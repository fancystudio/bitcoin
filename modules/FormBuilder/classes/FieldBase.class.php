<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbFieldBase {

	// should be made protected as soon as there are getters and setters
	public $Id=-1;
	var $FormId;
	public $Name;
	var $Type;
	public $Required=-1;
	var $OrderBy;
	var $HideLabel=-1;
	var $HasLabel=1;
	var $NeedsDiv=1;
	var $SmartyEval;

	var $ValidationTypes;
	public $ValidationType;
	public $validated = true;
	var $validationErrorText;

	var $DisplayInForm;
	var $DisplayInSubmission;
	var $DispositionPermitted;
	var $IsComputedOnSubmission;
	var $NonRequirableField;
	var $HasAddOp;
	var $HasDeleteOp;
	var $HasUserAddOp;
	var $HasUserDeleteOp;
	var $modifiesOtherFields;
	var $hasMultipleFormComponents;
	var $labelSubComponents;

	var $Value=false;
	var $form_ptr;
	var $Options;
	var $loaded;
	var $sortable;

	public function __construct(&$form_ptr, &$params)
	{
		$this->form_ptr = $form_ptr;
		$mod = $form_ptr->module_ptr;
		$this->Options = array();
		$this->DisplayInForm = true;
		$this->DisplayInSubmission = true;
		$this->IsDisposition = false;
		$this->IsEmailDisposition = false;
		$this->ValidationTypes = array($mod->Lang('validation_none')=>'none');
		$this->loaded = false;
		$this->NonRequirableField = false;
		$this->HasAddOp = false;
		$this->HasDeleteOp = false;
		$this->HasUserAddOp = false;
		$this->HasUserDeleteOp = false;
		$this->modifiesOtherFields = false;
		$this->hasMultipleFormComponents = false;
		$this->DispositionPermitted = true;
		$this->SmartyEval = false;
		$this->labelSubComponents = true;
		$this->sortable = true;
		$this->IsComputedOnSubmission = false;

		if (isset($params['form_id']))
		{
			$this->FormId = $params['form_id'];
		}

		if (isset($params['field_id']))
		{
			$this->Id = $params['field_id'];
		}

		if (isset($params['fbrp_field_name']))
		{
			$this->Name = $params['fbrp_field_name'];
		}

		if (isset($params['fbrp_field_type']))
		{
			$this->Type = $params['fbrp_field_type'];
		}
		else
		{
			$this->Type = '';
		}

		if (isset($params['fbrp_order_by']))
		{
			$this->OrderBy = $params['fbrp_order_by'];
		}

		if (isset($params['fbrp_hide_label']))
		{
			$this->HideLabel = $params['fbrp_hide_label'];
		}
		elseif (isset($params['fbrp_set_from_form']))
		{
			$this->HideLabel = 0;
		}

		if (isset($params['fbrp_required']))
		{
			$this->Required = $params['fbrp_required'];
		}
		elseif (isset($params['fbrp_set_from_form']))
		{
			$this->Required = 0;
		}

		if (isset($params['fbrp_validation_type'])) {

			$this->ValidationType = $params['fbrp_validation_type'];
		}

		foreach ($params as $thisParamKey=>$thisParamVal)
		{
			if (substr($thisParamKey,0,9) == 'fbrp_opt_')
			{
				$thisParamKey = substr($thisParamKey,9);
				$this->Options[$thisParamKey] = $thisParamVal;
			}
		}

		// Check value setup against $params
		if (isset($params['fbrp__'.$this->Id]) && (is_array($params['fbrp__'.$this->Id]) || strlen($params['fbrp__'.$this->Id]) > 0))
		{
			$this->SetValue($params['fbrp__'.$this->Id]);
		}

	}

	function HasMultipleFormComponents()
	{
		return $this->hasMultipleFormComponents;
	}

	function LabelSubComponents()
	{
		return $this->labelSubComponents;
	}

	function ComputeOnSubmission()
	{
		return $this->IsComputedOnSubmission;
	}

	// override me
	function ComputeOrder()
	{
		return 0;
	}

	function HasMultipleValues()
	{
		if ($this->hasMultipleFormComponents || $this->HasUserAddOp)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function GetFieldInputId($id, &$params, $returnid)
	{
		return $id.'fbrp__'.$this->Id;
	}

	function ModifiesOtherFields()
	{
		return $this->modifiesOtherFields;
	}

	// mechanism for fields/dispositions to inhibit other dispositions
	function DispositionIsPermitted()
	{
		return $this->DispositionPermitted;
	}

	// mechanism for fields/dispositions to inhibit other dispositions
	function SetDispositionPermission($permitted=true)
	{
		$this->DispositionPermitted = $permitted;
	}

	// override me if you need to do something after the form has been disposed
	public function PostDispositionAction() {}

	// override me if you're just tweaking other fields before disposition
	public function ModifyOtherFields() {}

	// override me with a form input string or something
	// this should just be the input portion. The title
	// and any wrapping divs will be provided by the form
	// renderer.
	function GetFieldInput($id, &$params, $returnid)
	{
		return '';
	}

	// Sends logic along with field, also allows smarty logic
	// Dosen't need override in most cases
	function GetFieldLogic()
	{
		$mod = $this->form_ptr->module_ptr;
		$code = $this->GetOption('field_logic','');

		if(!empty($code)) {

			return $mod->ProcessTemplateFromData($code);
		}
	}

	// override me with something to show users
	function StatusInfo()
	{
		return '';
	}

	function DebugDisplay()
	{
		$tmp = $this->form_ptr;
		$this->form_ptr = '[frmptr: '.$tmp->GetId().']';
		debug_display($this);
		$this->form_ptr = $tmp;
	}

	function GetId()
	{
		return $this->Id;
	}

	function HasAddOp()
	{
		return $this->HasAddOp;
	}

	// override me, when necessary or useful
	function DoOptionAdd(&$params)
	{
	}

	// override me
	function GetOptionAddButton()
	{
		$mod = $this->form_ptr->module_ptr;
		return $mod->Lang('add_options');
	}

	function HasDeleteOp()
	{
		return $this->HasDeleteOp;
	}

	// override me, when necessary or useful
	function DoOptionDelete(&$params)
	{
	}

	// override me
	function GetOptionDeleteButton()
	{
		$mod = $this->form_ptr->module_ptr;
		return $mod->Lang('delete_options');
	}

	function SetName($name)
	{
		$this->Name = $name;
	}

	function GetName()
	{
		return $this->Name;
	}

	function GetAlias()
	{
		return $this->GetOption('field_alias','');
	}

	function GetVariableName()
	{
		$maxvarlen = 24;
		$string = strtolower(preg_replace('/\s+/','_',$this->Name));
		$string = strtolower(preg_replace('/\W/','_',$string));
		if (strlen($string) > $maxvarlen)
		{
			$string = substr($string,0,$maxvarlen);
			$pos = strrpos($string,'_');
			if ($pos !== false)
			{
				$string = substr($string,0,$pos);
			}
		}
		return $string;
	}

	function GetCSSIdTag($suffix='')
	{
		return ' id="'.$this->GetCSSId($suffix).'"';
	}

	function GetCSSId($suffix='')
	{
		$alias = $this->GetAlias();
		if (empty($alias))
		{
			$cssid = 'fbrp__'.$this->Id;
			if ($this->HasMultipleFormComponents())
			{
				$cssid .= '_1';
			}
		}
		else
		{
			$cssid = $alias;
		}
		$cssid .= $suffix;
		return $cssid;
	}

	function SetAlias($alias)
	{
		$this->SetOption('field_alias',$alias);
	}


	function SetSmartyEval($bool)
	{
		$this->SmartyEval = $bool;
	}

	function GetSmartyEval()
	{
		return $this->SmartyEval;
	}

	function GetOrder()
	{
		return $this->OrderBy;
	}

	function SetOrder($order)
	{
		$this->OrderBy = $order;
	}

	function GetFieldType()
	{
		return $this->Type;
	}

	function SetFieldType($type)
	{
		return $this->Type = $type;
	}


	function IsDisposition()
	{
		return $this->IsDisposition;
	}

	function IsEmailDisposition()
	{
		return $this->IsEmailDisposition;
	}

	function HasLabel()
	{
		return $this->HasLabel;
	}

	function NeedsDiv()
	{
		return $this->NeedsDiv;
	}


	function SetHideLabel($hide)
	{
		$this->HideLabel = $hide?1:0;
	}
	 
	function HideLabel()
	{
		return ($this->HideLabel==1?true:false);
	}

	function DisplayInForm()
	{
		return $this->DisplayInForm;
	}

	function DisplayInSubmission()
	{
		//return ($this->DisplayInForm && $this->DisplayInSubmission);
		return $this->DisplayInSubmission;
	}


	function IsNonRequirableField()
	{
		return $this->NonRequirableField;
	}

	function IsRequired()
	{
		return ($this->Required == 1?true:false);
	}

	function SetRequired($required)
	{
		$this->Required = ($required?1:0);
	}

	function ToggleRequired()
	{
		$this->Required = ($this->Required?0:1);
	}


	function GetValidationTypes()
	{
		return $this->ValidationTypes;
	}

	function GetValidationType()
	{
		return $this->ValidationType;
	}

	function SetValidationType($theType)
	{
		$this->ValidationType = $theType;
	}

	function IsValid()
	{
		return $this->validated;
	}

	function GetValidationErrorText()
	{
		return $this->validationErrorText;
	}

	// override me with a displayable type
	function GetDisplayType()
	{
		return $this->form_ptr->module_ptr->Lang('field_type_'.$this->Type);
	}

	// Base backended fields configuration
	function PrePopulateBaseAdminForm($formDescriptor,$disposeOnly=0)
	{
		$mod = $this->form_ptr->module_ptr;

		// Do the field type check
		if ($this->Type == '')
		{
			if ($disposeOnly == 1)
			{
				$typeInput = $mod->CreateInputDropdown($formDescriptor, 'fbrp_field_type',array_merge(array($mod->Lang('select_type')=>''),$mod->disp_field_types), -1,'', 'onchange="this.form.submit()"');
			}
			else
			{
				$typeInput = $mod->CreateInputDropdown($formDescriptor, 'fbrp_field_type',array_merge(array($mod->Lang('select_type')=>''),$mod->field_types), -1,'', 'onchange="this.form.submit()"');
			}
		}
		else
		{
			$typeInput = $this->GetDisplayType().$mod->CreateInputHidden($formDescriptor, 'fbrp_field_type', $this->Type);
		}

		// Init main tab
		$main = array(
			array($mod->Lang('title_field_name'),$mod->CreateInputText($formDescriptor, 'fbrp_field_name', $this->GetName(), 50)),
			array($mod->Lang('title_field_type'),$typeInput)
		);

		// Init advanced tab
		$adv = array();

		// if we know our type, we can load up with additional options
		if ($this->Type != '') {
				
			// validation types?
			if (count($this->GetValidationTypes()) > 1) {

				$validInput = $mod->CreateInputDropdown($formDescriptor, 'fbrp_validation_type', $this->GetValidationTypes(), -1, $this->GetValidationType());
			} else {

				$validInput = $mod->Lang('automatic');
			}

			if (!$this->IsNonRequirableField()) {
				array_push($main, array($mod->Lang('title_field_required'),$mod->CreateInputCheckbox($formDescriptor, 'fbrp_required', 1, $this->IsRequired()).$mod->Lang('title_field_required_long')));
			}

			array_push($main, array($mod->Lang('title_field_validation'),$validInput));

			if( $this->HasLabel == 1 ) {
					
				array_push($adv, array($mod->Lang('title_hide_label'),$mod->CreateInputCheckbox($formDescriptor, 'fbrp_hide_label', 1, $this->HideLabel()).$mod->Lang('title_hide_label_long')));
			}

			$alias = $this->GetOption('field_alias','');
			if ($alias == '') {
				$alias = 'fld'.$this->GetId();
			}

			array_push($adv, array($mod->Lang('title_field_alias'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_field_alias', $this->GetOption('field_alias'), 50)));

			if ($this->DisplayInForm()) {
				array_push($adv,array($mod->Lang('title_field_css_class'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_css_class', $this->GetOption('css_class'), 50)));
				array_push($adv,array($mod->Lang('title_field_helptext'),$mod->CreateTextArea(false, $formDescriptor, $this->GetOption('helptext',''), 'fbrp_opt_helptext','module_fb_area_short')));
				array_push($adv,array($mod->Lang('title_field_javascript'),$mod->CreateTextArea(false, $formDescriptor, $this->GetOption('javascript',''),
								'fbrp_opt_javascript','module_fb_area_short','','', '', '80', '15','','js').'<br />'.$mod->Lang('title_field_javascript_long')));
				array_push($adv,array($mod->Lang('title_field_logic'),$mod->CreateTextArea(false, $formDescriptor, $this->GetOption('field_logic',''),
								'fbrp_opt_field_logic','module_fb_area_short','','', '', '80', '15').'<br />'.$mod->Lang('title_field_logic_long')));
			}

		} else {

			// no advanced options until we know our type
			array_push($adv,array($mod->Lang('tab_advanced'),$mod->Lang('notice_select_type')));
		}

		return array('main'=>$main, 'adv'=>$adv);
	}


	// override me.
	// I return an ugly data structure:
	// It's an associative array with two items, 'main' and 'adv' (for the
	// main and advanced setting tabs).
	// Each of these is an associative array of Title / Input values.
	// The Title will be displayed if it has a length;
	// the "Input" should be a Form input for that field attribute/option
	function PrePopulateAdminForm($formDescriptor)
	{
		return array();
	}

	// override me.
	// This gives you a chance to alter the array contents before
	// they get rendered.
	public function PostPopulateAdminForm(&$mainArray, &$advArray) {}

	// override me as necessary
	public function PostAdminSubmitCleanup() {}

	// override me as necessary
	public function PostFieldSaveProcess(&$params) {}

	// new method as of Oct 09 that should have been here all along...
	function RemoveAdminField(&$array, $fieldname)
	{
		$reqIndex = -1;
		for ($i=0;$i<count($array);$i++)
		{
			if ($array[$i]->title == $fieldname)
			{
				$reqIndex = $i;
			}
		}
		if ($reqIndex != -1)
		{
			array_splice($array, $reqIndex,1);
		}
	}

	function CheckForAdvancedTab(&$advArray)
	{
		if (count($advArray) == 0)
		{
			$advArray[0]->title = $mod->Lang('tab_advanced');
			$advArray[0]->input = $mod->Lang('title_no_advanced_options');
		}
	}

	// clear fields unused by invisible dispositions
	function HiddenDispositionFields(&$mainArray, &$advArray, $hideReq=true)
	{
		$mod = $this->form_ptr->module_ptr;

		// remove the "required" field
		if ($hideReq) {
			$this->RemoveAdminField($mainArray, $mod->Lang('title_field_required'));
		}

		// remove the "hide name" field
		$this->RemoveAdminField($advArray, $mod->Lang('title_hide_label'));

		// remove the "css" field
		$this->RemoveAdminField($advArray, $mod->Lang('title_field_css_class'));

		// hide "javascript"
		$this->RemoveAdminField($advArray, $mod->Lang('title_field_javascript'));

		// hide "logic"
		$this->RemoveAdminField($advArray, $mod->Lang('title_field_logic'));

		// hide "help text"
		$this->RemoveAdminField($advArray, $mod->Lang('title_field_helptext'));

		$this->CheckForAdvancedTab($advArray);
	}


	// override me. Returns an array: first value is a true or false (whether or not
	// the value is valid), the second is a message
	function Validate()
	{
		$this->validated = true;
		$this->validatedErrorText = '';
		return array($this->validated, $this->validatedErrorText);
	}


	// override me!
	function GetHumanReadableValue($as_string=true)
	{
		$mod = $this->form_ptr->module_ptr;
		if ($this->Value !== false)
		{
			$ret = $this->Value;
		}
		else
		{
	  $ret = $this->form_ptr->GetAttr('unspecified',$mod->Lang('unspecified'));
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

	// override me!
	function GetAllHumanReadableValues()
	{

		$mod = $this->form_ptr->module_ptr;
		if(in_array('option_value',$this->GetOptionNames())) {

			if(count($this->GetOption('option_value')) > 0) {

				return $this->GetOption('option_value');
			}
		}

		return false;
	}


	// override this if you have some unusual format for values,
	// especially if "false" is a valid value!
	function HasValue($deny_blank_responses=false)
	{
		if ($this->GetFieldType()=='TextField' || $this->GetFieldType()=='TextAreaField')
		{
			// fields with defaults
			$def = $this->GetOption('default','');
			if ($this->Value !== false &&
			($def == '' || $this->Value != $def))
			{
				if ($deny_blank_responses && !is_array($this->Value)
				&& preg_match('/^\s+$/',$this->Value))
				{
					return false;
				}
				return true;
			}
		}
		else if ($this->Value !== false)
		{
			if ($deny_blank_responses && !is_array($this->Value)
			&& preg_match('/^\s+$/',$this->Value))
			{
				return false;
			}
			return true;
		}
		return false;
	}

	// probably don't need to override this
	function GetValue()
	{
		return $this->Value;
	}

	// override me? Returns the (possibly converted) value of the field.
	function GetArrayValue($index)
	{
		if ($this->Value !== false)
		{
			if (is_array($this->Value))
	  {
	  	if (isset($this->Value[$index]))
	  	{
	  		return $this->Value[$index];
	  	}
	  }
	  elseif ($index == 0)
	  {
	  	return $this->Value;
	  }
		}
		return false;
	}

	// override me? Returns true if the value is contained in the Value array
	function FindArrayValue($value)
	{
		if ($this->Value !== false)
		{
			if (is_array($this->Value))
	  {
	  	return array_search($value,$this->Value);
	  }
	  elseif ($this->Value == $value)
	  {
	  	return true;
	  }
		}
		return false;
	}

	function ResetValue()
	{
		$this->Value = false;
	}

	// override me, if necessary to convert type or something.
	function SetValue($valStr)
	{

		//error_log($this->GetName().':'.print_r($valStr,true));
		$fm = $this->form_ptr;
		if ($this->Value === false)
		{
			if (is_array($valStr))
			{
				$this->Value = $valStr;
				for ($i=0;$i<count($this->Value);$i++)
				{
					while ( $this->Value[$i] != $fm->unmy_htmlentities($this->Value[$i]))
					{
						$this->Value[$i] = $fm->unmy_htmlentities($this->Value[$i]);
					}
				}
			}
			else
			{
				while ($this->Value !== $fm->unmy_htmlentities($valStr))
				{
					$this->Value = $fm->unmy_htmlentities($valStr);
				}
			}
		}
		else
		{
			while ($valStr != $fm->unmy_htmlentities($valStr))
			{
				$valStr = $fm->unmy_htmlentities($valStr);
			}
			if (! is_array($this->Value))
			{
				$this->Value = array($this->Value);
			}
			array_push($this->Value,$valStr);
		}
	}

	function RequiresValidation()
	{
		if ($this->ValidationType == 'none')
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	function DoesFieldNameExist()
	{
		$mod = $this->form_ptr->module_ptr;

		// field name in use??
		if ($mod->GetPreference('unique_fieldnames','1') == '1' &&
		$this->form_ptr->HasFieldNamed($this->GetName()) != $this->Id)
		{
			return array(false,$mod->Lang('field_name_in_use',$this->GetName()).'<br />');
		}
		return array(true,'');
	}


	function DoesFieldHaveName()
	{
		$mod = $this->form_ptr->module_ptr;
		if ($mod->GetPreference('require_fieldnames','1') == '1' &&
		strlen($this->GetName()) < 1)
		{
			return array(false, $mod->Lang('field_no_name').'<br />');
		}
		return array(true,'');
	}

	// override me, if needed. Returns an array: first value is a true or
	// false (whether or not the value is valid), the second is a message
	function AdminValidate()
	{
		list($ret, $message) = $this->DoesFieldHaveName();
		if ($ret)
		{
			list($ret, $message) = $this->DoesFieldNameExist();
		}

		return array($ret, $message);
	}


	// override me if you're a Form Disposition pseudo-field.
	// This method can do just
	// about anything you want it to, in order to handle form contents.
	// it returns an array, where the first element is true on success,
	// or false on failure, and the second element is explanatory
	// text for the failure
	function DisposeForm($returnid)
	{
		return array(true, '');
	}

	function ExportXML($exportValues = false)
	{
		$xmlstr = "\t<field id=\"".$this->Id."\"\n";
		$xmlstr .= "\t\ttype=\"".$this->Type."\"\n";
		//$xmlstr .= "\t\tname=\"".htmlspecialchars($this->Name)."\"\n";
		$xmlstr .= "\t\tvalidation_type=\"".$this->ValidationType."\"\n";
		$xmlstr .= "\t\torder_by=\"".$this->OrderBy."\"\n";
		$xmlstr .= "\t\trequired=\"".$this->Required."\"\n";
		$xmlstr .= "\t\thide_label=\"".$this->HideLabel."\"\n";
		$xmlstr .= "\t\tdisplay_in_submission=\"".$this->DisplayInSubmission."\"";
		$xmlstr .= ">\n";
		$xmlstr .= "\t\t\t<field_name><![CDATA[".$this->Name."]]></field_name>\n";
		$xmlstr .= "\t\t\t<options>\n".$this->OptionsAsXML()."\t\t\t</options>\n";
		if ($exportValues)
		{
			$xmlstr .= "\t\t\t<human_readable_value><![CDATA[".
			$this->GetHumanReadableValue().
            "]]></human_readable_value>\n";
		}

		$xmlstr .= "</field>\n";
		return $xmlstr;
	}


	// override as necessary
	function OptionFromXML($theArray)
	{
		if ($theArray['name'] != 'option')
		{
			return;
		}
		if (! isset($this->Options))
		{
			$this->Options = array();
		}
		if (isset($this->Options[$theArray['attributes']['name']]))
		{
			if (! is_array($this->Options[$theArray['attributes']['name']]))
			{
				$this->Options[$theArray['attributes']['name']] = array($this->Options[$theArray['attributes']['name']]);
			}
			array_push($this->Options[$theArray['attributes']['name']], $theArray['content']);
		}
		else
		{
			//	$this->Options[$theArray['name']] = $theArray['attributes']['name'];
			$this->Options[$theArray['attributes']['name']] = $theArray['content'];
		}
	}

	// override as necessary
	function OptionsAsXML()
	{
		$xmlstr = "";
		foreach($this->Options as $name=>$value)
		{
			if (! is_array($value))
			{
				$value = array($value);
			}
			foreach ($value as $thisVal)
			{
				$xmlstr .= "\t\t\t<option name=\"$name\"><![CDATA[".$thisVal.
               "]]></option>\n";
			}
		}
		if (isset($this->Value))
		{
			if (! is_array($this->Value))
			{
				$thisVal = array($this->Value);
			}
			else
			{
				$thisVal = $this->Value;
			}
			foreach ($thisVal as $thisValOut)
			{
				$xmlstr .= "\t\t\t<value><![CDATA[".$thisValOut.
               "]]></value>\n";
			}
		}
		return  $xmlstr;
	}


	function ExportObject()
	{
		$obj = new stdClass();
		$obj->name = $this->Name;
		$obj->type = $this->Type;
		$obj->id = $this->Id;
		$obj->value = $this->GetHumanReadableValue(true);
		$obj->valueArray = $this->GetHumanReadableValue(false);
		return $obj;
	}


	function GetOptionNames()
	{
		return array_keys($this->Options);
	}

	function GetOption($optionName, $default='')
	{
		if (isset($this->Options[$optionName]))
		{
			return $this->Options[$optionName];
		}
		return $default;
	}

	function GetOptionRef($optionName)
	{
		if (isset($this->Options[$optionName]))
		{
	  return $this->Options[$optionName];
		}
		return false;
	}


	function RemoveOptionElement($optionName, $index)
	{
		if (isset($this->Options[$optionName]))
		{
			if (is_array($this->Options[$optionName]))
	  {
	  	if (isset($this->Options[$optionName][$index]))
	  	{
	  		array_splice($this->Options[$optionName],$index,1);
	  	}
	  }
		}
	}

	function GetOptionElement($optionName, $index, $default="")
	{
		if (isset($this->Options[$optionName]))
		{
			if (is_array($this->Options[$optionName]))
	  {
	  	if (isset($this->Options[$optionName][$index]))
	  	{
	  		return $this->Options[$optionName][$index];
	  	}
	  }
	  elseif ($index == 0)
	  {
	  	return $this->Options[$optionName];
	  }
		}

		return $default;
	}

	function SetOption($optionName, $optionValue)
	{
		$this->Options[$optionName] = $optionValue;
	}

	function PushOptionElement($optionName, $val)
	{
		if (isset($this->Options[$optionName]))
		{
			if (is_array($this->Options[$optionName]))
			{
				array_push($this->Options[$optionName],$val);
			}
			else
			{
				$this->Options[$optionName] = array($this->Options[$optionName],$val);
			}
		}
		else
		{
			$this->Options[$optionName] = $val;
		}
	}

	public function LoadField(&$params)
	{
		if ($this->Id > 0)
		{
			$this->Load($this->Id, $params, true);
		}
		return;
	}

	// loadDeep also loads all options for a field.
	public function Load($id, &$params, $loadDeep=false)
	{
		$sql = 'SELECT * FROM ' . cms_db_prefix() . 'module_fb_field WHERE field_id=?';
		if($result = $this->form_ptr->module_ptr->dbHandle->GetRow($sql, array($this->Id)))
		{
			if (strlen($this->Name) < 1)
			{
				$this->Name = $result['name'];
			}
			if (strlen($this->ValidationType) < 1)
			{
				$this->ValidationType = $result['validation_type'];
			}
			$this->Type = $result['type'];
			$this->OrderBy = $result['order_by'];
			if ($this->Required == -1)
			{
				$this->Required = $result['required'];
			}
			if ($this->HideLabel == -1)
			{
				$this->HideLabel = $result['hide_label'];
			}
		}
		else
		{
			return false;
		}
		$this->loaded = true;
		if ($loadDeep)
		{
			$sql = 'SELECT name, value FROM ' . cms_db_prefix() . 'module_fb_field_opt WHERE field_id=? ORDER BY option_id';
			$rs = $this->form_ptr->module_ptr->dbHandle->Execute($sql,
			array($this->Id));
			$tmpOpts = array();
			while ($rs && $results = $rs->FetchRow())
			{
				if (isset($tmpOpts[$results['name']]))
				{
					if (! is_array($tmpOpts[$results['name']]))
					{
						$tmpOpts[$results['name']] = array($tmpOpts[$results['name']]);
					}
					array_push($tmpOpts[$results['name']],$results['value']);
				}
				else
				{
					$tmpOpts[$results['name']]=$results['value'];
				}
			}
			$this->Options = array_merge($tmpOpts,$this->Options);

			if (isset($params['value_'.$this->Name]) && (is_array($params['value_'.$this->Name]) || strlen($params['value_'.$this->Name]) > 0))
			{
				$this->SetValue($params['value_'.$this->Name]);
			}
	
			if (isset($params['value_fld'.$this->Id]) && (is_array($params['value_fld'.$this->Id]) || strlen($params['value_fld'.$this->Id]) > 0))
			{
				$this->SetValue($params['value_fld'.$this->Id]);
			}
		}

		return true;
	}


	function Store($storeDeep=false)
	{
		$mod =  $this->form_ptr->module_ptr;
		if ($this->Id == -1)
		{
			$this->Id = $mod->dbHandle->GenID(cms_db_prefix().'module_fb_field_seq');
			$sql = 'INSERT INTO ' .cms_db_prefix().'module_fb_field (field_id, form_id, name, type, required, validation_type, hide_label, order_by) '.
				' VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
			$res = $mod->dbHandle->Execute($sql,
				array($this->Id, $this->FormId, $this->Name,$this->Type, ($this->Required?1:0),$this->ValidationType, $this->HideLabel, $this->OrderBy));
		}
		else
		{
			$sql = 'UPDATE '.cms_db_prefix().'module_fb_field set name=?, type=?, required=?, validation_type=?, order_by=?, hide_label=? where field_id=?';
			$res = $mod->dbHandle->Execute($sql,
				array($this->Name, $this->Type, ($this->Required?1:0),$this->ValidationType,$this->OrderBy, $this->HideLabel, $this->Id));
		}

		if ($storeDeep)
		{
			// drop old options
			$sql = 'DELETE FROM ' . cms_db_prefix() .'module_fb_field_opt where field_id=?';
			$res = $mod->dbHandle->Execute($sql,
			array($this->Id));

			foreach ($this->Options as $thisOptKey=>$thisOptValueList)
			{
				if (! is_array($thisOptValueList))
				{
					$thisOptValueList = array($thisOptValueList);
				}
				foreach ($thisOptValueList as $thisOptValue)
				{
					$optId = $mod->dbHandle->GenID(cms_db_prefix().'module_fb_field_opt_seq');
					$sql = 'INSERT INTO ' . cms_db_prefix().'module_fb_field_opt (option_id, field_id, form_id, '.'name, value) VALUES (?, ?, ?, ?, ?)';
					$res = $mod->dbHandle->Execute($sql,array($optId, $this->Id, $this->FormId, $thisOptKey,$thisOptValue));
				}
			}
		}
		return $res;
	}

	function Delete()
	{
		if ($this->Id == -1)
		{
			return false;
		}
		$sql = 'DELETE FROM ' . cms_db_prefix() . 'module_fb_field where field_id=?';
		$res = $this->form_ptr->module_ptr->dbHandle->Execute($sql,array($this->Id));
		$sql = 'DELETE FROM ' . cms_db_prefix() . 'module_fb_field_opt where field_id=?';
		$res = $this->form_ptr->module_ptr->dbHandle->Execute($sql,array($this->Id));
		return true;
	}
}

?>
