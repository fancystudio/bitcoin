<?php

if (!cmsms()) exit;

require_once('autoloader.php');

$db = $this->GetDb();

$dict = NewDataDictionary($db);

$flds = array(
	'id I KEY',
	'module_name C(255)',
	'module_friendlyname C(255)',
	'module_version I',
	'parent_module I',
	'admin_section C(255)',
	'created_at D',
	'created_by I',
	'updated_at D',
	'updated_by I',
	'title_label C(255)',
	'show_module I',
	'is_user_module I',
	'api_enabled I',
	'is_protected I',
	'files_path XL',	
	'extra_fields X',
	'structure X',
	'filters X',
	'module_logic	XL',
	'templates_data XL',
	'extra_features XL'
);
$sql = $dict->CreateTableSQL(cms_db_prefix() . 'module_mcfactory_modules', implode(',', $flds), array('mysql' => 'TYPE=MyISAM'));
$dict->ExecuteSQLArray($sql);
$db->CreateSequence(cms_db_prefix() . 'module_mcfactory_modules_seq');

MCFModuleField::createTable();
MCFModuleAdminTemplate::createTable();

$flds = array(
	'id I KEY AUTO',	
	'created_at D',
	'created_by I',
	'updated_at D',
	'updated_by I',
	'module_id I',
	'name C(255)',
	'code XL',
	'is_public I',
	'have_permission I',
	'button_name C(255)',
	'button C(255)'
);

$sql = $dict->CreateTableSQL(cms_db_prefix() . 'module_mcfactory_module_actions', implode(',', $flds), array('mysql' => 'TYPE=MyISAM'));
$dict->ExecuteSQLArray($sql);

$flds = array(
	'id I KEY',
	'attribute_name C(255)',
	'attribute_value C(255)'
);
$sql = $dict->CreateTableSQL(cms_db_prefix() . 'module_mcfactory_attributes', implode(',', $flds), array('mysql' => 'TYPE=MyISAM'));
$dict->ExecuteSQLArray($sql);
$db->CreateSequence(cms_db_prefix() . 'module_mcfactory_attributes_seq');

$this->CreatePermission('Manage MCFactory', 'Manage MC Factory');
$this->AddEventHandler('Core', 'ContentEditPost', false);
$this->Audit(0, $this->GetName(), $this->Lang('installed', $this->GetVersion()));
