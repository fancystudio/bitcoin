<?php

/**
 * MCFModuleStructure Class
 *
 * This class handle the global configuration of the fields inside a module
 *  *
 * FIXME: Check the security processes !
 *
 */

class MCFModuleStructure
{

    protected $structure; // Stored structure
    protected static $version = 2; // Current version of this class

    protected $module;

    /**
     * @var array
     * @deprecated Use MCFModuleField::$blacklist
     */
    public static $blacklist = array('id', 'parent_id', 'title', 'created_at', 'created_by', 'updated_at', 'updated_by', 'order_by', 'parent', 'parent_module', 'published', 'order', 'order_by', 'from', 'select', 'in', 'date', 'full_text_search', 'core_slug', 'coreslug', 'user_id', 'user', 'function', 'byid', 'json', 'asarray', 'searchstring', 'group', 'by', 'add', 'all', 'alter', 'analyze', 'and', 'as', 'asc', 'asensitive', 'before', 'between', 'bigint', 'binary', 'blob', 'both', 'by', 'call', 'cascade', 'case', 'change', 'char', 'character', 'check', 'collate', 'column', 'condition', 'constraint', 'continue', 'convert', 'create', 'cross', 'current_date', 'current_time', 'current_timestamp', 'current_user', 'cursor', 'database', 'databases', 'day_hour', 'day_microsecond', 'day_minute', 'day_second', 'dec', 'decimal', 'declare', 'default', 'delayed', 'delete', 'desc', 'describe', 'deterministic', 'distinct', 'distinctrow', 'div', 'double', 'drop', 'dual', 'each', 'else', 'elseif', 'enclosed', 'escaped', 'exists', 'exit', 'explain', 'false', 'fetch', 'float', 'float4', 'float8', 'for', 'force', 'foreign', 'from', 'fulltext', 'grant', 'group', 'having', 'high_priority', 'hour_microsecond', 'hour_minute', 'hour_second', 'if', 'ignore', 'in', 'index', 'infile', 'inner', 'inout', 'insensitive', 'insert', 'int', 'int1', 'int2', 'int3', 'int4', 'int8', 'integer', 'interval', 'into', 'is', 'iterate', 'join', 'key', 'keys', 'kill', 'leading', 'leave', 'left', 'like', 'limit', 'lines', 'load', 'localtime', 'localtimestamp', 'lock', 'long', 'longblob', 'longtext', 'loop', 'low_priority', 'match', 'mediumblob', 'mediumint', 'mediumtext', 'middleint', 'minute_microsecond', 'minute_second', 'mod', 'modifies', 'natural', 'not', 'no_write_to_binlog', 'null', 'numeric', 'on', 'optimize', 'option', 'optionally', 'or', 'order', 'out', 'outer', 'outfile', 'precision', 'primary', 'procedure', 'purge', 'read', 'reads', 'real', 'references', 'regexp', 'release', 'rename', 'repeat', 'replace', 'require', 'restrict', 'return', 'revoke', 'right', 'rlike', 'schema', 'schemas', 'second_microsecond', 'select', 'sensitive', 'separator', 'set', 'show', 'smallint', 'soname', 'spatial', 'specific', 'sql', 'sqlexception', 'sqlstate', 'sqlwarning', 'sql_big_result', 'sql_calc_found_rows', 'sql_small_result', 'ssl', 'starting', 'straight_join', 'table', 'terminated', 'then', 'tinyblob', 'tinyint', 'tinytext', 'to', 'trailing', 'trigger', 'true', 'undo', 'union', 'unique', 'unlock', 'unsigned', 'update', 'usage', 'use', 'using', 'utc_date', 'utc_time', 'utc_timestamp', 'values', 'varbinary', 'varchar', 'varcharacter', 'varying', 'when', 'where', 'while', 'with', 'write', 'xor', 'year_month', 'zerofill', 'send_update_immediately', 'level', 'events', 'event');

    // public function __toString()
    // {
    // 	return serialize($this->structure);
    // }
    //

    /**
     * @param $structure
     * @param MCFModule $module
     */
    public function __construct($structure, $module = null)
    {
        if (isset($structure['version'])) {
            // Structure is correct, we can just proceed
            $this->structure = $structure;
        } else {
            // Old structure detected: First we need to transform it
            $this->structure = self::migrateStructure($structure);
        }

        if(isset($module))
        {
            $this->module = $module;
        }

        // Example
        // $this->structure['tabs']['default']['name'] = 'Main'; // TODO : I18n
        // $this->structure['tabs']['default']['fieldsets']['default']['name'] = 'Main'; // TODO : I18n
        // $this->structure['tabs']['secondary']['name'] = 'Secondary';
        // $this->structure['tabs']['secondary']['fieldsets']['default'] = array('fields' => array());
    }

