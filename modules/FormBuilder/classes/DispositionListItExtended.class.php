<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 * 
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbDispositionListItExtended extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);

		$this->Type = 'DispositionListItExtended';
		$this->IsDisposition = true;
		$this->NonRequirableField = true;
		$this->DisplayInForm = false;
		$this->DisplayInSubmission = false;
		$this->sortable = false;
	}

	public function StatusInfo()
	{
		return $this->GetOption('instance');
	}

	public function DisposeForm($returnid)
	{
		$fptr = $this->form_ptr;
		$theFields = $fptr->GetFields();
		$listitmod = cmsms()->GetModuleInstance($this->GetOption('instance'));
		$item = $listitmod->InitiateItem();

		for($i = 0; $i < count($theFields); $i++)
		{
			$key = $this->GetOption('fld_'.$theFields[$i]->GetId());
			if($key == 'title')
			{
				$item->title = $theFields[$i]->GetHumanReadableValue();
			}
			elseif(intval($key) && isset($item->fielddefs[intval($key)]))
			{
				$item->$key = $theFields[$i]->GetHumanReadableValue();
			}
		}
		$item->active = $this->GetOption('state', 0);
		$listitmod->SaveItem($item);

		return array(true, '');
	}


	public function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$fpt = $this->form_ptr;
		$listit = cmsms()->GetModuleInstance('ListIt2');

		$main = array();
		$adv = array();
		if (!is_object($listit))
		{
			array_push($main, array('',$mod->Lang('title_install_listit2')));
		}
		else
		{
			$listitmods = $listit->ListModules();
			$instances = array();
			foreach($listitmods as $listitmod)
			{
				$instances[$listitmod->module_name] = $listitmod->module_name;
			}
			
			array_push($main, array(
				$mod->Lang('title_listit2_instance'),
				$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_instance', $instances, -1, $this->GetOption('instance'))
			));		
			
			if(!$this->GetOption('instance'))
			{
				array_push($main, array($mod->Lang('notice'), '<div class="red">'. $mod->Lang('content_select_instance') .'</div>'));
			}
			else
			{
				$listitmod = cmsms()->GetModuleInstance($this->GetOption('instance'));
				$listitfields = array(
					$mod->Lang('none') => '',
					$listitmod->GetPreference('item_title') => 'title',
				);
				
				$item = $listitmod->InitiateItem();
				foreach($item->fielddefs as $fielddef) {
					$listitfields[$fielddef->name] = $fielddef->GetId();
				}
				
				$fields = $fpt->GetFields();
				foreach($fields as $tf)
				{
					if(!$tf->DisplayInSubmission)
						continue;
				
					$al = $tf->GetAlias();
					if (empty($al))
						$al = $tf->GetVariableName();
					
					array_push($main, array(
						$mod->Lang('title_maps_to_field', $tf->GetName()),
						$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_fld_' . $tf->GetId(), $listitfields, -1,
							$this->GetOption('fld_' . $tf->GetId(), $al)
						)
					));
				}
			}
			
			array_push($adv, array(
				$mod->Lang('title_listit2_state'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_state',0) . $mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_state', 1, $this->GetOption('state'))
			));
		}
		
		return array('main' => $main, 'adv' => $adv);
	}

	public function PostPopulateAdminForm(&$mainArray, &$advArray)
	{
		$this->HiddenDispositionFields($mainArray, $advArray);
	}
}
?>