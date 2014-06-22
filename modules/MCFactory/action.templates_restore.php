<?php
if (!cmsms()) exit;
if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if (isset($params['module_id']) && $params['module_id'] != '')
{
	$module = MCFModule::retrieveByPk($params['module_id']);
}

// TEMPLATES
// First, we check if the module is installed
if (MCFTools::IsModuleActive($module->getModuleName()))
{
	$mod = cms_utils::get_module($module->getModuleName());
	$templates = unserialize(base64_decode($module->getTemplatesData()));
	
	foreach($templates as $template)
	{
		$mod->setTemplate($template['name'], $template['data']);
		if($template['is_default'] !== false)
		{
				$mod->AddDefaultTemplate($template['is_default'], $template['name']);
		}
	}
}

return $this->Redirect($id,'edit',$returnid,array('module_id' => $params['module_id']));