<?php

/**
 * Pictures form base class.
 *
 * @method Pictures getObject() Returns the current form's model object
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePicturesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'Destination_id' => new sfWidgetFormPropelChoice(array('model' => 'Destination', 'add_empty' => false)),
      'title'          => new sfWidgetFormInputText(),
      'path'           => new sfWidgetFormInputText(),
      'link'           => new sfWidgetFormInputText(),
      'author'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'Pictures', 'column' => 'id', 'required' => false)),
      'Destination_id' => new sfValidatorPropelChoice(array('model' => 'Destination', 'column' => 'id')),
      'title'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'path'           => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'link'           => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'author'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pictures[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pictures';
  }


}
