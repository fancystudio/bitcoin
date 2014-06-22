<?php
if (!isset($gCms)) exit;

if (! $this->CheckAccess()) exit;

$params['fbrp_xml_file'] = $_FILES[$id.'fbrp_xmlfile']['tmp_name'];

$aeform = new fbForm($this, $params, true);
$res = $aeform->ImportXML($params);

if ($res)
	{
	$params['fbrp_message'] = $this->Lang('form_imported');
	}
else
	{
	$params['fbrp_message'] = $this->Lang('form_import_failed');
	}
$this->DoAction('defaultadmin', $id, $params);
?>