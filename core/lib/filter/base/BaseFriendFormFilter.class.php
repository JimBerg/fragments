<?php

/**
 * Friend filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseFriendFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fb_id'       => new sfWidgetFormFilterInput(),
      'name'        => new sfWidgetFormFilterInput(),
      'is_invited'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'Location_id' => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fb_id'       => new sfValidatorPass(array('required' => false)),
      'name'        => new sfValidatorPass(array('required' => false)),
      'is_invited'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'Location_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Location', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('friend_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Friend';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'fb_id'       => 'Text',
      'name'        => 'Text',
      'is_invited'  => 'Boolean',
      'Location_id' => 'ForeignKey',
    );
  }
}
