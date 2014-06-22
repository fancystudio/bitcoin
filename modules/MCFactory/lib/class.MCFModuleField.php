<?php

/**
 * Class MCFModuleField
 */
class MCFModuleField extends MCFObject
{

    /**
     * @var
     */
    protected $module_id;
    /**
     * @var
     */
    protected $module;
    /**
     * @var int
     */
    protected $position;
    /**
     * @var
     */
    protected $label;
    /**
     * @var
     */
    protected $field_name;
    /**
     * @var
     */
    protected $field_type = 'text';

    public static $field_types = array(
        'text' => array(
            'type' => 'text',
            'label' => 'Text field',
            'column_type' => 'C(255)',
            'form_type' => 'text',
            'options' => true
        ),
        'textarea' => array(
            'type' => 'textarea',
            'label' => 'Text area',
            'column_type' => 'X',
            'form_type' => 'textarea',
            'options' => true
        ),
        'textarea_plain' => array(
            'type' => 'textarea_plain',
            'label' => 'Text area (no WYSIWYG)',
            'column_type' => 'X',
            'form_type' => 'textarea_plain',
            'options' => true
        ),
        'textarea_code' => array(
            'type' => 'textarea_code',
            'label' => 'Text area (code)',
            'column_type' => 'X',
            'form_type' => 'textarea_code',
            'options' => true
        ),
        'select' => array(
            'type' => 'select',
            'label' => 'Select (Dropdown)',
            'column_type' => 'C(255)',
            'form_type' => 'select',
            'options' => true,
            'options_default' => 'values:option1=>Option 1,option2=>Option2;'
        ),
        'checkbox' => array(
            'type' => 'checkbox',
            'label' => 'Checkbox',
            'column_type' => 'I',
            'form_type' => 'checkbox',
            'options' => true,
            'options_default' => 'text:My checkbox text;'
        ),
        'date' => array(
            'type' => 'date',
            'label' => 'Date',
            'column_type' => 'D',
            'form_type' => 'text',
            'options' => true,
        ),
        'time' => array(
            'type' => 'time',
            'label' => 'Time',
            'column_type' => 'T',
            'form_type' => 'text',
            'options' => true,
            'options_default' => 'midnight: false;'
        ),
        'datetime' => array(
            'type' => 'datetime',
            'label' => 'Date & Time',
            'column_type' => 'I',
            'form_type' => 'datetime',
            'options' => true,
        ),
        'document' => array(
            'type' => 'document',
            'label' => 'Document',
            'column_type' => 'C(255)',
            'form_type' => 'file',
            'options' => true
        ),
        'image' => array(
            'type' => 'image',
            'label' => 'Image',
            'column_type' => 'C(255)',
            'form_type' => 'file',
            'options' => true,
            'options_default' => 'size:150x150;'
        ),
        'country' => array(
            'type' => 'country',
            'label' => 'Country',
            'column_type' => 'C(255)',
            'form_type' => 'select',
            'options' => true,
            'options_default' => ''
        ),
        'hidden_text' => array(
            'type' => 'hidden_text',
            'label' => 'Hidden text',
            'column_type' => 'C(255)',
            'form_type' => 'none',
            'options' => false
        ),
        'static' => array(
            'type' => 'static',
            'label' => 'Static value',
            'column_type' => 'X',
            'form_type' => 'static',
            'options' => false
        ),
        'module' => array(
            'type' => 'module',
            'label' => 'Module',
            'column_type' => 'C(255)',
            'form_type' => 'module',
            'options' => true,
            'options_default' => 'module_name:MyModuleName;'
        ),
        'page' => array(
            'type' => 'page',
            'label' => 'Page',
            'column_type' => 'C(255)',
            'form_type' => 'page',
            'options' => true
        ),
        'user' => array(
            'type' => 'user',
            'label' => 'CMS User',
            'column_type' => 'C(255)',
            'form_type' => 'user',
            'options' => true
        ),
        'group' => array(
            'type' => 'group',
            'label' => 'CMS Group',
            'column_type' => 'C(255)',
            'form_type' => 'group',
            'options' => true
        )
    );

    protected $options_data;

    protected $options = array();

    protected static $table_fields = array(
        'module_id' => 'I',
        'position' => 'I',
        'label' => 'C(255)',
        'field_name' => 'C(255)',
        'field_type' => 'C(255)',
        'options_data' => 'XL'
    );

    protected static $table_fields_indexes = array('module_id', 'position', 'field_name');

