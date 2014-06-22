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

function swap(&$a,&$b)
{
  $tmp = $a;
  $a = $b;
  $b = $tmp;
}


function reorder_by_key(&$input,$fld,$keys)
{
  if( !is_array($input) ) return;
  $tmp = array();
  foreach( $keys as $onekey ) {
    foreach( $input as $rec ) {
      if( $rec[$fld] == $onekey ) {
	$tmp[] = $rec;
	break;
      }
    }
  }
  $input = $tmp;
}

function adjust_order_by_keys(&$input,$fld,$keys)
{
  if( !is_array($input) ) return;
  $tmp = array();

  foreach( $keys as $onekey ) {
    foreach( $input as $rec ) {
      if( $rec[$fld] == $onekey ) {
	$tmp[] = $rec;
	break;
      }
    }
  }
  foreach( $input as $rec ) {
    $f1 = 0;
    foreach( $tmp as $tmprec ) {
      if( $rec[$fld] == $tmprec[$fld] ) {
	$f1 = 1;
	break;
      }
    }
    if( $f1 == 0 ) $tmp[] = $rec;
  }
  $input = $tmp;
}


//
// Initialization
//
$groupname = '';
$groupdesc = '';
$gid = -1;

// check permissions again
if( !isset($params['group_id']) ) {
  if( !$this->_HasSufficientPermissions( 'addgroup' ) ) {
    $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
    return;
  }
}
else {
  if( !$this->_HasSufficientPermissions( 'editgroups' ) ) {
    $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
    return;
  }
}

$propdefn = array();
{
  $tmp = $this->GetPropertyDefns();
  if( count($tmp) == 0 ) {
    $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('error_noproperties'));
    return;
  }
  foreach( $tmp as $key => $rec ) {
    $rec['required'] = 0;
    $rec['lostun'] = -1;
    $propdefn[$key] = $rec;
  }
}

if( isset($params['group_id']) ) {
  // we're editing a gruop
  $gid = (int)$params['group_id'];
  $ginfo = $this->GetGroupInfo($gid);
  if( isset($ginfo[0]) && $ginfo[0] == FALSE ) {
    $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('error_groupnotfound'));
    return;
  }
  $groupname = $ginfo['groupname'];
  $groupdesc = $ginfo['groupdesc'];

  // load relations, and adjust the propdefn array
  $res = $this->GetGroupPropertyRelations($gid);
  if( $res[0] == FALSE ) {
    // editing a group, but no property relations (maybe the groups are held in a consumer module, but not the property defs).
    // treat it like we're adding a group.
    /*
    $this->_DisplayErrorPage($id, $params, $returnid,
			     $this->Lang('error_nogroupproperties'));
    return;
    */
  }
  else {
    // sort them by sort key
    uasort($res,array('cge_array','compare_elements_by_sortorder_key'));

    // sort the propdefns by the sort order.
    $names = array();
    foreach( $res as $tmp ) {
      $names[] = $tmp['name'];
    }
    adjust_order_by_keys($propdefn,'name',$names);

    // update the propdefns
    for( $i = 0; $i < count($res); $i++ ) {
      for( $j = 0; $j < count($propdefn); $j++ ) {
	if( $res[$i]['name'] == $propdefn[$j]['name'] ) {
	  $propdefn[$j]['required'] = $res[$i]['required'];
	  $propdefn[$j]['lostun'] = $res[$i]['lostunflag'];
	  break;
	}
      }
    } // for
  } // else
 }

// exclude property defns from modules
{
  $tmp = array();
  foreach( $propdefn as $key => $rec ) {
    if( !isset($rec['extra']['module']) ) $tmp[] = $rec;
  }
  $propdefn = $tmp;
}

if (isset ($params['cancel'])) $this->RedirectToTab($id, 'groups' );
if( isset($params['moveup']) ) {
  // update the propdefn with status values
  for( $i = 0; $i < count($params['input_name']); $i++ ) {
    $name = $params['input_name'][$i];
    for( $j = 0; $j < count($propdefn); $j++ ) {
      if( $name == $propdefn[$j]['name'] ) {
	$propdefn[$j]['required'] = $params['input_required'][$i];
	if( isset($params['input_lostun_'.$name]) ) $propdefn[$j]['lostun'] = $params['input_lostun_'.$name];
	break;
      }
    }
  }
  if( isset($params['input_groupname']) ) $groupname = trim($params['input_groupname']);
  if( isset($params['input_groupdesc']) ) $groupdesc = trim($params['input_groupdesc']);

  // we're moving stuff up
  // so adjust the propdefn array
  $idx = (int)$params['moveup'] - 1;
  swap($params['input_name'][$idx],$params['input_name'][$idx-1]);
  reorder_by_key($propdefn,'name',$params['input_name']);
 }
