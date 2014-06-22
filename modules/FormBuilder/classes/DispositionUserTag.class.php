<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbDispositionUserTag extends  fbFieldBase 
{

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'DispositionUserTag';
    $this->IsDisposition = true;
    $this->NonRequirableField = true;
    $this->DisplayInForm = false;
    $this->DisplayInSubmission = false;
    $this->sortable = false;
  }

  function StatusInfo()
  {
    $mod=$this->form_ptr->module_ptr;
    return $this->GetOption('udtname',$mod->Lang('unspecified'));
  }

  function DisposeForm($returnid)
  {
    $mod=$this->form_ptr->module_ptr;
    $others = $this->form_ptr->GetFields();
    $unspec = $this->form_ptr->GetAttr('unspecified',$mod->Lang('unspecified'));
    $params = array();
    if ($this->GetOption('export_form','0') == '1')
      {
      $params['FORM'] = $this->form_ptr;
      }
    for($i=0;$i<count($others);$i++)
      {
	$replVal = '';
	if ($others[$i]->DisplayInSubmission())
	  {
	    $replVal = $others[$i]->GetHumanReadableValue();
	    if ($replVal == '')
	      {
		    $replVal = $unspec;
	      }
	  }
   $name = $others[$i]->GetVariableName();
	$params[$name] = $replVal;
	$id = $others[$i]->GetId();
	$params['fld_'.$id] = $replVal;
	$alias = $others[$i]->GetAlias();
	if (!empty($alias))
      {
	   $params[$alias] = $replVal;
	   }
   }

	$this->form_ptr->setFinishedFormSmarty();
    global $gCms;
    $usertagops = $gCms->GetUserTagOperations();
    $res = $usertagops->CallUserTag( $this->GetOption('udtname'), $params);

    if( $res === FALSE )
      {
	return array(false,$mod->Lang('error_usertag_disposition'));
      }
    return array(true,'');        
  }

  function PrePopulateAdminForm($formDescriptor)
  {
    $mod = $this->form_ptr->module_ptr;
    $main = array();
    $adv = array();

    global $gCms;
    $usertagops = $gCms->GetUserTagOperations();
    $usertags = $usertagops->ListUserTags();
    $usertaglist = array();
    foreach( $usertags as $key => $value )
      {
	$usertaglist[$value] = $key;
      }
    $main[] = array($mod->Lang('title_udt_name'),
		    $mod->CreateInputDropdown($formDescriptor,
					      'fbrp_opt_udtname',$usertaglist,-1,
					      $this->GetOption('udtname')));
      $main[] = array($mod->Lang('title_export_form_to_udt'),
			      $mod->CreateInputHidden($formDescriptor, 'fbrp_opt_export_form','0').
            		$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_export_form',
            		'1',$this->GetOption('export_form','0')));
    return array('main'=>$main,'adv'=>$adv);
  }

  function PostPopulateAdminForm(&$mainArray, &$advArray)
  {
    $this->HiddenDispositionFields($mainArray, $advArray);
  }
}

?>
