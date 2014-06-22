<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbHiddenField extends fbFieldBase 
{

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = &$form_ptr->module_ptr;
    $this->Type = 'HiddenField';
    $this->DisplayInForm = true;
    $this->NonRequirableField = true;
    $this->ValidationTypes = array();
    $this->HasLabel = 0;
    $this->NeedsDiv = 0;
    $this->sortable = false;
  }


  function GetFieldInput($id, &$params, $returnid)
  {
    $mod = &$this->form_ptr->module_ptr;

   if ($this->Value !== false)
      {
	  $v = $this->Value;
  	  }
	else
		{
		$v = $this->GetOption('value','');
		}

    if ($this->GetOption('smarty_eval','0') == '1')
      {
      $v =  $mod->ProcessTemplateFromData($v);
      }
		
		if ($this->GetOption('fbr_edit','0') == '1' && $params['in_admin'] == 1)
			{
			$type = "text";
			}
		else
			{
			$type = "hidden";
			}
		
    return '<input type="'.$type.'" name="'.$id.'fbrp__'.$this->Id.'" value="'.$v.'"'.$this->GetCSSIdTag().' />';
  }

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = &$this->form_ptr->module_ptr;
		$main = array(
				array($mod->Lang('title_value'),
            		$mod->CreateInputText($formDescriptor, 'fbrp_opt_value',$this->GetOption('value',''),25,1024))
		);
		$adv = array(
				array($mod->Lang('title_smarty_eval'),
				$mod->CreateInputHidden($formDescriptor, 'fbrp_opt_smarty_eval','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_smarty_eval',
            		'1',$this->GetOption('smarty_eval','0'))),
				array($mod->Lang('title_fbr_edit'),
				$mod->CreateInputHidden($formDescriptor, 'fbrp_opt_fbr_edit','0').
				$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_fbr_edit',
					'1', $this->GetOption('fbr_edit','0')))
		);
		return array('main'=>$main,'adv'=>$adv);
	}


}

?>
