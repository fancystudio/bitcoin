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

$params = selfreg_utils::clean_params($params);

// if( $this->GetPreference('allowselectpkg') && !isset($params['group'])) {
//   // we're allowing paid registration, but don't have a package/group specified
//   // so we need to ask it.
//   $this->DoAction('selpkg',$id,$params,$returnid);
//   return;
// }

if( !isset( $params['group'] ) ) {
  // this is ugly for the user to see
  // but at least the admin will be able to figure it out
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_insufficientparams'));
  return;
}

$feusers = $this->GetModuleInstance('FrontEndUsers');
$cmsmailer = $this->GetModuleInstance('CMSMailer');
if( !$cmsmailer ) {
  // this is ugly for the user to see
  // but at least the admin will be able to figure it out
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_nofeusersmodule'));
  return;
}

// yep, all the modules are here, now we convert a single name to an integer id
// or an array of integer ids... then we validate them.
$grpids = selfreg_utils::expand_group($params['group']);
if( !count($grpids) ) {
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_novalidgroups'));
  return;
}

// now we have an id... have to get a list of the groups properties
$relations = array();
foreach( $grpids as $gid ) {
  $grelns = $feusers->GetGroupPropertyRelations( $gid );
  $relations = RRUtils::array_merge_by_name_required($relations,$grelns);
  uasort( $relations, 'cge_array::compare_elements_by_sortorder_key');
}
// now we merge in property info
$defns = $feusers->GetPropertyDefns();
foreach( $relations as &$oneprop ) {
  foreach( $defns as $onedefn ) {
    if( $onedefn['name'] == $oneprop['name'] ) {
      $oneprop['prompt'] = $onedefn['prompt'];
      $oneprop['type'] = $onedefn['type'];
      break;
    }
  }
}

// now we have the properties, gotta show something to the user
// dammit.
if( isset( $params['error'] ) ) $smarty->assign('error', $params['error']);
if( isset( $params['message'] ) ) $smarty->assign('message', $params['message']);

// now we're ready to populate the template
// first we put in stuff that is required (username, password, etc, etc)
$rowarray = array();

// make sure username is in there
$onerow = new StdClass();
$onerow->color = $feusers->GetPreference('required_field_color','blue');
$onerow->marker = $feusers->GetPreference('required_field_marker','*');
$onerow->required = 1;
$val = (isset($params['input_username'])) ? $params['input_username'] : '';
$onerow->prompt = $feusers->GetUsernamePrompt();
$onerow->name = 'username';
$onerow->control = $this->CreateInputText($id, 'sr_input_username', $val,
					  $feusers->GetPreference('usernamefldlength'),
					  $feusers->GetPreference('max_usernamelength'));
$rowarray[$onerow->name] = $onerow;

if( $this->GetPreference('selfreg_force_email_twice' ) && $feusers->GetPreference('username_is_email') ) {
  // add it again
  $onerow = new StdClass();
  $onerow->color = $feusers->GetPreference('required_field_color','blue');
  $onerow->marker = $feusers->GetPreference('required_field_marker','*');
  $onerow->required = 1;
  $val = (isset($params['input_username_again'])) ? $params['input_username_again'] : '';

  if ($feusers->GetPreference('username_is_email')) {
    $onerow->prompt = $this->Lang('email');
  }
  else {
    $onerow->prompt = $this->Lang('username');
  }
  $onerow->prompt .= ' ('.$this->Lang('again').')';
  $onerow->name = 'username_again';
  $onerow->control =$this->CreateInputText($id, 'sr_input_username_again', $val,
					   $feusers->GetPreference('usernamefldlength'),
					   $feusers->GetPreference('max_usernamelength'));
  $rowarray[$onerow->name] = $onerow;
}


