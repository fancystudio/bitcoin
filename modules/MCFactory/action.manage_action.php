<?php
if (!cmsms()) exit;
if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if (isset($params['module_action_id']) && $params['module_action_id'] != '')
{
	$action = MCFModuleAction::retrieveByPk($params['module_action_id']);
}

if ((!isset($action)) || is_null($action))
{
	$action = new MCFModuleAction();
	$action->module_id = $params['module_id'];
}

$form = new CMSForm($this->GetName(), $id, 'manage_action', $returnid);
$form->setButtons(array('submit','apply','cancel'));

if ($form->isCancelled())
{
	return $this->Redirect($id,'edit',$returnid,array('module_id' => $action->module_id,'active_tab' => 'actions'));
}

$form->setWidget('module_action_id', 'hidden', array('object' => &$action, 'field_name' => 'id', 'get_method' => 'getId'));
$form->setWidget('module_id', 'hidden', array('object' => &$action));

$form->setWidget('name', 'text', array('object' => &$action, 'validators' => array('not_empty' => true)));
$form->setWidget('code', 'codearea', array('object' => &$action));

$form->setWidget('is_public', 'checkbox', array('object' => &$action));
$form->setWidget('have_permission', 'checkbox', array('object' => &$action));
$form->setWidget('button', 'select', array('object' => &$action, 'values' => (array('' => 'none') + MCFModuleAction::$button_places)
));
$form->setWidget('button_name', 'text', array('object' => &$action));

if($form->isPosted())
{
	$form->process();
	if (!$form->hasErrors())
	{
		$action->save();
		
		if ($form->isSubmitted())
		{
			return $this->Redirect($id,'edit',$returnid,array('module_id' => $action->module_id,'active_tab' => 'actions'));
		}
		else
		{
			return $this->Redirect($id,'manage_action',$returnid, array('module_action_id' => $action->getId(),'active_tab' => 'actions'));
		}
	}
	
}

echo $form->render();