<?php
if (!cmsms()) exit;

if(isset($_SESSION['{{$module->getModuleName()}}']['view']) && !isset($params['view']))
{
	$params['view'] = $_SESSION['{{$module->getModuleName()}}']['view'];
}
	
	$view = new MCFListView('{{$module->getModuleName()}}', $params);
	
	if(isset($params['open_branche']))
	{
		$view->addActiveBranche($params['open_branche']);
	}
	
	if(isset($params['close_branche']))
	{
		$view->removeActiveBranche($params['close_branche']);		
	}
	

	if ($this->getPreference('show_parent', '0') == 1)
	{
		// We switch to parents mode
		$view->setOrderBy('parent_id ASC, order_by ASC');		
		$view->setIsTree();
	}
	else
	{
		$view->setOrderBy($this->getPreference('order_by', 'order_by') . ' ' . $this->getPreference('order_by_direction', 'asc'));
		$view->setItemsPerPage($this->getPreference('items_per_page', '25'));
	}



$items = $view->getItems();

$this->smarty->assign('items_top', $this->getButtonsFor('items_top'));
$this->smarty->assign('items_bottom', $this->getButtonsFor('items_bottom'));
$this->smarty->assign('filters_buttons', $this->getButtonsFor('filters'));

echo {{$module->getModuleName()}}Views::adminItems($this,$id,$returnid,$view,$items);	

$_SESSION['{{$module->getModuleName()}}']['view'] = $view->getView();