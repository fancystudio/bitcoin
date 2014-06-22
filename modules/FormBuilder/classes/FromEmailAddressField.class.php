<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbFromEmailAddressField extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'FromEmailAddressField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array(
			$mod->Lang('validation_email_address') => 'email',
		);
		$this->ValidationType = 'email';
		$this->modifiesOtherFields = true;
	}

	public function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');
		$html5 = $this->GetOption('html5','0') == '1' ? ' placeholder="'.$this->GetOption('default').'"' : '';
		$default = $html5 ? '' : htmlspecialchars($this->GetOption('default'), ENT_QUOTES);

		return $mod->CreateInputEmail($id, 'fbrp__'.$this->Id,
		($this->HasValue()?htmlspecialchars($this->Value, ENT_QUOTES):$default),
		25,128,$html5.$js);
	}

	public function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$main = array();
		$adv = array(
			array($mod->Lang('title_field_default_value'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_default',$this->GetOption('default'),25,1024)),
			array($mod->Lang('title_html5'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_html5','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_html5','1',$this->GetOption('html5','0'))),
			array($mod->Lang('title_clear_default'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_clear_default','0').
			$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_clear_default','1',$this->GetOption('clear_default','0')).'<br />'.$mod->Lang('title_clear_default_help'))
		);
		$hopts = array($mod->Lang('option_from')=>'f',$mod->Lang('option_reply')=>'r',$mod->Lang('option_both')=>'b');
		array_push($main,array($mod->Lang('title_headers_to_modify'),
		$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_headers_to_modify', $hopts, -1, $this->GetOption('headers_to_modify','f'))));

		return array('main'=>$main,'adv'=>$adv);
	}

	public function ModifyOtherFields()
	{
		$mod = $this->form_ptr->module_ptr;
		$others = $this->form_ptr->GetFields();
		$htm = $this->GetOption('headers_to_modify','f');

		if ($this->Value !== false)
		{
			for($i=0;$i<count($others);$i++)
			{
				$replVal = '';
				if ($others[$i]->IsDisposition() && is_subclass_of($others[$i],'fbDispositionEmailBase'))
				{
					if ($htm == 'f' || $htm == 'b')
					{
						$others[$i]->SetOption('email_from_address',$this->Value);
					}
					if ($htm == 'r' || $htm == 'b')
					{
						$others[$i]->SetOption('email_reply_to_address',$this->Value);
					}
				}
			}
		}
	}

	public function StatusInfo()
	{
		return '';
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