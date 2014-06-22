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
$consumer = feu_utils::get_auth_consumer();

$gid = false;
if( isset($params['group_id']) ) $gid = (int)$params['group_id'];

$groupname = '';
$groupdesc = '';
if( isset( $params['input_groupname'] ) ) $groupname = trim($params['input_groupname']);
if( isset( $params['input_groupdesc'] ) ) $groupdesc = trim($params['input_groupdesc']);

if( $consumer->has_capability($consumer::CAPABILITY_EDITGROUPS) ) {
  // make sure the parameters are filled in
  if( $groupname == '' || $groupdesc == '' ) {
    unset($params['submit']);
    $params['error'] = '1';
    $params['message'] = $this->Lang('error_invalidparams');
    $this->myRedirect( $id, 'addgroup', $returnid, $params );
    return;
  }

  // make sure the group name doesn't already exist
  $tmp = $this->GetGroupID( $groupname );
  if( $tmp != $gid && $tmp != '' ) {
    unset($params['submit']);
    $params['error'] = '1';
    $params['message'] = $this->Lang('error_groupexists');
    $this->myRedirect( $id, 'addgroup', $returnid, $params );
    return;
  }
}

// make sure not all properties are off.
// and that we're not setting a lostun flag for a hidden or optional field.
if( $consumer->has_capability($consumer::CAPABILITY_EDITGROUPPROPS) ) {
    $relnadded = 0;
    for( $i = 0; $i < count($params['input_name']); $i++ ) {
        if( $params['input_required'][$i] != 0 ) $relnadded++;
        if( $params['input_required'][$i] != 2 ) {
            // it's not a required field.... so can't be used in lostun
            $str = $params['input_name'][$i];
            if( isset($params['input_lostun_'.$str]) ) {
                unset($params['submit']);
                $params['error'] = '1';
                $params['message'] = $this->Lang('error_lostun_nonrequired');
                $this->myRedirect( $id, 'addgroup', $returnid, $params );
                return;
            }
        }
    }
    if( $relnadded == 0 ) {
        unset($params['submit']);
        $params['error'] = '1';
        $params['message'] = $this->Lang('error_norelations');
        $this->myRedirect( $id, 'addgroup', $returnid, $params );
        return;
    }
}

// we're clear to add or update
if( $consumer->has_capability($consumer::CAPABILITY_EDITGROUPS) ) {
  if( $gid !== false ) {
    $ret = $this->SetGroup( $gid, $groupname, $groupdesc );
    if( $ret[0] == FALSE ) {
      unset($params['submit']);
      $params['error'] = '1';
      $params['message'] = $ret[1];
      $this->myRedirect( $id, 'addgroup', $returnid, $params );
      return;
    }
  }
  else {
    $ret = $this->AddGroup( $groupname, $groupdesc );
    if( $ret[0] == FALSE ) {
      unset($params['submit']);
      $params['error'] = '1';
      $params['message'] = $ret[1];
      $this->myRedirect( $id, 'addgroup', $returnid, $params );
      return;
    }
    $gid = $ret[1];
  }
}

if( $consumer->has_capability($consumer::CAPABILITY_EDITGROUPPROPS) ) {
  // also add the property choices
  $this->DeleteAllGroupPropertyRelations( $gid );
  for( $i = 0; $i < count($params['input_name']); $i++ ) {
    $propname = '';
    $sortorder = '';
    $lostun = -1;
    $required = 0;

    $propname = $params['input_name'][$i];
    $required = $params['input_required'][$i];
    if( isset( $params['input_lostun_'.$propname] ) ) {
      $lostun = 1;
    }

    if( $required != 0 && $propname != '') {
      $res = $this->AddGroupPropertyRelation( $gid, $propname, $i, $lostun, $required );
    }
  }
}

// send an event
$parms = array();
$parms['name'] = $groupname;
$parms['description'] = $groupdesc;
$parms['id'] = $gid;
$str = 'OnCreateGroup';
if( isset($params['group_id']) ) {
  $str = 'OnUpdateGroup';
}
$this->SendEvent($str,$parms);
$this->_SendNotificationEmail($str,$parms);

$this->RedirectToTab($id, 'groups' );
// EOF
?>
