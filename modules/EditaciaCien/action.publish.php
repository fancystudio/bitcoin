<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('EditaciaCien', $params);

$item = EditaciaCienObject::getById($params['item_id']);
$item->setPublished($item->getPublished() ? 0 : 1);
$item->save();

$this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));

?>
