<?php
// Auto-generate File
if (!cmsms()) exit;

{{if $action_obj->is_public ne 1}}
if (!$this->CheckAccess('Manage {{$module->getModuleName()}}')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}
{{/if}}

// SPECIFIC CODE FOR THE ACTION

{{$action_obj->getCleanCode()}}