<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 * 
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;
$aeform = new fbForm($this, $params, true);

$aefield = $aeform->GetFieldById($params['field_id']);
if ($aefield !== false)
{
	$aefield->ToggleRequired();
	$aefield->Store();
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		exit;
	}
	$aeform = new fbForm($this, $params, true);
}
$tab = $this->GetActiveTab($params);

echo $aeform->AddEditForm($id, $returnid, $tab, $this->Lang('field_requirement_updated'));
?>