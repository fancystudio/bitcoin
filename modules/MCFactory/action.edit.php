<?php
if (!cmsms()) exit;
/** @var $this MCFactory */

if (!$this->CheckAccess()) {
    return $this->DisplayErrorPage();
}

/*
	Module Edition
*/

// Tabs

$tabs = array(
    'main' => false,
//	'fields' => false,
    'actions' => false,
    'extra_features' => false,
    'logic' => false,
    'options' => false
);

if (isset($params['active_tab'])) {
    $tabs[$params['active_tab']] = true;
}

$this->smarty->assign('tab_headers', $this->StartTabHeaders() .

    $this->SetTabHeader('main', $this->Lang('main'), $tabs['main']) .
//	$this->SetTabHeader('fields',$this->Lang('fields'), $tabs['fields']).
    $this->SetTabHeader('actions', $this->Lang('actions'), $tabs['actions']) .
    $this->SetTabHeader('extra_features', $this->Lang('extra_features'), $tabs['extra_features']) .
    $this->SetTabHeader('logic', $this->Lang('logic'), $tabs['logic']) .
    $this->SetTabHeader('options', $this->Lang('options'), $tabs['options']) .

    $this->EndTabHeaders() . $this->StartTabContent());

$this->smarty->assign('start_main_tab', $this->StartTab('main'));
//$this->smarty->assign('start_fields_tab',$this->StartTab('fields'));
$this->smarty->assign('start_actions_tab', $this->StartTab('actions'));
$this->smarty->assign('start_extra_features_tab', $this->StartTab('extra_features'));
$this->smarty->assign('start_logic_tab', $this->StartTab('logic'));
$this->smarty->assign('start_options_tab', $this->StartTab('options'));

$this->smarty->assign('end_tab', $this->EndTab());
$this->smarty->assign('tab_footers', $this->EndTabContent());

// Logic

if (isset($params['cancel'])) {
    $this->Redirect($id, 'defaultadmin', $returnid);
    exit;
}

if (isset($params['module_id']) && !empty($params['module_id'])) {
    $module = MCFModule::retrieveByPk($params['module_id']);
} else {
    $module = new MCFModule();
    $module->setParentModule(0);
    $module->setModuleFriendlyname('Module');
}


if (isset($params['move_up']) && is_array($params['move_up'])) {
    foreach ($params['move_up'] as $key => $value) {
        $module->orderExtraFields($key, 'up');
        $module->save();
    }
}

if (isset($params['move_down']) && is_array($params['move_down'])) {
    foreach ($params['move_down'] as $key => $value) {
        $module->orderExtraFields($key, 'down');
        $module->save();
    }
}

if (isset($params['publish']) || isset($params['save'])) {
    $module->populateFromArray($params);
    if (!isset($params['show_module'])) {
        //var_dump($params);
        $module->setShowModule(0);
    }
    if (!isset($params['api_enabled'])) {
        //var_dump($params);
        $module->setAPIEnabled(0);
    }
    if (!isset($params['is_user_module'])) {
        //var_dump($params);
        $module->setIsUserModule(0);
    }
    if (!isset($params['is_protected'])) {
        //var_dump($params);
        $module->setIsProtected(0);
    }
    // REORDER FIELDS
    if (isset($params['fields_ordered'])) {
        $str = $module->getStructure();
        foreach ($params['fields_ordered'] as $tab_key => $tabs) {
            foreach ($tabs as $fieldset_key => $fields_ordered) {
                if ($fields_ordered != '') {
                    $str->reorderFields($tab_key, $fieldset_key, $fields_ordered);
                }
            }
        }
        $module->setStructure($str);
    }

    $module->save();
    if (isset($params['publish'])) {


        $generator = new MCFGenerator($module);

        try{
            $generator->publish();
            $this->SetFlashMessage('Module ' . $module->getModuleName() . ' published!');
            echo '<h3 style="color:green">Module published!</h3>';
            cmsms()->clear_cached_files(-1); // FORCE CLEAR CACHE
            return $this->Redirect($id, 'edit', $returnid, array('module_id' => $module->getId()));

        } catch(Exception $e) {
            $this->SetFlashMessage('Error while generation the module: ' . $e->getMessage(), 'error');
            echo '<h3 style="color:red">Error while generation the module: ' . $e->getMessage() . '</h3>';
            return $this->Redirect($id, 'edit', $returnid, array('module_id' => $module->getId()));
        }

    } else {
        $this->Redirect($id, 'edit', $returnid, array('module_id' => $module->getId()));
    }
}

