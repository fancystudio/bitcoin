<?php
if (!cmsms()) exit;

if (!$this->CheckAccess('Manage EdităCiaCien')) {
	return $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$datas = array();

// Main entries
$datas['Editacia cien'] = EdităCiaCien::ExportDatas();


// By default, and if the module CMS Excel exists, we export to excel.

if (MCFTools::IsModuleActive('CMSExcel'))
{
	$params = array(
		'creator' => 'M&C Factory',
		'title' => 'Editacia cien export',
		'subject' => 'Editacia cien export',
		);
	
	$stack = cms_utils::get_module('CMSExcel')->buildExcel($datas,$params);
	
	$link = cms_utils::get_module('CMSExcel')->getExcelLink($stack,array('filename' => 'EdităCiaCien_export_'.date('Y-m-d_H-i-s').'.xls'));
	
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