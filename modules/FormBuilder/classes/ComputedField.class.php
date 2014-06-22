<?php
/*
   FormBuilder. Copyright (c) 2005-2007 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2007 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbComputedField extends fbFieldBase 
{

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'ComputedField';
    $this->DisplayInForm = false;
    $this->DisplayInSubmission = true;
    $this->NonRequirableField = true;
    $this->ValidationTypes = array();
    $this->HasLabel = 1;
    $this->NeedsDiv = 0;
    $this->sortable = false;
    $this->IsComputedOnSubmission = true;
  }

    function ComputeOrder()
    {
        return $this->GetOption('order','1');    
    }

    function Compute()
    {
		$mod = $this->form_ptr->module_ptr;
        $others = $this->form_ptr->GetFields();

        $mapId = array();
		$eval_string = false;

        for($i=0;$i<count($others);$i++)
            {
	        $mapId[$others[$i]->GetId()] = $i;
            }

        $flds = array();
        $procstr = $this->GetOption('value','');
        preg_match_all('/\$fld_(\d+)/', $procstr, $flds);
        
        if ($this->GetOption('string_or_number_eval','numeric') == 'numeric')
            {
            foreach ($flds[1] as $tF)
                {
                if (isset($mapId[$tF]))
                    {
                    $ref = $mapId[$tF];
                    if (is_numeric($others[$ref]->GetHumanReadableValue()))
                        {
                        $procstr = str_replace('$fld_'.$tF,
                            $others[$ref]->GetHumanReadableValue(),$procstr);
                        }
                    else
                        {
                        $procstr = str_replace('$fld_'.$tF,
                            '0',$procstr);
                        }
                    }
                }
            $eval_string = true;
            }
        else if ($this->GetOption('string_or_number_eval','numeric') == 'compute')
            {
            foreach ($flds[1] as $tF)
                {
                if (isset($mapId[$tF]))
                    {
                    $ref = $mapId[$tF];
                    $procstr = str_replace('$fld_'.$tF,
                         $this->sanitizeValue($others[$ref]->GetHumanReadableValue()),$procstr);
                    }
                }
			$eval_string = true;
            }
		else
			{
			$thisValue = '';
			foreach ($flds[1] as $tF)
				{
				if (isset($mapId[$tF]))
					{
					$ref = $mapId[$tF];
					$this->Value .= $others[$ref]->GetValue();
					if ($this->GetOption('string_or_number_eval','numeric') != 'unstring')
						{
						$this->Value .= ' ';
						}
					}
				}
			}
		if ($eval_string)
			{
			$strToEval = "\$this->Value=$procstr;";
			// see if we can trap an error
			// this is all vulnerable to an evil form designer, but
			// not an evil form user. 
			ob_start();
			if (eval('function testcfield'.rand().'() {'.$strToEval.'}') === FALSE)
				{
				$this->Value = $mod->Lang('title_bad_function',$procstr);
				}
			else
				{
				eval($strToEval);
				} 
			ob_end_clean();                
			}
    }

	// strip any possible PHP function from submitted string
	function sanitizeValue($val)
	{
		$arr = get_defined_functions(); // internal and user
		$val = str_replace($arr['internal'],'',$val);
		$val = str_replace($arr['user'],'',$val);
		return $val;
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$processType = array($mod->Lang('title_numeric')=>'numeric',
		    $mod->Lang('title_string')=>'string', $mod->Lang('title_string_unspaced')=>'unstring', $mod->Lang('title_compute')=>'compute');
		
		$ret = $this->form_ptr->fieldValueTemplate();
	    $ret .= '<tr><td colspan="2">'.$mod->Lang('operators_help') .
	        '</td></tr></table>';
		
		$main = array(
				array($mod->Lang('title_compute_value'),
            		array($mod->CreateInputText($formDescriptor, 'fbrp_opt_value',$this->GetOption('value',''),35,1024),$ret)),
				array($mod->Lang('title_string_or_number_eval'),
				$mod->CreateInputRadioGroup($formDescriptor, 'fbrp_opt_string_or_number_eval',
				    $processType,
				    $this->GetOption('string_or_number_eval','numeric'))),
				array($mod->Lang('title_order'),
				$mod->CreateInputText($formDescriptor,
				    'fbrp_opt_order',$this->GetOption('order','1'),5,10).
				    $mod->Lang('title_order_help'))
		);
		$adv = array(
		);
		return array('main'=>$main,'adv'=>$adv);
	}


}

?>
