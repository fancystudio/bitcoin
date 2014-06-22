<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: SelfRegistration (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to register themselves
#  with a website.
# 
# Version: 1.1.5
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin 
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
if( !isset($gCms) ) exit;
$feusers = $this->GetModuleInstance('FrontEndUsers');
if( !$feusers ) {
  // this is ugly for the user to see
  // but at least the admin will be able to figure it out
  // this shouldn't happen once the user has seen the form.
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_nofeusersmodule'));
  return;
}

$cmsmailer = $this->GetModuleInstance('CMSMailer');
if( !$cmsmailer ) {
  // this is ugly for the user to see
  // but at least the admin will be able to figure it out
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_nofeusersmodule'));
  return;
}

// clean parameters
$params = selfreg_utils::clean_params($params);
// check for required parameters
if( !isset( $params['group'] ) ) {
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_insufficientparams'));
  return;
}
if( !isset($params['pkg']) ) {
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_insufficientparams'));
  return;
}


// attempt to register to an absolutely verboten group.
$grpids = selfreg_utils::expand_group($params['group']);
if( !count($grpids) ) {
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_insufficientparams'));
  return;
}
$tmp = $this->GetPreference('noregister_groups');
if( !empty($tmp) ) {
  $tmp = explode(',',$tmp);
  foreach( $grpids as $onegrp ) {
    if( in_array($onegrp,$tmp) ) {
      $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_noregister'));
      return;
    }
  }
}

// Get property definitions
$defns = $feusers->GetPropertyDefns();

$properties = array();
{
  $tmp = array();
  foreach( $grpids as $gid ) {
    $grelns = $feusers->GetGroupPropertyRelations( $gid );
    $tmp = RRUtils::array_merge_by_name_required($tmp,$grelns);
    uasort( $tmp, 'cge_array::compare_elements_by_sortorder_key');
  }
  foreach( $tmp as $one ) {
    $properties[$one['name']] = $one;
  }
}

//
// Check to ensure all required fields have some content
// and validate email fields
//
$reg_additionalgroups = $this->GetPreference('reg_additionalgroups',0);
$allow_overwrite = (isset($params['allowoverwrite']))?$params['allowoverwrite']:0;
$matchfields_str = $this->GetPreference('additionalgroups_matchfields','');
$matchfields = explode('::',$matchfields_str);
foreach( $properties as $propname => $prop ) {
  if( !isset($defns[$propname]) ) {
    $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_dberror'));
    return;
  }
  $defn = $defns[$propname];
  $proptype = $defn['type'];
  $required = ($prop['required'] == 2);
  $force_unique = $defn['force_unique'];

  switch( $proptype ) {
  case 2: /* email */
    if( $required ) {
      if( !isset($params['input_'.$propname]) || $params['input_'.$propname] == '' ) {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_requiredfield',$defn['prompt']);
	return $this->myRedirect( $id, 'default', $returnid, $params );
      }
	  
      $result = $feusers->IsValidEmailAddress( $params['input_'.$propname]);
      if( $result[0] == false ) {
	$params['error'] = 1;
	$params['message'] = $result[1];
	return $this->myRedirect( $id, 'default', $returnid, $params );
      }
    }
    break;
      
  case 5: /* multiselect */
    if( $required ) {
      if( !isset($params['input_'.$propname]) || $params['input_'.$propname] == ''  ) {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_requiredfield',$defn['prompt']);
	return $this->myRedirect( $id, 'default', $returnid, $params );
      }
    }
    if( isset($params['input_'.$propname]) ) $params['input_'.$propname] = implode(',',$params['input_'.$propname]);
    break;
      
  case 8: /* date */
    if( $required ) {
      if( !isset($params['input_'.$propname.'Month']) ) {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_requiredfield',$defn['prompt']);
	return $this->myRedirect( $id, 'default', $returnid, $params );
      }
    }
    if( isset($params['input_'.$propname.'Month']) ) {
      $params['input_'.$propname] =
	mktime(0,0,0,
	       $params['input_'.$propname.'Month'],
	       $params['input_'.$propname.'Day'],
	       $params['input_'.$propname.'Year']);
      unset($params['input_'.$propname.'Month']);
      unset($params['input_'.$propname.'Day']);
      unset($params['input_'.$propname.'Year']);
    }
    break;
      
  default:
    if( $required ) {
      if( !isset($params['input_'.$propname]) || $params['input_'.$propname] == '' ) {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_requiredfield',$defn['prompt']);
	return $this->myRedirect( $id, 'default', $returnid, $params );
      }
    }
    break;
  }

  if( $force_unique && (!$allow_overwrite || !in_array($propname,$matchfields)) ) {
    $value = $params['input_'.$propname];
    if( $value != '' && !$feusers->IsUserPropertyValueUnique( -1, $propname, $value ) ) {
      $params['error'] = 1;
      $params['message'] = $this->Lang('error_uniquefield',$defn['prompt']);
      return $this->myRedirect( $id, 'default', $returnid, $params );
    }
  }
}

// get the username and password
$username = '';
$password = '';
$repeatpassword = '';
if( isset( $params['input_username'] ) ) {
  $username = trim($params['input_username']);
  $username = cms_html_entity_decode($username);
}
if( isset( $params['input_password'] ) ) {
  $password = trim($params['input_password']);
  $password = cms_html_entity_decode($password);
}
if( isset( $params['input_repeatpassword'] ) ) {
  $repeatpassword = trim($params['input_repeatpassword']);
  $repeatpassword = cms_html_entity_decode($repeatpassword);
}

// check if the username is valid
if( $username == '' ) {
  $params['error'] = 1;
  if ($feusers->GetPreference('username_is_email')) {
    $params['message'] = $this->Lang('error_emptyemail');
  }
  else {
    $params['message'] = $this->Lang('error_emptyusername');
  }
    
  return $this->myRedirect( $id, 'default', $returnid, $params );
}

//Ok, we have a valid $username, now we check to see
//if we're checking the whitelist (or blacklist) and
//and then if it matches...
if ($this->GetPreference('enable_whitelist', '') != '') {
  $matched = false;
  $list = preg_split("/((\r(?!\n))|((?<!\r)\n)|(\r\n))/", $this->GetPreference('whitelist', ''));
  if (count($list)) {
    foreach ($list as $one_line) {
      $regex = '/^' . str_replace("@", "\@", str_replace("\*", ".*", preg_quote($one_line))) . '$/';
      if (preg_match($regex, $username) > 0) {
	$matched = true;
	break;
      }
    }
  }
	
  if ( ($this->GetPreference('enable_whitelist', '') == 'exclude' && $matched) ||
       ($this->GetPreference('enable_whitelist', '') == 'include' && !$matched) ) {
    $params['error'] = 1;
    $params['message'] = $this->GetPreference('whitelist_trigger_message', 'Whitelist Matched');
    return $this->myRedirect($id, 'default', $returnid, $params);
  }
}

// check if the passwords match or if they're valid
if( $password != $repeatpassword ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_passwordsdontmatch');
  return $this->myRedirect( $id, 'default', $returnid, $params );
}
$minpwlen = $feusers->GetPreference('min_passwordlength');
$maxpwlen = $feusers->GetPreference('max_passwordlength');
if( strlen($password) < $minpwlen || strlen($password) > $maxpwlen ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_invalidpassword', array($minpwlen,$maxpwlen));
  return $this->myRedirect( $id, 'default', $returnid, $params );
}


// get an email field
// so that we can do some emailing.
$email_field = '';
if ($feusers->GetPreference('username_is_email')) {
  // email field is easy!
  $email_field = 'input_username';
}
else {
  // find an email field... something that's name has email in it
  // or is of type 2
  foreach( $params as $key => $val ) {
    if( preg_match( '/^input_/', $key ) ) {
      $proptype = '';
      $propname = substr($key,strlen('input_'));
      if( isset($defns[$propname]) && $defns[$propname]['type'] == 2 ) $email_field = 'input_'.$propname;
    }
  }
}
if( $email_field == '' ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_noemailaddress');
  return $this->myRedirect( $id, 'default', $returnid, $params );
}
$email = $params[$email_field];
$res = $feusers->IsValidEmailAddress($email, -1, FALSE);
if( !is_array($res) || $res[0] == FALSE ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_invalidemail');
  return $this->myRedirect( $id, 'default', $returnid, $params );
}

// check the repeated email field.
if( $this->GetPreference('selfreg_force_email_twice') ) {
  if( !isset($params[$email_field.'_again'] ) ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_nosecondemailaddress');
    return $this->myRedirect( $id, 'default', $returnid, $params );
  }

  if( $params[$email_field] != $params[$email_field.'_again'] ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_emaildoesnotmatch');
    return $this->myRedirect( $id, 'default', $returnid, $params );
  }
}

// check captcha.
$captcha = $this->GetModuleInstance('Captcha');
if( is_object($captcha) && !isset($params['nocaptcha']) ) {
  if (! $captcha->CheckCaptcha($params['input_captcha'])) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_captchamismatch');
    return $this->myRedirect( $id, 'default', $returnid, $params );
  }
}


