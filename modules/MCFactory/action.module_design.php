<?php
if (!cmsms()) exit;
/** @var $this MCFactory */

if (!$this->CheckAccess()) {
    return $this->DisplayErrorPage();
}

if(isset($params['module_id']))
{
    $module = MCFModule::retrieveByPk($params['module_id']);
    if($module)
    {
        $smarty->assign('add', $this->CreateLink($id, 'module_templates_edit', $returnid, null, array('module_id' => $module->getId()), null, true));

        echo $this->ProcessTemplate('admin.module_design.tpl');
    }
    else
    {
        throw new Exception('Not able to find the module with ID ' . $params['module_id']);
    }
}
else
{
    throw new Exception('Module ID not specified');
}
