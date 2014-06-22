<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if (isset($params['module_id']) && !empty($params['module_id'])) {
	$module = MCFModule::getById($params['module_id']);
	$module->delete();
}

return $this->Redirect($id, 'defaultadmin', $returnid);