// check if the username is taken.
$overwrite_uid = null;
if( $reg_additionalgroups && $allow_overwrite ) {
  // we're allowing registration to additional groups.
  // meaning we need to find the existing user info

  $query = new feu_user_query();
  $query->set_pagelimit(1);
  foreach( $matchfields as $field ) {
    switch($field) {
    case '*username-password*':
      $feu = cms_utils::get_module('FrontEndUsers');
      $salt = $feu->GetPreference('pwsalt');
      $epasswd = md5($password.$salt);
      $query->add_and_opt(feu_user_query_opt::MATCH_USERNAME,$username);
      $query->add_and_opt(feu_user_query_opt::MATCH_PASSWORD,$epasswd);
      break;
	    
    default:
      $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY,$field,$params['input_'.$field]));
      break;
    }
  }

  $rs = $query->execute();
  $cnt = $rs->get_found_rows();
  if( $cnt == 1 ) {
    // only one match found.
    $data = $rs->fields;
    $overwrite_uid = $data['id'];
  }
}

// we just have to make sure the username isn't taken.
if( empty($overwrite_uid) && $feusers->GetUserID($username) ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_usernametaken');
  return $this->myRedirect( $id, 'default', $returnid, $params );
}

if( !$feusers->IsValidUsername( $username, ($overwrite_uid < 1) ? true : false ) ) {
  $params['error'] = 1;
  if ($feusers->GetPreference('username_is_email')) {
    $params['message'] = $this->Lang('error_invalidemail');
  }
  else {
    $params['message'] = $this->Lang('error_invalidusername');
  }
  return $this->myRedirect( $id, 'default', $returnid, $params );
}

