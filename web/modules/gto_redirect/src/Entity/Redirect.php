<?php

namespace Drupal\gto_redirect\Entity;

use Drupal\Core\Url;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\link\LinkItemInterface;

/**
 * Defines the GTO Redirect Entity.
 *
 * @ContentEntityType(
 * 	 id = "redirect",
 * 	 label = @Translation("GTO Redirect"),
 *   bundle_label = @Translation("Redirect type"),
 * 	 handlers = {
 *     "list_builder" = "Drupal\gto_redirect\RedirectListBuilder",
 *     "form" = {
 *       "default" = "Drupal\gto_redirect\Form\RedirectForm",
 *       "delete" = "Drupal\gto_redirect\Form\RedirectDeleteForm",
 * 			 "edit" = "Drupal\gto_redirect\Form\RedirectForm"
 *     },
 *     "views_data" = "Drupal\gto_redirect\RedirectViewsData"
 *   },
 *   base_table = "redirect",
 *   translatable = FALSE,
 *   admin_permission = "administer redirects",
 *   entity_keys = {
 *     "id" = "rid",
 *     "uuid" = "uuid"
 *   },
 * 	 links = {
 *     "canonical" = "/admin/config/search/redirect/edit/{redirect}",
 *     "delete-form" = "/admin/config/search/redirect/delete/{redirect}",
 *     "edit-form" = "/admin/config/search/redirect/edit/{redirect}",
 *   }
 * )
 */
class Redirect extends ContentEntityBase
{
	/**
	 * {@inheritdoc}
	 */
	public static function preCreate(EntityStorageInterface $storage_controller, array &$values)
	{
		$values += [
			'type' => 'redirect',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function preSave(EntityStorageInterface $storage_controller)
	{
	}

	public function getId()
	{
		return $this->get('rid')->value;
	}

	/**
	 * Sets the source URL data.
	 *
	 * @param string $path
	 *   The base url of the source.
	 * @param array $query
	 *   Query arguments.
	 */
	public function setSource($path, array $query = [])
	{
		$this->set('redirect_source', $path);
	}

	/**
	 * Gets the source URL data.
	 *
	 * @return array
	 */
	public function getSource()
	{
		return $this->get('redirect_source')->value;
	}

	public function getSourceUrl()
	{
		$url = Url::fromUri("internal:" . $this->get('redirect_source')->value, array('absolute' => TRUE));
		return $url;
	}

	/**
	 * Gets the redirect URL data.
	 *
	 * @return array
	 *   The redirect URL data.
	 */
	public function getRedirect()
	{
		return $this->get('redirect_destination')->get(0)->getUrl();
	}

	public function getRedirectUrl()
	{
		return $this->get('redirect_destination')->get(0)->getUrl();
	}

	public function setRedirect($path)
	{
		$this->set('redirect_destination', $path);
	}

	/**
	 * Sets the redirect created datetime.
	 *
	 * @param int $datetime
	 *   The redirect created datetime.
	 */
	public function setCreated($datetime)
	{
		$this->set('created', $datetime);
	}

	/**
	 * Gets the redirect created datetime.
	 *
	 * @return int
	 *   The redirect created datetime.
	 */
	public function getCreated()
	{
		return $this->get('created')->value;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
	{
		$fields = parent::baseFieldDefinitions($entity_type);

		$fields['rid'] = BaseFieldDefinition::create('integer')
			->setLabel(t('Redirect ID'))
			->setDescription(t('The redirect ID.'))
			->setReadOnly(TRUE);

		$fields['uuid'] = BaseFieldDefinition::create('uuid')
			->setLabel(t('UUID'))
			->setDescription(t('The record UUID.'))
			->setReadOnly(TRUE);

		$fields['uid'] = BaseFieldDefinition::create('entity_reference')
			->setLabel(t('User ID'))
			->setDescription(t('The user ID of the node author.'))
			->setDefaultValueCallback('\Drupal\gto_redirect\Entity\Redirect::getCurrentUserId')
			->setSettings([
				'target_type' => 'user',
			]);

		$fields['redirect_source'] = BaseFieldDefinition::create('string')
			->setLabel(t('Origin'))
			->setDescription(t("Enter an internal Drupal path (e.g. %example1 or %example2).", ['%example1' => 'node/123', '%example2' => 'taxonomy/term/123']))
			->setRequired(TRUE)
			->setTranslatable(FALSE)
			->setDisplayOptions('form', [
				'type' => 'string_textfield',
				'weight' => -5,
			])
			->setDisplayConfigurable('form', TRUE);

		$fields['redirect_destination'] = BaseFieldDefinition::create('link')
			->setLabel(t('Destination'))
			->setRequired(TRUE)
			->setTranslatable(FALSE)
			->setSettings([
				'link_type' => LinkItemInterface::LINK_GENERIC,
				'title' => DRUPAL_DISABLED
			])
			->setDisplayOptions('form', [
				'type' => 'link',
				'weight' => -4,
			])
			->setDisplayConfigurable('form', TRUE);

		$fields['created'] = BaseFieldDefinition::create('created')
			->setLabel(t('Created'))
			->setDescription(t('The date when the redirect was created.'));

		return $fields;
	}

	/**
	 * Default value callback for 'uid' base field definition.
	 *
	 * @see ::baseFieldDefinitions()
	 *
	 * @return array
	 *   An array of default values.
	 */
	public static function getCurrentUserId()
	{
		return [\Drupal::currentUser()->id()];
	}
}
