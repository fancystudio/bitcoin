<?php
#-------------------------------------------------------------------------
#
# Author: Lukas Blatter, <lb@blattertech.ch>
# Web: www.blattertech.de
#
#-------------------------------------------------------------------------
#
# Revisions is a CMS Made Simple module that logs changes in content,
# templates, CSS, GCBs and enables the web developer to view diff or revert to an earlier
# version of it. 
#
# 
# TODO: what happens if user that created a revision is deleted?
#-------------------------------------------------------------------------

$config = cmsms()->GetConfig();

require_once(cms_join_path($config['root_path'].'/'.$config['admin_dir'],"editcontent_extra.php"));

class Revisions extends CMSModule
{
	#---------------------
	# Attributes
	#---------------------

	private $_perms;
	private $_log;
	protected $_errors;
	protected $_donate;

	#---------------------
	# Magic methods
	#---------------------

	public function &__get($key)
	{
	    if ($key == 'userid')
		{
			$userid = get_userid();
	        return $userid;
		}
		else
		{
			return parent::__get($key);
		}
	}
	
	
	public function __construct()
	{
//		$this->AddEventHandler('Core', 'ContentEditPre', false);
//		$this->AddEventHandler('Core', 'ContentDeletePre', false);
//		$this->AddEventHandler('Core', 'EditGlobalContentPre', false);
//		$this->AddEventHandler('Core', 'DeleteGlobalContentPre', false);
//		$this->AddEventHandler('Core', 'EditTemplatePre', false);
//		$this->AddEventHandler('Core', 'DeleteTemplatePre', false);
//		$this->AddEventHandler('Core', 'EditStylesheetPre', false);
//		$this->AddEventHandler('Core', 'DeleteStylesheetPre', false);
		
		$this->_donate = '<div style="float: right">
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="RJT9ZGG57666E">
			<input type="image" src="https://www.paypalobjects.com/de_DE/CH/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Entwicklung von Revisions unterstützen">
			<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form></div>
		';

		if ($_SERVER['REMOTE_ADDR'] == "127.0.0.1") $this->_donate = "";
		
		$config = cmsms()->GetConfig();
		if ($config['debug']) {
			ini_set('display_errors', 1);
			error_reporting(E_ALL);
		}
		

		$this->SetEventOrder();
		parent::CMSModule();
	}

	#---------------------
	# Module api methods
	#---------------------
	
	public function GetName()
	{
		return 'Revisions';
	}

	public function GetFriendlyName()
	{
		return $this->Lang('friendlyname');
	}

	public function GetVersion()
	{
		return '1.0-Beta2';
	}

	public function GetHelp()
	{
		$smarty = cmsms()->GetSmarty();
		$config = cmsms()->GetConfig();

		$smarty->assign('rooturl', $config['root_url']);
		$smarty->assign('mod', $this);
		$smarty->assign('pageback_url', $this->CreateBackURL(''));
		$smarty->assign('pageback_text', $this->Lang("back"));
		$smarty->assign('donate', $this->_donate);
	
		echo $this->GetHeaderHTML();
		
		return $this->ProcessTemplate('help.tpl');
	}

	public function GetAuthor()
	{
		return 'Lukas Blatter';
	}

	public function GetAuthorEmail()
	{
		return 'lb@blattertech.ch';
	}

	public function GetChangeLog()
	{
		return $this->Lang('changelog');
	}

	public function HasAdmin()
	{
		return true;
	}

	function IsAdminOnly()
	{
		return true;
	}

	public function LazyLoadAdmin()
	{
		return true;
	}

	public function GetAdminSection()
	{
		return 'content';
	}

	public function GetAdminDescription()
	{
		return $this->Lang('moddescription');
	}

	public function VisibleToAdminUser()
	{
		$admintheme = cmsms()->get_variable('admintheme');
		return ($this->CheckPermission('revisions_use') && ($this->CheckPermission('revisions_options') || $this->HasPerm('pagePerms') || $this->HasPerm('htmlPerms') || $this->HasPerm('templatePerms') || $this->HasPerm('cssPerms')));
	}

	public function MinimumCMSVersion()
	{
		return '1.10.3';
	}

	public function InstallPostMessage()
	{
		return $this->Lang('postinstall');
	}

	public function UninstallPostMessage()
	{
		return $this->Lang('postuninstall');
	}

