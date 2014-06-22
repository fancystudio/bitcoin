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
if( !$this->_HasSufficientPermissions( 'editprefs' ) ) return;

if( isset( $params['input_removeall'] ) )
  {
    $this->ExpireTempCodes('-5 years');
    $this->RedirectToTab($id, 'prefs', '', 'admin_settings');
  }
else if( isset( $params['input_remove1week'] ) )
  {
    $this->ExpireTempCodes('-1 week');
    $this->RedirectToTab($id, 'prefs', '', 'admin_settings');
  }
else if( isset( $params['input_remove1month'] ) )
  {
    $this->ExpireTempCodes('-1 month');
    $this->RedirectToTab($id, 'prefs', '', 'admin_settings');
  }
else if( isset( $params['cancel'] ) )
  {
    $this->RedirectToTab($id, 'prefs', '', 'admin_settings');
  }


$this->SetPreference('auto_create_unknown',(int)$params['auto_create_unknown']);
$this->SetPreference('auth_module',trim($params['auth_module']));

$randomusername = 0;
if( isset( $params['input_randomusername']) )
  {
    $randomusername = (int)$params['input_randomusername'];
  }
$this->SetPreference('use_randomusername',$randomusername);

if( isset( $params['input_expireage']) )
  {
    $this->SetPreference('expireage_months',(int)$params['input_expireage']);
  }


$this->SetPreference('user_session_expires', $params['input_sessiontimeout']);

$cookie_keepalive = 0;
if( isset( $params['input_cookiekeepalive'] ) ) {
  $cookie_keepalive = $params['input_cookiekeepalive'];
}
$this->SetPreference('cookie_keepalive',$cookie_keepalive);

if( isset($params['input_signin_button']) ) {
  $this->SetPreference('signin_button', $params['input_signin_button']);
}

$this->SetPreference('allow_repeated_logins',(isset($params['input_allow_repeated_logins'])?$params['input_allow_repeated_logins']:0));
$this->SetPreference('image_destination_path',$params['input_image_destination_path']);
$this->SetPreference('allowed_image_extensions',$params['input_allowed_image_extensions']);
if (isset($params['notifications'])) {
  $this->SetPreference('notifications',implode(',',$params['notifications']));
}
$this->SetPreference('notification_address',$params['notification_address']);
$this->SetPreference('notification_subject',$params['notification_subject']);
$this->SetTemplate('notification_template',$params['notification_template']);
    
$query = "SELECT permission_id FROM ".cms_db_prefix()."permissions WHERE permission_name LIKE 'FEU %'";
$count = $db->GetOne($query);

$feusers_specific_permissions = 0;
if( isset( $params['input_feusers_specific_permissions'] ) )
  $feusers_specific_permissions = $params['input_feusers_specific_permissions'];
$this->SetPreference('feusers_specific_permissions',$feusers_specific_permissions);

if (isset($params['input_feusers_specific_permissions']) && $params['input_feusers_specific_permissions']==1)
  {
    // using FEUser-specific permissions, so create them if necessary
    if (intval($count) == 0)
      {
	// create 'em
	$this->CreatePermission('FEU Add Users','Add Front-End Users');
	$this->CreatePermission('FEU Modify Users','Modify Front-End Users');
	$this->CreatePermission('FEU Remove Users','Remove Front-End Users');
	$this->CreatePermission('FEU Add Groups','Add Front-End User Groups');
	$this->CreatePermission('FEU Modify Groups','Modify Front-End User Groups');
	$this->CreatePermission('FEU Modify Group Assignments','Modify Front-End User Group Assignments');
	$this->CreatePermission('FEU Remove Groups','Remove Front-End User Groups');
	$this->CreatePermission('FEU Modify Site Preferences','Modify Front-End Users Site Prefs');
	$this->CreatePermission('FEU Modify FrontEndUserProps','Modify Front-End User Properties');
	$this->CreatePermission('FEU Modify Templates','Modify Front-End User Templates');
      }
  }

$this->SetPreference('forcelogout_times',trim($params['forcelogout_times']));
$this->SetPreference('forcelogout_sessionage',(int)$params['forcelogout_sessionage']);
$this->SetPreference('expireusers_interval',(int)$params['expireusers_interval']);
if( isset($params['pagetype_groups']) ) {
  $this->SetPreference('pagetype_groups',implode(',',$params['pagetype_groups']));
}
$this->SetPreference('pagetype_action',trim($params['pagetype_action']));
$this->SetPreference('pagetype_redirectto',(int)$params['pagetype_redirectto']);
    
$this->RedirectToTab($id, 'prefs', '', 'admin_settings');

// EOF
?>