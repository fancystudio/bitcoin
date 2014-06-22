<?php

if (!cmsms()) exit;

$db = $this->GetDb();

$dict = NewDataDictionary($db);

$sql = $dict->DropTableSQL(cms_db_prefix() . 'module_mcfactory_modules');
$dict->ExecuteSQLArray($sql);
$db->DropSequence(cms_db_prefix() . 'module_mcfactory_modules_seq');

MCFModuleField::deleteTable();
MCFModuleAdminTemplate::deleteTable();

$sql = $dict->DropTableSQL(cms_db_prefix() . 'module_mcfactory_module_actions');
$dict->ExecuteSQLArray($sql);

$sql = $dict->DropTableSQL(cms_db_prefix() . 'module_mcfactory_attributes');
$dict->ExecuteSQLArray($sql);
$db->DropSequence(cms_db_prefix() . 'module_mcfactory_attributes_seq');

$this->RemovePermission('Manage MCFactory');
$this->RemoveEventHandler('Core', 'ContentEditPost');


$this->Audit(0, $this->getFriendlyName(), $this->Lang('uninstalled'));

