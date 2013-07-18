<?php

/**
 * Playerstatus form base class.
 *
 * @method Playerstatus getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePlayerstatusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'User_id'           => new sfWidgetFormInputHidden(),
      'on_flight'         => new sfWidgetFormInputCheckbox(),
      'points'            => new sfWidgetFormInputText(),
      'bonus'             => new sfWidgetFormInputText(),
      'flight_points'     => new sfWidgetFormInputText(),
      'available_miles'   => new sfWidgetFormInputText(),
      'flightmiles_total' => new sfWidgetFormInputText(),
      'flightmiles_week'  => new sfWidgetFormInputText(),
      'flight_count'      => new sfWidgetFormInputText(),
      'homebase_flight'   => new sfWidgetFormInputText(),
      'player_rank'       => new sfWidgetFormInputText(),
      'week1'             => new sfWidgetFormInputText(),
      'week2'             => new sfWidgetFormInputText(),
      'week3'             => new sfWidgetFormInputText(),
      'week4'             => new sfWidgetFormInputText(),
      'week5'             => new sfWidgetFormInputText(),
      'week6'             => new sfWidgetFormInputText(),
      'week7'             => new sfWidgetFormInputText(),
      'week8'             => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'User_id'           => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'on_flight'         => new sfValidatorBoolean(array('required' => false)),
      'points'            => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'bonus'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'flight_points'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'available_miles'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'flightmiles_total' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'flightmiles_week'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'flight_count'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'homebase_flight'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'player_rank'       => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'week1'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'week2'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'week3'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'week4'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'week5'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'week6'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'week7'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'week8'             => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('playerstatus[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Playerstatus';
  }


}
