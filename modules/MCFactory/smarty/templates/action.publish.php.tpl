<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('{{$module->getModuleName()}}', $params);

$item = {{$module->getModuleName()}}Object::getById($params['item_id']);
$item->setPublished($item->getPublished() ? 0 : 1);
$item->save();

{{if $parent_module}}
$parent = new {{$parent_module->getModuleName()}}();
$parent->Redirect($id, 'edit', $returnid, array('view' => $view->getView(), 'item_id' => $item->getParentItem(), 'tab' => $this->getName()));
{{else}}
$this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));
{{/if}}

?>
