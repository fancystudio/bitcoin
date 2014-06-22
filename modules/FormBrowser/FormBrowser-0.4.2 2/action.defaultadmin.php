<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

$this->buildBrowseNav($id,$params,$returnid,false);
$this->smarty->assign('tab_headers',$this->StartTabHeaders().$this->SetTabHeader('administerformdata',$this->Lang('title_browsers')). $this->SetTabHeader('configuration',$this->Lang('title_configuration')).
				$this->EndTabHeaders().$this->StartTabContent());
$this->smarty->assign('end_tab',$this->EndTab());
$this->smarty->assign('tab_footers',$this->EndTabContent());
$this->smarty->assign('start_administerformdata_tab',$this->StartTab('administerformdata'));
$this->smarty->assign('start_configuration_tab',$this->StartTab('configuration'));
$this->smarty->assign('title_browser_name',$this->Lang('title_browser_name'));
$this->smarty->assign('title_browser_alias',$this->Lang('title_browser_alias'));
$this->smarty->assign('title_related_form',$this->Lang('title_related_form'));
$this->smarty->assign('title_browser_administer',$this->Lang('title_browser_administer'));
$this->smarty->assign('title_date_format',$this->Lang('title_date_format'));
$this->smarty->assign('title_strip_on_export',$this->Lang('title_strip_on_export'));
$this->smarty->assign('title_date_format_help',$this->Lang('title_date_format_help'));
$this->smarty->assign('title_browser_export',$this->Lang('title_browser_export'));
$this->smarty->assign('title_export_file',$this->Lang('title_export_file'));
$this->smarty->assign('title_section',$this->Lang('friendlyname'));
$this->smarty->assign('fbrp_message',isset($params['fbrp_message'])?$params['fbrp_message']:'');
$this->smarty->assign('title_export_file_encoding',$this->Lang('title_export_file_encoding'));
$this->smarty->assign('title_suppress_email_on_edit',$this->Lang('title_suppress_email_on_edit'));

$browsers = $this->GetBrowsers();
//$num_browsers = count($browsers);
$browserArray = array();
//$currow = "row1";
foreach ($browsers as $thisBrowser) {

	$oneset = new stdClass();
	//$oneset->rowclass = $currow;
	if ($this->CheckPermission('Modify Browsers')) {
	
		$oneset->name = $this->CreateLink($id, 'admin_add_edit_browser', '', $thisBrowser['name'], array('browser_id'=>$thisBrowser['browser_id']));
		$oneset->editlink = $this->CreateLink($id, 'admin_add_edit_browser', '', $gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif',$this->Lang('edit'),'','','systemicon'), 
				array('browser_id'=>$thisBrowser['browser_id']));
		$oneset->adminlink = $this->CreateLink($id, 'admin_browse', '', $gCms->variables['admintheme']->DisplayImage('icons/system/permissions.gif',$this->Lang('administrite'),'','','systemicon'),
				array('browser_id'=>$thisBrowser['browser_id']));
		$oneset->deletelink = $this->CreateLink($id, 'admin_delete_browser', '', $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif',$this->Lang('delete'),'','','systemicon'),
				array('browser_id'=>$thisBrowser['browser_id']), $this->Lang('are_you_sure_delete_browser',$thisBrowser['name']));

	} else {
	
		$oneset->name=$thisBrowser['name'];
		$oneset->editlink = '';
		$oneset->deletelink = '';
	}

	$oneset->form_name=$thisBrowser['form_name'];	
	$oneset->exportlink = $this->CreateLink($id, 'admin_export_xls', '', '<img src="'.$this->config['root_url'].'/modules/FormBrowser/images/xls.gif" alt="'.$this->Lang('exporttoexcel').'"  title="'.$this->Lang('exporttoexcel').'" border="0" />',
				array('browser_id'=>$thisBrowser['browser_id']));		

	$oneset->usage = $thisBrowser['alias'];
	array_push($browserArray, $oneset);
	//($currow == "row1"?$currow="row2":$currow="row1");
	
}

#########################################################################
# Assign to Smarty
#########################################################################
		
if ($this->CheckPermission('Modify Browsers')) {

	$this->smarty->assign('addlink',$this->CreateLink($id, 'admin_add_edit_browser', '', $gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', 
				$this->Lang('title_add_new_browser'),'','','systemicon'), array()));
	$this->smarty->assign('addbrowser',$this->CreateLink($id, 'admin_add_edit_browser', '', $this->Lang('title_add_new_browser'), array()));
	$this->smarty->assign('may_config',1);
} else {

	$this->smarty->assign('no_permission', $this->Lang('lackpermission'));
}

$this->smarty->assign('browser_count',count($browsers));
$this->smarty->assign_by_ref('browsers', $browserArray);	

$this->smarty->assign('start_configform',$this->CreateFormStart($id, 'admin_store_config', $returnid));
$this->smarty->assign('end_configform',$this->CreateFormEnd());
$this->smarty->assign('input_date_format',$this->CreateInputText($id, 'fbrp_date_format', $this->GetPreference('date_format','d F y'), 20, 255));

$this->smarty->assign('input_suppress_email_on_edit', $this->CreateInputHidden($id,'fbrp_suppress_email_on_edit','0'). $this->CreateInputCheckbox($id, 'fbrp_suppress_email_on_edit', '1',
				$this->GetPreference('suppress_email_on_edit','1')).$this->Lang('help_suppress_email_on_edit'));

$this->smarty->assign('input_strip_on_export', $this->CreateInputHidden($id,'fbrp_strip_on_export','0'). $this->CreateInputCheckbox($id, 'fbrp_strip_on_export', '1',
				$this->GetPreference('strip_on_export','0')). $this->Lang('title_strip_on_export_long'));
$this->smarty->assign('input_export_file', $this->CreateInputHidden($id,'fbrp_export_file','0'). $this->CreateInputCheckbox($id, 'fbrp_export_file', '1',
				$this->GetPreference('export_file','0')). $this->Lang('title_export_file_long'));

$encodings = array('utf-8'=>'utf-8','windows-1252'=>'windows-1252', 'iso-8859-1'=>'iso-8859-1');
$this->smarty->assign('input_export_file_encoding', $this->CreateInputRadioGroup($id, 'fbrp_export_file_encoding', $encodings, $this->GetPreference('export_file_encoding','iso-8859-1')));
$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'fbrp_submit', $this->Lang('save')));

echo $this->ProcessTemplate('adminpanel.tpl');
?>