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
if( !isset($gCms) ) exit;

if( !$this->CheckPermission('Manage Registering Users' ) )
  {
    $this->_DisplayErrorPage($id, $params, $returnid, 
			     $this->Lang('accessdenied'));
    return;
  }

if( !isset( $params['user_id'] ) )
  {
    // this is ugly for the user to see
    // but at least the admin will be able to figure it out
    $this->_DisplayErrorPage( $id, $params, $returnid,
			      $this->Lang('error_insufficientparams'));
    return;
  }

$feusers =& $this->GetModuleInstance('FrontEndUsers');
if( !$feusers )
  {
    // this is ugly for the user to see
    // but at least the admin will be able to figure it out
    $this->_DisplayErrorPage( $id, $params, $returnid,
			      $this->Lang('error_nofeusersmodule'));
    return;
  }

$cmsmailer =& $this->GetModuleInstance('CMSMailer');
if( !$cmsmailer )
  {
    // this is ugly for the user to see
    // but at least the admin will be able to figure it out
    $this->_DisplayErrorPage( $id, $params, $returnid,
			      $this->Lang('error_nofeusersmodule'));
    return;
  }


$uid = $params['user_id'];
$userdetails = $this->GetTempUserDetails( $uid );
if( !$userdetails )
  {
    $this->_DisplayErrorPage( $id, $params, $returnid,
			      $this->Lang('error_usernotfound') );
    return;
  }

// get the group property relations
$relations = $feusers->GetGroupPropertyRelations( $userdetails['group_id'] );
if( $relations[0] == false )
  {
    // this is ugly for the user to see
    // but at least the admin will be able to figure it out
    $this->_DisplayErrorPage( $id, $params, $returnid, 
			      $this->Lang('error_noproprelations').' '.$relations[1] );
    return;
  }
uasort( $relations, 
	array('SelfregUtils','compare_elements_by_sortorder_key' ));

// get the users' properties
$props = array();
{
  $t_props = $this->GetTempUserProperties( $uid );
  if( !$t_props )
    {
      // this is ugly for the user to see
      // but at least the admin will be able to figure it out
      $this->_DisplayErrorPage( $id, $params, $returnid, 
				$this->Lang('error_noproperties').' '.$relations[1] );
      return;
    }

  // a little re-sorting
  foreach( $t_props as $prop )
    {
      $props[$prop['title']] = $prop;
    }
}

// here we'll display a form that is similar to the registration form in 
// every way,
if( isset( $params['error'] ) )
  {
    $this->smarty->assign('error', $params['error']);
  }
if( isset( $params['message'] ) )
  {
    $this->smarty->assign('message', $params['message']);
  }

$rowarray = array();

// make sure username is in there
$onerow = new StdClass();
$onerow->color = $feusers->GetPreference('required_field_color','blue');
$onerow->marker = $feusers->GetPreference('required_field_marker','*');
$onerow->required = 1;
$val = $userdetails['username'];
$onerow->hidden = SelfregUtils::myCreateInputHidden( $id, 'hidden_username',
				       implode(";",array('username',0,30,2)));
$onerow->prompt = $this->Lang('username');
$onerow->control =$this->CreateInputText($id, 'input_username', $val, 
					 $feusers->GetPreference('usernamefldlength'),
					 $feusers->GetPreference('max_usernamelength'));
$rowarray[] = $onerow;

// and password
$onerow = new StdClass();
$onerow->color = $feusers->GetPreference('required_field_color','blue');
$onerow->marker = $feusers->GetPreference('required_field_marker','*');
$onerow->extratext = $this->Lang('txt_changepassword');
$onerow->required = 1;
$val = '';
$onerow->hidden = SelfregUtils::myCreateInputHidden( $id, 'hidden_password',
				       implode(";",array('password',0,30,2)));
$onerow->prompt = $this->Lang('password');
$onerow->control =$this->CreateInputPassword($id, 'input_password', $val, 
					     $feusers->GetPreference('passwordfldlength'),
					     $feusers->GetPreference('max_passwordlength'));
$rowarray[] = $onerow;

// and make him repeat the password
$onerow = new StdClass();
$onerow->color = $feusers->GetPreference('required_field_color','blue');
$onerow->marker = $feusers->GetPreference('required_field_marker','*');
$onerow->required = 1;
$val = '';
$onerow->hidden = SelfregUtils::myCreateInputHidden( $id, 'hidden_repeatpassword',
				       implode(";",array('repeatpassword',0,30,2)));
$onerow->prompt = $this->Lang('repeatpassword');
$onerow->control =$this->CreateInputPassword($id, 'input_repeatpassword', $val,
					     $feusers->GetPreference('passwordfldlength'),
					     $feusers->GetPreference('max_passwordlength'));
$rowarray[] = $onerow;

