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

if (isset($params['message'])) {
	echo $this->ShowMessage($this->Lang($params['message']));
}

if (isset($params['errors']) && count($params['errors'])) {
	echo $this->ShowErrors($params['errors']);
}

$admintheme = cmsms()->get_variable('admintheme');
$db = cmsms()->GetDb();

$module_name = isset($params['module_name']) ? $params['module_name'] : '';

$previewoptions = array();
$dbparams = array();
switch($module_name)
{
	default:
		return;

	case 'content':
		$previewoptions['disable_theme'] = 1;
		$dbparams[] = $params['module_name'];
		$query = 'SELECT a.revision_id as revision_id, a.revision_nr as revision_nr, b.content_name AS name, a.create_time, c.username FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'content b, ' . cms_db_prefix() . 'users c WHERE a.module_name = ? AND a.content_id = ? AND a.content_id = b.content_id AND a.user_id = c.user_id GROUP BY a.revision_id ORDER BY a.revision_id desc';
		break;

	case 'gcb':
		$dbparams[] = $params['module_name'];
		$query = 'SELECT a.revision_id as revision_id, a.revision_nr as revision_nr, b.htmlblob_name AS name, a.create_time, c.username FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'htmlblobs b, ' . cms_db_prefix() . 'users c WHERE a.module_name = ? AND a.content_id = ? AND a.content_id = b.htmlblob_id AND a.user_id = c.user_id GROUP BY a.revision_id ORDER BY a.revision_id desc';
		break;

	case 'template':
		$dbparams[] = $params['module_name'];
		$query = 'SELECT a.revision_id as revision_id, a.revision_nr as revision_nr, b.template_name AS name, a.create_time, c.username FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'templates b, ' . cms_db_prefix() . 'users c WHERE a.module_name = ? AND a.content_id = ? AND a.content_id = b.template_id AND a.user_id = c.user_id GROUP BY a.revision_id ORDER BY a.revision_id desc';
		break;

	case 'stylesheet':
		$dbparams[] = $params['module_name'];
		$query = 'SELECT a.revision_id as revision_id, a.revision_nr as revision_nr, b.css_name AS name, a.create_time, c.username FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'css b, ' . cms_db_prefix() . 'users c WHERE a.module_name = ? AND a.content_id = ? AND a.content_id = b.css_id AND a.user_id = c.user_id GROUP BY a.revision_id ORDER BY a.revision_id desc';
		break;

	case 'recycle':
		$dbparams[] = $params['recycle_module_name'];
		$query = 'SELECT a.revision_id as revision_id, a.module_name as module_name, a.revision_nr as revision_nr, b.content_name AS name, a.create_time, c.username FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'module_revisions_recycle b, ' . cms_db_prefix() . 'users c WHERE a.module_name = ? AND a.content_id = ? AND a.content_id = b.content_id AND a.user_id = c.user_id GROUP BY a.revision_id ORDER BY a.revision_id desc';
		break;
}
$dbparams[] = $params['content_id'];
$dbresult = $db->Execute($query, $dbparams);

$name = "";

// PREPARE ALL REVISIONS FOR LISTING
$revisions = array();
while($dbresult && $row = $dbresult->FetchRow())
{
	if ($name == "") $name = $row['name'];
	
	$previewoptions['revision_id'] = $row['revision_id'];
	$previewoptions['name'] = $row['name'];
	if (isset($row['module_name']) and $row['module_name'] == 'content') $previewoptions['disable_theme'] = 1;
	
	
	$row['previewlink'] = $this->CreateLink($id, 'admin_preview', $returnid, $admintheme->DisplayImage('icons/system/view.gif', $this->Lang('preview'), '', '', 'systemicon'), 
		$previewoptions, '', false, false, (isset($previewoptions['disable_theme'])?'target="_blank" class="popup"':''));
	$row['restorelink'] = $this->CreateLink($id, 'restore', $returnid, $admintheme->DisplayImage('icons/system/export.gif', $this->Lang('restore'), '', '', 'systemicon'),
		array(
			'revision_id' => $row['revision_id']
		));
	$row['comparelink'] = $this->CreateLink($id, 'admin_compare', $returnid, $admintheme->DisplayImage('icons/system/copy.gif', $this->Lang('compare_tooltip'), '', '', 'systemicon'),
		array(
			'revision_id' => $row['revision_id'], 'name' => $row['name'], 'module_name' => $params['module_name']
		));
	$revisions[] = RevisionsUtils::array_to_object($row);
}

//if($params['module_name'] == 'recycle')
//{
//	if ($name == "") $name = $row['name'];
//	
//	// LIST LAST ACTIVE VERSION AT THE BOTTOM
//	$dbresult = $db->Execute('SELECT a.content_name AS name, a.create_time, b.username FROM ' . cms_db_prefix() . 'module_revisions_recycle a, ' . cms_db_prefix() . 'users b WHERE a.module_name = ? AND a.content_id = ? AND a.user_id = b.user_id', $dbparams);
//	$row = $dbresult->FetchRow();
//	$linkparams = array();
//	$linkparams['revision_id'] = -1;
//	$linkparams['revision_nr'] = $row['revision_nr'];
//	$linkparams['name'] = $row['name'];
//	$linkparams['module_name'] = $params['recycle_module_name'];
//	$linkparams['content_id'] = $params['content_id'];
//	$row['previewlink'] = $this->CreateLink($id, 'admin_preview', $returnid, $admintheme->DisplayImage('icons/system/view.gif', $this->Lang('preview'), '', '', 'systemicon'), 
//		$linkparams, '', false, false, (isset($previewoptions['disable_theme'])?'target="_blank" class="popup"':''));
//	$row['restorelink'] = $this->CreateLink($id, 'restore', $returnid, $admintheme->DisplayImage('icons/system/export.gif', $this->Lang('restore'), '', '', 'systemicon'), $linkparams);
//	$row['comparelink'] = '';
//	$revisions[] = RevisionsUtils::array_to_object($row);
//}


$smarty->assign('content_name', $this->Lang($params['module_name']) .": " . $name);
$smarty->assign('itemcount', count($revisions));
$smarty->assign_by_ref('items', $revisions);
$smarty->assign('pageback_url', $this->CreateBackURL($params['module_name'].'tab'));
$smarty->assign('pageback_text', $this->Lang("back"));
echo $this->ProcessTemplate('details.tpl');
?>