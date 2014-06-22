<?php

/**
 * MCFModule Class
 *
 * This class handle all the manipulations on the M&C Factory Module object
 *
 * NOTE: It should be split in two classes but for convenience, It won't.
 *
 * FIXME: Check the security processes !
 *
 */

class MCFModule
{
    protected $id;

    protected $created_at;
    protected $created_by;
    protected $updated_at;
    protected $updated_by;

    protected $module_name;
    protected $module_friendlyname;
    protected $module_version = 1;

    /**
     * @var array $fields Module fields
     */
    protected $fields;
    protected $actions;

    // GETTERS

    /**
     * Get the MC Factory Module's ID
     * @return int Module ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        if(empty($this->fields)) $this->fields = $this->retrieveFields();
        return $this->fields;
    }

    /**
     * @return array
     */
    private function retrieveFields()
    {
        $c = new MCFCriteria();
        $c->add('module_id', $this->getId());
        return MCFModuleField::doSelect($c);
    }

    /**
     * Get all the module's custom actions
     * @since 3.5
     * @return array
     */
    public function getActions()
    {
        if(empty($this->actions)) $this->actions = $this->fetchActions();
        return $this->actions;
    }

    /**
     * Retrieve all the module's custom actions
     * @since 3.5
     * @return array
     */
    private function fetchActions()
    {
        return MCFModuleAction::doSelect(array('where' => array('module_id' => $this->getId())));
    }

    /**
     * Get Module version
     * @return int
     */
    public function getModuleVersion()
    {
        return $this->module_version;
    }

    /**
     * Increment module version
     * @since 3.5
     */
    public function incrementModuleVersion()
    {
        $this->setModuleVersion($this->getModuleVersion() + 1);
    }

    // TO REFACTOR

    ////////////////////////////////////////////////////////////
    // CLASS PROPERTIES ////////////////////////////////////////
    ////////////////////////////////////////////////////////////



    protected $vars;

    protected $title_label;
    protected $api_enabled;
    protected $extra_fields = array();
    // protected $structure = array();
    protected $structure; // New structure of extra fields
    protected $delete_fields = array();
    protected $filters = array();
    protected $parent_module;
    protected $show_module;

    protected $admin_section;

    public static $possible_sections = array(
        'content' => 'Content',
        'layout' => 'Layout',
        'usersgroups' => 'Users & Groups',
        'extensions' => 'Extentions',
        'siteadmin' => 'Site Admin'
    );

    protected $is_user_module;
    protected $is_protected;
    protected $files_path;
    protected $module_logic;
    protected $templates_data;
    protected $extra_features;

    protected $is_modified = false;
    protected $is_new = true;

    public function __get($name)
    {
        try {
            $var = 'get' . self::Camelise($name);
            if (method_exists($this, $var)) {
                return $this->$var();
            } elseif(isset($this->vars[$name])) {
                return $this->vars[$name];
            } else {
                throw new Exception("Property $name does not exist");
            }
        } catch (Exception $e) {
            audit('', 'MCFactory', $e->getMessage());
        }

    }

    public function __set($name, $value)
    {
        if(isset($this->vars[$name]) && ($this->vars[$name] !== $value))
        {
            $this->is_modified = true;
        }
        $this->vars[$name] = $value;
    }

    /**
     * @param $name
     * @param $value
     * @deprecated
     */
    public function set($name, $value)
    {
        if ($this->$name !== $value) {
            $this->$name = $value;
            $this->is_modified = true;
        }
    }

    /**
     * Transform a name in Camel version
     * @param $name
     * @param string $glue
     * @return string
     */
    public static function Camelise($name, $glue = '')
    {
        $words = explode('_', $name);
        foreach ($words as &$word) {
            $word = ucfirst($word);
        }
        return implode($glue, $words);
    }

    // GETTER FUNCTIONS



    public function getModuleName()
    {
        if (empty($this->module_name)) {
            $value = preg_replace('/\W/', ' ', $this->module_friendlyname);
            $value = ucwords(strtolower($value));
            $value = preg_replace('/\s/', '', $value);
            $this->set('module_name', self::checkModuleNameAvailability($value));
        }
        return $this->module_name;
    }

    public function __toString()
    {
        return $this->getModuleName();
    }

    private static function checkModuleNameAvailability($module_name, $iterator = 0)
    {
        $module = $module_name;
        if ($iterator > 0) {
            $module .= $iterator;
        }

        if (cms_utils::get_module($module)) {
            $iterator++;
            return self::checkModuleNameAvailability($module_name, $iterator);
        } else {
            return $module;
        }
    }

