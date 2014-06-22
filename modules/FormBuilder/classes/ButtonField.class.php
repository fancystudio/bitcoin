<?php
/* 
   FormBuilder. Copyright (c) 2005-2009 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2009 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbButtonField extends fbFieldBase 
{

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'ButtonField';
    $this->DisplayInForm = true;
    $this->DisplayInSubmission = false;
    $this->NonRequirableField = true;
    $this->ValidationTypes = array();
    $this->sortable = false;
  }


  function GetFieldInput($id, &$params, $returnid)
  {
    $mod = $this->form_ptr->module_ptr;
	$js = $this->GetOption('javascript','');
	$cssid = $this->GetCSSIdTag();

    $ret = '<input type="button" name="'.$id.'fbrp__'.$this->Id.'" value="' .
	   $this->GetOption('text','').'" '.$js.$cssid.'/>';
	
	return $ret;
  }

  function PrePopulateAdminForm($formDescriptor)
  {
    $mod = $this->form_ptr->module_ptr;
    $main = array(
		  array($mod->Lang('title_button_text'),
            		$mod->CreateInputText($formDescriptor,'fbrp_opt_text',
					      $this->GetOption('text',''), 40)));
    $adv = array();
    return array('main'=>$main,'adv'=>$adv);
  }

}

?>
