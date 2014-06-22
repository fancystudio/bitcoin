<?php
if (!cmsms()) exit;
if (!$this->CheckAccess('Admin {{$module->getModuleName()}}')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

if (isset($params['cancel']))
{
	return $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'options'));
}

$fields = array('title', 'created_at', 'updated_at', 'order_by', 'mcfi_created_timestamp', 'mcfi_updated_timestamp');
{{foreach from=$extra_fields item=field}}
$fields[] = '{{$field.name}}';
{{/foreach}}
$fields = array_combine($fields, $fields);

if (isset($params['submit'])) {
	if (isset($params['index_content']))
	{
		if ($this->getPreference('index_content') == '0' || $this->getPreference('index_content') == '')
		{					
			$this->SearchReindex();
		}
	}
	else
	{
		if ($this->getPreference('index_content') == '1')
		{			
			$this->SearchDeindex();
		}
	}	
}

$templates = $this->ListTemplates();
$templates_list = array();
foreach($templates as $template)
{
	$templates_list[$template] = $template;
}

$form = new CMSForm('{{$module->getModuleName()}}', $id,'defaultadmin',$returnid);
$form->setLabel('submit', 'Save');
$form->setWidget('active_tab', 'hidden', array('value' => 'options'));
$form->setWidget('order_by', 'select', array('values' => $fields, 'preference' => 'order_by'));
$form->setWidget('order_by_direction', 'select', array('values' => array('ASC' => 'Ascending', 'DESC' => 'Descending'), 'preference' => 'order_by_direction'));
$form->setWidget('items_per_page', 'text', array('default_value' => array(25), 'preference' => 'items_per_page', 'size' => 5));
$form->setWidget('date_format', 'text', array('default_value' => array('d/m/Y'), 'preference' => 'date_format', 'size' => 10));
$form->setWidget('default_page', 'pages', array('default_value' =>  cmsms()->GetContentOperations()->GetDefaultPageID(), 'preference' => 'default_page'));
$form->setWidget('show_parent', 'checkbox', array('preference' => 'show_parent'));
$form->setWidget('show_parent_first_level', 'checkbox', array('preference' => 'show_parent_first_level'));
$form->setWidget('save_add', 'checkbox', array('preference' => 'save_add'));
$form->setWidget('index_content', 'checkbox', array('preference' => 'index_content', 'default_value' => 0));

if (MCFTools::IsModuleActive('CMon'))
{
	$form->setWidget('use_cmon', 'checkbox', array('preference' => 'use_cmon'));
	$form->setWidget('cmon_from', 'text', array('preference' => 'cmon_from'));
	$form->setWidget('cmon_from_email', 'text', array('preference' => 'cmon_from_email'));
	$form->setWidget('cmon_template', 'select', array('preference' => 'cmon_template', 'values' => $templates_list));
	$form->setWidget('cmon_template_plain', 'select', array('preference' => 'cmon_template_plain', 'values' => $templates_list));
	$form->setWidget('cmon_default_page', 'pages', array('default_value' =>  cmsms()->GetContentOperations()->GetDefaultPageID(), 'preference' => 'cmon_default_page'));
}

if (MCFTools::IsModuleActive('Twitter'))
{	
	$form->setWidget('use_twitter', 'checkbox', array('preference' => 'use_twitter'));
	$form->setWidget('twitter_template', 'textarea', array('preference' => 'twitter_template'));
}

if (isset($params['submit']))
{
	$form->process();
	return $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'options'));
}

$this->smarty->assign('form', $form);
$this->smarty->assign('update_objects', $this->CreateLink($id, 'updateObjects', $returnid, $this->lang('update_objects'), array('class' => 'actionbutton')));

$export =  new CMSForm('{{$module->getModuleName()}}', $id,'export',$returnid);
$export->setButtons(array('submit'));
$export->setLabel('submit', $this->lang('export'));
$this->smarty->assign('export', $export->render());

$this->smarty->assign('options_top', $this->getButtonsFor('options_top'));
$this->smarty->assign('options_bottom', $this->getButtonsFor('options_bottom'));

echo $this->ProcessTemplate('defaultadmin.options.tpl');

?>
