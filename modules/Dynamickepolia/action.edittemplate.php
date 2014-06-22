<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Manage MC Factory')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

   Code for DocumentsLibrary "manageTemplate" admin action
   
   -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
   
   Typically, this will display something from a template
   or do some other task.
   
*/

// ROCK AND LOAD

if (isset($params['template']) && $params['template'] != '')
{
	$title = $params['template'];
	
	if (isset($params['submitbutton']) || isset($params['applybutton']))
	{
		$this->SetTemplate($params['template'], $params['templatedetails']);
		
		if (isset($params['submitbutton']))
		{
			$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'templates'));
		}
	}
}
else 
{
	$title = '';
}

// DETAILS
		
	
		
	
	
$this->smarty->assign('id', $id);
	$this->smarty->assign('form_start', $this->CreateFormStart($id, 'edittemplate', $returnid));
	
	
	$this->smarty->assign('title_template', $this->Lang('titleTemplate'));
	$this->smarty->assign('input_template',$this->CreateInputText($id, 'template', $title, 50));
	
	if (isset($params['restorelist']))
	{
		$templatecode = $this->GetTemplateFromFile('template.list');
	}	
	elseif (isset($params['restoredetails']))
	{
		$templatecode = $this->GetTemplateFromFile('template.details');
	}
	elseif (isset($params['template']) && $params['template'] != '')
	{
		$templatecode = $this->GetTemplate($params['template']);
	}
	elseif (isset($params['templatedetails']))
	{
		$templatecode = $params['templatedetails'];
	}
	else 
	{
		$templatecode = '';
	}
	
	$this->smarty->assign('code_template', $this->Lang('codeTemplate'));
	$this->smarty->assign('textarea_template', $this->CreateTextArea(true, $id, $templatecode, 'templatedetails', 'pagebigtextarea', '','', '', 90, 15, 'EditArea'));
	
	$this->smarty->assign('form_details_submit', $this->CreateInputSubmit($id, 'submitbutton', $this->Lang('submit')));
	$this->smarty->assign('form_details_apply', $this->CreateInputSubmit($id, 'applybutton', $this->Lang('apply')));
	$this->smarty->assign('form_details_restorelist', $this->CreateInputSubmit($id, 'restorelist', $this->Lang('restorelist')));
	$this->smarty->assign('form_details_restoredetails', $this->CreateInputSubmit($id, 'restoredetails', $this->Lang('restoredetails')));

	echo $this->ProcessTemplate('edittemplate.tpl');
	
?>