$uid = $this->GetTempUserID($username);
if( $uid != false ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_usernametaken');
  return $this->myRedirect( $id, 'default', $returnid, $params );
}

// generate a unique code that the user can enter to double confirm
// his login.
$code = $feusers->GenerateRandomPrintableString();

// have to add the record to the database so that we know who this guy is
// when he comes back
$return = $this->CreateTempUser( $grpids, $username, $password, $code, $overwrite_uid );
if( $return[0] == false ) {
  $params['error'] = 1;
  $params['message'] = $return[1];
  return $this->myRedirect( $id, 'default', $returnid, $params );
}

// and add his properties too
$tmpuid = $return[1];
foreach( $properties as $propname => $prop ) {
  // check if the value exists (it may be an optional field)
  if( !isset($params['input_'.$propname]) ) continue;
  
  $value = $params['input_'.$propname];
  $return = $this->AddTempUserProperty( $tmpuid, $propname, $params['input_'.$propname] );
  
  if( $return[0] == false ) {
    // now we have an issue to figure out
    $this->DeleteTempUser( $tmpuid );
    $params['error'] = 1;
    $params['message'] = $return[1];
    return $this->myRedirect( $id, 'default', $returnid, $params );
  }
}


//
// okay we're done creating temporary users
//
$redirect_pref = 'redirect_afterregister';
$action = 'post_registeruser';
$parms = array();
$parms['sr_username'] = $username;
$parms['sr_email'] = $email;
$expires = '';
$docreatefeu = 1;

