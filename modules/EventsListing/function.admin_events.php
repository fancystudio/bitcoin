<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify events') ) exit;
$contentops =& $gCms->GetContentOperations();

$eventinfo = array();

// Set Tab name
$tabto = 'events';

// Check if event is given and get event ID
$event = isset($params['event']) ? (int)$params['event'] : 0;

// Display form for editing a event
if (isset($params['event'])) {

	// Get event info
	$eventinfo = $db->GetRow('SELECT short_desc,long_desc,start_date,end_date,detail_link,image_url,sort_order,active FROM '.cms_db_prefix().'module_eventslisting_events WHERE entry_id = ?', array($event));

	// Get categories
	$categorylist = $db->getAssoc('SELECT short_desc,entry_id FROM '.cms_db_prefix().'module_eventslisting_category ORDER BY short_desc');
	// Get selected categories
	if ($event>0) { $cats = $db->getCol('SELECT cat_id FROM '.cms_db_prefix().'module_eventslisting_category_events WHERE event_id=?',array($event)); }
	else { $cats = array(); }

	// Assign Smarty vars
	$smarty->assign('formid',$id);
	$smarty->assign('startform',$this->CreateFormStart($id,'admin_editevent',$returnid,'post','multipart/form-data',true,array()));
    $smarty->assign('formend', $this->CreateFormEnd());
    $smarty->assign('submit', $this->CreateInputSubmit($id,$event ? 'submit': 'add',$this->Lang('submit')));
    $smarty->assign('cache', $this->CreateInputSubmit($id,$event ? 'cache' : 'cacheadd',$this->Lang('cache')));
    $smarty->assign('reset', $this->CreateInputReset($id,'reset',$this->Lang('reset')));
    $smarty->assign('cancel', $this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
	$smarty->assign('tabto', $this->CreateInputHidden($id,'tabto',$tabto));
    $smarty->assign('event', $this->CreateInputHidden($id,'event',$event));
	$smarty->assign('prompt_short', $this->Lang('prompt_short'));
	$smarty->assign('input_short', $this->CreateInputText($id,'short_desc',$eventinfo['short_desc'],50,100));
	$smarty->assign('prompt_long', $this->Lang('prompt_long'));
	$smarty->assign('input_long', $this->CreateTextArea(true, $id, $eventinfo['long_desc'], 'long_desc'));

	$smarty->assign('prompt_category', $this->Lang('prompt_category'));
	$smarty->assign('cats', $categorylist);
	$smarty->assign('cats_selected', $cats);

	$smarty->assign('prompt_start_date', $this->Lang('prompt_start_date'));
	$smarty->assign('prefix_startdate', $id . 'start_date_');
	$smarty->assign('start_date', $eventinfo['start_date']);
	$smarty->assign('prompt_end_date', $this->Lang('prompt_end_date'));
	$smarty->assign('prefix_enddate', $id . 'end_date_');
	$smarty->assign('end_date', $eventinfo['end_date']);

	$smarty->assign('prompt_link', $this->Lang('prompt_link'));
	$smarty->assign('input_link',$contentops->CreateHierarchyDropdown('',$eventinfo['detail_link'],$id.'detail_link',0,1,0,1)); // current, parent, parent_id, allowcurrent, use_perms, ignore_current, allow_all

	$smarty->assign('prompt_image', $this->Lang('prompt_image'));
	$smarty->assign('input_image', $eventinfo['image_url'] ? '' : $this->CreateFileUploadInput($id, 'image','',50));
	$smarty->assign('input_image_ov', $eventinfo['image_url'] ? '<img src="'.$config['image_uploads_url'].'/Events/events/'.$event.'/'.$eventinfo['image_url'].'" />' : '');
	$smarty->assign('input_image_del', $eventinfo['image_url'] ? $this->Lang('delete_image').': '.$this->CreateInputCheckbox($id, 'image_del',1,0) : '');

	$smarty->assign('prompt_active', $this->Lang('active'));
	$smarty->assign('input_active', $this->CreateInputCheckbox($id, 'active', 'true', $eventinfo['active'] ? 'true' : 'false'));
	$smarty->assign('prompt_order', $this->Lang('sort_order'));
	$smarty->assign('sort_order', $eventinfo['sort_order']);

    // Display Template
    echo $this->ProcessTemplate('editevent.tpl');

}

// Display a list with available events
else {

	// Set vars and images
	$imageview = $gCms->variables['admintheme']->DisplayImage('icons/system/view.gif',$this->Lang('view'),'','','systemicon');
	$imagenostandard = $gCms->variables['admintheme']->DisplayImage('icons/system/false.gif',$this->Lang('makestandard'),'','','systemicon');
	$imageinactive = $gCms->variables['admintheme']->DisplayImage('icons/system/false.gif',$this->Lang('makeactive'),'','','systemicon');
	$imagestandard = $gCms->variables['admintheme']->DisplayImage('icons/system/true.gif',$this->Lang('standard'),'','','systemicon');
	$imageactive = $gCms->variables['admintheme']->DisplayImage('icons/system/true.gif',$this->Lang('makeinactive'),'','','systemicon');
	$imageedit = $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif',$this->Lang('edit'),'','','systemicon');
	$imagedelete = $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif',$this->Lang('delete'),'','','systemicon');
	$imagenew = $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif',$this->Lang('newtemplate'),'','','systemicon');

	// Get events
	$allevents = $db->GetAll('SELECT entry_id,short_desc,start_date,end_date,detail_link,sort_order,active FROM '.cms_db_prefix().'module_eventslisting_events');
	if (!is_array($allevents)) $allevents = array();

	// Show events
	$rowarray = array();
	$rowclass = 'row1';
	foreach ($allevents as $ev) {
		// Build a new row
		$row = new StdClass();
		$row->rowclass = $rowclass;
		// ID
		$row->id = $ev['entry_id'];
		// Title
		$row->title = $this->CreateLink( $id, 'admin_editevent', $returnid, $ev['short_desc'], array ( 'tabto'=>$tabto, 'event'=>$ev['entry_id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		// Start date
		$row->start_date = $ev['start_date'];
		// End date
		$row->end_date = $ev['end_date'];
		// Detail link
		$row->detail_link = $ev['detail_link'];
		// Sort order
		$row->sort_order = $ev['sort_order'];
		// Build link for de-/activate the event
		$active = $ev['active'] ? 1 : 0;
		if ( $active ) { $row->active = $this->CreateLink( $id, 'admin_eventactive', $returnid, $imageactive, array ( 'tabto'=>$tabto, 'event'=>$ev['entry_id'], 'active'=>0 ), $this->Lang('reallymakeinactive'), false, false, ' title="'.$this->Lang('makeinactive').'"'); }
		else { $row->active = $this->CreateLink( $id, 'admin_eventactive', $returnid, $imageinactive, array ( 'tabto'=>$tabto, 'event'=>$ev['entry_id'], 'active'=>1 ), $this->Lang('reallymakeactive'), false, false, ' title="'.$this->Lang('makeactive').'"'); }
		// Build edit icon
		$row->editlink = $this->CreateLink( $id, 'admin_editevent', $returnid, $imageedit, array ( 'tabto'=>$tabto, 'event'=>$ev['entry_id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		// Build delete icon
		$row->deletelink = $this->CreateLink( $id, 'admin_deleteevent', $returnid, $imagedelete, array ( 'tabto'=>$tabto, 'event'=>$ev['entry_id'] ), $this->Lang('reallydelete'), false, false, ' title="'.$this->Lang('delete').'"');
		// Merge new domain to array
		array_push ($rowarray, $row);
		// Alternate row color
		($rowclass == 'row1' ? $rowclass = 'row2' : $rowclass = 'row1');
	}


	// Assign smarty vars
	$smarty->assign('items', $rowarray );
	$smarty->assign('id', $this->Lang('id'));
	$smarty->assign('active', $this->Lang('active'));
	$smarty->assign('header_name', $this->Lang('headername'));
	$smarty->assign('addlink', $this->CreateLink( $id, 'admin_editevent', '', $imagenew.' '.$this->Lang('addevent'), array ( 'tabto'=>$tabto, 'event'=>'' ), '', false, false, ' title="'.$this->Lang('addevent').'"'));
	echo $this->ProcessTemplate('listevents.tpl');

}

// EOF