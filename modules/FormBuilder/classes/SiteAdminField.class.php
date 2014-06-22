<?php
/* 
   FormBuilder. Copyright (c) 2005-2008 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbSiteAdminField extends fbFieldBase {

	function __construct(&$form_ptr, &$params)
	{
    parent::__construct($form_ptr, $params);
		$this->Type = 'SiteAdminField';
		$this->DisplayInForm = true;
		$this->IsDisposition = false;
		$this->HasAddOp = false;
		$this->HasDeleteOp = false;
		$this->ValidationTypes = array();
	}


	function buildList()
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
		$ind = 1;
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
			if ($userlist[$i]->active || $this->GetOption('active_only','1')=='0')
				{
				$sorted[$sname]=$ind;
				$ind += 1;
				}
			}
		return $sorted;
	}

	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$sorted = $this->buildList();
		return $mod->CreateInputDropdown($id, 'fbrp__'.$this->Id, $sorted, -1, $this->Value, $js.$this->GetCSSIdTag());
	}

    function StatusInfo()
	{
	    global $gCms;
	    $groupops = $gCms->GetGroupOperations();
		$mod = $this->form_ptr->module_ptr;
		$ret = '';
		if ($this->GetOption('restrict_to_group','0')=='1')
			{
			$group = $groupops->LoadGroupByID($this->GetOption('group'));
			if ($group && isset($group->name))
				{
				$ret .= $mod->Lang('restricted_to_group',$group->name);
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

		$main=array();
		$adv=array();
		array_push($main,array($mod->Lang('title_select_one_message'),
			$mod->CreateInputText($formDescriptor, 'fbrp_opt_select_one',
			$this->GetOption('select_one',$mod->Lang('select_one')),25,128)));
		array_push($main,array($mod->Lang('title_show_userfirstname'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_userfirstname','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_show_userfirstname', '1',
				$this->GetOption('show_userfirstname','1'))));
		array_push($main,array($mod->Lang('title_show_userlastname'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_userlastname','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_show_userlastname', '1',
				$this->GetOption('show_userlastname','1'))));
		array_push($main,array($mod->Lang('title_show_username'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_username','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_show_username', '1',
				$this->GetOption('show_username','0'))));
		array_push($main,array($mod->Lang('title_active_only'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_active_only','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_active_only', '1',
				$this->GetOption('active_only','1'))));
				

		$items = array();
		foreach ($groups as $thisGroup)
			{
			$items[$thisGroup->name]=$thisGroup->id;
			}
		
		array_push($main,array($mod->Lang('title_restrict_to_group'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_restrict_to_group','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_restrict_to_group', '1',
				$this->GetOption('restrict_to_group','0')).
				$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_group', $items, -1, $this->GetOption('group',''))
				));
				
		return array('main'=>$main,'adv'=>$adv);
	}

	function GetHumanReadableValue($as_string=true)
	{
		$mod = $this->form_ptr->module_ptr;
		$userlist = array_flip($this->buildList());
		
		if (isset($userlist[$this->Value]))
			{
			$ret = $userlist[$this->Value];
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
	    
    function Validate()
    {
         $mod = $this->form_ptr->module_ptr;
         $result = true;
         $message = '';

         if ($this->Value == false)
            {
            $result = false;
            $message .=
$mod->Lang('must_specify_one_admin').'</br>';
            }
        return array($result,$message);
    }

}
?>