if( $this->GetPreference('allowpaidregistration') ) {
  // we're doing paid registration.
  // first, get the package info.
  $pkgid = $params['pkg'];
  if( is_array($pkgid) ) $pkgid = $pkgid[0];
  $query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_paidpkgs WHERE gid = ? AND id = ?';
  $pkg = $db->GetRow($query,array($params['group_id'],$pkgid));
  $expires = selfreg_utils::pkg_subscr_to_expirydate($pkg);
  if( $pkg && $pkg['cost'] > 0 ) {
    // this package costs money.
    $cart = cg_ecomm::get_cart_module();
    if( $cart ) {
      $redirect_pref = 'redirect_paidpkg';
      
      // now we gotta add an item to the cart.
      $item = new cg_ecomm_cartitem('',$tmpuid,1,$this->GetName());
      $item->set_type(cg_ecomm_cartitem::TYPE_SERVICE);
      $item->set_base_price($pkg['cost']);
      $smarty->assign('tmpuid',$tmpuid);
      $smarty->assign('username',$username);
      $smarty->assign('pkg',$pkg);
      $sku = 'sr-'.sprintf('%03d-%05d',$pkg['id'],$tmpuid);
      $smarty->assign('sku',$sku);
      $tmp = '{sitename} membership {$tmpuid}';
      $tpl = $this->GetPreference('cartitem_summary_tpl');
      if( !$tpl ) $tpl = $tmp;
      
      $item->set_sku($sku);
      $item->set_summary($this->ProcessTemplateFromData($tpl));
      $item->set_item_total($pkg['cost']);
      $subscription = new cg_ecomm_productinfo_subscription();
      switch( $pkg['subscr_type'] ) {
      case 'year':
	if( $pkg['subscr_num'] != 1 ) $this->Audit('',$this->GetName(),'Invalid Subscription package (more than one yer)');
	$subscription->set_payperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_YEARLY);
	$subscription->set_deliveryperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_YEARLY);
	break;
      case 'month':
	switch( $pkg['subscr_num'] ) {
	case 1:
	  $subscription->set_payperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_MONTHLY);
	  $subscription->set_deliveryperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_MONTHLY);
	  break;
	case 3:
	  $subscription->set_payperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_QUARTERLY);
	  $subscription->set_deliveryperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_QUARTERLY);
	  break;
	case 6:
	  $subscription->set_payperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_SEMIANUALLY);
	  $subscription->set_deliveryperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_SEMIANUALLY);
	  break;
	case 12:
	  $subscription->set_payperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_YEARLY);
	  $subscription->set_deliveryperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_YEARLY);
	  break;
	default:
	  // error;
	  $this->Audit('',$this->GetName(),'Invalid Subscription package (wierd number of months)');
	  $subscription->set_payperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_MONTHLY);
	  $subscription->set_deliveryperiod(cg_ecomm_productinfo_subscription::SUBSCR_PERIOD_MONTHLY);
	  break;
	}
	break;
      }
      $subscription->set_expiry(-1);
      $item->set_subscription($subscription);

      try {
	$res = $cart->AddCartItem($item);
	if( $res !== TRUE ) $res = FALSE;
	$docreatefeu = 0;
      }
      catch( Exception $e ) {
	die('got exception '.$e->GetMessage());
	$res = FALSE;
      }

      if( $res !== FALSE ) {
	// couldn't add this item to the cart (maybe the policy got in the way)
	// so redirect back to the start.
	// and display a message?
	$this->DeleteTempUser( $tmpuid );
	$this->DeleteTempUserProperties( $tmpuid );
	
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_policycantadd');
	return $this->myRedirect( $id, 'default', $returnid, $params );
      }
    }
  }

  // if we get here either the cost is 0 or there is some problem with the cart
  // so we just proceed like normal.
}


if( $this->GetPreference('require_email_confirmation',1) ) {
  // okay, we're now ready to send the email, yahoo, yahoo, yahoo
  // now we have to decide what goes in it.
  $this->_SendUserConfirmationEmail($id,$returnid,$email, $username, $code );
  
  // send an event
  $this->SendEvent('onNewUser',array('username'=>$username,'email'=>$email));

  // we're not redirecting anywhere we need to display some nice message
  // about we just spammed your inbox, etc, etc.
}
else if ($docreatefeu) {
  $action = 'post_createuser';
    
  // it appears we're allowing instant registration
  $result = $this->_CreateFrontendUser( $tmpuid, $username, $password, $expires ); // do not do md5 stuff.
    
  if( $result[0] == FALSE ) {
    $params['error'] = 1;
    $params['message'] = $result[1];
    return $this->myRedirect( $id, 'default', $returnid, $params );
  }
  
  // woohooo, the user be created (hopefully).
  // delete the records from the SelfReg tables
  $this->DeleteTempUserProperties( $tmpuid );
  $this->DeleteTempUser( $tmpuid );
  
  // do we automatically log this user in?
  if( $this->GetPreference('login_afterverify') ) {
    $feu = $this->GetModuleInstance('FrontEndUsers');
    if( $result[1] != $feu->LoggedInId() ) {
      $res = $feu->Login( $username, $password );
      if( is_array($res) && $res[0] == FALSE ) $this->Audit('',$this->GetName(),'Problem with auto-login: '.$res[1]);
    }
  }

  // send an event
  $this->SendEvent('onNewUser',array('username'=>$username,'email'=>$email));
 }

// Check if we have to redirect to a page or not
$destpagestr = '';
if( isset($params['destpage']) ) {
  $destpagestr = trim($params['destpage']);
}
else {
  $destpagestr = $this->ProcessTemplateFromData($this->GetPreference($redirect_pref));
}

if( strlen($destpagestr) > 0 ) {
  $contentops = $gCms->GetContentOperations();
  $destpageid = $contentops->GetPageIDFromAlias($destpagestr);
  if( $destpageid == FALSE ) {
    $tmpalias = $contentops->GetPageAliasFromID($destpagestr);
    if( $tmpalias ) $destpageid = $tmpalias;
  }
  if( $destpageid ) $returnid = $destpageid;
}

if( (isset($params['nofinalmessage']) && $params['nofinalmessage']) ||
    $this->GetPreference('selfreg_skip_final_msg') || $this->GetPreference('allowpaidregistration') ) {
  if( isset($params['orig_url']) && empty($destpagestr) ) {
    redirect($params['orig_url']);
    return;
  }
  $this->RedirectContent($returnid);
  return;
}

$this->Redirect($id,$action,$returnid,$parms);

#
# EOF
#
?>
