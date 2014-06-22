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

interface feu_auth_consumer
{
  const CAPABILITY_ALTLOGIN = 'CAPABILITY_ALTLOGIN';
  const CAPABILITY_LOGIN = 'CAPABILITY_LOGIN';
  const CAPABILITY_LOGOUT = 'CAPABILITY_LOGOUT';
  const CAPABILITY_CHANGESETTINGS = 'CAPABILITY_CHANGESETTINGS';
  const CAPABILITY_LOSTUSERNAME = 'CAPABILITY_LOSTUSERNAME';
  const CAPABILITY_FORGOTPASSWD = 'CAPABILITY_FORGOTPASSWD';
  const CAPABILITY_USESTDCHANGESETTINGS = 'CAPABILITY_USESTDCHANGESETTINGS';
  const CAPABILITY_USESTDGROUPS = 'CAPABILITY_USESTDGROUPS';
  const CAPABILITY_CHANGEPASSWD = 'CAPABILITY_CHANGEPASSWD';
  const CAPABILITY_CHANGEUSERNAME = 'CAPABILITY_CHANGEUSERNAME';
  const CAPABILITY_LISTPROPS = 'CAPABILITY_LISTPROPS';
  const CAPABILITY_EDITPROPS = 'CAPABILITY_EDITPROPS';
  const CAPABILITY_LISTGROUPS = 'CAPABILITY_LISTGROUPS';
  const CAPABILITY_EDITGROUPS = 'CAPABILITY_EDITGROUPS';
  const CAPABILITY_EDITGROUPPROPS = 'CAPABILITY_EDITGROUPPROPS';
  const CAPABILITY_GROUPMEMBERSHIP = 'CAPABILITY_GROUPMEMBERSHIP';
  const CAPABILITY_DEFAULTGROUPS = 'CAPABILITY_DEFAULTGROUPS';
  const CAPABILITY_USERNAME = 'CAPABILITY_USERNAME'; // retrieve readable username given a unique identifier.

  const PROPERTY_USERNAME = '__USERNAME__';
  const PROPERTY_UID      = '__UID__';

  /**
   * Return a flag if the user is authenticated.
   */
  public function is_authenticated();

  /**
   * Return an array with this authentication methods capabilities
   *
   */
  public function get_capabilities();

  /**
   * Test if the consumer has the capability
   *
   * Accepts a single capability identifier, or list of argument capabilities.
   * returns TRUE if any of the passed in properties match.
   * returns FALSE otherwise.
   */
  public function has_capability();

  /**
   * A function to display login informatio
   * (or a link to a login page)
   */
  public function get_login_display($id,$returnid,$params);

  /**
   * A function to display login information
   * (or a link to a login page)
   */
  public function get_logout_display($id,$returnid,$params);

  /**
   * A function to display the change settings page
   *
   */
  public function get_changesettings_display($id,$returnid,$params);


  /**
   * Get the user information from the external authentication system
   * for use by FEU 
   */
  public function get_user_info();


  /**
   * Get the name of an FEU property that is used to uniquely identify
   * a user 
   */
  public function get_connecting_property_name();


  /**
   * Get an identifier that uniquely identifies a user in this environment
   */
  public function get_unique_identifier();

  /**
   * Get a list of all groups
   *
   * @return Associative array of groupnames and groupid's.
   */
  public function get_group_list($with_count = FALSE);

  /**
   * Get the list of group (ids) that a user is a member of.
   *
   * @param integer The user id.  May be negative to indicate that the user account is representing a new user.
   * @return mixed array of integers, or null
   */
  public function get_group_membership($userid);

  /**
   * Get the list of group (ids) that by default, a new user should belong to.
   *
   * @return mixed array of integers, or null.
   */
  public function get_default_groups();

  /**
   * Get the username prompt
   */
  public function get_username_prompt();

  /**
   * Validate username.
   *
   * @param string the proposed useername 
   * @param boolean indicates wether the username should be treated as an email address, and validated
   * @param integer The user id (if its an existing user)... to use for checking for duplicate addresses
   * @return boolean
   */
  public function validate_username($username,$check_email_addr = FALSE,$uid = -1);
}

?>