    public function getStructure()
    {
        return $this->structure;
    }

    public function getTabs()
    {
        $tabs = array();
        foreach ($this->structure['tabs'] as $tab => $info) {
            $tabs[$tab] = $info;
        }
        return $tabs;
    }

    public function setTab($name)
    {
        $key = self::cleanName($name);
        if (!isset($this->structure['tabs'][$key])) {
            $this->structure['tabs'][$key]['name'] = $name;
        }
    }

    public function removeTab($key)
    {
        if (isset($this->structure['tabs'][$key])) {
            unset($this->structure['tabs'][$key]);
        }
    }

    public function setFieldset($tab_key, $name)
    {
        if (isset($this->structure['tabs'][$tab_key])) {
            $key = self::cleanName($name);
            $this->structure['tabs'][$tab_key]['fieldsets'][$key]['name'] = $name;
        }
    }

    public function removeFieldset($tab_key, $key)
    {
        if (isset($this->structure['tabs'][$tab_key]['fieldsets'][$key])) {
            unset($this->structure['tabs'][$tab_key]['fieldsets'][$key]);
        }
    }

    public function getFieldsetsWithTabsForSelect()
    {
        $list = array();
        foreach ($this->structure['tabs'] as $tab_key => $tab) {
            if (isset($tab['fieldsets'])) {
                foreach ($tab['fieldsets'] as $fs_key => $fieldset) {
                    $list[$tab_key . '---' . $fs_key] = $tab['name'] . ': ' . $fieldset['name'];
                }
            }
        }
        return $list;
    }

    //

    public function addField($tab_key, $fieldset_key, $params)
    {
        if (!isset($params['label']) || $params['label'] == '') {
            $params['label'] = 'Default field name';
        }

        if (isset($params['name']) && $params['name'] != '') {
            $name = $params['name'];
            $this->moveField($tab_key, $fieldset_key, $name);
        } else {
            $name = $this->createNameFromLabel($params['label']);
        }

        if (isset($name)) {
            $this->structure['tabs'][$tab_key]['fieldsets'][$fieldset_key]['fields'][$name] = array(
                'label' => $params['label'],
                'name' => $name,
                'type' => $params['type'],
                'options' => str_replace(array("\n", "\r"), ' ', $params['options']),
                'column' => isset($params['column']) ? $params['column'] : null,
                'filter' => isset($params['filter']) ? $params['filter'] : null,
                'frontend' => isset($params['frontend']) ? $params['frontend'] : null
            );
        }
    }

    public function moveField($tab_key, $fieldset_key, $name)
    {
        if ($place = $this->findField($name)) {
            if (($place['tab_key'] != $tab_key) || ($place['fieldset_key'] != $fieldset_key)) {
                $this->structure['tabs'][$tab_key]['fieldsets'][$fieldset_key]['fields'][$name] = $this->structure['tabs'][$place['tab_key']]['fieldsets'][$place['fieldset_key']]['fields'][$name];
                unset($this->structure['tabs'][$place['tab_key']]['fieldsets'][$place['fieldset_key']]['fields'][$name]);
            }
        }
    }

    public function reorderFields($tab_key, $fieldset_key, $fields)
    {
        $new_fields = array();
        $f_keys = explode(',', $fields);
        foreach ($f_keys as $key) {
            $new_fields[$key] = $this->structure['tabs'][$tab_key]['fieldsets'][$fieldset_key]['fields'][$key];
        }
        $new_fields[$key] = $this->structure['tabs'][$tab_key]['fieldsets'][$fieldset_key]['fields'] = $new_fields;
    }

    public function findField($name)
    {
        foreach ($this->structure['tabs'] as $tab_key => $tab) {
            foreach ($tab['fieldsets'] as $fs_key => $fieldset) {
                foreach ($fieldset['fields'] as $field) {
                    if ($field['name'] == $name) {
                        return array('tab_key' => $tab_key, 'fieldset_key' => $fs_key, 'fieldset_name' => $fieldset['name']);
                    }
                }
            }
        }
        return null;
    }

    public function getFirstTabFieldset()
    {
        foreach ($this->structure['tabs'] as $tab_key => $tab) {
            foreach ($tab['fieldsets'] as $fs_key => $fieldset) {
                return array('tab_key' => $tab_key, 'fieldset_key' => $fs_key, 'fieldset_name' => $fieldset['name']);
            }
        }
        return null;

    }

