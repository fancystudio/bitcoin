<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Manage {{$module->getModuleName()}}')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$datas['{{$module->getModuleFriendlyName()}}'] = {{$module->getModuleName()}}::ExportDatas();

{{foreach from=$child_modules item=child_module}}
$datas['{{$child_module->getModuleFriendlyName()}}'] = {{$child_module->getModuleName()}}::ExportDatas();
{{/foreach}}

// By default, and if the module CMS Excel exists, we export to excel.

if (MCFTools::IsModuleActive('CMSExcel'))
{
	$params = array(
		'creator' => 'M&C Factory',
		'title' => '{{$module->getModuleFriendlyName()}} export',
		'subject' => '{{$module->getModuleFriendlyName()}} export',
		);
	
	$stack = cms_utils::get_module('CMSExcel')->buildExcel($datas,$params);
	
	$link = cms_utils::get_module('CMSExcel')->getExcelLink($stack,array('filename' => '{{$module->getModuleName()}}_export_'.date('Y-m-d_H-i-s').'.xls'));
	
	echo '<h3>'.$this->lang('export').'</h3><p><a href="'.$link.'" rel="external" >'.$this->lang('download').'</a></p>';
}
else
{
	?>
	<h3><?php echo $this->lang('serialized_datas');?></h3>
	<textarea><?php echo serialize($datas); ?></textarea> 
	<em>(Try to install the CMSExcel module to have a better export support)</em>
	<p><a href="<?php echo $this->CreateLink($id,'export_dat',$detailpage,'',array(),'',true,false,'',false,''); ?>&showtemplate=false" target="_new">Download as file</a></p>
	<p><a href="<?php echo $this->CreateLink($id,'export_db',$detailpage,'',array(),'',true,false,'',false,''); ?>&showtemplate=false" target="_new">Download full entries as objects</a></p>
	<p><a href="<?php echo $this->CreateLink($id,'import_db',$detailpage,'',array(),'',true,false,'',false,''); ?>">Import entries from .dat file</a></p>
	<?php
}