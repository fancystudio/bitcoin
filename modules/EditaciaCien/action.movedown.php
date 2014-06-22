<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('EditaciaCien', $params);

if (isset($params['item_id']) && !empty($params['item_id'])) {
	$item = EditaciaCienObject::getById($params['item_id']);
	$pos1 = $item->getOrderBy();
	$parent_item = $item->getParentItem();
	$c = new MCFCriteria();
	$c->add('order_by', $pos1, MCFCriteria::GREATER_THAN);
	if ($parent_item) {
	    $c->add('parent_item', $parent_item);
	}
	
	if ($this->getPreference('show_parent', '0') == 1)
	{
		if($item->getParentId() > 0)
		{
			$c->add('parent_id', $item->getParentId());
		}
		else
		{
			$c->add('parent_id', 0, MCFCriteria::EQUAL, ' OR parent_id IS NULL');
		}
	}
	
	$c->addAscendingOrderByColumn('order_by');
	$c->setLimit(1);
	if ($next = EditaciaCienObject::doSelectOne($c)) {
	    $pos2 = $next->getOrderBy();
	    $next->setOrderBy($pos1);
	    $next->save();
	    $item->setOrderBy($pos1+1);
	    $item->save();
	}
}

$this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));
exit;

?>
