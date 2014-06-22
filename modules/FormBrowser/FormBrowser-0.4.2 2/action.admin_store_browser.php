<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

if (isset($params['cancel'])) {

	$this->Redirect($id, 'defaultadmin', $returnid);
}

        $aebrowser = new fbrBrowser($this, $params, true);

		$tab = $this->GetActiveTab($params);
		
        $aebrowser->Store();
        if (isset($params['fbrp_submit']) && $params['fbrp_submit'] == $this->Lang('save'))
            {
            $params['fbrp_message'] = $this->Lang('browser',$params['fbrp_browser_op']);
            $this->DoAction('defaultadmin', $id, $params);
            }
        else
        	{
			$this->buildBrowseNav($id,$params,$returnid,false);
			echo $aebrowser->AddEditBrowser($id, $returnid,$tab,$this->Lang('browser',$params['fbrp_browser_op']));
			}
?>
