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
if( !isset( $gCms ) ) return;

if( isset( $params['input_returnto'] ) )
  {
    $returnid = $params['input_returnto'];
  }

if( isset($params['cancel'] ) )
  {
    $this->RedirectContent($returnid);
    return;
  }

// if( !isset( $params['submit'] ) )
//   {
//     // should never happen
//     return;
//   }

function _handleError( $id, &$module, $returnid, $message, $params )
{
  $params['error'] = 1;
  $params['message'] = $message;
  $params['form'] = 'lostusername';
  $module->Redirect( $id, 'default', $returnid, $params );
}

//
// Process captcha
//
$captcha =& $this->GetModuleInstance('Captcha');
if( is_object($captcha) && !isset( $params['nocaptcha']) )
  {
    if( !$captcha->CheckCaptcha($params['input_captcha']) )
      {
	  _handleError( $id, $this, $returnid, 
			$this->Lang('error_captchamismatch'),
			$params);
	  return;
      }
  }

//
// Check to make sure the password was filled out 
//
if( !isset($params['feu_input_password']) || 
    trim($params['feu_input_password']) == '' )
  {
    _handleError( $id, $this, $returnid, 
		  $this->Lang('error_insufficientparams'),
		  $params);
    return;
  }

//
// Process all of the params, that have both an feu_hidden and feu_input field
// extract the property names out of them
//
$fields = array();
$firstprop = '';
foreach( $params as $key => $value )
{
  if( preg_match( '/^feu_hidden_/', $key ) )
    {
      $propname = substr( $key, strlen('feu_hidden_'));
      $arr = explode(";",$value);

      if( !isset($params['feu_input_'.$propname]) ||
	  $params['feu_input_'.$propname] == '')
	{
	  _handleError( $id, $this, $returnid, 
			$this->Lang('error_requiredfield',$propname),
			$params);
	  return;
	}

      if( $firstprop == '' ) $firstprop = $propname;
      $fields[$propname] = array();
      $fields[$propname]['input'] = $params['feu_input_'.$propname];
    }
}

//
// Now, try to find a userid/username
// that match these properties
//
$query = "SELECT userid FROM ".cms_db_prefix()."module_feusers_properties
           WHERE title = ? AND data = ?";
$newfields = array();
foreach( $fields as $propname => $data )
{
  $matches = array();
  $dbresult = $db->Execute( $query, array($propname,$data['input']) );
  while( $dbresult && $row = $dbresult->FetchRow() )
    {
      $matches[] = $row['userid'];
    }

  if( count($matches) == 0 )
    {
      // no matches, we can stop here
      _handleError( $id, $this, $returnid, 
		    $this->Lang('error_cantfinduser'), $params );
      return;
    }

  // store the results
  $data['matches'] = $matches;
  $newfields[$propname] = $data;
}

$fields = $newfields;

// now go through each of the matches arrays, and find all of the
// userids that are the same in each row
$gooduids = array();
$firstuids =& $fields[$firstprop]['matches'];
foreach( $firstuids as $firstuid )
{
  $found = true;
  foreach( $fields as $propname => $data )
    {
      if( $propname == $firstprop )
	{
	  continue;
	}

      if( array_search( $firstuid, $data['matches'], true ) === FALSE )
	{
	  // this firstuid uid fails.
	  $found = false;
	  break;
	}
    }
  if( $found == true )
    {
      $gooduids[] = $firstuid;
    }
}

if( count( $gooduids ) > 1 )
  {
    // non unique match
    _handleError( $id, $this, $returnid, 
		  $this->Lang('error_nonuniquematch'), $params);
    return;
  }

$uid = $gooduids[0];

//
// Confirm the password
//
$username = $this->GetUserName($uid);
if( !$username )
  {
    // now this is warped
    _handleError( $id, $this, $returnid, 
		  $this->Lang('error_usernotfound'), $params);
    return;
  }
$pw = $params['feu_input_password'];
if( !$this->CheckPassword( $username, $pw ) )
  {
    // now this is warped
    _handleError( $id, $this, $returnid, 
		  $this->Lang('error_loginfailed'), $params);
    return;
  }

//
// Yahoo, we made it
//

// display a warm and fuzzy message
$smarty->assign('prompt_yourusernameis',$this->Lang('your_username_is'));
$smarty->assign('username',$username);
$smarty->assign('premsg',$this->Lang('lostunconfirm_premsg'));
$smarty->assign('postmsg',$this->Lang('lostunconfirm_postmsg'));

echo $this->ProcessTemplateFromDatabase('feusers_lostunform_confirm');
// EOF
?>
