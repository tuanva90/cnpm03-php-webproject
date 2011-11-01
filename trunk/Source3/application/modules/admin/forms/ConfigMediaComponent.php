<?php

class Admin_Form_ConfigMediaComponent extends Zend_Form
{

    public function init()
    {
        /* Initialize action controller here */
       	$this->setAction('MediaComponent');
		$this->setMethod('post');
		$this->setDescription('Media Component');
		$this->setAttrib('sitename','CMS');
		
		//Add elements
		
		//Create txtLegalExtions
		$txtLegalExtensions=new Zend_Form_Element_Textarea('txtLegalExtensions');
		$txtLegalExtensions->setLabel("Legal Extensions (File type):");
		$txtLegalExtensions->setAttribs(array('cols'=>55,'rows'=>5));
		$this->addElement($txtLegalExtensions);
		
		//Create txtMaximumSize
		$txtMaximumSize=new Zend_Form_Element_Text('txtMaximumSize');
		$txtMaximumSize->setLabel('Maximum Size (MB):');
		$this->addElement($txtMaximumSize);
		
		//Create txtImageFolderPath
		$txtImageFolderPath=new Zend_Form_Element_Text('txtImageFolderPath');
		$txtImageFolderPath->setLabel('Path to image folder:');
		$this->addElement($txtImageFolderPath);
		
		//Create txtFileFolderPath
		$txtFileFolderPath=new Zend_Form_Element_Text('txtFileFolderPath');
		$txtFileFolderPath->setLabel('Path to files folder:');
		$this->addElement($txtFileFolderPath);
		
		//Create radRecstrictUpload
		$restrictUploadOptions=array("multiOptions"=>array
								("1"=>"Yes",
								 "0"=>"No"									
								))	;	
		$radRecstrictUpload=new Zend_Form_Element_Radio('radRecstrictUplooad',$restrictUploadOptions);
		$radRecstrictUpload->setLabel('Recstrict Upload:');
		$radRecstrictUpload->setRequired(true);
		$this->addElement($radRecstrictUpload);
		
		//Create radCheckMIMETypes
		$checkMIMETypesOptions=array("multiOptions"=>array
								("1"=>"Yes",
								 "0"=>"No"									
								))	;	
		$radCheckMIMETypes=new Zend_Form_Element_Radio('radCheckMIMETypes',$checkMIMETypesOptions);
		$radCheckMIMETypes->setLabel('Check MIME Types:');
		$radCheckMIMETypes->setRequired(true);
		$this->addElement($radCheckMIMETypes);
		
		//Create txtLegalImageEX
		$txtLegalImageEX=new Zend_Form_Element_Text('txtLegalImageEX');
		$txtLegalImageEX->setLabel('Legal Image Extensions (File Types):');
		$this->addElement($txtLegalImageEX);
		
		//Create txtIgnoredEX
		$txtIgnoredEX=new Zend_Form_Element_Text('txtIgnoredEX');
		$txtIgnoredEX->setLabel('Ignored Extensions');
		$this->addElement($txtIgnoredEX);
		
		//Create txtLegalMIME
		$txtLegalMIME=new Zend_Form_Element_Text('txtLegalMIME');
		$txtLegalMIME->setLabel('Legal MIME Types:');
		$this->addElement($txtLegalMIME);
		
		//Create txtllligalMIME
		$txtllligalMIME=new Zend_Form_Element_Text('txtllligalMIME');
		$txtllligalMIME->setLabel('llligal MIME Types:');
		$this->addElement($txtllligalMIME);
		
		//Create radFlashUploader
		$flashUploader=array("multiOptions"=>array
								("1"=>"Yes",
								 "0"=>"No"									
								))	;	
		$radFlashUploader=new Zend_Form_Element_Radio('radFlashUploader',$flashUploader);
		$radFlashUploader->setLabel('Enable Flash Uploader:');
		$radFlashUploader->setRequired(true);
		$this->addElement($radFlashUploader);
		
		//Create btnSave
		$btnSave=new Zend_Form_Element_Button('btnSave');
		$btnSave->setLabel('Save');
		$this->addElement($btnSave);
		
		//Create btnSaveClose
		$btnSaveClose=new Zend_Form_Element_Button('btnSaveClose');
		$btnSaveClose->setLabel('Save and Close');
		$this->addElement($btnSaveClose);
		
		//Create btnCancel
		$btnCancel=new Zend_Form_Element_Button('btnCancel');
		$btnCancel->setLabel('Cancel');
		$this->addElement($btnCancel);
		
   }
}
?>

