<?php

class MCFListView {

	protected $module;
	protected $view;
	protected $titleFilter;
	protected $categoryFilters = array();
	protected $pageFilters = array();
	protected $moduleFilters = array();
	protected $orderBy = 'order_by'; // OLD WAY
	protected $order_by = array('order_by');
	protected $customOrder = false;
	protected $page = 1;
	protected $itemsPerPage = 20;
	protected $is_tree = false;
	protected $active_branches = array();

	public function __construct($module, $params) {
		$this->module = $module;
		if (isset($params['view']) && $params['view']) {
      // var_dump($params['view']);
			$this->view = $params['view'];
			$this->titleFilter = isset($_SESSION['views'][$this->view]['titleFilter']) ? $_SESSION['views'][$this->view]['titleFilter'] : null;
			$this->categoryFilters = isset($_SESSION['views'][$this->view]['categoryFilters']) ? $_SESSION['views'][$this->view]['categoryFilters'] : array();
			$this->pageFilters = isset($_SESSION['views'][$this->view]['pageFilters']) ? $_SESSION['views'][$this->view]['pageFilters'] : array();
			$this->moduleFilters = isset($_SESSION['views'][$this->view]['moduleFilters']) ? $_SESSION['views'][$this->view]['moduleFilters'] : array();			
			$this->page = isset($_SESSION['views'][$this->view]['page']) ? $_SESSION['views'][$this->view]['page'] : 1;
			
			$this->active_branches = isset($_SESSION['views'][$this->view]['active_branches']) ? $_SESSION['views'][$this->view]['active_branches'] : array();	
 		} else {
			$this->view = uniqid();
		}
		if (isset($params['page'])) {
		    $this->setPage($params['page']);
		}
		if (isset($params['clear_filters'])) {
			$this->view = uniqid();
			$this->setTitleFilter(null);
			$this->setCategoryFilters(array());
			$this->setPageFilters(array());
			$this->setModuleFilters(array());			
			$this->setPage(1);
		} else {
			if (isset($params['titleFilter'])) {
				$this->setTitleFilter($params['titleFilter']);
			}
			if (isset($params['categoryFilters'])) {
				$this->setCategoryFilters($params['categoryFilters']);
			}
			if (isset($params['pageFilters'])) {
							$this->setPageFilters($params['pageFilters']);
			}
			if (isset($params['moduleFilters'])) {
				$this->setModuleFilters($params['moduleFilters']);
			}
		}
	}

	public function getView() {
		return $this->view;
	}
	
	public function getIsTree()
	{
		return (bool)$this->is_tree;
	}

	public function setIsTree($value = true)	{
		$this->is_tree = (bool)$value;
	}
	
	public function addActiveBranche($id)
	{
		$this->active_branches[$id] = $id; 
		$_SESSION['views'][$this->view]['active_branches'] = $this->active_branches;
	}
	
	public function removeActiveBranche($id)
	{
		if(isset($this->active_branches[$id]))
		{
			unset($this->active_branches[$id]);
		}		
		$_SESSION['views'][$this->view]['active_branches'] = $this->active_branches;
	}
	
	public function isBrancheOpen($id)
	{
		return isset($this->active_branches[$id]);
	}
	
	public function getActiveBranches()
	{
		return $this->active_branches;
	}
	
	public function getTitleFilter() {
		return $this->titleFilter;
	}

	public function setTitleFilter($filter) {
		$clean = trim($filter);
		$this->titleFilter = $clean;
		$_SESSION['views'][$this->view]['titleFilter'] = $clean;
		$this->customOrder = ($this->orderBy != 'order_by') || !empty($this->titleFilter) || count($this->categoryFilters) || count($this->pageFilters) || count($this->moduleFilters);
	}

	public function getCategoryFilters() {
		return $this->categoryFilters;
	}

	public function setCategoryFilters($filters) {
		$clean = array();
		foreach ($filters as $filter) {
			if (!empty($filter)) {
				$clean[] = $filter;
			}
		}
		$this->categoryFilters = $clean;
		$_SESSION['views'][$this->view]['categoryFilters'] = $clean;
		$this->customOrder = ($this->orderBy != 'order_by') || !empty($this->titleFilter) || count($this->categoryFilters) || count($this->pageFilters) || count($this->moduleFilters);
	}

	public function getPageFilters() {
		return $this->pageFilters;
	}

