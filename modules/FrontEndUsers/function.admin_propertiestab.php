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

$message = '';
if( isset( $params['message'] ) ) $smarty->assign('message', $message);
$smarty->assign('title',$this->Lang('properties'));
$themeObject = cms_utils::get_theme_object();

$rowarray = array();
$rowclass = 'row1';
$keys = array_keys($this->types);

$defns = $this->GetPropertyDefns();
if( is_array($defns) ) {
  foreach( $defns as $defn ) {
    $attribs = '';
    if( $defn['attribs'] ) $attribs = unserialize($defn['attribs']);
    
    $propgroups = $this->GetPropertyGroupRelations($defn['name']);
    
    $onerow = new StdClass();
    if( $this->_HasSufficientPermissions('editprop') && !isset($defn['extra']['module']) ) {
      $onerow->name = $this->CreateLink( $id, 'addprop', $returnid, $defn['name'],array('propname' => $defn['name']));
    }
    else {
      $onerow->name = $defn['name'];
      if( isset($defn['extra']['module']) ) {
	$onerow->name .= '&nbsp;<em title="'.$this->Lang('title_propmodule').'">('.$defn['extra']['module'].')</em>';
      }
    }
    $onerow->encrypt = $defn['encrypt'];
    $onerow->prompt = $defn['prompt'];
    $onerow->type = $this->Lang($keys[$defn['type']]);
    $onerow->length = $defn['length'];
    $onerow->force_unique = $defn['force_unique'];
    $onerow->rowclass = $rowclass;
    $is_moduleprop = 0;
    if( isset($defn['extra']) && isset($defn['extra']['module']) &&
	$defn['extra']['module'] != '' ) {
      $tmp = cms_utils::get_module($defn['extra']['module']);
      if( is_object($tmp) ) {
	$is_moduleprop = 1;
      }
    }

    if( $this->_HasSufficientPermissions('editprop') && !isset($defn['extra']['module']) ) {
      $onerow->editlink =
	$this->CreateLink ($id, 'addprop', $returnid,
			   $themeObject->DisplayImage('icons/system/edit.gif',$this->Lang ('edit'), '', '', 'systemicon'),
			   array('propname' => $defn['name']));
      
      if( count($propgroups) == 0 && !$is_moduleprop ) {
	$onerow->deletelink =
	  $this->CreateLink ($id, 'do_deleteprop', $returnid,
			     $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang ('delete'), '', '', 'systemicon'),
			     array('propname' => $defn['name'], 'proptype' => $defn['type']), 
			     $this->Lang('confirm_delete_prop'));
      }
    }
    
    $rowarray[] = $onerow;
    ($rowclass == "row1" ? $rowclass = "row2" : $rowclass = "row1");
  }
 }

$smarty->assign('nametext',$this->Lang('name'));
$smarty->assign('lengthtext',$this->Lang('length'));
$smarty->assign('prompttext',$this->Lang('prompt'));
$smarty->assign('typetext',$this->Lang('prompt_type'));
$smarty->assign('props',$rowarray);
$smarty->assign('propcount', count($rowarray));
$smarty->assign('propsfound',$this->Lang('propsfound'));

if( $this->_HasSufficientPermissions('addprop') ) {
  // todo, add a permission check around this
  // maybe create an "edit frontenduser properties" permission
  $smarty->assign('addlink', 
		  $this->CreateLink($id,'addprop',$returnid,$themeObject->DisplayImage('icons/system/newobject.gif',
										       $this->Lang('addprop'),'','','systemicon'),
				    array(), '', false, false, '').' '.
		  $this->CreateLink( $id, 'addprop', $returnid, $this->Lang('addprop'), array(), '', false,false));
}

echo $this->ProcessTemplate('propertiesform.tpl');

// EOF
?>
