<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

if (isset($params['fbrp_cancel'])) {

	$this->Redirect($id, 'defaultadmin', $returnid);
}

// Store data
$aeform = new fbForm($this, $params, true);
$aeform->Store();

$tab = $this->GetActiveTab($params);

// Check which button was pressed
if ($params['fbrp_submit'] == $this->Lang('save')) {

    $params['fbrp_message'] = $this->Lang('form',$params['fbrp_form_op']);
    $this->DoAction('defaultadmin', $id, $params);
	
} else {

	echo $aeform->AddEditForm($id, $returnid, $tab, $this->Lang('form',$params['fbrp_form_op']));
}

?>
