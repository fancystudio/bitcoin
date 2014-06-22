<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbFieldsetStart extends fbFieldBase {

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'FieldsetStart';
    $this->DisplayInForm = true;
    $this->DisplayInSubmission = false;
    $this->NonRequirableField = true;
    $this->ValidationTypes = array();    
    $this->HasLabel = 0;
    $this->NeedsDiv = 0;
    $this->sortable = false;
  }

  function GetFieldInput($id, &$params, $returnid)
  {
    $js = $this->GetOption('javascript','');
    $str = '<fieldset';
    $class = $this->GetOption('css_class');
    $legend = $this->GetOption('legend');
	$str .= $this->GetCSSIdTag();
    if( $class != '' )
      {
	$str .= " class=\"$class\"";
      }
    if ($js != '')
		{
		$str .= ' '.$js;
		}
    $str .= '>';
    if( $legend != '' )
      {
	$str .= '<legend>'.$legend.'</legend>';
      }
    return $str;
  }

  function StatusInfo()
  {
    return '';
  }

  function GetHumanReadableValue($as_string=true)
  {
    // there's nothing human readable about a fieldset.
    $ret = '[Begin Fieldset: '.$this->Value.']';
	if ($as_string)
		{
		return $ret;
		}
	else
		{
		return array($ret);
		}
  }
	
  function PrePopulateAdminForm($formDescriptor)
  {
    $mod = $this->form_ptr->module_ptr;
    $main = array(
		  array($mod->Lang('title_legend'),
            		$mod->CreateInputText($formDescriptor,'fbrp_opt_legend',
					      $this->GetOption('legend',''), 50)));
    $adv = array();
    return array('main'=>$main,'adv'=>$adv);
  }

}

?>
