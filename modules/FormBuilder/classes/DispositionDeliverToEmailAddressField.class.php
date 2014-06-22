<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

require_once(dirname(__FILE__).'/DispositionEmailBase.class.php');

class fbDispositionDeliverToEmailAddressField extends fbDispositionEmailBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'DispositionDeliverToEmailAddressField';
		$this->IsDisposition = true;
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
		return $mod->CreateInputEmail($id, 'fbrp__'.$this->Id, $this->Value, 25, 128, $js);
	}

	public function DisposeForm($returnid)
	{
		if ($this->HasValue() != false)
		{
			return $this->SendForm($this->Value,$this->GetOption('email_subject'));
		}
		else
		{
			return array(true,'');
		}
	}

	public function StatusInfo()
	{
		return $this->TemplateStatus();
	}

	public function PrePopulateAdminForm($formDescriptor)
	{
		list($main,$adv) = $this->PrePopulateAdminFormBase($formDescriptor);
		return array('main'=>$main,'adv'=>$adv);
	}

	public function Validate()
	{

		$this->validated = true;
		$this->validationErrorText = '';
		$result = true;
		$message = '';
		$mod = $this->form_ptr->module_ptr;
		if ($this->Value !== false
			&& !preg_match(($mod->GetPreference('relaxed_email_regex','0')==0?$mod->email_regex:$mod->email_regex_relaxed), $this->Value))
		{
			$this->validated = false;
			$this->validationErrorText = $mod->Lang('please_enter_an_email',$this->Name);
		}

		return array($this->validated, $this->validationErrorText);
	}
}
?>