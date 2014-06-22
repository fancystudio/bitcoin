<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (!$this->CheckAccess()) exit;
$parms = array();

if (isset($params['response_id'])) {

	// Delete responses
	$aebrowser = new fbrBrowser($this, $params, true);
	$aebrowser->DeleteResponse($params);

	// Send event
	$parms['browser_name']=$aebrowser->GetName();
	$parms['record_id']=$params['response_id'];
	$parms['side']='admin';
	$this->SendEvent('OnFormBrowserRecordDelete',$parms);

	// Set message
	unset($parms);
	$parms['module_message'] = $this->Lang('message_responses_deleted', count($params['response_id']));	
	
} else {

	// Set error message
	$parms['module_error'] = $this->Lang('message_nothing_deleted');
}

$parms['browser_id'] = $params['browser_id'];
$this->Redirect($id, 'admin_browse', $returnid, $parms);


?>