	public function GetDependencies()
	{
		return array();
		//return array('AceEditor' => '0.2.3.2');
	}

	
	private function Log($logtxt) 
	{
		if (is_object($this->_log)) {
			$this->_log->lwrite($logtxt);
		}
		else {		
			$log = cms_utils::get_module('ToolBox');
			if (is_object($log)) {
				$log->setLogFile('tbRevisions'); // Optional. Hier kann der Name des Logfiles festgelegt werden
				$this->_log = $log;
				$this->_log->lwrite($logtxt);
			}
		}
	}
	
	
	public function GetHeaderHTML()
	{
		$config = cmsms()->GetConfig();
		$smarty = cmsms()->GetSmarty();

		$smarty->assign('admindir', $config['admin_url']);
		$smarty->assign('moduledir', $this->GetModuleURLPath());
		$smarty->assign('userkey', get_secure_param());
		if(version_compare(CMS_VERSION, '1.11-alpha') < 1)
		{
			$smarty->assign('jquery_css', '<link rel="stylesheet" href="../lib/jquery/css/smoothness/jquery-ui-1.8.12.custom.css" />');
		}

        return $this->ProcessTemplate('header.tpl');
    }

	public function DoAction($name, $id, $params, $returnid = '')
	{
		$smarty = cmsms()->GetSmarty();

		$smarty->assign_by_ref('mod', $this);
		$smarty->assign_by_ref('actionid', $id);
		$smarty->assign_by_ref('returnid', $returnid);

		parent::DoAction($name, $id, $params, $returnid);
	}

	public function DoEvent($originator, $eventname, &$params)
	{
		$db = cmsms()->GetDB();
		$revision_id = $db->GenID(cms_db_prefix()."module_revisions_seq");
		
		switch($originator . ':' . $eventname)
		{
			case 'Core:ContentEditPre':
				$content = $params['content'];
				
				// Wenn die Funktion get_content_blocks nicht existiert, wird abgebrochen
				if (!method_exists($content, 'get_content_blocks')) break;
				
				// NO NEW PAGES
				if($content->Id() == -1) {
					break;
				}
				
				$content_blocks = array_keys($content->get_content_blocks());
				$parm = array();
				$isIdentical = true;
				// alte Inhalte auslesen
				foreach($content_blocks as $property)
				{
					$new = $content->GetPropertyValue($property);
					$dbresult = $db->Execute('SELECT content FROM ' . cms_db_prefix() . 'content_props WHERE content_id = ? AND prop_name = ? LIMIT 1', array($content->Id(), $property));
					$parm[$property] = $old = $dbresult->FetchRow();
					
					if (is_array($old) and isset($old['content'])) $old = $old['content'];
					if (is_array($new) and isset($new['content'])) $new = $new['content'];	
					// vergleichne ob etwas geändert hat
					if ($new != $old) $isIdentical = false;
				}
				
				if ($isIdentical) break;
				
				$contentobj = clone $content;
				foreach ($parm as $prop => $value) {
					$contentobj->SetPropertyValue($prop,$value);
				}
				
				$this->SaveRevision($revision_id, 'content', $content->Id(), $contentobj, $content->get_content_blocks(), $contentobj->GetModifiedDate());
				break;
				
			case 'Core:ContentDeletePre':
				if($this->GetPreference('delete_revisions_with_content') == 0) {
					
					$contentops = cmsms()->GetContentOperations();
					$contentobj = $contentops->LoadContentFromId($params['content']->Id(), true);
					
					$content_blocks = array_keys($contentobj->get_content_blocks());
					$parm = array();
					// alte Inhalte auslesen
					foreach($content_blocks as $property)
					{
						$dbresult = $db->Execute('SELECT content FROM ' . cms_db_prefix() . 'content_props WHERE content_id = ? AND prop_name = ? LIMIT 1', array($contentobj->Id(), $property));
						$old = $dbresult->FetchRow();
						if (is_array($old) and isset($old['content'])) $old = $old['content'];
						$contentobj->SetPropertyValue($property,$old);
					}
					
					$this->RecycleContent('content', $params['content']->Id(), $params['content']->MenuText(), $contentobj, $params['content']->GetModifiedDate());
				}
				else {
					$this->DeleteRevisions('content', $params['content']->Id());
				}
				break;

			case 'Core:EditGlobalContentPre':
				$gcb_new = $params['global_content'];
				if ($gcb_new->id == -1) break; 
				$dbresult = $db->Execute('SELECT html AS content, modified_date FROM ' . cms_db_prefix() . 'htmlblobs WHERE htmlblob_id = ? LIMIT 1', array($gcb_new->id));
				$gcb = $dbresult->FetchRow();
				$this->SaveRevision($revision_id, 'gcb', $gcb_new->id, $gcb['content'], "", strtotime($gcb['modified_date']));
				break;

			case 'Core:DeleteGlobalContentPre':
				if($this->GetPreference('delete_revisions_with_content') == 0) {
					$this->RecycleContent('gcb', $params['global_content']->id, $params['global_content']->name, $params['global_content'], $params['global_content']->modified_date);
				}
				else {
					$this->DeleteRevisions('gcb', $params['global_content']->id);
				}
				break;

			case 'Core:EditTemplatePre':
				$template_new = $params['template'];
				if ($template_new->id == -1) break; 
				
				$dbresult = $db->Execute('SELECT template_content AS content, modified_date FROM ' . cms_db_prefix() . 'templates WHERE template_id = ? LIMIT 1', array($template_new->id));
				$template = $dbresult->FetchRow();
				$this->SaveRevision($revision_id, 'template', $template_new->id, $template['content'], "", strtotime($template['modified_date']));
				break;

			case 'Core:DeleteTemplatePre':
				if($this->GetPreference('delete_revisions_with_content') == 0)	{
					$this->RecycleContent('template', $params['template']->id, $params['template']->name, $params['template'], $params['template']->modified_date);
				}
				else {
					$this->DeleteRevisions('template', $params['template']->id);
				}
				break;

			case 'Core:EditStylesheetPre':
				$stylesheet_new = $params['stylesheet'];
				if ($stylesheet_new->id == -1) break; 
				$dbresult = $db->Execute('SELECT css_text AS content, modified_date FROM ' . cms_db_prefix() . 'css WHERE css_id = ? LIMIT 1', array($stylesheet_new->id));
				$stylesheet = $dbresult->FetchRow();
				$this->SaveRevision($revision_id, 'stylesheet', $stylesheet_new->id, $stylesheet['content'], "", strtotime($stylesheet['modified_date']));
				break;

			case 'Core:DeleteStylesheetPre':
				if($this->GetPreference('delete_revisions_with_content') == 0)	{
					$dbresult = $db->Execute('SELECT modified_date FROM ' . cms_db_prefix() . 'css WHERE css_id = ?', array($params['stylesheet']->id));
					$row = $dbresult->FetchRow();
					$this->RecycleContent('stylesheet', $params['stylesheet']->id, $params['stylesheet']->name, $params['stylesheet'], strtotime($row['modified_date']));
				}
				else {
					$this->DeleteRevisions('stylesheet', $params['stylesheet']->id);
				}
				break;
		}
	}

