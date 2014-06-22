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

abstract class UserManipulator
{
  private $mod;
  private $_expire_notifier_callback;

  //
  // Internals
  //

  public function __construct( &$the_module )
  {
    $this->mod =& $the_module;
  }


  protected function &GetDb()
  {
    return $this->mod->GetDb();
  }


  protected function &GetModule()
  {
    return $this->mod;
  }

  public function SetExpireNotifier($callback)
  {
    if( is_callable($callback) )
    {
      $this->_expire_notifier_callback = $callback;
    }
  }

  protected function NotifyExpiredUser($params = array())
  {
    if( !is_array($params) && (is_string($params) || is_int($params)) && $params != '' )
      {
	$params = array($params);
      }
    if( $this->_expire_notifier_callback ) call_user_func_array($this->_expire_notifier_callback,$params);
  }

  //
  // ======================================================================
  //

  public function AddGroupPropertyRelation( $grpid, $propname, $sortkey, $lostun, $val )
  {
    return array(FALSE,"Function not implemented");
  }

  //! Add a single property definition
  //! \param name The name of the property
  //! \param prompt The prompt to display to the user
  //!       note, this will be Langified
  //! \param type  The type of the property
  //!       0 = text, 1 = checkbox, 2 = email
  //! \param required wether or not the property is required
  //! \return An array, the first element is a boolean which indicates success or failure, the
  //!    second element (optional) contains an error message in the event of an error.
  //!
  public function AddPropertyDefn( $name, $prompt, $type, $length )
  {
    return array(FALSE,"Not Implemented");
  }

  //! Add a new group
  //!
  //! Adds a new group with the supplied name and description
  //!
  //! \param name The new group name
  //! \param description the group description
  //! \return an array, the first element is a description describing the return status
  //!    (true on success, false on error).  The second element (optional) is an error string in the
  //!    event of an error.
  //!
  public function AddGroup( $name, $description )
  {
    return array(FALSE,"Function not defined");
  }

  //! Add a new user
  //!
  //! Add the specified user to the database
  //!
  //! \param name The desired username
  //! \param password The desired password (unencrypted)
  //! \param expires The expiry date
  //! \return an array, the first element is a description describing the return status
  //!    (true on success, false on error).  The second element (optional) is an error string in the
  //!    event of an error, or the userid otherwise
  //!
  public function AddUser( $name, $password, $expires )
  {
    return array(FALSE,"Function not defined");
  }

  //! Check if the specified user has the specified permission
  //! Assign the user specified (by id) to the group specified (by id)
  //!
  //!\param  uid  The userid for the new association
  //!\param  gid  The group id for the new association
  //!\return true on success, false otherwise
  //!
  public function AssignUserToGroup( $uid, $gid )
  {
    return false;
  }

  //! Check if the group specified has the required permission
  public function CheckGroupPermission( $gid, $perm )
  {
    return false;
  }

  //! Check the supplied password and ensure it maches the one in the database
  //!
  //!\params username The username to test for
  //!\params password The password to test
  //!\return true if passwords match, false otherwise.
  //!
  public function CheckPassword($username,$password)
  {
    return false;
  }

  //! Check if the user has the specified permission
  public function CheckUserPermission( $perm )
  {
    return false;
  }

  public function CheckUserPermissionByUid( $uid, $perm )
  {
    return false;
  }

  public function CountTempCodeRecords()
  {
    return 0;
  }


  public function DeleteAllGroupPropertyRelations( $grpid )
  {
    return array(FALSE,"Function not implemented");
  }

  //! Delete all of the current users properties
  //!
  //! \return true on success, false otherwise
  //!
  public function DeleteAllUserProperties()
  {
    return false;
  }

  //! Delete All properties for a specified user id
  //!
  //! \param userid
  //! \return true on success, false otherwise
  //!
  public function DeleteAllUserPropertiesFull($userid)
  {
    return false;
  }

  //! Delete the specified group
  //!
  //! Delete the group record for the matchind id
  //!
  //! \return an array, the first element is a description describing the return status
  //!    (true on success, false on error).  The second element (optional) is an error string in the
  //!    event of an error.
  //!
  public function DeleteGroupFull( $id )
  {
    return array(FALSE,"Function not defined");
  }

  public function DeleteGroupPropertyRelation( $grpid, $propname )
  {
    return array(FALSE,"Function not implemented");
  }