// TODO: SORT EVERYTHING HERE
if($module->getId())
{
    $smarty->assign('module_design', $this->CreateLink($id, 'module_design', $returnid, null, array('module_id' => $module->getId()), null, true));
}




$field_types = $module->getFieldTypes();
$field_types_with_options = array();
foreach ($field_types as $field_type) {
    if ($field_type['options']) {
        $field_types_with_options[] = $field_type['type'];
    }
}

$filter_types = $module->getFilterTypes();

//--

$form_module_options = new CMSForm($this->GetName(), $id, 'defaultadmin', $returnid);

$form_module_options->setWidget('parent_module', 'select', array('label' => 'Parent module', 'values' => MCFModule::getPossibleParentsModule($module), 'include_custom' => '', 'object' => &$module));
$form_module_options->setWidget('admin_section', 'select', array('label' => 'Admin section', 'values' => MCFModule::$possible_sections, 'object' => &$module));
$form_module_options->setWidget('show_module', 'checkbox', array('label' => 'Show module', 'object' => &$module, 'text' => 'Show the module in the admin?'));

if ($mod_instance = cms_utils::get_module($module->getModuleName())) {
    $api_url = $mod_instance->createLink($id, 'api', $returnid, $contents = '', array(), '', true, false, '', false, strtolower($module->getModuleName()) . '/api/list');
    $api_url = '(<a href="' . $api_url . '">' . $api_url . '</a>)';
} else {
    $api_url = false;
}

$form_module_options->setWidget('api_enabled', 'checkbox', array('label' => 'API', 'object' => &$module, 'text' => 'Enable API access', 'tips' => $api_url));
$form_module_options->setWidget('is_user_module', 'checkbox', array('label' => 'CMSUser\'s module', 'object' => &$module, 'text' => 'can a CMSUser add it\'s own entries?'));
$form_module_options->setWidget('is_protected', 'checkbox', array('label' => 'Protect files', 'object' => &$module, 'text' => 'Should the files uploaded be stored in a protected folder?'));

$form_module_options->setWidget('files_path', 'text', array('label' => 'File storage path (server path) in case of protected files', 'object' => &$module));

$smarty->assign('form_module_options', $form_module_options);

$this->smarty->assign('module_id', $id);
$this->smarty->assign('form_start', $this->CreateFormStart($id, 'edit', $returnid, 'post'));
$this->smarty->assign('input_module_id', $this->CreateInputHidden($id, 'module_id', $module->getId()));
$this->smarty->assign('input_module_parent', $this->CreateInputDropdown($id, 'parent_module', array_flip(array(0 => '') + MCFModule::getPossibleParentsModule($module)), -1, $module->getParentModule()));

$this->smarty->assign('input_admin_section', $this->CreateInputDropdown(
    $id,
    'admin_section',
    array_flip(MCFModule::$possible_sections),
    '-1',
    $module->getAdminSection()
));


$this->smarty->assign('input_module_friendlyname', $this->CreateInputText($id, 'module_friendlyname', $module->getModuleFriendlyname(), 50));
$this->smarty->assign('input_title_label', $this->CreateInputText($id, 'title_label', $module->getTitleLabel(), 50));
$this->smarty->assign('created_by', ($module->getCreatedBy() != '') ? cmsms()->GetUserOperations()->LoadUserByID($module->getCreatedBy())->username : null);
$this->smarty->assign('created_at', $module->getCreatedAt());
$this->smarty->assign('updated_by', ($module->getUpdatedBy() != '') ? cmsms()->GetUserOperations()->LoadUserByID($module->getUpdatedBy())->username : null);
$this->smarty->assign('updated_at', $module->getUpdatedAt());
$this->smarty->assign('filters', $module->getFilters());
$this->smarty->assign('module_logic', $this->CreateSyntaxArea($id, $module->getModuleLogic(), 'module_logic', 'pagebigtextarea', '', '', '', 90, 15));



