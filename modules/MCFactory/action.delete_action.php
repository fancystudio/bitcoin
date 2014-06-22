<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if (isset($params['module_action_id']) && !empty($params['module_action_id'])) {
	$module_action = MCFModuleAction::retrieveByPk($params['module_action_id']);
	$module_action->delete();
	
	return $this->Redirect($id, 'edit', $returnid, array('module_id' => $module_action->module_id,'active_tab' => 'actions'));
}

return $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'actions'));