<?php
if (!cmsms()) exit;
if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if (isset($params['module_id']))
{
	$module = MCFModule::retrieveByPk($params['module_id']);
	
	$xmlstr = "<?xml version='1.0' ?>\n<Module></Module>";
	$xml = new SimpleXMLElement($xmlstr);
	
	// TEMPLATES
	// First, we check if the module is installed
	if (MCFTools::IsModuleActive($module->getModuleName()))
	{
		$mod = cms_utils::get_module($module->getModuleName());
		$templates_list = $mod->ListTemplates();
		$templates  = array();
		foreach($templates_list as $template)
		{
			$template_data = $mod->getTemplate($template);
			$templates[] = array(
				'name' => $template,
				'data' => $template_data,
				'is_default' =>  $mod->isDefaultTemplate($template)
			);
		}
		$module->setTemplatesData(base64_encode(serialize($templates)));
		$module->save();
	}
	
	// Module
	
	$xml->addChild('module_name', $module->getModuleName());
	$xml->addChild('module_friendly_name', $module->getModuleFriendlyname());
  $xml->addChild('module_code', base64_encode(serialize($module)));

    // FIELDS

    // TODO: EXPORT FIELDS

    // ADMIN_TEMPLATES

    // TODO: EXPORT ADMIN TEMPLATES

	// ACTIONS
	$actions = MCFModuleAction::doSelect(array('where' => array('module_id' => $params['module_id'])));	
	$datas = array();
	foreach($actions as $action)
	{
		$datas[] = array(
			'name' => $action->name,
			'code' => $action->code,
			'is_public' => $action->is_public,
			'have_permission' => $action->have_permission,
			);
	}
	$xml->addChild('module_actions', base64_encode(serialize($datas)));

	$xmlstring =  $xml->asXML();	
	
	header('Content-Description: File Transfer');
	header("Content-type: text/xml");
	header('Content-Length: ' . strlen($xmlstring));
	header('Content-Disposition: attachment; filename=' .$module->getModuleName() . '-' . $module->getModuleVersion() . '.xml');
	echo $xmlstring;
	exit;
}