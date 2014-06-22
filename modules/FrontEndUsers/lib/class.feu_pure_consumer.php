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

class feu_pure_consumer implements feu_auth_consumer
{
  public function is_authenticated() {
    return FALSE;
  }

  final public function has_capability()
  {
    $flag = func_get_args();
    if( !is_array($flag) ) $flag = array($flag);
    foreach( $flag as $one ) {
      if( in_array($one,$this->get_capabilities()) ) return TRUE;
    }
    return FALSE;
  }

  public function get_capabilities()
  {
    return array();
  }

  public function get_login_display($id,$returnid,$params)
  {
    return;
  }

  public function get_logout_display($id,$returnid,$params)
  {
    return;
  }

  public function get_changesettings_display($id,$returnid,$params)
  {
    return;
  }

  public function get_user_info()
  {
    return;
  }

  public function get_connecting_property_name()
  {
    return;
  }

  public function get_unique_identifier()
  {
    return;
  }

  public function get_group_list($with_count = FALSE)
  {
    return;
  }

  public function get_group_membership($userid)
  {
    return;
  }

  public function get_default_groups()
  {
    return;
  }

  public function get_username($uid = null)
  {
    return;
  }

  public function get_username_prompt()
  {
    $feu = cms_utils::get_module('FrontEndUsers');
    return $feu->Lang('prompt_username');
  }

  public function validate_username($username,$check_email_addr = FALSE,$uid = -1)
  {
    return TRUE;
  }
} // end of class

?>