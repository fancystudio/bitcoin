<?php

if (!cmsms()) exit;
if (!$this->CheckAccess('Manage MC Factory')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}
EditãCiaCienObject::updateObjects();
$this->Redirect($id, 'defaultadmin', $returnid);