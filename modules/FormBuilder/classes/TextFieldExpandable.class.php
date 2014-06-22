<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbTextFieldExpandable extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'TextFieldExpandable';
		$this->DisplayInForm = true;
		$this->HasUserAddOp = true;
		$this->HasUserDeleteOp = true;
		$this->NonRequirableField = false;
		$this->ValidationTypes = array(
			$mod->Lang('validation_none')=>'none',
			$mod->Lang('validation_numeric')=>'numeric',
			$mod->Lang('validation_integer')=>'integer',
			$mod->Lang('validation_email_address')=>'email',
			$mod->Lang('validation_regex_match')=>'regex_match',
			$mod->Lang('validation_regex_nomatch')=>'regex_nomatch'
		);
		$this->hasMultipleFormComponents = true;
	}

	public function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');
		$sibling_id = $this->GetOption('siblings','');
		$hidebuttons = $this->GetOption('hidebuttons','');

		if (! is_array($this->Value))
		{
			$vals = 1;
		}
		else
		{
			$vals = count($this->Value);
		}

		foreach ($params as $pKey=>$pVal)
		{
			if (substr($pKey,0,9) == 'fbrp_FeX_')
			{
				$pts = explode('_',$pKey);
				if ($pts[2] == $this->Id || $pts[2] == $sibling_id)
				{
					// add row
					$this->Value[$vals]='';
					$vals++;
				}
			}
			elseif (substr($pKey,0,9) == 'fbrp_FeD_')
			{
				$pts = explode('_',$pKey);
				if ($pts[2] == $this->Id || $pts[2] == $sibling_id)
				{
					// delete row
					if (isset($this->Value[$pts[3]]))
					{
						array_splice($this->Value, $pts[3], 1);
					}
					$vals--;
				}
			}
		}

		// Input fields
		$ret = array();
		for ($i=0;$i<$vals;$i++)
		{
			$thisRow = new stdClass();

			//$thisRow->name = '';
			//$thisRow->title = '';
			$thisRow->input = $mod->fbCreateInputText($id, 'fbrp__'.$this->Id.'[]',$this->Value[$i],$this->GetOption('length')<25?$this->GetOption('length'):25,
			$this->GetOption('length'),$js.$this->GetCSSIdTag('_'.$i));
				
			if(!$hidebuttons) $thisRow->op = $mod->fbCreateInputSubmit($id, 'fbrp_FeD_'.$this->Id.'_'.$i, $this->GetOption('del_button','X'), $this->GetCSSIdTag('_del_'.$i).($vals==1?' disabled="disabled"':''));

			array_push($ret, $thisRow);
		}

		// Add button
		$thisRow = new stdClass();
		//$thisRow->name = '';
		//$thisRow->title = '';
		//$thisRow->input = '';
		if(!$hidebuttons) $thisRow->op = $mod->fbCreateInputSubmit($id, 'fbrp_FeX_'.$this->Id.'_'.$i, $this->GetOption('add_button','+'), $this->GetCSSIdTag('_add_'.$i));

		array_push($ret, $thisRow);

		return $ret;
	}

	public function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		$ret = $mod->Lang('abbreviation_length',$this->GetOption('length','80'));
		if (strlen($this->ValidationType)>0)
		{
			$ret .= ", ".array_search($this->ValidationType,$this->ValidationTypes);
		}

		return $ret;
	}

	public function GetHumanReadableValue($as_string = true)
	{
		$form = $this->form_ptr;
		if (!is_array($this->Value))
		{
			$this->Value = array($this->Value);
		}

		if ($as_string)
		{
			return implode($form->GetAttr('list_delimiter',','), $this->Value);
		}
		else
		{
			return array($this->Value);
		}
	}

	public function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;

		$main = array(
			array($mod->Lang('title_maximum_length'),$mod->CreateInputText($formDescriptor,'fbrp_opt_length',$this->GetOption('length','80'),25,25)),
			array($mod->Lang('title_add_button_text'),$mod->CreateInputText($formDescriptor,'fbrp_opt_add_button',$this->GetOption('add_button','+'),15,25)),
			array($mod->Lang('title_del_button_text'),$mod->CreateInputText($formDescriptor,'fbrp_opt_del_button',$this->GetOption('del_button','X'),15,25))
		);

		$adv = array(
			array($mod->Lang('title_field_regex'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_regex',$this->GetOption('regex'),25,255).'<br />'.$mod->Lang('title_regex_help')),
			array($mod->Lang('title_field_siblings'),$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_siblings',$this->GetFieldSiblings(),-1,$this->GetOption('siblings','')).'<br />'.$mod->Lang('title_field_siblings_help')),
			array($mod->Lang('title_field_hidebuttons'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_hidebuttons',0).
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_hidebuttons',1,$this->GetOption('hidebuttons',0)).$mod->Lang('title_field_hidebuttons_help'))
		);

		return array('main'=>$main,'adv'=>$adv);
	}

	public function LabelSubComponents()
	{
		return false;
	}

	public function Validate()
	{
		$this->validated = true;
		$this->validationErrorText = '';
		$mod = $this->form_ptr->module_ptr;
		if (! is_array($this->Value))
		{
			$this->Value = array($this->Value);
		}
		foreach ($this->Value as $thisVal)
		{
			switch ($this->ValidationType)
			{
				case 'none':
					break;
				case 'numeric':
					if ($thisVal !== false && !preg_match("/^([\d\.\,])+$/i", $thisVal))
					{
						$this->validated = false;
						$this->validationErrorText = $mod->Lang('please_enter_a_number',$this->Name);
					}
					break;
				case 'integer':
					if ($thisVal !== false && !preg_match("/^([\d])+$/i", $thisVal) || intval($thisVal) != $thisVal)
					{
						$this->validated = false;
						$this->validationErrorText = $mod->Lang('please_enter_an_integer',$this->Name);
					}
					break;
				case 'email':
					if ($thisVal !== false &&
						!preg_match(($mod->GetPreference('relaxed_email_regex','0')==0?$mod->email_regex:$mod->email_regex_relaxed), $thisVal))
					{
						$this->validated = false;
						$this->validationErrorText = $mod->Lang('please_enter_an_email',$this->Name);
					}
					break;
				case 'regex_match':
					if ($thisVal !== false && !preg_match($this->GetOption('regex','/.*/'), $thisVal))
					{
						$this->validated = false;
						$this->validationErrorText = $mod->Lang('please_enter_valid',$this->Name);
					}
					break;
				case 'regex_nomatch':
					if ($thisVal !== false && preg_match($this->GetOption('regex','/.*/'), $thisVal))
					{
						$this->validated = false;
						$this->validationErrorText = $mod->Lang('please_enter_valid',$this->Name);
					}
					break;
			}

			if ($this->GetOption('length',0) > 0 && strlen($thisVal) > $this->GetOption('length',0))
			{
				$this->validated = false;
				$this->validationErrorText = $mod->Lang('please_enter_no_longer',$this->GetOption('length',0));
			}
		}

		return array($this->validated, $this->validationErrorText);
	}

	// Gets all mirror fields of this field
	public function GetFieldSiblings()
	{
		$mod = $this->form_ptr->module_ptr;
		$form = $this->form_ptr;
		$siblings = array();

		$siblings[$mod->Lang('select_one')] = '';

		for ($i=0; $i < count($form->Fields); $i++)
		{
			$thisField = &$form->Fields[$i];

			if ($thisField->GetFieldType() == 'TextFieldExpandable' && $thisField->GetId() != $this->GetId()){
				$siblings[$thisField->GetName()] = $thisField->GetId();
			}
		}
		return $siblings;
	}
}
?>