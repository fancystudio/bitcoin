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
if ($publishing_checks && (!(isset($params['preview_key']) && $_SESSION['{{$module->getModuleName()}}']['preview_key'] == $params['preview_key'])))
{
	$c->add('published', '1');	
	{{$module->getModuleName()}}Object::globalFrontendFilters($c);
}

$item = {{$module->getModuleName()}}Object::doSelectOne($c);

if (is_object($item) && class_exists('XT_XtendedModule') && XT_XtendedModule::isXtendedModule($this->getName()))
{
	/* Attached lists */
  $xtended_felist = MX_XtendedModule::getRelatedItems($this->getName(), $item->getId());
	$item->xtended_felist = $xtended_felist;
	// deprecated
	$this->smarty->assign('xtended_felist', $xtended_felist);
	
}

if (isset($params['var'])) {
    $this->smarty->assign($params['var'], $item);
} else {
    $this->smarty->assign('item', $item);
    $this->smarty->assign('{{$module->getModuleName()}}', $item);
    $paramsobj = new stdClass();
    $paramsobj->params = $params;
    $this->smarty->assign('mcfactory', $paramsobj);
    $this->smarty->assign('{{$module->getModuleName()|lower}}_params', $paramsobj);
    
		if (isset($params['detailtemplate'])) $params['template'] = $params['detailtemplate'];

		echo $this->ProcessTemplateFor('detail', $params);
		return;
{{*
    // if (isset($params['detailtemplate']) && $this->GetTemplate($params['detailtemplate'])) {
    // 	echo $this->ProcessTemplateFromDatabase($params['detailtemplate']);
    // } else {
    // 	echo $this->ProcessTemplateFromDatabase('display_details');
    // }
*}}
}
