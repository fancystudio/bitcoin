<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbFromEmailAddressAgainField extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'FromEmailAddressAgainField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array(
			$mod->Lang('validation_email_address')=>'email',
		);
		$this->ValidationType = 'email';
		$this->modifiesOtherFields = false;
	}

	public function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');
		$val = '';
		$rq = '';
		$html5 = '';

		if ($this->GetOption('html5','0') == '1')
		{
			$val = $this->Value;
			$html5 = ' placeholder="'.$this->GetOption('default').'"';
		}
		else
		{
			$val = $this->HasValue() ? $this->Value : $this->GetOption('default');
			if($this->GetOption('clear_default','0') == 1)
			{
				$js .= ' onfocus="if(this.value==this.defaultValue) this.value=\'\';" onblur="if(this.value==\'\') this.value=this.defaultValue;"';
			}
		}

		if ($this->IsRequired()) {
			$rq = ' required="required"';
		}

		return $mod->CreateInputEmail($id, 'fbrp__'.$this->Id, $val, 25, 128, $js.$html5.$rq);
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
			$opts[$tf->GetName()]=$tf->GetName();
		}
		$main = array(array(
			$mod->Lang('title_field_to_validate'),
			$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_field_to_validate', $opts, -1, $this->GetOption('field_to_validate'))
		));
		$adv = array(
			array($mod->Lang('title_field_default_value'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_default',$this->GetOption('default'),25,1024)),
			array($mod->Lang('title_html5'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_html5','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_html5','1',$this->GetOption('html5','0'))),
			array($mod->Lang('title_clear_default'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_clear_default','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_clear_default','1',$this->GetOption('clear_default','0')).'<br />'.
				$mod->Lang('title_clear_default_help'))
		);

		return array('main'=>$main,'adv'=>$adv);
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
						$this->validationErrorText = $mod->Lang('email_address_does_not_match', $field_to_validate);
					}
				}
			}
		}
		return array($this->validated, $this->validationErrorText);
	}
}
?>