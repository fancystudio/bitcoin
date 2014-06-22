<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

        $aeform = new fbForm($this, $params, true);
        $srcIndex = $aeform->GetFieldIndexFromId($params['field_id']);
        if ($params['fbrp_dir'] == 'up')
            {
            $destIndex = $srcIndex - 1;
            }
        else
            {
            $destIndex = $srcIndex + 1;
            }
        $aeform->SwapFieldsByIndex($srcIndex,$destIndex);

		// force reload of form, this is kinda hackish but cant think of anything else ;)
		$aeform = new fbForm($this, $params, true);
		$tab = $this->GetActiveTab($params);


        echo $aeform->AddEditForm($id, $returnid, $tab, $this->ShowMessage($this->Lang('field_order_updated')));
?>