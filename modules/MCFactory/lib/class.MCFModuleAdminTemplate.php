<?php

class MCFModuleAdminTemplate extends MCFObject
{
    protected $module_id;
    /** @var MCFModule $module */
    protected $module;
    protected $name;
    protected $template;

    protected static $table_fields = array(
        'module_id' => 'I',
        'name' => 'C(255)',
        'template' => 'XL'
    );

    protected static $table_fields_indexes = array('module_id');

    const TABLE_NAME = 'module_mcfactory_module_admin_templates';

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
        $this->setModuleId($module->getId());
    }

    /**
     * @return MCFModule
     */
    public function getModule()
    {
        if(empty($this->module)) $this->module = MCFModule::retrieveByPk($this->getModuleId());
        return $this->module;
    }

}