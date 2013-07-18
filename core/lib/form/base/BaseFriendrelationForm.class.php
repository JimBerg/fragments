<?php

/**
 * Friendrelation form base class.
 *
 * @method Friendrelation getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFriendrelationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'Friend_id'     => new sfWidgetFormPropelChoice(array('model' => 'Friend', 'add_empty' => false)),
      'Friendlist_id' => new sfWidgetFormPropelChoice(array('model' => 'Friendlist', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorPropelChoice(array('model' => 'Friendrelation', 'column' => 'id', 'required' => false)),
      'Friend_id'     => new sfValidatorPropelChoice(array('model' => 'Friend', 'column' => 'id')),
      'Friendlist_id' => new sfValidatorPropelChoice(array('model' => 'Friendlist', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('friendrelation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friendrelation';
  }


}
