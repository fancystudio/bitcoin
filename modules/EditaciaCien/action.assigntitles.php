<?php

if (!cmsms()) exit;

$this->Audit($item->getId(), $this->GetFriendlyName(), '[DEPRECATED] - The action assigntitles is deprecated and should not be used');
 
$this->smarty->assign('titles', EditaciaCienObject::getTitles());

?>
