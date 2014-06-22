<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

require_once(dirname(__FILE__).'/DispositionEmailBase.class.php');

class fbDispositionEmailBasedFrontendFields extends fbDispositionEmailBase {


	function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'DispositionEmailBasedFrontendFields';
		$this->DisplayInForm = false;
		$this->DisplayInSubmission = false;
		$this->NonRequirableField = true;
		$this->IsDisposition = true;
		$this->HideLabel = 1;
		$this->ValidationTypes = array();
	}

	function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;

		$opt = $this->GetOptionRef('destination_address','');
		if(!is_array($opt)) {

			$opt = array($opt);
		}

		$ret= $mod->Lang('to').": ".count($opt)." ".$mod->Lang('fields');
		$ret.= $this->TemplateStatus();

		return $ret;
	}


	// Send off those emails
	function DisposeForm($returnid)
	{

		$mod = $this->form_ptr->module_ptr;
		$form = $this->form_ptr;

		$tmp = $form->GetFieldByID($this->GetOption('email_subject'));
		$this->SetOption('email_subject',$tmp->GetHumanReadableValue());

		$tmp = $form->GetFieldByID($this->GetOption('email_from_name'));
		$this->SetOption('email_from_name',$tmp->GetHumanReadableValue());

		$tmp = $form->GetFieldByID($this->GetOption('email_from_address'));
		$this->SetOption('email_from_address',$tmp->GetHumanReadableValue());

		$addarr = array();
		$address = $this->GetOptionRef('destination_address');

		if(!is_array($address)) {

			$address = array($address);
		}

		foreach($address as $item) {

			$tmp = $form->GetFieldByID($item);
			$value = $tmp->GetHumanReadableValue();
				
			if (strpos($value,',') !== false) {
					
				$arr = explode(',',$value);
			} else {
					
				$arr = array($value);
			}
				
			foreach($arr as $email) {
					
				$validate = $this->validateEmailAddr($email);

				if($validate[0]) {

					$addarr[] = $email;
						
				}
			}
		}

		return $this->SendForm($addarr,$this->GetOption('email_subject'));
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;

		$parm = array();
		$parm['opt_email_template']['html_button'] = true;
		$parm['opt_email_template']['text_button'] = true;
		$parm['opt_email_template']['is_email'] = true;

		$destadd_all = $this->GetFieldList();
		$destadd_tmp = $this->GetOptionRef('destination_address');

		if(!is_array($destadd_tmp)) {

			$destadd_tmp = array($destadd_tmp);
		}

		$destadd_sel = array();
		foreach($destadd_all as $k=>$v) {

			if(in_array($v,$destadd_tmp)) {
					
				$destadd_sel[$k] = $v;
					
			}
		}

		$main = array(
			array($mod->Lang('title_email_subject'),$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_email_subject',$this->GetFieldList(true),-1,$this->GetOption('email_subject',''))),
			array($mod->Lang('title_email_from_name'),$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_email_from_name',$this->GetFieldList(true),-1,$this->GetOption('email_from_name',$mod->Lang('friendlyname')))),
			array($mod->Lang('title_email_from_address'),array($mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_email_from_address',$this->GetFieldList(true),-1,$this->GetOption('email_from_address','')),
				$mod->Lang('email_from_addr_help',array($_SERVER['SERVER_NAME'])))),		
			array($mod->Lang('title_destination_address'),$mod->CreateInputSelectList($formDescriptor, 'fbrp_opt_destination_address[]',$destadd_all,$destadd_sel,5))
		);

		$adv = array(
			array($mod->Lang('title_html_email'), $mod->CreateInputHidden($formDescriptor,'fbrp_opt_html_email','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_html_email','1',$this->GetOption('html_email','0'))),
			array($mod->Lang('title_email_template'), array($mod->CreateTextArea(false, $formDescriptor, $this->GetOption('email_template',''),'fbrp_opt_email_template', 'module_fb_area_wide', '','','','80', '15','','html'),
				$this->form_ptr->AdminTemplateHelp($formDescriptor,$parm))),
			array($mod->Lang('title_email_encoding'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_email_encoding',$this->GetOption('email_encoding','utf-8'),25,128))
		);

		return array('main'=>$main,'adv'=>$adv);
	}

	function PostPopulateAdminForm(&$mainArray, &$advArray)
	{
		$this->HiddenDispositionFields($mainArray, $advArray);
	}

	// Validate admin side
	function AdminValidate()
	{
		$mod = $this->form_ptr->module_ptr;
		$subject = $this->GetOption('email_subject','');
		$name = $this->GetOption('email_from_name','');
		$from = $this->GetOption('email_from_address','');
		$dest = $this->GetOptionRef('destination_address');

		list($ret, $message) = $this->DoesFieldHaveName();

		if ($ret) {

			list($ret, $message) = $this->DoesFieldNameExist();
		}
			
		if ($subject == false || count($subject) == 0) {

			$ret = false;
			$message .= $mod->Lang('no_field_assigned',$mod->Lang('title_email_subject')).'<br />';
		}

		if ($name == false || count($name) == 0) {

			$ret = false;
			$message .= $mod->Lang('no_field_assigned',$mod->Lang('title_email_from_name')).'<br />';
		}

		if ($from == false || count($from) == 0) {

			$ret = false;
			$message .= $mod->Lang('no_field_assigned',$mod->Lang('title_email_from_address')).'<br />';
		}

		if ($dest == false || count($dest) == 0) {

			$ret = false;
			$message .= $mod->Lang('no_field_assigned',$mod->Lang('title_destination_address')).'<br />';
		}


		return array($ret,$message);
	}

	// Get all fields
	private function GetFieldList($selectone = false)
	{
		$mod = $this->form_ptr->module_ptr;
		$form = $this->form_ptr;
		$fields = $form->GetFields();
		$ret = array();

		if($selectone) {

			$ret[$mod->Lang('select_one')] = '';
		}

		foreach($fields as $thisField) {

			if($thisField->DisplayInForm) {

				$ret[$thisField->GetName()] = $thisField->GetId();
			}
		}

		return $ret;
	}
}
?>