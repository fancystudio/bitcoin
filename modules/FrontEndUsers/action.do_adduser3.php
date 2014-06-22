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
if( !isset($gCms) ) exit;
if( !$this->_HasSufficientPermissions( 'adduser' ) ) {
  return;
}

$step1_params = '';
$step1_params_orig = '';
if( isset($params['step1_params']) ) {
  $step1_params_orig = $params['step1_params'];
  $step1_params = unserialize(base64_decode($params['step1_params']));
  unset($params['step1_params']);
}

// do we want to go back
if( isset( $params['back'] ) ) {
  // yup we do
  $params = $step1_params;
  $this->myRedirect( $id, 'adduser', $returnid, $params, true );
}
if( isset( $params['cancel'] ) ) {
  // yup we do
  $this->RedirectToTab( $id, 'users', $params );
}


// get field definitions.
$defns = $this->GetPropertyDefns();

// get the property relations for the selected group(s).
$parms1 = $step1_params;
$groupprops = array();
$groupids = array();
foreach( $parms1 as $key => $value ) {
  if( startswith($key,'memberof_') ) {
    $gid = (int)substr($key,strlen('memberof_'));
    $groupids[] = $gid;
    
    $relns = $this->GetGroupPropertyRelations( $gid );
    $groupprops = RRUtils::array_merge_by_name_required( $groupprops, $relns );
    uasort( $groupprops,array('cge_array','compare_elements_by_sortorder_key') );
  }
}
$groupprops = cge_array::to_hash($groupprops,'name');

// get the field info
$fieldlist = array();
foreach( $params as $k => $v ) {
  if( preg_match('/^hidden_/', $k ) ) {
    $fldname = substr( $k, strlen('hidden_'));
    $fieldlist[$fldname] = $v;
  }
}

// now merge form values for each of the fields
foreach( $fieldlist as $fldname => $passed_value ) {
  $v = '';
  switch($defns[$fldname]['type']) {
  case '8': // date
    if( isset($params['input_'.$fldname.'Month']) ) {
      $v = mktime(0,0,0,
		  (int)$params['input_'.$fldname.'Month'],
		  (int)$params['input_'.$fldname.'Day'],
		  (int)$params['input_'.$fldname.'Year']);
    }
    break;

  default:
    if( isset($params['input_'.$fldname]) ) {
      $v = $params['input_'.$fldname];
    }
    break;
  }
  if( $v != '' ) $fieldlist[$fldname] = $v;
}

// now validate
foreach( $fieldlist as $name => $value ) {
  // process empty required fields
  // we don't care about empty optional ones
  $defn =& $defns[$name];
  $reln =& $groupprops[$name];

  if( $reln['required'] == 2 ) {
    // required field.
    if( $defn['type'] == 6 ) { // Image field
      if( (!isset($_FILES[$id.'input_'.$name]) || $_FILES[$id.'input_'.$name]['size'] == 0) &&
	  $value == '') {
	// a required field is empty
	$params = $step1_params;
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_missing_required_param',$name);
	$this->myRedirect( $id, 'do_adduser2', $returnid, $params, true );
	return;
      }
    }
    else if( $value == '' ) {
      // a required field is empty
      $params = $step1_params;
      $params['error'] = 1;
      $params['message'] = $this->Lang('error_missing_required_param',$name);
      $this->myRedirect( $id, 'do_adduser2', $returnid,$params, true );
      return;
    }
  }
  
  // validate filled in fields
  // and do post processing
  if( $value != '' && $defn['type'] != 6 ) {
    // validate unique values
    if( $defn['force_unique'] ) {
      // make sure that this value doesn't already exist
      if( !$this->IsUserPropertyValueUnique(-1,$name,$value) ) {
	$params = $step1_params;
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_nonunique_field_value',$name,$value);
	$this->myRedirect( $id, 'do_adduser2', $returnid,$params, true );
	return;
      }
    }

    switch( $defn['type'] ) {
    case 0: // text
      // not much we can do to validate a text field.
      break;

    case 1: // checkbox
      // or a checkbox
      break;

    case 2: // email
      // email addresses can be validated though
      $res = $this->IsValidEmailAddress($value,-1,TRUE);
      if( !is_array($res) || $res[0] == FALSE ) {
	$params = $step1_params;
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_emailalreadyused');
	$this->myRedirect( $id, 'do_adduser2', $returnid,$params, true );
	return;
      }
      break;

    case 3: // textarea
      // a textarea can be validated for length.
      break;

    case 4: // dropdown
    case 5: // multiselect
      // how can we validate a dropdown?
      break;

    case 6: // image
      // image types don't have a param (even if we have uploaded a file)
      break;
    }
  }
}


// get the parms from the first step
// and merge em into $params so we can actually add the user account
$params = array_merge( $params, $step1_params );

if( !isset($params['input_username']) || $params['input_username'] == '' ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_insufficientparams');
  $this->myRedirect( $id, 'do_adduser2', $returnid,$params, true );
  return;
}

// now we can actually add the user
$ret = $this->AddUser( $params['input_username'], 
		       $params['input_password'],
		       $params['input_expiresdate'] );
if( $ret[0] == FALSE ) {
  $params['error'] = 1;
  $params['message'] = $ret[1];
  $this->myRedirect( $id, 'do_adduser2', $returnid,$params, true );
  return;
}
$uid = $ret[1];

// and add him to his groups
foreach( $groupids as $mem ) {
  if( !$this->AssignUserToGroup( $uid, $mem ) ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_invalidgroupid',$mem);
    $this->myRedirect( $id, 'do_adduser2', $returnid,$params, true );
    return;
  }
}

// and add his properties
$this->SetEncryptionKey($uid);
foreach( $fieldlist as $k => $v ) {
  $defn =& $defns[$k];
  $reln =& $groupprops[$v];
	
  if( $defn['type'] == 6 ) {
    // image type
    if( isset($_FILES[$id.'input_'.$k]) && $_FILES[$id.'input_'.$k]['size'] > 0 ) {
      // it's an uploaded file type
      $result = $this->ManageImageUpload($id,'input_', $k, $uid );
      if( $result[0] == false ) {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error').'&nbsp;'.$result;
	$this->myRedirect( $id, 'do_adduser2', $returnid,$params, true );
	return;
      }
      $v = $result[1];
    }
  }

  if( $v == '' ) continue;
  if( is_array( $v ) ) $v = implode(',',$v);
  $ret = $this->SetUserPropertyFull( $k, $v, $uid );
  if( $ret == false ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error');
    $this->myRedirect( $id, 'do_adduser2', $returnid, $params, true );
    return;
  }
}

// send an event
$parms = array();
$parms['id'] = $uid;
$parms['name'] = $params['input_username'];
$this->SendEvent('OnCreateUser',$parms);
$this->_SendNotificationEmail('OnCreateUser',$parms);

// keep a log of it
audit( $uid, $this->Lang('friendlyname'),'Added User '.$params['input_username'].' ('.$uid.')');

// and that should be it
$params = $step1_params;

if( isset($params['returnto']) ) {
  if( strpos($params['returnto'],',') !== FALSE ) {
    list($module,$action) = explode(',',$params['returnto'],2);
    $module = $this->GetModuleInstance($module);
    $module->Redirect($id,$action,$returnid,
		      array('uid'=>$uid,'username'=>$params['input_username']));
  }
}
$this->RedirectToTab( $id, 'users', $params );

// EOF
?>