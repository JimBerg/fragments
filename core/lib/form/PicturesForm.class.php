<?php

/**
 * Pictures form.
 *
 * @package    ftyf
 * @subpackage form
 * @author     Your name here
 */
class PicturesForm extends BasePicturesForm
{
  public function configure()
  {
	  	$this->setWidgets(array(
	      'id'             => new sfWidgetFormInputHidden(),
	      'Destination_id' => new sfWidgetFormPropelChoice(array('model' => 'Destination', 'add_empty' => false)),
	      'title'          => new sfWidgetFormInputText(),
      	  'link'           => new sfWidgetFormInputText(),
          'author'         => new sfWidgetFormInputText(),
	      'path'           => new sfWidgetFormInputFileEditable(array(
                'label' => 'Destination Pic',
                'file_src' => '/uploads/locationPics/'.$this->getObject()->getPath(),
                'is_image' => true,
                'edit_mode' => !$this->isNew(),
                'template' => '%file% %input% %delete% %delete_label%')),
	    ));
	
	    $this->setValidators(array(
	      'id'             => new sfValidatorPropelChoice(array('model' => 'Pictures', 'column' => 'id', 'required' => false)),
	      'Destination_id' => new sfValidatorPropelChoice(array('model' => 'Destination', 'column' => 'id')),
	      'title'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
	      'link'           => new sfValidatorString(array('max_length' => 128, 'required' => false)),
	      'author'         => new sfValidatorString(array('max_length' => 64, 'required' => false)),
	      'path'           => new sfValidatorFile(array(
                  'required'        => false,
                  'path'            => sfConfig::get('sf_upload_dir').'/locationPics/',
                  'mime_categories' => 'web_images')),
	    ));
	
	    $this->widgetSchema->setNameFormat('pictures[%s]');
  }
}
