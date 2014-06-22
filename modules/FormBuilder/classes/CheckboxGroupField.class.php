<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbCheckboxGroupField extends fbFieldBase {

	var $boxCount;
	var $boxAdd;

	function __construct(&$form_ptr, &$params)
	{
        parent::__construct($form_ptr, $params);
        $mod = $form_ptr->module_ptr;
		$this->Type = 'CheckboxGroupField';
		$this->DisplayInForm = true;
		$this->HasAddOp = true;
		$this->HasDeleteOp = true;
		$this->NonRequirableField = false;
		$this->ValidationTypes = array();
        $this->boxAdd = 0;
        $this->hasMultipleFormComponents = true;
        $this->sortable = false;
	}

	// Count how many boxes we have
	function countBoxes()
	{
		$tmp = $this->GetOptionRef('box_name');
		if (is_array($tmp)) {
		
	        $this->boxCount = count($tmp);
		
		} elseif ($tmp !== false) {
	        
			$this->boxCount = 1;
	    } else {
			
			$this->boxCount = 0;
	    }
	}

	// Return status
    function StatusInfo()
	{
        $mod = $this->form_ptr->module_ptr;
		$this->countBoxes();
		$ret = $mod->Lang('boxes',$this->boxCount);
		 return $ret;
	}

	// Get add button
	function GetOptionAddButton()
	{
		$mod = $this->form_ptr->module_ptr;
		return $mod->Lang('add_checkboxes');
	}

	// Get delete button
	function GetOptionDeleteButton()
	{
		$mod = $this->form_ptr->module_ptr;
		return $mod->Lang('delete_checkboxes');
	}

	// Get input
	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$names = $this->GetOptionRef('box_name');
		$is_set = $this->GetOptionRef('box_is_set');
		$js = $this->GetOption('javascript','');
		if (! is_array($names))
			{
			$names = array($names);
			}	
		if (! is_array($is_set))
			{
			$is_set = array($is_set);
			}
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
			$thisBox->input = $mod->CreateInputCheckbox($id, 'fbrp__'.$this->Id.'[]', ($i+1),
				$check_val !== false?($i+1):'-1',$js.$this->GetCSSIdTag('_'.$i));

			array_push($fieldDisp, $thisBox);
			}			
		return $fieldDisp;
	}

	// Get Human readable value
	function GetHumanReadableValue($as_string=true)
	{
		$form = $this->form_ptr;
		
		// Init names
		$names = $this->GetOptionRef('box_name');
		if (! is_array($names)) {
		
				$names = array($names);
		}
		
		// Init checked boxes
		$checked = $this->GetOptionRef('box_checked');
		if (! is_array($checked)) {
		
			$checked = array($checked);
		}
		
		// Init unchecked boxes
		$unchecked = $this->GetOptionRef('box_unchecked');
		if (! is_array($unchecked)) {
		
			$unchecked = array($unchecked);
		}
		
		//$fieldLabels = array();
		$fieldRet = array();
		for ($i=1;$i<=count($names);$i++) {
		
			if ($this->FindArrayValue($i) === false) {
			
				if ($this->GetOption('no_empty','0') != '1' && isset($unchecked[$i-1]) && trim($unchecked[$i-1]) != '' ) {
				
					$fieldRet[$names[$i-1]] = $unchecked[$i-1];
				}
			} else {
				
				if( isset($checked[$i-1]) && trim($checked[$i-1]) != '' ) $fieldRet[$names[$i-1]] = $checked[$i-1];
			}
		}
		
		if ($as_string) {
			
			// Check if we should include labels
			if($this->GetOption('include_labels','0') == true) {
			
				$output = '';
				foreach($fieldRet as $key=>$value) {
				
					$output .= $key.': '.$value.$form->GetAttr('list_delimiter',',');
				
				}
			
				$output = substr($output,0,strlen($output)-1);
				return $output;
			}
			
			return join($form->GetAttr('list_delimiter',','),$fieldRet);
			
		} else {
		
			return $fieldRet;
		}
	}

	// Add action
	function DoOptionAdd(&$params)
	{
		$this->boxAdd = 1;
	}

	// Delete action
	function DoOptionDelete(&$params)
	{
		$delcount = 0;
		foreach ($params as $thisKey=>$thisVal)
			{
			if (substr($thisKey,0,9) == 'fbrp_del_')
				{
				$this->RemoveOptionElement('box_name', $thisVal - $delcount);
				$this->RemoveOptionElement('box_checked', $thisVal - $delcount);
				$this->RemoveOptionElement('box_unchecked', $thisVal - $delcount);
				$this->RemoveOptionElement('box_is_set', $thisVal - $delcount);
				$delcount++;
				}
			}
	}

	// Populate tabs
	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$yesNo = array($mod->Lang('no')=>'n',$mod->Lang('yes')=>'y');

		$this->countBoxes();
		if ($this->boxAdd > 0)
			{
			$this->boxCount += $this->boxAdd;
			$this->boxAdd = 0;
			}
			$boxes = '<table class="module_fb_table pagetable" cellpadding="0" cellspacing="0"><thead><tr><th>'.
			$mod->Lang('title_checkbox_label').'</th><th>'.
			$mod->Lang('title_checked_value').'</th><th>'.
			$mod->Lang('title_unchecked_value').'</th><th>'.
			$mod->Lang('title_default_set').'</th><th>'.
			$mod->Lang('title_delete').'</th></tr></thead><tbody>';

		$rowclass = 'row1';
		for ($i=0;$i<($this->boxCount>1?$this->boxCount:1);$i++)
			{
			$boxes .= '<tr class="'.$rowclass.'"><td>'.
            		$mod->CreateInputText($formDescriptor, 'fbrp_opt_box_name[]',$this->GetOptionElement('box_name',$i),25,128).
            		'</td><td>'.
            		$mod->CreateInputText($formDescriptor, 'fbrp_opt_box_checked[]',$this->GetOptionElement('box_checked',$i),25,128).
            		'</td><td>'.
            		$mod->CreateInputText($formDescriptor, 'fbrp_opt_box_unchecked[]',$this->GetOptionElement('box_unchecked',$i),25,128).
            		'</td><td>'.            		    
            		$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_box_is_set[]', $yesNo, -1, $this->GetOptionElement('box_is_set',$i)).	
            		'</td><td>'.
            		$mod->CreateInputCheckbox($formDescriptor, 'fbrp_del_'.$i, $i,-1).
             		'</td></tr>';
					
			($rowclass == 'row1'?$rowclass='row2':$rowclass='row1');
			}
		$boxes .= '</tbody></table>';
		
		$main = array(
			array($mod->Lang('title_dont_submit_unchecked'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_no_empty','0').
						$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_no_empty','1',$this->GetOption('no_empty','0')).$mod->Lang('title_dont_submit_unchecked_help')),
			array($mod->Lang('title_checkbox_details'),$boxes)
		);
		
		$adv = array(
			array($mod->Lang('title_field_includelabels'),$mod->CreateInputHidden($formDescriptor,'fbrp_opt_include_labels','0').
						$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_include_labels','1',$this->GetOption('include_labels','0')).$mod->Lang('title_field_includelabels_help'))
		);
		
		return array('main'=>$main,'adv'=>$adv);
	}


	// Before admin submit do cleanup
	function PostAdminSubmitCleanup()
	{
		$names = $this->GetOptionRef('box_name');
		$checked = $this->GetOptionRef('box_checked');
		$unchecked = $this->GetOptionRef('box_unchecked');
		$is_set = $this->GetOptionRef('box_is_set');
		for ($i=0;$i<count($names);$i++)
			{
			if ($names[$i] == '' && $checked[$i] == '' )
				{
				$this->RemoveOptionElement('box_name', $i);
				$this->RemoveOptionElement('box_checked', $i);
				$this->RemoveOptionElement('box_unchecked', $i);
				$this->RemoveOptionElement('box_is_set', $i);
				$i--;
				}
			}
		$this->countBoxes();
	}
	
} // End of Class

?>
