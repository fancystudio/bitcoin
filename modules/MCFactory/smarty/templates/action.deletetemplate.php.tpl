<?php

if (!cmsms()) exit;

if (!$this->CheckAccess('Manage MC Factory')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('{{$module->getModuleName()}}', $params);

if (isset($params['template']) && !empty($params['template'])) {
    $this->DeleteTemplate($params['template']);
}

$this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));
exit;

?>
