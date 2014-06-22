<?php

if (!cmsms()) exit;

if (!($this->CheckAccess() || $this->CheckAccess('Modify Templates'))) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$tabs = array(
//	'items' => false,
//	'templates' => false,
//	'options' => false,
//	'help' => false
);

if ($this->CheckAccess()) {
 $tabs['items'] = false; 
}

if ($this->CheckAccess('Modify Templates')) { 
  $tabs['templates'] = false;
} 
if ($this->CheckAccess('Admin {{$module->getModuleName()}}')) { 
  $tabs['options'] = false;
} 
$tabs['help'] = false; 

if (isset($params['active_tab'])) {
	$tabs[$params['active_tab']] = true;
}

echo $this->StartTabHeaders();
foreach ($tabs as $tab => $selected) {
	echo $this->SetTabHeader($tab, $this->Lang('tab_' . $tab), $selected);
}
echo $this->EndTabHeaders();

echo $this->StartTabContent();
foreach ($tabs as $tab => $selected) {
	echo $this->StartTab($tab);
	include 'function.defaultadmin.'.$tab.'.php';
	echo $this->EndTab();
}
echo $this->EndTabContent();

echo '<script type="text/javascript">$(".actionbutton").button();</script>';
?>
