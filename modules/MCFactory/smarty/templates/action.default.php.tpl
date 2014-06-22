<?php

if (!cmsms()) exit;

$c = new MCFCriteria();
if(isset($params['show_user_items']) && MCFTools::IsModuleActive('CMSUsers'))
{
	$user = CMSUsers::getUserOrLogin();
	if (is_object($user))
	{
		$c->add('user_id', $user->getId());
	}
	else
	{
		$c->add('published', '1');
	}
}
else
{
	$c->add('published', '1');
}


{{$module->getModuleName()}}Object::buildFrontendFilters($c, $params);
{{$module->getModuleName()}}Object::globalFrontendFilters($c, $params);


if (isset($params['calendar']) && isset($params['start_date']) && isset($params['end_date']))
{
	$calendar = new MCFCalendar(time());
  $c->add('start_date', $params['start_date'], MCFCriteria::LESS_EQUAL);
  $c->add('end_date', $params['end_date'], MCFCriteria::GREATER_EQUAL);
	
}
elseif (isset($params['calendar']) && isset($params['month_from_date']))
{
   $calendar_time = strtotime($params['month_from_date']);
   $calendar = new MCFCalendar($calendar_time);
   $c->add('start_date', date('Y/m/d', $calendar->end_date), MCFCriteria::LESS_EQUAL);
   $c->add('end_date', date('Y/m/d', $calendar->start_date), MCFCriteria::GREATER_EQUAL);
}
elseif (
	isset($params['calendar']) 
	&& 
	isset($_SESSION['modules']['{{$module->getModuleName()}}']['calendar']['scope'])
	&&
	(!isset($params['next_events']))
	&&
	(!isset($params['previous_events']))
	)
{
	 $calendar = new MCFCalendar($_SESSION['modules']['{{$module->getModuleName()}}']['calendar']['scope']);
   $c->add('start_date', date('Y/m/d', $calendar->end_date), MCFCriteria::LESS_EQUAL);
   $c->add('end_date', date('Y/m/d', $calendar->start_date), MCFCriteria::GREATER_EQUAL);
}
elseif (isset($params['calendar']))
{
   $calendar_time = isset($params['cal_time'])?$params['cal_time']:time();
   $calendar = new MCFCalendar($calendar_time);
   $c->add('start_date', date('Y/m/d', $calendar->end_date), MCFCriteria::LESS_EQUAL);
   $c->add('end_date', date('Y/m/d', $calendar->start_date), MCFCriteria::GREATER_EQUAL);
}


if (isset($params['next_events']))
{
   $c->add('end_date', date('Y/m/d'), MCFCriteria::GREATER_EQUAL);
}
if (isset($params['previous_events']))
{
   $c->add('end_date', date('Y/m/d'), MCFCriteria::LESS_THAN);
}



$modulextender = cms_utils::get_module('ModuleXtender');

if(is_object($modulextender))  {
  if ($modulextender->isXtendedModule('{{$module->getModuleName()}}')) {
    $mxfilters = array();
    foreach (MX_Relation::getFilters($this->getName()) as $filter) {
      if ($filter->getType() == 'category') {
        if(isset($params['title_filter_category_'.$filter->getId()])) {
          $values = array($params['title_filter_category_'.$filter->getId()] => 0);
        } else {
          $values = array($filter->getTitle(false, true) => 0);
        }
      
        foreach ($filter->getRelatedItems() as $item) {
          $values[$item->title] = $item->id;
        }
      
        $mxfilters[$filter->getId()] = $this->CreateInputDropdown($id, 'mxfilters_options[' . $filter->id . ']', $values, -1, isset($params['mxfilters_options'][$filter->id]) ? $params['mxfilters_options'][$filter->id] : '');
      } elseif ($filter->getType() == 'page') {
        if(isset($params['title_filter_page_'.$filter->getId()])) {
          $values = array($params['title_filter_page_'.$filter->getId()] => 0);
        } else {
          $values = array($filter->getTitle(false, true) => 0);
        }
      
        foreach ($filter->getRelatedItems() as $item) {
          $values[$item->title] = $item->id;
        }
        
        $mxfilters[$filter->getId()] = $this->CreateInputDropdown($id, 'mxfilters_pages[' . $filter->id . ']', $values, -1, isset($params['mxfilters_pages'][$filter->id]) ? $params['mxfilters_pages'][$filter->id] : '');
      }
    }
    $this->smarty->assign('mxfilters', $mxfilters);
  }
}

