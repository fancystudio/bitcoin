<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin Edit„CiaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$datas['Editacia cien'] = Edit„CiaCien::ExportDatas();

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="Edit„CiaCien.dat"');
echo serialize($datas);
exit;