// and password
$onerow = new StdClass();
$onerow->color = $feusers->GetPreference('required_field_color','blue');
$onerow->marker = $feusers->GetPreference('required_field_marker','*');
$onerow->required = 1;
$val = (isset($params['input_password'])) ? $params['input_password'] : '';
$onerow->prompt = $this->Lang('password');
$onerow->name = 'password';
$onerow->control =$this->CreateInputPassword($id, 'sr_input_password', $val,
					     $feusers->GetPreference('passwordfldlength'),
					     $feusers->GetPreference('max_passwordlength'));
$rowarray[$onerow->name] = $onerow;

// and make him repeat the password
$onerow = new StdClass();
$onerow->color = $feusers->GetPreference('required_field_color','blue');
$onerow->marker = $feusers->GetPreference('required_field_marker','*');
$onerow->required = 1;
$val = (isset($params['input_repeatpassword'])) ? $params['input_repeatpassword'] : '';
$onerow->prompt = $this->Lang('repeatpassword');
$onerow->name = 'repeatpassword';
$onerow->control =$this->CreateInputPassword($id, 'sr_input_repeatpassword', $val,
					     $feusers->GetPreference('passwordfldlength'),
					     $feusers->GetPreference('max_passwordlength'));
$rowarray[$onerow->name] = $onerow;

$relations2 = array();
$done_email_reqd = FALSE;
foreach( $relations as $reln ) {
  if( $reln['type'] == 6 || $reln['type'] ==  9 ) {
    // images and data fields are ignored. user can fill them in after registration
    continue;
  }
  if( $reln['required'] == 3 ) continue; // ignore hidden fields.

  if( $reln['type'] == 2 && !$done_email_reqd) {
    // email
    $done_email_reqd = TRUE;
    if( !$feusers->GetPreference('username_is_email') ) {
      // gotta have an email address, force it to be required.
      $reln['required'] = 2;
    }
    $relations2[] = $reln;
    if( $this->GetPreference('selfreg_force_email_twice') ) {
      $reln['mapto'] = $reln['name'];
      $reln['name'] = $reln['name'].'_again';
      $relations2[] = $reln;
    }
    continue;
  }
  else {
    $relations2[] = $reln;
  }
}

// convert relations to properties.
foreach( $relations2 as $reln ) {
  // get the property definition
  $defn = null;
  if( isset($reln['mapto']) ) {
    $defn = $feusers->GetPropertyDefn( $reln['mapto'] );
  }
  else {
    $defn = $feusers->GetPropertyDefn( $reln['name'] );
  }
  $attribs = null;
  if( isset($defn['attribs']) ) $attribs = unserialize($defn['attribs']);

  $color = '';
  $marker = '';
  if( $defn['encrypt'] ) {
    $color = $this->GetPreference('secure_field_color','yellow');
    $marker = $this->GetPreference('secure_field_marker','^^');
  }
  if( $reln['required'] == 2 ) $color = $feusers->GetPreference('required_field_color','blue');
  if( $reln['required'] == 2 ) $marker = $feusers->GetPreference('required_field_marker','*');
  $onerow = new StdClass();
  $onerow->required = ($reln['required'] == 2);
  $onerow->color    = $color;
  $onerow->marker   = $marker;
  $onerow->prompt = $reln['prompt'];
  $onerow->name = $reln['name'];
  $onerow->labelfor = $id.$reln['name'];

  $val = '';
  // default values for fields...
  switch( $defn['type'] ) {
  case 1:
    if( isset($attribs['checked']) ) $val = $attribs['checked'];
    break;
  }
  $val = isset($params['input_'.$reln['name']]) ? $params['input_'.$reln['name']] : $val;

  switch( $defn['type'] ) {
  case 0: // text
    $onerow->control = $this->CreateInputText( $id, 'sr_input_'.$reln['name'],
					       $val, $defn['length'], $defn['maxlength'] );
    break;

  case 1: // checkbox
    $onerow->control = SelfregUtils::myCreateInputCheckbox( $id, 'sr_input_'.$reln['name'], 1, $val );
    break;

  case 2: // email
    $onerow->control = $this->CreateInputText( $id, 'sr_input_'.$reln['name'],
					       $val, $defn['length'], ($defn['maxlength']) );
    break;

  case 3: // textarea
    $onerow->control = $this->CreateTextArea(false, $id, $val, 'sr_input_'.$reln['name']);
    break;

  case 4: // dropdown
    $onerow->control = $this->CreateInputDropdown($id,'sr_input_'.$reln['name'],
						  $feusers->GetSelectOptions($defn['name'], 1),
						  -1, $val);
    break;

  case 5: // multiselect
    $tmp = $feusers->GetSelectOptions($defn['name'],1);
    if( !is_array($val) ) $val = array($val);
    $onerow->control = $this->CreateInputSelectList($id,'sr_input_'.$defn['name'].'[]',$tmp,$val, min(count($tmp),5));
    break;

  case 7: // radio buttons
    $onerow->control = $this->CreateInputRadioGroup($id, 'sr_input_'.$defn['name'],
						    $feusers->GetSelectOptions($defn['name'], 1), 
						    $val, '', '<br/>');
    break;

  case 8: // date field
    $attribs = unserialize($defn['attribs']);
    $parms = array();
    $parms['prefix'] = $id.'sr_input_'.$defn['name'];
    if( $val ) $parms['time'] = $val;
    $parms['start_year'] = (isset($attribs['startyear']))?$attribs['startyear']:"-5";
    $parms['end_year'] = (isset($attribs['endyear']))?$attribs['endyear']:"+10";
    $str = '{html_select_date ';
    foreach( $parms as $key=>$value ) {
      $str.=$key.'="'.$value.'" ';
    }
    $str .= '}';
    $onerow->control = $this->ProcessTemplateFromData($str);
    break;
  }

  $rowarray[$onerow->name] = $onerow;
}

