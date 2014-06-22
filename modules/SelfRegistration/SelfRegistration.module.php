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

require_once(__DIR__."/functions.php" );

final class SelfRegistration extends CGExtensions
{

  var $dflt_emailconfirm_template = '
<!-- EmailConfirm template -->
<html>
<body>
<p>Greetings {$name} welcome to the site.  This email is being sent because somebody registered for access to {$sitename} using this email address. If this was you, please click on the following link and enter your username, password, and the unique code below</p>
   <p>Follow this link: {$link}</p>
   <p>or this link: {$smalllink}</p>
   <p>Code: {$code}</p>
</body>
</html>
<!-- EmailConfirm template -->
';

  var $dflt_emailconfirm_texttemplate = '
Greetings {$name} welcome to the site.  This email is being sent because somebody registered for access to {$sitename} using this email address. If this was you, please click on the following link and enter your username, password, and the unique code below.

Follow this link: {$url}
or this link: {$smallurl}</p>
Code: {$code}
';

  var $dflt_emailuseredited_template = '
<!-- EmailUserEdited template -->
<html>
<body>
<p>Greetings {$name} welcome to the site.  This email is being sent because, although you have already registered with {$sitename}, there was an error in your input.  The administrator has done his best to correct this data, and you are now being sent an updated registration form. Please click on the following link and enter your username, password, and the unique code below</p>
   <p>Follow this link: {$link}</p>
   <p>or this link: {$smalllink}</p>
   <p>Password: {$password}</p>
   <p>Code: {$code}</p>
</body>
</html>
<!-- EmailUserEdited template -->
';

  var $dflt_emailuseredited_texttemplate = '
Greetings {$name} welcome to the site.  This email is being sent because, although you have already registered with {$sitename}, there was an error in your input.  The administrator has done his best to correct this data, and you are now being sent an updated registration form. Please click on the following link and enter your username, password, and the unique code below
   Follow this link: {$url}
     or this link: {$smallurl}</p>
   Password: {$password}
   Code: {$code}
';

  var $dflt_finalmessage_template = '
<!-- FinalMessage Template -->
<p>Welcome {$username} to {$sitename}.  Your registration is complete.  Please login to continue</p>
<!-- FinalMessage Template -->
  ';

