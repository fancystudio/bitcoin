<?php
if (!isset($gCms)) exit;

if (preg_match('/\.tpl$/',$params['fbrp_tid']))
    {
    $tplstr = file_get_contents(dirname(__FILE__).'/templates/'.$params['fbrp_tid']);
    }
else
    {
    $db = $this->GetDb();
	list($browser_id,$template_type)=explode('.',$params['fbrp_tid']);
   $query = "SELECT value FROM ".cms_db_prefix().
		"module_fbr_browser_attr WHERE browser_id=? and name=?";
	$dbresult = $db->Execute($query,array($browser_id,$template_type.'_template'));
	if ($dbresult !== false && $row = $dbresult->FetchRow())
		{
		$tplstr = $row['value'];
		}
	else
		{
		$tplstr = 'Cannot load template?';
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
