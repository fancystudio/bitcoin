<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if(!$this->CheckPermission('EventsListing: modify templates') ) exit;

if (isset($params['cancel'])) $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'templates'));
$errors = array();

$template_text 	= (isset($params['template_text']) ? $params['template_text'] : '');
$template_name 	= (isset($params['template_name']) ? $params['template_name'] : '');

if(isset($params['submit'])) {

	$db =& $this->GetDb();

	if($template_text != '' && $template_name != '') {

		$entry_id = $db->GenID(cms_db_prefix()."module_eventslisting_templates_seq");

		$query = 'INSERT INTO ' . cms_db_prefix() . 'module_eventslisting_templates (entry_id, name, content) 
					VALUES (?, ?, ?)';

		$result = $db->Execute($query, array($entry_id, $template_name, $template_text));

		if(!$result) {

			$errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';

		} else {

			$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'templates', 'message' => 'changessaved'));

		}

	} else {

		if($params['template_text'] == '')
			$errors[] = $this->Lang('no_template_text');

		if($params['template_name'] == '')
			$errors[] = $this->Lang('no_template_name');

	}

}

if(count($errors))
	echo $this->ShowErrors($errors);

if(isset($params['entry_id']))
	$smarty->assign('idfield', $this->CreateInputHidden($id, 'entry_id', $params['entry_id']));

$smarty->assign('startform', $this->CreateFormStart($id, 'admin_addtemplate', $returnid, array('active_tab' => 'templates')));
$smarty->assign('endform', $this->CreateFormEnd());

$smarty->assign('prompt_template_name', $this->Lang('prompt_template_name'));
$smarty->assign('prompt_template_code', $this->Lang('prompt_template_code'));

$smarty->assign('input_name', $this->CreateInputText($id, 'template_name', $template_name));
$smarty->assign('input_template', $this->CreateTextArea(false, $id, $template_text, 'template_text'));

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

echo $this->ProcessTemplate('edittemplate.tpl');

// EOF