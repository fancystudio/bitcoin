<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin EditaciaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$datas['Editacia cien'] = EditaciaCien::ExportDatas();

header('Content-type: text/plain');
header('Content-Disposition: attachment; filename="EditaciaCien.dat"');
echo serialize($datas);
exit;