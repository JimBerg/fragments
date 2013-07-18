<?php

/**
 * Friend form base class.
 *
 * @method Friend getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFriendForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'fb_id'       => new sfWidgetFormInputText(),
      'name'        => new sfWidgetFormInputText(),
      'is_invited'  => new sfWidgetFormInputCheckbox(),
      'Location_id' => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Friend', 'column' => 'id', 'required' => false)),
      'fb_id'       => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'is_invited'  => new sfValidatorBoolean(array('required' => false)),
      'Location_id' => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('friend[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friend';
  }


}
