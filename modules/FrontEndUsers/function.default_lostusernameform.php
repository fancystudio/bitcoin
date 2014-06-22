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

$smarty = cmsms()->GetSmarty();

if( isset( $params['message'] ) ) {
  $message = html_entity_decode(trim($params['message']));
  $smarty->assign('message',$message);
}
if( isset( $params['error'] ) ) {
  $error = html_entity_decode(trim($params['error']));
  $smarty->assign('error',$error);
}

$gid = $this->GetPreference('default_group',-1);
if( isset($params['lostun_group']) ) {
  $gid = $this->GetGroupID( $params['lostun_group'] );
  if( $gid == false ) {
    $this->_DisplayErrorPage( $id, $params, $returnid,
			      $this->Lang('error_groupnotfound'));
    return;
  }
}
else if( $gid <= 0 ) {
  $groups = $this->GetGroupList();
  $values = array_values($groups);
  $gid = $values[0];
}

$relns = $this->GetGroupPropertyRelations( $gid );
if( !is_array( $relns ) || $relns[0] === FALSE ) {
  echo '<!-- FEU: Error - '.$relns[1].' -->';
  return;
}

$captcha = $this->GetModuleInstance('Captcha');
if( is_object($captcha) && !isset($params['nocaptcha']) ) {
  $smarty->assign('captcha_title', $this->Lang('captcha_title'));
  $smarty->assign('input_captcha',
		  $this->CreateInputText($id,'input_captcha','',10));
  $smarty->assign('captcha', $captcha->getCaptcha());
}

//
// Add a password field
//
$smarty->assign('prompt_password',$this->Lang('prompt_password'));
$smarty->assign('passwdfldlength',$this->GetPreference('passwdfldlength'));
$smarty->assign('max_passwordlength',$this->GetPreference('max_passwordlength'));
$smarty->assign('min_passwordlength',$this->GetPreference('min_passwordlength'));

// deprecaed.
$smarty->assign('input_password',
		$this->CreateInputPassword($id,'feu_input_password','',
		   $this->GetPreference('passwordfldlength')),
		   $this->GetPreference('max_passwordlength'));

// Now: we need to get the properties that are marked as 'lostunflag' 
// and display them in the form
$rowarray = array();
foreach( $relns as $onereln ) {
  // if it's not required here, don't do anything
  if( !isset($onereln['lostunflag']) || $onereln['lostunflag'] <= 0 )
    continue;

  if( $onereln['required'] == 3 || $onereln['required'] == 4) {
    // Hmm, how can an a field that's required in lostun be hidden
    // gotta figure that out.... todo
    echo '<!-- FEU: ERROR - A Hidden/readonly field is required for lost username? -->';
    continue;
  }

  $defn = $this->GetPropertyDefn( $onereln['name'] );

  $onerow = new StdClass();
  $onerow->name = 'input_'.$onereln['name'];
  $onerow->id   = $id.$onerow->name;
  $onerow->color = '';
  $onerow->type = $defn['type'];
  $onerow->marker = '';
  $onerow->classname = $onereln['name'];
  $addtext = '';
  $onerow->hidden = RRUtils::myCreateInputHidden( $id, 
						  'feu_hidden_'.$onereln['name'],
						  implode(';',
							  array($onereln['name'],
						    $defn['type'],
						    $onereln['required'])));

  switch( $defn['type'] ) {
  case 0: // text
    $onerow->control = $this->CreateInputText( $id, 'feu_'.$onerow->name,
					       '',$defn['length'],
					       $defn['maxlength'],
					       $addtext );
    break;

  case 1: // checkbox
    $onerow->control = RRUtils::myCreateInputCheckbox( $id,
						       'feu_'.$onerow->name,
						       1, 0,
						       $addtext );
    break;

  case 2: // email
    $onerow->control = $this->CreateInputText( $id, 'feu_'.$onerow->name,
					       '',$defn['length'],
					       $defn['maxlength'],
					       $addtext );
    break;

  case 3: // text area
    $onerow->control = $this->CreateTextArea( false, $id, '', 
					      'feu_'.$onerow->name );
    break;

  case 4: // dropdown
    $onerow->control = $this->CreateInputDropdown( $id, 
						  'feu_'.$onerow->name,
						   $this->GetSelectOptions($defn['name'], 1), 
						   -1, 
						   -1,
						   $addtext);
    break;

  case 5: // multiselect 
    $selected = explode(',',$val);
    $onerow->control = $this->CreateInputSelectList( $id, 
						     'feu_'.$onerow->name.'[]', 
						     $this->GetSelectOptions($defn['name'], 1), 
						     $selected,
						     $defn['length'],
						     $addtext);
    break;

  case 6: // image
    // this isn't allowed
    break;
  }
  $onerow->labelfor = 'feu_'.$id.$onereln['name'];
  $onerow->type = $defn['type'];
  $onerow->length = $defn['length'];
  $onerow->maxlength = $defn['maxlength'];
  $onerow->prompt = $defn['prompt'];
  $onerow->name = $onereln['name'];
  $rowarray[] = $onerow;
}


$smarty->assign('title',$this->Lang('title_lostusername'));
$smarty->assign('startform',
		$this->feCreateFormStart($id,'do_lostusername', $returnid, true, 'post', '', '', $params));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('submit', $this->CreateInputSubmit($id,'submit',$this->Lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));

$hidden = '';
if( isset($params['lostun_group']) ) {
  $hidden .= $this->CreateInputHidden($id,'lostun_group',$params['lostun_group']);
}
if( isset( $params['returnto'] ) ) {
  $hidden .= $this->CreateInputHidden($id,'input_returnto', $params['returnto']);
}
if( $hidden != '' ) {
  $smarty->assign('hidden',$hidden);
}
$smarty->assign('formid',$id);
$smarty->assign('controls', $rowarray);
$smarty->assign('controlcount', count($rowarray));
if( count($rowarray) == 0 ) $smarty->assign('message',$this->Lang('error_lostun_nocontrols'));

echo $this->ProcessTemplateFromDatabase('feusers_lostunform');
// EOF
?>
