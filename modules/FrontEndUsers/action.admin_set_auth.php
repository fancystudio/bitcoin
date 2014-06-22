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
if( !isset($gCms) ) return;
if( !$this->CheckPermission('Modify Site Preferences') ) return;
$this->SetCurrentTab('auth');

$query = 'SELECT count(id) FROM '.cms_db_prefix().'module_feusers_users';
$nusers = $db->GetOne($query);
if( $nusers > 0 && isset($params['pwsalt']) )
  {
    $oldsalt = $this->GetPreference('pwsalt');
    if( $oldsalt != $params['pwsalt'] )
      {
	$this->SetError($this->Lang('error_adjustsalt'));
	$this->RedirectToTab($id, 'auth', '', 'admin_settings');
	return;
      }
  }

$this->SetPreference('pwsalt',trim($params['pwsalt']));

$this->SetPreference('require_onegroup',(int)$params['require_onegroup']);
$this->SetPreference('default_group',(int)$params['default_group']);
$this->SetPreference('support_lostun',(int)$params['support_lostun']);
$this->SetPreference('allow_changeusername',(int)$params['allow_changeusername']);
$this->SetPreference('support_lostpw',(int)$params['support_lostpw']);
$this->SetPreference('passwordfldlength',(int)$params['pwfldlen']);
$this->SetPreference('min_passwordlength',(int)$params['minpwlen']);
$this->SetPreference('max_passwordlength',(int)$params['maxpwlen']);
$this->SetPreference('usernamefldlength',(int)$params['unfldlen']);
$this->SetPreference('min_usernamelength',(int)$params['minunlen']);
$this->SetPreference('max_usernamelength',(int)$params['maxunlen']);
$this->SetPreference('cookiename',trim($params['cookiename']));
$this->SetPreference('cookie_keepalive',(int)$params['cookie_keepalive']);
$this->SetPreference('username_is_email',(int)$params['username_is_email']);
$this->SetPreference('allow_duplicate_emails',(int)$params['allow_duplicate_emails']);
$this->SetPreference('allow_duplicate_reminders',(int)$params['allow_duplicate_reminders']);

$this->SetPreference('signin_button',trim($params['signin_button']));
$this->SetPreference('required_field_marker',trim($params['required_field_marker']));
$this->SetPreference('required_field_color',trim($params['required_field_color']));
$this->SetPreference('hidden_field_marker',trim($params['hidden_field_marker']));
$this->SetPreference('hidden_field_color',trim($params['hidden_field_color']));
$this->SetPreference('secure_field_marker',trim($params['secure_field_marker']));
$this->SetPreference('secure_field_color',trim($params['secure_field_color']));

$this->SetPreference('pageidforgotpasswd',trim($params['pageidforgotpasswd']));
$this->SetPreference('pageid_changesettings',trim($params['pageid_changesettings']));
$this->SetPreference('pageid_login',trim($params['pageid_login']));
$this->SetPreference('pageid_logout',trim($params['pageid_logout']));
$this->SetPreference('pageid_afterverify',trim($params['pageid_afterverify']));
$this->SetPreference('pageid_afterchangesettings',trim($params['pageid_afterchangesettings']));

if( isset($params['ecomm_ordercancelled']) )
  {
    $this->SetPreference('ecomm_paidregistration',(int)$params['ecomm_paidregistration']);
    if( $this->GetPreference('ecomm_paidregistration') )
      {
	$this->AddEventHandler('CGEcommerceBase','OrderUpdated',false);
	$this->AddEventHandler('CGEcommerceBase','OrderDeleted',false);
      }
    else
      {
	$this->RemoveEventHandler('CGEcommerceBase','OrderUpdated');
	$this->RemoveEventHandler('CGEcommerceBase','OrderDeleted');
      }
    $this->SetPreference('ecomm_ordercancelled',trim($params['ecomm_ordercancelled']));
    $this->SetPreference('ecomm_orderdeleted',trim($params['ecomm_orderdeleted']));
  }
$this->RedirectToTab($id, 'auth', '', 'admin_settings');