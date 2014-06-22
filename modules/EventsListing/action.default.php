<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;

// Set needed objects
$db = cmsms()->GetDb();

// get common parameters and build vars
$template = isset($params['template']) ? $params['template'] : 'default';
$sortorder = 'ASC';
if(isset($params['sortdesc']) && $params['sortdesc'] && $params['sortdesc']!='false') $sortorder = 'DESC';
$eventslimit = '987654321';
if(isset($params['eventslimit']) && $params['eventslimit'] > 0) $eventslimit = (int)$params['eventslimit'];
$cutoff = isset($params['cutoff']) ? (int)$params['cutoff'] : 0;
$cutoff = isset($params['cutoff']) ? ' AND end_date >= DATE_SUB(CURDATE(),INTERVAL '.$cutoff.' DAY'. ')' : '';
$pastonly = '';
if(isset($params['pastonly'])) $pastonly = ' AND end_date <= CURDATE()';
$showcats = isset($params['showcategories']) ? $params['showcategories'] : false;
$showcat = isset($params['showcategory']) ? $params['showcategory'] : '';

// category listing
if ($showcats) {

	$rowarray = array();
	$rowclass = 'row1';
	// Get categories
	$categories = $db->GetAll('SELECT entry_id,short_desc,long_desc,image_url,sort_order FROM '.cms_db_prefix().'module_eventslisting_category WHERE active=1', array());
	if (!is_array($categories)) $categories = array();
	foreach ($categories as $cat) {
		// Build a new row
		$row = new StdClass();
		$row->rowclass = $rowclass;
		// Get data in array
		$row->category = (int)$cat['entry_id'];
		$row->title = $this->ProcessTemplateFromData($cat['short_desc']);
		$row->content = $this->ProcessTemplateFromData($cat['long_desc']);
		$row->linkid = (int)$cat['detail_link'];
		$row->linkalias = $this->GetLinkAlias($row->linkid);
		$row->image = $cat['image_url'] ? $config['image_uploads_url'].'/Events/categories/'.$cat['entry_id'].'/'.$cat['image_url'] : '';
		$row->order = $cat['sort_order'];
		// Merge new domain to array
		array_push ($rowarray, $row);
		// Alternate row color
		($rowclass == 'row1' ? $rowclass = 'row2' : $rowclass = 'row1');
	}
	// Assign smarty vars
	$smarty->assign('categories',$rowarray);
}

// category details
else if ($showcat) {

	// Get category ID
	$scat = $db->GetOne('SELECT entry_id FROM '.cms_db_prefix().'module_eventslisting_category WHERE short_desc = ? AND active = 1', array($showcat));
	// build and execute query
	if (!$scat) {
		echo 'ERROR: No such category: '.$showcat;
	} else {
		// build and execute query
		$categoryinfo = $db->GetRow('SELECT short_desc,long_desc,image_url,sort_order FROM '.cms_db_prefix().'module_eventslisting_category WHERE entry_id = ? AND active = 1', array($scat));
		// assign smarty vars
		$smarty->assign('category', $showcat);
		$smarty->assign('category_id', $scat);
		$smarty->assign('short_desc', $categoryinfo['short_desc']);
		$smarty->assign('long_desc', $categoryinfo['long_desc']);
		$smarty->assign('image_url', $categoryinfo['image_url'] ? $config['image_uploads_url'].'/Events/categories/'.$scat.'/'.$categoryinfo['image_url'] : '');
		$smarty->assign('sort_order', $categoryinfo['sort_order']);
	}

}

// Show Events
else {

	$category = '';
	$categories = array();
	if(isset($params['categories']) && $params['categories']) {
		$categories = explode(',',$params['categories']);
		$cats = array();
		foreach ($categories as $c) {
			$cat = $db->GetOne('SELECT entry_id FROM '.cms_db_prefix().'module_eventslisting_category WHERE active = 1 AND short_desc = ?', array($c));
			if ($cat) $cats[] = $cat;
		}
		$category = $cats ? ' AND C.cat_id IN ('.implode(',',$cats).')' : ' AND E.entry_id<1';
	}

	$rowarray = array();
	$rowclass = 'row1';
	// Get events
	if ($category) { $query = 'SELECT E.entry_id entry_id,E.short_desc short_desc,E.long_desc long_desc,E.start_date start_date,E.end_date end_date,E.detail_link detail_link,E.image_url image_url,E.sort_order sort_order FROM '.cms_db_prefix().'module_eventslisting_events E,'.cms_db_prefix().'module_eventslisting_category_events C WHERE E.entry_id=C.event_id'.$category.$pastonly.$cutoff.' AND E.active = 1 ORDER BY start_date ' . $sortorder . ' LIMIT ' . $eventslimit; }
	else { $query = 'SELECT * FROM '.cms_db_prefix().'module_eventslisting_events WHERE entry_id>0'.$pastonly.$cutoff.' AND active = 1 ORDER BY start_date ' . $sortorder . ' LIMIT ' . $eventslimit; }
	$events = $db->GetAll($query, array());
	if (!is_array($events)) $events = array();
	foreach ($events as $ev) {
		// Build a new row
		$row = new StdClass();
		$row->rowclass = $rowclass;
		// Get data in array
		$row->event = (int)$ev['entry_id'];
		$row->title = $this->ProcessTemplateFromData($ev['short_desc']);
		$row->content = $this->ProcessTemplateFromData($ev['long_desc']);
		$row->linkid = (int)$ev['detail_link'];
		$row->linkalias = $this->GetLinkAlias($row->linkid);
		$row->start = $ev['start_date'];
		$row->hcstart = strftime("%Y-%m-%dT%H:%M:%S", strtotime($ev['start_date']));
		$row->end = $ev['end_date'];
		$row->hcend = strftime("%Y-%m-%dT%H:%M:%S", strtotime($ev['end_date']));
		if(strtotime($ev['end_date']) < time()) {
			$row->past = 'true';
		} else {
			$row->past = 'false';
		}
		$row->image = $ev['image_url'] ? $config['image_uploads_url'].'/Events/events/'.$ev['entry_id'].'/'.$ev['image_url'] : '';
		$row->order = $ev['sort_order'];
		// Merge new domain to array
		array_push ($rowarray, $row);
		// Alternate row color
		($rowclass == 'row1' ? $rowclass = 'row2' : $rowclass = 'row1');
	}
	// Assign smarty vars
	$smarty->assign('events',$rowarray);

}

// Get template and process it
$template_content = $db->GetOne('SELECT content FROM '.cms_db_prefix().'module_eventslisting_templates WHERE name=?', array($template));
#$items = Array();
if($template_content) {
	echo $this->ProcessTemplateFromData($template_content);
} else {
	echo 'ERROR: No such template: '.$params['template'];
}

// EOF