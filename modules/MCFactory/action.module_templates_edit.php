<?php
if (!cmsms()) exit;
/** @var $this MCFactory */

if (isset($params['admin_template_id'])) {
    $admin_template = MCFModuleAdminTemplate::retrieveByPk($params['admin_template_id']);
    $module = $admin_template->getModule();
} elseif (isset($params['module_id'])) {
    $module = MCFModule::retrieveByPk($params['module_id']);
    $admin_template = new MCFModuleAdminTemplate();
    $admin_template->setModule($module);
} else {
    throw new Exception('Module ID or Design ID not specified');
}

$form = new CMSForm($this->getName(), $id, 'module_templates_edit', $returnid);
$form->setWidget('module_id', 'hidden', array('value' => $module->getId(), 'object' => &$admin_template));
if ($admin_template->getId()) {
    $form->setWidget('admin_template_id', 'hidden', array('value' => $admin_template->getId()));
}
$form->setWidget('name', 'text', array('object' => &$admin_template));
$smarty->assign('form', $form);

// TEMPLATE

$template_form = new CMSForm($this->getName(), $id, 'module_templates_edit', $returnid);
$fields = $module->getFields();
foreach ($fields as $field) {
    /** @var MCFModuleField $field */
    $template_form->setWidget($field->getFieldName(), $field->getFormType(), array(
        'label' => $field->getLabel()
    ));
}
$smarty->assign('fields', $fields);
$smarty->assign('template_form', $template_form);

echo '<link rel="stylesheet" type="text/css" href="' . $this->loadResource('public/css/admin_template_edit.css') . '" />';

echo $this->ProcessTemplate('admin.module_templates_edit.tpl');

echo '<script type="text/javascript" src="' . $this->loadResource('public/js/admin_template_edit.js') . '"></script>';

