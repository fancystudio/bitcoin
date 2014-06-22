<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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
$gCms = cmsms();

$can_changepasswd = TRUE;
$consumer = feu_utils::get_auth_consumer();
$can_changepasswd = $consumer->has_capability(feu_auth_consumer::CAPABILITY_CHANGEPASSWD);

if( $consumer->has_capability(feu_auth_consumer::CAPABILITY_CHANGESETTINGS) ) {
  // the consumer provides the login capabilities
  echo $consumer->get_changesettings_display($id,$returnid,$params);
  return;
}
else if( !$consumer->has_capability(feu_auth_consumer::CAPABILITY_USESTDCHANGESETTINGS) ) {
  return;
}

$uid = $this->LoggedInId();
if( $uid == false ) {
  // user isn't logged in
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_notloggedin'));
  return;
}
$result = $this->GetUserInfo( $uid );
if( $result[0] == FALSE ) {
  // user isn't logged in
  $this->_DisplayErrorPage( $id, $params, $returnid, $result[1]);
  return;
}
$uinfo = $result[1];

if( isset( $params['error'] ) ) $this->smarty->assign('error', $params['error'] );
if( isset( $params['message'] ) ) $this->smarty->assign('message', $params['message'] );

// get the users member groups
$groups = $this->GetMemberGroupsArray( $uid );
if( !$groups ) {
  // this user is not a member of any gruops...
  // handle this later todo
  $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_nogroups'));
  return;
}

// now we have the groups, we build a union of all of the groups properties
$properties = array();
foreach( $groups as $grprecord ) {
  $gid = $grprecord['groupid'];
  $proprelations = $this->GetGroupPropertyRelations( $gid );
  if( is_array($proprelations) && count($proprelations) == 2 && $proprelations[0] === FALSE ) continue;
  if( count($properties) ) {
    $properties = RRUtils::array_merge_by_name_required( $properties, $proprelations );
  } else {
    $properties = $proprelations;
  }
}
uasort($properties, array('cge_array','compare_elements_by_sortorder_key'));

if( count($properties) == 0 ) {
  if( $this->GetPreference('require_onegroup') == 1 ) {
    // this user is not a member of any gruops...
    // handle this later todo
    $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_onegrouprequired'));
    return;
  }
}

// now we're ready to populate the template
// first we put in stuff that is required (username, password, etc, etc)
$rowarray = array();

// make sure username is in there
// we can hide it in the template.
$val = $uinfo['username'];
$onerow = new StdClass();
$onerow->name = 'username';
$onerow->type = 0;
$onerow->color = $this->GetPreference('required_field_color','blue');
$onerow->marker = $this->GetPreference('required_field_marker','*');
$onerow->required = 1;
$onerow->prompt = $consumer->get_username_prompt();
$onerow->value = $val;
$onerow->input_id = 'feu_input_username';
$onerow->input_name = $id.$onerow->input_id;
$onerow->length = $this->GetPreference('usernamefldlength',40);
$onerow->maxlength = $this->GetPreference('max_usernamelength',80);
$onerow->readonly = (!$consumer->has_capability(feu_auth_consumer::CAPABILITY_CHANGEUSERNAME));

$tmp = 'disabled="disabled"';
if( $consumer->has_capability(feu_auth_consumer::CAPABILITY_CHANGEUSERNAME) ) $tmp = '';
$onerow->control = $this->CreateInputText($id, 'feu_input_username', $val, $onerow->length, $onerow->maxlength, $tmp);
$rowarray[$onerow->name] = $onerow;

