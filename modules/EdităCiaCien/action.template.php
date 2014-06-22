<?php
if (!cmsms()) exit;
  
  $this->smarty->assign('mx_params', $params);
  
  if(isset($params['item']))
  {
	$this->smarty->assign('item', $params['item']);
  }

  if(isset($params['items']))
  {
	$this->smarty->assign('items', $params['items']);
  }
	
  $paramsobj = new stdClass();
  $paramsobj->params = $params;
  $this->smarty->assign('mcfactory', $paramsobj);

  if (isset($params['template']) && $this->GetTemplate($params['template']))
  {
    echo $this->ProcessTemplateFromDatabase($params['template']);
  }
  else
  {
  	echo '<p>' . $this->lang('unknown_template') . '</p>';
  }
  
?>