$this->smarty->assign('publish_button', $this->CreateInputSubmit($id, 'publish', 'Publish'));
$this->smarty->assign('save_button', $this->CreateInputSubmit($id, 'save', 'Save'));
$this->smarty->assign('cancel_button', $this->CreateInputSubmit($id, 'cancel', 'Cancel'));
$this->smarty->assign('field_types', $field_types);
$this->smarty->assign('field_types_with_options', $field_types_with_options);
$this->smarty->assign('filter_types', $filter_types);

$this->smarty->assign('move_up', $this->getImage('arrow_up.png'));
$this->smarty->assign('move_down', $this->getImage('arrow_down.png'));

$this->smarty->assign('remove_icon', cmsms()->get_variable('admintheme')->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'));
$this->smarty->assign('edit_icon', cmsms()->get_variable('admintheme')->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'));
$this->smarty->assign('add_icon', cmsms()->get_variable('admintheme')->DisplayImage('icons/system/newobject.gif', $this->Lang('add'), '', '', 'systemicon'));

//$this->smarty->assign('up_icon',cmsms()->get_variable('admintheme')->DisplayImage('icons/system/up.gif','', '', '', 'systemicon'));
//$this->smarty->assign('down_icon',cmsms()->get_variable('admintheme')->DisplayImage('icons/system/down.gif', $this->Lang('move_down'), '', '', 'systemicon'));


// Active field tab
$this->smarty->assign('active_fields_tab', (isset($params['active_fields_tab'])) ? $params['active_fields_tab'] : '');

$fields = $module->getFieldTypes();
$select = array();
foreach ($fields as $field) {
    $select[$field['type']] = $field['label'];
}

// --- STRUCTURE ---
$this->smarty->assign('extra_fields', $module->getOldExtraFields());
$this->smarty->assign('structure', $module->getStructure());

// echo '<pre>';
// var_dump($module->getStructure());
// echo '</pre>';

// --- TAB FORM ---
$tab_form = new CMSForm('MCFactory', $id, 'manage_tabs', $returnid);
$tab_form->setButtons(array());
$tab_form->setWidget('module_id', 'hidden', array('value' => $module->getId()));
$tab_form->setWidget('name', 'text', array('size' => 45));
$this->smarty->assign('tab_form', $tab_form);

// --- TAB REMOVE FORM ---
$tab_remove_form = new CMSForm('MCFactory', $id, 'manage_tabs', $returnid);
$tab_remove_form->setButtons(array());
$tab_remove_form->setWidget('module_id', 'hidden', array('value' => $module->getId()));
$tab_remove_form->setWidget('remove_tab', 'hidden');
$this->smarty->assign('tab_remove_form', $tab_remove_form);

// --- FIELDSET FORM ---
$fieldset_form = new CMSForm('MCFactory', $id, 'manage_fieldset', $returnid);
$fieldset_form->setButtons(array());
$fieldset_form->setWidget('module_id', 'hidden', array('value' => $module->getId()));
$fieldset_form->setWidget('tab_key', 'hidden');
$fieldset_form->setWidget('name', 'text', array('size' => 45));
$this->smarty->assign('fieldset_form', $fieldset_form);

// --- REMOVE FIELDSET FORM ---
$remove_fieldset_form = new CMSForm('MCFactory', $id, 'manage_fieldset', $returnid);
$remove_fieldset_form->setButtons(array());
$remove_fieldset_form->setWidget('module_id', 'hidden', array('value' => $module->getId()));
$remove_fieldset_form->setWidget('tab_key', 'hidden');
$remove_fieldset_form->setWidget('remove_fieldset', 'hidden');
$this->smarty->assign('remove_fieldset_form', $remove_fieldset_form);

// --- ADD/EDIT FIELD FORM ---
$add_field_form = new CMSForm('MCFactory', $id, 'manage_field', $returnid);
$add_field_form->setButtons(array());
$add_field_form->setWidget('module_id', 'hidden', array('value' => $module->getId()));
$add_field_form->setWidget('tab_key', 'hidden');
$add_field_form->setWidget('fieldset_key', 'hidden');
$add_field_form->setWidget('label', 'text', array('size' => 45));
$add_field_form->setWidget('name', 'hidden');
$add_field_form->setWidget('place', 'select', array('values' => $module->getStructure()->getFieldsetsWithTabsForSelect()));
$add_field_form->setWidget('type', 'hidden');
$add_field_form->setWidget('type_select', 'select', array('values' => $select));
$add_field_form->setWidget('options', 'textarea', array('cols' => 40, 'rows' => 4, 'addtext' => 'style="width:25em;height:10em;"'));
$add_field_form->setWidget('column', 'checkbox');
$add_field_form->setWidget('filter', 'checkbox');
$add_field_form->setWidget('frontend', 'checkbox');
$this->smarty->assign('add_field_form', $add_field_form);

// --- REMOVE FIELD FORM ---
$remove_field_form = new CMSForm('MCFactory', $id, 'manage_field', $returnid);
$remove_field_form->setButtons(array());
$remove_field_form->setWidget('module_id', 'hidden', array('value' => $module->getId()));
$remove_field_form->setWidget('tab_key', 'hidden');
$remove_field_form->setWidget('fieldset_key', 'hidden');
$remove_field_form->setWidget('field', 'hidden');
$this->smarty->assign('remove_field_form', $remove_field_form);


// Actions
$this->smarty->assign('add_action_url', (isset($params['module_id'])) ? $this->CreateLink($id, 'manage_action', $returnid, '', array('module_id' => $params['module_id']), '', true, false) : 'First save the module core in order to add actions');
$actions = (isset($params['module_id'])) ? MCFModuleAction::doSelect(array('where' => array('module_id' => $params['module_id']))) : array();
foreach ($actions as $action) {
    $action->edit_url = $this->CreateLink($id, 'manage_action', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('module_action_id' => $action->getId()));

    $action->delete_url = $this->CreateLink($id, 'delete_action', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('module_action_id' => $action->getId()));

    if ($action->is_public == 1) {
        $action->is_public_icon = cmsms()->get_variable('admintheme')->DisplayImage('icons/system/true.gif', '', '', '', 'systemicon');
    } else {
        $action->is_public_icon = cmsms()->get_variable('admintheme')->DisplayImage('icons/system/false.gif', '', '', '', 'systemicon');
    }
}
$this->smarty->assign('actions', $actions);

// Extra features

$extra_features = $module->getExtraFeatures();

$smarty_events = array();

if (isset($params['module_id'])) {
    if (is_array($extra_features->getEvents())) {
        foreach ($extra_features->getEvents() as $module_name => $events) {
            foreach ($events as $event_name => $code) {
                $smarty_events[] = array(
                    'module_name' => $module_name,
                    'event_name' => $event_name,
                    'edit' => $this->CreateLink($id, 'manage_event', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('module_id' => $params['module_id'], 'module_name' => $module_name, 'event_name' => $event_name)),
                    'delete' => $this->CreateLink($id, 'manage_event', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/delete.gif', $this->Lang('edit'), '', '', 'systemicon'), array('module_id' => $params['module_id'], 'delete' => true, 'module_name' => $module_name, 'event_name' => $event_name), 'Are you sure you want to delete this event?')
                );
            }
        }
    }
}


$this->smarty->assign('events', $smarty_events);
$this->smarty->assign('add_event', (isset($params['module_id'])) ? $this->CreateLink($id, 'manage_event', $returnid, '', array('module_id' => $params['module_id']), '', true, false) : 'First save the module core in order to add events');

// Templates: Restore

$this->smarty->assign('templates_restore_url', (isset($params['module_id'])) ? $this->CreateLink($id, 'templates_restore', $returnid, '', array('module_id' => $params['module_id']), '', true, false) : 'First save the module core in order to manage templates');

echo $this->ProcessTemplate('edit.tpl');

