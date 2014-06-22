<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

		$aebrowser = new fbrBrowser($this, $params, true);

		if ($aebrowser->GetAttr('allow_user_delete','0')=='0')
		{
			echo "<p>" . $this->Lang('accessdenied') . "</p>";
			return false;
		}

		$this->buildBrowseNav($id,$params,$returnid,true);
		if (isset($params['response_id']))
			{
			$aebrowser->DeleteResponse($params);
			$this->smarty->assign('fbrp_message',$this->Lang('deleted'));
			$parms = array();
			$parms['browser_name']=$aebrowser->GetName();
			$parms['record_id']=$params['response_id'];
			$parms['side']='user';
			$this->SendEvent('OnFormBrowserRecordDelete',$parms);			
			}
		else
			{
			$this->smarty->assign('fbrp_message','');
			}
		$aebrowser->BrowserShowList($id, $returnid,$this, $params,'list_fields');

echo $this->ProcessTemplateFromDatabase('fbr_ulist_'.$aebrowser->GetId());
?>