  public function DeletePropertyDefn( $name, $full = false )
  {
    return false;
  }

  //! Delete all property definitions (use with caution)
  public function DeletePropertyDefns()
  {
    return array(FALSE,"Not Implemented");
  }

  //! Delete the user with the specified id
  //! \note This is a deprecated function as it relies on the userid being set in the _GET
  //! variable.
  //!
  public function DeleteUser($id)
  {
    return false;
  }

  //! Completely delete all references to the supplied user id
  //!
  //!This method completely deletes anything from the database related to the specified user id.
  //!specifically, group associations, properties, and the user record itself.
  //!
  //!\param uid the userid to delete all references to
  //!\return array, the first element of the array is a boolean indicating success or failure.
  //!   if the first element is false, then the second element will contain an error message.
  //!
  public function DeleteUserFull( $uid )
  {
    return array(FALSE,"No function defined");
  }


  //! Delete a property for the current user
  //!
  //! Remove a property from the database for the currently logged in user
  //!
  //! \param title The name of the property to delete
  //! \param all   Optionally delete all properties for this user
  //! \returns true on success, false othwerisen
  //!
  public function DeleteUserProperty($title,$all=false)
  {
    return false;
  }

  //! Delete a property for a specified user
  //!
  //!\param title The name of the property to delete
  //!\param userid The id to delete the property for
  //!\param all (optional) Delete all properties for the specified userid.
  //!\return true on success, false otherwise.
  //!
  public function DeleteUserPropertyFull($title,$userid,$all=false)
  {
    return false;
  }

  /* expirycode is a strtotime string */
  public function ExpireTempCodes($expirycode)
  {
    return false;
  }

  //! Expire any and all users that have been away for too long
  public function ExpireUsers()
  {
    return false;
  }

  //! Get the email address of the user with the specified id
  //!
  //!\return Email address, or false
  //!
  public function GetEmail($userid)
  {
    return false;
  }

  //! Generate a random (but not used) username
  //!
  //!\ return username, or false
  //!
  public function GenerateRandomUsername( $prefix = 'user' )
  {
    return false;
  }

  //! Get the groupid given a group name
  //!
  //! \return groupid or false
  //!
  public function GetGroupID($groupname)
  {
    return false;
  }

  //! Get information about the group
  //!
  //! This method returns an association with the following information about the specified
  //! group id
  //!    id => The requested group id
  //!    groupname => The name of the group
  //!    groupdesc => The group description
  //!
  //! \param gid The group id
  //! \param associative array, or array with first element of false, second element contains error message
  //! \return an associative array with group info, or false
  //!
  public function GetGroupInfo( $gid )
  {
    return false;
  }

  //! Get a list of all of the groups, and their id's
  //!
  //! \return an associative array containing group names as keys, and id's as values
  //!
  public function GetGroupList()
  {
    return array();
  }

  //! Get information about the complete list of groups
  //!
  //! This method returns an array of groupinfo associations, representing all of the
  //! groups in the table.
  //!
  //! \returns an array of groupinfo associations
  //!
  public function GetGroupListFull()
  {
    return array();
  }

  //! Get the group name given a group id
  //!
  //! \return group name, or false
  //!
  public function GetGroupName($groupid)
  {
    return false;
  }

  //! Get the group description given a group id
  //!
  //! \return group description, or false
  //!
  public function GetGroupDesc($groupid)
  {
    return false;
  }

  public function GetGroupPropertyRelations( $grpid )
  {
    return array(FALSE,"Function not implemented");
  }

  //! Get a list of the groups that the specified user belongs to
  //!
  //! Return a string of comma delimited group names, corresponding to the
  //! groups that the user is a member of
  //!
  //! \return a comma delimited list of group names, or "none"
  //!
  public function GetMemberGroups($userid)
  {
    return false;
  }

  //! Return a complete list of the groups that this user belongs to
  //!
  //! Returns an array of groupinfo records corresponding to the groups that
  //! this user is associated with.
  //!
  //! \param userid The userid to test
  //! \return false on error, otherwise, an array of groupinfo records.
  //!
  public function GetMemberGroupsArray($userid)
  {
    return false;
  }

  //! Get a single property definition by name
  public function GetPropertyDefn( $name )
  {
    return FALSE;
  }

  //! Get an array of property definitions
  public function GetPropertyDefns()
  {
    return array(FALSE,"Not Implemented");
  }

