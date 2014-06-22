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
if( !$this->_HasSufficientPermissions('templates') ) return;

function _DisplayAdminLoginTemplateTab( &$module, $id, &$params, $returnid )
{
    echo cge_template_admin::get_single_template_form( $module, $id, $returnid, 'feusers_loginform', 'logintemplate', '', 'orig_loginform.tpl', '', 'admin_templates');
}


function _DisplayAdminLogoutTemplateTab( &$module, $id, &$params, $returnid )
{
    echo cge_template_admin::get_single_template_form( $module, $id, $returnid, 'feusers_logoutform', 'logouttemplate', '', 'orig_logoutform.tpl', '', 'admin_templates');
}


function _DisplayAdminChangeSettingsTemplateTab( &$module, $id, &$params, $returnid )
{
    echo cge_template_admin::get_single_template_form( $module, $id, $returnid, 'feusers_changesettingsform', 'changesettings_template', '',
                                                       'orig_changesettings.tpl', '', 'admin_templates');
  $module->smarty->assign('startform',
			  $module->CreateFormStart( $id, 'do_setchangesettingstemplate'));
  $module->smarty->assign('prompt_template',$module->Lang('template'));
  $module->smarty->assign('input_template',
			  $module->CreateTextArea( false, $id,
						   $module->GetTemplate ('feusers_changesettingsform'),
						   'templatecontent'));
  $module->smarty->assign('submit',
			  $module->CreateInputSubmit ($id, 'submit',
						      $module->Lang('submit')));
  $module->smarty->assign('defaults',
			  $module->CreateInputSubmit ($id, 'defaults',
						      $module->Lang('defaults')));
  $module->smarty->assign('endform',$module->CreateFormEnd());
  echo $module->ProcessTemplate('templateform.tpl');
}


function _DisplayAdminForgotPasswordTemplateTab( &$module, $id, &$params, $returnid )
{
  $module->smarty->assign('startform',
			  $module->CreateFormStart( $id, 'do_setforgotpwtemplate'));
  $module->smarty->assign('prompt_template1',$module->Lang('forgotpassword_template'));
  $module->smarty->assign('input_template1',
			  $module->CreateTextArea( false, $id,
						   $module->GetTemplate ('feusers_forgotpasswordform'),
						   'templatecontent1'));
  $module->smarty->assign('prompt_template2',$module->Lang('forgotpassword_emailtemplate'));
  $module->smarty->assign('input_template2',
			  $module->CreateTextArea( false, $id,
						   $module->GetTemplate ('feusers_forgotpasswordemailform'),
						   'templatecontent2'));
  $module->smarty->assign('prompt_template3',$module->Lang('forgotpassword_verifytemplate'));
  $module->smarty->assign('input_template3',
			  $module->CreateTextArea( false, $id,
						   $module->GetTemplate ('feusers_forgotpasswordverifyform'),
						   'templatecontent3'));
  $module->smarty->assign('submit',
			  $module->CreateInputSubmit ($id, 'submit',
						      $module->Lang('submit')));
  $module->smarty->assign('defaults',
			  $module->CreateInputSubmit ($id, 'defaults',
						      $module->Lang('defaults')));
  $module->smarty->assign('endform',$module->CreateFormEnd());
  echo $module->ProcessTemplate('forgotpw_templateform.tpl');
}

echo '<div class="pageoverflow" style="text-align: right; width: 80%;">';
echo $this->CreateImageLink($id,'defaultadmin',$returnid,
			    $this->Lang('back'),'icons/system/back.gif',array(),'','',false).'</div><br/>';
echo '</div>';

echo $this->StartTabHeaders();
echo $this->SetTabHeader( 'logintemplate', $this->Lang('login_template'));
echo $this->SetTabHeader( 'logouttemplate', $this->Lang('logout_template'));
echo $this->SetTabHeader( 'changesettings_template', $this->Lang('changesettings_template'));
echo $this->SetTabHeader( 'forgotpassword_template', $this->Lang('forgotpassword_template'));
echo $this->SetTabHeader( 'lostusername_template', $this->Lang('lostusername_template'));
echo $this->SetTabHeader( 'view_user', $this->Lang('viewuser_template'));
echo $this->SetTabHeader( 'reset_session', $this->Lang('resetsession_template'));
echo $this->EndTabHeaders();

echo $this->StartTabContent();
echo $this->StartTab('logintemplate',$params);
_DisplayAdminLoginTemplateTab( $this, $id, $params, $returnid );
echo $this->EndTab();

echo $this->StartTab('logouttemplate',$params);
_DisplayAdminLogoutTemplateTab( $this, $id, $params, $returnid );
echo $this->EndTab();

echo $this->StartTab('changesettings_template',$params);
_DisplayAdminChangeSettingsTemplateTab( $this, $id, $params, $returnid );
echo $this->EndTab();

echo $this->StartTab('forgotpassword_template',$params);
_DisplayAdminForgotPasswordTemplateTab( $this, $id, $params, $returnid );
echo $this->EndTab();

echo $this->StartTab('lostusername_template',$params);
include(__DIR__.'/function.admin_lostusername_template.php');
echo $this->EndTab();

echo $this->StartTab('view_user',$params);
include(__DIR__.'/function.admin_viewuser_template.php');
echo $this->EndTab();

echo $this->StartTab('reset_session',$params);
include(__DIR__.'/function.admin_resetsession_template.php');
echo $this->EndTab();
echo $this->EndTabContent();

#
# EOF
#
?>