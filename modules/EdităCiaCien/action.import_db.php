<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin EditãCiaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$form = new CMSForm('EditãCiaCien', $id,'import_db',$returnid);

if($form->isPosted())
{
  
}
else
{
  $form->setLabel('submit', 'Import');
  $form->setWidget('file', 'file');
}


echo $form->render();