  public function GetPropertyGroupRelations( $title )
  {
    return array(FALSE,"Function not implemented");
  }

  //! Get the userid of the user with the matching name
  //!
  //! \return UserID, or false
  //!
  public function GetUserID($username)
  {
    return false;
  }

  //! Get information about a user
  //!
  //! This method returns an association with the following information about the specified
  //! user id
  //!   id = the requested user id
  //!   username = the users name
  //!   password = the (encrypted) user password
  //!   email    = the users email address
  //!   expires  = the users expiry date
  //!   status   = the users status
  //!
  //! \param uid The userid to inquire about
  //! \return an array, the first element contains return status (true/false), the second element
  //!    is either an array containing the details above, or an error message.
  //!
  public function GetUserInfo( $uid )
  {
    return array(FALSE,"Function not defined");
  }

  //! Return the username that maches the specified user id
  //!
  //!\return The matching username, or false
  //!
  public function GetUserName($userid)
  {
    return false;
  }

  //! Get a single property for the current user
  //!
  //! Get a single property for the currently logged in user.
  //!
  //! \param title The name of the parameter to return
  //! \param defaultvalue A value to return if the property does not exist for that user
  //! \return The property value, or false.
  //!
  public function GetUserProperty($title,$defaultvalue=false)
  {
    return false;
  }

  //! Get property information for the specified user id
  //!
  //! \param title The name of the property we are searching for
  //! \param userid The userid for who's property we are searching
  //! \param defaultvalue The value to return if this property does not exist for this user
  //! \return The property value, or false.
  //!
  public function GetUserPropertyFull($title,$userid, $defaultvalue=false)
  {
    return false;
  }

  //! Get a list of all of the users that belong to the specified group
  //! including all of their properties
  //!
  //! This method returns an associative array (with userid as the key)
  //!
  //! \param groupid the desired group id
  //! \return an array of user information (see GetUserInfo), or false
  //! \sa GetUserInfo
  //!
  public function GetFullUsersInGroup($groupid)
  {
    return false;
  }

  //! Get a list of the users that belong to the specified group
  //!
  //! This method returns an associative array containing a complete set of the
  //! information about all of the users that belong to the specified group
  //!
  //! \param groupid the desired group id
  //! \return an array of user information (see GetUserInfo), or false
  //! \sa GetUserInfo
  //!
  public function GetUsersInGroup( $groupid = '' )
  {
    return false;
  }

  //! Return an array of the user's properties
  //!
  //! Returns a complete list of the users properties
  //!
  //! \param uid The uid to test
  //! \return false on error, otherwise an array of associations, each association
  //!   has the following keys:
  //!      id     = The property id
  //!      userid = The matching user id
  //!      title  = The property title
  //!      data   = The property data
  //!
  public function GetUserProperties($uid)
  {
    return false;
  }

  public function GetUserTempCode( $uid )
  {
    return array(FALSE,"Function not implemented");
  }

  //! A function that tests wether a group with the spefified id exists
  //!
  //! \param gid The desired group id
  //! \return boolean
   //!
  public function GroupExistsByID( $gid )
  {
    return false;
  }

  //! A public function that tests wether a group with the name exists
  //!
  //! \param gid The desired group name
  //! \return boolean
   //!
  public function GroupExistsByName( $name )
  {
    return false;
  }

  public function GetExpiryDate( $uid )
  {
    return false;
  }

  public function IsAccountExpired( $uid )
  {
    return true;
  }

  //! Test wether the specified email address passes the rules.
  //!
  //! This method will test if the email address supplied matches the
  //! set rules.  Optionally, the email address can be validated via
  //! smtp.
  //!
  //! \param  email The address to test
  //! \return an array, the first element of the array indicuates success or failure
  //!    the second element is the error message, if an error occurred
  //!
  public function IsValidEmailAddress( $email )
  {
    return array(FALSE,"Function not defined");
  }

  //! Check the validity of the supplied password
  //!
  //!\param  password The password to test.
  //!\return true if the password is valid, false otherwise
  //!
  public function IsValidPassword( $password )
  {
    return false;
  }

  //! Check wether the username supplied passes the rules
  //!
  //!\param username The username to be tested
  //!\return boolean true/false
  //!
  public function IsValidUsername( $username )
  {
    return false;
  }