  var $dflt_sendanotheremail_template = '
<!-- SendAnotherEmail Template -->
{$title}
{if isset($message) && $message != \'\'}
  {if isset($message) && $error != \'\'}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<p>I didn\'t receive my confirmation email, please send another one.</p>
<p>My Username is: {$startform}{$input_username}&nbsp;{$submit}{$endform}</p>
<!-- SendAnotherEmail Template -->
  ';

  var $dflt_post_sendanotheremail_template = '
<!-- Post SendAnotherEmail template -->
{$title}
{if isset($message) && $message != \'\'}
  {if isset($error) && $error != \'\'}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
<p>Thank you {$username} for registering with {$sitename}.  We are sorry you had difficulty receiving your email.  A second email has been sent to {$email} with instructions on how to continue the registration process</p>
<!-- Post SendAnotherEmail template -->
';

  public function AllowAutoInstall() { return FALSE; }
  public function AllowAutoUpgrade() { return FALSE; }
  public function GetName() { return 'SelfRegistration'; }
  public function GetFriendlyName() { return $this->Lang('friendlyname'); }
  public function MinimumCMSVersion() { return '1.11.8'; }
  public function LazyLoadAdmin() { return TRUE; }
  public function GetVersion() { return '1.8.2'; }
  public function GetHelp() { return @file_get_contents(__DIR__.'/help.inc'); }
  public function GetAuthor() { return 'Calguy1000'; }
  public function GetAuthorEmail() { return 'calguy1000@hotmail.com'; }
  public function GetChangeLog() { return file_get_contents(__DIR__.'/changelog.inc'); }
  public function IsPluginModule() { return true; }
  public function HasAdmin() { return true; }
  public function GetAdminSection() { return 'usersgroups'; }
  public function GetEventDescription( $eventname ) { return $this->Lang('event_description_'.$eventname ); }
  public function GetEventHelp( $eventname ) { return $this->Lang('event_help_'.$eventname ); }
  public function GetAdminDescription() { return $this->Lang('moddescription'); }
  public function InstallPostMessage() { return $this->Lang('postinstall'); }
  public function UninstallPostMessage() { return $this->Lang('postuninstall'); }

  public function VisibleToAdminUser()
  {
    $status = $this->CheckPermission('Manage Registering Users')
      || $this->CheckPermission('Modify Site Preferences')
      || $this->CheckPermission('Modify Templates');
    return $status;
  }

  public function GetDependencies()
  {
    return array('CGExtensions' => '1.38.1','FrontEndUsers' => '1.22.3' );
  }
  
  public function HandlesEvents()
  {
    return $this->GetPreference('allowpaidregistration',0);
  }

  public function InitializeAdmin()
  {
    $this->CreateParameter('action','default',$this->Lang('help_param_action'));
    $this->CreateParameter('destpage','',$this->Lang('help_param_destpage'));
    $this->CreateParameter('group','',$this->Lang('help_param_group'));
    $this->CreateParameter('onlyhref','',$this->Lang('help_param_onlyhref'));
    $this->CreateParameter('linktext','',$this->Lang('help_param_linktext'));
    $this->CreateParameter('noinline','',$this->Lang('help_param_noinline'));
    $this->CreateParameter('allowoverwrite','',$this->Lang('help_param_allowoverwrite'));
    $this->CreateParameter('nofinalmessage','',$this->Lang('help_param_nofinalmessage'));
  }

  public function InitializeFrontend()
  {
    $this->RegisterModulePlugin();
    $this->RestrictUnknownParams();

    $this->SetParameterType('mode',CLEAN_STRING);
    $this->SetParameterType('nocaptcha',CLEAN_INT);
    $this->SetParameterType('group',CLEAN_STRING);
    $this->SetParameterType('noinline',CLEAN_INT);
    $this->SetParameterType('destpage',CLEAN_STRING);
    $this->SetParameterType('group',CLEAN_STRING);
    $this->SetParameterType('pkg',CLEAN_INT);
    $this->SetParameterType('onlyhref',CLEAN_INT);
    $this->SetParameterType('linktext',CLEAN_STRING);
    $this->SetParameterType('noinline',CLEAN_INT);
    $this->SetParameterType('allowoverwrite',CLEAN_INT);
    $this->SetParameterType('nofinalmessage',CLEAN_INT);
    $this->SetParameterType('input_username',CLEAN_STRING);
    $this->SetParameterType('input_code',CLEAN_STRING);
    $this->SetParameterType('input_group_id',CLEAN_INT); // todo, remove me.
    $this->SetParameterType('input_password',CLEAN_STRING);
    $this->SetParameterType('linktext',CLEAN_STRING);
    $this->SetParameterType(CLEAN_REGEXP.'/sr_.*/',CLEAN_STRING);
    $this->SetParameterType(CLEAN_REGEXP.'/selfreg_.*/',CLEAN_STRING);

    $this->RegisterRoute('/[Ss]elfreg\/register\/(?P<returnid>[0-9]+)\/(?P<group>.*)$/',
			 array('action'=>'default','mode'=>'signup'));
    $this->RegisterRoute('/[Ss]elfreg\/confirm\/(?P<returnid>[0-9]+)\/(?P<input_code>.*?)\/(?P<input_username>.*?)$/',
			 array('action'=>'default','mode'=>'verify'));
    $this->RegisterRoute('/[Ss]elfreg\/confirm\/(?P<returnid>[0-9]+)\/(?P<input_code>.*?)$/',
			 array('action'=>'default','mode'=>'verify'));
  }

  // deprecated
  protected function myRedirectToTab( $id, $tab, $params = '' )
  {
    $parms = array();
    if( is_array( $params ) ) $parms = $params;
    unset( $parms['hidden_password'] );
    unset( $parms['hidden_repeatpassword'] );
    unset( $parms['input_password'] );
    unset( $parms['input_repeatpassword'] );
    unset( $parms['password'] );
    unset( $parms['repeatpassword'] );
    unset( $parms['action'] );
    $this->RedirectToTab($id,$tab,$parms);
  }

  protected function myRedirect( $id, $action, $returnid, $params = '' )
  {
    // unset any password things 
    unset( $params['hidden_password'] );
    unset( $params['hidden_repeatpassword'] );
    unset( $params['input_password'] );
    unset( $params['input_repeatpassword'] );
    unset( $params['password'] );
    unset( $params['repeatpassword'] );
    unset( $params['action'] );
    return $this->DoAction($action, $id, $params, $returnid);
  }

  public function DoAction($action, $id, $params, $returnid=-1)
  {
    $gCms = cmsms();
    $smarty = $gCms->GetSmarty();
    $smarty->assign('selfregactionid',$id);
    $smarty->assign('selfregparams',$params);
    $smarty->assign('mod',$this);
    $smarty->assign($this->GetName(),$this);

    switch ($action) {
      case 'deletetempuser':
	if( $this->CheckPermission('Manage Registering Users' ) ) {
	  $this->_DoDeleteUser( $id, $params, $returnid );
        }
	else {
	  $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
	}
	break;

      case 'do_deleteusersbulk':
        if( $this->CheckPermission('Manage Registering Users' ) ) {
	  $this->_DoDeleteBulkUsers( $id, $params, $returnid );
        }
        else {
	  $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
        }
        break;

      case 'set_reg1template':
        if( $this->CheckPermission( 'Modify Templates' ) ) {
	  $this->_SetAdminReg1Template( $id, $params, $returnid );
	}
	else {
          $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
        }
        break;

      case 'set_reg2template':
        if( $this->CheckPermission( 'Modify Templates' ) ) {
          $this->_SetAdminReg2Template( $id, $params, $returnid );
	}
        else {
	  $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
	}
	break;

      case 'set_emailconfirm_template':
        if( $this->CheckPermission( 'Modify Templates' ) ) {
          $this->_SetAdminEmailConfirmTemplate( $id, $params, $returnid );
	}
	else {
          $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
        }
	break;

      case 'set_emailuseredited_template':
        if( $this->CheckPermission( 'Modify Templates' ) ) {
          $this->_SetAdminEmailUserEditedTemplate( $id, $params, $returnid );
	}
	else {
          $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
	}
	break;

      case 'set_finalmessage_template':
        if( $this->CheckPermission( 'Modify Templates' ) ) {
	  $this->_SetAdminFinalMessageTemplate( $id, $params, $returnid );
        }
	else {
          $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
	}
	break;

      case 'set_sendanotheremail_template':
        if( $this->CheckPermission( 'Modify Templates' ) ) {
	  $this->_SetAdminSendAnotherEmailTemplate( $id, $params, $returnid );
	}
	else {
          $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
	}
	break;

      default:
        return parent::DoAction($action, $id, $params, $returnid );
	break;
      } // switch
  }


  /*---------------------------------------------------------
   _CreateFrontendUser($id, $params, $return_id )
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _CreateFrontendUser( $tmpid, $username, $password, $expires = '', $do_md5 = true )
  {
    $gCms = cmsms();
    $db = $gCms->GetDb(); 
    $feusers = $this->GetModuleInstance('FrontEndUsers');
    if( !$feusers ) return array(FALSE,$this->Lang('error_nofeusersmodule'));

    $query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_users WHERE id = ?';
    $row = $db->GetRow($query,array($tmpid));
    if( !$row ) return array(FALSE,$this->Lang('error_usernotfound'));

    $q = 'SELECT gid FROM '.cms_db_prefix().'module_selfreg_grps WHERE user = ?';
    $grps = $db->GetCol($q,array($tmpid));
    if( !is_array($grps) || count($grps) == 0 ) {
      $gid = $this->GetPreference('default_group', -1);
      if( $gid != -1 ) $grps = array($gid);
    }
    if( !is_array($grps) || count($grps) == 0 ) return array(FALSE,$this->Lang('error_nogroups'));

    if( $expires == '' ) {
      $timeperiod = $feusers->GetPreference('expireage_months',120);
      $expires = strtotime("+{$timeperiod} months",time());
    }
    if( $row['overwrite_uid'] ) {
      // we're overwriting a user account
      $result = $feusers->SetUser( $row['overwrite_uid'], $username, $password, $expires, $do_md5 );
if( $result[0] == false ) return array(FALSE,$result[1]);
    }
    else {
      $result = $feusers->AddUser( $username, $password, $expires, $do_md5 );
      if( $result[0] == false ) return array(FALSE,$result[1]);
    }

    $uid = $result[1];
    $feusers->SetEncryptionKey($uid,1);
 
    // and add the user to whatever group specified in the groups parameter
    if( is_array($grps) && count($grps) ) {
      foreach( $grps as $gid ) {
	$res = $feusers->AssignUserToGroup( $uid, $gid );
	if( !$res ) return array(FALSE,$this->Lang('warning_couldnotaddgroup'));
      }
    }    
    
    // he's in.... he's in... now just add his properties
    $q = "SELECT * FROM ".cms_db_prefix()."module_selfreg_properties WHERE user = ?";
    $dbresult = $db->Execute( $q, array( $tmpid ) );
    if( !$dbresult ) return array(FALSE,$this->Lang('error_dberror'));
    while( $row = $dbresult->FetchRow() ) {
      $feusers->SetUserPropertyFull( $row['title'], $row['data'], $uid );
    }

    // send an event
    $this->SendEvent('onUserRegistered', array('username'=>$username, 'id'=>$uid));

    // and notify the administrator
    // if the admin wants notifications.
    // off we go.
    if( $this->GetPreference('notify_on_registration') ) {
	$cmsmailer = $this->GetModuleInstance('CMSMailer');
	if( !$cmsmailer ) return array(FALSE,$this->Lang('error_nocmsmailermodule'));

	$tmp = $this->GetPreference('send_emails_to');
	if( $tmp ) {
	  $list = cge_array::smart_explode($tmp);
	  foreach( $list as $one ) {
	    $cmsmailer->AddAddress($one);
	  }
	  $cmsmailer->SetSubject('A new user has registered on '.$gCms->config['root_url']);
	  $msg = 'A new user ('.$username.' with uid '.$uid.') has completed registration to your site. you should check this user out and validate that the information provided is as complete and valid as possible.';
	  $cmsmailer->SetBody($msg);  
	  $cmsmailer->IsHTML(false); // we're not sending an html mail
	  $cmsmailer->Send();
	}
    }

    $this->Audit( '', $this->Lang('friendlyname'), $this->Lang('info_userverified').": ".$username);
    return array(TRUE,$uid);
  }


  /*---------------------------------------------------------
   DisplayErrorPage($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _DisplayErrorPage($id, &$params, $returnid, $message='')
  {
    $this->smarty->assign('title_error', $this->Lang('error'));
    if ($message != '')	$this->smarty->assign('message', $message);
    
    // Display the populated template
    echo $this->ProcessTemplate('error.tpl');
  }


  /*---------------------------------------------------------
   _DoDeleteBulkUsers($id, $params, $return_id)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _DoDeleteBulkUsers( $id, &$params, $returnid )
  {
    $tmp = array();
    foreach( $params as $key => $value ) {
      if( $key == 'markdelete_'.$value ) $tmp[] = $value;
    }
    if( count($tmp) ) $this->DeleteTempUser($tmp);
    $this->myRedirectToTab($id,'adminusers');
  }


  /*---------------------------------------------------------
   _DoDeleteUser($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _DoDeleteUser( $id, &$params, $returnid )
  {
    if( !isset( $params['user_id'] ) ) {
      // this is ugly for the user to see
      // but at least the admin will be able to figure it out
      $this->_DisplayErrorPage( $id, $params, $returnid, $this->Lang('error_insufficientparams'));
      return;
    }

    $id = $params['user_id'];
    $this->DeleteTempUser( $id ); 
    $this->myRedirectToTab('','adminusers');
  }


  /*---------------------------------------------------------
   SendUserConfirmationEmail($address,$username,$code);
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _SendUserConfirmationEmail($id,$returnid,$address,$username,$code)
  {
    $config = cmsms()->GetConfig();
    $cmsmailer = $this->GetModuleInstance('CMSMailer');
    if( !$cmsmailer ) return false;

    $cmsmailer->AddAddress( $address );
    $this->smarty->assign('name',$username);
    $this->smarty->assign('code',$code);
    $this->smarty->assign('sitename', $config['root_url']);
    $parms = array( 'mode' => 'verify', 'sr_input_username' => $username, 'sr_input_code' => $code );
    $prettyurl = "Selfreg/confirm/$returnid/$code/$username";
    $url = $this->CreateLink($id,'default',$returnid,'',$parms,'',true,true,'',false,$prettyurl);
    $this->smarty->assign('url',$url);
    $this->smarty->assign('link',$this->CreateLink($id,'default',$returnid,$url,$parms,'',false,true,'',false,$prettyurl));

    $prettyurl = "Selfreg/confirm/$returnid/$code";
    $smallurl = $this->CreateLink( $id, 'default', $returnid, '', array('mode' => 'verify'),'',true, true,'',false,$prettyurl);
    $this->smarty->assign('smallurl',$smallurl);
    $this->smarty->assign('smalllink',
			  $this->CreateLink($id,'default',$returnid,$smallurl,array('mode'=>'verify'),'',false,true,'',false,$prettyurl));
    $htmlbody = $this->ProcessTemplateFromDatabase('selfreg_emailconfirm_template');
    $textbody = $this->ProcessTemplateFromDatabase('selfreg_emailconfirm_texttemplate');
    $cmsmailer->SetBody( $textbody );
    if( $htmlbody != '' ) {
      $cmsmailer->IsHTML(true);  // we're sending an html mail
      $cmsmailer->SetBody( $htmlbody );
      $cmsmailer->SetAltBody( $textbody );
    }
    else {
      $cmsmailer->IsHTML(false);  // we're sending an html mail
      $cmsmailer->SetBody( $textbody );
    }
    $cmsmailer->SetSubject($this->GetPreference('selfreg_emailconfirm_subject',$this->Lang('registration_confirmation')));
    $cmsmailer->Send();
  }


  /*---------------------------------------------------------
   SetAdminReg1Template($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _SetAdminReg1Template( $id, &$params, $returnid )
  {
    if( isset( $params['defaultbutton'] ) ) {
      $this->SetTemplate( 'selfreg_reg1template', file_get_contents(__DIR__.'/templates/orig_registration1.tpl'));
      $this->SetTemplate( 'selfreg_postreg1_template', file_get_contents(__DIR__.'/templates/orig_postreg1.tpl'));
    }
    else if( isset( $params['reg1_templatecontent'] ) || isset( $params['postreg1_templatecontent'] ) ) {
      $this->SetTemplate( 'selfreg_reg1template', $params['reg1_templatecontent'] );
      $this->SetTemplate( 'selfreg_postreg1_template', $params['postreg1_templatecontent'] );
    }
    $this->myRedirectToTab( $id, 'reg1template' );
  }


  /*---------------------------------------------------------
   SetAdminReg2Template($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _SetAdminReg2Template( $id, &$params, $returnid )
  {
    if( isset( $params['defaultbutton'] ) ) {
      $this->SetTemplate( 'selfreg_reg2template', file_get_contents(__DIR__.'/templates/orig_registration2.tpl'));
    }
    else if( isset( $params['templatecontent'] ) ) {
      $this->SetTemplate( 'selfreg_reg2template',$params['templatecontent'] );
    }
    $this->myRedirectToTab( $id, 'reg2template' );
  }


  /*---------------------------------------------------------
   SetAdminEmailConfirmationTemplate($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _SetAdminEmailConfirmTemplate( $id, &$params, $returnid )
  {
    if( isset( $params['defaultbutton'] ) ) {
      $this->SetTemplate( 'selfreg_emailconfirm_template',$this->dflt_emailconfirm_template );
      $this->SetTemplate( 'selfreg_emailconfirm_texttemplate',$this->dflt_emailconfirm_texttemplate );
    }
    else {
      $htmltemplate = '';
      $texttemplate = '';
      $subject = '';
      if( isset( $params['templatecontent'] ) ) $htmltemplate = $params['templatecontent'];
      if( isset( $params['texttemplatecontent'] ) )  $texttemplate = $params['texttemplatecontent'];
      if( isset( $params['input_subject'] ) ) $subject = $params['input_subject'];
      if( $subject == '' ) {
	$this->_DisplayErrorPage($id,$params,$returnid, $this->Lang('error_mustspecifysubject'));
	return;
      }
      if( $texttemplate == '' ) {
	$this->_DisplayErrorPage($id,$params,$returnid,$this->Lang('error_mustspecifytexttemplate'));
	return;
      }

      $this->SetTemplate( 'selfreg_emailconfirm_template', $params['templatecontent'] );
      $this->SetTemplate( 'selfreg_emailconfirm_texttemplate', $params['texttemplatecontent'] );
      $this->SetPreference( 'selfreg_emailconfirm_subject', $params['input_subject'] );
    }
    $this->myRedirectToTab( $id, 'emailconfirm_template' );
  }


  /*---------------------------------------------------------
   SetAdminFinalMessageTemplate($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _SetAdminFinalMessageTemplate( $id, &$params, $returnid )
  {
    if( isset( $params['defaultbutton'] ) ) {
      $this->SetTemplate( 'selfreg_finalmessage_template',$this->dflt_finalmessage_template );
    }
    else if( isset( $params['templatecontent'] ) ) {
      $this->SetTemplate( 'selfreg_finalmessage_template', $params['templatecontent'] );
    }
    $this->myRedirectToTab( $id, 'finalmessage_template' );
  }


  /*---------------------------------------------------------
   SetAdminEmailConfirmationTemplate($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _SetAdminEmailUserEditedTemplate( $id, &$params, $returnid )
  {
    if( isset( $params['defaultbutton'] ) ) {
      $this->SetTemplate( 'selfreg_emailuseredited_template', $this->dflt_emailuseredited_template );
      $this->SetTemplate( 'selfreg_emailuseredited_texttemplate', $this->dflt_emailuseredited_texttemplate );
    }
    else {
      $htmltemplate = '';
      $texttemplate = '';
      $subject = '';
      if( isset( $params['templatecontent'] ) ) $htmltemplate = $params['templatecontent'];
      if( isset( $params['texttemplatecontent'] ) ) $texttemplate = $params['texttemplatecontent'];
      if( isset( $params['input_subject'] ) ) $subject = $params['input_subject'];
      if( $subject == '' ) {
	$this->_DisplayErrorPage($id,$params,$returnid, $this->Lang('error_mustspecifysubject'));
	return;
      }
      if( $texttemplate == '' ) {
	$this->_DisplayErrorPage($id,$params,$returnid, $this->Lang('error_mustspecifytexttemplate'));
	return;
      }

      $this->SetTemplate( 'selfreg_emailuseredited_template', $params['templatecontent'] );
      $this->SetTemplate( 'selfreg_emailuseredited_texttemplate', $params['texttemplatecontent'] );
      $this->SetPreference( 'selfreg_emailuseredited_subject', $params['input_subject'] );
    }
    $this->myRedirectToTab( $id, 'emailuseredited_template' );
  }


  /*---------------------------------------------------------
   SetAdminSetAnotherEmailTemplate($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
  protected function _SetAdminSendAnotherEmailTemplate( $id, &$params, $returnid )
  {
    if( isset( $params['defaultbutton'] ) ) {
      $this->SetTemplate( 'selfreg_sendanotheremail_template', $this->dflt_sendanotheremail_template );
      $this->SetTemplate( 'selfreg_post_sendanotheremail_template', $this->dflt_post_sendanotheremail_template );
    }
    else if( isset( $params['templatecontent'] ) ) {
      $this->SetTemplate( 'selfreg_sendanotheremail_template', $params['templatecontent'] );
      $this->SetTemplate( 'selfreg_post_sendanotheremail_template', $params['templatecontent2'] );
    }
    $this->myRedirectToTab( $id, 'sendanotheremail_template' );
  }


  /////////////////////////////////////////////////////////////////
  // API FUNCTIONS
  /////////////////////////////////////////////////////////////////

  public function AddTempUserProperty( $uid, $propname, $propvalue )
  {
    $db = $this->GetDb();
    $id = $db->GenID(cms_db_prefix()."module_selfreg_users_seq");
    $q = "INSERT INTO ".cms_db_prefix()."module_selfreg_properties VALUES (?,?,?,?)";
    $dbresult = $db->Execute( $q, array( $id, $uid, $propname, $propvalue ) );
    if( !$dbresult ) return array(FALSE,$db->sql.' - '.$db->ErrorMsg());
    return array(TRUE);
  }


  public function CountTempUsers()
  {
    $db = $this->GetDb();
    $q = "SELECT count(id) as count FROM ".cms_db_prefix()."module_selfreg_users";
    $dbresult = $db->Execute( $q );
    if( !$dbresult ) return false;
    $row = $dbresult->FetchRow();
    return $row['count'];
  }


  public function CreateTempUser( $gid, $username, $password, $code, $overwrite_uid = null )
  {
    $db = $this->GetDb();
    if( $username == '' || $password == '' ) return false;

    $feu = cms_utils::get_module('FrontEndUsers');
    $salt = $feu->GetPreference('pwsalt');

    // get an id
    $id = $db->GenID(cms_db_prefix()."module_selfreg_users_seq");
    $q = "INSERT INTO ".cms_db_prefix()."module_selfreg_users (id,username,passsword,code,createdate,overwrite_uid)
          VALUES (?,?,?,?,NOW(),?)";
    $dbresult = $db->Execute( $q, array( $id, $username, md5($password.$salt), $code, $overwrite_uid ) );
    if( !$dbresult ) return array(FALSE,$db->ErrorMsg());

    $q = 'INSERT INTO '.cms_db_prefix().'module_selfreg_grps (user,gid) VALUES (?,?)';
    if( !is_array($gid) ) $gid = array((int)$gid);
    foreach( $gid as $one ) {
      $dbr = $db->Execute($q,array($id,$one));
    }

    $this->Audit($id,$this->GetName(),sprintf('User %s registered',$username));
    return array(TRUE,$id);
  }


  function CSVOldTempUsers($expirycode)
  {
    $db = $this->GetDb();
    $expires = $db->DbTimeStamp(strtotime( $expirycode ));
    // find all the user id's that match
    $q = "SELECT * FROM ".cms_db_prefix()."module_selfreg_users WHERE createdate < ?";
    $dbresult = $db->Execute( $q, array( $expires ) ); 
    $result = '';

    while( $row = $dbresult->FetchRow() ) {
      $vals = array_values( $row );
      $result .= $row['id'].",".$row['username'].",".$row['code'].",".$row['createdate'].",";
      $q2 = "SELECT * FROM ".cms_db_prefix()."module_selfreg_properties WHERE user = ? ORDER by id";
      $dbresult2 = $db->Execute( $q2, array( $row['id'] ) );
      while( $row2 = $dbresult2->FetchRow() ) {
	$result .= $row2['data'].",";
      }
      $result .= "end\n";
    }

    return $result;
  }


  public function EditTempUser( $uid, $username, $password, $code = null)
  {
    $db = $this->GetDb();
    if( $username == '' ) return false;

    $q = "UPDATE ".cms_db_prefix()."module_selfreg_users SET username = ?";
    $params = array($username);
    if( $code ) {
      $q .= ",code = ?";
      $params[] = $code;
    }
    if( $password != '' ) {
      $q .= ",passsword = ?";
      $feu = cms_utils::get_module('FrontEndUsers');
      $salt = $feu->GetPreference('pwsalt');
      $params[] = md5($password.$salt);
    }
    $q .= " WHERE id = ?";
    $params[] = $uid;

    $dbresult = $db->Execute( $q, $params );
    if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
    return array(TRUE);
  }


  public function ExpireOldTempUsers($expirycode)
  {
    $db = $this->GetDb();
    $expires = $db->DbTimeStamp(strtotime( $expirycode ));
    // find all the user id's that match
    $q = "SELECT id FROM ".cms_db_prefix()."module_selfreg_users WHERE createdate < ?";
    $dbresult = $db->GetCol( $q, array( $expires ) ); 

    if( is_array($dbresult) && count($dbresult) ) $this->DeleteTempUser($dbresult);
    return TRUE;
  }


  public function DeleteTempUser( $uid )
  {
    if( !is_array($uid) ) $uid = array($uid);

    $db = $this->GetDb();
    $ql = array();
    $q1 = 'DELETE FROM '.cms_db_prefix().'module_selfreg_grps WHERE user IN ('.implode(',',$uid).')';
    $db->Execute( $q1 );
    $q2 = 'DELETE FROM '.cms_db_prefix().'module_selfreg_properties WHERE user IN ('.implode(',',$uid).')';
    $db->Execute( $q2 );
    $q3 = "DELETE FROM ".cms_db_prefix().'module_selfreg_users WHERE id IN ('.implode(',',$uid).')';
    $db->Execute( $q3 );
    return TRUE;
  }


  public function DeleteTempUserProperties( $uid )
  {
    $db = $this->GetDb();
    $q = "DELETE FROM ".cms_db_prefix()."module_selfreg_properties WHERE user = ?";
    $dbresult = $db->Execute( $q, array( $uid ) );
    if( !$dbresult ) return false;
    return true;
  }


  public function GetTempUserDetails( $uid )
  {
    $db = $this->GetDb();
    $q = "SELECT * FROM ".cms_db_prefix()."module_selfreg_users WHERE id = ?";
    $dbresult = $db->GetRow( $q, array( $uid ) );
    if( !is_array($dbresult) ) return FALSE;
    return $dbresult;
  }


  public function GetTempUserID( $username )
  {
    if( $username == '' ) return FALSE;
    $db = $this->GetDb();
    $q = "SELECT * FROM ".cms_db_prefix()."module_selfreg_users WHERE username = ?";
    $dbr = $db->GetOne($q, array($username) );
    if( !$dbr ) return FALSE;
    return $dbr;
  }


  public function GetTempUserProperty( $uid, $propname, $dflt )
  {
    $db = $this->GetDb();
    $q = "SELECT data FROM ".cms_db_prefix()."module_selfreg_properties WHERE user = ? AND title =  ?";
    $dbr = $db->GetOne( $q, array( $uid, $propname ) );
    if( !$dbr ) return $dflt;
    return $dbr;
  }


  public function GetTempUserProperties( $uid )
  {
    $db = $this->GetDb();
    $q = "SELECT * FROM ".cms_db_prefix()."module_selfreg_properties WHERE user = ?";
    $dbresult = $db->Execute( $q, array( $uid ) );
    if( !$dbresult || $dbresult->RecordCount() == 0 ) return false;
    $result = array();
    while( $row = $dbresult->FetchRow() ) {
      $result[] = $row;
    }
    return $result;
  }

  
  public function get_product_info($temp_user_id)
  {
    $res = array();
    $res['id'] = $temp_user_id;
    $res['product_name'] = 'Account Registration';
    return $res;
  }

} // end of class

?>
