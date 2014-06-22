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

if (!$this->CheckPermission('revisions_use') || !isset($params['revision_id']))
	return;

require_once('editcontent_extra.php');		
	
if($params['revision_id'] > 0) {
	$contentinfo = $this->GetContentInfoFromRevision($params['revision_id']);
}

$db = cmsms()->GetDB();

// RESTORE RECYCLED CONTENT
if($params['revision_id'] < 0 || $contentinfo['recycle'])
{
	$module_name = isset($contentinfo['module_name']) ? $contentinfo['module_name'] : $params['module_name'];
	$content_id = isset($contentinfo['content_id']) ? $contentinfo['content_id'] : $params['content_id'];

	$content_obj = $this->RestoreRecycledContent($module_name, $content_id);
	
	if ($content_obj === FALSE) {
		$errors = $this->Lang("restoreerror");
		if (is_array($this->_errors)) $errors .= ": " . $this->_errors[0];
		
		$params = array('module_error'=> $errors,'active_tab' => 'recycletab');
		$this->Redirect($id, 'defaultadmin', '', $params);
		return;
	}
	
	$db->Execute('UPDATE ' . cms_db_prefix() . 'module_revisions SET content_id = ? WHERE module_name = ? AND content_id = ?', array($content_obj->Id(), $module_name, $content_id));
	$db->Execute('DELETE FROM ' . cms_db_prefix() . 'module_revisions_recycle WHERE module_name = ? AND content_id = ?', array($module_name, $content_id));

	if ($module_name == "content") {
		audit($content_obj->Id(), 'Revision Restore Recycled Page: '.$content_obj->Name(), 'Restored');
		$params = array('tab_message'=> 'msg_restored_recycle','active_tab' => $module_name . 'tab');
	}
	else {
		audit($content_obj->id, 'Revision Restore Recycled '.$module_name.': '.$content_obj->name, 'Restored');
		$params = array('tab_message'=> 'msg_restored_recycle','active_tab' => $module_name . 'tab');
	}
	$this->Redirect($id, 'defaultadmin', '', $params);
	return;

	
}

$oldcontent = $contentinfo['content'];

if($params['revision_id'] > 0)
{
	switch($contentinfo['module_name'])
	{
		default:
			return false;
	
		case 'content':
			
			$contentops = cmsms()->GetContentOperations();
			$contentobj = $contentops->LoadContentFromId($contentinfo['content_id'], true);
	
			$revcontentobj = UnserializeObject($oldcontent);
			
			$content_type = get_class($revcontentobj);
			$parm = array();
			$contentblocks = UnserializeObject($contentinfo['contentblocks']);
			
			foreach(array_keys($contentblocks) as $block_name)
			{
				$content = $revcontentobj->GetPropertyValue($block_name);
				if (is_array($content)) $content = $content['content'];
				$parm[$block_name] = $content;
			}
			
			if (strtolower(get_class($contentobj)) != strtolower($content_type))
			{
				copycontentobj($contentobj, $content_type, $parm);
			}
			updatecontentobj($contentobj, true, $parm);
			$contentobj->SetLastModifiedBy(get_userid());
			
			$res = $contentobj->ValidateData();
			if( $res === FALSE ) {
				// everything is okay... save it
				// and make sure the hierarchy stuff works.
				$contentobj->Save();
				$this->Audit( $contentobj->Id(), $this->Lang('friendlyname'), "Restore page: ".$contentobj->MenuText());
				$params = array('tab_message'=> 'msg_restored','active_tab' => $contentinfo['module_name'] . 'tab');
				$this->Redirect($id, 'defaultadmin', '', $params);
			}
			else  {
				$params = array('errors'=> $res,'active_tab' => $contentinfo['module_name'] . 'tab');
				$this->Redirect($id, 'defaultadmin', '', $params);
			}
			break;
	
		case 'stylesheet':
			$stylesheetops = cmsms()->GetStylesheetOperations();
			$stylesheet = $stylesheetops->LoadStylesheetByID($contentinfo['content_id']);
			$stylesheet->value = $oldcontent;
			$stylesheet->Save();
			break;
	
		case 'template':
			$templateops = cmsms()->GetTemplateOperations();
			$template = $templateops->LoadTemplateByID($contentinfo['content_id']);
			$template->content = $oldcontent;
			$template->Save();
			break;
	
		case 'gcb':
			$gcbops = cmsms()->GetGlobalContentOperations();
			$gcb = $gcbops->LoadHtmlBlobByID($contentinfo['content_id']);
			$gcb->content = $oldcontent;
			$gcb->Save();
			break;
			
			
			
	}
}

$params = array('tab_message'=> $this->Lang('msg_restored'),'active_tab' => $contentinfo['module_name'] . 'tab');
$this->Redirect($id, 'defaultadmin', '', $params);
?>