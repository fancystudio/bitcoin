<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('Modify Templates') ) exit;

// Set Tab name
$tabto = 'templates';

// Check if template is given and get template ID
$template = isset($params['template']) ? (int)$params['template'] : 0;

// Display form for editing a template
if (isset($params['template'])) {

	// Get template info
	$templateinfo = $db->GetRow('SELECT name as template_title, content FROM '.cms_db_prefix().'module_eventslisting_templates WHERE entry_id = ?', array($template));

	// Assign Smarty vars
	$smarty->assign('startform',$this->CreateFormStart($id,'admin_edittemplate',$returnid,'post','multipart/form-data',true,array()));
    $smarty->assign('formend', $this->CreateFormEnd());
    $smarty->assign('submit', $this->CreateInputSubmit($id,$template ? 'submit': 'add',$this->Lang('submit')));
    $smarty->assign('cache', $this->CreateInputSubmit($id,$template ? 'cache' : 'cacheadd',$this->Lang('cache')));
    $smarty->assign('reset', $this->CreateInputReset($id,'reset',$this->Lang('reset')));
    $smarty->assign('cancel', $this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
	$smarty->assign('tabto', $this->CreateInputHidden($id,'tabto',$tabto));
    $smarty->assign('template', $this->CreateInputHidden($id,'template',$template));
	$smarty->assign('prompt_title', $this->Lang('prompt_template_name'));
	$smarty->assign('input_title', $this->CreateInputText($id,'title',$templateinfo['template_title'],50,100));
	$smarty->assign('prompt_content', $this->Lang('prompt_template_code'));
	$smarty->assign('input_content', $this->CreateTextArea(false, $id, $templateinfo['content'], 'content'));

    // Display Template
    echo $this->ProcessTemplate('edittemplate.tpl');

}

// Display a list with available templates
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

	// Get templates
	$alltemplates = $db->GetAll('SELECT entry_id,name as template_title FROM '.cms_db_prefix().'module_eventslisting_templates');
	if (!is_array($alltemplates)) $alltemplates = array();

	// Show templates
	$rowarray = array();
	$rowclass = 'row1';
	foreach ($alltemplates as $tpl) {
		// Build a new row
		$row = new StdClass();
		$row->rowclass = $rowclass;
		// ID
		$row->id = $tpl['entry_id'];
		// Title
		$row->title = $this->CreateLink( $id, 'admin_edittemplate', $returnid, $tpl['template_title'], array ( 'tabto'=>$tabto, 'template'=>$tpl['entry_id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		// Build edit icon
		$row->editlink = $this->CreateLink( $id, 'admin_edittemplate', $returnid, $imageedit, array ( 'tabto'=>$tabto, 'template'=>$tpl['entry_id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		// Build delete icon
		$row->deletelink = $this->CreateLink( $id, 'admin_deletetemplate', $returnid, $imagedelete, array ( 'tabto'=>$tabto, 'template'=>$tpl['entry_id'] ), $this->Lang('reallydelete'), false, false, ' title="'.$this->Lang('delete').'"');
		// Merge new domain to array
		array_push ($rowarray, $row);
		// Alternate row color
		($rowclass == 'row1' ? $rowclass = 'row2' : $rowclass = 'row1');
	}


	// Assign smarty vars
	$smarty->assign('items', $rowarray );
	$smarty->assign('id', $this->Lang('id'));
	$smarty->assign('header_name', $this->Lang('headername'));
	$smarty->assign('addlink', $this->CreateLink( $id, 'admin_edittemplate', '', $imagenew.' '.$this->Lang('addtemplate'), array ( 'tabto'=>$tabto, 'template'=>'' ), '', false, false, ' title="'.$this->Lang('addtemplate').'"'));
	echo $this->ProcessTemplate('listtemplates.tpl');

}

// EOF