	#---------------------
	# Internal methods
	#---------------------
	
	protected function voidRecycleBin()
	{
		$db = cmsms()->GetDB();
		$dbresult = $db->Execute('SELECT module_name, content_id FROM ' . cms_db_prefix() . 'module_revisions_recycle');
		while($dbresult && $row = $dbresult->FetchRow())
		{
			$this->DeleteRevisions($row['module_name'], $row['content_id']);
		}
		$db->Execute('DELETE FROM ' . cms_db_prefix() . 'module_revisions_recycle');
	}

	protected function DeleteAllRevisionsBut($retain)
	{
		$db = cmsms()->GetDb();
		$dbresult = $db->Execute('SELECT module_name, content_id, COUNT(revision_id) AS count FROM ' . cms_db_prefix() . 'module_revisions GROUP BY module_name, content_id');
		while($dbresult && $row = $dbresult->FetchRow())
		{
			$limit = $row['count'] - $retain;
			if($limit > 0)
			{
				$this->DeleteRevisions($row['module_name'], $row['content_id'], $limit);
			}
		}
	}

	protected function DeleteRevisions($module_name, $content_id, $limit = false)
	{
		$db = cmsms()->GetDB();
		$query = 'SELECT revision_id FROM ' . cms_db_prefix() . 'module_revisions WHERE module_name = ? AND content_id = ?';
		if($limit !== false)
		{
			$query .= ' ORDER BY create_time ASC LIMIT ' . $limit;
		}
		$dbresult = $db->Execute($query, array($module_name, $content_id));
		while($dbresult && $row = $dbresult->FetchRow())
		{
			$db->Execute('DELETE FROM ' . cms_db_prefix() . 'module_revisions_diff WHERE revision_id = ?', array($row['revision_id']));
		}
		$query = 'DELETE FROM ' . cms_db_prefix() . 'module_revisions WHERE module_name = ? AND content_id = ?';
		if($limit !== false)
		{
			$query .= ' ORDER BY create_time ASC LIMIT ' . $limit;
		}
		$db->Execute($query, array($module_name, $content_id));
	}