    public function getModuleFriendlyname()
    {
        return $this->module_friendlyname;
    }

    public function getTitleLabel()
    {
        return (!empty($this->title_label)) ? $this->title_label : 'Title';
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getCreatedBy()
    {
        return $this->created_by;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    public function getExtraFields()
    {
        return $this->extra_fields;
    }

    public function getOldExtraFields()
    {
        return $this->getStructure()->getOldStructure();
    }

    public function getStructure()
    {
        if (!is_object($this->structure)) {
            $this->structure = new MCFModuleStructure($this->extra_fields, $this);
        }
        return $this->structure;
    }

    public function getDeleteFields()
    {
        return $this->delete_fields;
    }

    public function getFilters()
    {
        sort($this->filters);
        return $this->filters;
    }

    public function getParentModule()
    {
        return $this->parent_module;
    }

    public static function getPossibleParentsModule(MCFModule $module)
    {
        $c = new MCFCriteria();

        if (!$module->isNew()) {
            $c->add('id', $module->getId(), MCFCriteria::NOT_EQUAL);
        }

        $modules = MCFModule::doSelect($c);

        $possible_parents = array();
        foreach ($modules as $mod) {
            $possible_parents[$mod->getId()] = $mod->getModuleFriendlyName();
        }
        return $possible_parents;
    }

    public function getChildModules()
    {
        $c = new MCFCriteria();
        $c->add('parent_module', $this->getId());
        return self::doSelect($c);
    }

    public function getShowModule()
    {
        return $this->show_module;
    }

    public function getAPIEnabled()
    {
        return $this->api_enabled;
    }

    public function getIsUserModule()
    {
        return $this->is_user_module;
    }

    public function getIsProtected()
    {
        return $this->is_protected;
    }

    public function getFilesPath()
    {
        // Could have default path but dangerous if user do not modify it when moving the website...
        return $this->files_path; // Empty path means $config['uploads_path'];
    }

    public function getModuleLogic()
    {
        return $this->module_logic;
    }

    public function getTemplatesData()
    {
        return $this->templates_data;
    }

    public function getAdminSection()
    {
        return $this->admin_section;
    }

    public function getExtraFeatures()
    {
        if (!is_object($this->extra_features)) {
            $this->extra_features = new MCFExtraFeatures();
        }
        return $this->extra_features;
    }

    /**
     * Check if the module is new
     * @return bool
     */
    public function isNew()
    {
        return (bool)$this->is_new;
    }

    // SETTER FUNCTIONS


    public function setId($value)
    {
        $this->set('id', $value);
    }

    public function setModuleName($value)
    {
        $this->set('module_name', $value);
    }

    public function setModuleFriendlyname($value)
    {
        $this->set('module_friendlyname', $value);
    }

    public function setModuleVersion($value)
    {
        $this->set('module_version', $value);
    }

    public function setTitleLabel($value)
    {
        $this->set('title_label', $value);
    }

    public function setCreatedAt($value)
    {
        $this->set('created_at', $value);
    }

    public function setCreatedBy($value)
    {
        $this->set('created_by', $value);
    }

    public function setUpdatedAt($value)
    {
        $this->set('updated_at', $value);
    }

    public function setUpdatedBy($value)
    {
        $this->set('updated_by', $value);
    }

    /**
     * @param $value
     * @deprecated
     */
    public function setShowModule($value)
    {
        $this->show_module = $value;
    }

    /**
     * @param $value
     * @deprecated
     */
    public function setIsUserModule($value)
    {
        $this->is_user_module = $value;
    }

    public function setAPIEnabled($value)
    {
        $this->set('api_enabled', $value);
    }

    public function setIsProtected($value)
    {
        $this->set('is_protected', $value);
    }

    public function setFilesPath($value)
    {
        $this->set('files_path', $value);
    }

    public function setModuleLogic($value)
    {
        $this->set('module_logic', $value);
    }

    public function setTemplatesData($value)
    {
        $this->set('templates_data', $value);
    }

    public function setAdminSection($value)
    {
        $this->set('admin_section', $value);
    }

    public function setExtraFields($value)
    {
        $this->setExtraOldFields($value);
    }

    public function setStructure($value)
    {
        if (empty($value)) {
            $structure = new MCFModuleStructure($this->extra_fields, $this);
            $value = $structure;
        }

        if (is_object($value)) {
            $this->set('structure', $value);
        } elseif (is_array($value)) {
            $structure = new MCFModuleStructure($value, $this);
            $this->set('structure', $structure);
        } else {
            $structure = new MCFModuleStructure(unserialize($value), $this);
            $this->set('structure', $structure);
        }
    }

    public function setExtraFeatures($value)
    {
        if (is_object($value)) {
            $this->extra_features = $value;
        }
    }

    public function setExtraOldFields($value)
    {

        // DEPRECATED SEE MODULE STRUCTURE INSTEAD !!!
        $blacklist = array('id', 'parent_id', 'title', 'created_at', 'created_by', 'updated_at', 'updated_by', 'order_by', 'parent', 'parent_module', 'published', 'order', 'order_by', 'from', 'select', 'in', 'date', 'full_text_search', 'core_slug', 'coreslug', 'user_id', 'function', 'byid', 'json', 'asarray', 'searchstring', 'group', 'by', 'send_immediate_update');
        $filter = array();
        if (is_array($value)) {
            foreach ($value as $field) {
                // Reserve mcfi_ for internal use only
                $field['name'] = str_replace('mcfi_', 'mcf_', $field['name']);
                // Get label from name if undefined
                if (($field['label']) == '') {
                    $field['label'] = $field['name'];
                }

                if (preg_match("/[A-Z]/", $field['name']) === 0) {
                    $field['uppercase_name'] = $field['name'];
                }

                $field['name'] = preg_replace('/\W/', '', strtolower($field['name']));

                if (!empty($field['name'])) {
                    if (!in_array($field['name'], $blacklist)) {
                        $filter[] = $field;
                    } else {
                        $field['name'] = 'mcf_' . $field['name'];
                        $filter[] = $field;
                    }
                }
            }
        }
        $this->set('extra_fields', $filter);
    }

    public function orderExtraFields($id, $direction)
    {
        $fields = $this->getOldExtraFields();
        if ($direction == 'up') {
            $id1 = $id;
            $id2 = $id - 1;
        }

        if ($direction == 'down') {
            $id1 = $id;
            $id2 = $id + 1;
        }

        if (isset($fields[$id1]) && isset($fields[$id2])) {
            $field1 = $fields[$id1];
            $field2 = $fields[$id2];
            $fields[$id1] = $field2;
            $fields[$id2] = $field1;
        }
        $this->set('extra_fields', $fields);
    }

    public function setDeleteFields($value)
    {
        $this->set('delete_fields', $value);
    }

    public function setFilters($value)
    {
        if (is_array($value)) {
            foreach ($value as &$filter) {
                $filter['name'] = preg_replace('/\W/', '', $filter['name']);
                $filter['field'] = preg_replace('/\W/', '', $filter['field']);
            }
        }
        $this->set('filters', $value);
    }

    public function setParentModule($value)
    {
        $this->set('parent_module', $value);
        if ($value > 0) {
            if (is_array($this->filters)) {
                $exists = false;
                foreach ($this->filters as $filter) {
                    if ($filter['name'] == 'parent_item') {
                        $exists = true;
                    }
                }
                if ($exists == false) {
                    $this->filters[] = array('name' => 'parent_item', 'field' => 'parent_item', 'type' => 'equal');
                }
            }
        }
    }

    // Properties

    public function hasFieldWithType($field_type)
    {
        return $this->hasFieldWithTypes(array($field_type));
    }

    public function hasFieldWithTypes(Array $field_types)
    {
        $return = false;

        foreach ($field_types as $field_type) {
            $return = $return || $this->getStructure()->hasFieldWithType($field_type);
        }

        return $return;
    }

    public function getFieldsWithTypes(Array $fields_type)
    {
        return $this->getStructure()->getFieldsWithTypes($fields_type);
    }

    // OTHER FUNCTIONS

    /**
     * @return array
     * @deprecated
     */
    public function getFieldTypes()
    {
        return MCFModuleField::getFieldTypes();
    }

    public function getFilterTypes()
    {
        return array(
            'equal' => array(
                'type' => 'equal',
                'label' => 'Equal',
                'criteria' => 'EQUAL'
            ),
            'not_equal' => array(
                'type' => 'not_equal',
                'label' => 'Not equal',
                'criteria' => 'NOT_EQUAL'
            ),
            'like' => array(
                'type' => 'like',
                'label' => 'Like (without wildcard %)',
                'criteria' => 'LIKE'
            ),
            'like_wild' => array(
                'type' => 'like_wild',
                'label' => 'Like (with wildcard %)',
                'criteria' => 'LIKE'
            ),
            'multilike_wild' => array(
                'type' => 'multilike_wild',
                'label' => 'List Multiple Like',
                'criteria' => 'MULTILIKE'
            ),
            'multinotlike_wild' => array(
                'type' => 'multinotlike_wild',
                'label' => 'List Multiple Not Like',
                'criteria' => 'MULTINOTLIKE'
            ),
            'in' => array(
                'type' => 'in',
                'label' => 'In list (separated with ",")',
                'criteria' => 'IN'
            ),
            'less' => array(
                'type' => 'less',
                'label' => 'Less than',
                'criteria' => 'LESS_THAN'
            ),
            'less_equal' => array(
                'type' => 'less_equal',
                'label' => 'Equal or less than',
                'criteria' => 'LESS_EQUAL'
            ),
            'greater' => array(
                'type' => 'greater',
                'label' => 'Greater than',
                'criteria' => 'GREATER_THAN'
            ),
            'greater_equal' => array(
                'type' => 'greater_equal',
                'label' => 'Equal or greater than',
                'criteria' => 'GREATER_EQUAL'
            ),
            'not_empty' => array(
                'type' => 'not_empty',
                'label' => 'Not empty',
                'criteria' => 'ISNOTEMPTY'
            ),
            'empty' => array(
                'type' => 'empty',
                'label' => 'Empty',
                'criteria' => 'ISEMPTY'
            ),
            'upcoming' => array(
                'type' => 'upcoming',
                'label' => 'Upcoming date',
                'criteria' => 'UPCOMING'
            ),
            'past' => array(
                'type' => 'past',
                'label' => 'Past date',
                'criteria' => 'PAST'
            )
        );
    }

    public function populateFromArray(array $params, $modified = true)
    {
        if (isset($params['id'])) {
            $this->setId($params['id']);
        }
        if (isset($params['module_name'])) {
            $this->setModuleName($params['module_name']);
        }
        if (isset($params['module_friendlyname'])) {
            $this->setModuleFriendlyname($params['module_friendlyname']);
        }
        if (isset($params['module_version'])) {
            $this->setModuleVersion($params['module_version']);
        }
        if (isset($params['title_label'])) {
            $this->setTitleLabel($params['title_label']);
        }
        if (isset($params['created_by'])) {
            $this->setCreatedBy($params['created_by']);
        }
        if (isset($params['created_at'])) {
            $this->setCreatedAt($params['created_at']);
        }
        if (isset($params['updated_by'])) {
            $this->setUpdatedBy($params['updated_by']);
        }
        if (isset($params['updated_at'])) {
            $this->setUpdatedAt($params['updated_at']);
        }
        if (isset($params['extra_fields'])) {
            $this->setExtraFields($params['extra_fields']);
        } else {
            $this->setExtraFields(array());
        }
        if (isset($params['structure'])) {
            $this->setStructure($params['structure']);
        } else {
            //$this->setStructure(array());
        }
        if (isset($params['delete_fields'])) {
            $this->setDeleteFields($params['delete_fields']);
        }
        if (isset($params['filters'])) {
            $this->setFilters($params['filters']);
        } else {
            $this->setFilters(array());
        }
        if (isset($params['parent_module'])) {
            $this->setParentModule($params['parent_module']);
        }
        if (isset($params['show_module'])) {
            $this->setShowModule($params['show_module']);
        }
        if (isset($params['api_enabled'])) {
            $this->setAPIEnabled($params['api_enabled']);
        }
        if (isset($params['is_user_module'])) {
            $this->setIsUserModule($params['is_user_module']);
        }
        if (isset($params['is_protected'])) {
            $this->setIsProtected($params['is_protected']);
        }
        if (isset($params['files_path'])) {
            $this->setFilesPath($params['files_path']);
        }
        if (isset($params['module_logic'])) {
            $this->setModuleLogic($params['module_logic']);
        }
        if (isset($params['templates_data'])) {
            $this->setTemplatesData($params['templates_data']);
        }
        if (isset($params['admin_section'])) {
            $this->setAdminSection($params['admin_section']);
        }
        if (isset($params['extra_features'])) {
            $this->setExtraFeatures($params['extra_features']);
        }

        $this->is_new = false;

        if (!$modified) {
            $this->is_modified = false;
        }
    }

    // DATABASE FUNCTIONS

    public static function getById($id)
    {
        $sql = 'SELECT * FROM ' . cms_db_prefix() . 'module_mcfactory_modules
			WHERE id = ?';
        $values = array($id);
        $result = self::query($sql, $values);
        if ($result && $row = $result->FetchRow()) {
            $module = new self();
            $module->populateFromArray($row);
            return $module;
        } else {
            return false;
        }
    }

    public static function query($sql, $values = array())
    {
        $db = cms_utils::get_db();
        return $db->execute($sql, $values);
    }

    public static function doSelect(MCFCriteria $c)
    {

        return MCFModuleRepository::doSelect($c);
    }

    public static function doSelectOne(MCFCriteria $c)
    {
        return MCFModuleRepository::doSelectOne($c);
    }

    public static function retrieveByPk($pk)
    {
        return MCFModuleRepository::retrieveByPk($pk);
    }

    public function forceUpdate()
    {
        $this->is_modified = true;
        $this->save();
    }

    public function save()
    {
        if (empty($this->id)) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    protected function insert()
    {
        $db = cms_utils::get_db();
        $this->setId($db->GenID(cms_db_prefix() . 'module_mcfactory_modules_seq'));
        $query = 'INSERT INTO ' . cms_db_prefix() . 'module_mcfactory_modules
			SET id = ?,
				module_name = ?,
				module_friendlyname = ?,
				module_version = 1,
				title_label = ?,
				created_by = ?,
				created_at = NOW(),
				updated_by = ?,
				updated_at = NOW(),
				extra_fields = ?,
				structure = ?,
				filters = ?,
				parent_module = ?,
				show_module = ?,
				api_enabled = ?,
				is_user_module = ?,
				is_protected = ?,
				files_path = ?,
				module_logic = ?,
				templates_data = ?,
				admin_section = ?,
				extra_features = ?
				';
        $db->Execute($query, array(
            $this->getId(),
            $this->getModuleName(),
            $this->getModuleFriendlyname(),
            $this->getTitleLabel(),
            get_userid(),
            get_userid(),
            serialize($this->getStructure()->getOldStructure()),
            serialize($this->getStructure()->getStructure()),
            serialize($this->getFilters()),
            $this->getParentModule(),
            $this->getShowModule(),
            $this->getAPIEnabled(),
            $this->getIsUserModule(),
            $this->getIsProtected(),
            $this->getFilesPath(),
            $this->getModuleLogic(),
            $this->getTemplatesData(),
            $this->getAdminSection(),
            serialize($this->getExtraFeatures())
        ));
        $result = $db->Execute('SELECT LAST_INSERT_ID() AS id');
        $row = $result->FetchRow();
        $this->setId($row['id']);
        return true;
    }

    protected function update()
    {
        $db = cms_utils::get_db();
//        $this->setModuleVersion($this->getModuleVersion() + 1);
        $query = 'UPDATE ' . cms_db_prefix() . 'module_mcfactory_modules
			SET module_name = ?,
				module_friendlyname = ?,
				module_version = ?,
				title_label = ?,
				updated_by = ?,
				updated_at = NOW(),
				extra_fields = ?,
				structure = ?,
				filters = ?,
				parent_module = ?,
				show_module = ?,
				api_enabled = ?,
				is_user_module = ?,
				is_protected = ?,
				files_path = ?,
				module_logic = ?,
				templates_data = ?,
				admin_section = ?,
				extra_features = ?
			WHERE id = ?';
        $db->Execute($query, array(
            $this->getModuleName(),
            $this->getModuleFriendlyname(),
            $this->getModuleVersion(),
            $this->getTitleLabel(),
            get_userid(),
            serialize($this->getStructure()->getOldStructure()),
            serialize($this->getStructure()->getStructure()),
            serialize($this->getFilters()),
            $this->getParentModule(),
            $this->getShowModule(),
            $this->getAPIEnabled(),
            $this->getIsUserModule(),
            $this->getIsProtected(),
            $this->getFilesPath(),
            $this->getModuleLogic(),
            $this->getTemplatesData(),
            $this->getAdminSection(),
            serialize($this->getExtraFeatures()),
            $this->getId()
        ));
        return true;
    }

    public function delete()
    {
        if ($this->getId()) {
            $query = 'DELETE FROM ' . cms_db_prefix() . 'module_mcfactory_modules WHERE id = ?';
            $this->query($query, array($this->getId()));

            // Erase actions
            $actions = MCFModuleAction::doSelect(array('where' => array('module_id' => $this->getId())));
            foreach ($actions as $action) {
                $action->delete();
            }
        }
        return true;
    }

    /**
     * @return bool
     * @deprecated
     */
    public function publish()
    {
        $generator = new MCFGenerator($this);
        return $generator->publish();
    }

}

?>
