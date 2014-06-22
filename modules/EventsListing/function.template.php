<?php

$query = 'SELECT * FROM '.cms_db_prefix().'module_eventslisting_templates';

$dbresult =& $db->Execute($query);
$items = Array();
$rowclass = 'row1';

while($dbresult && $row = $dbresult->FetchRow()) {
	$i = count($items);
	$items[$i]['link'] = $this->CreateLink($id, 'admin_edittemplate', $returnid,$row['name'], array('entry_id' => $row['entry_id']));
	$items[$i]['delete'] = $this->CreateLink($id, 'admin_deletetemplate', $returnid,$gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'),array('entry_id' => $row['entry_id']), $this->Lang('areyousure')); 
	$items[$i]['rowclass']	= $rowclass;
	$rowclass = ($rowclass == 'row1' ? 'row2' : 'row1');
}

$smarty->assign('items', $items);
$smarty->assign('header_name', $this->Lang('headername'));
$smarty->assign('addlink', $this->CreateLink($id, 'admin_addtemplate', $returnid,$gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('addtemplate'),'','','systemicon') . ' ' . $this->Lang('addtemplate')));

echo $this->ProcessTemplate('listtemplates.tpl');

// EOF