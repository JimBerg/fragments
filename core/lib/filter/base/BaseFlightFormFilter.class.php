<?php

/**
 * Flight filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseFlightFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'User_id'              => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'Friend_id'            => new sfWidgetFormPropelChoice(array('model' => 'Friend', 'add_empty' => true)),
      'start_location_id'    => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => true)),
      'target_location_id'   => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => true)),
      'flight_type'          => new sfWidgetFormFilterInput(),
      'flight_start'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'flight_end'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'flight_duration'      => new sfWidgetFormFilterInput(),
      'flight_accepted'      => new sfWidgetFormFilterInput(),
      'landing_notification' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'User_id'              => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'Friend_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Friend', 'column' => 'id')),
      'start_location_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Location', 'column' => 'id')),
      'target_location_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Location', 'column' => 'id')),
      'flight_type'          => new sfValidatorPass(array('required' => false)),
      'flight_start'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'flight_end'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'flight_duration'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flight_accepted'      => new sfValidatorPass(array('required' => false)),
      'landing_notification' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('flight_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Flight';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'User_id'              => 'ForeignKey',
      'Friend_id'            => 'ForeignKey',
      'start_location_id'    => 'ForeignKey',
      'target_location_id'   => 'ForeignKey',
      'flight_type'          => 'Text',
      'flight_start'         => 'Date',
      'flight_end'           => 'Date',
      'flight_duration'      => 'Number',
      'flight_accepted'      => 'Text',
      'landing_notification' => 'Boolean',
    );
  }
}
