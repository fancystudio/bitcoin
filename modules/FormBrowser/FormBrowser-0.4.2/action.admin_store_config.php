<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

	$this->SetPreference('date_format',$params['fbrp_date_format']);
	$this->SetPreference('strip_on_export',$params['fbrp_strip_on_export']);
	$this->SetPreference('export_file',$params['fbrp_export_file']);
	$this->SetPreference('export_file_encoding',$params['fbrp_export_file_encoding']);
	$this->SetPreference('suppress_email_on_edit',$params['fbrp_suppress_email_on_edit']);

    $params['fbrp_message'] = $this->Lang('prefs_updated');
    $this->DoAction('defaultadmin', $id, $params);

?>
