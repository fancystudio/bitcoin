<?php
/*======================================================================================
Module: EventsListing
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify categories') ) exit;

// Get POST data
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$category = (int)$params['category'];
$active = $params['active'] ? 1 : 0;

// De-/Activate category
if ($category) {
	// Get db instance
	$db = cmsms()->GetDb();
	// De-/Activate the category
	$sql = 'UPDATE '.cms_db_prefix().'module_eventslisting_category SET active=? WHERE entry_id=?';
	$res = $db->Execute($sql,array($active, $category));
}

// Redirect
$this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto ));

// EOF