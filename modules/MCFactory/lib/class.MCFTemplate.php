<?php

class MCFTemplate extends Smarty {

	protected $module;
	protected $source;
	protected $destination;
	protected $cmsConfig;

	public function __construct($module, $source, $destination) {
		parent::__construct();
		$this->module = $module;
		$this->source = $source;
		$this->destination = $destination;
		$this->cmsConfig = cms_utils::get_config();
		$this->template_dir = $this->cmsConfig['root_path'] . '/modules/MCFactory/smarty/templates';
//		$this->compile_dir = $this->cmsConfig['root_path'] . '/modules/MCFactory/smarty/templates_c'; // TODO: Change that to the global one
		$this->compile_dir = $this->cmsConfig['previews_path']; // TODO: Change that to the global one
		$this->config_dir = $this->cmsConfig['root_path'] . '/modules/MCFactory/smarty/config';
		$this->force_compile = true;
		$this->left_delimiter = '{{';
		$this->right_delimiter = '}}';
	}

	public function save() {
		$contents = $this->fetch($this->source);
		$result = @file_put_contents($this->cmsConfig['root_path'] . '/modules/' . $this->module . '/' . $this->destination, $contents);
		
		// SMARTY 2/3 
		if(method_exists($this, 'clear_compiled_tpl'))
		{
		  $this->clear_compiled_tpl();		  
		}
		else
		{
		  $this->clearCompiledTemplate();
		}
		return $result;
	}

}

?>