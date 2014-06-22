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
if( !$this->_HasSufficientPermissions('editgroups') ) return;

function check_group_complete( &$grp )
{
  if( !is_array( $grp ) ) return false;
  if(!isset($grp['name']) || empty($grp['name'])) return false;
  
  // passed
  if( !isset($grp['properties']) || !is_array($grp['properties']) || (count($grp['properties']) == 0) ) return false;

  foreach( $grp['properties'] as $oneprop ) {
    if( !check_property_complete( $oneprop ) ) return false;
  }

  return true;
}


function check_property_complete( &$prop )
{
  if( !is_array( $prop ) ) return FALSE;
  if(!isset($prop['name']) || empty($prop['name'])) return FALSE;
  if(!isset($prop['type']) || $prop['type'] == '') return FALSE;
  if(!isset($prop['prompt']) || empty($prop['prompt'])) return FALSE;
  if(!isset($prop['sortorder']) || $prop['sortorder'] === '' ) return FALSE;
  if(!isset($prop['status']) || empty($prop['status'])) return FALSE;
  if(!isset($prop['lostunflag']) || empty($prop['lostunflag'])) return FALSE;

  if(isset($prop['length'])) {
    if(empty($prop['length'])) return FALSE;
    if(intval($prop['length']) == 0) return FALSE;
  }
  if(isset($prop['maxlength'])) {
    if(empty($prop['maxlength'])) return FALSE;
    if(intval($prop['maxlength']) == 0) return FALSE;
  }

  $type = intval($prop['type']);
  if( $type > 6 || $type < 0 ) return FALSE;
  if( $type == 4 || $type == 5 ) {
    // check for options
    if( !isset($prop['options']) || !is_array($prop['options']) ) return FALSE;

    foreach( $prop['options'] as $oneop ) {
      if( !isset($oneop['name']) || !isset($oneop['text']) ) return FALSE;
    }
  }

  return TRUE;
}

if( !feu_utils::using_std_consumer() ) {
  $this->SetError($this->Lang('error_notsupported'));
  $this->RedirectToTab($id,'groups');
}

if( isset( $params['cancel'] ) ) {
  $this->RedirectToTab($id,'groups');
}

