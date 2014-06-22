<?php
/* 
   FormBuilder. Copyright (c) 2005-2008 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbUniqueIntegerField extends fbFieldBase 
{

	function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'UniqueIntegerField';
		$this->DisplayInForm = true;
		$this->NonRequirableField = true;
		$this->ValidationTypes = array();
		$this->sortable = false;
	}


	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		if ($this->Value !== false) {

			$ret = $mod->CreateInputHidden($id, 'fbrp__'.$this->Id, $this->Value);
			if ($this->GetOption('show_to_user','0') == '1') {

				$ret .= $this->Value;
			}
		
		} else if ($this->GetOption('use_random_generator','0') == '1') {

			$times = $this->GetOption('numbers_to_generate','5') ? $this->GetOption('numbers_to_generate','5') : 5;
			$number = $this->generate_numbers(0,9,$times);
			$ret = $mod->CreateInputHidden($id, 'fbrp__'.$this->Id,$number);
			if ($this->GetOption('show_to_user','0') == '1') {			
				
				$ret .= $number;		
			}
		
		} else {

			$db = $mod->dbHandle;
			$seq = $db->GenID(cms_db_prefix(). 'module_fb_uniquefield_seq');
			$ret = $mod->CreateInputHidden($id, 'fbrp__'.$this->Id,$seq);
			if ($this->GetOption('show_to_user','0') == '1') {
			
				$ret .= $seq;
			}
		}

		return $ret;
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;

		$main = array(
			array($mod->Lang('title_show_to_user'), $mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_to_user','0').
						$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_show_to_user', '1',$this->GetOption('show_to_user','0'))),				
			array($mod->Lang('title_use_random_generator'), $mod->CreateInputHidden($formDescriptor,'fbrp_opt_use_random_generator','0').
						$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_use_random_generator', '1',$this->GetOption('use_random_generator','0'))),	
			array($mod->Lang('title_numbers_to_generate'),$mod->CreateInputText($formDescriptor,'fbrp_opt_numbers_to_generate',$this->GetOption('numbers_to_generate','5'),25,25))						
		);
				
		$adv = array();
		
		return array('main'=>$main,'adv'=>$adv);
	}
	
	private function generate_numbers($min, $max, $times)
	{
		$output = '';
		$array = range($min, $max);
		srand ((double)microtime()*10000);
		for($x = 0; $x < $times; $x++) {
		
			$i = rand(1, count($array))-1;
			$output .= $array[$i];
		}
		
		return $output;
	}	

}

?>
