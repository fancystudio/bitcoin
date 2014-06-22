<?php
if (!cmsms()) exit;

$form = new CMSForm($this->GetName(), $id,'default',(isset($params['returnid']) ? $params['returnid'] : $returnid));
$form->setButtons(array('submit'));
$form->setLabel('submit', isset($params['search_label'])?$params['search_label']:'Search');

if(isset($params['filter_title']))  $form->setWidget('filter_title', 'text', array('size' => 20, 'default_value' => isset($params['filter_title'])?$params['filter_title']:''));

if(isset($params['filter_all']))  $form->setWidget('filter_all', 'text', array('size' => 20, 'default_value' => isset($params['filter_all'])?$params['filter_title']:''));

if (isset($params['filters']))
{
	$filters = explode('|', $params['filters']);
	foreach ($filters as $filter)
	{
		$opt = explode(';', $filter);
		$options = array();
		foreach($opt as $op)
		{
			$o = explode('=', $op);
			$options[trim($o[0])] = trim($o[1]);
		}
		if (isset($options['name']))
		{
			$name = $options['name'];
			unset($options['name']);
			if(isset($params['current_values'][$name])) $options['value'] = $params['current_values'][$name];
			{{$module->getModuleName()}}Object::getFEFilter($form, $name, $options);
		}
	}
}

$mxfilters = array();
$modulextender = cms_utils::get_module('ModuleXtender');
if(is_object($modulextender))
{
  if ($modulextender->isXtendedModule('{{$module->getModuleName()}}')) {
  	foreach (MX_Relation::getFilters($this->getName()) as $filter) {
  	    if ($filter->getType() == 'category') {
  			if(isset($params['title_filter_category_'.$filter->getId()]))
  			{
  				$values = array($params['title_filter_category_'.$filter->getId()] => 0);
  			}
  			else
  			{				
  		     $values = array($filter->getTitle(false, true) => 0);
  			}
      		foreach ($filter->getRelatedItems() as $item) {
      			$values[$item->title] = $item->id;
      		}


  				//$mxfilters[$filter->getId()] = $this->CreateInputDropdown($id, 'mxfilters_options[' . $filter->id . ']', $values, -1, isset($params['mxfilters_options'][$filter->id]) ? $params['mxfilters_options'][$filter->id] : '');
  				$form->setWidget('mxfilters_options[' . $filter->id . ']', 'select', array(
  					'values' => $values
  					,'value' => isset($params['mxfilters_options'][$filter->id]) ? $params['mxfilters_options'][$filter->id] : ''
  				));
  	    } 
  			elseif ($filter->getType() == 'page') 
  			{
  				if(isset($params['title_filter_page_'.$filter->getId()]))
  				{
  					$values = array($params['title_filter_page_'.$filter->getId()] => 0);
  				}
  				else
  				{				
  		      $values = array($filter->getTitle(false, true) => 0);
  				}
      		foreach ($filter->getRelatedItems() as $item) {
      			$values[$item->title] = $item->id;
      		}

  				//$mxfilters[$filter->getId()] = $this->CreateInputDropdown($id, 'mxfilters_pages[' . $filter->id . ']', $values, -1, isset($params['mxfilters_pages'][$filter->id]) ? $params['mxfilters_pages'][$filter->id] : '');
  				$form->setWidget('mxfilters_pages[' . $filter->id . ']', 'select', array(
  					'values' => $values
  					,'value' => isset($params['mxfilters_pages'][$filter->id]) ? $params['mxfilters_pages'][$filter->id] : ''
  				));
  	    }
  	}
  }
  
}


/*

$this->smarty->assign('id', $id);
$this->smarty->assign('form_start', $this->CreateFormStart($id, 'default', (isset($params['returnid']) ? $params['returnid'] : $returnid), 'post'));
$this->smarty->assign('parameters', $params);
$this->smarty->assign('mxfilters', $mxfilters);
$this->smarty->assign('titlefilter', $this->CreateInputText($id, 'filter_title', isset($params['filter_title']) ? html_entity_decode($params['filter_title']) : '', 20));
$this->smarty->assign('filter_all', $this->CreateInputText($id, 'filter_all', isset($params['filter_all']) ? html_entity_decode($params['filter_all']) : '', 20));

/**/




if(isset($params['view_template']))
{
	$form->setWidget('template', 'hidden', array('value' => $params['view_template']));
}

$newparams = $params;
unset($newparams['module']);
unset($newparams['action']);
unset($newparams['page']);
unset($newparams['returnid']);
unset($newparams['view_template']);
unset($newparams['filters']);
unset($newparams['current_values']);
foreach($newparams as $key => $value)
{
	$form->setWidget($key, 'hidden', array('value' => $value));
}

$this->smarty->assign('form', $form);
echo $this->ProcessTemplateFor('search', $params);
return;

?>
