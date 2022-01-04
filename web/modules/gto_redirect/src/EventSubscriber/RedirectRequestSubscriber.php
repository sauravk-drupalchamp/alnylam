<?php

namespace Drupal\gto_redirect\EventSubscriber;

use Drupal\gto_redirect\RedirectRepository;
use Drupal\Core\Url;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RequestContext;

/**
 * Redirect subscriber for controller requests.
 */
class RedirectRequestSubscriber implements EventSubscriberInterface
{
	/** @var  \Drupal\redirect\RedirectRepository */
	protected $redirectRepository;

	/**
	 * Constructs a \Drupal\gto_redirect\EventSubscriber\RedirectRequestSubscriber object.
	 * 
	 * @param \Drupal\gto_redirect\RedirectRepository $repository
	 *   The redirect entity repository.
	 *
	 */
	public function __construct(RedirectRepository $repository)
	{
		$this->redirectRepository = $repository;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		// This needs to run before RouterListener::onKernelRequest(), which has
		// a priority of 32. Otherwise, that aborts the request if no matching
		// route is found.
		$events[KernelEvents::REQUEST][] = ['requestRedirect', 33];
		$events[KernelEvents::EXCEPTION][] = ['exceptionRedirect', 1];
		return $events;
	}

	/**
	 * Perform redirect for access denied exceptions. Without this callback,
	 * if a user has a custom page to display on 403 (access denied) on
	 * admin/config/system/site-information, another redirection will take
	 * place before the redirection for the KernelEvents::REQUEST event.
	 * It results in infinite redirection and an error.
	 *
	 * @param GetResponseForExceptionEvent $event
	 */
	public function exceptionRedirect(GetResponseForExceptionEvent $event)
	{
		\Drupal::logger('gto_redirect - OKAY GOOD')->notice('<pre><code>' . print_r("REACHED", true) . '</code></pre>');
		$exception = $event->getException();
		if ($exception instanceof HttpExceptionInterface && $event->getException()->getStatusCode() === 403) {
			$this->handleRedirect($event);
		}
	}

	/**
	 * Perform redirect for http request.
	 *
	 * @param GetResponseEvent $event
	 */
	public function requestRedirect(GetResponseEvent $event)
	{
		$this->handleRedirect($event);
	}

	public function handleRedirect($event)
	{
		// Get a clone of the request. During inbound processing the request
		// can be altered. Allowing this here can lead to unexpected behavior.
		// For example the path_processor.files inbound processor provided by
		// the system module alters both the path and the request; only the
		// changes to the request will be propagated, while the change to the
		// path will be lost.
		$request = clone $event->getRequest();
		global $base_url;

		// Parse URI query string into an array
		parse_str($request->getQueryString(), $requestQuery);

		// Check if there is a redirect match
		$path = $request->getPathInfo();
		$path = trim($path, '/');

		// Find redirect match
		$r = $this->redirectRepository->findRedirect($path);

		// Redirect user if match is found
		if ($r) {
			if (strpos($r['redirect_destination__uri'], "internal:/") !== false) {
				// Is an internal redirect
				$url = Url::fromUri($r['redirect_destination__uri']);
				$r['redirect_destination__uri'] = $url->toString();
			}

			$response = new TrustedRedirectResponse($r['redirect_destination__uri'], 301);
			$event->setResponse($response);
		}
	}

	/**
	 * Check for external URL.
	 *
	 * @param type $path
	 * @return type
	 */
	public function urlRedirectIsExternal($path)
	{
		// check for http:// or https://
		if (preg_match("`https?://`", $path)) {
			return true;
		} else {
			return false;
		}
	}
}
