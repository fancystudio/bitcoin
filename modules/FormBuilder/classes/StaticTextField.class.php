<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbStaticTextField extends fbFieldBase {

	function __construct(&$form_ptr, &$params)
	{
        parent::__construct($form_ptr, $params);
        $mod = $form_ptr->module_ptr;
		$this->Type = 'StaticTextField';
		$this->DisplayInForm = true;
		$this->DisplayInSubmission = false;
		$this->NonRequirableField = true;
		$this->HasLabel = 0;
		$this->ValidationTypes = array();
	}

	function GetFieldInput($id, &$params, $returnid)
	{
      if ($this->GetOption('smarty_eval','0') == '1')
         {
         $this->SetSmartyEval(true);
         }
		return $this->GetOption('text','');
	}

	function StatusInfo()
	{
		 return $this->form_ptr->module_ptr->Lang('text_length',strlen($this->GetOption('text','')));
	}

	function GetHumanReadableValue($as_string=true)
	{
		$ret = '[static text field]';
		if ($as_string)
			{
			return $ret;
			}
		else
			{
			return array($ret);
			}		
	}
	
	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$main = array(
				array($mod->Lang('title_text'),
				$mod->CreateTextArea((get_preference(get_userid(), 'use_wysiwyg')=='1'), $formDescriptor,  $this->GetOption('text',''), 'fbrp_opt_text','pageheadtags'))
		);
		$adv = array(
				array($mod->Lang('title_smarty_eval'),
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_smarty_eval',
            		'1',$this->GetOption('smarty_eval','0')))
		);
		return array('main'=>$main,'adv'=>$adv);
	}
}

?>
