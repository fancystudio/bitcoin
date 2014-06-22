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
if( !$this->_HasSufficientPermissions( 'removeusers' ) ) return;

if (!isset ($params['user_id']) || $params['user_id'] == "") {
    $this->_DisplayErrorPage ($id, $params, $returnid,
                              $this->Lang ('error_insufficientparams'));
    return;
}

$user = $this->GetUserInfo( $params['user_id'] );
if( !is_array($user) || $user[0] == FALSE )
  {
    $this->_DisplayErrorPage ($id, $params, $returnid, $this->Lang('error_usernotfound') );
    return;
  }

// Get all of the property definitions, if they're of type 6
// and the property is not empty, then we may
// have to delete a file as well.
$defns = $this->GetPropertyDefns();
$props = $this->GetUserProperties( $params['user_id'] );
$prop_ary = array();
$destDir1 = $gCms->config['uploads_path'].DIRECTORY_SEPARATOR;
$destDir1 .= $this->GetPreference('image_destination_path','feusers').DIRECTORY_SEPARATOR;
if( $props )
  {
    foreach( $defns as $onedefn )
      {
	if( $onedefn['type'] != 6 ) continue;

	foreach( $props as $oneprop )
	  {
	    if( $oneprop['title'] != $onedefn['name'] ) continue;

	    // found a match, we have a type 6 field.
	    if( $oneprop['data'] == '' ) continue;

	    // and one with a value too.
	    $file1 = $destDir1.$oneprop['data'];
	    @unlink( $file1 );
	  }
      }
	foreach ($props as $one_prop)
	{
		$prop_ary[$one_prop['title']] = $one_prop['data'];
	}
  }

$ret = $this->DeleteUserFull( $params['user_id'] );
if( $ret[0] == FALSE )
  {
    $this->_DisplayErrorPage ($id, $params, $returnid, $ret[1] );
    return;
  }

// send an event
$parms = array();
$parms['id'] = $params['user_id'];
$parms['username'] = $user[1]['username'];
$parms['props'] = $prop_ary;
$this->SendEvent( 'OnDeleteUser', $parms );
$this->_SendNotificationEmail('OnDeleteUser',$parms);

// and log it
$this->Audit( 0, $this->Lang('friendlyname'),'Deleted User '.$params['user_id']);

$this->RedirectToTab($id, 'users' );

// EOF
?>
