<?php
if(!cmsms()) exit;
/** @var $this MCFactory */
//
//$module = MCFModule::retrieveByPk(2);
//
//// DEV CLEAN
////MCFModuleField::deleteTable();
////MCFModuleField::createTable();
//
//
//
////echo '<pre>';
////var_dump($module->getStructure()->getStructure());
////echo '</pre>';
//
////$module->getStructure()->upgradeStructure();
//
//$form = new CMSForm($this->getName(), $id, 'dev', $returnid);
//$fields = $module->getFields();
//
//foreach($fields as $field)
//{
//    /** @var MCFModuleField $field */
//    $form->setWidget($field->getFieldName(), $field->getFormType(), array(
//        'label' => $field->getLabel()
//    ));
//}
//
//$smarty->assign('form', $form);
//$smarty->assign('fields', $fields);
//
//echo '<link rel="stylesheet" type="text/css" href="' . $this->loadResource('public/css/admin_template_edit.css'). '" />';
//
//echo $this->ProcessTemplate('admin.edit_admin_template.tpl');
//
//echo '<script type="text/javascript" src="' . $this->loadResource('public/js/admin_template_edit.js') . '"></script>';
