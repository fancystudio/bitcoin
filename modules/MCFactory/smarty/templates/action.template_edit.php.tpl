<?php
if(!cmsms()) exit;
if (! $this->CheckAccess('Modify Templates')) // Restrict to admin panel and users with permission
{
	return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
	exit;
}

$form = new CMSForm($this->GetName(), $id, 'template_edit',$returnid);
$form->setButtons(array('submit','apply','cancel'));
$form->setMethod('post');
$form->setWidget('template','text',array('validators' => array('not_empty' => true)));
$form->setWidget('code', 'codearea');
$form->setWidget('restore_template_from', 'select', array('values' => array_merge(array('select' => $this->lang('select one')),{{$module->getModuleName()}}::$frontend_templates)));
$form->setWidget('default_template_for', 'select', array('values' => array_merge(array('select' => $this->lang('select one')),{{$module->getModuleName()}}::$frontend_templates)));

if (!$form->getWidget('template')->isEmpty())
{
	if ($form->getWidget('code')->isEmpty() && !$form->isPosted())
	{
		$form->getWidget('code')->setValues($this->getTemplate($form->getWidget('template')->getValue()));
	}
	
	$action = $this->isDefaultTemplate($form->getWidget('template')->getValue());
	if ($form->getWidget('default_template_for')->isEmpty() && ($action !== false))
	{
		$form->getWidget('default_template_for')->setValues($action);
	}
}

if ($form->isPosted())
{
	$restore = $form->getWidget('restore_template_from')->getValue();
	if ($restore != '')
	{
		if (is_file(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'frontend.'.$restore . '.tpl'))
		{
			$form->getWidget('code')->setValues($this->GetTemplateFromFile('frontend.'.$restore));
			$form->getWidget('restore_template_from')->setValues('');
		}
	}
	
	$form->process();
	
	if(!$form->hasErrors())
	{
			$this->SetTemplate($form->getWidget('template')->getValue(), $form->getWidget('code')->getValue());
			
			$action = $form->getWidget('default_template_for')->getValue();

			if ($action == 'select')
			{
				$this->RemoveDefaultTemplate($form->getWidget('template')->getValue());
			}
			else
			{
				
				$this->AddDefaultTemplate($action, $form->getWidget('template')->getValue());
				$form->getWidget('default_template_for')->setValues($action);
			}
			
			if ($form->isSubmitted())
			{
					return $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'templates'));
			}
	}
}

if ($form->isCancelled())
{
			return $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'templates'));
}

$this->smarty->assign('id', $id);
$this->smarty->assign('form', $form);

echo $this->ProcessTemplate('admin.template_edit.tpl');