	protected function DeleteRevision($revision_id)
	{
		$db = cmsms()->GetDB();
		$db->Execute('DELETE FROM ' . cms_db_prefix() . 'module_revisions WHERE revision_id = ?', array($revision_id));
		$db->Execute('DELETE FROM ' . cms_db_prefix() . 'module_revisions_diff WHERE revision_id = ?', array($revision_id));
	}

	protected function RestoreRecycledContent($module_name, $content_id)
	{
		global $id;
		
		$gCms = cmsms();
		
		$db = $gCms->GetDb();
		$dbresult = $db->Execute('SELECT content_object FROM ' . cms_db_prefix() . 'module_revisions_recycle WHERE module_name = ? AND content_id = ?', array($module_name, $content_id));
		$row = $dbresult->FetchRow();
		$contentobj = UnserializeObject($row['content_object']);
		
		if ($module_name == "content") {
			
			$contentops = $gCms->GetContentOperations();
			$config = $gCms->GetConfig();
			$fromobj = $contentobj;
			$fromobj->GetAdditionalEditors();
			$fromobj->Properties();
			$parentobj = $contentops->LoadContentFromId($fromobj->ParentId());
			
			$to_url = $contentobj->URL();
			$to_alias = $contentobj->Alias();
			$to_title = $contentobj->Name();
			$to_menutext = $contentobj->MenuText();
			$to_parentid = -1;
			if (is_object($parentobj)) {
				$to_parentid = $fromobj->ParentId();
			}
			$to_accesskey = $contentobj->AccessKey();
			
			// kopiere das Objekt 
			$tmpobj = clone $fromobj;
				
			// Füllt die notwendigen Inhalte im kopierten Objekt wieder
			$tmpobj->SetURL($to_url);
			$tmpobj->SetName($to_title);
			$tmpobj->SetMenuText($to_menutext);
			$tmpobj->SetAlias($to_alias);
			$tmpobj->SetParentId($to_parentid);
			$tmpobj->SetOldParentId($to_parentid);
			
			$tmpobj->SetDefaultContent(0);
			$tmpobj->SetOwner(get_userid());
			$tmpobj->SetLastModifiedBy(get_userid());
				
			// This shouldn't be needed because the object was copied
			$tmpobj->SetShowInMenu($contentobj->ShowInMenu());
			$tmpobj->SetAdditionalEditors($contentobj->GetAdditionalEditors());
			$tmpobj->SetActive($contentobj->Active());
			
			// Now make sure everything is okay, and move forward.
			$res = $tmpobj->ValidateData();
			if( $res === FALSE )
			{
				// everything is okay... save it
				// and make sure the hierarchy stuff works.
				$tmpobj->Save();
				$contentops->SetAllHierarchyPositions();
				
				return $tmpobj;
			}
			else {
				$this->_errors = $res;
				return false;
			}
		}
		else {
			$contentobj->id = -1;
			$contentobj->Save();
		}
		return $contentobj;
	}

