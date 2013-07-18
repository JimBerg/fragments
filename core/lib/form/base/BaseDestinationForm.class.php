<?php

/**
 * Destination form base class.
 *
 * @method Destination getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseDestinationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'location_id'        => new sfWidgetFormInputText(),
      'location_name'      => new sfWidgetFormInputText(),
      'region'             => new sfWidgetFormInputText(),
      'geolocation'        => new sfWidgetFormInputText(),
      'area'               => new sfWidgetFormInputText(),
      'elevation'          => new sfWidgetFormInputText(),
      'population'         => new sfWidgetFormInputText(),
      'infotext'           => new sfWidgetFormTextarea(),
      'population_density' => new sfWidgetFormInputText(),
      'airport_name'       => new sfWidgetFormInputText(),
      'airport_abbr'       => new sfWidgetFormInputText(),
      'airport_type'       => new sfWidgetFormInputText(),
      'timezone'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'Destination', 'column' => 'id', 'required' => false)),
      'location_id'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'location_name'      => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'region'             => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'geolocation'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'area'               => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'elevation'          => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'population'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'infotext'           => new sfValidatorString(array('required' => false)),
      'population_density' => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'airport_name'       => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'airport_abbr'       => new sfValidatorString(array('max_length' => 16, 'required' => false)),
      'airport_type'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'timezone'           => new sfValidatorString(array('max_length' => 64, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('destination[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Destination';
  }


}
