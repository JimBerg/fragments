<?php

/**
 * Friendlist form base class.
 *
 * @method Friendlist getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFriendlistForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'User_id' => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'Friendlist', 'column' => 'id', 'required' => false)),
      'User_id' => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('friendlist[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friendlist';
  }


}
