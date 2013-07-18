<?php

/**
 * Routes form base class.
 *
 * @method Routes getObject() Returns the current form's model object
 *
 * @package    mealplaner
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseRoutesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'routename'         => new sfWidgetFormInputText(),
      'length'            => new sfWidgetFormInputText(),
      'flightduration'    => new sfWidgetFormInputText(),
      'Location_id_start' => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => false)),
      'Location_id_end'   => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorPropelChoice(array('model' => 'Routes', 'column' => 'id', 'required' => false)),
      'routename'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
      'length'            => new sfValidatorNumber(array('required' => false)),
      'flightduration'    => new sfValidatorNumber(array('required' => false)),
      'Location_id_start' => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id')),
      'Location_id_end'   => new sfValidatorPropelChoice(array('model' => 'Location', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('routes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Routes';
  }


}
