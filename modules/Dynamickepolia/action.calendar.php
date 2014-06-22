<?php

if (!cmsms()) exit;

$c = new MCFCriteria();
$c->add('published', '1');

DynamickepoliaObject::buildFrontendFilters($c, $params);
DynamickepoliaObject::globalFrontendFilters($c);

// Define scope

if(isset($params['forget_scope']))
{
  unset($_SESSION['modules']['Dynamickepolia']['calendar']['scope']);
}

if (isset($params['scope']))
{
	$scope = $params['scope'];
}
elseif(isset($_SESSION['modules']['Dynamickepolia']['calendar']['scope']))
{
  $scope = $_SESSION['modules']['Dynamickepolia']['calendar']['scope'];
}
else
{
  $scope = time();
}

if(!isset($params['forget_scope']))
{
  $_SESSION['modules']['Dynamickepolia']['calendar']['scope'] = $scope;
}

// Init calendar

$calendar = new MCFCalendar($scope);

$c->add('start_date', date('Y/m/d', $calendar->end_date), MCFCriteria::LESS_EQUAL);
$c->add('end_date', date('Y/m/d', $calendar->start_date), MCFCriteria::GREATER_EQUAL);

$items = DynamickepoliaObject::doSelect($c);

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

foreach ($items as &$item) {
	$params['item_id'] = $item->getId();
	$params['title'] = $item->getCoreSlug();
	$newparams = $params;
	unset($newparams['showtemplate']);
	unset($newparams['detailpage']);
	unset($newparams['template']);
	$item->detail_link = $this->createLink($id, 'calendar', $detailpage, $contents='', $newparams, '', true, true);
	if(class_exists('MX_XtendedModule')) {
	  $item->xtended_felist = MX_XtendedModule::getRelatedItems($this->getName(), $item->getId());
	}

}
unset($item);

$calendar->processEvents($items);
$calendar->processCalendar();

$this->smarty->assign('calendar', $calendar->calendar_table);
$this->smarty->assign('mcfcalendar', $calendar->calendar_table);
$this->smarty->assign('current_month', $scope);
$this->smarty->assign('first_day',$calendar->first_day);
$this->smarty->assign('last_day',$calendar->last_day);
$this->smarty->assign('next_month', $this->createLink($id,'calendar', $detailpage, $contents='', 
	array_merge(
		$params, 
		array(
			'scope' => strtotime('+ 1 MONTH',$scope)
			)
		)
	, '', true, true));

$this->smarty->assign('previous_month', $this->createLink($id, 'calendar', $detailpage, $contents='', 
	array_merge(
		$params,   
		array(
			'scope' => strtotime('- 1 MONTH', $scope)
			)
		)
	, '', true, true));


if (isset($params['var'])) {
    $this->smarty->assign($params['var'], $items);
} else {
  $this->smarty->assign('items', $items);
  $this->smarty->assign('Dynamickepolia', $items);
  $this->smarty->assign('dynamickepolia', $items);
  $paramsobj = new stdClass();
  $paramsobj->params = $params;
  $this->smarty->assign('mcfactory', $paramsobj);

	echo $this->ProcessTemplateFor('calendar', $params);
}

return;
?>