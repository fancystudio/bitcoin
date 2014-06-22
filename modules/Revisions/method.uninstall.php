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

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_revisions');
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix() . 'module_revisions_seq');

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_revisions_recycle');
$dict->ExecuteSQLArray($sqlarray);

#---------------------
# Templates
#---------------------	

$this->DeleteTemplate();

#---------------------
# Preferences
#---------------------

$this->RemovePreference();

#---------------------
# Permissions
#---------------------

$this->RemovePermission('revisions_use');
$this->RemovePermission('revisions_options');

#---------------------
# Events
#---------------------

$this->RemoveEventHandler('Core', 'ContentEditPost', false);
$this->RemoveEventHandler('Core', 'ContentDeletePre', false);
$this->RemoveEventHandler('Core', 'EditGlobalContentPost', false);
$this->RemoveEventHandler('Core', 'DeleteGlobalContentPre', false);
$this->RemoveEventHandler('Core', 'EditTemplatePost', false);
$this->RemoveEventHandler('Core', 'DeleteTemplatePre', false);
$this->RemoveEventHandler('Core', 'EditStylesheetPost', false);
$this->RemoveEventHandler('Core', 'DeleteStylesheetPre', false);


$this->RemoveEventHandler('Core', 'ContentEditPre', false);
$this->RemoveEventHandler('Core', 'EditGlobalContentPre', false);
$this->RemoveEventHandler('Core', 'EditTemplatePre', false);
$this->RemoveEventHandler('Core', 'EditStylesheetPre', false);
