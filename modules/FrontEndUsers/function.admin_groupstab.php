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

$groups = $this->GetGroupListFull(TRUE);
$rowclass = 'row1';

$themeObject = cms_utils::get_theme_object();
$propdefns = $this->GetPropertyDefns();
$ndefs = (is_array($propdefns) && count($propdefns))?count($propdefns):0;
$rowarray = array();
$smarty->assign( 'groupsfound', $this->Lang('groupsfound'));
$smarty->assign( 'nprops',$ndefs);
foreach( $groups as $onegroup ) {
  if( $this->_HasSufficientPermissions('listgroups') ) {
    $onerow = new stdClass();
    $onerow->id = $onegroup['id'];
    $onerow->name = $this->CreateLink( $id, 'addgroup', $returnid, $onegroup['groupname'], array ('group_id' => $onegroup['id']));			       
    $onerow->desc = $onegroup['groupdesc'];
    $onerow->nusers = '';
    if( isset($onegroup['count']) ) $onerow->nusers = $onegroup['count'];
    $onerow->rowclass = $rowclass;

    if( $this->_HasSufficientPermissions('editgroups') && $ndefs ) {
      $onerow->editlink =
	$this->CreateLink ($id, 'addgroup', $returnid,
			   $themeObject->DisplayImage ('icons/system/edit.gif',$this->Lang ('edit'), '', '', 'systemicon'),
			   array ('group_id' => $onegroup['id']));
      $onerow->exportlink =
	$this->CreateLink ($id, 'admin_exportgroup', $returnid,
			   '<img src="'.$this->GetModuleURLPath().'/icons/xml_rss.gif" alt="xml"/>',
			   array('group_id'=>$onegroup['id'],
				 'disable_buffer'=>1,
				 'disable_theme'=>1),
			   '', false, false, 'class="systemicon" title="'.$this->Lang('title_rssexport').'"');
    }
    if( $this->_HasSufficientPermissions('removegroups') && $onerow->nusers == 0 ) {
      $onerow->deletelink =
	$this->CreateLink ($id, 'do_deletegroup', $returnid,
			   $themeObject->DisplayImage ('icons/system/delete.gif',$this->Lang ('delete'), '', '', 'systemicon'),
			   array ('group_id' => $onegroup['id']),
			   $this->Lang ('areyousure_deletegroup'));
    }
	  
    $rowarray[] = $onerow;
    ($rowclass == "row1" ? $rowclass = "row2" : $rowclass = "row1");
  }

  $smarty->assign('itemcount',count($rowarray));
  $smarty->assign('items',$rowarray);
  $smarty->assign('groupsfound', $this->Lang('groupsfound') );
  $smarty->assign('idtext', $this->Lang('id'));
  $smarty->assign('nametext', $this->Lang('name'));
  $smarty->assign('desctext', $this->Lang('description'));
}

if( $this->_HasSufficientPermissions('addgroup') ) {
  $smarty->assign('propcount',count($propdefns));
  if( is_array($propdefns) && count($propdefns) > 0 ) {
    $smarty->assign('addgrouplink', 
		    $this->CreateLink( $id, 'addgroup', $returnid,
				       $themeObject->DisplayImage('icons/system/newobject.gif',$this->Lang('addgroup'),'','','systemicon')).' '.
		    $this->CreateLink( $id, 'addgroup', $returnid,$this->Lang('addgroup')));
  }

  $smarty->assign('importlink',
		  $this->CreateLink( $id, 'admin_importgroup', $returnid,
				     $themeObject->DisplayImage('icons/system/import.gif', $this->Lang('importgroup'),'','','systemicon')).' '.
		  $this->CreateLink( $id, 'admin_importgroup', $returnid, $this->Lang('importgroup'))); 
}

echo $this->ProcessTemplate( 'grouplist.tpl' );

// EOF
?>