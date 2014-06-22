<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: SelfRegistration (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to register themselves
#  with a website.
# 
# Version: 1.1.5
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

final class SelfregUtils
{
  private function __construct() {}

  function array_merge_by_name_required( $arr1, $arr2 )
  {
    $xxresult = array();
    // add items common to arr1 and arr2 
    // but favor required items
    if( !is_array( $arr1 ) || !is_array( $arr2 ) ) {
      return;
    }
    foreach( $arr1 as $a1 ) {
      foreach( $arr2 as $a2 ) {
	if( $a1['name'] == $a2['name'] ) {
	  if( $a1['required'] == 2 ) {
	    $xxresult[] = $a1;
	    break;
	  }
	  else {
	    $xxresult[] = $a2;
	    break;
	  }
	}    
      }
    }
  
    // add items in arr1 not in result
    foreach( $arr1 as $a1 ) {
      $found = false;
      foreach( $xxresult as $res ) {
	if( $a1['name'] == $res['name'] ) {
	  $found = true;
	  break;
	}
      }
      if( !$found ) $xxresult[] = $a1;
    }
  
    // add items in arr2 not in result
    foreach( $arr2 as $a2 ) {
      $found = false;
      foreach( $xxresult as $res ) {
	if( $a2['name'] == $res['name'] ) {
	  $found = true;
	  break;
	}
      }
      if( !$found ) $xxresult[] = $a2;
    }
    return $xxresult;
  }


  static function compare_elements_by_sortorder_key( $e1, $e2 )
  {
    if( $e1['sort_key'] < $e2['sort_key'] ) {
      return -1;
    }
    else if( $e1['sort_key'] > $e2['sort_key'] ) {
      return 1;
    }
    return 0;
  }


  static public function implode_with_key($assoc, $inglue = '=', $outglue = '&')
  {
    $return = null;
    foreach ($assoc as $tk => $tv) $return .= $outglue.$tk.$inglue.$tv;
    return substr($return,strlen($outglue));
  }

  function myCreateInputCheckbox($id, $name, $value='', $selectedvalue='', 
				 $addttext='')
  {
    $text = '<input type="checkbox" name="'.$id.$name.'" value="'.$value.'"';
    $arr = split(",",$selectedvalue);
    foreach( $arr as $a ) {
      if ($a == $value)  $text .= ' ' . 'checked="checked"';
    }
    if ($addttext != '') $text .= ' '.$addttext;
    $text .= " />\n";
    return $text;
  }

  static public function myCreateInputHidden( $id, $name, $value='', $addtext='', $delim=',')
  {
    if( is_array( $value ) ) {
      $val = SelfregUtils::implode_with_key( $value );
    }
    else {
      $val = $value;
    }
    $val = str_replace('"', '&quot;', $val);
    $text = '<input type="hidden" name="'.$id.$name.'" value="'.$val.'"';
    if ($addtext != '') {
      $text .= ' '.$addtext;
    }
    $text .= " />\n";
    return $text;
  }

  function is_associative(&$array){
    if (!is_array($array)) return false;
    foreach(array_keys($array) as $key=>$value) {
      if( !is_numeric($key) ) return true;
    }
    return false;
  }

} // End of class


  /*---------------------------------------------------------
   UserDisplayVerificationForm($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _UserDisplayVerificationForm( &$module, $id, &$params, $returnid )
{
  $feusers = $module->GetModuleInstance('FrontEndUsers');
  if( !$feusers ) {
    $module->_DisplayErrorPage($id, $params, $returnid, $module->Lang('error_nofeusersmodule'));
    return;
  }

  if( isset( $params['error'] ) ) $module->smarty->assign('error', $params['error']);
  if( isset( $params['message'] ) ) $module->smarty->assign('message', $params['message']);

  $username = '';
  $password = '';
  $code = '';
    $group_id = '';
  if( isset( $params['input_username'] ) ) $username = trim($params['input_username']);
  if( isset( $params['input_password'] ) ) $password = trim($params['input_password']);
  if( isset( $params['input_code'] ) )	$code = trim($params['input_code']);
  if( isset( $params['input_group_id'] ) ) $group_id = trim($params['input_group_id']);

  // process the template
  $module->smarty->assign('title', $module->Lang('title_verifyregistration'));
  if ($feusers->GetPreference('username_is_email')) {
    $module->smarty->assign('prompt_username',$module->Lang('email'));
  }
  else {
    $module->smarty->assign('prompt_username',$module->Lang('username'));
  }
  $module->smarty->assign('input_username',
			  $module->CreateInputText($id,'sr_input_username',
						   $username,
						   $feusers->GetPreference('usernamefldlength'),
						   $feusers->GetPreference('max_usernamelength')));
  $module->smarty->assign('prompt_password',$module->Lang('password'));
  $module->smarty->assign('input_password',
			  $module->CreateInputPassword($id,'sr_input_password',
						       $password,
						       $feusers->GetPreference('passwordfldlength'),
						       $feusers->GetPreference('max_passwordlength')));
  $module->smarty->assign('prompt_code',$module->Lang('code'));
  $module->smarty->assign('input_code',$module->CreateInputText($id,'sr_input_code',$code, 30, 30 ));
  $module->smarty->assign('submit',$module->CreateInputSubmit($id,'sr_submit',$module->Lang('submit')));

  $inline = $module->GetPreference('inline_forms',true);
  if( isset($params['noinline']) ) $inline = false;
  $module->smarty->assign('startform', $module->CreateFrontendFormStart($id, $returnid, 'verifyuser','post','',$inline));
  $module->smarty->assign('hidden', $module->CreateInputHidden($id, 'sr_input_group_id', $group_id ));
  $module->smarty->assign('endform', $module->CreateFormEnd());
  echo $module->ProcessTemplateFromDatabase('selfreg_reg2template');
}


  /*---------------------------------------------------------
   UserDisplayLostRegEmailForm($id, $params, $return_id, $message)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _UserDisplayLostRegEmailForm( &$module, $id, &$params, $returnid )
{
  $feusers = $module->GetModuleInstance('FrontEndUsers');
  if( !$feusers ) {
    $module->_DisplayErrorPage($id, $params, $returnid, $module->Lang('error_nofeusersmodule'));
    return;
  }

  if( isset( $params['error'] ) ) $module->smarty->assign('error', $params['error']);
  if( isset( $params['message'] ) ) $module->smarty->assign('message', $params['message']);

  $inline = $module->GetPreference('inline_forms',true);
  if( isset($params['noinline']) ) $inline = false;

  $module->smarty->assign('startform', $module->CreateFormStart( $id, 'sendanotheremail', $returnid, 'post', '', $inline));
  $module->smarty->assign ('endform', $module->CreateFormEnd ());
  $module->smarty->assign ('input_username',
			   $module->CreateInputText($id, 'input_username',
						    $val, 20,
						    $feusers->GetPreference('max_usernamelength')));
  $module->smarty->assign('submit',$module->CreateInputSubmit($id,'submit',
							      $module->Lang('submit')));
  echo $module->ProcessTemplateFromDatabase('selfreg_sendanotheremail_template');
}

?>