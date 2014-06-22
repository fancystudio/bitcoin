<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('Modify Templates') ) exit;
$errors = array();

// get parameters
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$template = isset($params['template']) ? (int)$params['template'] : 0;
$title = isset($params['title']) ? $params['title'] : '';
$content = isset($params['content']) ? $params['content'] : '';

// Save template changes
if (isset($params['submit']) || isset($params['cache']) || isset($params['add']) || isset($params['cacheadd']) || isset($params['apply'])) {
	// Edit template
	if ($template) {
		$res = $db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_templates SET name=?, content=? WHERE entry_id=?',array($title, $content, $template));
		if(!$res) { $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')'; }
	// Insert new template
	} else {
		$res = $db->Execute('INSERT INTO '.cms_db_prefix().'module_eventslisting_templates (name, content) VALUES (?, ?)',array($title, $content));
		$template = $db->GetOne('SELECT entry_id FROM '.cms_db_prefix().'module_eventslisting_templates WHERE name = ? ORDER BY entry_id DESC LIMIT 1', array($title));
	}
}

// Redirect
if (isset($params['submit']) || isset($params['add'])) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto, 'errors' => implode(',',str_replace(',',';',$errors)), 'message' => $this->Lang('changessaved')));
elseif (isset($params['cancel'])) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto));
else $this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto, 'template'=>$template ));

/*
// Edit template
if(isset($params['submit']) || isset($params['apply'])) {
	if($params['template_name'] != '' && $params['template_text'] != '') {
		$query = 'UPDATE ' . cms_db_prefix() . 'module_eventslisting_templates SET name=?,content=? WHERE entry_id=' . $entry_id;
		$result = $db->Execute($query, array($template_name, $template_text));
		if(!$result) {
			$errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
		} else {
			if(!isset($params['apply'])) {
				$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'templates', 'message' => 'changessaved'));
			} else {
				echo $this->ShowMessage($this->Lang('changessaved'));
			}
		}
	} else {
		if($params['template_name'] == '') $errors[] = $this->Lang('no_template_name');
		if($params['template_text'] == '') $errors[] = $this->Lang('no_template_code');
	}
} else {
	$query = 'SELECT * FROM ' . cms_db_prefix() . 'module_eventslisting_templates WHERE entry_id = ' . $entry_id;
	$dbresult =& $db->Execute($query);
	if(!$dbresult) {
		$errors[] = $this->Lang('nosuchid', array($entry_id));
		$entry_id = '';
	} else {
		$row 		= $dbresult->FetchRow();
		$template_name	= $row['name'];
		$template_text	= $row['content'];
	}
}

// Display form for editing an template
if(count($errors)) echo $this->ShowErrors($errors);
if(isset($params['entry_id'])) $smarty->assign('idfield', $this->CreateInputHidden($id, 'entry_id', $params['entry_id']));
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_edittemplate', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('prompt_template_name', $this->Lang('prompt_template_name'));
$smarty->assign('prompt_template_code', $this->Lang('prompt_template_code'));
$smarty->assign('input_name', $this->CreateInputText($id, 'template_name', $template_name));
$smarty->assign('input_template', $this->CreateTextArea(false, $id, $template_text, 'template_text'));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('apply', $this->CreateInputSubmit($id, 'apply', lang('apply')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
echo $this->ProcessTemplate('edittemplate.tpl');
*/
// EOF