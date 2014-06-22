<?php

$query = 'SELECT * FROM	' . cms_db_prefix() . 'module_eventslisting_events ORDER BY start_date,end_date';

$dbresult =& $db->Execute($query);
$items = Array();
$rowclass = 'row1';

while($dbresult && $row = $dbresult->FetchRow()) {
	$i = count($items);
	$items[$i]['link'] = $this->CreateLink($id, 'admin_editevent', $returnid, $row['short_desc'], array('entry_id' => $row['entry_id']));
	$items[$i]['delete'] = $this->CreateLink($id, 'admin_deleteevent', $returnid,		$gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'),		array('entry_id' => $row['entry_id']), $this->Lang('areyousure'));
 	$items[$i]['start'] = strftime($this->Lang('timestamp'), $db->UnixTimeStamp($row['start_date']));
	$items[$i]['end'] = strftime($this->Lang('timestamp'), $db->UnixTimeStamp($row['end_date']));
	$items[$i]['rowclass']	= $rowclass;
	$rowclass = ($rowclass == 'row1' ? 'row2' : 'row1');
}

$smarty->assign('items', $items);
$smarty->assign('header_name', $this->Lang('headername'));
$smarty->assign('header_start', $this->Lang('startdate'));
$smarty->assign('header_end', $this->Lang('enddate'));
$smarty->assign('addlink', $this->CreateLink($id, 'admin_addevent', $returnid,	$gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addevent'),'','','systemicon') . ' ' . $this->Lang('addevent')));

echo $this->ProcessTemplate('listevents.tpl');

// EOF