  //! Tests wether the current user is logged in or not.
  public function LoggedIn()
  {
    if ($this->LoggedInId()==false) return false; else return true;
  }

  //! Return the email address of the current user
  //!
  //! \returns a string representing the email address of the currently logged in user
  //!   if noone is logged in, then an empty string is returned
  //!
  public function LoggedInEmail()
  {
    return "";
  }

  //! Return the userid of the currently logged in user
  public function LoggedInId()
  {
    return false;
  }

  //! Return the username of the current user
  //!
  //! \returns a string representing the username of the currently logged in user
  //!   if noone is logged in, then an empty string is returned
  //!
  public function LoggedInName()
  {
    return false;
  }

  public function Login( $username, $password, $groups = '', $md5pw = false,
		  $force_logout = false)
  {
    return array(FALSE,"Function not implemented");
  }


  //! Logout the current user
  public function Logout()
  {
    return false;
  }

  //! Test wether an association exists between the specified user and group
  //!
  //! \param userid The userid to test
  //! \param groupid The groupid to test
  //! \return true if an association exists, false otherwise
  //!
  public function MemberOfGroup($userid,$groupid)
  {
    return false;
  }

  //! Remove the specified user from the specified group
  //!
  //!This method revokes the membership of user $uid from group $gid
  //!
  //!\param uid
  //!\param gid
  //!\return array, the first element contains exit status (boolean), the second element
  //!   (optional) returns an error message, if an error occurred.
  //!
  public function RemoveUserFromGroup( $uid, $gid )
  {
    return array(FALSE,"Function not defined");
  }

  public function RemoveUserTempCode( $uid )
  {
    return false;
  }

  //! A method to modify an existing group
  //!
  //!\param gid An existing group id
  //!\param name The new group name
  //!\param desc The new group description
  //!\return An array, the first element is a boolean which indicates success or failure, the
  //!  second element (optional) contains an error message in the event of an error.
  //!
  public function SetGroup( $gid, $name, $desc )
  {
    return array(FALSE,"Function not defined");
  }

  public function SetPropertyDefn( $name, $newname, $prompt, $length, $type )
  {
    return false;
  }

  //! Modify an existing group
  //!
  //! \param uid The id of the existing user
  //! \param username The new user name
  //! \param email The new email address
  //! \param password The new (unencrypted) password
  //! \param expires The new expiry date
  //! \param status the new status
  //! \return An array, the first element is a boolean which indicates success or failure, the
  //!    second element (optional) contains an error message in the event of an error.
  //!
  public function SetUser( $uid, $username, $password, $expires = false )
  {
    return array(FALSE,"Function not defined");
  }

  //! Set the user's group memberships absolutely
  //!
  //!This method removes all previous group associations, and sets new ones
  //!to match those in the grpids array.
  //!
  //!\param uid The user id to edit
  //!\param grpids An array of user ids to associate with
  //!\returns true on success, false otherwise
  //!
  public function SetUserGroups( $uid, $grpids )
  {
    return false;
  }

  public function SetUserPassword( $uid, $password )
  {
    return array(FALSE,"Function not defined");
  }

  //! Set the user's properties absolutely.
  //!
  //! This method deletes any existing user properties and sets them according to the properties
  //! supplied.
  //!
  //! \param uid The user id to be edited
  //! \param props An array of Key=Value strings consisting of the user properties.
  //! \return true on success, false otherwise
  //!
  public function SetUserProperties( $uid, $props )
  {
    return false;
  }

  //! Set a property for the current user
  //!
  //! Sets a property for the currently logged in user
  //!
  //! \param title The property name
  //! \param data  The property value
  //! \returns true on success, false otherwise
  //!
  public function SetUserProperty($title,$data)
  {
    return false;
  }


  //! Set a property for the provided userid
  //!
  //! Sets a property exclusively for a certain user
  //!
  //! \param title The property name
  //! \param data  The property value
  //! \param userid The desired user id
  //!
  public function SetUserPropertyFull($title,$data,$userid)
  {
    return false;
  }

  public function SetUserTempCode( $uid, $code )
  {
    return false;
  }

  //! Test if the user id is already taken
  //!
  //! Tests if a user by that id already exists
  //!
  //! \param uid The userid to test
  //! \return boolean
  //!
  public function UserExistsByID( $uid )
  {
    return false;
  }

  //
  // ======================================================================
  //

} // class

?>
