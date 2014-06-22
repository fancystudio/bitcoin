<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if (!$this->CheckPermission('EventsListing: modify events')) exit;

// prepare other things
if (isset($params['cancel'])) $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'events'));
$db = cmsms()->GetDb();
$contentops =& cmsms()->GetContentOperations();
$errors = array();

// get parameters
$short_desc	= (isset($params['short_desc']) ? $params['short_desc'] : '');
$long_desc	= (isset($params['long_desc']) ? $params['long_desc'] : '');
$detail_link = preg_replace('/[^0-9]/','',$params['detail_link']);
$start_date	= (isset($params['start_date_Month']) ? mktime($params['start_date_Hour'], $params['start_date_Minute'], $params['start_date_Second'], $params['start_date_Month'], $params['start_date_Day'], $params['start_date_Year']) : 'time()');
$end_date	= (isset($params['end_date_Month']) ? mktime($params['end_date_Hour'], $params['end_date_Minute'], $params['end_date_Second'], $params['end_date_Month'], $params['end_date_Day'], $params['end_date_Year']) : 'time()');

// Edit event
if (isset($params['submit'])) { 
	if($short_desc != '' && $long_desc != '' && $start_date <= $end_date) {
		$entry_id = $db->GenID(cms_db_prefix().'module_eventslisting_events_seq');
		$query = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_events (entry_id, short_desc, long_desc, start_date, end_date, detail_link) VALUES (?, ?, ?, ?, ?, ?)';
		$result = $db->Execute($query, array($entry_id, $short_desc, $long_desc, trim($db->DBTimeStamp($start_date), "'"), trim($db->DBTimeStamp($end_date), "'"), $detail_link));
		if(!$result) $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
		// Update categories
		if (is_array($params['cats'])) {
			foreach ($params['cats'] as $catid) {
				$catid=(int)$catid;
				if ($catid>0) {
					$query = 'INSERT '.cms_db_prefix().'module_eventslisting_category_events (cat_id,event_id,modified_date) VALUES (?,?,?)';
					$db->Execute($query, array($catid,$entry_id,trim($db->DBTimeStamp(time()), "'")));
				}
			}
		}
		if (!$errors) $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'events', 'message' => 'changessaved'));
	} else {
		if($params['short_desc'] == '') $errors[] = $this->Lang('no_short_desc');
		if($params['long_desc'] == '') $errors[] = $this->Lang('no_long_desc');
		if($start_date > $end_date) $errors[] = $this->Lang('bad_end_date');
	}
}

// Get categories
$query = 'SELECT short_desc,entry_id FROM '.cms_db_prefix().'module_eventslisting_category '.$filter.' ORDER BY short_desc';
$categorylist = $db->getAssoc($query);
// Get selected categories
if ($entry_id>0) {
	$query = 'SELECT cat_id FROM '.cms_db_prefix().'module_eventslisting_category_events WHERE event_id=?';
	$cats = $db->getCol($query,array($entry_id));
} else {
	$cats = array();
}

// Assign to smarty parameters
if(count($errors)) echo $this->ShowErrors($errors);
if(isset($entry_id)) $smarty->assign('idfield', $this->CreateInputHidden($id, 'entry_id', $entry_id));
$smarty->assign('formid',$id);
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_addevent', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('prompt_short', $this->Lang('prompt_short'));
$smarty->assign('prompt_long', $this->Lang('prompt_long'));
$smarty->assign('prompt_category', $this->Lang('prompt_category'));
$smarty->assign('prompt_start_date', $this->Lang('prompt_start_date'));
$smarty->assign('prompt_end_date', $this->Lang('prompt_end_date'));
$smarty->assign('prompt_link', $this->Lang('prompt_link'));
$smarty->assign('input_short', $this->CreateInputText($id, 'short_desc', $short_desc));
$smarty->assign('input_long', $this->CreateTextArea(true, $id, $long_desc, 'long_desc'));
$smarty->assign('input_link',$contentops->CreateHierarchyDropdown('',$detail_link,$id.'detail_link',0,1,0,1)); // current, parent, parent_id, allowcurrent, use_perms, ignore_current, allow_all
$smarty->assign('prefix_startdate', $id . 'start_date_');
$smarty->assign('prefix_enddate', $id . 'end_date_');
$smarty->assign('cats', $categorylist);
$smarty->assign('cats_selected', $cats);
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

echo $this->ProcessTemplate('editevent.tpl');

// EOF