<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'fb_id'                 => new sfWidgetFormInputText(),
      'access_token'          => new sfWidgetFormInputText(),
      'is_fan'                => new sfWidgetFormInputCheckbox(),
      'firstname'             => new sfWidgetFormInputText(),
      'lastname'              => new sfWidgetFormInputText(),
      'email'                 => new sfWidgetFormInputText(),
      'locale'                => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'inactive_notification' => new sfWidgetFormInputCheckbox(),
      'weekly_notification'   => new sfWidgetFormInputCheckbox(),
      'Location_id'           => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'fb_id'                 => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'access_token'          => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'is_fan'                => new sfValidatorBoolean(array('required' => false)),
      'firstname'             => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'lastname'              => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'email'                 => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'locale'                => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
      'updated_at'            => new sfValidatorDateTime(array('required' => false)),
      'inactive_notification' => new sfValidatorBoolean(array('required' => false)),
      'weekly_notification'   => new sfValidatorBoolean(array('required' => false)),
      'Location_id'           => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }


}
