<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin Dynamickepolia')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$c = new MCFCriteria();
$entries = DynamickepoliaObject::doSelect($c);

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="Dynamickepolia_entries.dat"');
echo base64_encode(serialize($entries));
exit;