if( $can_changepasswd ) {
  // and password
  $val = '';
  if( isset( $params['feu_input_password'] ) ) $val = $params['feu_input_password'];
  $onerow = new StdClass();
  $onerow->name = 'password';
  $onerow->type = 'password';
  $onerow->color = $this->GetPreference('required_field_color','blue');
  $onerow->marker = $this->GetPreference('required_field_marker','*');
  $onerow->required = 1;
  $onerow->prompt = $this->Lang('password');
  $onerow->control = $this->CreateInputPassword($id, 'feu_input_password', $val,
                                               $this->GetPreference('passwordfldlength'),
                                               $this->GetPreference('max_passwordlength'));
  $onerow->addtext =$this->Lang('info_emptypasswordfield');
  $onerow->value = null;
  $onerow->input_id = 'feu_input_password';
  $onerow->input_name = $id.$onerow->input_id;
  $onerow->length = $this->GetPreference('passwordfldlength');
  $onerow->maxlength = $this->GetPreference('max_passwordlength');
  $onerow->readonly = false;
  $rowarray[$onerow->name] = $onerow;

  // and make him repeat the password
  $val = '';
  if( isset( $params['feu_input_repeatpassword'] ) ) $val = $params['feu_input_repeatpassword'];
  $onerow = new StdClass();
  $onerow->name = 'repeat_password';
  $onerow->type = 'password';
  $onerow->color = $this->GetPreference('required_field_color','blue');
  $onerow->marker = $this->GetPreference('required_field_marker','*');
  $onerow->required = 1;
  $onerow->prompt = $this->Lang('repeatpassword');
  $onerow->control =$this->CreateInputPassword($id, 'feu_input_repeatpassword', $val,
                                               $this->GetPreference('passwordfldlength'),
                                               $this->GetPreference('max_passwordlength'));
  $onerow->addtext =$this->Lang('info_emptypasswordfield');
  $onerow->value = null;
  $onerow->input_id = 'feu_input_repeatpassword';
  $onerow->input_name = $id.$onerow->input_id;
  $onerow->length = $this->GetPreference('passwordfldlength');
  $onerow->maxlength = $this->GetPreference('max_passwordlength');
  $onerow->readonly = false;
  $rowarray[$onerow->name] = $onerow;
}

$encrypt_color = $this->GetPreference('secure_field_color','yellow');
$encrypt_marker = $this->GetPreference('secure_field_marker','^^');