$this->smarty->assign('titlefilter', $this->CreateInputText($id, 'filter_title', isset($params['filter_title']) ? html_entity_decode($params['filter_title']) : '', 20));
$this->smarty->assign('filter_all', $this->CreateInputText($id, 'filter_all', isset($params['filter_all']) ? html_entity_decode($params['filter_all']) : '', 20));

if(isset($params['order_by'])) $params['orderby'] = $params['order_by'];

if (isset($params['random'])) 
{
	$c->addAscendingOrderByColumn('RAND()');
} 
elseif (isset($params['orderby'])) 
{
	$clauses = explode(',', $params['orderby']);
	foreach ($clauses as $clause) {
		$clause = trim($clause);
		if (preg_match('/(\w+)(?:\s+(asc|desc))?/i', $clause, $matches)) {
			$column = $matches[1];
			$order = isset($matches[2]) ? strtolower($matches[2]) : 'asc';
			if ($order == 'desc') {
				$c->addDescendingOrderByColumn($column);
			} else {
				$c->addAscendingOrderByColumn($column);
			}
		}
	}
} else {
    $c->addAscendingOrderByColumn('order_by');
}

if(isset($params['group_by']))
{
  $groups = explode(',', $params['group_by']);
  foreach($groups as $group)
  {
   $c->addGroupByColumn(trim($group)); 
  }
}

if (isset($params['limit'])) {
	if (isset($params['page'])) {
		$page = $params['page'];
		$c->setOffset(($page - 1) * $params['limit']);
	} else {
		$page = 1;
	}
	if(isset($params['offset']))
	{
		$c->setOffset($params['offset']);
	}
	$c->setLimit($params['limit']);
}

$items = {{$module->getModuleName()}}Object::doSelect($c);

if(isset($params['reverse']))
{
	$items = array_reverse($items, true);
}

if (($this->getPreference('show_parent', '0') == 1) && isset($params['get_tree']))
{
  $tree = {{$module->getModuleName()}}Object::buildTree($items);
  $this->smarty->assign('{{$module->getModuleName()|lower}}_tree', $tree); 
}

if (isset($params['limit'])) {
	$c->setOffset(0);
	$c->setLimit(0);
	$total = {{$module->getModuleName()}}Object::doCount($c);
	$totalpages = ceil($total / $params['limit']);
	$page = $params['page'] ? $params['page'] : 1;
	$pager = array();
	$pager['has_to_paginate'] = $totalpages > 1;
	$pager['current'] = $page;
	$pager['total_pages'] = $totalpages;
	$pager['total_results'] = $total;
	$pager['pages'] = array();
	
	for ($i = 1; $i <= $totalpages; ++$i) {
		$pager['pages'][] = ($i == $page) ? $i : $this->createLink($id, 'default', $returnid, $i, 
		$this->ParamsForLink($params, array('page' => $i))
		, '');
	}
	$pager['previous_page'] = ($page > 1) ? $this->createLink($id, 'default', $returnid, '', 
	$this->ParamsForLink($params, array('page' => $page - 1))
	, '', true, true) : false;
	$pager['next_page'] = ($page < $totalpages) ? $this->createLink($id,'default', $returnid, '', 
	$this->ParamsForLink($params, array('page' => $page + 1))
	, '', true, true) : false;
	$this->smarty->assign('pager', $pager);
}

