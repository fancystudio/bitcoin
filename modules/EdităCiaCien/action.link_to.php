<?php
if(!cmsms()) exit;

if(isset($params['maction']))
{
	unset($params['action']);
	$action = $params['maction'];
	unset($params['maction']);
	
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
	$title = isset($params['title'])?$params['title']:'link';
	unset($params['title']);
	unset($params['origid']);


	$withslash = (isset($params['withslash']))?true:false;
	
	unset($params['withslash']);

	echo $this->CreateLink($id,$action,$detailpage,$title,$params,'',false,false,'',false,'',$withslash);
}
return;
