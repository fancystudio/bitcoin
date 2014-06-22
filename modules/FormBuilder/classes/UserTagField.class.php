<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbUserTagField extends  fbFieldBase
{

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'UserTagField';
    $this->IsDisposition = false;
    $this->NonRequirableField = true;
    $this->DisplayInForm = true;
    $this->DisplayInSubmission = false;
    $this->sortable = false;
  }

  function StatusInfo()
  {
    $mod=$this->form_ptr->module_ptr;
    return $this->GetOption('udtname',$mod->Lang('unspecified'));
  }

	function GetFieldInput($id, &$params, $returnid)
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

    global $gCms;
    $usertagops = $gCms->GetUserTagOperations();
    $udt = $this->GetOption('udtname');
    $res = $usertagops->CallUserTag( $udt, $params);

    if( $res === FALSE )
      {
	   return $mod->Lang('error_usertag', $udt);
      }
    return $res;
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

}

?>
