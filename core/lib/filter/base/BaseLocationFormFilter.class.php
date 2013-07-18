<?php

/**
 * Location filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseLocationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'location_name'       => new sfWidgetFormFilterInput(),
      'lat'                 => new sfWidgetFormFilterInput(),
      'lng'                 => new sfWidgetFormFilterInput(),
      'country'             => new sfWidgetFormFilterInput(),
      'timezone'            => new sfWidgetFormFilterInput(),
      'swiss_destination'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'foreign_destination' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'nearest_destination' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'location_name'       => new sfValidatorPass(array('required' => false)),
      'lat'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'lng'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'country'             => new sfValidatorPass(array('required' => false)),
      'timezone'            => new sfValidatorPass(array('required' => false)),
      'swiss_destination'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'foreign_destination' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'nearest_destination' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('location_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Location';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'location_name'       => 'Text',
      'lat'                 => 'Number',
      'lng'                 => 'Number',
      'country'             => 'Text',
      'timezone'            => 'Text',
      'swiss_destination'   => 'Boolean',
      'foreign_destination' => 'Boolean',
      'nearest_destination' => 'Text',
    );
  }
}