	private function RecycleContent($module_name, $content_id, $content_name, $content_obj, $create_ts)
	{
		$db = cmsms()->GetDB();
		$count_revision = $db->GetOne('select count(revision_id) FROM ' . cms_db_prefix() . 'module_revisions WHERE module_name = ? AND content_id = ? ',array($module_name, $content_id));
		
		// Revision des aktuellen Contents erstellen
		
		$hierarchy = '';
		$depth = 0;
		
		$revision_id = $db->GenID(cms_db_prefix()."module_revisions_seq");
		switch($module_name)
		{
			case 'content':
				
				$contentops = cmsms()->GetContentOperations();
				$contentobj = $contentops->LoadContentFromId($content_id, true);
				$content_blocks = array_keys($contentobj->get_content_blocks());
				
				foreach($content_blocks as $property)
				{
					$dbresult = $db->Execute('SELECT content FROM ' . cms_db_prefix() . 'content_props WHERE content_id = ? AND prop_name = ? LIMIT 1', array($contentobj->Id(), $property));
					$old = $dbresult->FetchRow();
					if (is_array($old) and isset($old['content'])) $old = $old['content'];
					$contentobj->SetPropertyValue($property,$old);
				}
				
				$query = 'SELECT hierarchy FROM ' . cms_db_prefix() . 'content where content_id = ?';
				$hierarchy = $db->GetOne($query,array($content_id));
				
				$hierarchy = $contentops->CreateFriendlyHierarchyPosition($hierarchy);
				$depth = substr_count($hierarchy, '.');
				
				$this->SaveRevision($revision_id, 'content', $content_id, $content_obj, $content_obj->get_content_blocks(), $contentobj->GetModifiedDate());
				break;
				
			case 'gcb':
				$dbresult = $db->Execute('SELECT html AS content, modified_date FROM ' . cms_db_prefix() . 'htmlblobs WHERE htmlblob_id = ? LIMIT 1', array($content_id));
				$gcb = $dbresult->FetchRow();
				$this->SaveRevision($revision_id, 'gcb', $content_id, $gcb['content'], "", strtotime($gcb['modified_date']));
				break;

			case 'template':
				$dbresult = $db->Execute('SELECT template_content AS content, modified_date FROM ' . cms_db_prefix() . 'templates WHERE template_id = ? LIMIT 1', array($content_id));
				$template = $dbresult->FetchRow();
				$this->SaveRevision($revision_id, 'template', $content_id, $template['content'], "", strtotime($template['modified_date']));
				break;

			case 'stylesheet':
				$dbresult = $db->Execute('SELECT css_text AS content, modified_date FROM ' . cms_db_prefix() . 'css WHERE css_id = ? LIMIT 1', array($content_id));
				$stylesheet = $dbresult->FetchRow();
				$this->SaveRevision($revision_id, 'stylesheet', $content_id, $stylesheet['content'], "", strtotime($stylesheet['modified_date']));
				break;
		}			
	
		$db->Execute('INSERT INTO ' . cms_db_prefix() . 'module_revisions_recycle (module_name, content_id, content_name, content_object, hierarchy, depth, create_time, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
			array($module_name, $content_id, $content_name, SerializeObject($content_obj), $hierarchy, $depth, date('Y-m-d H:i:s', $create_ts), $this->userid));
	}
	
	protected function SetEventOrder()
	{
		$db = cmsms()->GetDb();
		
		$revevents = array('core:ContentEditPre','core:EditGlobalContentPre','core:EditTemplatePre','core:EditStylesheetPre');
		
		foreach($revevents as $revevent) {
		
			$e = explode(":",$revevent);
			
			// Get the event id
			$q = "SELECT event_id FROM ".cms_db_prefix().'events WHERE originator = ? and event_name = ?';
			$event_id = $db->GetOne($q,array($e[0],$e[1]));
			
			$q = "SELECT handler_order FROM ".cms_db_prefix().'event_handlers WHERE module_name = ? and event_id = ?';
			$cur_order = $db->GetOne($q,array("Revisions",$event_id));
			
			$q = "SELECT handler_id FROM ".cms_db_prefix().'event_handlers WHERE module_name = ? and event_id = ?';
			$handler = $db->GetOne($q,array("Revisions",$event_id));

			
			// Get the next handler id
			$q = 'SELECT handler_id FROM '.cms_db_prefix().'event_handlers WHERE handler_order = ?
	                    AND event_id = ?';
			$next_id = $db->GetOne($q,array($cur_order + 1,$event_id));
			
			if($next_id) {
				// Get the next handler id
				$q = 'SELECT handler_id FROM '.cms_db_prefix().'event_handlers WHERE handler_order = ?
		                    AND event_id = ?';
				$next_id = $db->GetOne($q,array($cur_order + 1,$event_id));
				if( $next_id )
				{
					$q = "UPDATE ".cms_db_prefix()."event_handlers SET handler_order = (handler_order + 1)
							where handler_id = ?";
					$db->Execute( $q, array( $handler ) );
		
					$q = "UPDATE ".cms_db_prefix()."event_handlers SET handler_order = (handler_order - 1)
							where handler_id = ?";
					$db->Execute( $q, array( $next_id ) );
				}
			
			}		
		}	
	}
	
	
	// TODO: Funktion CompareContentObj schreiben
	protected function CompareContentObj($newcontentobj, $contentblocks, $oldcontentobj)
	{
		if (get_class($newcontentobj) != get_class($oldcontentobj)) return false;
		
		$contentblocks1 = array();
		$contentblocks2 = array();
		
		foreach ($contentblocks as $block) {
			$contentblocks1[$block] = $newcontentobj->GetPropertyValue($block);
			$contentblocks2[$block] = $oldcontentobj->GetPropertyValue($block);
		}

		if ($contentblocks1 != $contentblocks2) return false;
		
		return true;
	}
	

