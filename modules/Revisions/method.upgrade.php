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

// Get version
$current_version = $oldversion;

// Get db handle
$db = cmsms()->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'ENGINE MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci', 'mysqli' => 'ENGINE MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci');

switch ($current_version) {
	case '1.0-Beta':
		
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_revisions_recycle','hierarchy C(255) NULL, depth I NULL');
		$return = $dict->ExecuteSQLArray($sqlarray);
		
		// Set new current version
		$current_version = '1.0-Beta1';
}

// Write message to admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('updated',$this->GetVersion()));


// EOF