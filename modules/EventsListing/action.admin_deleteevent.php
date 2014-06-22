<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
$errors = array();
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify events') ) {
	$errors[] = $this->Lang('needpermission', array($this->Lang('modeventslisting')));
} else {

	// Get POST data
	$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
	$event = (int)$params['event'];

	// Delete the event
	if ($event) {
		// Get db instance
		$db = cmsms()->GetDb();
		// check event for existence
		$query = 'SELECT 0 FROM '.cms_db_prefix().'module_eventslisting_events WHERE entry_id=?';
		$result = $db->Execute($query, array($event));
		if(!$result->FetchRow()) $errors[] = $this->Lang('nosuchid', array($event));
		// delete event
		if (!$errors) {
			// delete image, if one exists
			$filename = $db->GetOne('SELECT image_url FROM '.cms_db_prefix().'module_eventslisting_events WHERE entry_id = ?', array($event));
			if ($filename) {
				// get image path
				$deldir = cms_join_path($config['image_uploads_path'],'Events','events',$event);
				$delfile = cms_join_path($deldir,$filename);
				// delete image
				if (is_file($delfile)) unlink($delfile);
				// delete event directory
				if (is_dir($deldir)) rmdir($deldir);
			}
			// Delete filename from event entry
			$db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_events SET image_url = "" WHERE entry_id = ?', array($event));
			// delete from category-event table
			$sql = 'DELETE FROM '.cms_db_prefix().'module_eventslisting_category_events WHERE event_id=?';
			$res = $db->Execute($sql,array($event));
			if(!$res) $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
			// delete from event table
			$sql = 'DELETE FROM '.cms_db_prefix().'module_eventslisting_events WHERE entry_id=?';
			$res = $db->Execute($sql,array($event));
			if(!$res) $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
		}
	}

	// Redirect
	if (!$errors) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto, 'message' => $this->Lang('postdelete')));

}

// EOF