<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
   This project's homepage is: http://www.cmsmadesimple.org
   
   This Field written by Tapio "Stikki" L�ytty <tapsa@blackmilk.fi>
*/

class fbYearPulldownField extends fbFieldBase {

	function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
        $mod = $form_ptr->module_ptr;
		$this->Type = 'YearPullDownField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array();

	}

	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');
		$sorted =array();

		if ($this->GetOption('year_start','') != '') {
			$count_from = $this->GetOption('year_start','');
		} else {
			$count_from = 1900;
		}
		
		for ($i=date("Y"); $i>=$count_from; $i--) {
			$sorted[$i]=$i;
		}
			
		if( $this->GetOption('sort') == '1' ) {
			ksort($sorted);
		}
	
		if ($this->GetOption('select_one','') != '') {
			$sorted = array(' '.$this->GetOption('select_one','')=>'') + $sorted;
		} else {
			$sorted = array(' '.$mod->Lang('select_one')=>'') + $sorted;
		}
		return $mod->CreateInputDropdown($id, 'fbrp__'.$this->Id, $sorted, -1, $this->Value,$js.$this->GetCSSIdTag());
	}
	
	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
	
		$main = array();
		$adv = array();
		$main[] = array($mod->Lang('title_select_one_message'),
						$mod->CreateInputText($formDescriptor, 'fbrp_opt_select_one',
											  $this->GetOption('select_one',$mod->Lang('select_one')),25,128));
											  
		$main[] = array($mod->Lang('title_year_end_message'),
						$mod->CreateInputText($formDescriptor, 'fbrp_opt_year_start',
											  $this->GetOption('year_start',1900),25,128));
											  
		$main[] = array($mod->Lang('sort_options'),
						$mod->CreateInputDropdown($formDescriptor,'fbrp_opt_sort',
												  array('Yes'=>1,'No'=>0),-1,
												  $this->GetOption('sort',0)));
												  
		return array('main'=>$main,'adv'=>$adv);
	}


	function GetHumanReadableValue($as_string=true)
	{
		$mod = $this->form_ptr->module_ptr;
		if ($this->HasValue())
			{
			$ret = $this->Value;
			}
		else
			{
			$ret = $this->form_ptr->GetAttr('unspecified',$mod->Lang('unspecified'));
			}
		if ($as_string)
			{
			return $ret;
			}
		else
			{
			return array($ret);
			}
	}

}
?>
