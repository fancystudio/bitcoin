<?php
if (!cmsms()) exit;

/*
	This allows Frontend Forms for the module
*/
if (!{{$module->getModuleName()}}Object::checkPermissions($params))
{
	echo $this->lang('you do not have the permission to use this action');
	exit;
}
if (is_object(cms_utils::get_module('CMSUsers'))) // Only work with CMSUsers for now...
{
	$user = CMSUsers::getUserOrLogin();
	
	if (isset($params['item_id']) && !empty($params['item_id'])) {
		$item = {{$module->getModuleName()}}Object::getById($params['item_id']);
		if ($item->getUserId() != $user->getId())
		{
			unset($item);
		}
		if(is_null($item))
		{
			unset($item);
		}
		
	} 	
	if (!isset($item))
	 {
		$item = new {{$module->getModuleName()}}Object();
		$item->setUserId($user->getId());
	}
	

	
	// The form
	
	$form = new CMSForm($this->GetName(), $id, 'user_form', $returnid);
	if(isset($params['buttons']))
	{
		$buttons = array();
		$labels = array();
		$each = explode(';',html_entity_decode($params['buttons']));
		foreach($each as $buttn)
		{
			list($button, $label) = explode('=>', html_entity_decode($buttn));
			$buttons[] = trim($button);
			$labels[trim($button)] = trim($label);
		}
		$form->setButtons($buttons);
		foreach($labels as $button => $label)
		{
			$form->setLabel($button, $label);
		}
	}
	$form->setWidget('item_id', 'hidden', array('object' => &$item, 'field_name' => 'id'));	
	// if(isset($params['item_id']) && !is_null($params['item_id']))
	// {
	// 	$form->getWidget('item_id')->setValues(html_entity_decode($params['item_id']));
	// }
	$form->setWidget('title', 'text', array('object' => &$item));	
	$form->setWidget('disabled', 'hidden');	
		if(isset($params['disabled']) && !is_null($params['disabled']))
		{
			$form->getWidget('disabled')->setValues(html_entity_decode($params['disabled']));
		}
	$form->setWidget('hidden', 'hidden');	
		if(isset($params['hidden']) && !is_null($params['hidden']))
		{
			$form->getWidget('hidden')->setValues(html_entity_decode($params['hidden']));
		}
	$form->setWidget('buttons', 'hidden');	
		if(isset($params['buttons']) && !is_null($params['buttons']))
		{
			$form->getWidget('buttons')->setValues(html_entity_decode($params['buttons']));
		}
	$form->setMultipartForm();
	
	if ($this->getPreference('show_parent', '0') == 1)
	{
		$form->setWidget('parent_id', 'select', array(
			'object' => &$item, 
			'values' => array(0 => '') + $item->getPossibleParentsHierarchy()
			));
			
			if(isset($params['parent_id']) && !is_null($params['parent_id']))
			{
				$form->getWidget('parent_id')->setValues($params['parent_id']);
			}
	}
	
	if(isset($params['goback']))
	{
		$form->setWidget('goback', 'hidden',array('value' =>  'true'));
		$form->setWidget('redirect_url', 'hidden',array('value' =>  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
	}

$params['frontend'] = true;

{{$module->getModuleName()}}Views::createForm($this,&$form,&$item,$params);

//var_dump($params);

// foreach()

if(isset($params['disabled']))
{
	$disabled = explode(';', $params['disabled']);
	foreach($disabled as $disable)
	{
		$form->removeWidget($disable);
	}
}

if(isset($params['hidden']))
{
	$hidden = explode(';', $params['hidden']);
	foreach($hidden as $hide)
	{
		$form->hideWidget($hide);
	}
} 

if ($form->isPosted())
{	
	$form->process();
	if($form->noError())
	{
		$item->uploadFiles($id);
		$item->save(array('frontend' => true));
		$item->userPostActions($id,$returnid,$form);
		$this->smarty->assign('item', $item);
		$this->smarty->assign('success_message', $this->lang('item posted'));
		
		if ($form->getWidget('redirect_url') && !$form->getWidget('redirect_url')->isEmpty())
		{
			return {{$module->getModuleName()}}::jumpTo($form->getWidget('redirect_url')->getValue());
		}
						
		echo $this->ProcessTemplateFor('user_form_success');
		return;
	}
}

if($item->getId() > 0)
{
	$form->getWidget('item_id')->setValues($item->getId());
	$this->smarty->assign('item_id', $item->getId());
}

$this->smarty->assign('form', $form);

echo $this->ProcessTemplateFor('user_form', $params);
}