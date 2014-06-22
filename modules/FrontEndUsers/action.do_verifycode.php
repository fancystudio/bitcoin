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

    $uid = '';
    if( isset( $params['input_uid'] ) )
      {
	$uid = trim($params['input_uid']);
      }
    $code = '';
    if( isset( $params['input_code'] ) )
      {
	$code = trim($params['input_code']);
      }
    $password = '';
    if( isset( $params['input_password'] ) )
      {
	$password = trim($params['input_password']);
      }
    $repeatpassword = '';
    if( isset( $params['input_repeatpassword'] ) )
      {
	$repeatpassword = trim($params['input_repeatpassword']);
      }

    if( $password == '' || $repeatpassword == '' || 
	$password != $repeatpassword || !$this->IsValidPassword($password))
      {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_invalidpassword');
	$this->myRedirect( $id, 'verifycode', $returnid, $params );
	return;
      }

    // now we have to verify the code
    $result = $this->GetUserTempCode( $uid );
    if( $result[0] == FALSE )
      {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_tempcodenotfound');
	$this->myRedirect( $id, 'verifycode', $returnid, $params );
	return;
      }
    $dbcode = $result[1]['code'];

    if( $dbcode != $code )
      {
	$params['error'] = 1;
	$params['message'] = $this->Lang('error_invalidcode');
	$this->myRedirect( $id, 'verifycode', $returnid, $params );
	return;
      }

    // whew, we got it... now we can reset the password
    $ret = $this->SetUserPassword( $uid, $password );
    if( $ret[0] != TRUE )
      {
	$params['error'] = 1;
	$params['message'] = $ret[1];
	$this->myRedirect( $id, 'verifycode', $returnid, $params );
	return;
      }

    // and delete the code
    $this->RemoveUserTempCode( $uid );

    // and send an event
    $event_params = array();
    $event_params['name'] = $this->GetUsername($uid);
    $event_params['id'] = $uid;
    $this->SendEvent('OnUpdateUser',$event_params);
    $this->_SendNotificationEmail('OnUpdateUser',$event_params);

    // And redirect to a specified page
    $page = $this->GetPreference('pageid_afterverify');
    if( isset( $params['returnto'] ) )
      {
	$page = $params['returnto'];
      }

    $smarty->assign('username',$event_params['name']);
    $groups = $this->GetMemberGroupsArray( $uid );
    $groupname = $this->GetGroupName( $groups[0]['groupid'] );
    $smarty->assign('groupname',$groupname);
    $page = $this->ProcessTemplateFromData($page);

    if( $page )
      {
	$pageid = ContentManager::get_instance()->GetPageIDFromAlias( $page );
	if( $pageid )
	  {
	    $this->RedirectContent( $pageid );
	    return;
	  }
	die( "couldn't get pageid for $page" );
      }
    $this->RedirectContent($returnid);

#
# EOF
#
?>
