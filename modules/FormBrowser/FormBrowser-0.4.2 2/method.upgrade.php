<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

switch($oldversion)
{
	case '0.1':
	case '0.2':
	case '0.3':
		$this->CreateEvent( 'OnFormBrowserRecordEditPostSave' );
		$this->CreateEvent( 'OnFormBrowserRecordAddPostSave' );
	case '0.3.1':
	case '0.3.2':
	case '0.4':
	case '0.4.1':
		
}

// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('upgraded',$this->GetVersion()));
?>