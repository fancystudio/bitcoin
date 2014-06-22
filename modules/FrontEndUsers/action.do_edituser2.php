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
if( !isset($gCms) ) return;
if( !$this->_HasSufficientPermissions('adduser') && !$this->_HasSufficientPermissions('editusers') ) return;

$tmp = $this->_session_to_params();
if( $tmp !== false ) $params = array_merge($params,$tmp);
if( isset( $params['message'] ) ) $smarty->assign('message', $params['message'] );
if( isset( $params['error'] ) ) $smarty->assign('error', $params['error'] );

$properties = array();
$groups = 0;
$grouplist = array();
$user_id = -1;
if( isset($params['user_id']) ) $user_id = (int)$params['user_id'];

foreach( $params as $key => $val ) {
  if( preg_match( '/^memberof_/', $key ) ) {
    $groups++;
    // get the groupid from the checkbox
    $grpid = substr($key,strlen('memberof_'));
    $grouplist[] = (int)$grpid;
  }
}	  
if( $groups == 0 ) {
  // here, we haven't been told about membership in any groups yet
  // maybe our consumer will tell us about one.
  $consumer = feu_utils::get_auth_consumer();
  if( $consumer->has_capability($consumer::CAPABILITY_GROUPMEMBERSHIP) ) {
    $grouplist = $consumer->get_group_membership($user_id);
    if( is_array($grouplist) && count($grouplist) )  $groups = count($grouplist);
  }
}
if( $groups == 0 ) {
  // final handling of no groups situation.
  $consumer = feu_utils::get_auth_consumer();
  if( $this->GetPreference('require_onegroup') == 1 && get_class($consumer) == 'feu_std_consumer' ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_onegrouprequired');
    $this->myRedirect( $id, 'adduser', $returnid, $params, true );
    return;
  }

  // don't need to ask about any properties... so lets finish it off.
  if( $user_id > 0 ) {
    $this->myRedirect( $id, 'do_edituser3', $returnid, $params, true );
  }
  else {
    $this->myRedirect( $id, 'do_adduser3', $returnid, $params, true );
  }
}

// calculate the union (yep, union, not intersection)
// of all of the properties of all of the member groups
// preferring all items with a priority of 2
foreach( $grouplist as $grpid ) {
  // have the group id, now get a list of the properties
  $proprelations = $this->GetGroupPropertyRelations( $grpid );
  $properties = RRUtils::array_merge_by_name_required( $properties, $proprelations );
}
uasort( $properties, array('cge_array','compare_elements_by_sortorder_key') );

if( count($properties) == 0 ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_properties');
  $this->myRedirect( $id, 'adduser', $returnid, $params, true );
  return;
}

