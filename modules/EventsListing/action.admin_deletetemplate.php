<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
$errors = array();
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('Modify Templates') ) {
	$errors[] = $this->Lang('needpermission', array($this->Lang('modeventslisting')));
} else {

	// Get POST data
	$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
	$template = (int)$params['template'];

	// Delete the template
	if ($template) {
		// Get db instance
		$db = cmsms()->GetDb();
		// check template for existence
		$query = 'SELECT 0 FROM '.cms_db_prefix().'module_eventslisting_templates WHERE entry_id=?';
		$result = $db->Execute($query, array($template));
		if(!$result->FetchRow()) $errors[] = $this->Lang('nosuchid', array($template));
		// delete template
		if (!$errors) {
			// delete from template table
			$sql = 'DELETE FROM '.cms_db_prefix().'module_eventslisting_templates WHERE entry_id=?';
			$res = $db->Execute($sql,array($template));
			if(!$res) $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
		}
	}

	// Redirect
	if (!$errors) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto, 'message' => $this->Lang('postdelete')));

}

// EOF