<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
$errors = array();
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify categories') ) {
	$errors[] = $this->Lang('needpermission', array($this->Lang('modeventslisting')));
} else {

	// Get POST data
	$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
	$category = (int)$params['category'];

	// Delete the category
	if ($category) {
		// Get db instance
		$db = cmsms()->GetDb();
		// check category for existence
		$query = 'SELECT 0 FROM '.cms_db_prefix().'module_eventslisting_category WHERE entry_id=?';
		$result = $db->Execute($query, array($category));
		if(!$result->FetchRow()) $errors[] = $this->Lang('nosuchid', array($category));
		// delete category
		if (!$errors) {
			// delete image, if one exists
			$filename = $db->GetOne('SELECT image_url FROM '.cms_db_prefix().'module_eventslisting_category WHERE entry_id = ?', array($category));
			if ($filename) {
				// get image path
				$deldir = cms_join_path($config['image_uploads_path'],'Events','categories',$category);
				$delfile = cms_join_path($deldir,$filename);
				// delete image
				if (is_file($delfile)) unlink($delfile);
				// delete category directory
				if (is_dir($deldir)) rmdir($deldir);
			}
			// Delete filename from category entry
			$db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_category SET image_url = "" WHERE entry_id = ?', array($category));
			// delete from category-event table
			$sql = 'DELETE FROM '.cms_db_prefix().'module_eventslisting_category_events WHERE cat_id=?';
			$res = $db->Execute($sql,array($category));
			if(!$res) $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
			// delete from category table
			$sql = 'DELETE FROM '.cms_db_prefix().'module_eventslisting_category WHERE entry_id=?';
			$res = $db->Execute($sql,array($category));
			if(!$res) $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
		}
	}

	// Redirect
	if (!$errors) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto, 'message' => $this->Lang('postdelete')));

}

// EOF