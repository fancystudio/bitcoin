<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Admin Edit�CiaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$form = new CMSForm('Edit�CiaCien', $id,'import_db',$returnid);

if($form->isPosted())
{
  
}
else
{
  $form->setLabel('submit', 'Import');
  $form->setWidget('file', 'file');
}


echo $form->render();