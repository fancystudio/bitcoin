<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

require_once('DispositionEmailBase.class.php');

class fbDispositionEmailSiteAdmin extends fbDispositionEmailBase {

	public $addressCount;
	public $addressAdd;

	function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'DispositionEmailSiteAdmin';
		$this->DisplayInForm = true;
		$this->IsDisposition = true;
		$this->HasAddOp = false;
		$this->HasDeleteOp = false;
		$this->ValidationTypes = array();
	}


	function GetFieldInput($id, &$params, $returnid)
	{
		global $gCms;
		$userops = $gCms->GetUserOperations();
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');

		// why all this? Associative arrays are not guaranteed to preserve
		// order, except in "chronological" creation order.
		$sorted =array();
		if ($this->GetOption('select_one','') != '')
		{
			$sorted[' '.$this->GetOption('select_one','')]='';
		}
		else
		{
			$sorted[' '.$mod->Lang('select_one')]='';
		}
			
		if ($this->GetOption('restrict_to_group','0')=='1')
		{
			$userlist = $userops->LoadUsersInGroup($this->GetOption('group'));
		}
		else
		{
			$userlist = $userops->LoadUsers();
		}
		for($i=0;$i<count($userlist);$i++)
		{
			$name = array();
			if ($this->GetOption('show_userfirstname','0')=='1')
			{
				array_push($name,$userlist[$i]->firstname);
			}
			if ($this->GetOption('show_userlastname','0')=='1')
			{
				array_push($name,$userlist[$i]->lastname);
			}
			if ($this->GetOption('show_username','0')=='1')
			{
				array_push($name,' ('.$userlist[$i]->username.')');
			}
			$sname = implode(' ',$name);
			$sorted[$sname]=($i+1);
		}
		return $mod->CreateInputDropdown($id, 'fbrp__'.$this->Id, $sorted, -1, $this->Value, $js.$this->GetCSSIdTag());
	}



	function StatusInfo()
	{
		global $gCms;
		$groupops = $gCms->GetGroupOperations();
		$mod = $this->form_ptr->module_ptr;
		$ret = $this->TemplateStatus();
		if ($this->GetOption('restrict_to_group','0')=='1')
		{
			$group = $groupops->LoadGroupByID($this->GetOption('group'));
			if ($group && isset($group->name))
			{
				$ret .= ', '.$mod->Lang('restricted_to_group',$group->name);
			}
		}
		return $ret;
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		global $gCms;
		$groupops = $gCms->GetGroupOperations();
		$groups = $groupops->LoadGroups();
		$mod = $this->form_ptr->module_ptr;

		list($main,$adv) = $this->PrePopulateAdminFormBase($formDescriptor);
		array_push($main, array($mod->Lang('title_select_one_message'),
			$mod->CreateInputText($formDescriptor, 'fbrp_opt_select_one',$this->GetOption('select_one',$mod->Lang('select_one')),25,128)));
		array_push($main, array($mod->Lang('title_show_userfirstname'),
			$mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_userfirstname','0').
			$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_show_userfirstname', '1',$this->GetOption('show_userfirstname','1'))));
		array_push($main, array($mod->Lang('title_show_userlastname'),
			$mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_userlastname','0').
			$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_show_userlastname', '1',$this->GetOption('show_userlastname','1'))));
		array_push($main, array($mod->Lang('title_show_username'),
			$mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_username','0').
			$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_show_username', '1',$this->GetOption('show_username','0'))));

		$items = array();
		foreach ($groups as $thisGroup)
		{
			$items[$thisGroup->name]=$thisGroup->id;
		}

		array_push($main, array($mod->Lang('title_restrict_to_group'),
			$mod->CreateInputHidden($formDescriptor,'fbrp_opt_restrict_to_group','0').
			$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_restrict_to_group', '1',$this->GetOption('restrict_to_group','0')).
			$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_group', $items, -1, $this->GetOption('group',''))
		));

		return array('main'=>$main,'adv'=>$adv);
	}

	function GetHumanReadableValue($as_string=true)
	{
		global $gCms;
		$userops = $gCms->GetUserOperations();
		$mod = $this->form_ptr->module_ptr;

		if ($this->GetOption('restrict_to_group','0')=='1')
		{
			$userlist = $userops->LoadUsersInGroup($this->GetOption('group'));
		}
		else
		{
			$userlist = $userops->LoadUsers();
		}
		if (isset($userlist[$this->Value - 1]))
		{
			$ret = $userlist[$this->Value - 1]->firstname . ' '. $userlist[$this->Value - 1]->lastname;
		}
		else
		{
			$ret = $mod->Lang('unspecified');
		}
		if ($as_string)
		{
			return $ret;
		}
		else
		{
			return array($ret);
		}

	}

	function DisposeForm($returnid)
	{
		global $gCms;
		$userops = $gCms->GetUserOperations();
		$mod = $this->form_ptr->module_ptr;

		if ($this->GetOption('restrict_to_group','0')=='1')
		{
			$userlist = $userops->LoadUsersInGroup($this->GetOption('group'));
		}
		else
		{
			$userlist = $userops->LoadUsers();
		}
		$dest = array($userlist[$this->Value - 1]->email);
		return $this->SendForm($dest,$this->GetOption('email_subject'));
	}


	function AdminValidate()
	{
		$mod = $this->form_ptr->module_ptr;
		list($ret,$message) = $this->validateEmailAddr($this->GetOption('email_from_address'));
		return array($ret,$message);
	}

	function Validate()
	{
		$mod = $this->form_ptr->module_ptr;
		$result = true;
		$message = '';

		if ($this->Value == false)
		{
			$result = false;
			$message .=
			$mod->Lang('must_specify_one_destination').'</br>';
		}
		return array($result,$message);
	}

}
?>
