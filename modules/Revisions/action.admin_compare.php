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


// TODO: choose between comparison of revision <-> current version or revision <-> other revision

if (!$this->CheckPermission('revisions_use'))
	return;

require_once dirname(__FILE__).'/lib/Diff/Renderer/SideBySide.php';

$admintheme = cmsms()->get_variable('admintheme');

$contentinfo = $this->GetContentInfoFromRevision($params['revision_id']);
$content = $this->GetCurrentVersion(
	($contentinfo['recycle'] ? 'recycle' : $contentinfo['module_name']),
	$contentinfo['content_id'],
	($contentinfo['recycle'] ? $contentinfo['module_name'] : '')
);

$oldcontent = $this->getRevisionContent($params['revision_id']);

$diff_markup = '';

if ($contentinfo['module_name'] == "content") {
	
	$oldcontentobj = UnserializeObject($oldcontent);
	$contentblocks = UnserializeObject($contentinfo['contentblocks']);
	
	if (is_array($contentblocks)) {
		foreach($contentblocks as $key => $value)
		{
			$old = $oldcontentobj->GetPropertyValue($key);
			$new = $content->GetPropertyValue($key);
			
			if ($contentinfo['recycle']) $new = "";
			
			if (is_array($old) and isset($old['content'])) $old = $old['content'];
			if (is_array($new) and isset($new['content'])) $new = $new['content'];	
			
			$renderer = new Diff_Renderer_Html_SideBySide($contentinfo['revision_nr']);
			$diff_markup .= "<h4>".$this->Lang("contentblock"). " '" . $key . "':</h4>";
			$diff = new Diff(explode("\n", $old), explode("\n", $new));
			$d = $diff->render($renderer);
			if ($d == "") 
				$diff_markup .= $this->Lang('revisions_identical'); 
			else 
				$diff_markup .= $diff->render($renderer);
		}
	}
	else {
		echo $this->Lang('error_contentblocks');
	}
}
else {
	$renderer = new Diff_Renderer_Html_SideBySide($contentinfo['revision_nr']);
	{
		if ($contentinfo['recycle']) $content = "";
		$diff = new Diff(explode("\n", $oldcontent), explode("\n", $content));
		$diff_markup .= $diff->render($renderer);
	}
}

$smarty->assign('restorelink',
	  $this->CreateLink($id, 'restore', $returnid,
			     $admintheme->DisplayImage('icons/system/export.gif', $this->Lang('restore'),'','','systemicon'),
			     array($contentinfo['revision_id']), '', false, false, '').' '.

	  $this->CreateLink($id, 'restore', $returnid,
			     $this->Lang('restore'),
			     array('revision_id' => $contentinfo['revision_id'])));



$smarty->assign('content_name', $this->Lang($params['module_name']) .": " . $params['name']);
$smarty->assign('pageback_url', htmlspecialchars_decode($this->create_url($id, 'admin_details', $returnid, array(
	'module_name' => ($contentinfo['recycle']?'recycle':$contentinfo['module_name']),
	'recycle_module_name' => ($contentinfo['recycle']?$contentinfo['module_name']:''),
	'content_id' => $contentinfo['content_id']
))));
$smarty->assign('pageback_text', $this->Lang("back"));
$smarty->assign('diff', $diff_markup);

echo $this->ProcessTemplate('compare.tpl');
?>