$inline = $this->GetPreference('inline_forms',true);
if( isset($params['noinline']) ) $inline = false;

// and the rest of the stuff
$smarty->assign('startform', $this->CreateFormStart($id, 'reguser', $returnid, 'post', '', $inline));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('title',$this->Lang('user_registration'));

$allow_overwrite = (isset($params['allowoverwrite']))?$params['allowoverwrite']:0;
$tmp = array();
$tmp['orig_url'] = cge_url::current_url();
$tmp['pkg'] = (isset($params['pkg']))?$params['pkg']:'';
$tmp['group'] = $params['group'];
$tmp['allowoverwrite'] = $allow_overwrite;
if( isset($params['nofinalmessage']) ) $tmp['nofinalmessage'] = $params['nofinalmessage'];
if( isset($params['destpage']) ) $tmp['destpage'] = $params['destpage'];
$tmp2 = $this->CreateInputHidden($id,'sr_data',base64_encode(serialize($tmp)));

$smarty->assign('hidden',$tmp2);
$smarty->assign('controls', $rowarray);
$smarty->assign('controlcount', count($rowarray));
$smarty->assign('submit',$this->CreateInputSubmit($id,'sr_submit', $this->Lang('submit')));
$smarty->assign('msg_sendanotheremail', $this->Lang('msg_sendanotheremail'));
$smarty->assign('link_sendanotheremail',
		$this->CreateLink($id,'default',$returnid,$this->Lang('clickhere'),
				  array('mode'=>'sendanotheremail'),'',false,true));

$captcha = $this->GetModuleInstance('Captcha');
if( is_object($captcha) && !isset($params['nocaptcha']) ) {
  $smarty->assign('captcha_title', $this->Lang('captcha_title'));
  $smarty->assign('captcha', $captcha->getCaptcha());
  $smarty->assign('input_captcha', $this->CreateInputText($id,'sr_input_captcha','',10));
}

// todo, put this into the database and let the admin play with it.
echo $this->ProcessTemplateFromDatabase('selfreg_reg1template');

#
# EOF
#
?>