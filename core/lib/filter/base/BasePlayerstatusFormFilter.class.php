<?php

/**
 * Playerstatus filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePlayerstatusFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'on_flight'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'points'            => new sfWidgetFormFilterInput(),
      'bonus'             => new sfWidgetFormFilterInput(),
      'flight_points'     => new sfWidgetFormFilterInput(),
      'available_miles'   => new sfWidgetFormFilterInput(),
      'flightmiles_total' => new sfWidgetFormFilterInput(),
      'flightmiles_week'  => new sfWidgetFormFilterInput(),
      'flight_count'      => new sfWidgetFormFilterInput(),
      'homebase_flight'   => new sfWidgetFormFilterInput(),
      'player_rank'       => new sfWidgetFormFilterInput(),
      'week1'             => new sfWidgetFormFilterInput(),
      'week2'             => new sfWidgetFormFilterInput(),
      'week3'             => new sfWidgetFormFilterInput(),
      'week4'             => new sfWidgetFormFilterInput(),
      'week5'             => new sfWidgetFormFilterInput(),
      'week6'             => new sfWidgetFormFilterInput(),
      'week7'             => new sfWidgetFormFilterInput(),
      'week8'             => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'on_flight'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'points'            => new sfValidatorPass(array('required' => false)),
      'bonus'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flight_points'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'available_miles'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flightmiles_total' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flightmiles_week'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'flight_count'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'homebase_flight'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'player_rank'       => new sfValidatorPass(array('required' => false)),
      'week1'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'week2'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'week3'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'week4'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'week5'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'week6'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'week7'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'week8'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('playerstatus_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Playerstatus';
  }

  public function getFields()
  {
    return array(
      'User_id'           => 'ForeignKey',
      'on_flight'         => 'Boolean',
      'points'            => 'Text',
      'bonus'             => 'Number',
      'flight_points'     => 'Number',
      'available_miles'   => 'Number',
      'flightmiles_total' => 'Number',
      'flightmiles_week'  => 'Number',
      'flight_count'      => 'Number',
      'homebase_flight'   => 'Number',
      'player_rank'       => 'Text',
      'week1'             => 'Number',
      'week2'             => 'Number',
      'week3'             => 'Number',
      'week4'             => 'Number',
      'week5'             => 'Number',
      'week6'             => 'Number',
      'week7'             => 'Number',
      'week8'             => 'Number',
    );
  }
}
