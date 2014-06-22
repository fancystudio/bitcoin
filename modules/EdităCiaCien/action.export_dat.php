<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin EdităCiaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$datas['Editacia cien'] = EdităCiaCien::ExportDatas();

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="EdităCiaCien.dat"');
echo serialize($datas);
exit;