<?php

/*
	// CLASS TO HANDLE THE VIEWS
*/

class EditãCiaCienViews {

public static function adminItems($module,$id,$returnid,$view,$items,$parent_id=null)
{
	if (!cmsms()) exit;

	// Preview code
	if (!isset($_SESSION['EditãCiaCien']['preview_key']))
	{
		$_SESSION['EditãCiaCien']['preview_key'] = base64_encode(time());
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
			'previewlink' => $module->CreateLink($id, 'detail', $module->getPreference('default_page'), cmsms()->get_variable('admintheme')->DisplayImage('icons/system/view.gif', $module->lang('preview_s',$item->getTitle()), '', '', 'systemicon'), array('preview_key' => $_SESSION['EditãCiaCien']['preview_key'], 'item_id' => $item->getId()), '', false,false,' target="_new"', true)

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
		EditãCiaCienObject::buildFiltersWidgets($form, $currentModuleFilters);		

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
  
  	
				
			$form->setFieldset('default---default', 'Main');
			
			
		
			
	  
        if(!isset($params['frontend'])) {        	  $form->getFieldset('default---default')->setWidget('btc_k_dispozci_na_predaj', 'text', array(
  		'label' => 'BTC k dispozÃ­ciÃ­ na predaj', 
  		'object' => &$item, 
  		'size' => 50
  		  		));
  	    }	      if(!isset($params['frontend'])) {        	  $form->getFieldset('default---default')->setWidget('EUR_k_dispozci_na_nkup', 'text', array(
  		'label' => 'â‚¬ k dispozÃ­ciÃ­ na nÃ¡kup', 
  		'object' => &$item, 
  		'size' => 50
  		  		));
  	    }	      if(!isset($params['frontend'])) {        	  $form->getFieldset('default---default')->setWidget('mara_v_Percent_na_predaj', 'text', array(
  		'label' => 'marÅ¾a v % na predaj', 
  		'object' => &$item, 
  		'size' => 50
  		  		));
  	    }	      if(!isset($params['frontend'])) {        	  $form->getFieldset('default---default')->setWidget('mara_v_Percent_na_nkup', 'text', array(
  		'label' => 'marÅ¾a v % na nÃ¡kup', 
  		'object' => &$item, 
  		'size' => 50
  		  		));
  	    }	}


}
