<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: SelfRegistration (c) 2008-2013 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to register themselves
#  with a website.
# 
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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

// we have the username (theoretically) in the $params
if( !isset( $params['input_username'] ) ) {
  $parms['mode'] = 'sendanotheremail';
  $parms['error'] = 1;
  $parms['message'] = $this->Lang('error_insufficientparams');
  $parms['mode'] = 'sendanotheremail';
  $this->myRedirect( $id, 'default', $returnid, $parms );
  return;
}
$username = $params['input_username'];

// look up the username and get an id
$tempuserid = $this->GetTempUserID( $username );
if( !$tempuserid ) {
  $parms['error'] = 1;
  $parms['message'] = $this->Lang('error_usernotfound');
  $parms['mode'] = 'sendanotheremail';
  $this->myRedirect( $id, 'default', $returnid, $parms );
  return; 
}

// and whatever details we can from the users table
$details = $this->GetTempUserDetails( $tempuserid );
if( $details == false ) {
  $parms['error'] = 1;
  $parms['message'] = $this->Lang('error_usernotfound');
  $parms['mode'] = 'sendanotheremail';
  $this->myRedirect( $id, 'default', $returnid, $parms );
  return; 
}

$email = '';
if( is_email($username) ) {
  $email = $username;
}
else {
  // now get properties
  $tempuserprops = $this->GetTempUserProperties( $tempuserid );
  if( $tempuserprops == false ) {
    $parms['error'] = 1;
    $parms['message'] = $this->Lang('error_noproperties');
    $parms['mode'] = 'sendanotheremail';
    $this->myRedirect( $id, 'default', $returnid, $parms );
    return; 
  }

  $feusers = $this->GetModuleInstance('FrontEndUsers');
  if( !$feusers ) {
    $parms['error'] = 1;
    $parms['message'] = $this->Lang('error_nofeusersmodule');
    $parms['mode'] = 'sendanotheremail';
    $this->myRedirect( $id, 'default', $returnid, $parms );
    return; 
  }

  // have the group id, get the group property relations
  $relations = $feusers->GetGroupPropertyRelations( $details['group_id'] );
  if( $relations[0] == false ) {
    $parms['error'] = 1;
    $parms['message'] = $relations[1];
    $parms['mode'] = 'sendanotheremail';
    $this->myRedirect( $id, 'default', $returnid, $parms );
    return; 
  }

  $props = $feusers->GetPropertyDefns();
  if( $props == false ) {
    $parms['error'] = 1;
    $parms['message'] = $this->Lang('error_dberror');
    $parms['mode'] = 'sendanotheremail';
    $this->myRedirect( $id, 'default', $returnid, $parms );
    return; 
  }

  // now find an email address property
  // and make sure it's of type 2
  $found = '';
  foreach( $relations as $reln ) {
    foreach( $props as $prop ) {
      if( $prop['type'] == 2 && $reln['name'] == $prop['name'] ) {
	// found an email property
	foreach( $tempuserprops as $tempprop ) {
	  if( $reln['name'] == $tempprop['title'] ) {
	    $found = $tempprop['data'];
	    break;
	  }
	}
      }
      if( $found != '' ) break;
    }
    if( $found != '' ) break;
  }
  if( !$found ) {
    $parms['error'] = 1;
    $parms['message'] = $this->Lang('error_noemailaddress');
    $parms['mode'] = 'sendanotheremail';
    $this->myRedirect( $id, 'default', $returnid, $parms );
    return; 
  }
  $email = $found;
}

$this->_SendUserConfirmationEmail( $id,$returnid,$email, $username, $details['code'] );

// we're not redirecting anywhere we need to display some nice message
// about we just spammed your inbox, etc, etc.
$smarty->assign('sitename', $gCms->config['root_url']);
$smarty->assign('username',$username);
$smarty->assign('email', $found );
echo $this->ProcessTemplateFromDatabase('selfreg_post_sendanotheremail_template');

#
# EOF
#
?>