    public static $blacklist = array('id', 'parentid', 'title', 'createdat', 'createdby', 'updatedat', 'updatedby', 'orderby', 'parent', 'parentmodule', 'published', 'order', 'orderby', 'from', 'select', 'in', 'date', 'fulltextsearch', 'coreslug', 'coreslug', 'userid', 'user', 'function', 'byid', 'json', 'asarray', 'searchstring', 'group', 'by', 'add', 'all', 'alter', 'analyze', 'and', 'as', 'asc', 'asensitive', 'before', 'between', 'bigint', 'binary', 'blob', 'both', 'by', 'call', 'cascade', 'case', 'change', 'char', 'character', 'check', 'collate', 'column', 'condition', 'constraint', 'continue', 'convert', 'create', 'cross', 'currentdate', 'currenttime', 'currenttimestamp', 'currentuser', 'cursor', 'database', 'databases', 'dayhour', 'daymicrosecond', 'dayminute', 'daysecond', 'dec', 'decimal', 'declare', 'default', 'delayed', 'delete', 'desc', 'describe', 'deterministic', 'distinct', 'distinctrow', 'div', 'double', 'drop', 'dual', 'each', 'else', 'elseif', 'enclosed', 'escaped', 'exists', 'exit', 'explain', 'false', 'fetch', 'float', 'float4', 'float8', 'for', 'force', 'foreign', 'from', 'fulltext', 'grant', 'group', 'having', 'highpriority', 'hourmicrosecond', 'hourminute', 'hoursecond', 'if', 'ignore', 'in', 'index', 'infile', 'inner', 'inout', 'insensitive', 'insert', 'int', 'int1', 'int2', 'int3', 'int4', 'int8', 'integer', 'interval', 'into', 'is', 'iterate', 'join', 'key', 'keys', 'kill', 'leading', 'leave', 'left', 'like', 'limit', 'lines', 'load', 'localtime', 'localtimestamp', 'lock', 'long', 'longblob', 'longtext', 'loop', 'lowpriority', 'match', 'mediumblob', 'mediumint', 'mediumtext', 'middleint', 'minutemicrosecond', 'minutesecond', 'mod', 'modifies', 'natural', 'not', 'nowritetobinlog', 'null', 'numeric', 'on', 'optimize', 'option', 'optionally', 'or', 'order', 'out', 'outer', 'outfile', 'precision', 'primary', 'procedure', 'purge', 'read', 'reads', 'real', 'references', 'regexp', 'release', 'rename', 'repeat', 'replace', 'require', 'restrict', 'return', 'revoke', 'right', 'rlike', 'schema', 'schemas', 'secondmicrosecond', 'select', 'sensitive', 'separator', 'set', 'show', 'smallint', 'soname', 'spatial', 'specific', 'sql', 'sqlexception', 'sqlstate', 'sqlwarning', 'sqlbigresult', 'sqlcalcfoundrows', 'sqlsmallresult', 'ssl', 'starting', 'straightjoin', 'table', 'terminated', 'then', 'tinyblob', 'tinyint', 'tinytext', 'to', 'trailing', 'trigger', 'true', 'undo', 'union', 'unique', 'unlock', 'unsigned', 'update', 'usage', 'use', 'using', 'utcdate', 'utctime', 'utctimestamp', 'values', 'varbinary', 'varchar', 'varcharacter', 'varying', 'when', 'where', 'while', 'with', 'write', 'xor', 'yearmonth', 'zerofill', 'sendupdateimmediately', 'level', 'events', 'event');

    const TABLE_NAME = 'module_mcfactory_module_fields';

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $field_name
     */
    public function setFieldName($field_name)
    {
        $this->field_name = $field_name;
    }

    /**
     * @return mixed
     */
    public function getFieldName()
    {
        if (empty($this->field_name)) {
            $this->field_name = $this->createFieldnameFromLabel();
        }
        return $this->field_name;
    }

    /**
     * @param $field_type
     * @throws Exception
     */
    public function setFieldType($field_type)
    {
        if (!self::checkFieldType($field_type)) {
            throw new Exception('Unknown field type: ' . $field_type);
        }
        $this->field_type = $field_type;
    }

    /**
     * @return mixed
     */
    public function getFieldType()
    {
        return $this->field_type;
    }

