<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin EditaciaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$c = new MCFCriteria();
$entries = EditaciaCienObject::doSelect($c);

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="EditaciaCien_entries.dat"');
echo base64_encode(serialize($entries));
exit;