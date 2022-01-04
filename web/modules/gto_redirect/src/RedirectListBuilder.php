<?php

namespace Drupal\gto_redirect;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Redirect entity entities.
 *
 * @ingroup gto_redirect
 */
class RedirectListBuilder extends EntityListBuilder
{
	/**
	 * {@inheritdoc}
	 */
	public function buildHeader()
	{
		$header['rid'] = $this->t('Redirect ID');
		$header['redirect_source'] = $this->t('Origin');
		$header['redirect_destination'] = $this->t('Destination');
		$header['created'] = $this->t('Created');
		return $header + parent::buildHeader();
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildRow(EntityInterface $entity)
	{
		/* @var \Drupal\gto_redirect\Entity\Redirect $entity */
		$row['rid'] = $entity->getId();
		$row['redirect_source'] = $entity->getSource();
		$row['redirect_destination'] = $entity->getRedirect();
		$row['created'] = $entity->getCreated();
		return $row + parent::buildRow($entity);
	}
}
