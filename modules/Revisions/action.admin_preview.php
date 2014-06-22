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

$config = cmsms()->GetConfig();

require_once('editcontent_extra.php');

$admintheme = cmsms()->get_variable('admintheme');

if($params['revision_id'] > 0)
{
	$contentinfo = $this->GetContentInfoFromRevision($params['revision_id']);
}
else
{
	$contentinfo = array();
	$contentinfo['recycle'] = true;
	$contentinfo['module_name'] = $params['module_name'];
	$contentinfo['content_id'] = $params['content_id'];
}
$content = $this->GetCurrentVersion(
	($contentinfo['recycle'] ? 'recycle' : $contentinfo['module_name']),
	$contentinfo['content_id'],
	($contentinfo['recycle'] ? $contentinfo['module_name'] : '')
);
$oldcontent = $params['revision_id'] > 0 ? $this->getRevisionContent($params['revision_id']) : $content;

if($contentinfo['module_name'] == 'content')
{
	$revcontentobj = UnserializeObject($oldcontent);
	$parm = array();
	$contentblocks = UnserializeObject($contentinfo['contentblocks']);
	

	$contentops = cmsms()->GetContentOperations();
	$content_type = get_class($revcontentobj);
	
	$parm = array();
	
	if ($contentinfo['recycle']) {
		$contentobj = 	$this->GetCurrentVersion("recycle", $contentinfo['content_id'], "content");
			
		foreach($contentblocks as $block_name => $value)
		{
			$old = $revcontentobj->GetPropertyValue($block_name);
			if (is_array($old) and isset($old['content'])) $old = $old['content'];
			
			$parm[$block_name] = $old;
		}
	}
	else {
		$contentobj = $contentops->LoadContentFromId($contentinfo['content_id'], true);
		foreach($contentobj->get_content_blocks() as $block_name => $value)
		{
			$old = $revcontentobj->GetPropertyValue($block_name);
			if (is_array($old) and isset($old['content'])) $old = $old['content'];
			
			$parm[$block_name] = $old;
		}
	}	
		
		
	if (strtolower(get_class($contentobj)) != strtolower($content_type))
	{
		copycontentobj($contentobj, $content_type, $parm);
	}
	updatecontentobj($contentobj, true, $parm);


	
	$tmpfname = createtmpfname($contentobj);
	$_SESSION['cms_preview'] = str_replace('\\','/',$tmpfname);
	$tmpvar = substr(str_shuffle(md5($tmpfname)),-3);
	$url = $config["root_url"].'/index.php?'.$config['query_var']."=__CMS_PREVIEW_PAGE__&r=$tmpvar"; // temporary	
	header('Location: ' . $url);
	
	exit;
}
else
{
	switch($contentinfo['module_name'])
	{
		default:
			$mode = '';
			break;

		case 'stylesheet':
			$mode = 'css';
			break;

		case 'template':
		case 'gcb':
			$mode = 'html';
			break;
	}

	$smarty->assign('restorelink',
	  $this->CreateLink($id, 'restore', $returnid,
			     $admintheme->DisplayImage('icons/system/export.gif', $this->Lang('restore'),'','','systemicon'),
			     array($contentinfo['revision_id']), '', false, false, '').' '.

	  $this->CreateLink($id, 'restore', $returnid,
			     $this->Lang('restore'),
			     array('revision_id' => $contentinfo['revision_id'])));
	
	
	$smarty->assign('content_name', $this->Lang($contentinfo['module_name']) .": " . $params['name']);
	$smarty->assign('revision_nr', $contentinfo['revision_nr']);
	$smarty->assign('pageback_url', htmlspecialchars_decode($this->create_url($id, 'admin_details', $returnid, array(
		'module_name' => ($contentinfo['recycle']?'recycle':$contentinfo['module_name']),
		'recycle_module_name' => ($contentinfo['recycle']?$contentinfo['module_name']:''),
		'content_id' => $contentinfo['content_id']
	))));
	$smarty->assign('pageback_text', $this->Lang("back"));
	$smarty->assign('code', htmlspecialchars($oldcontent));
	echo $this->ProcessTemplate('preview.tpl');
	$ace = Revisions::GetModuleInstance('AceEditor');
	if (is_object($ace)) {
		$ace->DoAction('head', $id, array());
		$ace->DoAction('default', $id, array('divid' => 'previewcode', 'width' => '600', 'height' => 500, 'mode' => $mode));
	}
}
?>