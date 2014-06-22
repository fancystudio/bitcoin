<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify categories') ) exit;

// Set Tab name
$tabto = 'categories';

// Check if Category is given and get Category ID
$category = isset($params['category']) ? (int)$params['category'] : 0;

// Display form for editing a category
if (isset($params['category'])) {

	// Get category info
	$categoryinfo = $db->GetRow('SELECT short_desc,long_desc,image_url,sort_order,active FROM '.cms_db_prefix().'module_eventslisting_category WHERE entry_id = ?', array($category));

	// Assign Smarty vars
	$smarty->assign('startform',$this->CreateFormStart($id,'admin_editcategory',$returnid,'post','multipart/form-data',true,array()));
    $smarty->assign('formend', $this->CreateFormEnd());
    $smarty->assign('submit', $this->CreateInputSubmit($id,$category ? 'submit': 'add',$this->Lang('submit')));
    $smarty->assign('cache', $this->CreateInputSubmit($id,$category ? 'cache' : 'cacheadd',$this->Lang('cache')));
    $smarty->assign('reset', $this->CreateInputReset($id,'reset',$this->Lang('reset')));
    $smarty->assign('cancel', $this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
	$smarty->assign('tabto', $this->CreateInputHidden($id,'tabto',$tabto));
    $smarty->assign('category', $this->CreateInputHidden($id,'category',$category));
	$smarty->assign('prompt_short', $this->Lang('prompt_short'));
	$smarty->assign('input_short', $this->CreateInputText($id,'short_desc',$categoryinfo['short_desc'],50,100));
	$smarty->assign('prompt_long', $this->Lang('prompt_long'));
	$smarty->assign('input_long', $this->CreateTextArea(true, $id, $categoryinfo['long_desc'], 'long_desc'));
	$smarty->assign('prompt_image', $this->Lang('prompt_image'));
	$smarty->assign('input_image', $categoryinfo['image_url'] ? '' : $this->CreateFileUploadInput($id, 'image','',50));
	$smarty->assign('input_image_ov', $categoryinfo['image_url'] ? '<img src="'.$config['image_uploads_url'].'/Events/categories/'.$category.'/'.$categoryinfo['image_url'].'" />' : '');
	$smarty->assign('input_image_del', $categoryinfo['image_url'] ? $this->Lang('delete_image').': '.$this->CreateInputCheckbox($id, 'image_del',1,0) : '');
	$smarty->assign('prompt_active', $this->Lang('active'));
	$smarty->assign('input_active', $this->CreateInputCheckbox($id, 'active', 'true', $categoryinfo['active'] ? 'true' : 'false'));
	$smarty->assign('prompt_order', $this->Lang('sort_order'));
	$smarty->assign('sort_order', $categoryinfo['sort_order']);

    // Display Template
    echo $this->ProcessTemplate('editcategory.tpl');

}

// Display a list with available categories
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

	// Get categories
	$allcategories = $db->GetAll('SELECT entry_id,short_desc,sort_order,active FROM '.cms_db_prefix().'module_eventslisting_category');
	if (!is_array($allcategories)) $allcategories = array();

	// Show categories
	$rowarray = array();
	$rowclass = 'row1';
	foreach ($allcategories as $cat) {
		// Build a new row
		$row = new StdClass();
		$row->rowclass = $rowclass;
		// ID
		$row->id = $cat['entry_id'];
		// Title
		$row->title = $this->CreateLink( $id, 'admin_editcategory', $returnid, $cat['short_desc'], array ( 'tabto'=>$tabto, 'category'=>$cat['entry_id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		// Build link for de-/activate the category
		$active = $cat['active'] ? 1 : 0;
		if ( $active ) { $row->active = $this->CreateLink( $id, 'admin_categoryactive', $returnid, $imageactive, array ( 'tabto'=>$tabto, 'category'=>$cat['entry_id'], 'active'=>0 ), $this->Lang('reallymakeinactive'), false, false, ' title="'.$this->Lang('makeinactive').'"'); }
		else { $row->active = $this->CreateLink( $id, 'admin_categoryactive', $returnid, $imageinactive, array ( 'tabto'=>$tabto, 'category'=>$cat['entry_id'], 'active'=>1 ), $this->Lang('reallymakeactive'), false, false, ' title="'.$this->Lang('makeactive').'"'); }
		// Build edit icon
		$row->editlink = $this->CreateLink( $id, 'admin_editcategory', $returnid, $imageedit, array ( 'tabto'=>$tabto, 'category'=>$cat['entry_id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		// Build delete icon
		$row->deletelink = $this->CreateLink( $id, 'admin_deletecategory', $returnid, $imagedelete, array ( 'tabto'=>$tabto, 'category'=>$cat['entry_id'] ), $this->Lang('reallydelete'), false, false, ' title="'.$this->Lang('delete').'"');
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
	$smarty->assign('addlink', $this->CreateLink( $id, 'admin_editcategory', '', $imagenew.' '.$this->Lang('addcategory'), array ( 'tabto'=>$tabto, 'category'=>'' ), '', false, false, ' title="'.$this->Lang('addcategory').'"'));
	echo $this->ProcessTemplate('listcategories.tpl');

}

// EOF