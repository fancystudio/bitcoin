<?php

class MCFGenerator
{

    /** @var  MCFModule $module */
    protected $module;

    protected $config = array();

    public function __construct(MCFModule $module)
    {
        $this->module = $module;
        $this->config = cms_utils::get_config();
    }


    /**
     * Create the structure of a module
     */
    private function createStructure()
    {
        $this->createFolder();
        $this->createFolder('lang');
        $this->createFolder('templates');
        $this->createFolder('images');
        $this->createFolder('rss');
        $this->createFolder('lib');
    }

    /**
     * Generate a subfolder for the module
     * @param null $folder
     * @return bool
     * @throws Exception
     */
    private function createFolder($folder = null)
    {
        $base = $this->config['root_path']  . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->module->getModuleName();
        $dir = $base . DIRECTORY_SEPARATOR . $folder;
        if(!is_dir($dir))
        {
            if(!@mkdir($dir, 0777, true))
            {
                throw new Exception('Cannot generate the folder [' . $dir . '] for the module ' . $this->module->getModuleName() . ' - Check the module\'s directory permissions');
            }
        }
        return true;
    }

    /**
     * Clean module structure from old references
     */
    private function cleanStructure()
    {
        if (is_file($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes/' . $this->module->getModuleName() . 'ObjectBase.class.php')) unlink($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes/' . $this->module->getModuleName() . 'ObjectBase.class.php');
        if (is_file($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes/' . $this->module->getModuleName() . 'Object.class.php')) unlink($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes/' . $this->module->getModuleName() . 'Object.class.php');
        if (is_file($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes/' . $this->module->getModuleName() . 'Views.class.php')) unlink($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes/' . $this->module->getModuleName() . 'Views.class.php');
        if (is_dir($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes')) unlink($this->config['root_path'] . '/modules/' . $this->module->getModuleName() . '/classes');
    }

    public function publish()
    {
        $this->module->incrementModuleVersion();

        $this->createStructure();

        $this->cleanStructure();

        $this->publishFile('lib/class.' . $this->module->getModuleName() . 'Base.php', 'lib/class.MCFModuleBase.php.tpl');
        $this->publishFile('lib/class.' . $this->module->getModuleName() . 'ObjectBase.php', 'lib/class.MCFModuleObjectBase.php.tpl');
        $this->publishFile('lib/class.' . $this->module->getModuleName() . 'Object.php', 'lib/class.MCFModuleObject.php.tpl');
        $this->publishFile('lib/class.' . $this->module->getModuleName() . 'Views.php', 'lib/class.MCFModuleViews.php.tpl');

        $this->publishFile('lang/en_US.php');
        $this->publishFile('templates/defaultadmin.items.tpl');
        $this->publishFile('templates/defaultadmin.templates.tpl');
        $this->publishFile('templates/admin.templates.tpl');
        $this->publishFile('templates/admin.template_edit.tpl');
        $this->publishFile('templates/defaultadmin.options.tpl');
        $this->publishFile('templates/edit.tpl');
        $this->publishFile('templates/edittemplate.tpl');
        $this->publishFile('templates/error.tpl');

        // TODO: Clean those files
//		$this->publishFile('templates/template.details.tpl');
//		$this->publishFile('templates/template.list.tpl');
//      $this->publishFile('templates/template.paginated.tpl');
//      $this->publishFile('templates/template.search.tpl');
//      $this->publishFile('templates/template.calendar.tpl');

        $this->publishFile('templates/frontend.default.tpl');
        $this->publishFile('templates/frontend.detail.tpl');
        $this->publishFile('templates/frontend.search.tpl');
        $this->publishFile('templates/frontend.calendar.tpl');
        $this->publishFile('templates/frontend.paginated.tpl');
        $this->publishFile('templates/frontend.tagcloud.tpl');
        $this->publishFile('templates/frontend.rss.tpl');
        $this->publishFile('templates/frontend.direct_email.tpl');

        $this->publishFile('rss/rss.css');
        $this->publishFile('rss/style.xsl');

        if ($this->module->getIsUserModule()) {
            $this->publishFile('action.user_form.php');
            $this->publishFile('templates/frontend.user_form.tpl');
            $this->publishFile('templates/frontend.user_form_success.tpl');
        }

        $this->copyFile('images/icon.gif');
        $this->publishFile('action.api.php');
        $this->publishFile('action.calendar.php');
        $this->publishFile('action.default.php');
        $this->publishFile('action.defaultadmin.php');
        $this->publishFile('action.delete.php');
        $this->publishFile('action.moveup.php');
        $this->publishFile('action.movedown.php');
        $this->publishFile('action.detail.php');
        $this->publishFile('action.export.php');
        $this->publishFile('action.export_dat.php');
        $this->publishFile('action.export_db.php');
        $this->publishFile('action.import_db.php');
        $this->publishFile('action.edit.php');
        $this->publishFile('action.template_edit.php');
        $this->publishFile('action.template_delete.php');
        $this->publishFile('action.edittemplate.php');
        $this->publishFile('action.deletetemplate.php');
        $this->publishFile('action.geturl.php');
        $this->publishFile('action.publish.php');
        $this->publishFile('action.rss.php');
        $this->publishFile('action.search.php');
        $this->publishFile('action.template.php');
        $this->publishFile('action.count.php');
        $this->publishFile('action.url_for.php');
        $this->publishFile('action.link_to.php');
        $this->publishFile('action.assigntitles.php');
        $this->publishFile('index.html');
        $this->publishFile('function.defaultadmin.items.php');
        $this->publishFile('function.defaultadmin.templates.php');
        $this->publishFile('function.defaultadmin.options.php');
        $this->publishFile('function.defaultadmin.help.php');
        $this->publishFile('action.updateObjects.php');
        $this->publishFile('action.tagcloud.php');
        $this->publishFile('action.ical.php');
        $this->publishFile('action.download.php');

        // ACTIONS
        $actions = $this->module->getActions();
        foreach ($actions as $action) {
            $this->publishFile('action.' . $action->name . '.php', 'action.module_action.php.tpl', array('action_obj' => $action));
        }

        $buttons = MCFModuleAction::sortByPlace($actions);
        $this->publishFile($this->module->getModuleName() . '.module.php', 'MCFModule.module.php.tpl', array('buttons' => $buttons));

        $this->updateDB();

        $this->module->save();

        return true;
    }

    private function copyFile($source)
    {
        $source_dir = $this->config['root_path'] . '/modules/MCFactory/smarty/templates';
        $destination_dir = $this->config['root_path'] . '/modules/' . $this->module->getModuleName();
        if (@copy($source_dir . DIRECTORY_SEPARATOR . $source, $destination_dir . DIRECTORY_SEPARATOR . $source) === false) {
            throw new Exception('Cannot copy file [' . $source . '] to destination folder');
        }
    }

    private function updateDB()
    {
        // TODO: Refactor
        if (cms_utils::get_module($this->module->getModuleName())) {
            $db = cms_utils::get_db();
            foreach ($this->module->getDeleteFields() as $field) {
                $dict = NewDataDictionary($db);
                $sqlarray = $dict->DropColumnSQL(cms_db_prefix() . 'module_' . strtolower($this->module->getModuleName()), $field);
                $dict->ExecuteSQLArray($sqlarray);
            }
            $fieldTypes = $this->module->getFieldTypes();

            foreach ($this->module->getOldExtraFields() as $field) {

                if (isset($field['new']) or ($db->execute('SELECT COUNT(' . $field['name'] . ') FROM ' . cms_db_prefix() . 'module_' . strtolower($this->module->getModuleName())) === false)) {
                    $dict = NewDataDictionary($db);
                    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_' . strtolower($this->module->getModuleName()), $field['name'] . ' ' . $fieldTypes[$field['type']]['column_type']);
                    $dict->ExecuteSQLArray($sqlarray);
                }

                // Fix uppercase names
                if (isset($field['uppercase_name'])) {
                    if ($db->execute('SELECT COUNT(' . $field['uppercase_name'] . ') FROM ' . cms_db_prefix() . 'module_' . strtolower($this->module->getModuleName())) !== false) {
                        $dict = NewDataDictionary($db);
                        $sqlarray = $dict->RenameColumnSQL(cms_db_prefix() . 'module_' . strtolower($this->module->getModuleName()), $field['uppercase_name'], $field['name']);
                        $dict->ExecuteSQLArray($sqlarray);
                    }
                }
            }
        }
    }

    private function publishFile($destination, $source = null, $extra_assigns = array())
    {
        if (is_null($source)) $source = $destination . '.tpl';

        $tpl = new MCFTemplate($this->module->getModuleName(), $source, $destination);
        $tpl->assign('module', $this->module);
        $tpl->assign('table_name', strtolower($this->module->getModuleName()));

        foreach ($extra_assigns as $key => $value) {
            $tpl->assign($key, $value);
        }

        if ($this->module->getParentModule()) {
            $tpl->assign('has_admin', 'false');
        } elseif (!is_null($this->module->getShowModule()) && $this->module->getShowModule() == 0) {
            $tpl->assign('has_admin', 'false');
        } else {
            $tpl->assign('has_admin', 'true');
        }

        $tpl->assign('admin_section', ($this->module->getAdminSection() != '') ? $this->module->getAdminSection() : 'content');
        $tpl->assign('parent_module', $this->module->getParentModule() ? MCFModule::retrieveByPk($this->module->getParentModule()) : false);
        $tpl->assign('child_modules', $this->module->getChildModules());
        $tpl->assign('is_protected', $this->module->getIsProtected());
        $tpl->assign('files_path', $this->module->getFilesPath());
        $mcfactory = cms_utils::get_module('MCFactory');
        $tpl->assign('mcfactoryversion', $mcfactory->getVersion());
        $tpl->assign('mcfactory_version', $mcfactory->GetVersion());
        $tpl->assign('title_label', $this->module->getTitleLabel());
        $tpl->assign('structure', $this->module->getStructure());

        $extra_fields = $this->module->getOldExtraFields();
        $fieldTypes = $this->module->getFieldTypes();

        $tpl->assign('first_tab_fieldset', $this->module->getStructure()->getFirstTabFieldset());

        // TODO : REFACTORISE THAT FOR STRUCTURE
        foreach ($extra_fields as &$field) {
            $field['place'] = $this->module->getStructure()->findField($field['name']);
            $field['camelcase'] = MCFModule::Camelise($field['name']);
            $field['friendlyname'] = MCFModule::Camelise($field['name'], ' ');
            $field['label'] = addslashes(($field['label']));
            $field['column_type'] = $fieldTypes[$field['type']]['column_type'];
            $field['form_type'] = $fieldTypes[$field['type']]['form_type'];

            if ($field['name'] == 'rate') {
                $tpl->assign('ratable', true);
            }

            if (isset($field['options'])) {
                if ((strpos($field['options'], ';') !== false) || (strpos($field['options'], ':') !== false)) {
                    $options = explode(';', $field['options']);
                    foreach ($options as $option) {
                        $val = explode(':', $option);
                        if (count($val) > 1) $field['foptions'][$val[0]] = $val[1];
                        unset($val);
                    }
                } else {
                    // Means we are old school ?
                    $field['foptions']['values'] = $field['options'];
                }
            }
            if ($field['type'] == 'select') {
                $values = explode(',', $field['foptions']['values']);
                foreach ($values as &$value) {
                    if (strpos($value, '=>') === false) {
                        $value = "'" . trim($value) . "' => '" . trim($value) . "'";
                    } else {
                        list($key, $nvalue) = explode('=>', $value);
                        $value = "'" . trim($key) . "' => '" . trim($nvalue) . "'";
                    }
                }
                unset($value);
                $field['select_options'] = 'array(' . implode(', ', $values) . ')';
            }
            if ($field['type'] == 'country') {
                if (isset($field['foptions']['options'])) {
                    $whitelist = explode(',', $field['foptions']['options']);
                } elseif ($field['foptions']['values']) {
                    $whitelist = explode(',', $field['foptions']['values']);
                } else {
                    $whitelist = array_keys(MCFactory::$countries);
                }
                $values = array();
                $countries = MCFactory::$countries;
                asort($countries);
                foreach ($countries as $code => $country) {
                    $country = addslashes($country);
                    if (in_array($code, $whitelist)) {
                        $values[] = "'" . trim($code) . "' => '" . trim($country) . "'";
                    }
                }
                $field['select_options'] = 'array(' . implode(', ', $values) . ')';
            }
            if ($field['type'] == 'date') {
                if ((strpos($field['options'], ';') !== false)) {
                    $options = explode(';', $field['options']);
                } else {
                    $options = explode('|', $field['options']);
                }
                $val = array();
                foreach ($options as $option) {
                    $v = explode(':', $option);
                    if (count($v) == 2) $val[$v[0]] = $v[1];
                }
                $field['date_options'] = $val;
            }
            if ($field['type'] == 'image') {
                if (isset($field['foptions']['size'])) {
                    list($field['image_width'], $field['image_height']) = explode('x', $field['foptions']['size']);
                } else {
                    list($field['image_width'], $field['image_height']) = explode('x', $field['options']);
                }
            }
            if ($field['type'] == 'module') {
                //$field['module_options'] = $field['foptions'];
                if (!isset($field['foptions']['module_name'])) $field['foptions']['module_name'] = $field['foptions']['values'];
                //$field['foptions']['module_name'] = isset($field['foptions']['module_name'])?$field['foptions']['module_name']:$field['foptions']['values'];
            }
        }

        unset($field);

        $tpl->assign('extra_fields', $extra_fields);
        if ($this->module->getIsUserModule()) {
            $tpl->assign('is_user_module', 1);
        }

        $filters = $this->module->getFilters();
        $filterTypes = $this->module->getFilterTypes();
        foreach ($filters as &$filter) {
            $filter['criteria'] = $filterTypes[$filter['type']]['criteria'];
        }
        unset($filter);

        $tpl->assign('filters', $filters);

        // Extra features
        $tpl->assign('events', $this->module->getExtraFeatures()->getEvents());


        if ($tpl->save() === false) {
            throw new Exception('Cannot generate the template ' .$destination . ' for an unknown reason');
        }
    }

}