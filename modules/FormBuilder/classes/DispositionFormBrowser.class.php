<?php
/* 
   FormBuilder. Copyright (c) 2005-2008 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbDispositionFormBrowser extends fbFieldBase {

	var $approvedBy;

	function __construct(&$form_ptr, &$params)
	{
      parent::__construct($form_ptr, $params);
      $mod = $form_ptr->module_ptr;
		$this->Type = 'DispositionFormBrowser';
		$this->IsDisposition = true;
		$this->NonRequirableField = true;
		$this->DisplayInForm = false;
		$this->DisplayInSubmission = false;
		$this->HideLabel = 1;
		$this->NeedsDiv = 0;
		$this->approvedBy = '';
		$this->sortable = false;
	}

	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		if ($this->Value === false)
			{
			return '';
			}
		return $mod->CreateInputHidden($id, 'fbrp__'.$this->Id,	
			$this->EncodeReqId($this->Value));
	}

	function SetApprovalName($name)
	{
		$this->approvedBy = $name;
	}

	function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		$enc = ($this->GetOption('crypt','0') == '1'?$mod->Lang('yes'):$mod->Lang('no'));
		$feu = ($this->GetOption('feu_bind','0') == '1'?$mod->Lang('yes'):$mod->Lang('no'));
		return $mod->Lang('title_encryption').':'.$enc.', '.$mod->Lang('title_feu_binding').':'.$feu;
	}
	
	function DecodeReqId($theVal)
	{
		$tmp = base64_decode($theVal);
		$tmp2 = str_replace(session_id(),'',$tmp);
		if (substr($tmp2,0,1) == '_')
			{
			return substr($tmp2,1);
			}
		else
			{
			return -1;
			}
	}
	
	function EncodeReqId($req_id)
	{
		return base64_encode(session_id().'_'.$req_id);
	}
	
	
	function SetValue($val)
	{
		$decval = base64_decode($val);
   
		if ($val === false)
			{
			// no value set, so we'll leave value as false
			}
		elseif (strpos($decval,'_') === false)
			{
			// unencrypted value, coming in from previous response
			$this->Value = $val;
			}
		else
			{
			// encrypted value coming in from a form, so we'll update.
			$this->Value = $this->DecodeReqId($val);
			}
	}
	
	function PrePopulateAdminForm($formDescriptor)
	{
	
		$mod = $this->form_ptr->module_ptr;
		$form = $this->form_ptr;
		$fields = $form->GetFields();
		$fieldlist = array($mod->Lang('none')=>'-1');
		$main = array();
		$adv = array();
		for ($i=0;$i<count($fields);$i++)
			{
			if ($fields[$i]->DisplayInSubmission())
				{
				$fieldlist[$fields[$i]->GetName()] = $fields[$i]->GetId();
				}
			}
		$current_indexes = array();
		for ($i=1;$i<6;$i++)
			{
			$fname = array_search($this->GetOption('sortfield'.$i),$fieldlist);
			array_push($main,
					array($mod->Lang('title_sortable_field',array($i)),
						$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_sortfield'.$i, $fieldlist, -1,
					$this->GetOption('sortfield'.$i,-1))
					));
			array_push($current_indexes,$this->GetOption('sortfield'.$i,-1));
			}
	  array_push($main,array($mod->Lang('title_note'),$mod->Lang('title_changing_triggers_reindex').
		$mod->CreateInputHidden($formDescriptor,'fbrp_previous_indices',implode(':',$current_indexes))
		));

	array_push($adv,array($mod->Lang('title_searchable'),
		$mod->CreateInputHidden($formDescriptor, 'fbrp_opt_searchable','0').
		$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_searchable',
		'1',$this->GetOption('searchable','0')).
		$mod->Lang('title_searchable_help')));

	  $feu = cmsms()->GetModuleInstance('FrontEndUsers');
	  if ($feu === null)
		{
		array_push($adv,array($mod->Lang('title_feu_binding'),
			$mod->Lang('title_install_feu')));	
		}
	else
		{
		array_push($adv,array($mod->Lang('title_feu_binding'),
			$mod->CreateInputHidden($formDescriptor, 'fbrp_opt_feu_bind','0').
			$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_feu_bind',
			'1',$this->GetOption('feu_bind','0')).
			$mod->Lang('title_feu_bind_help')));
		}
		
	  $openssl = cmsms()->GetModuleInstance('OpenSSL');
	  if ($openssl === null && !function_exists('mcrypt_encrypt'))
		{
		array_push($adv,array($mod->Lang('title_encryption_functions'),
            $mod->Lang('title_install_crypto')));
        
		}
	else
		{
		if ($openssl !== null)
         {
		    $keys = $openssl->getKeyList();
		    $certs = $openssl->getCertList();
		    }
		array_push($adv,array($mod->Lang('title_encrypt_database_data'),
			   $mod->CreateInputHidden($formDescriptor, 'fbrp_opt_crypt','0').
            		$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_crypt',
            		'1',$this->GetOption('crypt','0')).
					$mod->Lang('title_encrypt_database_long')));
		array_push($adv,array($mod->Lang('title_encrypt_sortfields'),
			   $mod->CreateInputHidden($formDescriptor, 'fbrp_opt_hash_sort','0').
            		$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_hash_sort',
            		'1',$this->GetOption('hash_sort','0')).
                  $mod->Lang('title_encrypt_sortfields_help')));
		array_push($adv,array($mod->Lang('title_encryption_keyfile'),
            $mod->CreateInputText($formDescriptor, 'fbrp_opt_keyfile',
            		$this->GetOption('keyfile',''),40,255)));

      $cryptlibs = array();
      if ($openssl !== null)
         {
         $cryptlibs[$mod->Lang('openssl')]='openssl';
         }
      if (function_exists('mcrypt_encrypt'))
         {
         $cryptlibs[$mod->Lang('mcrypt')]='mcrypt';
         }

		array_push($adv,array($mod->Lang('title_crypt_lib'),
            $mod->CreateInputDropdown($formDescriptor,'fbrp_opt_crypt_lib',
            $cryptlibs,-1,$this->GetOption('crypt_lib'))));



      if ($openssl !== null)
         {
         array_push($adv,array($mod->Lang('choose_crypt'),$mod->Lang('choose_crypt_long')));

		   array_push($adv,array($mod->Lang('title_crypt_cert'),
					$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_crypt_cert', $certs,
						-1,$this->GetOption('crypt_cert'))));
		    array_push($adv,array($mod->Lang('title_private_key'),
				$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_private_key', $keys,
					-1,$this->GetOption('private_key')).$mod->Lang('title_ensure_cert_key_match')));
         }
		}

		return array('main'=>$main,'adv'=>$adv);
	}

	function PostPopulateAdminForm(&$mainArray, &$advArray)
	{
		$mod = $this->form_ptr->module_ptr;
		$this->HiddenDispositionFields($mainArray, $advArray);
	}


	function DisposeForm($returnid)
	{
		$form = $this->form_ptr;
		list($res,$msg) = $form->StoreResponse(($this->Value?$this->Value:-1),$this->approvedBy,$this);
		if ($this->GetOption('searchable','0') == '1')
			{
			$form->AddToSearchIndex($this->Value);
			}
		return array($res, $msg);
	}


  function PostFieldSaveProcess(&$params)
  {
	$reindex = false;
	$prev_indices = explode(':',$params['fbrp_previous_indices']);
	for ($i=1;$i<6;$i++)
		{
		if ($this->GetOption('sortfield'.$i) != $prev_indices[$i-1])
			{
			$reindex = true;
			}
		}
	if (! $reindex)
		{
		return;
		}
	$form = $this->form_ptr;
	$form->ReindexResponses();
  }
  

	function getHashedSortFieldVal($sortFieldNumber)
   {
      $v = $this->getSortFieldVal($sortFieldNumber);
      if (strlen($v) > 4)
         {
         $v = substr($v,0,4). md5(substr($v,4));
         }
      return $v;
   }
	
	function getSortFieldList()
	{
		$form = $this->form_ptr;
		$ret = array();
		for ($i=1;$i<6;$i++)
			{
			if ($this->GetOption('sortfield'.$i,'-1') != '-1')
				{
				$afield = $form->GetFieldById($this->GetOption('sortfield'.$i));
				if ($afield !== false)
               {
				   $ret[$i] = $afield->GetName();
               }
				}
			}
		return $ret;
	}

	function getSortFieldVal($sortFieldNumber)
	{
		$form = $this->form_ptr;
		$val = "";
		if ($this->GetOption('sortfield'.$sortFieldNumber,'-1') != '-1')
			{
			$afield = $form->GetFieldById($this->GetOption('sortfield'.$sortFieldNumber));
         if ($afield !== false)
            {
            $val = $afield->GetHumanReadableValue();
            }
			}
		if (strlen($val) > 80)
			{
			$val = substr($val,0,80);
			}
		return $val;
	}

}

?>
