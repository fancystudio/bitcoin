<?php
if (!cmsms()) exit;

$c = new MCFCriteria();
$c->add('published', '1');

  if (isset($params['currentpage'])) {
    if(class_exists('MX_RelationLink')) {
      $c->add('id', MX_RelationLink::getRelatedItemsIds('{{$module->getModuleName()}}', cmsms()->get_variable('content_id'), 'pages'), MCFCriteria::IN);
    }
  }
  if (isset($params['pages'])) {
  	$glue = isset($params['all_pages']) ? 'AND' : 'OR';
    if(class_exists('MX_RelationLink')) {
      $c->add('id', MX_RelationLink::getRelatedItemsIds('{{$module->getModuleName()}}', explode(',', $params['pages']), 'pages', $glue), MCFCriteria::IN);
    }
  }
  if (isset($params['options'])) {
  	$glue = isset($params['all_options']) ? 'AND' : 'OR';
    if(class_exists('MX_RelationLink')) {
      $c->add('id', MX_RelationLink::getRelatedItemsIds('{{$module->getModuleName()}}', explode(',', $params['options']), 'options', $glue), MCFCriteria::IN);
    }
  }
  if (isset($params['mxfilters_options']) && is_array($params['mxfilters_options'])) {
  	$options = array();
  	foreach ($params['mxfilters_options'] as $option) {
  		if ($option) {
  			$options[] = $option;
  		}
  	}
  	if (count($options)) {
      if(class_exists('MX_RelationLink')) {
        $c->add('id', MX_RelationLink::getRelatedItemsIds('{{$module->getModuleName()}}', $options, 'options', 'AND'), MCFCriteria::IN);
      }
  	}
  }



{{foreach from=$filters item=filter}}
if (isset($params['{{$filter.name}}'])) {
	{{if in_array($filter.type, array('less', 'less_equal', 'greater', 'greater_equal'))}}
	$c->add('CAST({{$filter.field}} AS UNSIGNED)', $params['{{$filter.name}}'], MCFCriteria::{{$filter.criteria}});
	{{elseif  in_array($filter.type, array('like_wild'))}}
	$c->add('%{{$filter.field}}%', $params['{{$filter.name}}'], MCFCriteria::{{$filter.criteria}});
	{{else}}
	$c->add('{{$filter.field}}', $params['{{$filter.name}}'], MCFCriteria::{{$filter.criteria}});
	{{/if}}
}
{{/foreach}}

if (isset($params['limit'])) {
	$c->setLimit($params['limit']);
}
else
{
	$c->setLimit(25);
}

$c->addDescendingOrderByColumn('updated_at');
$c->addDescendingOrderByColumn('id');

{{$module->getModuleName()}}Object::globalFrontendFilters($c);

$items = {{$module->getModuleName()}}Object::doSelect($c);
$this->smarty->assign_by_ref('items', $items);
$config = cms_utils::get_config();
$this->smarty->assign_by_ref('root_url', $config['root_url']);

if( preg_match( '/Mozilla/', $_SERVER["HTTP_USER_AGENT"] ) )
{
  cmsms()->set_variable('content-type', 'text/xml');
}
else 
{
  cmsms()->set_variable('content-type', 'application/rss+xml');
}

echo $this->ProcessTemplateFor('rss', $params);