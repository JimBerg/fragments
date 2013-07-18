<?php

/**
 * History filter form base class.
 *
 * @package    mealplaner
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseHistoryFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'date'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'Location_id'          => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => true)),
      'Friend_id'            => new sfWidgetFormPropelChoice(array('model' => 'Friend', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'date'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'Location_id'          => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Location', 'column' => 'id')),
      'Friend_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Friend', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('history_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'History';
  }

  public function getFields()
  {
    return array(
      'Playerstatus_User_id' => 'ForeignKey',
      'date'                 => 'Date',
      'Location_id'          => 'ForeignKey',
      'Friend_id'            => 'ForeignKey',
    );
  }
}