	protected function SaveRevision($revision_id, $module_name, $content_id, $content, $contentblocks, $create_ts)
	{
		$db = cmsms()->GetDB();
		
		// Kontrolle ob Inhalt geändert hat
		$dbresult = $db->Execute('SELECT content, revision_id FROM ' . cms_db_prefix() . 'module_revisions WHERE module_name = ? AND content_id = ? order by create_time desc LIMIT 1', array($module_name, $content_id));
		$lastrevision = $dbresult->FetchRow();
		
		if ($module_name == "content") {
			
			if (isset($lastrevision['content']) and $lastrevision['content'] != "") {
				$oldcontentobj = UnserializeObject($lastrevision['content']);
				$isIdendical = true;
				foreach (array_keys($contentblocks) as $key) {
					$old = $oldcontentobj->GetPropertyValue($key);
					$new = $content->GetPropertyValue($key);
					
					if (is_array($old) and isset($old['content'])) $old = $old['content'];
					if (is_array($new) and isset($new['content'])) $new = $new['content'];	
					
					if ($new != $old) $isIdendical = false;
				}
				
				// Sind die Inhalte identisch, wird hier abgebrochen
				if ($isIdendical) return;
			}
			
			$content = SerializeObject($content);
			$contentblocks = SerializeObject($contentblocks);
			
		}
		// Wenn nicht geändert hat, die Revision nicht speichern
		else if ($lastrevision['content'] == $content) {
			return;
			
		}
		
		$revision_nr = $db->GetOne('select max(revision_nr) FROM ' . cms_db_prefix() . 'module_revisions WHERE module_name = ? AND content_id = ? ',array($module_name, $content_id));
		$revision_nr += 1;

		// Ältere Revisions löschen falls eingestellt
		$dbresult = $db->Execute('SELECT COUNT(DISTINCT revision_id) AS count FROM ' . cms_db_prefix() . 'module_revisions WHERE module_name = ? AND content_id = ? LIMIT 1', array($module_name, $content_id));
		$revisions = $dbresult->FetchRow();
		$store_revisions_count = $this->GetPreference('store_revisions_count');
		if($store_revisions_count > 0 && $revisions['count'] >= $store_revisions_count)
		{
			$deletecount = $revisions['count'] - $this->GetPreference('store_revisions_count') + 1;
			$this->DeleteRevisions($module_name, $content_id, $deletecount);
		}

		// revision einfügen
		$result = $db->Execute('INSERT INTO ' . cms_db_prefix() . 'module_revisions (revision_id, module_name, revision_nr, content_id, content, contentblocks, create_time, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
			array($revision_id, $module_name, $revision_nr, $content_id, $content, $contentblocks, date('Y-m-d H:i:s', $create_ts), $this->userid));

		return true;
	}

