<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
  return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$view = new MCFListView('EditaciaCien', $params);



if (isset($params['item_id']) && !empty($params['item_id'])) {
  $item = EditaciaCienObject::getById($params['item_id']);
} else {
  $item = new EditaciaCienObject();
  $item->setParentItem(isset($params['parent_item']) ? $params['parent_item'] : 0);
}

if (isset($params['cancel'])) {
    $this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));
    exit;
}

$form = new CMSForm('EditaciaCien', $id,'edit',$returnid);
$buttons = array('submit','apply','cancel');
if($this->GetPreference('save_add', false) == '1')
{
  $buttons = array('submit','save_add','apply','cancel');  
  $form->setLabel('save_add', $this->Lang('save_add'));
}
$form->setButtons($buttons);
$form->setMultipartForm();
$form->setLabel('submit', $this->Lang('save'));
$form->setLabel('apply', $this->Lang('save_continue'));
$form->setLabel('cancel', $this->Lang('cancel'));

$form->setWidget('view','hidden', array('value' => $view->getView()));
$form->setWidget('item_id', 'hidden', array('object' => &$item, 'field_name' => 'id'));
$form->setWidget('parent_item', 'hidden', array('object' => &$item));

  $form->setFieldset('default---default', 'Main');
  $form->getFieldset('default---default')->setWidget('title', 'text', array('label' => 'Title','object' => &$item, 'size' => 50));
  
  if ($this->getPreference('show_parent', '0') == 1)
  {
    $form->getFieldset('default---default')->setWidget('parent_id', 'select', array(
      'object' => &$item, 
      'values' => array(0 => '') + $item->getPossibleParentsHierarchy(' - ', $this->getPreference('show_parent_first_level', '0'))
      ));
  }
  

// Custom part
$config = cms_utils::get_config();

EditaciaCienViews::createForm($this,$form,$item);





// SUB MODULES SECTION
$c = new MCFCriteria();
$c->add('parent_module', 3, MCFCriteria::EQUAL);
$child_modules = MCFModule::doSelect($c);
$submodules = array();
foreach ($child_modules as $child) {
  if (MCFTools::IsModuleActive($child->GetModuleName()))
  {
    $submodules[$child->getId()] = array('gname' => $child->GetModuleName(), 'name' => $child->GetModuleFriendlyName(), 'items' => array());
    if (!$item->isNew()) {
      $c = new MCFCriteria();
      $c->add('parent_item', $item->getId());
      $c->addAscendingOrderByColumn('order_by');
      $classname = $child->GetModuleName();
      $mod = new $classname();
      // var_dump($classname);
      $items = call_user_func(array($child->GetModuleName() . 'Object', 'doSelect'), $c);
      $submodules[$child->getId()]['template'] = call_user_func(array($child->GetModuleName() . 'Views', 'adminItems'),$mod,$id,$returnid,$view,$items,$item->getId());
      $submodules[$child->getId()]['add_item_link'] = $mod->CreateLink($id, 'edit', $returnid, $mod->Lang('add_item_for', $child->GetModuleFriendlyName()), array('parent_item' => $item->getId()));
      $submodules[$child->getId()]['add_item_icon'] = $mod->CreateLink($id, 'edit', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/newobject.gif', $mod->Lang('add_item_for', $child->GetModuleFriendlyName()), '', '', 'systemicon'));
    }
  }
}

$this->smarty->assign('submodules', $submodules);

// MODULE XTENDER SECTION

$modulextender = cms_utils::get_module('ModuleXtender');

if (is_object($modulextender) && $modulextender->isXtendedModule($this->getName())) {  
  $this->smarty->assign('xtended_form', $modulextender->XtendModuleForm('EditaciaCien', $item->getId(), $id));
} else {
  $this->smarty->assign('xtended_form', '');
}


$form->setFieldset('module---options', $this->lang('module_options'));


// if ($this->getPreference('show_parent', '0') == 1)
// {
//   $form->getFieldset('module---options')->setWidget('parent_id', 'select', array(
//     'object' => &$item, 
//     'values' => array(0 => '') + $item->getPossibleParentsHierarchy(' - ', $this->getPreference('show_parent_first_level', '0'))
//     ));
// }


if(!is_null($item->getCreatedBy())) $form->getFieldset('module---options')->setWidget('created_by', 'static', array('label' => 'Created by',  'value' => cmsms()->GetUserOperations()->LoadUserByID($item->getCreatedBy())->username . ' on ' . $item->getCreatedAt()));
$form->getFieldset('module---options')->setWidget('mcfi_created_timestamp', 'static', array('label' => 'Creation exact time', 'value' => date('d-M-Y H:i:s', $item->getMcfiCreatedTimestamp()) ));
if(!is_null($item->getUpdatedBy())) $form->getFieldset('module---options')->setWidget('updated_by', 'static', array('label' => 'Last updated by',  'value' => cmsms()->GetUserOperations()->LoadUserByID($item->getUpdatedBy())->username . ' on ' . $item->getUpdatedAt()));
$form->getFieldset('module---options')->setWidget('mcfi_updated_timestamp', 'static', array('label' => 'Update exact time', 'value' => date('d-M-Y H:i:s', $item->getMcfiUpdatedTimestamp()) ));

$pub_array = array('label' => 'Published', 'object' => &$item);
if(is_null($item->getId()))
{
  $pub_array['default_value'] = 1;
}

$form->getFieldset('module---options')->setWidget('published', 'checkbox', $pub_array);

if(cms_utils::get_module('Digest'))
{
  $dig_array = array('label' => 'Send update immediately', 'object' => &$item);
  if(is_null($item->getId()))
  {
    $dig_array['default_value'] = 1;
  }
  
  $form->getFieldset('module---options')->setWidget('send_update_immediately', 'checkbox', $dig_array);
}


$this->smarty->assign('form', $form);

// FORM PROCESSING

if ($form->isPosted()) {
  $form->process();
  if ($form->NoError())
  {
    if($item->isNew())
    {
      $log_message = 'Item created';
    }
    else
    {
      $log_message = 'Item updated';
    }
    
    
    $item->deleteFiles($params);  
    $item->uploadFiles($id);
    $item->save();
    
  	$this->Audit($item->getId(), $this->GetFriendlyName(), $log_message);
    
    if (is_object($modulextender) && $modulextender->isXtendedModule($this->getName())) {
      $modulextender->getFormInput($this->getName(), $item->getId(), $params);
    }
    $item->postActions(); // Use to allow people to tweak things.
    if (isset($params['submit'])) {
            $this->Redirect($id, 'defaultadmin', $returnid, array('view' => $view->getView()));
            exit;
    }
    elseif(isset($params['save_add'])) {
            $this->Redirect($id, 'edit', $returnid, array('view' => $view->getView()));
            exit;
    } else {
      $this->Redirect($id, 'edit', $returnid, array('view' => $view->getView(), 'item_id' => $item->getId()));
      exit;
    }
  }
}

$this->smarty->assign('tab', isset($params['tab'])?$params['tab']:null);

echo $this->ProcessTemplate('edit.tpl');
