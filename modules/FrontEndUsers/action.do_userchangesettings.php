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

if( isset($params['feu_cancel']) ) {
  if( isset( $params['feu_returnto'] ) ) $returnid = (int)$params['feu_returnto'];
  $this->RedirectContent($returnid);
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

$username = $uinfo['username'];
$password = '';

// check if user is allowed to change his username
$consumer = feu_utils::get_auth_consumer();
if( $consumer->has_capability(feu_auth_consumer::CAPABILITY_CHANGEUSERNAME) ) {
    if( isset($params['feu_input_username']) ) {
        // user is changing his username
        $tmp = trim($params['feu_input_username']);
        if( !$this->IsValidUsername($tmp,FALSE,$uid) ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_invalidusername');
            $this->Redirect($id, 'changesettings', $returnid, $params );
        }
        if( $tmp ) $username = $tmp;
    }
}

// check if the user is allowed to change his password
if( $consumer->has_capability(feu_auth_consumer::CAPABILITY_CHANGEPASSWD) ) {
    // change this password
    $password = cms_html_entity_decode(trim($params['feu_input_password']));
    $repeat   = cms_html_entity_decode(trim($params['feu_input_repeatpassword']));
    if( $password != $repeat && $password != '') {
        $params['error'] = 1;
        $params['message'] = $this->Lang('error_passwordmismatch');
        $this->Redirect($id, 'changesettings', $returnid, $params );
    }

    if( $password != '' && !$this->IsValidPassword($password) ) {
        $params['error'] = 1;
        $params['message'] = $this->Lang('error_invalidpassword');
        $this->Redirect($id, 'changesettings', $returnid, $params );
    }
}

// get property definitions
$defnsbyname = $this->GetPropertyDefns();

// Get member groups
$groups = $this->GetMemberGroupsArray($uid);

// Get group property relations into a union.
$properties = array();
$tmp = array();
foreach( $groups as $onegroup ) {
    $proprelations = $this->GetGroupPropertyRelations( $onegroup['groupid'] );
    $tmp = RRUtils::array_merge_by_name_required( $tmp, $proprelations );
    uasort( $tmp, array('cge_array','compare_elements_by_sortorder_key') );
}
$properties = cge_array::to_hash($tmp,'name');

$userprops = $this->GetUserProperties($uid);
$deleteprops = array();

// do validation of the fields.
foreach( $properties as $propname => $prop ) {
    $fldtype = $defnsbyname[$propname]['type'];
    $required = ($prop['required'] == 2);
    $hidden   = ($prop['required'] == 3);
    $readonly = ($prop['required'] == 4);

    switch( $fldtype ) {
    case FrontEndUsers::FIELDTYPE_TEXT:
        if( $required ) {
            if( !isset($params['feu_input_'.$propname]) || empty($params['feu_input_'.$propname]) ) {
                $params['error'] = 1;
                $params['message'] = $this->Lang('error_requiredfield',$defnsbyname[$propname]['prompt']);
                $this->Redirect( $id, 'changesettings', $returnid, $params );
            }
        }
        break;

    case FrontEndUsers::FIELDTYPE_CHECKBOX:
        if( $required ) {
            if( !isset($params['feu_input_'.$propname]) || $params['feu_input_'.$propname] == 0 ) {
                $params['error'] = 1;
                $params['message'] = $this->Lang('error_requiredfield',$defnsbyname[$propname]['prompt']);
                $this->Redirect( $id, 'changesettings', $returnid, $params );
            }
        }
        break;

    case FrontEndUsers::FIELDTYPE_EMAIL:
        if( $required ) {
            if( !isset($params['feu_input_'.$propname]) ) {
                $params['error'] = 1;
                $params['message'] = $this->Lang('error_invalidemailaddress').' '.$result[1];
                $this->Redirect( $id, 'changesettings', $returnid, $params );
            }
            else {
                $result = $this->IsValidEmailAddress( $params['feu_input_'.$propname], $uid );
                if( $result[0] == false ) {
                    $params['error'] = 1;
                    $params['message'] = $this->Lang('error_invalidemailaddress').' '.$result[1];
                    $this->Redirect( $id, 'changesettings', $returnid, $params );
                }
            }
        }
        break;

    case FrontEndUsers::FIELDTYPE_TEXTAREA:
        if( $required && !isset($params['feu_input_'.$propname]) ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_requiredfield',$defnsbyname[$propname]['prompt']);
            $this->Redirect( $id, 'changesettings', $returnid, $params );
        }
        if( $required && empty($params['feu_input_'.$propname]) ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_requiredfield',$defnsbyname[$propname]['prompt']);
            $this->Redirect( $id, 'changesettings', $returnid, $params );
        }
        break;

    case FrontEndUsers::FIELDTYPE_MULTISELECT:
        if( $required && !isset($params['feu_input_'.$propname]) ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_requiredfield',$defnsbyname[$propname]['prompt']);
            $this->Redirect( $id, 'changesettings', $returnid, $params );
        }
        // encode it into a comma separated list.
        if( isset($params['feu_input_'.$propname]) ) {
            $params['feu_input_'.$propname] = implode(',',$params['feu_input_'.$propname] );
        }
        else {
            $params['feu_input_'.$propname] = '';
        }
        break;

    case FrontEndUsers::FIELDTYPE_IMAGE:
        if( isset($params['feu_input_'.$propname.'_clear']) &&
            $params['feu_input_'.$propname.'_clear'] == 'clear' ) {
            // we're told to clear an image property, we must also
            // delete the image
            $destDir1 = $gCms->config['uploads_path'].'/';
            $destDir1 .= $this->GetPreference('image_destination_path','feusers').'/';
            $file1 = $destDir1.$params['feu_input_'.$propname];
            @unlink( $file1 );

            // unset the hidden param to prevent any further processing
            $deleteprops[] = $propname;
            unset( $params['feu_input_'.$propname] );
        }
        if( $required &&
            ((!isset($_FILES[$id.'feu_input_'.$propname]) || $_FILES[$id.'feu_input_'.$propname]['size'] == 0) &&
             (!isset($params['feu_input_'.$propname]) || $params['feu_input_'.$propname] == '')) ) {
            // but we can't find a value
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_requiredfield',$propname);
            $this->Redirect( $id, 'changesettings', $returnid, $params );
        }
        break;

    case FrontEndUsers::FIELDTYPE_DATE:
        if( isset($params['feu_input_'.$propname.'Month']) ) {
            $params['feu_input_'.$propname] =
                mktime(0,0,0,
                       $params['feu_input_'.$propname.'Month'],
                       $params['feu_input_'.$propname.'Day'],
                       $params['feu_input_'.$propname.'Year']);
            unset($params['feu_input_'.$propname.'Month']);
            unset($params['feu_input_'.$propname.'Day']);
            unset($params['feu_input_'.$propname.'Year']);
        }
        if( $required && !isset($params['feu_input_'.$propname]) ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_requiredfield',$propname);
            $this->Redirect( $id, 'changesettings', $returnid, $params );
        }
        break;

    case FrontEndUsers::FIELDTYPE_DROPDOWN:
    case FrontEndUsers::FIELDTYPE_RADIOBUTNS:
        if( $required && !isset($params['feu_input_'.$propname]) ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_requiredfield',$propname);
            $this->Redirect( $id, 'changesettings', $returnid, $params );
        }
        break;

    default:
        // we don't accept field types like this
        $params['error'] = 1;
        $params['message'] = $this->Lang('error_cantsetpropertytype',$propname);
        $this->Redirect( $id, 'changesettings', $returnid, $params );
        break;
    }
}


//
// now we actually change the user settings
//

// password
if( $password != '' || $username != '' ) {
  $result = $this->SetUser( $uid, $username, $password );
  if( $result[0] == FALSE ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_problemsettinginfo').' '.$result[1];
    $this->Redirect( $id, 'changesettings', $returnid, $params );
  }
}

//
// now delete all the properties for this user
// in preparation for setting new ones.
//
$this->SetEncryptionKey($uid);
foreach( $deleteprops as $one ) {
  $this->DeleteUserPropertyFull( $one, $uid, false );
}
foreach( $properties as $propname => $prop ) {
    //$propname = 'feu_input_'.$propname;
    $required = ($prop['required'] == 2);
    $hidden = ($prop['required'] == 3);
    $readonly = ($prop['required'] == 4);
    $fldtype  = $defnsbyname[$propname]['type'];
    $force_unique = $defnsbyname[$propname]['force_unique'];

    if( $readonly || $hidden ) continue; // cannot set readonly or hidden fields

    if( $fldtype == 6 ) {
        // image type
        $val = $params['feu_input_'.$propname];
        if( isset( $_FILES[$id.'feu_input_'.$propname] ) && $_FILES[$id.'feu_input_'.$propname]['size'] > 0) {
            // It is an upload file type
            $result = $this->ManageImageUpload($id, 'feu_input_', $propname, $uid );
            if( $result[0] == false ) {
                $params['error'] = 1;
                $params['message'] = $this->Lang('error').'&nbsp;'.$result[1];
                $this->Redirect( $id, 'changesettings', $returnid, $params );
            }
            $val = $result[1];
        }
    }
    else if( isset( $params['feu_input_'.$propname] ) ) {
        $val = trim($params['feu_input_'.$propname]);
        $val = cms_html_entity_decode($val);
    }
    else {
        continue;
    }

    // check for forced unique values.
    if( $val ) {
        if( $force_unique && !$this->IsUserPropertyValueUnique( $uid, $propname, $val ) ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_user_nonunique_field_value',$propname);
            $this->Redirect( $id, 'changesettings', $returnid, $params );
            return;
        }

        $ret = $this->SetUserPropertyFull( $propname, $val, $uid );
        if( $ret == false ) {
            $params['error'] = 1;
            $params['message'] = $this->Lang('error_settingproperty').' '.$propname;
            $this->Redirect( $id, 'changesettings', $returnid, $params );
            return;
        }
    }
}

// send the event
$this->add_history($uid,'change settings');

$event_params = array();
$event_params['name'] = $uinfo['username'];
$event_params['id'] = $uid;
$this->SendEvent('OnUpdateUser',$event_params);
$this->_SendNotificationEmail('OnUpdateUser',$event_params);

if( isset( $params['feu_returnto'] ) ) {
    $page = ContentOperations::get_instance()->GetPageIDFromAlias( $params['feu_returnto'] );
    if( $page ) {
        $this->RedirectContent( $page );
        return;
    }
}

$page = $this->GetPreference('pageid_afterchangesettings');
if( !empty($page) ) {
    $smarty->assign('username',$uinfo['username']);
    $smarty->assign('userinfo',$uinfo);
    $groups = $this->GetMemberGroupsArray( $this->LoggedinId() );
    $groupname = $this->GetGroupName( $groups[0]['groupid'] );
    $smarty->assign('group',$groupname);
    $page = $this->ProcessTemplateFromData($page);

    $pageid = ContentOperations::get_instance()->GetPageIDFromAlias( $page );
    if( $pageid ) {
        $this->RedirectContent( $pageid );
        return;
    }
}

// old behavior
// $this->RedirectContent( $returnid );

// new behavior
$parms = array('message'=>$this->Lang('msg_settingschanged'));
$this->_DoUserAction( $id, $parms, $returnid );

?>