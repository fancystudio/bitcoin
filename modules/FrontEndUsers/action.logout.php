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

$username = $this->LoggedInName();
$uid = $this->LoggedInId();

$this->Logout();

$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('frontenduser_logout').": $username");

$parms = array();
$parms['username'] = $username;
$parms['id'] = $uid;
$this->_SendNotificationEmail('OnLogout',$parms);

// we're logged out
// redirect somewhere 
// todo, add more options here.
$page = '';
$return_url = '';
if( isset($_SESSION['feu_prelogout_url']) )
  {
    $return_url = $_SESSION['feu_prelogout_url'];
    unset($_SESSION['feu_prelogout_url']);
  }
if( $return_url == '' )
  {
    $page = $this->GetPreference('pageid_logout');
    if( isset( $params['returnto'] ) )
      {
	$page = $params['returnto'];
      }
  }

$smarty->assign('username',$username);
$page = str_replace( "{\$username}", $username, $page );
$groups = $this->GetMemberGroupsArray( $uid );
$groupname = $this->GetGroupName( $groups[0]['groupid'] );
$smarty->assign('groupname',$groupname);
$page = $this->ProcessTemplateFromData($page);

if( $return_url != '' )
  {
    redirect($return_url);
  }
if( $page )
  {
    $id = ContentManager::GetPageIDFromAlias( $page );
    if( $id )
      {
	$this->RedirectContent( $id );
	return;
      }
  }
$this->RedirectContent( $returnid );

?>