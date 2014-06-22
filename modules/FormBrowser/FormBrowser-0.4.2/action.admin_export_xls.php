<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;
$aebrowser = new fbrBrowser($this, $params, true);

$datestr = date('Y-m-d');
$sname = preg_replace('/\W/','_',$aebrowser->GetName());
$spec = $this->Lang('export_spec',array($sname,$datestr));

if ($this->GetPreference('export_file','0') == '1')
	{
	$params['filespec']=$spec;
	$config = $gCms->getConfig();
	$url= $config['uploads_url'].'/'.$spec;
	if ($aebrowser->BrowserShowListXLSFile($this,$params))
		{
		@ob_clean();
		@ob_clean();
		header('Location: '.$url);
		exit;
		}
}
$reportString = $aebrowser->BrowserShowListXLS($this,$params);

@ob_clean();
@ob_clean();
header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private',false);
header('Content-Description: File Transfer');
header('Content-Type: text/csv; charset='.$this->GetPreference('export_file_encoding','iso-8859-1')); // CSV standard, believe it or not !?
header('Content-Length: ' . strlen($reportString));
header('Content-Disposition: attachment; filename=' . $spec);
echo $reportString;
exit;
?>