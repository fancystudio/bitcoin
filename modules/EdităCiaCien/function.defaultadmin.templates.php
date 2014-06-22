<?php

// NEW

if (!$this->CheckAccess('Modify Templates')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$list_templates = $this->ListTemplates();
$templates = array();
foreach($list_templates as $template) {
	$row = array(
		'titlelink' => $this->CreateLink($id, 'template_edit', $returnid, $template, array('template' => $template), '', false, false, 'class="itemlink"'),
		'deletelink' => $this->CreateLink($id, 'template_delete', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('template' => $template), $this->lang('are you sure you want to delete this template')),
		'editlink' => $this->CreateLink($id, 'template_edit', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/edit.gif', $template, '', '', 'systemicon'), array('template' => $template))
	);
	
	if ($this->isDefaultTemplate($template) !== false)
	{
		$row['default'] = $this->lang('default template for', $this->isDefaultTemplate($template));
	}
	else
	{
		$row['default'] = '';
	}
	
	$templates[] = $row;
}
$this->smarty->assign('templates', $templates);
$this->smarty->assign('add_templates_link', $this->CreateLink($id, 'template_edit', $returnid, $this->Lang('add template')));
$this->smarty->assign('add_templates_icon', $this->CreateLink($id, 'template_edit', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/newobject.gif', $this->Lang('add template'), '', '', 'systemicon')));

echo $this->ProcessTemplate('admin.templates.tpl');