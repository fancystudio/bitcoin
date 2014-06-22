<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbRadioGroupField extends fbFieldBase 
{

  var $optionCount;
  var $optionAdd;
	
  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'RadioGroupField';
    $this->DisplayInForm = true;
    $this->HasAddOp = true;
    $this->HasDeleteOp = true;
    $this->NonRequirableField = false;
    $this->ValidationTypes = array(
            );
    $this->optionAdd = 0;
    $this->hasMultipleFormComponents = true;

  }

  function countBoxes()
  {
    $tmp = $this->GetOptionRef('button_name');
    if (is_array($tmp))
      {
	$this->optionCount = count($tmp);
      }
    elseif ($tmp !== false)
      {
	$this->optionCount = 1;
      }
    else
      {
	$this->optionCount = 0;
      }
  }

  function StatusInfo()
  {
    $mod = $this->form_ptr->module_ptr;
    $this->countBoxes();
    $ret = $mod->Lang('options',$this->optionCount);
    if (strlen($this->ValidationType)>0)
      {
	$ret .= ", ".array_search($this->ValidationType,$this->ValidationTypes);
      }
    return $ret;
  }

  function GetOptionAddButton()
  {
    $mod = $this->form_ptr->module_ptr;
    return $mod->Lang('add_options');
  }

  function GetOptionDeleteButton()
  {
    $mod = $this->form_ptr->module_ptr;
    return $mod->Lang('delete_options');
  }

  function GetFieldInput($id, &$params, $returnid)
  {
    $mod = $this->form_ptr->module_ptr;
    $names = $this->GetOptionRef('button_name');
    $is_set = $this->GetOptionRef('button_is_set');
	$js = $this->GetOption('javascript','');

    $fieldDisp = array();
    for ($i=0;$i<count($names);$i++)
      {
	$label = '';
	$thisBox = new stdClass();
	if (strlen($names[$i]) > 0)
	  {
	    $thisBox->name = '<label for="'.$this->GetCSSId('_'.$i).'">'.$names[$i].'</label>';
	    $thisBox->title = $names[$i];
	  }
	$check_val = false;
	if ($this->Value !== false)
	  {
	    $check_val = $this->FindArrayValue($i+1);
	  }
	else
	  {
	    if (isset($is_set[$i]) && $is_set[$i] == 'y')
	      {
		$check_val = true;
	      }				
	  }
	$thisBox->input = '<input type="radio" name="'.$id.'fbrp__'.$this->Id.'" value="'.($i+1).'"';
	if ($check_val)
	  {
	    $thisBox->input .= ' checked="checked"';
	  }
	$thisBox->input .= $js.$this->GetCSSIdTag('_'.$i).' />';
	array_push($fieldDisp, $thisBox);
      }
    return $fieldDisp;
  }

  function GetHumanReadableValue($as_string=true)
  {
    $mod = $this->form_ptr->module_ptr;
    if ($this->HasValue())
      {
	   $ret = $this->GetOptionElement('button_checked',($this->Value - 1));
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


  function DoOptionAdd(&$params)
  {
    $this->optionAdd = 1;
  }

  function DoOptionDelete(&$params)
  {
    $delcount = 0;
    foreach ($params as $thisKey=>$thisVal)
      {
	if (substr($thisKey,0,9) == 'fbrp_del_')
	  {
	    $this->RemoveOptionElement('button_name', $thisVal - $delcount);
	    $this->RemoveOptionElement('button_checked', $thisVal - $delcount);
	    $this->RemoveOptionElement('button_is_set', $thisVal - $delcount);
	    $delcount++;
	  }
      }
  }


  function PrePopulateAdminForm($formDescriptor)
  {
    $mod = $this->form_ptr->module_ptr;
    $yesNo = array($mod->Lang('no')=>'n',$mod->Lang('yes')=>'y');

    $this->countBoxes();
    if ($this->optionAdd > 0)
      {
	$this->optionCount += $this->optionAdd;
	$this->optionAdd = 0;
      }
    $boxes = '<table class="pagetable module_fb_table"><tr><th>'.$mod->Lang('title_radio_label').'</th><th>'.
      $mod->Lang('title_checked_value').'</th><th>'.
      $mod->Lang('title_default_set').'</th><th>'.
      $mod->Lang('title_delete').
      '</th></tr>';

	$odd = false;
    for ($i=0;$i<($this->optionCount>1?$this->optionCount:1);$i++)
      {
	$boxes .= '<tr class="'.($odd?'row1':'row2').'"><td>'.
	  $mod->CreateInputText($formDescriptor, 'fbrp_opt_button_name[]',$this->GetOptionElement('button_name',$i),25,128).
	  '</td><td>'.
	  $mod->CreateInputText($formDescriptor, 'fbrp_opt_button_checked[]',$this->GetOptionElement('button_checked',$i),25,128).
	  '</td><td>'.
	  $mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_button_is_set[]', $yesNo, -1, $this->GetOptionElement('button_is_set',$i)).
	  '</td><td>'.
	  $mod->CreateInputCheckbox($formDescriptor, 'fbrp_del_'.$i, $i,-1).
	  '</td></tr>';
	  
	  $odd = !$odd;
      }
    $boxes .= '</table>';
    $main = array(
		  array($mod->Lang('title_radiogroup_details'),$boxes)
		  );
    $adv = array();
    return array('main'=>$main,'adv'=>$adv);
  }


  function PostAdminSubmitCleanup()
  {
    $names = $this->GetOptionRef('button_name');
    $checked = $this->GetOptionRef('button_checked');
    for ($i=0;$i<count($names);$i++)
      {
	if ($names[$i] == '' && $checked[$i] == '' )
	  {
	    $this->RemoveOptionElement('button_name', $i);
	    $this->RemoveOptionElement('button_checked', $i);
	    $this->RemoveOptionElement('button_is_set', $i);
	    $i--;
	  }
      }
    $this->countBoxes();
  }
}

?>
