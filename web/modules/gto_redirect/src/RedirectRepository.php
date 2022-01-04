<?php

namespace Drupal\gto_redirect;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\feeds\Feeds\Target\Boolean;

class RedirectRepository
{
	/**
	 * @var \Drupal\Core\Entity\EntityTypeManagerInterface
	 */
	protected $manager;

	/**
	 * @var \Drupal\Core\Database\Connection
	 */
	protected $connection;

	/**
	 * An array of found redirect IDs to avoid recursion.
	 *
	 * @var array
	 */
	protected $foundRedirects = [];

	public function __construct(EntityTypeManagerInterface $manager, Connection $connection)
	{
		$this->manager = $manager;
		$this->connection = $connection;
	}

	/**
	 * Checks if a given path has regex or wildcards
	 */
	public function pathHasWildcard()
	{
	}

	/**
	 * Wrapper function for Drupal\Core\Path\PathMatcher::matchPath
	 */
	public function matchPath($path, $patterns)
	{
		$path = "/" . trim($path, "/");
		$patterns = rtrim($patterns, "/");

		return \Drupal::service('path.matcher')->matchPath($path, $patterns);
	}

	/**
	 * Resolver which finds a redirect by
	 * exact match or pattern
	 * 
	 * @param string $path
	 */
	public function findRedirect($path)
	{
		// Get all redirects in the DB
		$select = $this->connection->select('redirect', 'r');
		$select->addField('r', 'redirect_source');
		$select->addField('r', 'redirect_destination__uri');

		$redirects = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);

		// Check all redirects for a potential path match
		$redirectMatch = null;
		foreach ($redirects as $r) {
			/* @var Drupal\Core\Path\PathMatcher */
			$pathMatches = $this->matchPath($path, $r['redirect_source']);
			if ($pathMatches) {
				// Check if ends with (*)
				if (str_ends_with($r['redirect_destination__uri'], "*")) {
					$r['redirect_destination__uri'] = substr($r['redirect_destination__uri'], 0, -1) . end(explode("/", $path));
				}

				$redirectMatch  = $r;
				break;
			}
		}

		return $redirectMatch;
	}

	/**
	 * Finds redirects based on the source path.
	 *
	 * @param string $source_path
	 *   The redirect source path (without the query).
	 *
	 * @return \Drupal\gto_redirect\Entity\Redirect[]
	 *   Array of redirect entities.
	 */
	public function findBySourcePath($source_path)
	{
		// $ids = $this->manager->getStorage('redirect')->getQuery()
		// 	->condition('redirect_source.path', $source_path, 'LIKE')
		// 	->execute();
		// return $this->manager->getStorage('redirect')->loadMultiple($ids);
	}
}
