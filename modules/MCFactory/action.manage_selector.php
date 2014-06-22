<?php

if (!cmsms()) exit;

if (!$this->CheckAccess()) {
	return $this->DisplayErrorPage();
}

if(isset($params['module_id']))
{
  
}