// now we're ready to populate the template
$rowarray = array();
foreach( $properties as $prop ) {
  // get the property definition
  $defn = $this->GetPropertyDefn( $prop['name'] );
  if( $defn['encrypt'] ) continue;
  $attribs = '';
  if( isset($defn['attribs']) ) $attribs = unserialize($defn['attribs']);

  // default value for the property.
  $propval = '';
  switch( $defn['type'] ) {
  case 1:
    if( isset($attribs['checked']) ) $propval = $attribs['checked'];
    break;
  }

  if( $user_id > 0 ) {
    $this->SetEncryptionKey($user_id);
    $propval = $this->GetUserPropertyFull( $prop['name'], $user_id );
  }

  $onerow = new StdClass();

  $color = '';
  if( $prop['required'] == 2 ) $color = $this->GetPreference('requried_field_color','blue');
  if( $prop['required'] == 3 ) $color = $this->GetPreference('hidden_field_color','green');
  $marker = '';
  if( $prop['required'] == 2 ) $marker = $this->GetPreference('requried_field_marker','*');
  if( $prop['required'] == 3 ) $marker = $this->GetPreference('hidden_field_marker','!!');
  $onerow->required = ($prop['required'] == 2);
  $onerow->type     = $defn['type'];
  $onerow->color    = $color;
  $onerow->marker   = $marker;
  $onerow->hidden = RRUtils::myCreateInputHidden($id,'hidden_'.$prop['name'],$propval);

  $val = isset($params['input_'.$prop['name']]) ? $params['input_'.$prop['name']] : $propval;
  $val = urldecode($val);
  $seloptions = $this->GetSelectOptions($prop['name']);
  $selected = array();
  if( $defn['type'] == 5) {
    // handle comma separated arrays of selected values
    if( strpos($val,',') !== FALSE ) {
      $selected = explode(',',$val);
    }
    else if( strpos($val,':') !== FALSE ) {
      $selected = explode(':',$val);
    }
  }
  else if ($defn['type'] == 7) {
    $selected = $val;
  }

  $onerow->prompt = $defn['prompt'];
  switch( $defn['type'] ) {
  case 0: // text
    $onerow->control = $this->CreateInputText( $id, 'input_'.$prop['name'],$val, $defn['length'], $defn['maxlength'] );
    break;

  case 1: // checkbox
    $onerow->control = $this->CreateInputHidden($id, 'input_'.$prop['name'], 0) . 
      RRUtils::myCreateInputCheckbox( $id, 'input_'.$prop['name'], 1, $val );
    break;

  case 2: // email
    $onerow->control = $this->CreateInputText( $id, 'input_'.$prop['name'], $val, $defn['length'], $defn['maxlength'] );
    break;

  case 3: // textarea
    $onerow->control = $this->CreateTextArea(is_array($attribs) && isset($attribs['wysiwyg'])?$attribs['wysiwyg']:0,
					     $id, $val, 'input_'.$prop['name']);
    break;

  case 4: // dropdown
    $onerow->control = $this->CreateInputDropdown($id, 'input_'.$prop['name'], $seloptions,-1, $val);
    break;

  case 5: // multiselect
    $onerow->control = $this->CreateInputSelectList($id, 'input_'.$prop['name'].'[]', $seloptions, $selected, $defn['length']);
    break;

  case 6: // image
    if( $user_id > 0 ) {
      $destDir1 = $gCms->config['uploads_path'].DIRECTORY_SEPARATOR;
      $destDir1 .= $this->GetPreference('image_destination_path','feusers').DIRECTORY_SEPARATOR;
      $destDir2 = $gCms->config['uploads_url'].DIRECTORY_SEPARATOR;
      $destDir2 .= $this->GetPreference('image_destination_path','feusers').DIRECTORY_SEPARATOR;
      $file1 = $destDir1.$val;
      $file2 = $destDir2.$val;
      if( is_readable($file1) && is_file($file1) ) {
	// TODO: here we could ideally resize the image using CGSI.. but later.
	$onerow->image = '<img src="'.$file2.'" alt="'.$val.'"/>';
	if( !$onerow->required  && isset($user_id) ) {
	  $onerow->prompt2 = $this->Lang('prompt_clear');
	  $onerow->control2 = $this->CreateInputCheckbox($id,'input_'.$prop['name'].'_clear','clear','');
	}
      }
    }
    $onerow->control = $this->CreateFileUploadInput($id,'input_'.$prop['name'], '', $defn['length']);
    break;

  case 7: // radio button group
    $onerow->control = $this->CreateInputRadioGroup($id, 'input_'.$prop['name'], $seloptions, $val, '', '<br/>');
    break;

  case 8: // date
    $parms = array();
    $parms['prefix'] = $id.'input_'.$prop['name'];
    if( $val )  $parms['time'] = $val;
    $parms['start_year'] = (is_array($attribs) && isset($attribs['startyear']))?$attribs['startyear']:"-5";
    $parms['end_year'] = (is_array($attribs) && isset($attribs['endyear']))?$attribs['endyear']:"+10";
    $str = '{html_select_date ';
    foreach( $parms as $key=>$value ) {
      $str .= $key.'="'.$value.'" ';
    }
    $str .= '}';
    $onerow->control = $this->ProcessTemplateFromData($str);
    break;
  }

  $rowarray[] = $onerow;
}

if( isset($params['input_username']) ) {
  $smarty->assign('edittext',$this->Lang('editing_user'));
  $smarty->assign('username',trim($params['input_username']));
}
$smarty->assign('hidden', RRUtils::myCreateInputHidden( $id, 'step1_params', base64_encode(serialize($params)) ));
$smarty->assign('controls', $rowarray);
$smarty->assign('controlcount', count($rowarray));
$smarty->assign('submit',$this->CreateInputSubmit($id,'submit', $this->Lang('submit')));
$smarty->assign('cancel',$this->CreateInputSubmit($id,'cancel', $this->Lang('cancel')));
$smarty->assign('back',$this->CreateInputSubmit($id,'back', $this->Lang('back')));
if( $user_id > 0 ) {
  $smarty->assign('title', $this->Lang('edituser'));
  $smarty->assign('hidden2', $this->CreateInputHidden($id,'user_id',$user_id));
  $smarty->assign('startform', $this->CreateFormStart ($id,'do_edituser3',$returnid,'post', 'multipart/form-data'));
}
else {
  $smarty->assign('title', $this->Lang('adduser'));
  $smarty->assign('startform', $this->CreateFormStart ($id,'do_adduser3',$returnid,'post', 'multipart/form-data'));
}
    
$smarty->assign('endform', $this->CreateFormEnd ());
echo $this->ProcessTemplate( 'adduser2.tpl' );

#
# EOF
#
?>