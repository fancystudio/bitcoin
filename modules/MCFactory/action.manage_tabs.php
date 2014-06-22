<?php
if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if(isset($params['module_id']) && $params['module_id'] != '')
{
	$module = MCFModule::retrieveByPk($params['module_id']);
	if ($module)
	{
		$structure = $module->getStructure();
		
		if($params['name'] && $params['name'] != '')
		{
			$structure->setTab($params['name']);
			$module->setStructure($structure);			
			$module->save();			
		}
		
		if($params['remove_tab'] && $params['remove_tab'] != '')
		{
			$structure->removeTab($params['remove_tab']);
			$module->setStructure($structure);			
			$module->save();			
		}
		
		
		$this->Redirect($id, 'edit', $returnid, array('module_id' => $module->getId()));
	}
}
echo 'An error occurred. Did you save your module first ? Please try again.';