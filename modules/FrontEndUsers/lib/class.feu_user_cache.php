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

/**
 * this is an internal class ...do no use
 */

final class feu_user_cache
{
  private static $_users = array();
  private function __construct() {}

  /**
   * Get user information for a uid
   * will return deep information if alredy loaded
   * will not load any info
   **/
  public static function get_user_noload($uid)
  {
    $uid = (int)$uid;
    if( $uid <= 0 ) return;
    if( !isset(self::$_users[$uid]) ) return;

    return self::$_users[$uid];
  }

  /** 
   * Get user information for a uid
   * will return deep info if it is already loaded, even if $deep = FALSE
   * will load the user if not in memory
   **/
  public static function get_user($uid,$deep = FALSE)
  {
    $uid = (int)$uid;
    if( $uid <= 0 ) return;
    if( !isset(self::$_users[$uid]) || ($deep && !isset(self::$_users[$uid]['fprops'])) ) {
      self::load_users(array($uid),$deep);
    }
    return self::get_user_noload($uid);
  }

  public static function set_user($uinfo)
  {
    if( !is_array($uinfo) ) return FALSE;
    if( !isset($uinfo['id']) ) return FALSE;
    $uid = (int)$uinfo['id'];
    if( $uid <= 0 ) return FALSE;
    if( !isset($uinfo['username']) ) return FALSE;

    self::$_users[$uid] = $uinfo;
    return TRUE;
  }

  public static function set_new_user($uinfo)
  {
    if( !is_array($uinfo) ) return FALSE;
    if( !isset($uinfo['id']) ) return FALSE;
    $uid = (int)$uinfo['id'];
    if( $uid <= 0 ) return FALSE;
    if( !isset($uinfo['username']) ) return FALSE;
    if( isset(self::$_users[$uid]) ) return FALSE;

    self::$_users[$uinfo['id']] = $uinfo;
    return TRUE;
  }

  public static function del_user($uid)
  {
    $uid = (int)$uid;
    if( $uid <= 0 ) return FALSE;
    if( !isset(self::$_users[$uid]) ) return FALSE;

    unset(self::$_users[$uid]);
    return TRUE;
  }

  public static function clear_all()
  {
    self::$_users = array();
  }

  public static function load_users($uid_list,$deep = FALSE)
  {
    if( !is_array($uid_list) || count($uid_list) == 0 ) return;

    $need = array();
    $need_props = array();
    foreach( $uid_list as $one ) {
      $one = (int)$one;
      if( $one <= 0 ) continue;

      if( !isset(self::$_users[$one]) ) $need[] = $one;
      if( !isset(self::$_users[$one]['fprops']) ) $need_props[] = $one;
    }

    $need = array_unique($need);
    $need_props = array_unique($need_props);
    asort($need);
    asort($need_props);

    $db = cmsms()->GetDb();
    if( count($need) ) {
      // get the user info
      $uquery = 'SELECT u.*,count(li.userid) AS loggedin FROM '.cms_db_prefix().'module_feusers_users u
                 LEFT JOIN '.cms_db_prefix().'module_feusers_loggedin li ON u.id = li.userid 
                 WHERE u.id IN (';
      $uquery .= implode(',',$need).') GROUP BY u.id ORDER BY u.id';
      $uinfo = $db->GetArray($uquery);
      foreach($uinfo as $rec) {
	self::$_users[$rec['id']] = $rec;
      }
    }

    if( $deep && count($need_props) ) {
      $mod = cms_utils::get_module('FrontEndUsers');
      $defns = $mod->GetPropertyDefns();

      $pquery = 'SELECT * FROM '.cms_db_prefix().'module_feusers_properties WHERE userid IN (';
      $pquery .= implode(',',$need_props).') ORDER BY userid,title';
      $pinfo = $db->GetArray($pquery);

      $prev_uid = null;
      $fprops = null;
      foreach($pinfo as $rec) {
	if( count($fprops) && $rec['userid'] != $prev_uid && $prev_uid != null) {
	  $tuid = $fprops[0]['userid'];
	  if( !isset(self::$_users[$tuid]) ) throw new CmsException('Loaded properties for user, but no user loaded');
	  self::$_users[$tuid]['fprops'] = $fprops;
	  $fprops = array();
	}
	if( $defns[$rec['title']]['encrypt'] ) {
	  $rec['data'] = $mod->DecryptUserData($rec['userid'],$rec['data']);
	}
	$fprops[] = $rec;
	$prev_uid = $rec['userid'];
      }
      if( count($fprops) ) {
	$tuid = $fprops[0]['userid'];
	if( !isset(self::$_users[$tuid]) ) throw new CmsException('Loaded properties for user, but no user loaded');
	self::$_users[$tuid]['fprops'] = $fprops;
      }
    }
  }

} // end of class

?>