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
		if (isset($params['fbrp_apr']) && isset($params['response_id']))
			{
			$aebrowser->ApproveResponse($params);
			$this->smarty->assign('fbrp_message',$this->Lang('updated'));
			}
		else
			{
			$this->smarty->assign('fbrp_message','');
			}
		$this->buildBrowseNav($id,$params,$returnid,false);
		$aebrowser->BrowserShowList($id, $returnid,$this, $params,'admin_list_fields',true);

		echo $this->ProcessTemplate('admin_browse_list.tpl');
?>