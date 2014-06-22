<?php

/*
	// CLASS TO HANDLE THE VIEWS
*/

class {{$module->getModuleName()}}Views {

public static function adminItems($module,$id,$returnid,$view,$items,$parent_id=null)
{
	if (!cmsms()) exit;

	// Preview code
	if (!isset($_SESSION['{{$module->getModuleName()}}']['preview_key']))
	{
		$_SESSION['{{$module->getModuleName()}}']['preview_key'] = base64_encode(time());
	}

	if (is_null($parent_id) && !$view->getIsTree())
	{
		$totalItems = $view->getTotalItems();
	}
	else
	{
		$totalItems = count($items);
	}
		
	$module->smarty->assign('total_items', $totalItems);
		
	$ids = array();
	$rows = array();
	
	// TREE
	
	if($view->getIsTree())
	{
		$tree = new MCFTree($items, 'parent_id');
		$items = $tree->getFlatenTree();
	}
	
	// END TREE

	foreach ($items as $item) {
		$ids[] = $item->getId();
		$rows[$item->getId()] = array(
		  'id' => $item->getId(),
		  'parent_id' => $item->getParentId(),
			'titlelink' => $module->CreateLink($id, 'edit', $returnid, (string)$item, array('view' => $view->getView(), 'item_id' => $item->getId()), '', false, false, 'class="itemlink"'),
			'publishlink' => $module->CreateLink($id, 'publish', $returnid, cmsms()->get_variable('admintheme')->DisplayImage(($item->getPublished() ? 'icons/system/true.gif' : 'icons/system/false.gif'), ($item->getPublished() ? $module->Lang('unpublish') : $module->Lang('publish')), '', '', 'systemicon'), array('view' => $view->getView(), 'item_id' => $item->getId())),
			'deletelink' => $module->CreateLink($id, 'delete', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/delete.gif', $module->Lang('delete'), '', '', 'systemicon'), array('view' => $view->getView(), 'item_id' => $item->getId()), 'Are you sure you want to delete this entry?'),
			'editlink' => $module->CreateLink($id, 'edit', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/edit.gif', $item->getTitle(), '', '', 'systemicon'), array('view' => $view->getView(), 'item_id' => $item->getId())),
			'previewlink' => $module->CreateLink($id, 'detail', $module->getPreference('default_page'), cmsms()->get_variable('admintheme')->DisplayImage('icons/system/view.gif', $module->lang('preview_s',$item->getTitle()), '', '', 'systemicon'), array('preview_key' => $_SESSION['{{$module->getModuleName()}}']['preview_key'], 'item_id' => $item->getId()), '', false,false,' target="_new"', true)

		);
		
		if($view->getIsTree())	{
			$rows[$item->getId()]['level'] = $item->getLevel();
			
			if($item->hasChildrens())
			{
				if($view->isBrancheOpen($item->getId()))
				{
					$rows[$item->getId()]['arrow'] = $module->CreateLink($id, 'defaultadmin', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/contract.gif', $module->lang('collapse'), '', '', 'systemicon'), array('close_branche' => $item->getId(),'view' => $view->getView()), '', false,false,'', true);
				}
				else
				{
					$rows[$item->getId()]['arrow'] = $module->CreateLink($id, 'defaultadmin', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/expand.gif', $module->lang('expand'), '', '', 'systemicon'), array('open_branche' => $item->getId(),'view' => $view->getView()), '', false,false,'', true);
				}
			}
			else
			{
				$rows[$item->getId()]['arrow'] = cmsms()->get_variable('admintheme')->DisplayImage('icons/extra/space.gif', '', 11, 16, 'systemicon');
			}
			// $rows[$item->getId()]['frontspace'] = $item->getLevel() * '&nbsp;&nbsp;';
		}
				
		if($module->getPreference('use_cmon', '0') == '1')
		{
			$url = $module->CreateLink($id, 'detail', $module->getPreference('cmon_default_page'), '', array('detailtemplate' => $module->getPreference('cmon_template'), 'item_id' => $item->getId()), '', true,false,'', true);
			$plain_url = $module->CreateLink($id, 'detail', $module->getPreference('cmon_default_page'), '', array('showtemplate' => 'false', 'detailtemplate' => $module->getPreference('cmon_template_plain'), 'item_id' => $item->getId()), '', true,false,'', true);
			
			$from = $module->GetPreference('cmon_from', null);
			$from_email = $module->GetPreference('cmon_from_email', null);
			
			$cmon = cms_utils::get_module('CMon');
			
			if($cmon)
			{
				$rows[$item->getId()]['cmon'] =  $cmon->createSendLink($id,$returnid,$url,$plain_url, $from, $from_email);
			}
			else
			{
				$rows[$item->getId()]['cmon'] =  '';
			}
			
		}
		else
		{
			$rows[$item->getId()]['cmon'] = '';
		}
		
		if (($module->getPreference('use_twitter', '0') == '1') && MCFTools::IsModuleActive('Twitter'))
		{
			$url = $module->CreateLink($id, 'detail', $module->getPreference('default_page'), '', array('detailtemplate' => $module->getPreference('cmon_template'), 'item_id' => $item->getId()), '', true,false,'', true);
			$title = $item->getTitle();
			
			$status = str_replace('{$title}', $title, str_replace('{$url}', $url, $module->getPreference('twitter_template', '{$title} - {$url}'))); // TODO: Replace that by real smarty
			
			$rows[$item->getId()]['twitter'] =  cms_utils::get_module('Twitter')->createSendLink($id,$returnid,array('status' => $status));
		}
		else
		{
			$rows[$item->getId()]['twitter'] = '';
		}
		
		if (!$view->isCustomOrder() || $view->getIsTree()) { //&& is_null($parent_id)
			
		    // $index = ($view->getPage() - 1) * $view->getItemsPerPage() + $i; // $i to replace
		  	
				if($view->getIsTree())
				{
					$sibling = $item->countSibling();
				}
				else
				{
					$sibling = $item->countSibling('parent_item');					
				}
			
		  	if ($item->order_by > 1) {
	    		$rows[$item->getId()]['moveuplink'] = $module->CreateLink($id, 'moveup', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/arrow-u.gif', $item->getTitle(), '', '', 'systemicon'), array('view' => $view->getView(), 'item_id' => $item->getId()), '', false, false, 'class="itemlink"');
	    	}
	    	if ($item->order_by < $sibling) {
	    		$rows[$item->getId()]['movedownlink'] = $module->CreateLink($id, 'movedown', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/arrow-d.gif', $item->getTitle(), '', '', 'systemicon'), array('view' => $view->getView(), 'item_id' => $item->getId()), '', false, false, 'class="itemlink"');
	    	}
		}
	}
	
	$module->smarty->assign('rows', $rows);
	
	// EXTRA COLUMNS
	$results = array();
	
	foreach ($items as $item)
	{
		
	{{if isset($is_user_module)}}
		$results['User'][$item->getId()][] = (string)$item->getUser();
	{{/if}}
	
	{{foreach from=$extra_fields item=field}}
	{{if $field.column == 'true' || $field.column == '1'}}
		{{if $field.type == 'date'}}
			$results['{{$field.label}}'][$item->getId()][] = date($module->getPreference('date_format', 'd/m/Y'), strtotime($item->get{{$field.camelcase}}()));
		{{elseif $field.type == 'datetime'}}
			$results['{{$field.label}}'][$item->getId()][] = date($module->getPreference('date_format', 'd/m/Y H:i:s'), $item->get{{$field.camelcase}}());
		{{elseif $field.type == 'module'}}
			{{if isset($field.foptions.multiple)}}
				$results['{{$field.label}}'][$item->getId()][] = implode(', ', $item->get{{$field.camelcase}}Items());
			{{else}}
				$results['{{$field.label}}'][$item->getId()][] = $item->get{{$field.camelcase}}Object();		
			{{/if}}		
		{{elseif $field.type == 'select'}}
			{{if isset($field.foptions.multiple)}}
				$results['{{$field.label}}'][$item->getId()][] = implode(', ', $item->get{{$field.camelcase}}Values());
			{{else}}
				$results['{{$field.label}}'][$item->getId()][] = $item->get{{$field.camelcase}}Value();		
			{{/if}}					
		{{elseif $field.type == 'group'}}
			{{if isset($field.foptions.multiple)}}
				$results['{{$field.label}}'][$item->getId()][] = implode(', ', $item->get{{$field.camelcase}}Values());
			{{else}}
				$results['{{$field.label}}'][$item->getId()][] = $item->get{{$field.camelcase}}Value();		
			{{/if}}	
		{{elseif $field.type == 'user'}}
			{{if isset($field.foptions.multiple)}}
				$results['{{$field.label}}'][$item->getId()][] = implode(', ', $item->get{{$field.camelcase}}Values());
			{{else}}
				$results['{{$field.label}}'][$item->getId()][] = $item->get{{$field.camelcase}}Value();		
			{{/if}}		
		{{elseif $field.type == 'country'}}
			{{if isset($field.foptions.multiple)}}
				$results['{{$field.label}}'][$item->getId()][] = implode(', ', $item->get{{$field.camelcase}}Values());
			{{else}}
				$results['{{$field.label}}'][$item->getId()][] = $item->get{{$field.camelcase}}Value();		
			{{/if}}
		{{elseif $field.type == 'user'}}
			if(class_exists('CMSUser'))
			{
				$results['{{$field.label}}'][$item->getId()][] = CMSUser::getUserNameById($item->get{{$field.camelcase}}());
			}
			else
			{
				$results['{{$field.label}}'][$item->getId()][] = $item->get{{$field.camelcase}}();
			}
		{{else}}
			$results['{{$field.label}}'][$item->getId()][] = $item->get{{$field.camelcase}}();
		{{/if}}
	{{/if}}
	{{/foreach}}
	}

  if(class_exists('MX_Relation'))
  {
    $columns = MX_Relation::getColumns($module->getName());
  	foreach ($columns as $column) 
  	{
  	  $results[$column->getTitle(false, true)] = MX_RelationLink::getRelatedItemsByRelations($column, $ids);
  	}
  }

 	$module->smarty->assign('columns', $results);
	// END EXTRA COLUMNS

	$totalPages = $view->getTotalPages();

	if (is_null($parent_id))
	{
		$pages = array();
		for ($i = 1; $i <= $totalPages; ++$i) {
			$pages[] = $module->CreateLink($id, 'defaultadmin', $returnid, $i, array('view' => $view->getView(), 'page' => $i), '', false, false);
		}
		
		$module->smarty->assign('pages', $pages);
		$module->smarty->assign('currentPage', $view->getPage());
		$module->smarty->assign('add_item_link', $module->CreateLink($id, 'edit', $returnid, 'Add item', array('view' => $view->getView())));
		$module->smarty->assign('add_item_icon', $module->CreateLink($id, 'edit', $returnid, cmsms()->get_variable('admintheme')->DisplayImage('icons/system/newobject.gif', $module->Lang('add_item'), '', '', 'systemicon'), array('view' => $view->getView())));


		$currentCategoryFilters = $view->getCategoryFilters();
		$currentPageFilters = $view->getPageFilters();
		$currentModuleFilters = $view->getModuleFilters();
		
		$form = new CMSForm($module->GetName(), $id,'defaultadmin', $returnid);
		$form->setButtons(array('filter','clear_filters'));
		$form->setMultipartForm();
		$form->setLabel('filter', 'Filter');
		$form->setLabel('clear_filters', 'Clear');
		$form->setWidget('titleFilter', 'text', array('label'=>'', 'value' => $view->getTitleFilter(), 'size' => 10));
		
		// TODO: Insert modules filters here
		{{$module->getModuleName()}}Object::buildFiltersWidgets($form, $currentModuleFilters);		

		$modulextender = cms_utils::get_module('ModuleXtender');
		
		if (is_object($modulextender) && $modulextender->isXtendedModule($module->GetName()))
		{
				foreach (MX_Relation::getFilters($module->getName()) as $key => $filter) 
				{
					if ($filter->getType() == 'category') {
			        $values = array(0 => '&laquo; ' . $filter->getTitle(false, true) . ' &raquo;');
		    		foreach ($filter->getRelatedItems() as $item) {
		    			$values[$item->id] = $item->title;
		    		}			
						$form->setWidget('categoryFilters[]' . $filter->id, 'select', array('label' =>'', 'values' => $values, 'value' => ($currentCategoryFilters)));		
			    } elseif ($filter->getType() == 'page') {
			        $values = array(0 => '&laquo; ' . $filter->getTitle(false, true) . ' &raquo;');
		    		foreach ($filter->getRelatedItems() as $item) {
		    			$values[$item->id] = $item->title;
		    		}
						$form->setWidget('pageFilters[]' . $filter->id, 'select', array('label' =>'', 'values' => $values, 'value' => ($currentPageFilters)));
			    }
				}
		}
		
		if ($form->isPushed('clear_filters'))		
		{
			$form->getWidget('titleFilter')->setValue('');
		}
		$module->smarty->assign('filters_form', $form);
	}

	
	return $module->ProcessTemplate('defaultadmin.items.tpl');
}


public static function createForm($module,&$form,&$item,$params=array())
{
  $config = cms_utils::get_config();
  
  {{foreach from=$structure->getTabs() item=tabs key=tab_key}}
	
		{{foreach from=$tabs.fieldsets item=fieldset key=fieldset_key}}
		
			$form->setFieldset('{{$tab_key}}---{{$fieldset_key}}', '{{$fieldset.name}}');
			
			{{*foreach from=$fieldset.fields item=field }}
			$form->getFieldset('{{$tab_key}}---{{$fieldset_key}}')->setWidget('{{$field.name}}');
			{{/foreach*}}
		
		{{/foreach}}
	
	{{/foreach}}
  
  {{foreach from=$extra_fields item=field}}
    {{if $field.frontend != 1 }}  if(!isset($params['frontend'])) {  {{/if}}
    {{if $field.form_type == 'select'}}
      $class = array('chzn-select');
  	  {{if isset($field.foptions.class)}}$class[] = '{{$field.foptions.class}}';{{/if}}
    
  	  $form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'select', array(
  		{{if isset($field.foptions.multiple) || isset($field.foptions.expanded)}}
  		'values' => {{$field.select_options}},
  		{{else}}
  		'values' => array('' => '&laquo; ' . $module->lang('select_one') . ' &raquo;') + {{$field.select_options}},
  		{{/if}} 
  		'label' => '{{$field.label}}', 
  		'get_method' => 'get{{$field.camelcase}}', 
  		'object' => &$item,
  		'class' => $class
  		,'addtext' => ' style="min-width: 350px;"'
  		{{if isset($field.foptions.multiple)}}, 'multiple' => true{{/if}}
  		{{if isset($field.foptions.size)}}, 'size' => {{$field.foptions.size}}{{/if}}
  		{{if isset($field.foptions.expanded)}}, 'expanded' => true{{/if}}

  		,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:{{if isset($field.foptions.default_value)}}'{{$field.foptions.default_value}}'{{else}}null{{/if}}
  	));
    {{elseif $field.form_type == 'checkbox'}}
    $form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'select', array(
      'values' => array('1' => '{{if isset($field.foptions.text)}}{{$field.foptions.text}}{{else}}{{$field.label}}{{/if}}'),
      'label' => '{{$field.label}}',
      'object' => &$item,
      'get_method' => 'get{{$field.camelcase}}', 
      'multiple' => true,
      'expanded' => true
      {{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
      {{if isset($field.foptions.checked)}}, 'default_value' => '1'{{/if}}
    ));
  	{{elseif $field.form_type == 'textarea'}}
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'textarea', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item,
  		'show_wysiwyg' => true
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  		,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:null
  		));
  	{{elseif $field.form_type == 'textarea_plain'}}
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'textarea', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  		,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:null
  		));
  	{{elseif $field.form_type == 'textarea_code'}}
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'codearea', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  		,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:null
  		));
  	{{elseif $field.form_type == 'file'}}
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'file', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item,
  		// 'direct_link' => $item->get{{$field.camelcase}}Url(), // FIXME: Issue in CMSMS 1.11
  		'direct_link' => $item->get{{$field.camelcase}}CleanUrl(),
  		'base_url' => $config['root_url'],
  		'delete_checkbox' => '{{$field.name}}_delete'
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  		,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:null
  	));
  	{{elseif $field.type == 'date'}}
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'date', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item, 
			'european_date' => true, 
  		'set_method' => 'set{{$field.camelcase}}',		
  		'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:array(date('Y'),date('m'),date('d'))
  		{{if isset($field.date_options.start_year)}}, 'start_year' => {{$field.date_options.start_year}}{{/if}}
  		{{if isset($field.date_options.number_years)}}, 'number_years' => {{$field.date_options.number_years}}{{/if}}
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  	));
  	{{elseif $field.type == 'time'}}
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'time', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item,
  		'set_method' => 'set{{$field.camelcase}}',
  		{{if isset($field.foptions.midnight)}}
  		'default_value' => array(0,0,0) {{* TODO: FIX *}}
  		{{else}}		
  		'default_value' => array(date('H'),date('i'),date('s'))
  		{{/if}}
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  	));
		{{elseif $field.form_type == 'datetime'}}
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'datetime', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item,
			'european_date' => true, 
  		'set_method' => 'set{{$field.camelcase}}',
  		{{if isset($field.foptions.midnight) && $field.foptions.midnight == 'true'}}
  		'default_value' => array(date('Y'),date('m'),date('d'),0,0,0) {{* TO FIX *}}
  		{{else}}		
  		'default_value' => array(date('Y'),date('m'),date('d'),date('H'),date('i'),date('s'))
  		{{/if}}
			{{if isset($field.foptions.start_year)}}, 'start_year' => {{$field.foptions.start_year}}{{/if}}
			{{if isset($field.foptions.number_years)}}, 'number_years' => {{$field.foptions.number_years}}{{/if}}
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  	));
  	{{elseif $field.form_type == 'module'}}
  	if (class_exists('{{$field.foptions.module_name}}Object'))
  	{	
  	  $class = array('chzn-select');
  	  {{if isset($field.foptions.class)}}$class[] = '{{$field.foptions.class}}';{{/if}}
  	  
  		$c = new MCFCriteria();
  		$c->add('published', 1);
  		{{if isset($field.foptions.selector)}}
  		$mod_items = {{$field.foptions.module_name}}Object::{{$field.foptions.selector}}($c);
  		{{else}}
  		$mod_items = {{$field.foptions.module_name}}Object::doSelect($c);
  		{{/if}}
  		$list = array();
  	$form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'select', array(
  		{{if isset($field.foptions.multiple) || isset($field.foptions.expanded)}}
  		'values' =>	$mod_items, 
  		{{else}}
  		'values' =>	array('' => '&laquo; ' . $module->lang('select_one') . ' &raquo;') + $mod_items, 
  		{{/if}}
  		'label' => '{{$field.label}}', 
  		'get_method' => 'get{{$field.camelcase}}', 
  		'object' => &$item,
  		'class' => $class
  		,'addtext' => ' style="min-width: 350px;"'
  	{{if isset($field.foptions.multiple)}}, 'multiple' => true{{/if}}  	
  	{{if isset($field.foptions.size)}}, 'size' => {{$field.foptions.size}}{{/if}}
  	{{if isset($field.foptions.expanded)}}, 'expanded' => true{{/if}}
  	{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  	,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:null
  	));
  	}
  	{{elseif $field.form_type == 'page'}}
  	  $class = array('chzn-select');
	    {{if isset($field.foptions.class)}}$class[] = '{{$field.foptions.class}}';{{/if}}
  	  $form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'pages', array(
  		'label' => '{{$field.label}}' 
  		,'object' => &$item
  		,'class' => $class
  		,'addtext' => ' style="min-width: 350px;"'
  		{{if isset($field.foptions.start_page)}}, 'start_page' => '{{$field.foptions.start_page}}'{{/if}}
  		{{if isset($field.foptions.childrenof)}}, 'childrenof' => '{{$field.foptions.childrenof}}'{{/if}}
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}		
  		{{if isset($field.foptions.size)}}, 'size' => {{$field.foptions.size}}{{/if}}
  		{{if isset($field.foptions.multiple)}}, 'multiple' => true{{/if}}
  		{{if isset($field.foptions.expanded)}}, 'expanded' => true{{/if}}
  		,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:null
  		));
  	{{elseif $field.form_type == 'static'}}
  	  $form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'static', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  		{{if isset($field.foptions.prefix)}}, 'prefix' => '{{$field.foptions.prefix}}'{{/if}}
  		{{if isset($field.foptions.sufix)}}, 'sufix' => '{{$field.foptions.sufix}}'{{/if}}
  		,'default_value' => isset($params['{{$field.name}}'])?$params['{{$field.name}}']:null
  		));
  	{{elseif $field.form_type == 'none'}}
  	{{elseif $field.form_type == 'user'}}
  	  $class = array('chzn-select');
	    {{if isset($field.foptions.class)}}$class[] = '{{$field.foptions.class}}';{{/if}}
  	  ${{$field.name}}_list = CMSUser::getUserList();
  	  $form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'select', array(
  		{{if isset($field.foptions.multiple) || isset($field.foptions.expanded)}}
  		'values' => {{$field.select_options}},
  		{{else}}
  		'values' => array('' => '&laquo; ' . $module->lang('select_one') . ' &raquo;') + ${{$field.name}}_list,
  		{{/if}} 
  		'label' => '{{$field.label}}', 
  	//	'get_method' => 'get{{$field.camelcase}}', 
  		'object' => &$item,
  		'class' => $class
  		,'addtext' => ' style="min-width: 350px;"'
  		{{if isset($field.foptions.multiple)}}, 'multiple' => true{{/if}}
  		{{if isset($field.foptions.size)}}, 'size' => {{$field.foptions.size}}{{/if}}
  		{{if isset($field.foptions.expanded)}}, 'expanded' => true{{/if}}
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  	));
  	{{elseif $field.form_type == 'group'}}
  	  $class = array('chzn-select');
	    {{if isset($field.foptions.class)}}$class[] = '{{$field.foptions.class}}';{{/if}}
  	  ${{$field.name}}_list = CMSGroup::getGroupList();
  	  $form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', 'select', array(
  		{{if isset($field.foptions.multiple) || isset($field.foptions.expanded)}}
  		'values' => ${{$field.name}}_list,
  		{{else}}
  		'values' => array('' => '&laquo; ' . $module->lang('select_one') . ' &raquo;') + ${{$field.name}}_list,
  		{{/if}} 
  		'label' => '{{$field.label}}', 
  	//	'get_method' => 'get{{$field.camelcase}}', 
  		'object' => &$item,
  		'class' => $class
  		,'addtext' => ' style="min-width: 350px;"'
  		{{if isset($field.foptions.multiple)}}, 'multiple' => true{{/if}}
  		{{if isset($field.foptions.size)}}, 'size' => {{$field.foptions.size}}{{/if}}
  		{{if isset($field.foptions.expanded)}}, 'expanded' => true{{/if}}
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  	));
  	{{else}}
  	  $form->getFieldset('{{$field.place.tab_key}}---{{$field.place.fieldset_key}}')->setWidget('{{$field.name}}', '{{$field.form_type}}', array(
  		'label' => '{{$field.label}}', 
  		'object' => &$item, 
  		'size' => 50
  		{{if isset($field.foptions.tips)}}, 'tips' => '{{$field.foptions.tips}}'{{/if}}
  		));
  	{{/if}}
    {{if $field.frontend != 1 }}}{{/if}}
	{{/foreach}}
}


}
