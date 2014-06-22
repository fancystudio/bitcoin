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
		
		$taboptarray = array('mysql' => 'TYPE=MyISAM');
		$dict = NewDataDictionary($db);
		
        $flds = "
        	browser_id I KEY,
			form_id I,
			name C(255),
			alias C(255)
			";
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_fbr_browser",
				$flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		$db->CreateSequence(cms_db_prefix()."module_fbr_browser_seq");

		
		$flds = "
			browser_attr_id I KEY,
			browser_id I,
			name C(35),
			value X
		";
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fbr_browser_attr',
			$flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		$db->CreateSequence(cms_db_prefix()."module_fbr_browser_attr_seq");

		$this->CreatePermission('Modify Browsers','Modify Form Browsers');

		$this->CreateEvent( 'OnFormBrowserRecordEdit' );
		$this->CreateEvent( 'OnFormBrowserRecordDelete' );
		$this->CreateEvent( 'OnFormBrowserRecordAdd' );
		$this->CreateEvent( 'OnFormBrowserRecordView' );
		$this->CreateEvent( 'OnFormBrowserRecordEditPostSave' );
		$this->CreateEvent( 'OnFormBrowserRecordAddPostSave' );



		$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
?>