<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

/* A class to provide a dynamic multiselect list to allow selecting one
 * or more items from the CompanyDirectory 
 * the item list is filtered by an array
 * of options as specified in the admin.
 * This Field written by Jeremy Bass <jeremyBass@cableone.net>
 */
class fbCompanyDirectoryField extends fbFieldBase {

  var $optionCount;
  var $optionAdd;

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'CompanyDirectoryField';
    $this->DisplayInForm = true;
    $this->NonRequirableField = false;
	$this->DisplayInSubmission = true;
    $this->HasAddOp = false;
    $this->HasDeleteOp = false;
    $this->ValidationTypes = array();
    $this->optionAdd = 0;
    $this->sortable = false;
  }


  function GetFieldInput($id, &$params, $returnid)
  {
    global $gCms;

    $mod = $this->form_ptr->module_ptr;
    $CompanyDirectory = $mod->GetModuleInstance('CompanyDirectory');
    if( !$CompanyDirectory )
      {
	return $mod->Lang('error_CompanyDirectory_module_not_available');
      }

    $results = array();

		$db = $gCms->GetDb();
 		$Like=$this->GetOption('Category','%');
		if($Like==''||$Like=='%'||$Like=='All'){
			$processPath="LIKE  '%'";
		}else{
			$processPath="=  ?";
		}
 		$query = 'SELECT com.id, com.company_name FROM '.cms_db_prefix().'module_compdir_company_categories AS comcat '
				.'LEFT JOIN '.cms_db_prefix().'module_compdir_categories AS cat ON cat.id = comcat.category_id '
				.'LEFT JOIN '.cms_db_prefix().'module_compdir_companies AS com ON com.id = comcat.company_id '
				.'WHERE cat.name '.$processPath.' AND status = \'published\'';

		$query2 = 'SELECT value FROM '.cms_db_prefix().'module_compdir_fieldvals AS comfv '
				.'LEFT JOIN '.cms_db_prefix().'module_compdir_fielddefs AS fdd ON fdd.id = comfv.fielddef_id '
				.'LEFT JOIN '.cms_db_prefix().'module_compdir_companies AS com ON comfv.company_id = com.id '
				.'WHERE com.company_name = ? AND fdd.name = ?';
		$val=array();
		$companies = array();
		$field=$this->GetOption('FieldDefs','');
		if($Like==''||$Like=='%'||$Like=='All'){
			$dbr = $db->Execute( $query , array());
				while( $dbr && ($row = $dbr->FetchRow()) ){
					$company=$row['company_name'];
					$FDval='';
					$dbr2 = $db->Execute( $query2 , array($company,$field));
						while( $dbr2 && ($row = $dbr2->FetchRow()) ){
							$FDval=$row['value'];
						}
					$companies[$company] = $FDval;
				}

		}else{
			if(is_array($Like)){
				foreach($Like as $key => $value){
					$dbr = $db->Execute( $query , array($value));
						while( $dbr && ($row = $dbr->FetchRow()) ){
							$company=$row['company_name'];
							$FDval='';
							$dbr2 = $db->Execute( $query2 , array($company,$field));
								while( $dbr2 && ($row = $dbr2->FetchRow()) ){
									$FDval=$row['value'];
								}
							$companies[$company] = $FDval;
						}
				}
			}else{
				$dbr = $db->Execute( $query , array($Like));
					while( $dbr && ($row = $dbr->FetchRow()) ){
							$company=$row['company_name'];
							$FDval='';
							$dbr2 = $db->Execute( $query2 , array($company,$field));
								while( $dbr2 && ($row = $dbr2->FetchRow()) ){
									$FDval=$row['value'];
								}
							$companies[$company] = $FDval;
					}
			}
		}

      foreach($companies as $key=>$val)
         {
         if (empty($val))
            {
            $companies[$key]=$key;
            }
         }
		// All done, do we have something to display?
		if( count($companies) ){
			$size = min(50,count($companies)); // maximum 50 lines, though this is probably big
			
			$val = array();
			if( $this->Value !== false ){
				$val = $this->Value;
				if( !is_array( $this->Value ) ){
					$val = array($this->Value);
				}
			}
			
			$cssid = $this->GetCSSIdTag();
			$UserInput = $this->GetOption('UserInput','Dropdown');
			if($UserInput=='Select List-single'){
				return $mod->CreateInputSelectList($id,'fbrp__'.$this->Id.'[]', $companies, $val, $size, $cssid);
			}elseif($UserInput=='Select List-multiple'){
				return $mod->CreateInputSelectList($id,'fbrp__'.$this->Id.'[]', $companies, $val, $size, $cssid, true);
			}elseif($UserInput=='Dropdown'){
				return $mod->CreateInputDropdown($id,'fbrp__'.$this->Id.'', $companies, '-1', $val);
			}elseif($UserInput=='Radio Group'){
				return $mod->CreateInputRadioGroup($id,'fbrp__'.$this->Id.'', $companies, $val,'',' ');
			}
		}

    return ''; // error
	}


  function StatusInfo()
  {
    // return a string for displaying in the options field
    $mod = $this->form_ptr->module_ptr;
    $CompanyDirectory = $mod->GetModuleInstance('CompanyDirectory');
    if( !$CompanyDirectory )
      {
	return $mod->Lang('error_CompanyDirectory_module_not_available');
      }
    return '';
  }
	

  function PrePopulateAdminForm($formDescriptor)
  {
    $mod = $this->form_ptr->module_ptr;
	global $gCms;
   //$CompanyDirectory = $mod->GetModuleInstance('CompanyDirectory');
	 $db =& $gCms->GetDb();
		$query = 'SELECT id, name FROM '.cms_db_prefix().'module_compdir_categories ';
		$dbr = $db->Execute( $query , array());
		$Categories = array();
		$Categories['All'] = 'All';
		while( $dbr && ($row = $dbr->FetchRow()) )
		{
			$Categories[$row['name']] = $row['name'];
		}
		$CategorySelected=$this->GetOption('Category','');

		$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_fielddefs ORDER BY item_order';
		$dbr = $db->Execute( $query , array());
		$FieldDefs = array();
		$FieldDefs['none'] = 'none';
		while( $dbr && ($row = $dbr->FetchRow()) )
		{
			$FieldDefs[$row['name']] = $row['name'];
		}
		$FieldDefsSelected=$this->GetOption('FieldDefs','');
		
		//check and force the right type
		if(!is_array($CategorySelected)){$CategorySelected=explode(',',$CategorySelected);}
		if(!is_array($FieldDefsSelected)){$FieldDefsSelected=explode(',',$FieldDefsSelected);}		
		
		
		$Useinput=array($mod->Lang('option_dropdown')=>'Dropdown',
			   $mod->Lang('option_selectlist_single')=>'Select List-single',
			   $mod->Lang('option_selectlist_multiple')=>'Select List-multiple',
			   $mod->Lang('option_radiogroup')=>'Radio Group'
			   );
		
		$main = array(
				array($mod->Lang('title_company_field_note'),''),  
				array($mod->Lang('title_pick_categories'),
					$mod->CreateInputSelectList($formDescriptor,'fbrp_opt_Category[]', $Categories, $CategorySelected, 5,'',true)
				),
				array($mod->Lang('title_pick_fielddef'),
					$mod->CreateInputSelectList($formDescriptor,'fbrp_opt_FieldDefs', $FieldDefs, $FieldDefsSelected, 5,'',false)
				)
		);
		$adv = array(
				array($mod->Lang('title_choose_user_input'),
					$mod->CreateInputDropdown ($formDescriptor,'fbrp_opt_UserInput', $Useinput, '-1', $this->GetOption('UserInput','')) 
				)
		);
		return array('main'=>$main,'adv'=>$adv);
  }

  function GetHumanReadableValue($as_string=true)
  {
    $mod = $this->form_ptr->module_ptr;
    $form = $this->form_ptr;
    if ($this->HasValue())
      {
	$fieldRet = array();
	if (! is_array($this->Value))
	  {
	    $this->Value = array($this->Value);
	  }
	if ($as_string)
	  {
	    return join($form->GetAttr('list_delimiter',','),$this->Value);
	  }
	else
	  {
	    return array($this->Value);
	  }			
      }
    else
      {
	if ($as_string)
	  {
	    return $mod->Lang('unspecified');
	  }
	else
	  {
	    return array($mod->Lang('unspecified'));
	  }
      }
	
  }

}
?>
