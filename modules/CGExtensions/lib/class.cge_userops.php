<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

final class cge_userops
{
  private function __construct() {}

  /**
   * A function to return an expanded list of user id's given an input list
   * if one of the id's specified is negative, it is assumed to be a group id
   * and is expanded to its members.
   *
   * @param mixed A comma separated string, or an array of userid's or negative group id's.
   * @return array
   */
  static public function expand_userlist($useridlist)
  {
    $users = array();

    if( !is_array($useridlist) ) $useridlist = explode(',',$useridlist);
    if( !count($useridlist) ) return $users;

    $userops = cmsms()->GetUserOperations();
    foreach( $useridlist as $oneuid ) {
      if( $oneuid < 0 ) {
	// assume its a group id
	// and get all the uids for that group
	$groupusers = $userops->LoadUsersInGroup($oneuid * -1);
	foreach( $groupusers as $oneuser ) {
	  $users[] = $oneuser->id;
	}
      }
      else {
	$users[] = $oneuid;
      }
    }

    $users = array_unique($users);
    return $users;
  }

  /**
   * Retrieve an associative array containing a list of CMSMS admin groups that
   * is suitable for formatting in a dropdown.
   *
   * @param boolean Flag indicating whether "none" should be the first item.
   * @return array
   */
  public static function get_grouplist($inclnone = TRUE)
  {
    $ops = cmsms()->GetGroupOperations();
    $groups = $ops->LoadGroups();
    $mod = cms_utils::get_module('CGExtensions');
    $out = array();
    if( $inclnone ) {
      $out[-1] = $mod->Lang('none');
    }
    foreach( $groups as $onegroup ) {
      if( !$onegroup->active ) continue;
      $out[$onegroup->id] = $onegroup->name;
    }
    return $out;
  }


  public static function expand_group_emails($groupid)
  {
    if( $groupid <= 0 ) return;

    $emails = array();
    $ops = cmsms()->GetUserOperations();
    $list = $ops->LoadUsersInGroup($groupid);
    if( is_array($list) && count($list) ) {
      foreach( $list as $oneuser ) {
	if( $oneuser->email != '' && !in_array($oneuser->email,$emails) ) {
	  $emails[] = $oneuser->email;
	}
      }
    }

    if( count($emails) == 0 ) return;
    return $emails;
  }

  static public function get_uid_emails($list)
  {
    if( !is_array($list) ) $list = array($list);

    $userops = cmsms()->GetUserOperations();
    $allusers = $userops->LoadUsers();
    $emails = array();
    foreach( $list as $uid ) {
      $uid = (int)$uid;
      if( $uid < 1 ) continue;

      // find it.
      foreach( $allusers as $rec ) {
	if( $rec->id != $uid ) continue;
	if( !$rec->active ) continue;
	if( !$rec->email ) continue;
	$emails[] = $rec->email;
	break;
      }
    }

    if( count($emails) ) return $emails;
  }
} // end of class

#
# EOF
#
?>