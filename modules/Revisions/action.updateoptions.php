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

if (!$this->CheckPermission('revisions_use'))
	return;

$parms = array('active_tab' => 'optiontab');
$db = cmsms()->GetDb();
if(isset($params['deleteallbutsubmit']))
{
	$this->DeleteAllRevisionsBut($params['delete_all_but']);
	$parms['message'] = 'revisionsdeleted';
}
elseif(isset($params['deleteolderthansubmit']))
{
	$dbresult = $db->Execute('SELECT DISTINCT revision_id FROM ' . cms_db_prefix() . 'module_revisions WHERE create_time < ?', array(date('Y-m-d H:i:s', strtotime($params['delete_older_than']))));
	while($dbresult && $row = $dbresult->FetchRow())
	{
		$db->Execute('DELETE FROM ' . cms_db_prefix() . 'module_revisions WHERE revision_id = ?', array($row['revision_id']));
		$db->Execute('DELETE FROM ' . cms_db_prefix() . 'module_revisions_diff WHERE revision_id = ?', array($row['revision_id']));
	}
	$parms['message'] = 'revisionsdeleted';
}
else
{
	$this->SetPreference('store_revisions_count', $params['store_revisions_count']);

	$delete_revisions_with_content = isset($params['delete_revisions_with_content']) ? '1' : '0';
	$this->SetPreference('delete_revisions_with_content', $delete_revisions_with_content);
	// when activated, delete orphaned data
	if($delete_revisions_with_content == 1)
	{
		$this->voidRecycleBin();
	}
	$parms['message'] = 'optionsupdated';
}

$this->Redirect($id, 'defaultadmin', '', $parms);
?>