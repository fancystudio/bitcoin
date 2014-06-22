<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

require_once(dirname(__FILE__).'/DispositionEmailBase.class.php');

class fbDispositionFromEmailAddressField extends fbDispositionEmailBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'DispositionFromEmailAddressField';
		$this->IsDisposition = true;
		$this->DisplayInForm = true;
		$this->ValidationTypes = array(
			$mod->Lang('validation_none')=>'none',
			$mod->Lang('validation_email_address')=>'email',
		);
		$this->modifiesOtherFields = true;
		$this->NonRequirableField = false;
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
			$val = $this->Value[0];
			$html5 = ' placeholder="'.$this->GetOption('default').'"';
		}
		else
		{
			$val = $this->Value[0] ? $this->$this->Value[0] : $this->GetOption('default');
			if($this->GetOption('clear_default','0') == 1)
			{
				$js .= ' onfocus="if(this.value==this.defaultValue) this.value=\'\';" onblur="if(this.value==\'\') this.value=this.defaultValue;"';
			}
		}

		if ($this->IsRequired()) {
			$rq = ' required="required"';
		}

		$input = $mod->CreateInputEmail($id, 'fbrp__'.$this->Id.'[]', $val, 25, 128, $js.$html5.$rq);

		if ($this->GetOption('send_user_copy','n') == 'c')
		{
			$input .= $mod->CreateInputCheckbox($id, 'fbrp__'.$this->Id.'[]', 1, 0);
			$input .= $mod->CreateLabelForInput($id, 'fbrp__'.$this->Id.'[]', $this->GetOption('send_user_label', $mod->Lang('title_send_me_a_copy')));
		}

		return $input;
	}

	public function HasValue($deny_blank_responses=false)
	{
		return ($this->Value[0] !== false && !empty($this->Value[0]));
	}

	public function GetValue()
	{
		return $this->Value[0];
	}

	public function SetValue($valStr)
	{
		if (! is_array($valStr))
		{
			$this->Value = array($valStr);
		}
		else
		{
			$this->Value = $valStr;
		}
	}

	public function GetHumanReadableValue($as_string=true)
	{
		if (is_array($this->Value))
		{
			return $this->Value[0];
		}
		else
		{
			return $this->Value;
		}
	}

	public function DisposeForm($returnid)
	{
		if ($this->HasValue() != false &&
			(
				$this->GetOption('send_user_copy','n') == 'a'
				||
				($this->GetOption('send_user_copy','n') == 'c' && isset($this->Value[1]) && $this->Value[1] == 1)
			)
		)
		{
			return $this->SendForm($this->Value[0],$this->GetOption('email_subject'));
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
		$mod = $this->form_ptr->module_ptr;
		$opts = array($mod->Lang('option_never')=>'n',$mod->Lang('option_user_choice')=>'c',$mod->Lang('option_always')=>'a');
		$hopts = array($mod->Lang('option_from')=>'f',$mod->Lang('option_reply')=>'r',$mod->Lang('option_both')=>'b');

		$main = array(
			array($mod->Lang('title_send_usercopy'),
				$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_send_user_copy', $opts, -1, $this->GetOption('send_user_copy','n'))),
			array($mod->Lang('title_send_usercopy_label'),
				$mod->CreateInputText($formDescriptor, 'fbrp_opt_send_user_label', $this->GetOption('send_user_label',
				$mod->Lang('title_send_me_a_copy')),25,125)),
			array($mod->Lang('title_headers_to_modify'),
				$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_headers_to_modify', $hopts, -1, $this->GetOption('headers_to_modify','f'))),
		);
		$adv = array(
			array($mod->Lang('title_field_default_value'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_default',$this->GetOption('default'),25,1024)),
			array($mod->Lang('title_html5'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_html5','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_html5','1',$this->GetOption('html5','0'))),
			array($mod->Lang('title_clear_default'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_clear_default','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_clear_default','1',$this->GetOption('clear_default','0')).'<br />'.
				$mod->Lang('title_clear_default_help'))
		);

		$base = $this->PrePopulateAdminFormBase($formDescriptor);
		return array('main' => array_merge($base[0], $main), 'adv' => array_merge($adv, $base[1]));
	}

	public function PostPopulateAdminForm(&$mainArray, &$advArray)
	{
		$mod = $this->form_ptr->module_ptr;
		$this->RemoveAdminField($mainArray, $mod->Lang('title_email_from_address'));
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
				if ($others[$i]->IsDisposition() &&
				is_subclass_of($others[$i],'fbDispositionEmailBase'))
				{
					if ($htm == 'f' || $htm == 'b')
					{
						$others[$i]->SetOption('email_from_address',$this->Value[0]);
					}
					if ($htm == 'r' || $htm == 'b')
					{
						$others[$i]->SetOption('email_reply_to_address',$this->Value[0]);
					}
				}
			}
		}
	}

	public function Validate()
	{

		$this->validated = true;
		$this->validationErrorText = '';
		$result = true;
		$message = '';
		$mod = $this->form_ptr->module_ptr;
		if ($this->ValidationType != 'none')
		{
			if ($this->Value !== false &&
				!preg_match(($mod->GetPreference('relaxed_email_regex','0')==0?$mod->email_regex:$mod->email_regex_relaxed), $this->Value[0]))
			{
				$this->validated = false;
				$this->validationErrorText = $mod->Lang('please_enter_an_email',$this->Name);
			}
		}
		return array($this->validated, $this->validationErrorText);
	}
}
?>