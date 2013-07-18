<?php

/**
 * Friendlist filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseFriendlistFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'User_id' => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'User_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('friendlist_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friendlist';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'User_id' => 'ForeignKey',
    );
  }
}
