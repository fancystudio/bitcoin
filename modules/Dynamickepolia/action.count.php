<?php

if (!cmsms()) exit;

$c = new MCFCriteria();
$c->add('published', '1');

DynamickepoliaObject::buildFrontendFilters($c, $params);
DynamickepoliaObject::globalFrontendFilters($c);

if (isset($params['currentpage'])) {
  if(class_exists('MX_RelationLink')) {
    $c->add('id', MX_RelationLink::getRelatedItemsIds('Dynamickepolia', cmsms()->get_variable('content_id'), 'pages'), MCFCriteria::IN);
  }
}
if (isset($params['pages'])) {
	$glue = isset($params['all_pages']) ? 'AND' : 'OR';
  if(class_exists('MX_RelationLink')) {
    $c->add('id', MX_RelationLink::getRelatedItemsIds('Dynamickepolia', explode(',', $params['pages']), 'pages', $glue), MCFCriteria::IN);
  }
}
if (isset($params['options'])) {
	$glue = isset($params['all_options']) ? 'AND' : 'OR';
  if(class_exists('MX_RelationLink')) {
    $c->add('id', MX_RelationLink::getRelatedItemsIds('Dynamickepolia', explode(',', $params['options']), 'options', $glue), MCFCriteria::IN);
  }
}


if (isset($params['limit'])) {
	$c->setLimit($params['limit']);
}

echo DynamickepoliaObject::doCount($c);