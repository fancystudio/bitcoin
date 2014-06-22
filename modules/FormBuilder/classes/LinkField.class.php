<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbLinkField extends fbFieldBase {

	function __construct(&$form_ptr, &$params)
	{
        parent::__construct($form_ptr, $params);
        $mod = $form_ptr->module_ptr;
		$this->Type =  'LinkField';
		$this->DisplayInForm = true;
		$this->NonRequirableField = true;
		$this->Required = false;
		$this->ValidationTypes = array(
            $mod->Lang('validation_none')=>'none'
            );
      $this->hasMultipleFormComponents = true;
	}

	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');
		
		if ($this->Value !== false && is_array($this->Value))
			{
			$val = $this->Value;
			}
		else
			{
			$val = array($this->GetOption('default_link',''),$this->GetOption('default_link_title',''));
			} 
		$fieldDisp = array();
		$thisBox = new stdClass();
		$thisBox->name = '<label for="'.$id.'fbrp__'.$this->Id.'_1">'.$mod->Lang('link_destination').'</label>';
		$thisBox->title = $mod->Lang('link_destination');
		$thisBox->input = $mod->CreateInputText($id, 'fbrp__'.$this->Id.'[]', $val[0], 10, 255, $js);
		array_push($fieldDisp, $thisBox);
		$thisBox = new stdClass();
		$thisBox->name = '<label for="'.$id.'fbrp__'.$this->Id.'_2">'.$mod->Lang('link_label').'</label>';
		$thisBox->title = $mod->Lang('link_label');
		$thisBox->input = $mod->CreateInputText($id, 'fbrp__'.$this->Id.'[]', $val[1], 10, 255, $js);
		array_push($fieldDisp, $thisBox);			
		return $fieldDisp;
	}

	function GetHumanReadableValue($as_string=true)
	{
		$mod = $this->form_ptr->module_ptr;

		if ($this->Value === false || ! is_array($this->Value))
			{
			$ret = '';
			}
		else
			{
			$ret = '<a href="'.$this->Value[0].'">'.$this->Value[1].'</a>';
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


	function PostPopulateAdminForm(&$mainArray, &$advArray)
	{
		$mod = $this->form_ptr->module_ptr;
		// remove the "required" field, since this can only be done via validation
      $this->RemoveAdminField($mainArray, $mod->Lang('title_field_required'));
	}


	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$main = array(
             array($mod->Lang('title_default_link'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_default_link',$this->GetOption('default_link',''),25,128)),
             array($mod->Lang('title_default_link_title'),$mod->CreateInputText($formDescriptor, 'fbrp_opt_default_link_title',$this->GetOption('default_link_title',''),25,128))
		);
		$adv = array(
		);
		return array('main'=>$main,'adv'=>$adv);
	}

}
?>