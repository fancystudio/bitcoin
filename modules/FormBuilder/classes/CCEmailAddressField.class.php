<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbCCEmailAddressField extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'CCEmailAddressField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array(
			$mod->Lang('validation_email_address')=>'email',
		);
		$this->ValidationType = 'email';
		$this->modifiesOtherFields = true;
	}

	public function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');

		return $mod->CreateInputEmail($id, 'fbrp__'.$this->Id,htmlspecialchars($this->Value, ENT_QUOTES), 25,128,$js);
	}


	public function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$main = array();
		$adv = array();
		$fieldlist = array();
		$others = $this->form_ptr->GetFields();
		for($i=0;$i<count($others);$i++)
		{
			if ($others[$i]->IsDisposition() && is_subclass_of($others[$i],'fbDispositionEmailBase'))
			{
				$txt = $others[$i]->GetName().': '.$others[$i]->GetDisplayType();
				$alias = $others[$i]->GetAlias();
				if (!empty($alias))
				{
					$txt .= ' ('.$alias.')';
				}
				$fieldlist[$txt] = $others[$i]->GetId();
			}
		}

		array_push($main,array($mod->Lang('title_field_to_modify'),
		$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_field_to_modify', $fieldlist, -1, $this->GetOption('field_to_modify'))));

		return array('main'=>$main,'adv'=>$adv);
	}


	public function ModifyOtherFields()
	{
		$mod = $this->form_ptr->module_ptr;
		$others = $this->form_ptr->GetFields();

		if ($this->Value !== false)
		{
			for($i=0;$i<count($others);$i++)
			{
				if ($others[$i]->IsDisposition() && is_subclass_of($others[$i],'fbDispositionEmailBase') && $others[$i]->GetId() == $this->GetOption('field_to_modify'))
				{
					$cc = $others[$i]->GetOption('email_cc_address','');
					if (!empty($cc))
					{
						$cc .= ',';
					}
					$cc .= $this->Value;
					$others[$i]->SetOption('email_cc_address',$this->Value);
				}
			}
		}
	}

	public function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		$others = $this->form_ptr->GetFields();
		for($i=0;$i<count($others);$i++)
		{
			if ($others[$i]->GetId() == $this->GetOption('field_to_modify'))
			{
				return $mod->Lang('title_modifies',$others[$i]->GetName());
			}
		}
		return $mod->Lang('unspecified');
	}

	public function Validate()
	{
		$this->validated = true;
		$this->validationErrorText = '';
		$mod = $this->form_ptr->module_ptr;
		switch ($this->ValidationType)
		{
			case 'email':
				if ($this->Value !== false
					&& !preg_match(($mod->GetPreference('relaxed_email_regex','0')==0?$mod->email_regex:$mod->email_regex_relaxed), $this->Value))
				{
					$this->validated = false;
					$this->validationErrorText = $mod->Lang('please_enter_an_email',$this->Name);
				}
				break;
		}
		return array($this->validated, $this->validationErrorText);
	}
}
?>