<?php

namespace Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\TermInterface;
use Drupal\taxonomy\TermStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'continent_country_widget'.
 *
 * @FieldWidget(
 *   id = "continent_country_widget",
 *   label = @Translation("Countries grouped by continent"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class ContinentCountryWidget extends WidgetBase {

  /**
   * The taxonomy term storage service.
   *
   * @var TermStorageInterface
   */
  protected $termStorage;

  /**
   * Constructs a ContinentCountryWidget object.
   *
   * @param TermStorageInterface $term_storage
   *   The taxonomy term storage service.
   */
  public function __construct(TermStorageInterface $term_storage) {
    $this->termStorage = $term_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')->getStorage('taxonomy_term')
    );
  }

  /**
   * Builds the form element for selecting a country within a continent.
   *
   * This method generates a select dropdown field where the options are grouped
   * by continent and populated with countries (taxonomy terms). The continents
   * are loaded first, and then the child countries for each continent are
   * loaded and added to the options array. The select dropdown allows the user
   * to choose a country.
   *
   * @param TermInterface[] $items
   *   An array of taxonomy terms (FieldItemListInterface). This contains the
   *   current values of the field for the given delta.
   * @param int $delta
   *   The index of the item in the list of items being displayed. If this is a
   *   multi-value field, the delta refers to the specific value in the field.
   * @param array $element
   *   An array containing the current form element properties.
   * @param array &$form
   *   An associative array containing the complete form structure.
   * @param FormStateInterface $form_state
   *   The form state interface that holds the current state of the form.
   *
   * @return array
   *   An array where the key 'value' contains the modified form element.
   *
   * @see TermInterface
   * @see FormStateInterface
   * @see \Drupal::entityTypeManager()
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $options = [];
    $continents = $this->termStorage->loadTree('continent_countries', 0, 1, TRUE);
    foreach ($continents as $continent) {
      $countries = $this->termStorage->loadTree('continent_countries', $continent->id(), 1, TRUE);
      foreach ($countries as $country) {
        $options[$continent->getName()][$country->id()] = $country->getName();
      }
    }
    $element += [
      '#type' => 'select',
      '#title' => $this->fieldDefinition->getLabel(),
      '#options' => $options,
      '#default_value' => $items[$delta]->target_id ?? NULL,
      '#empty_option' => $this->t('- Select a country -'),
    ];

    return ['value' => $element];
  }

}
