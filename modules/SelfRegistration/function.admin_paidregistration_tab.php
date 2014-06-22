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
if( !$this->CheckPermission('Modify Site Preferences') ) return;
$feu = $this->GetModuleInstance('FrontEndUsers');
if( !$feu ) return;

$query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_paidpkgs ORDER BY name';
$packagelist = $db->GetArray($query);

if( is_array($packagelist) ) {
  for( $i = 0; $i < count($packagelist); $i++ ) {
    $rec =& $packagelist[$i];
    $rec['edit_url'] = $this->CreateURL($id,'admin_addpaidpkg',$returnid, array('pkgid'=>$rec['id']));
    $rec['delete_link'] = $this->CreateImageLink($id,'admin_delpaidpkg',$returnid, $this->Lang('delete'),
						 'icons/system/delete.gif', array('pkgid'=>$rec['id']));
    $rec['edit_link'] = $this->CreateImageLink($id,'admin_addpaidpkg',$returnid, $this->Lang('edit'),
					       'icons/system/edit.gif', array('pkgid'=>$rec['id']));
  }
}
// build the template'
$smarty->assign('packagelist',$packagelist);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_editregistrations'));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('addlink',$this->CreateImageLink($id,'admin_addpaidpkg',$returnid, $this->Lang('add_paidpkg'),
						 'icons/system/newobject.gif', array(),'','',false));

if( $this->GetModuleInstance('CGEcommerceBase') ) {
  $smarty->assign('currency_symbol',cg_ecomm::get_currency_symbol());
  $smarty->assign('currency_code',cg_ecomm::get_currency_code());
}
$smarty->assign('grouplist',array_flip($feu->GetGroupList()));
							     
echo $this->ProcessTemplate('admin_paidregistration_tab.tpl');

#
# EOF
#
?>