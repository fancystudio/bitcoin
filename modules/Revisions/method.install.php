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

if (!is_object(cmsms())) exit;

#---------------------
# Database tables
#---------------------

$db = cmsms()->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'ENGINE MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci', 'mysqli' => 'ENGINE MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci');

// CREATE REVISIONS TABLE
$fields = '
	revision_id I KEY NOTNULL UNSIGNED,
	revision_nr I NOTNULL UNSIGNED,
	module_name C(255) NOTNULL,
	content_id I NOTNULL UNSIGNED,
	content XL NOTNULL, 
	contentblocks X NULL,
	create_time DT NOTNULL,
	user_id I NOTNULL UNSIGNED
';
$sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_revisions', $fields, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence(cms_db_prefix() . 'module_revisions_seq');


//// CREATE REVISIONS_DIFF TABLE
//$fields = '
//	id I KEY AUTO UNSIGNED,
//	revision_id I NOTNULL UNSIGNED,
//	block_name C(255) NOTNULL,
//	base_offset I NOTNULL UNSIGNED,
//	changed_offset I NOTNULL UNSIGNED,
//	base X NOTNULL,
//	changed X NOTNULL
//';
//$sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_revisions_diff', $fields, $taboptarray);
//$dict->ExecuteSQLArray($sqlarray);

// ADD INDEX revision_id
//$sqlarray = $dict->CreateIndexSQL('revision_id', cms_db_prefix() . 'module_revisions_diff', array('revision_id'));
//$dict->ExecuteSQLArray($sqlarray);

//
// CREATE REVISIONS_RECYCLE TABLE
$fields = '
	id I KEY AUTO UNSIGNED,
	module_name C(255) NOTNULL,
	content_id I NOTNULL UNSIGNED,
	content_name C(255) NOTNULL,
	hierarchy C(255) NULL,
	depth I NULL,
	content_object X NOTNULL,
	create_time DT NOTNULL,
	user_id I NOTNULL UNSIGNED
';
$sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_revisions_recycle', $fields, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// ADD UNIQUE (MODULE_NAME, CONTENT_ID)
$sqlarray = $dict->CreateIndexSQL('unique_content', cms_db_prefix() . 'module_revisions_recycle', array('module_name', 'content_id'), array('UNIQUE' => true));
$dict->ExecuteSQLArray($sqlarray);

#---------------------
# Preferences
#---------------------

$this->SetPreference('store_revisions_count', '0');
$this->SetPreference('delete_revisions_with_content', '0');

#---------------------
# Permissions
#---------------------

$this->CreatePermission('revisions_use', 'Revisions: Use');
$this->CreatePermission('revisions_options', 'Revisions: Set Options');

#---------------------
# Events
#---------------------

$this->AddEventHandler('Core', 'ContentEditPre', false);
$this->AddEventHandler('Core', 'ContentDeletePre', false);
$this->AddEventHandler('Core', 'EditGlobalContentPre', false);
$this->AddEventHandler('Core', 'DeleteGlobalContentPre', false);
$this->AddEventHandler('Core', 'EditTemplatePre', false);
$this->AddEventHandler('Core', 'DeleteTemplatePre', false);
$this->AddEventHandler('Core', 'EditStylesheetPre', false);
$this->AddEventHandler('Core', 'DeleteStylesheetPre', false);


$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