	public function setPageFilters($filters) {
		$clean = array();
		foreach ($filters as $filter) {
			if (!empty($filter)) {
				$clean[] = $filter;
			}
		}
		$this->pageFilters = $clean;
		$_SESSION['views'][$this->view]['pageFilters'] = $clean;
		$this->customOrder = ($this->orderBy != 'order_by') || !empty($this->titleFilter) || count($this->categoryFilters) || count($this->pageFilters) || count($this->moduleFilters);
	}	
	
	public function getModuleFilters() {
		return $this->moduleFilters;
	}

	public function setModuleFilters($filters) {
		$conditions = array();
		foreach($filters as $field => $filter)
		{
			if (!empty($filter)) 
			{
				$conditions[$field] = $filter;
			}
		}
		$this->moduleFilters = $conditions;
		$_SESSION['views'][$this->view]['moduleFilters'] = $conditions;
		$this->customOrder = ($this->orderBy != 'order_by') || !empty($this->titleFilter) || count($this->categoryFilters) || count($this->pageFilters) || count($this->moduleFilters);
	}
	
	public function resetOrderBy()
	{
		$this->order_by = array();
	}

	public function setOrderBy($value) {
		$this->resetOrderBy();
		$orders = explode(',', $value);
		foreach($orders as $order)
		{
			$this->addOrderBy(trim($order));
		}
	}
	
	public function addOrderBy($value)
	{
		$this->order_by[] = strtolower($value);
		
		$this->orderBy = implode(',',$this->order_by); // RETROCOMPATIBILITY
		
		if(!$this->customOrder)
		{
			$this->customOrder = (!in_array($this->orderBy, array('order_by', 'order_by asc', 'parent_id', 'parent_id asc'))) || !empty($this->titleFilter) || count($this->categoryFilters) || count($this->pageFilters) || count($this->moduleFilters);
		}
	}
	
	public function setItemsPerPage($value) {
		$this->itemsPerPage = $value;
	}

	public function isCustomOrder() {
		return $this->customOrder;
	}

	public function getItemsPerPage() {
		return $this->itemsPerPage;
	}

	public function getPage() {
		return $this->page;
	}

	public function setPage($page) {
		$this->page = $page;
		$_SESSION['views'][$this->view]['page'] = $page;
	}

	public function getCriteria() {
		$c = new MCFCriteria();
		if (!empty($this->titleFilter)) {
			$c->add('title', '%' . $this->titleFilter . '%', MCFCriteria::LIKE);
		}
		if (count($this->categoryFilters)) {
		  if(class_exists('MX_RelationLink'))
			$c->add('id', MX_RelationLink::getRelatedItemsIds($this->module, $this->categoryFilters, 'options', 'AND'), MCFCriteria::IN);
		}
		if (count($this->pageFilters)) {
		  if(class_exists('MX_RelationLink'))
			$c->add('id', MX_RelationLink::getRelatedItemsIds($this->module, $this->pageFilters, 'pages', 'AND'), MCFCriteria::IN);
		}
		if (count($this->moduleFilters)) {
			cms_utils::get_module($this->module)->buildFiltersCriteria($c, $this->moduleFilters);
		}
		
		
		// TREE
		if($this->is_tree)
		{
			$c->add('parent_id', array(0 => 0) + $this->active_branches, MCFCriteria::IN, ' OR parent_id IS NULL');
		}
		
		return $c;
	}

	public function getItems() {
		$totalPages = $this->getTotalPages();
		if ($this->page > $totalPages) {
			$this->setPage($totalPages);
		}
		$c = $this->getCriteria();
		
		foreach($this->order_by as $order_by)
		{
			if (preg_match('/(\w+)(?: (asc|desc))?/i', $order_by, $matches)) {
				$column = $matches[1];
				$order = isset($matches[2]) ? strtolower($matches[2]) : 'asc';
				if ($order == 'desc') {
					$c->addDescendingOrderByColumn($column);
				} else {
					$c->addAscendingOrderByColumn($column);
				}
			}
		}
		if(!$this->is_tree)
		{
			$c->setOffset(($this->page - 1) * $this->itemsPerPage);
			$c->setLimit($this->itemsPerPage);
		}
		else
		{
			// $c->setLimit();
		}

		return call_user_func(array($this->module . 'Object', 'doSelect'), $c);
	}

	public function getTotalItems() {
		$c = $this->getCriteria();
		return call_user_func(array($this->module . 'Object', 'doCount'), $c);
	}

	public function getTotalPages() {
		if ($this->itemsPerPage != 0)
		{
			return max(1, ceil($this->getTotalItems() / $this->itemsPerPage));
		}
		else
		{
			return null;
		}
	}

}

?>