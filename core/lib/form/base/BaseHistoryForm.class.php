<?php

/**
 * History form base class.
 *
 * @method History getObject() Returns the current form's model object
 *
 * @package    mealplaner
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHistoryForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Playerstatus_User_id' => new sfWidgetFormInputHidden(),
      'date'                 => new sfWidgetFormDateTime(),
      'Location_id'          => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => false)),
      'Friend_id'            => new sfWidgetFormPropelChoice(array('model' => 'Friend', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'Playerstatus_User_id' => new sfValidatorPropelChoice(array('model' => 'Playerstatus', 'column' => 'User_id', 'required' => false)),
      'date'                 => new sfValidatorDateTime(array('required' => false)),
      'Location_id'          => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id')),
      'Friend_id'            => new sfValidatorPropelChoice(array('model' => 'Friend', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('history[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'History';
  }


}
