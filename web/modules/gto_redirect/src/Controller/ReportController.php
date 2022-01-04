<?php

/**
 * @file
 * Contains \Drupal\gto_redirect\Controller\ReportController.
 */

namespace Drupal\gto_redirect\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Controller for GTO Redirects Report
 */
class ReportController extends ControllerBase
{
	/**
	 * Gets all Redirects for all nodes.
	 *
	 * @return array
	 */
	protected function load()
	{
		$select = Database::getConnection()->select('gto_redirect', 'r');
		$select->addField('r', 'origin');
		$select->addField('r', 'destination');
		$select->addField('r', 'created_at');

		$entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
		return $entries;
	}

	/**
	 * Creates the report page.
	 *
	 * @return array
	 *  Render array for report output.
	 */
	public function report()
	{
		$content = array();
		$content['message'] = array(
			'#markup' => $this->t('Below is a list of all redirects'),
		);

		$headers = array(
			t('Origin'),
			t('Destination'),
			t('Date Created'),
			t('Actions')
		);

		$rows = array();
		foreach ($entries = $this->load() as $id => $entry) {
			$buildActionDropdown = array(
				'#type' => 'dropbutton',
				'#links' => array(
					'edit_action' => array(
						'title' => $this->t('Edit'),
						'url' => Url::fromRoute('gto_redirect.add'),
					),
					'delete_action' => array(
						'title' => $this->t('Delete'),
						'url' => Url::fromRoute('gto_redirect.report'),
					),
				),
			);

			// Format timestamp to date time
			$entry['created_at'] = date("m/d/Y", $entry['created_at']);
			$entry['actions'] = array(
				'data' => \Drupal::service('renderer')->render($buildActionDropdown)
			);

			// Sanitize each entry.
			$rows[] = $entry;
		}

		$content['table'] = array(
			'#type' => 'table',
			'#header' => $headers,
			'#rows' => $rows,
			'#empty' => t('No entries available.'),
		);
		// Don't cache this page.
		$content['#cache']['max-age'] = 0;
		return $content;
	}
}
