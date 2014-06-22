<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin {{$module->getModuleName()}}')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$datas['{{$module->getModuleFriendlyName()}}'] = {{$module->getModuleName()}}::ExportDatas();

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="{{$module->getModuleName()}}.dat"');
echo serialize($datas);
exit;