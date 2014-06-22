<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('Dynamickepolia', $params);

if (isset($params['item_id']) && !empty($params['item_id'])) {
	$item = DynamickepoliaObject::getById($params['item_id']);
	$order = $item->getOrderBy();
	$item->delete();
	if ($order) {
		$db = cms_utils::get_db();
		$query = 'UPDATE '.cms_db_prefix().'module_dynamickepolia SET order_by =  order_by - 1 WHERE order_by > ?';
		$db->Execute($query, array($order));
	}
}

$this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));
exit;

?>
