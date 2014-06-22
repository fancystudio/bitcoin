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
if( !$this->_HasSufficientPermissions( 'editusers' ) ) return;
if( !isset( $params['user_id'] ) ) {
  $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('error_insufficientparams'));
  return;
}

if( isset($params['step1_params']) ) $params['step1_params'] = unserialize(base64_decode($params['step1_params']));

// do we want to go back
if( isset( $params['back'] ) ) {
  // yup we do
  $params = $params['step1_params'];
  $this->myRedirect( $id, 'edituser', $returnid,$params );
}
if( isset($params['cancel']) ) $this->RedirectToTab($id, 'users' );

$user_id = (int)$params['user_id'];

// get field definitions.
$defns = $this->GetPropertyDefns();

// get the property relations for the selected group(s).
$groupprops = array();
$groupids = array();
if( isset($params['step1_params']) ) {
  $parms1 = $params['step1_params'];
  foreach( $parms1 as $key => $value ) {
    if( startswith($key,'memberof_') ) {
      $gid = (int)substr($key,strlen('memberof_'));
      $groupids[] = $gid;
    }
  }
}

if( count($groupids) == 0 ) {
  // here, we haven't been told about membership in any groups yet
  // maybe our consumer will tell us about one.
  $consumer = feu_utils::get_auth_consumer();
  if( $consumer->has_capability($consumer::CAPABILITY_GROUPMEMBERSHIP) ) {
    $groupids = $consumer->get_group_membership($user_id);
  }
}

