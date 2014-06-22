<?php
if (!cmsms()) exit;
if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if (is_uploaded_file($_FILES[$id.'xmlfile']['tmp_name']))
{
	$xml_content = file_get_contents($_FILES[$id.'xmlfile']['tmp_name']);
	
	$xml = simplexml_load_string($xml_content);
	
	$module_name =  (string)$xml->module_name;
	$module_friendly_name = $module_name;
	
	foreach($xml as $field)
	{
	  if('module_friendly_name' == $field->getName())
	  {
	    $module_friendly_name = (string)$xml->module_friendly_name;
	  }
	}
	
	if (isset($params['module_name']) && $params['module_name'] != '')
	{
		$module_friendly_name = $params['module_name'];
		$module_name = null;
	}
	
	$module = unserialize(base64_decode($xml->module_code));

	$module->setId(null);
	$module->setModuleName($module_name);
	$module->setModuleFriendlyName($module_friendly_name);
	$module->save();
	
	if(isset($xml->module_actions))
	{
		$actions = unserialize(base64_decode($xml->module_actions));
		if (is_array($actions))
		{
			foreach($actions as $action)
			{
				$new_action =  new MCFModuleAction();
				$new_action->module_id = $module->getId();
				$new_action->name = $action['name'];
				$new_action->code = $action['code'];
				$new_action->is_public = $action['is_public'];
				$new_action->have_permission = $action['have_permission'];
				$new_action->save();
			}
		}
	}	
}

	$this->Redirect($id, 'defaultadmin', $returnid);