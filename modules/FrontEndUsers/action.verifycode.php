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

// fill in the template
$uid = '';
if( isset( $params['input_uid'] ) )
  {
    $uid = (int)$params['input_uid'];
  }
else if( isset($params['uid']) )
  {
    $uid = (int)$params['uid'];
  }
$username = '';
if( isset( $params['input_username'] ) )
  {
    $username = trim($params['input_username']);
  }
 else
   {
     $username = $this->GetUserName( $uid );
   }
$code = '';
if( isset( $params['input_code'] ) )
  {
    $code = trim($params['input_code']);
  }
else if( isset($params['code']) )
  {
    $code = trim($params['code']);
  }

if( isset( $params['error'] ) )
  {
    $this->smarty->assign('error',$params['error']);
  }
if( isset( $params['message'] ) )
  {
    $this->smarty->assign('message',$params['message']);
  }

$this->smarty->assign('startform',
		      $this->feCreateFormStart($id,'do_verifycode',$returnid));
$this->smarty->assign('endform',
		      $this->CreateFormEnd());
$this->smarty->assign('hidden',
		      $this->CreateInputHidden($id,'input_uid',$uid));
$this->smarty->assign('submit',
		      $this->CreateInputSubmit($id, 'submit',$this->Lang('submit')));
$this->smarty->assign('prompt_username',$this->Lang('prompt_username'));
$this->smarty->assign('input_username',
		      $this->CreateInputText( $id, 'input_username', $username,
					      $this->GetPreference('usernamefldlength'), 
					      $this->GetPreference('max_usernamelength'),
					      'disabled="disabled"'));
$this->smarty->assign('prompt_code',$this->Lang('prompt_code'));
$this->smarty->assign('input_code',
		      $this->CreateInputText( $id, 'input_code', $code, 10, 10 ));
$this->smarty->assign('prompt_password',$this->Lang('prompt_password'));
$this->smarty->assign('input_password',
		      $this->CreateInputPassword($id, 'input_password', '',
						 $this->GetPreference('passwordfldlength'),
						 $this->GetPreference('max_passwordlength')));
$this->smarty->assign('prompt_repeatpassword',$this->Lang('repeatpassword'));
$this->smarty->assign('input_repeatpassword',
		      $this->CreateInputPassword($id, 'input_repeatpassword', '',
						 $this->GetPreference('passwordfldlength'),
						 $this->GetPreference('max_passwordlength')));
echo $this->ProcessTemplateFromDatabase('feusers_forgotpasswordverifyform');

?>