<?php

/**
 * Routes filter form base class.
 *
 * @package    mealplaner
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseRoutesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'routename'         => new sfWidgetFormFilterInput(),
      'length'            => new sfWidgetFormFilterInput(),
      'flightduration'    => new sfWidgetFormFilterInput(),
      'Location_id_start' => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => true)),
      'Location_id_end'   => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'routename'         => new sfValidatorPass(array('required' => false)),
      'length'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'flightduration'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'Location_id_start' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Location', 'column' => 'id')),
      'Location_id_end'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Location', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('routes_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Routes';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'routename'         => 'Text',
      'length'            => 'Number',
      'flightduration'    => 'Number',
      'Location_id_start' => 'ForeignKey',
      'Location_id_end'   => 'ForeignKey',
    );
  }
}
