<?php

if (!cmsms()) exit;
if (!$this->CheckAccess('Manage MC Factory')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}
Edit�CiaCienObject::updateObjects();
$this->Redirect($id, 'defaultadmin', $returnid);