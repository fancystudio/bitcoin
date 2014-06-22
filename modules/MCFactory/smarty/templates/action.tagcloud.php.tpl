<?php
if (!cmsms()) exit;

$c = new MCFCriteria();
$c->add('published', '1');

{{$module->getModuleName()}}Object::buildFrontendFilters($c, $params);
{{$module->getModuleName()}}Object::globalFrontendFilters($c);
$items = {{$module->getModuleName()}}Object::doSelect($c);

$tags = array();
foreach ($items as $item)
{
	if (method_exists($item, 'getTags'))
	{	
		$tagline = $item->getTags(isset($params['cloudtype'])?$params['cloudtype']:null);
		if(!empty($tagline))
    {
			$elements = explode(',', $tagline);

			foreach ($elements as $element)
			{
				if (isset($tags[trim($element)]))
				{
					$tags[trim($element)]++;
				}
				else
				{
					$tags[trim($element)] = 1;
				}
			}
		}
	}	
}
arsort($tags);

if(isset($params['limit']))
{
	if ($params['limit'] > 0)	$tags = array_slice($tags, 0, $params['limit'], true);
}
else
{	
	$tags = array_slice($tags, 0, 15, true);
}

// Now calculate percent

$max = max($tags);

$ntags = array();

foreach($tags as $tag => $popularity)
{
	$ntags[] = array('class' => floor($popularity/$max*10), 'tag' => $tag, 'popularity' => $popularity);
}

if (!isset($params['noshuffle'])) shuffle($ntags);


$this->smarty->assign('tags', $ntags);

echo $this->ProcessTemplateFor('tagcloud', $params);
return;
{{*
// 
// if (isset($params['template']) && $this->GetTemplate($params['template'])) {
// 	echo $this->ProcessTemplateFromDatabase($params['template']);
// } else {
// 	echo $this->ProcessTemplateFromDatabase('display_list');
// }
*}}