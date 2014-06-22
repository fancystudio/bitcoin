<?php
if (!cmsms()) exit;
/** @var $this MCFactory */

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

$c = new MCFCriteria();
$c->addAscendingOrderByColumn('module_name');
$modules = MCFModule::doSelect($c);
$rows = array();

$tokken = isset($_REQUEST['_sx_'])?'_sx_='.$_REQUEST['_sx_']:'sp_='.$_REQUEST['sp_'];

foreach ($modules as $module) {
	$rows[] = array(
		'title' => $this->CreateLink($id, 'edit', $returnid, $module->getModuleName(), array('module_id' => $module->getId()), '', false, false, 'class="itemlink"'),
        'module_name' => $module->getModuleName(),
		'module_friendlyname' => $module->getModuleFriendlyName(),
        'edit_link' => $this->CreateLink($id, 'edit', $returnid, null, array('module_id' => $module->getId()), '', true),
		'delete' => $this->CreateLink($id, 'delete', $returnid, $this->DisplayImage('application_delete.png', 'Delete'), array('module_id' => $module->getId()), 'Are you sure you want to delete this module?\n\n(No files will be deleted but the module will no longer be editable.)'),
		'edit' => $this->CreateLink($id, 'edit', $returnid, $this->DisplayImage('application_edit.png', 'Edit'), array('module_id' => $module->getId())),
		'publish' => $this->CreateLink($id, 'publish', $returnid, $this->DisplayImage('wand.png', 'Publish'), array('module_id' => $module->getId())),
		'view' =>
		  	'<a href="moduleinterface.php?'.$tokken.'&module='.$module->getModuleName().'">'.
			$this->DisplayImage('application_home.png', 'View')
			.'</a>',
		'export' => $this->CreateLink($id, 'module_export', $returnid, $this->DisplayImage('application_get.png', 'Export'), array('module_id' => $module->getId(),'disable_theme' => 'true')),
	);
}

$this->smarty->assign('rows', $rows);
$this->smarty->assign('add', $this->CreateLink($id, 'module_wizard', '', 'Create new module'));
$this->smarty->assign('add_icon', $this->CreateLink($id, 'module_wizard', '', $this->DisplayImage('application_add.png', $this->Lang('title_create_module'))));

$form = new CMSForm($this->GetName(), $id, 'module_import',$returnid);
$form->setButtons(array('submit'));
$form->setLabel('submit', $this->lang('import'));
$form->setFieldset($this->lang('import_module'));
$form->getFieldset($this->lang('import_module'))->setWidget('module_name', 'text', array('tips' => $this->lang('leave_empty'), 'size' => 40));
$form->getFieldset($this->lang('import_module'))->setWidget('xmlfile', 'file');


$this->smarty->assign('form', $form);
echo $this->ProcessTemplate('defaultadmin.tpl');

