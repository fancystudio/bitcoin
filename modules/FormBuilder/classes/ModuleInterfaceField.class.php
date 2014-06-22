<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org

* This Field written by Jeremy Bass <jeremyBass@cableone.net>

*/

class fbModuleInterfaceField extends fbFieldBase 
{

	function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = &$form_ptr->module_ptr;
		$this->Type = 'ModuleInterfaceField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array();
		$this->HasLabel = 0;
		$this->NeedsDiv = 0; 
		$this->sortable = false;
		$this->DisplayInSubmission = true;	
	}


	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = &$this->form_ptr->module_ptr;
		$v = $this->GetOption('value','');

		cmsms()->GetSmarty()->assign('FBid',$id.'fbrp__'.$this->Id);
		// for selected... what to do here  
		// for things like checked="checked" on the back page
		cmsms()->GetSmarty()->assign('FBvalue',$this->Value);

		return $mod->ProcessTemplateFromData($v);
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = &$this->form_ptr->module_ptr;
		$main = array(
				array($mod->Lang('help_module_interface'),
            		$mod->Lang('help_module_interface_long')),
				array($mod->Lang('title_add_tag'),
            		$mod->CreateInputText($formDescriptor, 'fbrp_opt_value',$this->GetOption('value',''),100,1024))
		);
		$adv = array();
		return array('main'=>$main,'adv'=>$adv);
	}
	
	function GetHumanReadableValue($as_string=true)
	{
		$mod = $this->form_ptr->module_ptr;
		$form = $this->form_ptr;

		if ($this->HasValue()) {
			
			$fieldRet = array();
			if (!is_array($this->Value)) {
			
				$this->Value = array($this->Value);
			}
			
			if ($as_string) {
				return join($form->GetAttr('list_delimiter',','),$this->Value);
			} else {
				return array($this->Value);
			}
			
		} else {
			
			if ($as_string) {
				return $mod->Lang('unspecified');
			} else {
			
				return array($mod->Lang('unspecified'));
			}
		}

	}

}

?>