    public static function getFieldTypes()
    {
        $field_types = self::$field_types;

        $field_types['date']['options_default'] = 'start_year:' . date('Y', strtotime('-1 year')) . ';';
        $field_types['datetime']['options_default'] = 'start_year:' . date('Y', strtotime('-1 year')) . ';';

        if (class_exists('CMSFormInputFiles')) {
            // TODO: Find a way to insert that info from the MCMedias module
            $field_types['files'] = array(
                'type' => 'files',
                'label' => 'Multiple files',
                'column_type' => 'C(255)',
                'form_type' => 'files',
                'options' => true
            );
        }

        if (class_exists('CMSFormInputImages')) {
            // TODO: Find a way to insert that info from the MCMedias module
            $field_types['images'] = array(
                'type' => 'images',
                'label' => 'Multiple images',
                'column_type' => 'C(255)',
                'form_type' => 'images',
                'options' => true
            );
        }

        return $field_types;
    }

    private function getFieldSettings()
    {
        $fields = self::getFieldTypes();
        if(isset($fields[$this->field_type]))
        {
            return $fields[$this->field_type];
        }
        else
        {
            throw new Exception('No type found for field type ' . $this->field_type);
        }
    }

    public function getFormType()
    {
        $field = $this->getFieldSettings();
        return $field['form_type'];
    }

    public static function checkFieldType($type)
    {
        $types = array_keys(self::getFieldTypes());
        return in_array($type, $types);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $module_id
     */
    private function setModuleId($module_id)
    {
        $this->module_id = $module_id;
    }

    /**
     * @return mixed
     */
    public function getModuleId()
    {
        return $this->module_id;
    }

    /**
     * @param MCFModule $module
     */
    public function setModule(MCFModule $module)
    {
        $this->module = $module;
        $this->module_id = $module->getId();
    }

    /**
     * @return MCFModule
     */
    public function getModule()
    {
        if (empty($this->module)) {
            $this->module = MCFModule::retrieveByPk($this->module_id);
        }
        return $this->module;
    }

    /**
     * @param mixed $options_data
     */
    public function setOptionsData($options_data)
    {
        $this->options_data = $options_data;
        $this->options = json_decode($this->options_data, true);
    }

    /**
     * @return mixed
     */
    public function getOptionsData()
    {
        $this->options_data = json_encode($this->options);
        return $this->options_data;
    }



    /**
     * @param $name
     * @param $value
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }



    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        if (is_null($this->position)) {
            $this->position = $this->nextPosition();
        }
        return $this->position;
    }

    private function nextPosition()
    {
        $c = new MCFCriteria();
        $c->add('module_id', $this->getModuleId());
        $c->addDescendingOrderByColumn('position');
        $last_field = self::doSelectOne($c);
        if ($last_field) {
            return (int)$last_field->getPosition() + 1;
        }
        return 0;
    }


    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_by
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    private static function isBlacklistedField($name)
    {
        $name = self::cleanName($name, '', array('_'));
        if (in_array($name, static::$blacklist)) {
            return true;
        }
        return false;
    }

    public function createFieldnameFromLabel()
    {
        $name = self::cleanName($this->getLabel(), '_');
        $name = str_replace('mcfi_', 'mcf_', $name);
        if (self::isBlacklistedField($name)) {
            $name = 'mcf_' . $name;
        }

        $original_name = $name;
        $i = 1;
        while ($this->checkIfFieldnameExists($name)) {
            $name = $original_name . $i;
            $i++;
        }
        return $name;
    }

    private function checkIfFieldnameExists($field_name)
    {
        $c = new MCFCriteria();
        $c->add('module_id', $this->getModuleId());
        $c->add('field_name', $field_name);
        if ($field = self::doSelectOne($c)) {
            return true;
        }
        return false;
    }


    public static function cleanName($name, $spacer = '-', $include = array())
    {
        $result = strtolower($name);
        // Remove accents
        $result = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $result);

        // Soft way
        $result = str_replace("#", "No.", $result);
        $result = str_replace("$", "Dollar", $result);
        $result = str_replace("%", "Percent", $result);
        $result = str_replace("^", " ", $result);
        $result = str_replace("&", "and", $result);
        $result = str_replace("*", " ", $result);
        $result = str_replace("?", " ", $result);
        $result = str_replace(",", " ", $result);
        $result = str_replace("'", " ", $result);
        $result = str_replace('"', " ", $result);
        $result = str_replace(".", " ", $result);

        foreach ($include as $character) {
            $result = str_replace($character, " ", $result);
        }

        // strip all non word chars
        $result = preg_replace('/((?![-a-zA-Z0-9 _]).)+/s', ' ', $result);

        // replace all white space sections with a dash
        $result = preg_replace('/\ +/', $spacer, $result);
        // trim dashes
        $result = preg_replace('/\-$/', '', $result);
        $result = preg_replace('/^\-/', '', $result);
        return $result;
    }
}