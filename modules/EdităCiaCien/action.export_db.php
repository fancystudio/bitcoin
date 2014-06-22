<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin Edit„CiaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$c = new MCFCriteria();
$entries = Edit„CiaCienObject::doSelect($c);

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="Edit„CiaCien_entries.dat"');
echo base64_encode(serialize($entries));
exit;