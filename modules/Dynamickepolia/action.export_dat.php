<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin Dynamickepolia')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$datas['Dynamickepolia'] = Dynamickepolia::ExportDatas();

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="Dynamickepolia.dat"');
echo serialize($datas);
exit;