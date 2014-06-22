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

if( isset($params['cancel'] ) ) {
  if( isset( $params['input_returnto'] ) ) {
    $returnid = $params['input_returnto'];
  }
  $this->RedirectContent($returnid);
  return;
 }

if( !isset( $params['input_username'] )  ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_insufficientparams');
  $params['form'] = 'forgotpw';
  $this->myRedirect( $id, 'default', $returnid,$params );
  return;
 }
    
$captcha = $this->GetModuleInstance('Captcha');
if( is_object($captcha) && !isset($params['nocaptcha']) ) {
  if( !$captcha->CheckCaptcha($params['input_captcha']) ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_captchamismatch');
    $params['form'] = 'forgotpw';
    $this->myRedirect($id,'default',$returnid,$params);
    return;
  }
 }

// see if we can find this user
$uid = $this->GetUserID( $params['input_username'] );
if( !$uid ) {
  $params['error'] = 1;
  $params['message'] = $this->Lang('error_usernotfound');
  $params['form'] = 'forgotpw';
  $this->myRedirect( $id, 'default', $returnid,$params );
  return;
 }

// see if we can dig up an email address for him
$email = $this->GetEmail($uid);
if( !empty($email) ) {
  $cmsmailer =& $this->GetModuleInstance('CMSMailer');
  if( !$cmsmailer ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_nomailermodule');
    $params['form'] = 'forgotpw';
    $this->myRedirect( $id, 'default', $returnid,$params );
    return;
  }
    
  // we found ane mail address
  // generate a code, and store it someplace
  // but that means we gotta clean these things up
  // from time to time.
  $code = $this->GenerateRandomPrintableString();
  if( !$this->SetUserTempCode( $uid, $code ) ) {
    $params['error'] = 1;
    $params['message'] = $this->Lang('error_resetalreadysent');
    $params['form'] = 'forgotpw';
    $this->myRedirect( $id, 'default', $returnid,$params );
    return;
  }
    
  // send our funky email
  $page = $this->GetPreference('pageidforgotpasswd');
  $pid = $returnid;
  if( $page ) {
    $tpid = ContentOperations::get_instance()->GetPageIDFromAlias( $page );
    if( $tpid != false ) $pid = $tpid;
  }
    
  $this->smarty->assign('message_forgotpwemail',
			$this->Lang('message_forgotpwemail'));
  $this->smarty->assign('prompt_code',$this->Lang('message_code'));
  $this->smarty->assign('data_code',$code);
  $this->smarty->assign('prompt_link',$this->Lang('prompt_link'));
  $parms = array( 'input_uid' => $uid, 'input_code' => $code );
  
  $config =& $gCms->GetConfig();
  $prettyurl = "feu/verify/{$pid}/{$uid}/{$code}";
  $link = $this->CreateLink($id,'verifycode',$pid,'',$parms, '', true, false, '', false, $prettyurl);
  
  $this->smarty->assign('data_link',
			$this->CreateLink($id,'verifycode',$pid,$link,$parms));
  $this->smarty->assign('data_url',$link);
  
  $body = $this->ProcessTemplateFromDatabase('feusers_forgotpasswordemailform');
  
  $cmsmailer->AddAddress( $email );
  $cmsmailer->SetBody( $body );
  $cmsmailer->IsHTML(true);
  if( strip_tags($body) != $body ) {
    $cmsmailer->IsHTML(true);
  }
  $cmsmailer->SetSubject($this->Lang('lostpassword_emailsubject'));
  $cmsmailer->Send();
    
  // and tell the user something
  $params['message'] = $this->Lang('info_forgotpwmessagesent',$email);
  $params['skipformdisplay'] = 1;
  $params['form'] = 'forgotpw';
    
  if( isset( $params['input_returnto'] ) ) {
    $returnid = $params['input_returnto'];
  }
    
  $this->myRedirect( $id, 'default', $returnid,$params );
  return;
 }

// we found no email address
$params['error'] = 1;
$params['message'] = $this->Lang('error_couldnotfindemail');
$params['form'] = 'forgotpw';
$this->myRedirect( $id, 'default', $returnid,$params );

// EOF
?>