if( isset( $params['submit'] ) ) {
  //
  // Submit was pressed
  //
  if( !isset( $_FILES[$id.'xmlfile'] ) ) {
    $this->SetError($this->Lang('error_missing_upload'));
    $this->RedirectToTab($id,'groups');
  }
  $thefile =& $_FILES[$id.'xmlfile'];
  if( $thefile['type'] != 'text/xml' || $thefile['size'] == 0 || $thefile['error'] != 0 ) {
    $this->SetError($this->Lang('error_problem_upload'));
    $this->RedirectToTab($id,'groups');
  }

  //
  // We got an XML file (hope it's the right one
  // now we can try to parse it 
  //

  $xml = file_get_contents( $thefile['tmp_name'] );
  $parser = xml_parser_create();
  $ret = xml_parse_into_struct( $parser, $xml, $val, $xt );
  xml_parser_free( $parser );

  if( $ret == 0 ) {
    $this->SetError($this->Lang('error_bad_xml').' 1');
    $this->RedirectToTab($id,'groups');
  }

  //
  // We have some kind of valid XML
  //
  $oneproperty = array();
  $oneoption = array();
  $have_complete_group = false;
  $grp_info = array();
  foreach( $val as $elem ) {
    $value = (isset($elem['value'])?$elem['value']:'');
    $type = (isset($elem['type'])?$elem['type']:'');
    $tag = strtolower($elem['tag']);
    $fld = substr($tag,strpos($tag,'_')+1);

    switch( $tag ) {
    case 'feu_group':
      {
	if( $type != 'complete' && $type != 'close' ) continue;
	if( !check_group_complete($grp_info) ) {
	  // an error that we should never get
	  $this->SetError($this->Lang('error_bad_xml').' 2');
	  $this->RedirectToTab($id,'groups');
	  return;
	}
	// we should have a complete group at this point
	$have_complete_group = true;
	break;
      }

    case 'grp_name':
    case 'grp_description':
      {
	if( $type != 'complete' && $type != 'close' ) continue;
	if( isset($grp_info[$fld]) ) {
	  // an error that we should never get
	  $this->SetError($this->Lang('error_bad_xml').' 3');
	  $this->RedirectToTab($id,'groups');
	  return;
	}
	$grp_info[$fld] = $value;
	break;
      }


    case 'property':
      {
	if( $type != 'complete' && $type != 'close' ) continue;
	if( !check_property_complete($oneproperty) ) {
	  // an error that we should never get
	  $this->SetError($this->Lang('error_bad_xml').' 4');
	  $this->RedirectToTab($id,'groups');
	  return;
	}
	if( !isset($grp_info['properties']) ) $grp_info['properties'] = array();
	$grp_info['properties'][] = $oneproperty;
	$oneproperty = array();
	break;
      }

    case 'prop_name':
    case 'prop_prompt':
    case 'prop_value':
    case 'prop_type':
    case 'prop_length':
    case 'prop_maxlength':
    case 'prop_sortorder':
    case 'prop_status':
    case 'prop_lostunflag':
      {
	if( $type != 'complete' && $type != 'close' ) continue;
	if( isset( $oneproperty[$fld] ) ) {
	  // an error that we should never get
	  $this->SetError($this->Lang('error_bad_xml').' 5');
	  $this->RedirectToTab($id,'groups');
	  return;
	}
	$oneproperty[$fld] = $value;
	break;
      }

    case 'prop_option':
      {
	if( $type != 'complete' && $type != 'close' ) continue;
	$oneproperty['options'][] = $oneoption;
	$oneoption = array();
	break;
      }

    case 'op_name':
    case 'op_text':
      {
	if( $type != 'complete' && $type != 'close' ) continue;
	$oneoption[$fld] = $value;
	break;
      }
    } // switch
  } // foreach

  //
  // If we got here, we parsed the xml file properly
  // and it looks good.
  //

  // If the newname is set, we'll use that
  if( isset($params['input_newname']) && $params['input_newname'] != '' ) $grp_info['name'] = $params['input_newname'];

  if( $this->GroupExistsByName( $grp_info['name'] ) ) {
    // an error that we should never get
    $this->SetError($this->Lang('error_groupexists'));
    $this->RedirectToTab($id,'groups');
    return;
  }

  if( !isset($grp_info['properties']) || !is_array($grp_info['properties']) || (count($grp_info['properties']) == 0) ) {
    // no properties?
    $this->SetError($this->Lang('error_properties'));
    $this->RedirectToTab($id,'groups');
    return;
  }

  // Now add the properties
  // (first scan for names)
  $passed = true;
  foreach( $grp_info['properties'] as $oneprop ) {
    $res = $this->GetPropertyDefn( $oneprop['name'] );
    if( is_array($res) ) {
      $passed = false;
      break;
    }
  }
  if( !$passed ) {
    // no properties?
    $this->SetError($this->Lang('error_dup_properties'));
    $this->RedirectToTab($id,'groups');
    return;
  }

  //
  // Now really add them
  //
  foreach( $grp_info['properties'] as $oneprop ) {
    $res = $this->AddPropertyDefn($oneprop['name'], $oneprop['prompt'], $oneprop['type'], $oneprop['lengtn'], $oneprop['maxlength']);
    if( is_array( $res ) && $res[0] === FALSE ) {
      // for some dumb reason, we still couldn't insert 
      // the property
      $this->SetError($this->Lang('error_cantaddprop'));
      $this->RedirectToTab($id,'groups');
      return;
    }

    if( $oneprop['type'] == 4 || $oneprop['type'] == 5 ) {
      // it's a select type
      $ops = array();
      foreach( $oneprop['options'] as $oneop ) {
	$ops[] = $oneop['text'].'='.$oneop['name'];
      }
      $res = $this->AddSelectOptions( $oneprop['name'], $ops );
      if( $res[0] == FALSE ) {
	// for some dumb reason, we still couldn't insert 
	// the property
	$this->SetError($this->Lang('error_cantaddprop').' 2');
	$this->RedirectToTab($id,'groups');
	return;
      }
    }
  }

  // Woohoo, the properties were added
  // Now to add the group itself.
  $res = $this->AddGroup($grp_info['name'],$grp_info['description']);
  if( is_array( $res ) && $res[0] === FALSE ) {
    $this->SetError($this->Lang('error_cantaddgroup'));
    $this->RedirectToTab($id,'groups');
    return;
  }
  $grpid = $res[1];

  // and associate the properties with the group
  $error = false;
  foreach( $grp_info['properties'] as $oneprop ) {
    // if it's an option type (type 4 or 5) then
    // add the options
    $res = $this->AddGroupPropertyRelation( $grpid, $oneprop['name'], $oneprop['sortorder'], $oneprop['lostunflag'], $oneprop['status'] );
    if( $res[0] === FALSE ) $error = true;
  }
  if( $error == true ) {
    $this->SetError($this->Lang('error_cantaddgrouprels'));
    $this->RedirectToTab($id,'groups');
    return;
  }

  $this->RedirectToTab($id,'groups');
} // if

// Provide a simple form that allows people to choose the file to import
$smarty->assign('startform',$this->CreateFormStart($id,'admin_importgroup',$returnid,'post','multipart/form-data'));
$smarty->assign('endform',$this->CreateFormEnd());
$smarty->assign('submit',$this->CreateInputSubmit($id,'submit',$this->Lang('submit')));
$smarty->assign('cancel',$this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
$smarty->assign('prompt_filename',$this->Lang('prompt_importxmlfile'));
$smarty->assign('input_filename',$this->CreateFileUploadInput($id,'xmlfile','',40));
$smarty->assign('prompt_newname',$this->Lang('prompt_newgroupname'));
$smarty->assign('input_newname',$this->CreateInputText($id,'input_newname'));

echo $this->ProcessTemplate('importgroup.tpl');

// EOF
?>