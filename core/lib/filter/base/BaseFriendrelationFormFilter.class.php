<?php

/**
 * Friendrelation filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseFriendrelationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Friend_id'     => new sfWidgetFormPropelChoice(array('model' => 'Friend', 'add_empty' => true)),
      'Friendlist_id' => new sfWidgetFormPropelChoice(array('model' => 'Friendlist', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'Friend_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Friend', 'column' => 'id')),
      'Friendlist_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Friendlist', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('friendrelation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friendrelation';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'Friend_id'     => 'ForeignKey',
      'Friendlist_id' => 'ForeignKey',
    );
  }
}
