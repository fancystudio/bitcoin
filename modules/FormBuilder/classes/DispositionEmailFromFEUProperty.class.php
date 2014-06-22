<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

require_once(dirname(__FILE__).'/DispositionEmailBase.class.php');

class fbDispositionEmailFromFEUProperty extends fbDispositionEmailBase
{

	function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr,$params);
		$mod = $form_ptr->module_ptr;

		$this->Type = 'DispositionEmailFromFEUProperty';
		$this->DisplayInForm = true;
		$this->DisplayInSubmission = true;
		$this->NonRequirableField = true;
	}


	function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		$ret = 'Property: '.$this->GetOption('feu_property');
		$ret .= $this->TemplateStatus();
		return $ret;
	}


	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		list($main,$adv) = $this->PrePopulateAdminFormBase($formDescriptor);

		$feu = $mod->GetModuleInstance('FrontEndUsers');
		if( !is_object($feu) )
		{
			// just act like a regular disposition...
			$tmp = array($mod->Lang('error_emailfromfeuprop'),$mod->Lang('error_nofeu'));
			array_unshift($main,$tmp);
			return array('main'=>$main,'adv'=>$adv);
		}

		$defns = $feu->GetPropertyDefns();
		if( !is_array($defns) )
		{
			// just act like a regular disposition...
			$tmp = array($mod->Lang('error_emailfromfeuprop'),$mod->Lang('error_nofeudefns'));
			array_unshift($main,$tmp);
			return array('main'=>$main,'adv'=>$adv);
		}

		// check for dropdown or multiselect fields
		$opts = array();
		foreach( $defns as $key => $data )
		{
			switch( $data['type'] )
			{
				case 4:
				case 5:
				case 7:
					$opts[$data['name']] = $data['prompt'];
					break;

				default:
					// ignore these field types.
					break;
			}
		}
		if( !count($opts) )
		{
			// just act like a regular disposition...
			$tmp = array($mod->Lang('error_emailfromfeuprop'),$mod->Lang('error_nofeudefns'));
			array_unshift($main,$tmp);
			return array('main'=>$main,'adv'=>$adv);
		}

		$keys = array_keys($opts);
		$tmp = array($mod->Lang('title_feu_property'),
		$mod->CreateInputDropdown($formDescriptor,'fbrp_opt_feu_property',
		array_flip($opts),-1,
		$this->GetOption('feu_property',$keys[0])).'<br/>'.$mod->Lang('info_feu_property'));
		array_unshift($main,$tmp);
		return array('main'=>$main,'adv'=>$adv);
	}


	function GetFieldInput($id,&$params,$returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$feu = $mod->GetModuleInstance('FrontEndUsers');
		if( !$feu ) return FALSE;

		// get the proeprty name and data
		$prop = $this->GetOption('feu_property');
		if( !$prop ) return FALSE;
		$defn = $feu->GetPropertyDefn($prop);
		if( !$defn ) return FALSE;

		// get the property input field.
		$options = $feu->GetSelectOptions($prop);
		switch( $defn['type'] )
		{
			case 4: // dropdown
			case 5: // multiselect
			case 7: // radio button group
				// rendered all as a dropdown field.
				$res = $mod->CreateInputDropdown($id,'fbrp__'.$this->Id,$options,-1,$this->GetCSSIdTag());
				break;

			default:
				return FALSE;
		}

		return $res;
	}


	function GetHumanReadableValue($as_string = true)
	{
		$mod = $this->form_ptr->module_ptr;
		$feu = $mod->GetModuleInstance('FrontEndUsers');
		$prop = $this->GetOption('feu_property');

		$opts = array_flip($feu->GetSelectOptions($opts));
		if( isset($opts[$this->Value]) ) return $opts[$this->Value];
	}


	function DisposeForm($returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$feu = $mod->GetModuleInstance('FrontEndUsers');
		if( !$feu ) return array(false,'FrontEndUsers module not found');

		// get the property name
		$prop = $this->GetOption('feu_property');

		// get the list of emails that match this value.
		$users = $feu->GetUsersInGroup(-1,'','','',$prop,$this->Value);
		if( !is_array($users) || count($users) == 0 )
		{
			// no matching users is not an error.
			return array(true,'');
		}

		$smarty_users = array();
		$destinations = array();
		for( $i = 0; $i < count($users); $i++ )
		{
			$rec =& $users[$i];
			unset($rec['password']);
			if( $feu->GetPreference('username_is_email') )
			{
				$rec['email'] = $rec['username'];
				$destinations[] = $rec['username'];
			}
			else
			{
				$rec['email'] = $feu->GetEmail($rec['id']);
				$destinations[] = $rec['email'];
			}
			$smarty_users[$rec['username']] = $rec;
			$smarty = $mod->smarty;
			$smarty->assign('users',$smarty_users);

			if( count($users) == 1 )
			{
				$smarty->assign('user_info',$users[0]);
			}
		}

		// send the form.
		return $this->SendForm($destinations,$this->GetOption('email_subject'));
	}

}
?>