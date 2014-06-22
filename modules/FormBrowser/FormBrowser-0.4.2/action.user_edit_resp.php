<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

$aebrowser = new fbrBrowser($this, $params, true);

if ($aebrowser->GetAttr('allow_user_edit','0')=='0')
{
	echo "<p>" . $this->Lang('accessdenied') . "</p>";
	return false;
}

$fb = $this->GetModuleInstance('FormBuilder');

$params['form_id'] = $aebrowser->GetFormId();
$fb->DoAction('default', $id, $params, $returnid);
?>