foreach( $groupids as $gid ) {
  $relns = $this->GetGroupPropertyRelations( $gid );
  $groupprops = RRUtils::array_merge_by_name_required( $groupprops, $relns );
  uasort( $groupprops, array('cge_array','compare_elements_by_sortorder_key') );
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
foreach( $groupprops as $fldname => $reln ) {
  $v = '';
  switch($defns[$fldname]['type']) {
  case '6': // image
    // we'll handle setting the value for this below.... this is just a placeholder.
    $v = '::image::';
    break;

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

  $fieldlist[$fldname] = $v;
}

// now validate
foreach( $fieldlist as $name => $value )
{
    $defn = $defns[$name];
    $reln = $groupprops[$name];

    // process empty required fields
    // we don't care about empty optional ones
    if( $reln['required'] == 2 ) {
        // process empty required fields
        if( $defn['type'] == 6 ) {
            // image uploads?
            if( (!isset($_FILES[$id.'input_'.$name]) || $_FILES[$id.'input_'.$name]['size'] == 0) &&
                $value == '') {
                // a required image field is empty
                // and no file being uploaded.
                $params = $params['step1_params'];
                $params['error'] = 1;
                $params['message'] = $this->Lang('error_missing_required_param',$name);
                $this->myRedirect( $id, 'do_edituser2', $returnid,$params );
                return;
            }
        }
        else if( $value = '' ) {
            // a required other type field is empty
            $params = $params['step1_params'];
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_missing_required_param',$name);
            $this->myRedirect( $id, 'do_edituser2', $returnid,$params );
            return;
        }
    }

    // handle clear buttons for image fields.
    if( $defn['type'] == 6 ) {
        if( isset($params['input_'.$name.'_clear']) &&
            $params['input_'.$name.'_clear'] == 'clear' &&
            $value != '' ) {
            // we're told to clear an image property, we must also
            // delete the image
            $destDir1 = $gCms->config['uploads_path'].DIRECTORY_SEPARATOR;
            $destDir1 .= $this->GetPreference('image_destination_path','feusers').DIRECTORY_SEPARATOR;
            $file1 = $destDir1.$value;
            @unlink( $file1 );
            unset($fieldlist[$name]);
            $value = '';
        }
    }

    // validate filled in fields
    // optional,or required.
    // and do post processing
    if( $value != '' ) {
        // validate unique values
        if( $defn['force_unique'] ) {
            // make sure that this value doesn't already exist
            if( !$this->IsUserPropertyValueUnique($user_id,$name,$value) ) {
                $params = $params['step1_params'];
                $params['error'] = 1;
                $params['message'] = $this->Lang('error_nonunique_field_value',$name,$value);
                $this->myRedirect( $id, 'do_edituser2', $returnid,$params, true );
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
            break;
        case 3: // textarea
            // maybe size?
            break;
        case 4: // dropdown
            // How can we validate a dropdown?
            break;
        case 5: // multiselect
            // How can we validate a multi-select
            if( is_array( $fieldlist[$name] ) ) {
                // convert it to a comma separated list for storage
                $fieldlist[$name] = implode(',',$fieldlist[$name]);
            }
            break;
        case 6: // image
            break;
        case 8: // date
            // todo, validate... against attribs.
            break;
        }
    }
}


// get the parms from the first step
// and merge em into $params so we can actually add the user account
if( isset($params['step1_params']) ) {
    $parms1 = $params['step1_params'];
    unset($params['step1_params']);
    $params = array_merge( $params, $parms1 );
}

// now find out which groups he's a member of
$username = '';
if( isset( $params['input_username'] ) ) $username = $params['input_username'];
$password = '';
if( isset( $params['input_password'] ) && $params['input_password'] != '' ) $password = $params['input_password'];
$expiresdate = strtotime('+10 years', time());
if( isset( $params['input_expiresdate'] ) ) $expiresdate = $params['input_expiresdate'];

// and Set the user
$ret = $this->SetUser( $user_id, $username, $password, $expiresdate );
if( $ret[0] == false ) {
    $params['error'] = 1;
    $params['message'] = 'Problem Attempting to Set User: '.$ret[1];
    $this->myRedirect( $id, 'do_edituser2', $returnid, $params, true );
    return;
}

// remove any user temp code that may exist...
$this->RemoveUserTempCode($user_id);

// and then add him to his groups
$ret = $this->SetUserGroups( $user_id, $groupids );
if( $ret[0] == false ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_cantassignuser');
    $this->myRedirect( $id, 'do_edituser2', $returnid, $params, true );
    return;
}

// and then add his properties
// delete them all first though (so we don't keep properties with empty values)
$this->SetEncryptionKey($user_id);
$this->DeleteUserPropertyFull( "", $user_id, true );
foreach( $fieldlist as $k => $v ) {
    $defn =& $defns[$k];
    $reln =& $groupprops[$k];

    if( $defn['type'] == 6 ) {
        // image type
        if( isset($_FILES[$id.'input_'.$k]) && $_FILES[$id.'input_'.$k]['size'] > 0 ) {
            // it's an uploaded file type
            $result = $this->ManageImageUpload($id,'input_', $k, $user_id );
            if( $result[0] == false ) {
                $params['error'] = 1;
                $params['message'] = $this->Lang('error').'&nbsp;'.$result[1];
                $this->myRedirect( $id, 'do_edituser2', $returnid, $params, true );
                return;
            }
            $v = $result[1];
        }
        else if( isset($params['hidden_'.$k]) ) {
            // image was not uploaded, use the old value.
            $v = trim($params['hidden_'.$k]);
        }
    }

    if( $v == '' ) continue;
    if( is_array($v) ) $v = implode(',',$v);
    $ret = $this->SetUserPropertyFull( $k, $v, $user_id );
    if( $ret == false ) {
        $params['error'] = 1;
        $params['message'] = 'Error Setting Property '.$k.' to '.$v.' for user '.$user_id;
        $this->myRedirect( $id, 'do_edituser2', $returnid, $params, true );
        return;
    }
}

// and we're done
// send the event
$event_params = array();
$event_params['name'] = $username;
$event_params['id'] = $user_id;
$this->SendEvent('OnUpdateUser',$event_params);
$this->_SendNotificationEmail('OnUpdateUser',$event_params);
$this->RedirectToTab($id, 'users' );

// EOF
?>