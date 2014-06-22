<?php
/* 
   FormBuilder. Copyright (c) 2005-2007 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
   This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

	// and a list of all the extant forms.
	$forms = $this->GetForms();
	$num_forms = count($forms);
	
	$this->smarty->assign('tabheaders', $this->StartTabHeaders() .
		$this->SetTabHeader('forms',$this->Lang('forms')) .
		$this->SetTabHeader('config',$this->Lang('configuration')) .
		$this->EndTabHeaders().
		$this->StartTabContent());
	$this->smarty->assign('start_formtab',$this->StartTab("forms"));
	$this->smarty->assign('start_configtab',$this->StartTab("config"));
	$this->smarty->assign('end_tab',$this->EndTab());
	$this->smarty->assign('end_tabs',$this->EndTabContent());
	$this->smarty->assign('title_form_name',$this->Lang('title_form_name'));
	$this->smarty->assign('title_form_alias',$this->Lang('title_form_alias'));
	$this->smarty->assign('start_configform',$this->CreateFormStart($id,
		'admin_update_config', $returnid));
	$this->smarty->assign('message', isset($params['fbrp_message'])?$params['fbrp_message']:'');
	
	$formArray = array();
	$currow = "row1";
	foreach ($forms as $thisForm)
	{
		$oneset = new stdClass();
		$oneset->rowclass = $currow;
		if ($this->CheckPermission('Modify Forms'))
		{
			$conf = $this->GetConfig();
			$oneset->name = $this->CreateLink($id,
				'admin_add_edit_form', '',
				$thisForm['name'], array('form_id'=>$thisForm['form_id']));
			$oneset->xml = $this->CreateLink($id,'exportxml','',"<img src=\"".$conf['root_url']."/modules/".$this->GetName()."/images/xml_rss.gif\" class=\"systemicon\" alt=\"Export Form as XML\" />",array('form_id'=>$thisForm['form_id']));
			$oneset->editlink = $this->CreateLink($id,
				'admin_add_edit_form', '',
				$gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif',$this->Lang('edit'),'','','systemicon'),
					array('form_id'=>$thisForm['form_id']));
			$oneset->deletelink = $this->CreateLink($id,
				'admin_delete_form', '',
				$gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif',$this->Lang('delete'),'','','systemicon'),
				array('form_id'=>$thisForm['form_id']),
				$this->Lang('are_you_sure_delete_form',$thisForm['name']));
	
		}
		else
		{
			$oneset->name=$thisForm['name'];
			$oneset->editlink = '';
			$oneset->deletelink = '';
		}
		$oneset->usage = $thisForm['alias'];
		array_push($formArray,$oneset);
		($currow == "row1"?$currow="row2":$currow="row1");
		}
	if ($this->CheckPermission('Modify Forms'))
	{
		$this->smarty->assign('addlink',$this->CreateLink($id,
			'admin_add_edit_form', '',
			$gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif', $this->Lang('title_add_new_form'),'',
				'','systemicon'), array()));
		$this->smarty->assign('addform',$this->CreateLink($id,
			'admin_add_edit_form', '', $this->Lang('title_add_new_form'),
			array()));
		$this->smarty->assign('may_config',1);
	}
	else
	{
		$this->smarty->assign('no_permission',
			$this->Lang('lackpermission'));
	}
	
	$this->smarty->assign('title_hide_errors',$this->Lang('title_hide_errors'));		
	$this->smarty->assign('input_hide_errors',$this->CreateInputCheckbox($id, 'fbrp_hide_errors', 1, $this->GetPreference('hide_errors','0')). $this->Lang('title_hide_errors_long'));
	
	$this->smarty->assign('title_relaxed_email_regex',$this->Lang('title_relaxed_email_regex'));		
	$this->smarty->assign('input_relaxed_email_regex',$this->CreateInputCheckbox($id, 'fbrp_relaxed_email_regex', 1, $this->GetPreference('relaxed_email_regex','0')). $this->Lang('title_relaxed_regex_long'));
	
	$this->smarty->assign('title_enable_fastadd',$this->Lang('title_enable_fastadd'));
	$this->smarty->assign('input_enable_fastadd',$this->CreateInputCheckbox($id, 'fbrp_enable_fastadd', 1, $this->GetPreference('enable_fastadd','1')). $this->Lang('title_enable_fastadd_long'));		
	
	$this->smarty->assign('title_require_fieldnames',$this->Lang('title_require_fieldnames'));		
	$this->smarty->assign('input_require_fieldnames',$this->CreateInputCheckbox($id, 'fbrp_require_fieldnames', 1, $this->GetPreference('require_fieldnames','1')). $this->Lang('title_require_fieldnames_long'));		
	
	$this->smarty->assign('title_unique_fieldnames',$this->Lang('title_unique_fieldnames'));
	$this->smarty->assign('input_unique_fieldnames',$this->CreateInputCheckbox($id, 'fbrp_unique_fieldnames', 1, $this->GetPreference('unique_fieldnames','1')). $this->Lang('title_unique_fieldnames_long'));		
	
	$this->smarty->assign('title_enable_antispam',$this->Lang('title_enable_antispam'));
	$this->smarty->assign('input_enable_antispam',$this->CreateInputCheckbox($id, 'fbrp_enable_antispam', 1, $this->GetPreference('enable_antispam','1')). $this->Lang('title_enable_antispam_long'));
	
	$this->smarty->assign('title_show_fieldids',$this->Lang('title_show_fieldids'));
	$this->smarty->assign('input_show_fieldids',
		$this->CreateInputcheckbox($id,'fbrp_show_fieldids',1,
		$this->GetPreference('show_fieldids','0')). $this->Lang('title_show_fieldids_long'));
	
	$this->smarty->assign('title_show_fieldaliases',$this->Lang('title_show_fieldaliases'));
	$this->smarty->assign('input_show_fieldaliases',
		$this->CreateInputcheckbox($id,'fbrp_show_fieldaliases',1,
		$this->GetPreference('show_fieldaliases','1')). $this->Lang('title_show_fieldaliases_long'));
	
	$this->smarty->assign('title_show_version',$this->Lang('title_show_version'));
	$this->smarty->assign('input_show_version',$this->CreateInputCheckbox($id, 'fbrp_show_version', 1, $this->GetPreference('show_version','1')). $this->Lang('title_show_version_long'));

	$this->smarty->assign('title_blank_invalid',$this->Lang('title_blank_invalid'));
	$this->smarty->assign('input_blank_invalid',$this->CreateInputCheckbox($id,
      'fbrp_blank_invalid', 1, $this->GetPreference('blank_invalid','0')).
      $this->Lang('title_blank_invalid_long'));
   			
	$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'fbrp_submit', $this->Lang('save')));
	$this->smarty->assign('end_configform',$this->CreateFormEnd());
	
	$this->smarty->assign('start_xmlform',$this->CreateFormStart($id, 'importxml', $returnid, 'post','multipart/form-data'));
	$this->smarty->assign('submitxml', $this->CreateInputSubmit($id, 'fbrp_submit', $this->Lang('upload')));
	$this->smarty->assign('end_xmlform',$this->CreateFormEnd());
	
	$this->smarty->assign('input_xml_to_upload',$this->CreateInputFile($id, 'fbrp_xmlfile'));
	$this->smarty->assign('title_xml_to_upload',$this->Lang('title_xml_to_upload'));
	$this->smarty->assign('title_xml_upload_formname',$this->Lang('title_xml_upload_formname'));
	$this->smarty->assign('input_xml_upload_formname',
	      $this->CreateInputText($id,'fbrp_import_formname','',25));
	$this->smarty->assign('title_xml_upload_formalias',$this->Lang('title_xml_upload_formalias'));
	$this->smarty->assign('input_xml_upload_formalias',
	      $this->CreateInputText($id,'fbrp_import_formalias','',25));
	$this->smarty->assign('info_leaveempty',$this->Lang('help_leaveempty'));
	$this->smarty->assign('legend_xml_import',$this->Lang('title_import_legend'));
	
	$this->smarty->assign_by_ref('forms', $formArray);			
	echo $this->ProcessTemplate('AdminMain.tpl');
?>
