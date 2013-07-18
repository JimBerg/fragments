<?php

/**
 * User filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BaseUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'fb_id'                 => new sfWidgetFormFilterInput(),
      'access_token'          => new sfWidgetFormFilterInput(),
      'is_fan'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'firstname'             => new sfWidgetFormFilterInput(),
      'lastname'              => new sfWidgetFormFilterInput(),
      'email'                 => new sfWidgetFormFilterInput(),
      'locale'                => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'inactive_notification' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'weekly_notification'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'Location_id'           => new sfWidgetFormPropelChoice(array('model' => 'Location', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'fb_id'                 => new sfValidatorPass(array('required' => false)),
      'access_token'          => new sfValidatorPass(array('required' => false)),
      'is_fan'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'firstname'             => new sfValidatorPass(array('required' => false)),
      'lastname'              => new sfValidatorPass(array('required' => false)),
      'email'                 => new sfValidatorPass(array('required' => false)),
      'locale'                => new sfValidatorPass(array('required' => false)),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'inactive_notification' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'weekly_notification'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'Location_id'           => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Location', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'fb_id'                 => 'Text',
      'access_token'          => 'Text',
      'is_fan'                => 'Boolean',
      'firstname'             => 'Text',
      'lastname'              => 'Text',
      'email'                 => 'Text',
      'locale'                => 'Text',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'inactive_notification' => 'Boolean',
      'weekly_notification'   => 'Boolean',
      'Location_id'           => 'ForeignKey',
    );
  }
}