if( isset($params['movedown']) ) {
  // update the propdefn with status values
  for( $i = 0; $i < count($params['input_name']); $i++ ) {
    $name = $params['input_name'][$i];
    for( $j = 0; $j < count($propdefn); $j++ ) {
      if( $name == $propdefn[$j]['name'] ) {
	$propdefn[$j]['required'] = $params['input_required'][$i];
	if( isset($params['input_lostun_'.$name]) ) $propdefn[$j]['lostun'] = $params['input_lostun_'.$name];
	break;
      }
    }
  }
  if( isset($params['input_groupname']) ) $groupname = trim($params['input_groupname']);
  if( isset($params['input_groupdesc']) ) $groupdesc = trim($params['input_groupdesc']);

  // we're moving stuff down
  // so adjust the propdefn array
  $idx = (int)$params['movedown'] - 1;
  swap($params['input_name'][$idx],$params['input_name'][$idx+1]);
  reorder_by_key($propdefn,'name',$params['input_name']);
 }
if( isset($params['submit']) ) {
  $this->myRedirect($id,'do_addgroup',$returnid,$params);
}

// populate the template
if( isset( $params['error'] ) ) $smarty->assign('error',$params['error']);
if( isset( $params['message'] ) ) $smarty->assign('message',$params['message']);
$smarty->assign('title', $this->Lang('addgroup'));
if( $gid > 0 ) {
  $smarty->assign('hidden',$this->CreateInputHidden($id,'group_id',$gid));
  $smarty->assign('title', $this->Lang('editgroup'));
 }
$smarty->assign ('startform',$this->CreateFormStart ($id,'addgroup',$returnid));
$smarty->assign ('endform', $this->CreateFormEnd ());
$smarty->assign ('submit', $this->CreateInputSubmit ($id, 'submit',$this->Lang('submit')));
$smarty->assign ('cancel',$this->CreateInputSubmit ($id, 'cancel',$this->Lang('cancel')));

$smarty->assign ('prompt_groupname', $this->Lang ('name'));
$smarty->assign ('prompt_groupdesc',$this->Lang ('description'));
$consumer = feu_utils::get_auth_consumer();
$addtext = '';
if( !$consumer->has_capability($consumer::CAPABILITY_EDITGROUPS) && !$consumer->has_capability($consumer::CAPABILITY_USESTDGROUPS) ) {
  $addtext='readonly="readonly" disabled="disabled"';
}
$smarty->assign ('input_groupname', $this->CreateInputText ($id, 'input_groupname', $groupname, 20, 80, $addtext));
$smarty->assign ('input_groupdesc', $this->CreateInputText ($id, 'input_groupdesc', $groupdesc, 80, 255, $addtext));

// display a list of the properties in a form
// to allow the user to pick which ones are required and which ones arent.
$rowarray = array();
$keys = array_keys($this->types);
$options = array( $this->Lang('off') => 0,
		  $this->Lang('optional') => 1,
		  $this->Lang('required') => 2,
		  $this->Lang('hidden') => 3,
		  $this->Lang('readonly') => 4);

$themeObject = cms_utils::get_theme_object();
$img_up = $themeObject->DisplayImage('icons/system/sort_up.gif',$this->Lang('move_up','','','systemicon'));
$smarty->assign('img_up',$img_up);
$img_down = $themeObject->DisplayImage('icons/system/sort_down.gif',$this->Lang('move_down','','','systemicon'));
$smarty->assign('img_down',$img_down);

$sortorder = 1;
foreach( $propdefn as $defn ) {
  $onerow = new StdClass();
  $onerow->name = $defn['name'];
  $onerow->prompt = $defn['prompt'];
  $onerow->type = $this->Lang($keys[$defn['type']]);
  $onerow->hidden = '<div>'.$this->CreateInputHidden($id,'input_name[]',$defn['name']).'</div>';
  $onerow->required = $this->CreateInputDropdown( $id, 'input_required[]', $options,-1, $defn['required']);
  $onerow->encrypted = $defn['encrypt'];

  if( $sortorder > 1 ) {
    $onerow->moveup_idx = $sortorder;
    $onerow->moveup = $this->CGCreateInputSubmit($id,'moveup',$sortorder,'','icons/system/sort_up.gif');
  }
  if( $sortorder < count($propdefn) ) {
    $onerow->movedown_idx = $sortorder;
    $onerow->movedown = $this->CGCreateInputSubmit($id,'movedown',$sortorder,'','icons/system/sort_down.gif');
  }

  if( $defn['encrypt'] == 0 && ($defn['type'] == 0 || $defn['type'] == 2 || $defn['type'] == 4) ) {
      $onerow->askinlostun = $this->CreateInputCheckbox( $id, 'input_lostun_'.$defn['name'], 1, $defn['lostun'] );
  }

  $rowarray[] = $onerow;
  ++$sortorder;
}

$smarty->assign('props', $rowarray);
$smarty->assign('propcount',count($rowarray));
$smarty->assign('sortordertext', $this->Lang('sortorder'));
$smarty->assign('nametext',$this->Lang('name'));
$smarty->assign('prompttext', $this->Lang('prompt'));
$smarty->assign('typetext',$this->Lang('type'));
$smarty->assign('fieldstatustext',$this->Lang('fieldstatus'));
$smarty->assign('usedinlostuntext',$this->Lang('usedinlostun'));

// Display the populated template
echo $this->ProcessTemplate ('addgroup.tpl');

?>
