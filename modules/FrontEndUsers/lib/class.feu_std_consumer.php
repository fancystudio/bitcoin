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

class feu_std_consumer extends feu_pure_consumer
{
  public function is_authenticated()
  {
    $res = $this->get_unique_identifier();
    if( $res ) return TRUE;
    return FALSE;
  }

  public function get_capabilities()
  {
    $res = array();
    //$res[] = self::CAPABILITY_LOGIN;
    //$res[] = self::CAPABILITY_CHANGESETTINGS;
    //$res[] = self::CAPABILITY_LOSTUSERNAME;
    //$res[] = self::CAPABILITY_FORGOTPASSWD;
    //$res[] = self::CAPABILITY_LOGOUT;
    $res[] = self::CAPABILITY_USESTDCHANGESETTINGS;
    $res[] = self::CAPABILITY_CHANGEPASSWD;
    $res[] = self::CAPABILITY_LISTGROUPS;
    $res[] = self::CAPABILITY_EDITGROUPS;
    $res[] = self::CAPABILITY_EDITGROUPPROPS;
    $res[] = self::CAPABILITY_LISTPROPS;
    $res[] = self::CAPABILITY_EDITPROPS;
    $res[] = self::CAPABILITY_LISTGROUPS;
    $res[] = self::CAPABILITY_GROUPMEMBERSHIP;
    $res[] = self::CAPABILITY_DEFAULTGROUPS;
    $res[] = self::CAPABILITY_USERNAME;
    $mod = cge_utils::get_module(MOD_FRONTENDUSERS);
    if( $mod->GetPreference('allow_changeusername') ) {
      $res[] = self::CAPABILITY_CHANGEUSERNAME;
    }

    return $res;
  }

  public function get_login_display($id,$returnid,$params)
  {
    // todo
    return;
  }

  public function get_logout_display($id,$returnid,$params)
  {
    // todo
    return;
  }

  public function get_changesettings_display($id,$returnid,$params)
  {
    // todo
    return;
  }

  public function get_user_info()
  {
    // todo
    stack_trace();
    die('not implemented');
  }

  public function get_unique_identifier()
  {
    $module = cms_utils::get_module(MOD_FRONTENDUSERS);
    $manip = $module->GetManipulator();
    return $manip->_std_LoggedinId();
  }

  public function get_group_list($with_count = FALSE)
  {
    // this method doesn't exactly listen to the docs.
    $db = cmsms()->GetDb();
    $query = 'SELECT * FROM '.cms_db_prefix().'module_feusers_groups';
    if( $with_count ) {
      $query = 'SELECT g.*,count(b.userid) AS count FROM '.cms_db_prefix().'module_feusers_groups g
                LEFT JOIN '.cms_db_prefix().'module_feusers_belongs b
                ON g.id = b.groupid
                GROUP BY g.id';
    }
    $dbr = $db->GetArray($query);
    if( is_array($dbr) && count($dbr) ) {
      $tmp = array();
      foreach( $dbr as $one ) {
	$tmp[$one['id']] = $one;
      }
      return $tmp;
    }
    return $dbr;
  }

  public function get_group_membership($userid)
  {
    $db = cmsms()->GetDb();
    $q = "SELECT groupid FROM ".cms_db_prefix()."module_feusers_belongs WHERE userid=?";
    $dbr = $db->GetCol($q,array($userid));
    return $dbr;
  }

  public function get_default_groups()
  {
    $mod = cms_utils::get_module(MOD_FRONTENDUSERS);
    $tmp = $mod->GetPreference('default_group');
    if( (int)$tmp > 0 ) return array($tmp);
  }

  public function get_username($identifier = null)
  {
    if( !$identifier ) $identifier = $this->get_unique_identifier();
    $row = feu_user_cache::get_user($identifier);
    if( !$row ) return FALSE;
    return $row['username'];
  }

  public function get_username_prompt()
  {
    $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
    if( $feu->GetPreference('username_is_email') ) {
      return $feu->Lang('prompt_email');
    }
    return $feu->Lang('prompt_username');
  }


  public function validate_username($username,$check_email_addr = FALSE,$uid = -1)
  {
    // a username is valid, if it's length is
    // within certain ranges, and it contains
    // only alphanumerics
    $module = cms_utils::get_module(MOD_FRONTENDUSERS);
    $minlen = $module->GetPreference('min_usernamelength', 4 );
    $maxlen = $module->GetPreference('max_usernamelength', 20 );
    if( strlen( $username ) < $minlen || strlen( $username ) > $maxlen ) {
      return false;
    }
    if ($module->GetPreference('username_is_email')) {
      $test = $module->IsValidEmailAddress($username,$uid,$check_email_addr);
      if ($test[0] === false) {
          return false;
      }
    }
    else if( !preg_match( '/^[a-zA-Z0-9_-\s\.]*$/', $username ) ) {
        return false;
    }
    return true;
  }
} // end of class

#
# EOF
#
?>