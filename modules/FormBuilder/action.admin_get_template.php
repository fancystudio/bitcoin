<?php
if (!isset($gCms)) exit;

if (preg_match('/\.tpl$/',$params['fbrp_tid']))
    {
    $tplstr = file_get_contents(dirname(__FILE__).'/templates/'.$params['fbrp_tid']);
    }
else
    {
    $db = $this->GetDb();
    $query = "SELECT value FROM ".cms_db_prefix().
		"module_fb_form_attr WHERE form_id=? and name='form_template'";
	$dbresult = $db->Execute($query,array($params['fbrp_tid']));
	if ($dbresult !== false && $row = $dbresult->FetchRow())
		{
		$tplstr = $row['value'];
		}
    }

    @ob_clean();
    @ob_clean();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Description: File Transfer');
    header('Content-Length: ' . strlen($tplstr));
    echo $tplstr;
    exit;
?>
