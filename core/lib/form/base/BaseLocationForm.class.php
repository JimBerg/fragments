<?php

/**
 * Location form base class.
 *
 * @method Location getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseLocationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'location_name'       => new sfWidgetFormInputText(),
      'lat'                 => new sfWidgetFormInputText(),
      'lng'                 => new sfWidgetFormInputText(),
      'country'             => new sfWidgetFormInputText(),
      'timezone'            => new sfWidgetFormInputText(),
      'swiss_destination'   => new sfWidgetFormInputCheckbox(),
      'foreign_destination' => new sfWidgetFormInputCheckbox(),
      'nearest_destination' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id', 'required' => false)),
      'location_name'       => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'lat'                 => new sfValidatorNumber(array('required' => false)),
      'lng'                 => new sfValidatorNumber(array('required' => false)),
      'country'             => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'timezone'            => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'swiss_destination'   => new sfValidatorBoolean(array('required' => false)),
      'foreign_destination' => new sfValidatorBoolean(array('required' => false)),
      'nearest_destination' => new sfValidatorString(array('max_length' => 128, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('location[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Location';
  }


}
