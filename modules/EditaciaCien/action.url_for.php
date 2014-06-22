<?php
if(!cmsms()) exit;

if(isset($params['maction']))
{
	unset($params['action']);
	$action = $params['maction'];
	unset($params['maction']);
	if(empty($returnid)) $returnid = $this->getPreference('default_page', cmsms()->GetContentOperations()->GetDefaultPageID());
	$detailpage = $returnid;
	if (isset($params['detailpage'])) {
	    $manager = cmsms()->GetHierarchyManager();
	    $node = $manager->sureGetNodeByAlias($params['detailpage']);
	    if ($node) {
	        $content = $node->GetContent();
	        if ($content)
	        {
	            $detailpage = $content->Id();
	        }
	    } else {
	        $node = $manager->sureGetNodeById($params['detailpage']);
	        if ($node) {
	            $detailpage = $params['detailpage'];
	        }
	    }
	    $params['origid'] = $returnid;
	}
	unset($params['detailpage']);	
	unset($params['assign']);	
	unset($params['origid']);	
	
	if(isset($params['clean_empty_values']))
	{
		foreach($params as $key => $value)
		{
			if (empty($value))
			{
				unset($params[$key]);
			}
		}
		unset($params['clean_empty_values']);
	}
	
	$withslash = (isset($params['withslash']))?true:false;	
	unset($params['withslash']);
	echo $this->CreateLink($id,$action,$detailpage,'',$params,'',true,false,'',false,'',$withslash);
}
return;