<?php
if (!cmsms()) exit;

require_once('autoloader.php');

$db = $this->GetDb();
$dict = NewDataDictionary($db);

switch (true) {
    case version_compare($oldversion, '0.1', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'filters X');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '0.3', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'parent_module I');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '1.0.1', '<'):
        $this->CreatePermission('Manage MCFactory', 'Manage MCFactory');
    case version_compare($oldversion, '1.1', '<'):
        $flds = array(
            'id I KEY',
            'attribute_name C(255)',
            'attribute_value C(255)'
        );
        $sql = $dict->CreateTableSQL(cms_db_prefix() . 'module_mcfactory_attributes', implode(',', $flds), array('mysql' => 'TYPE=MyISAM'));
        $dict->ExecuteSQLArray($sql);
        $db->CreateSequence(cms_db_prefix() . 'module_mcfactory_attributes_seq');
        $this->AddEventHandler('Core', 'ContentEditPost', false);
    case version_compare($oldversion, '2.7.1', '<'):
        $c = new MCFCriteria();
        $modules = MCFModule::doSelect($c);
        foreach ($modules as $module) {
            $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_' . strtolower($module->getModuleName()), 'full_text_search XL');
            $dict->ExecuteSQLArray($sqlarray);
        }
    case version_compare($oldversion, '2.8.6', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'show_module I');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '2.9.1', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'module_logic	XL');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '2.9.15', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'is_user_module	I');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '2.10.10', '<'):
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
            'have_permission I'
        );
        $sql = $dict->CreateTableSQL(cms_db_prefix() . 'module_mcfactory_module_actions', implode(',', $flds), array('mysql' => 'TYPE=MyISAM'));
        $dict->ExecuteSQLArray($sql);
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'templates_data	XL');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '2.10.13', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'admin_section C(255)');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '2.11.4', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'is_protected I');
        $dict->ExecuteSQLArray($sql);
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'files_path XL');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '2.12.7', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'title_label C(255)');
        $dict->ExecuteSQLArray($sql);
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'structure XL');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '3.2.5', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_module_actions', 'button C(255)');
        $dict->ExecuteSQLArray($sql);
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_module_actions', 'button_name C(255)');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '3.2.16', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'api_enabled I');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '3.2.35', '<'):
        $sql = $dict->AddColumnSQL(cms_db_prefix() . 'module_mcfactory_modules', 'extra_features XL');
        $dict->ExecuteSQLArray($sql);
    case version_compare($oldversion, '3.4.92', '<'):
        MCFModuleField::createTable();
        MCFModuleAdminTemplate::createTable();
}

$this->Audit(0, $this->getFriendlyName(), $this->Lang('upgraded', $this->GetVersion()));