	protected function getRevisionContent($revision_id) 
	{
		$db = cmsms()->GetDb();
		$contentinfo = $this->GetContentInfoFromRevision($revision_id);
		$content = "";
		
		$query = 'select * from '.cms_db_prefix() . 'module_revisions where revision_id = ?';
		$result = $db->Execute($query, array($revision_id));
		
		if( $result && $result->RecordCount() > 0 )	{
			$data = $result->FetchRow();
		}
		
		return $data['content'];
	}
	
	
	protected function RebuildRevision($content, $revision_id)
	{
		$db = cmsms()->GetDb();
		$contentinfo = $this->GetContentInfoFromRevision($revision_id);
		
		// GET ALL REVISIONS
		$query = 'SELECT d.revision_id, d.block_name, d.base_offset, d.changed_offset, d.base, d.changed FROM ' . cms_db_prefix() . 'module_revisions_diff d, ' . cms_db_prefix() . 'module_revisions r WHERE d.revision_id = r.revision_id AND r.module_name = ? AND r.content_id = ? AND r.revision_id >= ? ORDER BY r.revision_id DESC';
		$dbresult = $db->Execute($query, array($contentinfo['module_name'], $contentinfo['content_id'], $revision_id));
		$revisions = array();
		while($dbresult && $row = $dbresult->FetchRow())
		{
			$revisions[] = $row;
		}

		// REVERT
		// $is_array = (bool) is_array($content);
		foreach($revisions as $revision)
		{
			$patch = $revision;
			$patch['base'] = unserialize($patch['base']);
			$patch['changed'] = unserialize($patch['changed']);
			foreach($patch['base'] as $key => $value){
				$patch['base'][$key] = str_replace(array('<del>', '</del>', '<ins>', '</ins>'), '', $value);
			}
			foreach($patch['changed'] as $key => $value){
				$patch['changed'][$key] = str_replace(array('<del>', '</del>', '<ins>', '</ins>'), '', $value);
			}
			$content = $this->ApplyPatch($content, $patch);

			// $diff = array_reverse(unserialize($revision['diff']));
			// if($is_array)
			// {
				// foreach($content as $key => $value)
				// {
					// $content[$key] = $this->ApplyPatch($value, $diff);
				// }
			// }
			// else
			// {
				// $content = $this->ApplyPatch($content, $diff);
			// }
		}
		return $content;
	}

	protected function GetContentInfoFromRevision($revision_id)
	{
		$db = cmsms()->GetDb();
		$query = 'SELECT a.revision_id, a.module_name, a.revision_nr, a.content_id, a.content, a.contentblocks, b.content_name, COUNT(b.content_id) AS recycle FROM ' . cms_db_prefix() . 'module_revisions a LEFT JOIN ' . cms_db_prefix() . 'module_revisions_recycle b ON a.content_id = b.content_id WHERE a.revision_id = ? group by a.revision_id, a.module_name, a.revision_nr, a.content_id, a.content, a.contentblocks, b.content_name';
		$dbresult = $db->Execute($query, array($revision_id));
		return $dbresult->FetchRow();
	}

	private function ApplyPatch($content, $patch)
	{
		$content_lines = explode("\n", $content);
		// DELETE LINES
		for($n = $patch['changed_offset']; $n < $patch['changed_offset'] + count($patch['changed']); $n++){
			unset($content_lines[$n]);
		}
		// INSERT LINES
		foreach($patch['base'] as $op_offset => $newval)
		{
			$key = $patch['base_offset'] + $op_offset;
			if(!isset($content_lines[$key])){
				$content_lines[$key] = $newval;
			}
			else
			{
				RevisionsUtils::array_insert($content_lines, $key, $newval);
			}
		}
		ksort($content_lines);
		return implode("\n", $content_lines);
	}

	protected function ListContent($query, $id, $returnid, $recycle = false)
	{
		$admintheme = cmsms()->get_variable('admintheme');
		$db = cmsms()->GetDb();
		$smarty = cmsms()->GetSmarty();
		$contentops = cmsms()->GetContentOperations();

		$dbresult = $db->query($query);
		$pages = array();
		while($dbresult && $row = $dbresult->FetchRow())
		{
			if(isset($row['hierarchy']) and $recycle)
			{
				/* Daten werden bereits korrekt aus der DB gelesen (Hierarchy zum Zeitpunkt des Löschens) */
			}
			else if(isset($row['hierarchy']))
			{
				$row['hierarchy'] = $contentops->CreateFriendlyHierarchyPosition($row['hierarchy']);
				$row['depth'] = substr_count($row['hierarchy'], '.');
			}
			else
			{
				$row['hierarchy'] = '';
				$row['depth'] = 0;
			}
			$row['recycle_module_name'] = '';
			if($recycle)
			{
				$row['recycle_module_name'] = $row['module_name'];
				$row['module_name'] = 'recycle';
			}
			$row['namelink'] = $this->CreateLink($id, 'admin_details', $returnid, $row['name'], array(
				'module_name' => $row['module_name'],
				'recycle_module_name' => $row['recycle_module_name'],
				'content_id' => $row['content_id']
			));
			$row['detaillink'] = $this->CreateLink($id, 'admin_details', $returnid, $admintheme->DisplayImage('icons/system/info.gif', $this->Lang('showdetails'), '', '', 'systemicon'), array(
				'module_name' => $row['module_name'],
				'recycle_module_name' => $row['recycle_module_name'],
				'content_id' => $row['content_id']
			));

			$pages[] = RevisionsUtils::array_to_object($row);
		}
		
		$smarty->assign('itemcount', count($pages));
		$smarty->assign_by_ref('items', $pages);
		echo $this->ProcessTemplate('listitems.tpl');
	}

