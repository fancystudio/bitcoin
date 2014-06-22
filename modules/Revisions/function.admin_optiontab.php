<?php
#-------------------------------------------------------------------------
#
# Author: Lukas Blatter, <lb@blattertech.ch>
# Web: www.blattertech.ch
#
#-------------------------------------------------------------------------
#
# Revisions is a CMS Made Simple module that logs changes in content, CSS,
# GCBs and enables the web developer to revert to earlier versions of it. 
#
#-------------------------------------------------------------------------

// TODO: Use Datetime Picker for delete_older_than field

if (!$this->CheckPermission('revisions_options'))
	return;

$smarty->assign('startform', $this->CreateFormStart($id, 'updateoptions', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());

$smarty->assign('input_store_revisions_count', $this->CreateInputNumber($id, 'store_revisions_count', $this->GetPreference('store_revisions_count', '0'), 'min="0" max="100"'));
$smarty->assign('input_delete_revisions_with_content', $this->CreateInputCheckbox($id, 'delete_revisions_with_content', '1', $this->GetPreference('delete_revisions_with_content', '0')));
$smarty->assign('input_delete_all_but', $this->CreateInputNumber($id, 'delete_all_but', 20, 'min="1"'));
$smarty->assign('submit_delete_all_but', $this->CreateInputSubmit($id, 'deleteallbutsubmit', $this->Lang('delete')));
$smarty->assign('input_delete_older_than', $this->CreateInputText($id, 'delete_older_than', date('Y-m-d', strtotime('6 months ago')), 20, 10));
$smarty->assign('submit_delete_older_than', $this->CreateInputSubmit($id, 'deleteolderthansubmit', $this->Lang('delete')));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'optionssubmit', $this->Lang('submit')));

echo $this->ProcessTemplate('optiontab.tpl');
?>