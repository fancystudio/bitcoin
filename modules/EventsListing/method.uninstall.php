<?php
/*======================================================================================
Module: EventListing
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;

// Get DB instance and make DB settings
$db = cmsms()->GetDb();
$dict = NewDataDictionary($db);

// drop tables
$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_eventslisting_events');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_eventslisting_category');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_eventslisting_category_events');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_eventslisting_templates');
$dict->ExecuteSQLArray($sqlarray);

// remove permissions
$this->RemovePermission('EventsListing: modify events');
$this->RemovePermission('EventsListing: modify categories');

// Remove Events
#$this->RemoveEventHandler('Core','ContentPostRender');

// delete image folder
$deldir = cms_join_path($config['image_uploads_path'],'Events','events');
if (is_dir($deldir)) if (!rmdir($deldir)) { echo "Error removing dir $deldir"; }
$deldir = cms_join_path($config['image_uploads_path'],'Events','categories');
if (is_dir($deldir)) if (!rmdir($deldir)) { echo "Error removing dir $deldir"; }
$deldir = cms_join_path($config['image_uploads_path'],'Events');
if (is_dir($deldir)) if (!rmdir($deldir)) { echo "Error removing dir $deldir"; }

// Delete module preferences
$this->RemovePreference();

// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('postuninstall'));

// EOF