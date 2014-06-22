<?php

// DEPRECATED

$urlaction = isset($params['urlaction']) ? $params['urlaction'] : 'default';
unset($params['urlaction']);

$detailpage = $returnid;
if (isset($params['detailpage'])) {
    $manager = cmsms()->GetHierarchyManager();
    $node =& $manager->sureGetNodeByAlias($params['detailpage']);
    if (isset($node)) {
        $content =& $node->GetContent();
        if (isset($content))
        {
            $detailpage = $content->Id();
        }
    } else {
        $node =& $manager->sureGetNodeById($params['detailpage']);
        if (isset($node)) {
            $detailpage = $params['detailpage'];
        }
    }

    $params['origid'] = $returnid;
}


echo $this->createLink($id, $urlaction, $detailpage, $contents='', $params, '', true);

?>