<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if (isset($params['module_id']) && !empty($params['module_id'])) 
{
	$module = MCFModule::retrieveByPk($params['module_id']);
	if(is_object($module))
	{		
		$module->forceUpdate();
        $generator = new MCFGenerator($module);

        try{
            $generator->publish();
            $this->SetFlashMessage('Module ' . $module->getModuleName() . ' published!');
            cmsms()->clear_cached_files(-1); // FORCE CLEAR CACHE
            $this->Redirect($id, 'defaultadmin', $returnid);

        } catch(Exception $e) {
            $this->SetFlashMessage('Error while generation the module: ' . $e->getMessage(), 'error');
            echo '<h3 style="color:red">Error while generation the module: ' . $e->getMessage() . '</h3>';
        }
	}
}

echo '<p>' . $this->lang('error_occured_publishing') . '</p>'; 