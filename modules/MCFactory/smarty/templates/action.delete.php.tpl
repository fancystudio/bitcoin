<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('{{$module->getModuleName()}}', $params);

if (isset($params['item_id']) && !empty($params['item_id'])) {
	$item = {{$module->getModuleName()}}Object::getById($params['item_id']);
	$order = $item->getOrderBy();
	$item->delete();
	if ($order) {
		$db = cms_utils::get_db();
		$query = 'UPDATE '.cms_db_prefix().'module_{{$table_name}} SET order_by =  order_by - 1 WHERE order_by > ?';
		$db->Execute($query, array($order));
	}
}

{{if $parent_module}}
$parent = new {{$parent_module->getModuleName()}}();
$parent->Redirect($id, 'edit', $returnid, array('view' => $view->getView(), 'item_id' => $item->getParentItem()));
{{else}}
$this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));
{{/if}}
exit;

?>
