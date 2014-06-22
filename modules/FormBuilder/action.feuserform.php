<?php

if (!isset($gCms)) exit;

$feu = &$this->GetModuleInstance('FrontEndUsers');
if ($feu == false || $feu->LoggedIn() == false)
	{
	return;
	}
$this->DoAction('default',$id,$params, $returnid);
?>
