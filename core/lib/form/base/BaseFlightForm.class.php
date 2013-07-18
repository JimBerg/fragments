<?php

/**
 * Flight form base class.
 *
 * @method Flight getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFlightForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'User_id'              => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'Friend_id'            => new sfWidgetFormPropelChoice(array('model' => 'Friend', 'add_empty' => true)),
      'start_location_id'    => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => false)),
      'target_location_id'   => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => false)),
      'flight_type'          => new sfWidgetFormInputText(),
      'flight_start'         => new sfWidgetFormDateTime(),
      'flight_end'           => new sfWidgetFormDateTime(),
      'flight_duration'      => new sfWidgetFormInputText(),
      'flight_accepted'      => new sfWidgetFormInputText(),
      'landing_notification' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorPropelChoice(array('model' => 'Flight', 'column' => 'id', 'required' => false)),
      'User_id'              => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'Friend_id'            => new sfValidatorPropelChoice(array('model' => 'Friend', 'column' => 'id', 'required' => false)),
      'start_location_id'    => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id')),
      'target_location_id'   => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id')),
      'flight_type'          => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'flight_start'         => new sfValidatorDateTime(array('required' => false)),
      'flight_end'           => new sfValidatorDateTime(array('required' => false)),
      'flight_duration'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'flight_accepted'      => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'landing_notification' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('flight[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Flight';
  }


}