$detailpage = $returnid;
if (isset($params['detailpage'])) {
    $manager = cmsms()->GetHierarchyManager();
    $node = $manager->sureGetNodeByAlias($params['detailpage']);
    if ($node) {
        $content = $node->GetContent();
        if ($content)
        {
            $detailpage = $content->Id();
        }
    } else {
        $node = $manager->sureGetNodeById($params['detailpage']);
        if ($node) {
            $detailpage = $params['detailpage'];
        }
    }
    $params['origid'] = $returnid;
}

$this->smarty->assign('detailpage',$detailpage);

// MX Preloading
$ids = array();
foreach ($items as $item)
{
	$ids[] = $item->getId();
}
if(class_exists('MX_XtendedModule')) {
  MX_XtendedModule::preloadRelatedItems($this->getName(), $ids);
}


$newparams = $params;
unset($newparams['showtemplate']);
unset($newparams['detailpage']);
unset($newparams['template']);

foreach ($items as &$item) {
	$newparams['item_id'] = $item->getId();
	$newparams['title'] = $item->getCoreSlug();
	$item->detail_link = $this->createLink($id, 'detail', $detailpage, $contents='', $newparams, '', true);
	if(class_exists('MX_XtendedModule')) {
	  $xtended_felist = MX_XtendedModule::getRelatedItems($this->getName(), $item->getId());
	  $item->xtended_felist = $xtended_felist;
	}
}
unset($item);

if (isset($params['calendar']))
{
   $calendar->processEvents($items);
   $calendar->processCalendar();

   $this->smarty->assign('calendar', $calendar->calendar_table);
   $this->smarty->assign('current_month', $calendar_time);
   $this->smarty->assign('next_month', $this->createLink($id,'default', $detailpage, $contents='', array_merge($params, array('cal_time' => strtotime('+ 1 MONTH',$calendar_time))), '', true, true));
   $this->smarty->assign('previous_month', $this->createLink($id, 'default', $detailpage, $contents='', array_merge($params,   array('cal_time' => strtotime('- 1 MONTH', $calendar_time))), '', true, true));
}

// JSON
if(isset($_REQUEST['json']))
{	
	$json = array();
	foreach($items as $item)
	{
		$json[] = $item->getAsArray();
	}
	
	$callback = $_REQUEST['callback'];
	if ($callback) {
		header('Content-type: text/javascript');
	  echo $callback . '(' . utf8_encode(json_encode($json)) . ');';
	} else {		
		header('Content-type: application/x-json');
		echo utf8_encode(json_encode($json));
	}
	exit;
	die();
}


if (isset($params['var'])) {
    $this->smarty->assign($params['var'], $items);
} else {
    $this->smarty->assign('items', $items);
    $this->smarty->assign('{{$module->getModuleName()}}', $items);
    $this->smarty->assign('{{$module->getModuleName()|lower}}', $items);
    $paramsobj = new stdClass();
    $paramsobj->params = $params;
    $this->smarty->assign('mcfactory', $paramsobj);
    $this->smarty->assign('{{$module->getModuleName()|lower}}_params', $paramsobj);
		$this->smarty->assign('form_start', $this->CreateFormStart($id, 'default', $detailpage, 'post'));
	
		$inputs_hidden = '';
		$newparams = $params;
		unset($newparams['module']);
		unset($newparams['action']);
		unset($newparams['page']);
		unset($newparams['returnid']);
		foreach($newparams as $key => $value)
		{
			$inputs_hidden .= $this->CreateInputHidden($id,$key,$value);
		}
		$this->smarty->assign('inputs_hidden', $inputs_hidden);
	
		echo $this->ProcessTemplateFor('default', $params);
	
	return;
{{*
    // if (isset($params['template']) && $this->GetTemplate($params['template'])) {
    // 	echo $this->ProcessTemplateFromDatabase($params['template']);
    // } else {
    // 	echo $this->ProcessTemplateFromDatabase('display_list');
    // }
*}}
}

?>
