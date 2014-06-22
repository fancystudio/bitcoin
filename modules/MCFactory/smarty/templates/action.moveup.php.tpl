<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('{{$module->getModuleName()}}', $params);

if (isset($params['item_id']) && !empty($params['item_id'])) {
	$item = {{$module->getModuleName()}}Object::getById($params['item_id']);
	$pos1 = $item->getOrderBy();
	$parent_item = $item->getParentItem();
	$c = new MCFCriteria();
	$c->add('order_by', $pos1, MCFCriteria::LESS_THAN);
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
	
	$c->addDescendingOrderByColumn('order_by');
	$c->setLimit(1);
	if ($prev = {{$module->getModuleName()}}Object::doSelectOne($c)) {
	    $pos2 = $prev->getOrderBy();
	    $prev->setOrderBy($pos2+1);
	    $prev->save();
	    $item->setOrderBy($pos2);
	    $item->save();
	}
	elseif($item->order_by > 1)
	{
		$item->setOrderBy(1);
    $item->save();
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
