<?php

if (!cmsms()) exit;

$c = new MCFCriteria();
$c->add('published', '1');

{{$module->getModuleName()}}Object::buildFrontendFilters($c, $params);
{{$module->getModuleName()}}Object::globalFrontendFilters($c);

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

{{foreach from=$filters item=filter}}
if (isset($params['{{$filter.name}}']) && !empty($params['{{$filter.name}}'])) {
	{{if in_array($filter.type, array('less', 'less_equal', 'greater', 'greater_equal'))}}
	$c->add('CAST({{$filter.field}} AS UNSIGNED)', $params['{{$filter.name}}'], MCFCriteria::{{$filter.criteria}});
	{{else}}
	$c->add('{{$filter.field}}', $params['{{$filter.name}}'], MCFCriteria::{{$filter.criteria}});
	{{/if}}
}
{{/foreach}}

if (isset($params['limit'])) {
	$c->setLimit($params['limit']);
}

echo {{$module->getModuleName()}}Object::doCount($c);