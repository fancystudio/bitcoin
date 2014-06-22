<?php

if (!cmsms()) exit;

$c = new MCFCriteria();
$c->add('published', '1');

Edit„CiaCienObject::buildFrontendFilters($c, $params);
Edit„CiaCienObject::globalFrontendFilters($c);

if (isset($params['currentpage'])) {
  if(class_exists('MX_RelationLink')) {
    $c->add('id', MX_RelationLink::getRelatedItemsIds('Edit„CiaCien', cmsms()->get_variable('content_id'), 'pages'), MCFCriteria::IN);
  }
}
if (isset($params['pages'])) {
	$glue = isset($params['all_pages']) ? 'AND' : 'OR';
  if(class_exists('MX_RelationLink')) {
    $c->add('id', MX_RelationLink::getRelatedItemsIds('Edit„CiaCien', explode(',', $params['pages']), 'pages', $glue), MCFCriteria::IN);
  }
}
if (isset($params['options'])) {
	$glue = isset($params['all_options']) ? 'AND' : 'OR';
  if(class_exists('MX_RelationLink')) {
    $c->add('id', MX_RelationLink::getRelatedItemsIds('Edit„CiaCien', explode(',', $params['options']), 'options', $glue), MCFCriteria::IN);
  }
}


if (isset($params['limit'])) {
	$c->setLimit($params['limit']);
}

echo Edit„CiaCienObject::doCount($c);