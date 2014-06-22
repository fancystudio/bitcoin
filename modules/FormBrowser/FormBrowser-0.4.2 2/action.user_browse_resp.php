<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

if (isset($params['browser']) && ! isset($params['browser_alias']))
	{
	$params['browser_alias']=$params['browser'];
	$params['load']=true;
	}

$br = new fbrBrowser($this, $params, true);
$br->LoadResponse($id,$this,$params,'full_fields');
$this->buildBrowseNav($id,$params,$returnid,true);
$parms = array();
$parms['browser_name']=$br->GetName();
$parms['record_id']=$params['response_id'];
$parms['side']='user';
$this->SendEvent('OnFormBrowserRecordView',$parms);

$this->smarty->assign('in_admin',0);
$this->smarty->assign('in_formbrowser',1);
$this->smarty->assign('fbr_id',$params['response_id']);

echo $this->ProcessTemplateFromDatabase('fbr_ufull_'.$br->GetId());

?>
