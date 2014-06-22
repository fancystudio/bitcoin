<?php

if (!cmsms()) exit;

{{if $module->getAPIEnabled() == 1}}
  
  if(isset($params['command']))
  {
    if('list' == $params['command'])
    {
      {{foreach from=$filters item=filter}}
      if (isset($_REQUEST['{{$filter.name}}']) && ($_REQUEST['{{$filter.name}}'] != '') && !isset($params['{{$filter.name}}'])) {
        $params['{{$filter.name}}'] = $_REQUEST['{{$filter.name}}'];
      }
      {{/foreach}}
      
      
      $c = new MCFCriteria();
      $c->add('published', '1');
      {{$module->getModuleName()}}Object::buildFrontendFilters($c, $params);
      {{$module->getModuleName()}}Object::globalFrontendFilters($c, $params);
      $items = {{$module->getModuleName()}}Object::doSelect($c);
      
      if(is_array($items))
      {
        $json = array();
        foreach($items as $key => $item)
        {
          $json[$key] = $item->toArray();
        }
        
        $callback = $_REQUEST['callback'];
        if ($callback) {
            header('Content-type: text/javascript');
          echo $callback . '(' . utf8_encode(json_encode($json)) . ');';
        } else {        
            header('Content-type: application/x-json');
            echo utf8_encode(json_encode($json));
        }
      }
    }
  }
  
  
{{else}}
  echo 'API is not enabled for this module';
{{/if}}