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
if( !isset($gCms) ) return;

$params = selfreg_utils::clean_params($params);

// we're allowing the user to select his own package (group(s)).
if( isset($params['submit']) && isset($params['selpkg']) && $this->GetPreference('allowselectpkg') ) {
  $pkgids = array();
  if( is_array($params['selpkg']) ) {
    $pkgids = $params['selpkg'];
  }
  else {
    $pkgids = array($params['selpkg']);
  }
  foreach( $pkgids as &$one ) {
    $one = (int)$one;
  }

  if( count($pkgids) > 1 && $this->GetPreference('allowselectpkg') < 2 ) {
    $this->_DisplayErrorPage($id,$params,$returnid, $this->Lang('error_multiplepkgs'));
    return;
  }

  $pkgids = array_unique($pkgids);
  $query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_paidpkgs WHERE id IN ('.implode(',',$pkgids).')';
  $pkgs = $db->GetArray($query);
  if( !is_array($pkgs) || count($pkgs) == 0 ) {
    // couldn't find the package.
    $this->_DisplayErrorPage($id,$params,$returnid, $this->Lang('error_dberror'));
    return;
  }

  $feu = $this->GetModuleInstance('FrontEndUsers');
  $gids = cge_array::extract_field($pkgs,'gid');
  $allgroups = $feu->GetGroupListFull();
  $allgroups = array_keys($allgroups);
  foreach( $gids as $gid ) {
    if( !in_array($gid,$allgroups) ) {
      $this->_DisplayErrorPage($id,$params,$returnid, $this->Lang('error_dberror'));
      return;
    }
  }

  $parms = array('sr_group'=>$gids,'sr_pkg'=>$pkgids);
  $parms['sr_data'] = base64_encode(serialize($parms));
  $this->Redirect($id,'signup',$returnid,$parms);
}

// build the template
$query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_paidpkgs ORDER BY name';
$ppkgs = $db->GetArray($query);
if( !$ppkgs ) {
  $this->_DisplayErrorPage($id,$params,$returnid, $this->Lang('error_nopkgs'));
}

$pkgs = array();
for( $i = 0; $i < count($ppkgs); $i++ ) {
  $rec =& $ppkgs[$i];
  $pkgs[$rec['id']] = $rec['prompt'];
}
if( isset( $params['error'] ) ) $smarty->assign('error', $params['error']);
if( isset( $params['message'] ) ) $smarty->assign('message', $params['message']);

$mod = cms_utils::get_module('CGEcommerceBase');
if( $mod ) {
  $smarty->assign('currency_symbol',cg_ecomm::get_currency_symbol());
  $smarty->assign('currency_code',cg_ecomm::get_currency_code());
}
$smarty->assign('pkgs',$ppkgs);
$smarty->assign('pkglist',$pkgs);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'selpkg',$returnid,$params));
$smarty->assign('formend',$this->CreateFormEnd());
if( $this->GetPreference('allowselectpkg') == 2 ) $smarty->assign('inputtype','checkbox');
echo $this->ProcessTemplateFromDatabase('selpkgtemplate');

#
# EOF
#
?>