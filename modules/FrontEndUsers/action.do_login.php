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

// honeypot captcha test
if( isset($params['feu__data']) && $params['feu__data'] != '' ) {
  $params['error'] = $this->Lang('error_captchamismatch');
  include(__DIR__.'/function.user_loginform.php');
  return;
}

$captcha = $this->GetModuleInstance('Captcha');
if( is_object($captcha) && !isset($params['nocaptcha']) ) {
  if (!$captcha->CheckCaptcha($params['input_captcha'])) {
    $params['error'] = $this->Lang('error_captchamismatch');
    include(__DIR__.'/function.user_loginform.php');
    return;
  }
}

if( !isset( $params['feu_input_username'] ) || $params['feu_input_username'] == '' ) {
  $params['error'] = $this->Lang('error_missingusername');
  include(__DIR__.'/function.user_loginform.php');
  return;
}

if( !isset( $params['feu_input_password'] ) || $params['feu_input_password'] == '' ) {
  $params['error'] = $this->Lang('error_missingpassword');
  include(__DIR__.'/function.user_loginform.php');
  return;
}

// now validate the password and username
if (isset($params['only_groups'])) {
  $result = $this->Login( $params['feu_input_username'], $params['feu_input_password'], $params['only_groups'] );
}
else {
  $params['feu_input_password'] = cms_html_entity_decode($params['feu_input_password']);
  $params['feu_input_username'] = cms_html_entity_decode($params['feu_input_username']);
  $result = $this->Login( $params['feu_input_username'], $params['feu_input_password'] );
}
if( $result[0] == false ) {
  $params['error'] = $result[1];
  include(__DIR__.'/function.user_loginform.php');
  return;
}
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('frontenduser_loggedin').": ".$params['feu_input_username'] );

//
// we're logged in
//

// store a cookie ?
if( isset($params['feu_rememberme']) && $params['feu_rememberme'] == 1) {
  if( ($name = $this->GetPreference('cookiename')) != '' ) {
    // this is the only place this data is set.
    $data = array('uid'=>(int)$uid,'time'=>time(),'sessionid'=>$sessionid);
    @setcookie($name,base64_encode(serialize($data)),time()+60*24*3600,'/');
  }
}

// redirect somewhere ?
$userid = $result[0];
$page = '';
$return_url = '';
if( ($url = $this->session_get('postlogin_url')) ) {
  $return_url = trim($url);
  $this->session_clear('postlogin_url');
}
else if( isset($params['returnlast']) && isset($_SESSION['feu_prelogin_url']) ) {
  $return_url = trim($_SESSION['feu_prelogin_url']);
  unset($_SESSION['feu_prelogin_url']);
}
else {
  $page = $this->GetPreference('pageid_login');
  if( isset( $params['returnto'] ) ) $page = $params['returnto'];

  // replace {$groupname} with the first groupname we can find that matches
  $groups = $this->GetMemberGroupsArray( $userid );
  $groupname = $this->GetGroupName( $groups[0]['groupid'] );
  $smarty->assign('username',$params['feu_input_username']);
  $smarty->assign('group',$groupname);
  $page = $this->ProcessTemplateFromData($page);
}

// send the event
$parms = array();
$parms['id'] = $userid;
$parms['username'] = $params['feu_input_username'];
$parms['ip'] = cge_utils::get_real_ip();
$this->SendEvent( 'OnLogin', $parms );
$this->_SendNotificationEmail('OnLogin',$parms);

if( $return_url != '' ) {
  redirect($return_url);
}
else if( $page ) {
  $id = ContentManager::get_instance()->GetPageIDFromAlias( $page );
  if( $id ) {
    $this->RedirectContent( $id );
    return;
  }
  die( "couldn't get pageid for $page" );
}
else {
  $this->RedirectContent( $returnid );
}

?>