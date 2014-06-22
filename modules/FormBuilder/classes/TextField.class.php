<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbTextField extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'TextField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array(
			$mod->Lang('validation_none')=>'none',
			$mod->Lang('validation_numeric')=>'numeric',
			$mod->Lang('validation_integer')=>'integer',
			$mod->Lang('validation_usphone')=>'usphone',
			$mod->Lang('validation_email_address')=>'email',
			$mod->Lang('validation_regex_match')=>'regex_match',
			$mod->Lang('validation_regex_nomatch')=>'regex_nomatch'
		);
	}

	public function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$input = '';
		$val = '';
		$length = $this->GetOption('length') < 25 ? $this->GetOption('length') : 25;
		$js = $this->GetOption('javascript','');
		$ro = '';
		$html5 = '';
		$rq = '';

		if ($this->GetOption('readonly','0') == '1')
		{
			$ro = ' readonly="readonly"';
		}

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

		switch($this->ValidationType) {
			default:
				return $mod->CreateInputText($id, 'fbrp__'.$this->Id, $val, $length, $this->GetOption('length'), $js.$ro.$html5.$rq);
				break;

			case 'usphone':
				return $mod->CreateInputTel($id, 'fbrp__'.$this->Id, $val, $length, $this->GetOption('length'), $js.$ro.$html5.$rq);
				break;

			case 'email':
				return $mod->CreateInputEmail($id, 'fbrp__'.$this->Id, $val, $length, $this->GetOption('length'), $js.$ro.$html5.$rq);
				break;
		}
	}

	public function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		$ret = $mod->Lang('abbreviation_length',$this->GetOption('length','80'));

		if (strlen($this->ValidationType)>0)
		{
			$ret .= ", ".array_search($this->ValidationType,$this->ValidationTypes);
		}

		if ($this->GetOption('readonly','0') == '1')
		{
			$ret .= ", ".$mod->Lang('title_read_only');
		}
			
		return $ret;
	}

	public function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;

		$main = array(
			array($mod->Lang('title_maximum_length'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_length',$this->GetOption('length','80'),25,25)),
			array($mod->Lang('title_read_only'),$mod->CreateInputHidden($formDescriptor, 'fbrp_opt_readonly','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_readonly','1',$this->GetOption('readonly','0')))
		);

		$adv = array(
			array($mod->Lang('title_field_regex'),
				$mod->CreateInputText($formDescriptor, 'fbrp_opt_regex',$this->GetOption('regex'),25,1024).'<br />'.$mod->Lang('title_regex_help')),
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
		switch ($this->ValidationType)
		{
			case 'none':
				break;
			case 'numeric':
				if ($this->Value !== false) $this->Value = trim($this->Value);
				if ($this->Value !== false && !preg_match("/^([\d\.\,])+$/i", $this->Value))
				{
					$this->validated = false;
					$this->validationErrorText = $mod->Lang('please_enter_a_number',$this->Name);
				}
				break;
			case 'integer':
				if ($this->Value !== false) $this->Value = trim($this->Value);
				if ($this->Value !== false && !preg_match("/^([\d])+$/i", $this->Value) || intval($this->Value) != $this->Value)
				{
					$this->validated = false;
					$this->validationErrorText = $mod->Lang('please_enter_an_integer',$this->Name);
				}
				break;
			case 'email':
				if ($this->Value !== false)
				{
					$this->Value = trim($this->Value);
				}
				if ($this->Value !== false && !preg_match(($mod->GetPreference('relaxed_email_regex','0')==0?$mod->email_regex:$mod->email_regex_relaxed), $this->Value))
				{
					$this->validated = false;
					$this->validationErrorText = $mod->Lang('please_enter_an_email',$this->Name);
				}
				break;
			case 'usphone':
				if ($this->Value !== false) $this->Value = trim($this->Value);
				if ($this->Value !== false &&
					!preg_match('/^([0-9][\s\.-]?)?(\(?[0-9]{3}\)?|[0-9]{3})[\s\.-]?([0-9]{3}[\s\.-]?[0-9]{4}|[a-zA-Z0-9]{7})(\s?(x|ext|ext.)\s?[a-zA-Z0-9]+)?$/', $this->Value))
				{
					$this->validated = false;
					$this->validationErrorText = $mod->Lang('please_enter_a_phone',$this->Name);
				}
				break;
			case 'regex_match':
				if ($this->Value !== false && !preg_match($this->GetOption('regex','/.*/'), $this->Value))
				{
					$this->validated = false;
					$this->validationErrorText = $mod->Lang('please_enter_valid',$this->Name);
				}
				break;
			case 'regex_nomatch':
				if ($this->Value !== false && preg_match($this->GetOption('regex','/.*/'), $this->Value))
				{
					$this->validated = false;
					$this->validationErrorText = $mod->Lang('please_enter_valid',$this->Name);
				}
				break;
		}

		if ($this->GetOption('length',0) > 0 && strlen($this->Value) > $this->GetOption('length',0))
		{
			$this->validated = false;
			$this->validationErrorText = $mod->Lang('please_enter_no_longer',$this->GetOption('length',0));
		}
			
		return array($this->validated, $this->validationErrorText);
	}
}
?>