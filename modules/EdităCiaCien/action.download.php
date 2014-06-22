<?php

if (!cmsms()) exit;

$c = new MCFCriteria();
$c->add('id', $params['item_id']);

$publishing_checks = true;
if(isset($params['show_user_items']) && MCFTools::IsModuleActive('CMSUsers'))
{
	$user = CMSUsers::getUserOrLogin();
	if (is_object($user))
	{
		$c->add('user_id', $user->getId());
		$publishing_checks = false;
	}

}
if ($publishing_checks && (!(isset($params['preview_key']) && $_SESSION['EditãCiaCien']['preview_key'] == $params['preview_key'])))
{
	$c->add('published', '1');	
	EditãCiaCienObject::globalFrontendFilters($c);
}
$item = EditãCiaCienObject::doSelectOne($c);
if(is_object($item)) echo $item->downloadMCFFile($params['field']);