// now for the properties
$this->SetEncryptionKey($uid);
foreach( $properties as $prop ) {
  // get the property definition
  $defn = $this->GetPropertyDefn( $prop['name'] );

  if( $prop['required'] == 3 ) continue; // hidden.

  $onerow = new StdClass();
  $onerow->propname    = $prop['name'];
  $onerow->input_id    = 'feu_input_'.$onerow->propname;
  $onerow->input_name  = $id.$onerow->input_id;
  $val = $this->GetUserPropertyFull( $prop['name'], $uid );
  if( isset($params[$onerow->input_name]) ) $val=$params['feu_'.$onerow->input_name];


  // begin building the object that contains data for building the fields.
  $onerow->type        = $defn['type'];
  $onerow->encrypted   = $defn['encrypt'];
  $onerow->required    = ($prop['required'] == 2);
  $onerow->readonly    = ($prop['required'] == 4);
  $onerow->status      = $prop['required'];
  $onerow->color       = null;
  $onerow->marker      = null;;
  $onerow->value       = $val;
  $onerow->length      = $defn['length'];
  $onerow->maxlength   = $defn['maxlength'];
  $onerow->prompt      = $defn['prompt'];
  if( $defn['encrypt'] ) {
      $onerow->color = $encrypt_color;
      $onerow->marker = $encrypt_marker;
  }
  else if( $onerow->required ) {
      $onerow->color = $this->GetPreference('required_field_color','blue');
      $onerow->marker = $this->GetPreference('required_field_marker','*');
  }

  switch( $defn['type'] ) {
  case 0: // text
      $onerow->control = $this->CreateInputText( $id, 'feu_'.$onerow->input_name, $val, $defn['length'], $defn['maxlength'] );
      break;

  case 1: // checkbox
      $onerow->control  = $this->CreateInputHidden($id,'feu_'.$onerow->input_name,0);
      $onerow->control  .= RRUtils::myCreateInputCheckbox( $id, 'feu_'.$onerow->input_name, 1, $val);
      break;

  case 2: // email
      $onerow->control = $this->CreateInputText( $id, 'feu_'.$onerow->input_name, $val, $defn['length'], $defn['maxlength']);
      break;

  case 3: // textarea
      $flag = false;
      if( isset($defn['attribs']) && !empty($defn['attribs']) ) {
          $attribs = unserialize($defn['attribs']);
          if( is_array($attribs) && isset($attribs['wysiwyg']) ) $flag = $attribs['wysiwyg'];
      }
      $onerow->wysiwyg = $flag;
      $onerow->control = $this->CreateTextArea($flag, $id, $val, 'feu_'.$onerow->input_name);
      break;

  case 4: // dropdown
      $opts = $this->GetSelectOptions($defn['name']);
      $onerow->options = array_flip($opts);
      $onerow->control = $this->CreateInputDropdown($id, 'feu_'.$onerow->input_name, $opts, -1, $val);
      break;

  case 5: // multiselect
      $opts = $this->GetSelectOptions($defn['name']);
      $onerow->options = array_flip($opts);
      $selected = explode(',',$val);
      $onerow->control = $this->CreateInputSelectList($id, 'feu_'.$onerow->input_name.'[]', $opts, $selected, $defn['length']);
      break;

  case 6: // image
      $destDir1 = $gCms->config['uploads_path'].DIRECTORY_SEPARATOR;
      $destDir1 .= $this->GetPreference('image_destination_path','feusers').DIRECTORY_SEPARATOR;
      $destDir2 = $gCms->config['uploads_url'].'/';
      $destDir2 .= $this->GetPreference('image_destination_path','feusers').'/';
      $file1 = $destDir1.$val;
      $file2 = $destDir2.$val;
      if( is_readable( $file1 ) && is_file($file1) ) {
          $onerow->image_url = $file2;
          $onerow->image = '<img src="'.$file2.'" alt="'.$val.'"/>';
          if( !$onerow->required ) {
              $onerow->prompt2 = $this->Lang('prompt_clear');
              $onerow->input_name2 = $onerow->input_name . '_clear';
              $onerow->control2 = $this->CreateInputCheckbox($id, 'feu_'.$onerow->input_name.'_clear', 'clear','');
          }
      }
      $onerow->control = $this->CreateInputHidden($id,'feu_'.$onerow->input_name,$val).$this->CreateFileUploadInput($id,'feu_'.$onerow->input_name, '', $defn['length']);
      break;

  case '7': // radio group
      $opts = $this->GetSelectOptions($defn['name']);
      $onerow->options = array_flip($opts);
      $onerow->control = $this->CreateInputRadioGroup($id, 'feu_'.$onerow->input_name, $opts, $val, '', '<br/>');
      break;

  case '8': // date
    {
        $parms = array();
        $parms['prefix'] = $onerow->input_id;
        if( $val )  $parms['time'] = $val;
        $parms['start_year'] = "-5";
        $parms['end_year'] = "+10";

        if( isset($defn['attribs']) && !empty($defn['attribs']) ) {
            $attribs = unserialize($defn['attribs']);
            if( isset($attribs['startyear']) && !empty($attribs['startyear']) ) $parms['start_year'] = $attribs['startyear'];
            if( isset($attribs['endyear']) && !empty($attribs['endyear']) ) $parms['end_year'] = $attribs['endyear'];
        }

        $str = '{html_select_date ';
        foreach( $parms as $key=>$value ) {
            $str.=$key.'="'.$value.'" ';
        }
        $str .= '}';
        $onerow->control = $this->ProcessTemplateFromData($str);
    }
    break;
  }
  $rowarray[$prop['name']] = $onerow;
}

// fill in the variables for the template
$this->smarty->assign('title',$this->Lang('user_settings')); // deprecated
$this->smarty->assign('startform', $this->feCreateFormStart($id,'do_userchangesettings',$returnid, true, 'post', 'multipart/form-data' ));
$this->smarty->assign('endform', $this->CreateFormEnd());
$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'feu_submit',$this->Lang('submit'))); // deprecated

if( isset( $params['returnto'] ) ) $this->smarty->assign('hidden', $this->CreateInputHidden($id,'feu_returnto',$params['returnto']));
$this->smarty->assign('formid',$id);
$this->smarty->assign('controls', $rowarray);
$this->smarty->assign('controlcount', count($rowarray));

echo $this->ProcessTemplateFromDatabase('feusers_changesettingsform');

// EOF
?>