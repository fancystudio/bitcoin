<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

$aebrowser = new fbrBrowser($this, $params, true);
$this->buildBrowseNav($id,$params,$returnid,false);
$aebrowser->BrowserShowList($id, $returnid,$this, $params,'admin_list_fields',true);

$parms = array();
$parms['browser_id']=$aebrowser->GetId();
$parms['form_id']=$aebrowser->GetFormId();
$parms['fbrp_sort_field']=(isset($params['fbrp_sort_field'])?$params['fbrp_sort_field']:'');
$parms['fbrp_sort_dir']=(isset($params['fbrp_sort_dir'])?$params['fbrp_sort_dir']:'d');

$this->smarty->assign('form_start',$this->CreateFormStart($id, 'admin_delete_resp', $returnid, 'post', '', '', '', $parms));
$this->smarty->assign('delete',$this->CreateInputSubmit($id, 'delete', $this->Lang('delete'), '', '', $this->Lang('delete_selected_records')));
$this->smarty->assign('in_admin',1);
$this->smarty->assign('in_formbrowser',1);

echo $this->ProcessTemplateFromDatabase('fbr_alist_'.$aebrowser->GetId());
		
?>
