<?php

/**
 * Pictures filter form base class.
 *
 * @package    ftyf
 * @subpackage filter
 * @author     Your name here
 */
abstract class BasePicturesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'Destination_id' => new sfWidgetFormPropelChoice(array('model' => 'Destination', 'add_empty' => true)),
      'title'          => new sfWidgetFormFilterInput(),
      'path'           => new sfWidgetFormFilterInput(),
      'link'           => new sfWidgetFormFilterInput(),
      'author'         => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'Destination_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Destination', 'column' => 'id')),
      'title'          => new sfValidatorPass(array('required' => false)),
      'path'           => new sfValidatorPass(array('required' => false)),
      'link'           => new sfValidatorPass(array('required' => false)),
      'author'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('pictures_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Pictures';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'Destination_id' => 'ForeignKey',
      'title'          => 'Text',
      'path'           => 'Text',
      'link'           => 'Text',
      'author'         => 'Text',
    );
  }
}
