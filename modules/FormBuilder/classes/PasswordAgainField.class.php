<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbPasswordAgainField extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'PasswordAgainField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array();
		$this->modifiesOtherFields = false;
	}

	public function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');
		if ($this->GetOption('hide','1') == '0')
		{
			return $mod->fbCreateInputText($id, 'fbrp__'.$this->Id,($this->Value?$this->Value:''),$this->GetOption('length'),255,$js.$this->GetCSSIdTag());
		}
		else
		{
			return $mod->CreateInputPassword($id, 'fbrp__'.$this->Id,($this->Value?$this->Value:''), $this->GetOption('length'),255, $js);
		}
	}

	public function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		return $mod->Lang('title_field_id') . ': ' . $this->GetOption('field_to_validate','');
	}

	public function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$flds = $this->form_ptr->GetFields();
		$opts = array();
		foreach ($flds as $tf)
		{
			if ($tf->GetFieldType() == 'PasswordField')
			{
				$opts[$tf->GetName()]=$tf->GetName();
			}
		}
		$main = array(
			array(
				$mod->Lang('title_field_to_validate'),
				$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_field_to_validate', $opts, -1, $this->GetOption('field_to_validate'))),
			array($mod->Lang('title_display_length'),$mod->CreateInputText($formDescriptor,'fbrp_opt_length',$this->GetOption('length','12'),25,25)),
			array($mod->Lang('title_minimum_length'),$mod->CreateInputText($formDescriptor,'fbrp_opt_min_length',$this->GetOption('min_length','8'),25,25)),
			array($mod->Lang('title_hide'),$mod->CreateInputHidden($formDescriptor, 'fbrp_opt_hide','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_hide','1',$this->GetOption('hide','1')).$mod->Lang('title_hide_help')),
		);

		return array('main'=>$main);
	}

	public function Validate()
	{
		$this->validated = true;
		$this->validationErrorText = '';
		$mod = $this->form_ptr->module_ptr;

		$field_to_validate = $this->GetOption('field_to_validate','');

		if ($field_to_validate != '')
		{
			foreach ($this->form_ptr->Fields as $one_field)
			{
				if ($one_field->Name == $field_to_validate)
				{
					$value = $one_field->GetValue();
					if ($value != $this->Value)
					{
						$this->validated = false;
						$this->validationErrorText = $mod->Lang('password_does_not_match', $field_to_validate);
					}
				}
			}
		}
		return array($this->validated, $this->validationErrorText);
	}
}

?>
