<?php
if (!cmsms()) exit;
/** @var $this MCFactory */

if (!$this->CheckAccess()) {
    return $this->DisplayErrorPage();
}

if(isset($params['cancel']))
{
    $this->Redirect($id, 'defaultadmin');
}

$form = new CMSForm($this->GetName(), $id, 'module_wizard', $returnid);
//$form->setButtons(array('submit'));
$form->setLabel('submit', $this->Lang('Continue'));

if(!isset($params['module_id']))
{
    $module = new MCFModule();
    $form->setWidget('module_friendlyname', 'text', array('label' => 'Module name', 'tips' => 'Choose a name for your module', 'placeholder' => 'Acme Directory', 'object' => &$module));


    if($form->isSent())
    {
        $form->process();

        if($form->noError())
        {
            $module->save();
            $this->Redirect($id, 'edit', $returnid, array('module_id' => $module->getId()));
//            $this->Redirect($id, 'module_wizard', $returnid, array('module_id' => $module->getId()));
        }
    }

    $template = $this->GetFileResource('admin.module_wizard_step1.tpl');
}
else
{
    $module = MCFModuleRepository::retrieveByPk($params['module_id']);
    $form->setWidget('module_id', 'hidden', array('value' => $params['module_id']));
    $smarty->assign('module_friendlyname', $module->getModuleFriendlyname());



    $form->setWidget('next', 'hidden', array('value' => 'filters'));

    $template = $this->GetFileResource('admin.module_wizard_step2.tpl');
}

$smarty->assign('form', $form);

echo $smarty->fetch($template,'|mcfactory_wizard_' . md5(serialize($params)),'');