// an option to send another confirmation message
// but a different one from the normal
$onerow = new StdClass();
$onerow->color = $feusers->GetPreference('required_field_color','blue');
$onerow->marker = $feusers->GetPreference('required_field_marker','*');
$onerow->required = 1;
$onerow->prompt = $this->Lang('send_adjustmentemail');
$onerow->extratext = $this->Lang('txt_adjustmentemail');
$onerow->control = $this->CreateInputCheckbox($id, 'input_adjustmentemail', 1, 1);
$rowarray[] = $onerow;

foreach( $relations as $reln )
{
  // don't process hidden fields here
  if( $reln['required'] == 3 ) continue;

  // get the property definition
  $defn = $feusers->GetPropertyDefn( $reln['name'] );

  if( $defn['type'] == 6 )
    {
      // images are ignored too
      continue;
    }

  $onerow = new StdClass();

  $color = '';
  if( $reln['required'] == 2 ) $color = $feusers->GetPreference('required_field_color','blue');
  $marker = '';
  if( $reln['required'] == 2 ) $marker = $feusers->GetPreference('required_field_marker','*');
  $onerow->required = ($reln['required'] == 2);
  $onerow->color    = $color;
  $onerow->marker   = $marker;
  $onerow->hidden = SelfregUtils::myCreateInputHidden( $id, 'hidden_'.$reln['name'],
					 implode(";",array($reln['name'],$defn['type'],
							   $defn['length'],$reln['required'])));

  $val = isset($props[$reln['name']]['data']) ? $props[$reln['name']]['data'] : '';
  $onerow->prompt = $defn['prompt'];
  $onerow->labelfor = $id.$defn['name'];
  switch( $defn['type'] )
    {
    case 0: // text
      $onerow->control = $this->CreateInputText( $id, 'input_'.$reln['name'],
						 $val, $defn['length'], $defn['maxlength'] );
      break;

    case 1: // checkbox
      $onerow->control = $this->CreateInputCheckbox( $id, 'input_'.$reln['name'], 1, $val );
      break;

    case 2: // email
      $onerow->control = $this->CreateInputText( $id, 'input_'.$reln['name'],
						 $val, $defn['length'], ($defn['maxlength']) );
      break;

    case 3: // textarea
      $onerow->control = $this->CreateTextArea(false, $id, $val, 'input_'.$defn['name']);
      break;

    case 4: // dropdown
      $onerow->control = $this->CreateInputDropdown($id, 
						    'input_'.$defn['name'], 
						    $feusers->GetSelectOptions($defn['name'], 1), 
						    -1, 
						    $val);
      break;

    case 5: // multiselect
      if( !$val ) $val = array();
      $onerow->control = $this->CreateInputSelectList($id,
						      'input_'.$defn['name'].'[]',
						      $feusers->GetSelectOptions($defn['name'], 1),
						      $val);
      break;

    case 6: // image
      // skipped intentionally
      break;

    case 7: // radiobuttons
      $onerow->control = $this->CreateInputRadioGroup($id, 'input_'.$defn['name'], 
						      $feusers->GetSelectOptions($defn['name'], 1), 
						      $val, '', '<br/>');
      break;

    case 8: // date
      {
	$attribs = unserialize($defn['attribs']);
	$parms = array();
	$parms['prefix'] = $id.'input_'.$defn['name'];
	if( $val ) $parms['time'] = $val;
	$parms['start_year'] = (isset($attribs['startyear']))?$attribs['startyear']:"-5";
	$parms['end_year'] = (isset($attribs['endyear']))?$attribs['endyear']:"+10";
	$str = '{html_select_date ';
	foreach( $parms as $key=>$value )
	  {
	    $str.=$key.'="'.$value.'" ';
	  }
	$str .= '}';
	$onerow->control = $this->ProcessTemplateFromData($str);
      }
      break;
    }

  $rowarray[] = $onerow;
}

$this->smarty->assign ('startform',
		       $this->CreateFormStart ($id, 'do_edituser', $returnid));
$this->smarty->assign ('endform', $this->CreateFormEnd ());
$this->smarty->assign('title',$this->Lang('edituser'));
$this->smarty->assign('hidden',
		      $this->CreateInputHidden($id, 'user_id', $userdetails['id'] ));
$this->smarty->assign('hidden2',
		      $this->CreateInputHidden($id, 'group_id', $userdetails['group_id'] ));
$this->smarty->assign('controls', $rowarray);
$this->smarty->assign('controlcount', count($rowarray));
$this->smarty->assign('submit',$this->CreateInputSubmit($id,'submit',
							$this->Lang('submit')));
$this->smarty->assign('cancel',$this->CreateInputSubmit($id,'cancel',
							$this->Lang('cancel')));

echo $this->ProcessTemplate('edituser.tpl');

?>