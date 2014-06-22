<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbDispositionPageRedirector extends fbFieldBase {

	var $addressCount;
	var $addressAdd;

	function __construct(&$form_ptr, &$params)
	{
 		parent::__construct($form_ptr, $params);
        $mod = $form_ptr->module_ptr;
		$this->Type = 'DispositionPageRedirector';
		$this->DisplayInForm = true;
		$this->NonRequirableField = false;
		$this->IsDisposition = true;
		$this->HasAddOp = true;
		$this->HasDeleteOp = true;
		$this->ValidationTypes = array(
       		);
       	$this->addressAdd = 0;
	}

	function GetOptionAddButton()
	{
		$mod = $this->form_ptr->module_ptr;
		return $mod->Lang('add_destination');
	}

	function GetOptionDeleteButton()
	{
		$mod = $this->form_ptr->module_ptr;
		return $mod->Lang('delete_destination');
	}

	function DoOptionAdd(&$params)
	{
		$this->addressAdd = 1;
	}

	function DoOptionDelete(&$params)
	{
		$delcount = 0;
		foreach ($params as $thisKey=>$thisVal)
			{
			if (substr($thisKey,0,9) == 'fbrp_del_')
				{
				$this->RemoveOptionElement('destination_page', $thisVal - $delcount);
				$this->RemoveOptionElement('destination_subject', $thisVal - $delcount);
				$delcount++;
				}
			}
	}

	function countAddresses()
	{
			$tmp = $this->GetOptionRef('destination_page');
			if (is_array($tmp))
				{
	        	$this->addressCount = count($tmp);
	        	}
	        elseif ($tmp !== false)
	        	{
	        	$this->addressCount = 1;
	        	}
	        else
	        	{
	        	$this->addressCount = 0;
	        	}
	}

	function GetFieldInput($id, &$params, $returnid)
	{
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
		$subjects = $this->GetOptionRef('destination_subject');

		if (count($subjects) > 1)
			{
			for($i=0;$i<count($subjects);$i++)
				{
				$sorted[$subjects[$i]]=($i+1);
				}
			}
		else
			{
			$sorted[$subjects] = '1';
			}
		return $mod->CreateInputDropdown($id, 'fbrp__'.$this->Id, $sorted, -1, $this->Value, $js.$this->GetCSSIdTag());
	}



    function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		$opt = $this->GetOption('destination_page','');
		
		if (is_array($opt))
		  {
		      $num = count($opt);
		  }
		elseif ($opt != '')
			{
			$num = 1;
			}
		else
		  {
          $num = 0;
          }
         $ret= $mod->Lang('destination_count',$num);
      //  $ret.= $this->TemplateStatus();
        return $ret;
	}
	
	function PrePopulateAdminForm($formDescriptor)
	{
   		global $gCms;
		global $id;
    		$contentops = $gCms->GetContentOperations();
		$mod = $this->form_ptr->module_ptr;

		$this->countAddresses();
		if ($this->addressAdd > 0)
			{
			$this->addressCount += $this->addressAdd;
			$this->addressAdd = 0;
			}
		$dests = '<table class="module_fb_table"><tr><th>'.$mod->Lang('title_selection_subject').'</th><th>'.
			$mod->Lang('title_destination_page').'</th><th>'.
			$mod->Lang('title_delete').'</th></tr>';


		for ($i=0;$i<($this->addressCount>1?$this->addressCount:1);$i++)
			{
			$dests .=  '<tr><td>';
            		$dests .= $mod->CreateInputText($formDescriptor, 'fbrp_opt_destination_subject[]',$this->GetOptionElement('destination_subject',$i),25,128);
            		$dests .= '</td><td>';
			$dests .=     			$contentops->CreateHierarchyDropdown('',$this->GetOptionElement('destination_page',$i), $id.'fbrp_opt_destination_page[]');
			$dests .= '</td><td>';
            		$dests .= $mod->CreateInputCheckbox($formDescriptor, 'fbrp_del_'.$i, $i,-1);
             		$dests .= '</td></tr>';
            		//$mod->CreateInputText($formDescriptor, 'opt_destination_page[]',$this->GetOptionElement('destination_page',$i),25,128).

			}
		$dests .= '</table>';
		// list($main,$adv) = $this->PrePopulateAdminFormBase($formDescriptor);
		$adv = array();
		$main = array();
		array_push($main,array($mod->Lang('title_select_one_message'),
			$mod->CreateInputText($formDescriptor, 'fbrp_opt_select_one',
			$this->GetOption('select_one',$mod->Lang('select_one')),25,128)));

		array_push($main,array($mod->Lang('title_director_details'),$dests));
		return array('main'=>$main,'adv'=>$adv);
	}

	function PostPopulateAdminForm(&$mainArray, &$advArray)
	{
      $this->HiddenDispositionFields($mainArray, $advArray);
	}

	function GetHumanReadableValue($as_string)
	{
		$mod = $this->form_ptr->module_ptr;
		if ($this->HasValue())
			{
			$ret = $this->GetOptionElement('destination_page',($this->Value - 1));
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
		// If needed, make sure other dispositions get run 1st.See  Dispose($returnid) in Form class.
		// Not really needed, the 'FromEmailAddressField' already calls modify other fields, Just need to make sure the the email results things are listed before this one and everything should be fine.
		// print_r($this->GetOptionElement('destination_page',($this->Value - 1)));
    		global $gCms;
    		$mod = $this->form_ptr->module_ptr;
    		$mod->RedirectContent($this->GetOptionElement('destination_page',($this->Value - 1)));
		//return $this->SendForm($this->GetOptionElement('destination_page',($this->Value - 1)),
		//	$this->GetOptionElement('destination_subject',($this->Value - 1)));
		return array(true, 'everything worked');
	}


	function AdminValidate()
	{
		$mod = $this->form_ptr->module_ptr;
    		$opt = $this->GetOption('destination_page');
  		list($ret, $message) = $this->DoesFieldHaveName();
		if ($ret)
			{
			list($ret, $message) = $this->DoesFieldNameExist();
			}		
		if (count($opt) == 0)
			{
			$ret = false;
			$message .= $mod->Lang('must_specify_one_destination').'</br>';
			}
	        return array($ret,$message);
    }

}
?>
