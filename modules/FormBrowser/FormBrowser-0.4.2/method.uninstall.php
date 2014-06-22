<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

		$db = $gCms->GetDb();
		$dict = NewDataDictionary($db);
		$sqlarray = $dict->DropTableSQL(cms_db_prefix().'module_fbr_browser');
		$dict->ExecuteSQLArray($sqlarray);

		$db->DropSequence(cms_db_prefix().'module_fbr_browser_seq');

		$sqlarray = $dict->DropTableSQL(cms_db_prefix().'module_fbr_browser_attr');
		$dict->ExecuteSQLArray($sqlarray);

		$db->DropSequence(cms_db_prefix().'module_fbr_browser_attr_seq');
		
		// remove the permissions
		$this->RemovePermission('Modify Browsers');
		
		$this->RemoveEvent( 'OnFormBrowserRecordEdit' );
		$this->RemoveEvent( 'OnFormBrowserRecordDelete' );
		$this->RemoveEvent( 'OnFormBrowserRecordAdd' );
		$this->RemoveEvent( 'OnFormBrowserRecordView' );
		

		$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));
?>