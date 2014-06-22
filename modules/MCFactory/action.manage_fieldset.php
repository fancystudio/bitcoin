<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
    return $this->DisplayErrorPage();
}

if (isset($params['module_id']) && $params['module_id'] != '') {
    $module = MCFModule::retrieveByPk($params['module_id']);
} else {
    $module = new MCFModule();
    $module->setParentModule(0);
    $module->setModuleFriendlyname('Module');
    $module->save();
}

if ($module) {
    if (isset($params['tab_key'])) {
        $structure = $module->getStructure();

        if (isset($params['name']) && $params['name'] != '') {
            $structure->setFieldset($params['tab_key'], $params['name']);
            $module->setStructure($structure);
            $module->save();
        }

        if (isset($params['remove_fieldset']) && $params['remove_fieldset'] != '') {
            $structure->removeFieldset($params['tab_key'], $params['remove_fieldset']);
            $module->setStructure($structure);
            $module->save();
        }


        $this->Redirect($id, 'edit', $returnid, array('module_id' => $module->getId(), 'active_fields_tab' => $params['tab_key']));
    }
} else {
    echo 'An error occurred. Did you save your module first ? Please try again.';
}
