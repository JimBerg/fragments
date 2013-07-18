<?php

/**
 * Destination filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseDestinationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'location_id'        => new sfWidgetFormFilterInput(),
      'location_name'      => new sfWidgetFormFilterInput(),
      'region'             => new sfWidgetFormFilterInput(),
      'geolocation'        => new sfWidgetFormFilterInput(),
      'area'               => new sfWidgetFormFilterInput(),
      'elevation'          => new sfWidgetFormFilterInput(),
      'population'         => new sfWidgetFormFilterInput(),
      'infotext'           => new sfWidgetFormFilterInput(),
      'population_density' => new sfWidgetFormFilterInput(),
      'airport_name'       => new sfWidgetFormFilterInput(),
      'airport_abbr'       => new sfWidgetFormFilterInput(),
      'airport_type'       => new sfWidgetFormFilterInput(),
      'timezone'           => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'location_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'location_name'      => new sfValidatorPass(array('required' => false)),
      'region'             => new sfValidatorPass(array('required' => false)),
      'geolocation'        => new sfValidatorPass(array('required' => false)),
      'area'               => new sfValidatorPass(array('required' => false)),
      'elevation'          => new sfValidatorPass(array('required' => false)),
      'population'         => new sfValidatorPass(array('required' => false)),
      'infotext'           => new sfValidatorPass(array('required' => false)),
      'population_density' => new sfValidatorPass(array('required' => false)),
      'airport_name'       => new sfValidatorPass(array('required' => false)),
      'airport_abbr'       => new sfValidatorPass(array('required' => false)),
      'airport_type'       => new sfValidatorPass(array('required' => false)),
      'timezone'           => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('destination_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Destination';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'location_id'        => 'Number',
      'location_name'      => 'Text',
      'region'             => 'Text',
      'geolocation'        => 'Text',
      'area'               => 'Text',
      'elevation'          => 'Text',
      'population'         => 'Text',
      'infotext'           => 'Text',
      'population_density' => 'Text',
      'airport_name'       => 'Text',
      'airport_abbr'       => 'Text',
      'airport_type'       => 'Text',
      'timezone'           => 'Text',
    );
  }
}