    /**
     * @param $label
     * @return mixed|string
     * @deprecated see MCFModuleField
     */
    public function createNameFromLabel($label)
    {
        $name = self::cleanName($label, '_');
        $name = str_replace('mcfi_', 'mcf_', $name);
        if (in_array($name, self::$blacklist)) {
            $name = 'mcf_' . $name;
        }

        $original_name = $name;
        $fields = $this->getAllFieldsName();
        $i = 1;
        while (in_array($name, $fields)) {
            $name = $original_name . $i;
            $i++;
        }
        return $name;
    }

    public function getAllFieldsName()
    {
        $fields = array();

        foreach ($this->structure['tabs'] as $tab) {
            foreach ($tab['fieldsets'] as $fieldset) {
                if (isset($fieldset['fields'])) {
                    foreach ($fieldset['fields'] as $field) {
                        $fields[] = $field['name'];
                    }
                }
            }
        }
        return $fields;
    }

    public function getAllFieldsType()
    {
        $fields = array();

        foreach ($this->structure['tabs'] as $tab) {
            foreach ($tab['fieldsets'] as $fieldset) {
                if (isset($fieldset['fields'])) {
                    foreach ($fieldset['fields'] as $field) {
                        $fields[] = $field['type'];
                    }
                }
            }
        }
        return $fields;
    }

    public function getFieldsWithTypes(Array $field_types)
    {
        $fields = array();

        foreach ($this->structure['tabs'] as $tab) {
            foreach ($tab['fieldsets'] as $fieldset) {
                if (isset($fieldset['fields'])) {
                    foreach ($fieldset['fields'] as $field) {
                        if (in_array($field['type'], $field_types)) {
                            $fields[$field['name']] = $field;
                        }
                    }
                }
            }
        }
        return $fields;
    }

    public function getAllFields()
    {
        $fields = array();

        foreach ($this->structure['tabs'] as $tab) {
            foreach ($tab['fieldsets'] as $fieldset) {
                if (isset($fieldset['fields'])) {
                    foreach ($fieldset['fields'] as $field) {
                        $fields[$field['name']] = $field;
                    }
                }
            }
        }
        return $fields;
    }

    public function hasFieldWithType($field_type)
    {
        $fields_type = $this->getAllFieldsType();
        if (in_array($field_type, $fields_type)) {
            return true;
        } else {
            return false;
        }
    }

    public function removeField($name)
    {
        foreach ($this->structure['tabs'] as $tab_key => $tab) {
            foreach ($tab['fieldsets'] as $fs_key => $fieldset) {
                if (isset($fieldset['fields'][$name])) {
                    unset($this->structure['tabs'][$tab_key]['fieldsets'][$fs_key]['fields'][$name]);
                }
            }
        }
    }

    /**
     * @param $name
     * @param string $spacer
     * @return mixed|string
     * @deprecated
     */
    public static function cleanName($name, $spacer = '-')
    {
        return MCFModuleField::cleanName($name, $spacer);
    }

    public static function migrateStructure($structure)
    {
        $array = array();
        // Version 1
        $array['version'] = self::$version;

        foreach ($structure as $position => $field) {
            $array['tabs']['default']['fieldsets']['default']['fields'][$field['name']] = $field;
        }

        $array['tabs']['default']['name'] = 'Main'; // TODO : I18n
        $array['tabs']['default']['fieldsets']['default']['name'] = 'Main'; // TODO : I18n

        return $array;
    }

    public function getOldStructure()
    {
        // Version 1
        $structure = array();
        foreach ($this->structure['tabs'] as $tab) {
            if (isset($tab['fieldsets'])) {
                foreach ($tab['fieldsets'] as $fieldset) {
                    if (isset($fieldset['fields']) && is_array($fieldset['fields'])) {
                        foreach ($fieldset['fields'] as $field) {
                            $structure[] = $field;
                        }
                    }
                }
            }
        }
        return $structure;
    }

    public function upgradeStructure()
    {
        switch($this->version){
            case 1:
                $this->upgradeTo2();
        }
    }

    private function upgradeTo2()
    {
        if($this->module)
        {
            $fields = $this->getAllFields();

            foreach($fields as $field)
            {
                $new_field = new MCFModuleField();
                $new_field->setModule($this->module);
                $new_field->setLabel($field['label']);
                $new_field->setFieldName($field['name']);
                $new_field->setFieldType($field['type']);
                $new_field->setOption('options', $field['options']);
                $new_field->setOption('column', $field['column']);
                $new_field->setOption('filter', $field['filter']);
                $new_field->setOption('frontend', $field['frontend']);
                $new_field->save();
            }


            $this->version = 2;
        }
        else
        {
            throw new Exception('MCFModuleStructure: Module undefined');
        }

    }

    /* DEV NOTES

        Structure:

        Tabs => Fieldsets => Fields

    */


}