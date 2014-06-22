<?php
/*======================================================================================
Module: EventsListing
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify events') ) exit;

// Get POST data
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$event = (int)$params['event'];
$active = $params['active'] ? 1 : 0;

// De-/Activate event
if ($event) {
	// Get db instance
	$db = cmsms()->GetDb();
	// De-/Activate the event
	$sql = 'UPDATE '.cms_db_prefix().'module_eventslisting_events SET active=? WHERE entry_id=?';
	$res = $db->Execute($sql,array($active, $event));
}

// Redirect
$this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto ));

// EOF