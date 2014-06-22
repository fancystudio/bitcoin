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
if( !$this->_HasSufficientPermissions( 'adduser' ) ) return;

// are we cancelling
if (isset ($params['cancel'])) {
  $this->SetCurrentTab('users');
  $this->RedirectToTab($id);
}

// make sure the parameters are filled in
$username = trim($params['input_username']);
$password = trim($params['input_password']);
$repeat   = trim($params['input_repeatpassword']);

$ret = $this->_handleUserInfoValidation( $id, $params, $returnid, $message, true );
switch( $ret ) {
 case -1: // error
   $params['error'] = 1;
   $params['message'] = $message;
   $this->myRedirect( $id, 'adduser', $returnid,$params, true );
   return;
   break;
 case 0:  // no error, but don't continue operation
   $this->myRedirect( $id, 'adduser', $returnid,$params, true );
   return;
   break;
 case 1:  // all is good, continue operation
   break;
}


// convert the expires field to a real time
$expires = NULL;

// and store this all in the params, 
$params['input_username'] = $username;
$params['input_password'] = $password;
$params['input_repeatpassword'] = $repeat;

// and go to step 2
$this->_params_to_session($params);    
$this->myRedirect( $id, 'do_adduser2', $returnid, array(), true );

// EOF
?>