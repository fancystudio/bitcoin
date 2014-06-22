<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin {{$module->getModuleName()}}')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$c = new MCFCriteria();
$entries = {{$module->getModuleName()}}Object::doSelect($c);

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="{{$module->getModuleName()}}_entries.dat"');
echo base64_encode(serialize($entries));
exit;