	protected function GetCurrentVersion($module_name, $content_id, $recycle_module_name = '')
	{
		switch($module_name)
		{
			default:
				return false;

			case 'content':
				$contentops = cmsms()->GetContentOperations();
				$contentobj = $contentops->LoadContentFromId($content_id, true);
				
				$content = $contentobj;
				break;
				
			case 'stylesheet':
				$stylesheetops = cmsms()->GetStylesheetOperations();
				$stylesheet = $stylesheetops->LoadStylesheetByID($content_id);
				$content = $stylesheet->value;
				break;

			case 'template':
				$templateops = cmsms()->GetTemplateOperations();
				$template = $templateops->LoadTemplateByID($content_id);
				$content = $template->content;
				break;

			case 'gcb':
				$gcbops = cmsms()->GetGlobalContentOperations();
				$gcb = $gcbops->LoadHtmlBlobByID($content_id);
				$content = $gcb->content;
				break;

			case 'recycle':
				
				$db = cmsms()->GetDb();
				$dbresult = $db->Execute('SELECT content_object FROM ' . cms_db_prefix() . 'module_revisions_recycle WHERE module_name = ? AND content_id = ?',
					array($recycle_module_name, $content_id));
				$row = $dbresult->FetchRow();
				$content_obj = UnserializeObject($row['content_object']);
				switch($recycle_module_name)
				{
					default:
						return false;

					case 'content':
						$content = $content_obj;
						break;

					case 'stylesheet':
						$content = $content_obj->value;
						break;

					case 'template':
					case 'gcb':
						$content = $content_obj->content;
						break;
						
						
				}
				break;
		}
		return $content;
	}

	private function SetAggregatePermissions($force = FALSE)
	{
		if (is_array($this->_perms && $force == FALSE))
			return;

		$this->_perms = array();

		// Content Permissions
		$this->_perms['htmlPerms'] = check_permission($this->userid, 'Add Global Content Blocks') | check_permission($this->userid, 'Modify Global Content Blocks') | check_permission($this->userid, 'Delete Global Content Blocks');

		$gcbops = cmsms()->GetGlobalContentOperations();

		$thisUserBlobs = $gcbops->AuthorBlobs($this->userid);
		if (count($thisUserBlobs) > 0) {
			$this->_perms['htmlPerms'] = true;
		}
		$this->_perms['pagePerms'] = (check_permission($this->userid, 'Modify Any Page') || check_permission($this->userid, 'Add Pages') || check_permission($this->userid, 'Remove Pages') || check_permission($this->userid, 'Manage All Content'));
		$thisUserPages = author_pages($this->userid);
		if (count($thisUserPages) > 0) {
			$this->_perms['pagePerms'] = true;
		}
		$this->_perms['contentPerms'] = $this->_perms['pagePerms'] | $this->_perms['htmlPerms'] | (isset($this->_sectionCount['content']) && $this->_sectionCount['content'] > 0);

		// layout        
		$this->_perms['templatePerms'] = check_permission($this->userid, 'Add Templates') | check_permission($this->userid, 'Modify Templates') | check_permission($this->userid, 'Remove Templates');
		$this->_perms['cssPerms'] = check_permission($this->userid, 'Add Stylesheets') | check_permission($this->userid, 'Modify Stylesheets') | check_permission($this->userid, 'Remove Stylesheets');
	}

	protected function HasPerm($permission)
	{
	    $this->SetAggregatePermissions();

	    if (isset($this->_perms[$permission]) && $this->_perms[$permission]) {
	        return true;
	    } else {
	        return false;
	    }
	}

	#---------------------
	# Help methods
	#---------------------

	protected function CreateBackURL($tab)
	{
		$secureparam = CMS_SECURE_PARAM_NAME . '=' . $_SESSION[CMS_USER_KEY];
		return 'moduleinterface.php?' . $secureparam .'&module='.$this->GetName().'&m1_active_tab='.$tab;
	}

	public function CreateInputNumber($id, $name, $value='', $addttext='')
	{
		if(is_callable('parent::CreateInputNumber'))
		{
			return parent::CreateInputNumber($id, $name, $value, $addttext);
		}

		return RevisionsUtils::CreateInputNumber($id, $name, $value, $addttext);
	}
}
?>