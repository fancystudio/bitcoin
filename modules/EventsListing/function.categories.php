<?php

$query = 'SELECT * FROM	' . cms_db_prefix() . 'module_eventslisting_category ORDER BY short_desc';

$dbresult =& $db->Execute($query);
$items = Array();
$rowclass = 'row1';

while($dbresult && $row = $dbresult->FetchRow()) {
	$i = count($items);
	$items[$i]['link'] = $this->CreateLink($id, 'admin_editcategory', $returnid, $row['short_desc'], array('entry_id' => $row['entry_id']));
	$items[$i]['delete'] = $this->CreateLink($id, 'admin_deletecategory', $returnid, $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('entry_id' => $row['entry_id']), $this->Lang('areyousure'));
	$items[$i]['rowclass']	= $rowclass;
	$rowclass = ($rowclass == 'row1' ? 'row2' : 'row1');
}

$smarty->assign('items', $items);
$smarty->assign('header_name', $this->Lang('headername'));
$smarty->assign('addlink', $this->CreateLink($id, 'admin_addcategory', $returnid,	$gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addevent'),'','','systemicon') . ' ' . $this->Lang('addcategory')));

echo $this->ProcessTemplate('listcategories.tpl');

// EOF