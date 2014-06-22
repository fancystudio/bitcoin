<?php
if (!cmsms()) exit;
if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if(isset($params['module_id']))	{
	$module = MCFModule::retrieveByPk($params['module_id']);
	
	if(isset($params['delete']))
	{
		$module->getExtraFeatures()->removeEvent($params['module_name'], $params['event_name']);
		$module->save();
		return $this->Redirect($id,'edit',$returnid,array('module_id' => $params['module_id'],'active_tab' => 'extra_features'));
	}

	if(!$module){
		echo '<h1>An error occurred: Module id do not exist</h1>';
		return;
	}
	
	$params['code'] = $module->getExtraFeatures()->getEvent($params['module_name'], $params['event_name']);
	
	$form = new CMSForm($this->GetName(), $id, 'manage_event', $returnid);
	$form->setButtons(array('submit','apply','cancel'));

	if ($form->isCancelled())
	{
		return $this->Redirect($id,'edit',$returnid,array('module_id' => $params['module_id'],'active_tab' => 'extra_features'));
	}

	$form->setWidget('module_id', 'hidden', array('value' => $params['module_id']));
	
	$form->setWidget('module_name', 'text', array('value' => $params['module_name']));
	$form->setWidget('event_name', 'text', array('value' => $params['event_name']));
	$form->setWidget('code', 'codearea', array('value' => $params['code']));
	
	if($form->isPosted())
	{
		$form->process();
		if (!$form->hasErrors())
		{
			$module->getExtraFeatures()->setEvent($params['module_name'], $params['event_name'], $form->getWidget('code')->getValue());
			$module->save();

			if ($form->isSubmitted())
			{
				return $this->Redirect($id,'edit',$returnid,array('module_id' => $params['module_id'],'active_tab' => 'extra_features'));
			}
		}

	}
	
	echo $form->render();
	
		
}	else {
	echo '<h1>An error occurred: no module id defined...</h1>';
	return;
}