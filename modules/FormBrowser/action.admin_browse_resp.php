<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

		$this->buildBrowseNav($id,$params,$returnid,false);
		$aebrowser = new fbrBrowser($this, $params, true);
		$aebrowser->LoadResponse($id,$this,$params,'admin_full_fields',true);

$parms = array();
$parms['browser_name']=$aebrowser->GetName();
$parms['record_id']=$params['response_id'];
$parms['side']='admin';
$this->SendEvent('OnFormBrowserRecordView',$parms);

$this->smarty->assign('in_admin',1);
$this->smarty->assign('in_formbrowser',1);
$this->smarty->assign('fbr_id',$params['response_id']);

echo $this->ProcessTemplate('admin_browse_resp.tpl'); //zmena sablony pre vykreslovanie objednavok
//echo $this->ProcessTemplateFromDatabase('fbr_afull_'.$aebrowser->GetId());

?>
