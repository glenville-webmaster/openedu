<?php

namespace Drupal\openedu_subtheme\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Subtheme Entity entity.
 *
 * @ingroup openedu_subtheme
 *
 * @ContentEntityType(
 *   id = "subtheme_entity",
 *   label = @Translation("Subtheme Entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\openedu_subtheme\SubthemeEntityListBuilder",
 *     "views_data" = "Drupal\openedu_subtheme\Entity\SubthemeEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\openedu_subtheme\Form\SubthemeEntityForm",
 *       "add" = "Drupal\openedu_subtheme\Form\SubthemeEntityForm",
 *       "edit" = "Drupal\openedu_subtheme\Form\SubthemeEntityForm",
 *       "delete" = "Drupal\openedu_subtheme\Form\SubthemeEntityDeleteForm",
 *     },
 *     "access" = "Drupal\openedu_subtheme\SubthemeEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\openedu_subtheme\SubthemeEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "subtheme_entity",
 *   admin_permission = "administer subtheme entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/appearance/subtheme-entity/subtheme_entity/{subtheme_entity}",
 *     "add-form" = "/admin/appearance/subtheme-entity/subtheme_entity/add",
 *     "edit-form" = "/admin/appearance/subtheme-entity/subtheme_entity/{subtheme_entity}/edit",
 *     "delete-form" = "/admin/appearance/subtheme-entity/subtheme_entity/{subtheme_entity}/delete",
 *     "collection" = "/admin/appearance/subtheme-entity/subtheme_entity",
 *   },
 * )
 */
class SubthemeEntity extends ContentEntityBase implements SubthemeEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getMachineName() {
    return $this->get('machine_name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getParentMachineName() {
    return $this->get('parent_machine_name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setParentMachineName($value) {
    $this->set('parent_machine_name', $value);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getSettings() {
    return $this->get('settings')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setSettings($value) {
    $this->set('settings', $value);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPages() {
    return $this->get('pages')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setPages($value) {
    $this->set('pages', $value);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPagesOption() {
    return $this->get('pages_option')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setPagesOption($value) {
    $this->set('pages_option', $value);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCustomCss() {
    return $this->get('custom_css')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCustomCss($value) {
    $this->set('custom_css', $value);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getLogo() {
    return $this->get('logo')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setLogo($value) {
    $this->set('logo', $value);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Subtheme Entity entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['machine_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Subtheme Entity machine name'))
      ->setDescription(t('The machine name of the Subtheme Entity entity.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setRequired(TRUE)
      ->addConstraint('UniqueField', [])
      ->setPropertyConstraints('value', [
        'Regex' => [
          'pattern' => '/^[a-z0-9_]+$/',
          'message' => 'Please use only lowercase letters, numbers or underscore in the machine name field.',
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $themes = system_list('theme');
    $themes_name = array_keys($themes);
    $theme = 'oedu_sub';
    $fields['parent_machine_name'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('The name of parent theme'))
      ->setDescription(t('Parent theme name for the Subtheme Entity.'))
      ->setSettings([
        'allowed_values' => array_combine($themes_name, $themes_name),
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDefaultValue($theme)
      ->setRequired(TRUE)
      ->setPropertyConstraints('value', [
        'Regex' => [
          'pattern' => '/^[a-z0-9_]+$/',
          'message' => 'Please use only lowercase letters, numbers or underscore in the machine name field.',
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['settings'] = BaseFieldDefinition::create('subtheme_settings_field_type')
      ->setLabel(t('Settings'))
      ->setDescription(t('JSON settings'))
      ->setDisplayOptions('form', [
        'type'   => 'subtheme_settings_field_type',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['logo'] = BaseFieldDefinition::create('subtheme_logo_field_type')
      ->setLabel(t('Logo Image'))
      ->setDescription(t('Logo Image for subtheme'))
      ->setDisplayOptions('form', [
        'type'   => 'subtheme_logo_field_type',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['pages'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Pages'))
      ->setDescription(t('Pages to apply subtheme'))
      ->setDisplayOptions('form', [
        'type'   => 'string_textarea',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['pages_option'] = BaseFieldDefinition::create('list_string')
      ->setSettings([
        'allowed_values' => [
          'include' => 'Include pages',
          'exclude' => 'Exclude pages',
        ],
      ])
      ->setDefaultValue(['value' => 'include'])
      ->setLabel('Options')
      ->setDescription('Specify method of applying pages')
      ->setRequired(TRUE)
      ->setCardinality(1)
      ->setDisplayOptions('form', [
        'type' => 'options_buttons',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['custom_css'] = BaseFieldDefinition::create('subtheme_custom_css_field_type')
      ->setLabel(t('Custom CSS'))
      ->setDescription(t('Add custom CSS to be applied with subtheme'))
      ->setDisplayOptions('form', [
        'type'   => 'subtheme_custom_css_field_type',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Subtheme Entity is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

  /**
   * Check if path is in Entity pages.
   *
   * @param string $path
   *   Path of page, e.g. '/node/1' .
   *
   * @return bool
   *   If path is in entyti pages, it will return TRUE, else FALSE.
   */
  public function isInPages(string $path) {
    $pages = $this->getPages();
    $pages_arr = explode(PHP_EOL, $pages);
    foreach ($pages_arr as $page) {
      if (!empty($page)) {
        $page_path = \Drupal::service('path.alias_manager')->getPathByAlias($page);
        if ($path == $page_path) {
          return TRUE;
        }
      }
    }
    return FALSE;
  }

}
