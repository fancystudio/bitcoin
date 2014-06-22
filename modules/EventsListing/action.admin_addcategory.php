<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if (!$this->CheckPermission('EventsListing: modify categories')) exit;

// prepare other things
if (isset($params['cancel'])) $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'categories'));
$db = cmsms()->GetDb();
$contentops =& cmsms()->GetContentOperations();
$errors = array();

// get parameters
$short_desc	= (isset($params['short_desc']) ? $params['short_desc'] : '');
$long_desc	= (isset($params['long_desc']) ? $params['long_desc'] : '');

// Edit event
if (isset($params['submit'])) { 
	if($short_desc) {
		$entry_id = $db->GenID(cms_db_prefix().'module_eventslisting_category_seq');
		$query = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_category (entry_id, short_desc, long_desc) VALUES (?, ?, ?)';
		$result = $db->Execute($query, array($entry_id, $short_desc, $long_desc));
		if(!$result) {
			$errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')';
		} else {
			$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'categories', 'message' => 'changessaved'));
		}
	} else {
		if(!$params['short_desc']) $errors[] = $this->Lang('no_short_desc');
	}
}

if(count($errors)) echo $this->ShowErrors($errors);
if(isset($entry_id)) $smarty->assign('idfield', $this->CreateInputHidden($id, 'entry_id', $entry_id));

$smarty->assign('formid',$id);
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_addcategory', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('prompt_short', $this->Lang('prompt_short'));
$smarty->assign('prompt_long', $this->Lang('prompt_long'));
$smarty->assign('input_short', $this->CreateInputText($id, 'short_desc', $short_desc));
$smarty->assign('input_long', $this->CreateTextArea(true, $id, $long_desc, 'long_desc'));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

echo $this->ProcessTemplate('editcategory.tpl');

// EOF