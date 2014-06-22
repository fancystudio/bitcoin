<?php
// Feedback Form. 02/2005 SjG <feedbackform_cmsmodule@fogbound.net>
// A Module for CMS Made Simple, (c)2005 by Ted Kulp (wishy@cmsmadesimple.org)
// This project's homepage is: http://www.cmsmadesimple.org

class fbStatePickerField extends fbFieldBase {

	var $States;
	
	function __construct(&$form_ptr, &$params)
	{
        parent::__construct($form_ptr, $params);
        $mod = $form_ptr->module_ptr;
		$this->Type = 'StatePickerField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array(
            );

        $this->States = array(
        "No Default"=>'',"Alabama"=>"AL", "Alaska"=>"AK", "Arizona"=>"AZ", "Arkansas"=>"AR", 
        "California"=>"CA", "Colorado"=>"CO", "Connecticut"=>"CT", "Delaware"=>"DE", 
        "Florida"=>"FL", "Georgia"=>"GA", "Hawaii"=>"HI", "Idaho"=>"ID", 
        "Illinois"=>"IL", "Indiana"=>"IN", "Iowa"=>"IA", 
        "Kansas"=>"KS", "Kentucky"=>"KY", "Louisiana"=>"LA", "Maine"=>"ME",
        "Maryland"=>"MD", "Massachusetts"=>"MA", 
        "Michigan"=>"MI", "Minnesota"=>"MN", "Mississippi"=>"MS",
        "Missouri"=>"MO", "Montana"=>"MT", "Nebraska"=>"NE", 
        "Nevada"=>"NV", "New Hampshire"=>"NH", "New Jersey"=>"NJ",
        "New Mexico"=>"NM", "New York"=>"NY", 
        "North Carolina"=>"NC", "North Dakota"=>"ND", "Ohio"=>"OH",
        "Oklahoma"=>"OK", "Oregon"=>"OR", 
        "Pennsylvania"=>"PA", "Rhode Island"=>"RI", "South Carolina"=>"SC",
        "South Dakota"=>"SD", "Tennessee"=>"TN", "Texas"=>"TX", "Utah"=>"UT",
        "Vermont"=>"VT", "Virginia"=>"VA", "Washington"=>"WA",
        "District of Columbia"=>"DC", "West Virginia"=>"WV", "Wisconsin"=>"WI",
        "Wyoming"=>"WY");

	}


    function StatusInfo()
	{
		return '';
	}

	function GetHumanReadableValue($as_string=true)
	{
		$ret = array_search($this->Value,$this->States);
		if ($as_string)
			{
			return $ret;
			}
		else
			{
			return array($ret);
			}		
	}


	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');

		unset($this->States[$mod->Lang('no_default')]);
		if ($this->GetOption('select_one','') != '')
			{
			$this->States = array_merge(array($this->GetOption('select_one','')=>''),$this->States);
			}
		else
			{
			$this->States = array_merge(array($mod->Lang('select_one')=>''),$this->States);
			}


		if (! $this->HasValue() && $this->GetOption('default_state','') != '')
		  {
		  $this->SetValue($this->GetOption('default_state',''));
		  }

		return $mod->CreateInputDropdown($id, 'fbrp__'.$this->Id, $this->States, -1, $this->Value, $js.$this->GetCSSIdTag());
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		ksort($this->States);

		$main = array(
			array($mod->Lang('title_select_default_state'),
            		$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_default_state',
            		$this->States, -1, $this->GetOption('default_state',''))),
			array($mod->Lang('title_select_one_message'),
            		$mod->CreateInputText($formDescriptor, 'fbrp_opt_select_one',
            		$this->GetOption('select_one',$mod->Lang('select_one'))))
		);
		return array('main'=>$main,array());
	}


}

?>
