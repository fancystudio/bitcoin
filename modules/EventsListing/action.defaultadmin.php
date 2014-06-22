<?php
/*======================================================================================
Module: EventsListing
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;

// Set needed objects
$db = cmsms()->GetDb();
$smarty = cmsms()->GetSmarty();

// Insert content operations class
$contentops =& cmsms()->GetContentOperations();

// Get Tab Redirect action
$tabto = isset($params['tabto']) ? preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']) : 'events';

#echo $this->donate;

// Show messages or errors
if (isset($params['errors'])) {
	if ($params['errors']) echo '<div style="border:3px solid #ff3333; margin:5px; padding:5px; font-weight:bold;">'.str_replace(',','<br />',$params['errors']).'</div>';
}
if (isset($params['message'])) {
	if ($params['message']) echo '<div style="border:3px solid #33ff33; margin:5px; padding:5px; font-weight:bold;">'.$params['message'].'</div>';
}

// Displays the Tabs
echo $this->StartTabHeaders();
if ( $this->CheckPermission('EventsListing: modify events') ) {
	echo $this->SetTabHeader('events',$this->Lang('events'),$tabto=='events'?true:false);
}
if ( $this->CheckPermission('EventsListing: modify categories') ) {
	echo $this->SetTabHeader('categories',$this->Lang('categories'),$tabto=='categories'?true:false);
}
if ( $this->CheckPermission('Modify Templates') ) {
	echo $this->SetTabHeader('templates',$this->Lang('templates'),$tabto=='templates'?true:false);
}
echo $this->EndTabHeaders();

// Display the content of the tabs
echo $this->StartTabContent();
if ( $this->CheckPermission('EventsListing: modify events') ) {
	echo $this->StartTab('events');
	include(dirname(__FILE__).'/function.admin_events.php');
	echo $this->EndTab();
}
if ( $this->CheckPermission('EventsListing: modify categories') ) {
	echo $this->StartTab('categories');
	include(dirname(__FILE__).'/function.admin_categories.php');
	echo $this->EndTab();
}
if ( $this->CheckPermission('Modify Templates') ) {
	echo $this->StartTab('templates');
	include(dirname(__FILE__).'/function.admin_templates.php');
	echo $this->EndTab();
}
echo $this->EndTabContent();

// EOF