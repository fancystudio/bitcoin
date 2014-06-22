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

// initialization
$this->SetCurrentTab('regpkgs');
$error = '';
$pkgid = '';
$rec = array();
$rec['name'] = '';
$rec['prompt'] = '';
$rec['description'] = '';
$rec['gid'] = '';
$rec['subscr_num'] = 1;
$rec['subscr_type'] = 'yearly';
$rec['cost'] = '';
$groups = array_flip($feu->GetGroupList());

// handle incoming params
if( isset($params['pkgid']) ) {
  $pkgid = (int)$params['pkgid'];
  $query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_paidpkgs WHERE id = ?';
  $tmp = $db->GetRow($query,array($pkgid));
  if( $tmp )$rec = $tmp;
}

// handle form submit
if( isset($params['cancel']) ) {
  $this->RedirectToTab($id);
}
if( isset($params['submit']) ) {
  // fill in the record
  $rec['name'] = trim($params['pkg_name']);
  $rec['prompt'] = trim($params['pkg_prompt']);
  $rec['description'] = trim($params['pkg_description']);
  $rec['gid'] = (int)$params['pkg_gid'];
  if( isset($params['pkg_cost']) ) $rec['cost'] = (float)$params['pkg_cost'];
  if( isset($params['subscr_num']) ) $rec['subscr_num'] = (int)$params['subscr_num'];
  if( isset($params['subscr_type']) )$rec['subscr_type'] = trim($params['subscr_type']);

  // check for errors.
  $flds = array('name'=>$this->Lang('name'),'prompt'=>$this->Lang('prompt'));

  foreach( $flds as $fld => $lbl ) {
    $query = sprintf('SELECT id FROM '.cms_db_prefix().'module_selfreg_paidpkgs WHERE %s = ?',$fld);
    $parms = array($rec[$fld]);
    if( $pkgid ) {
      $query = sprintf('SELECT id FROM '.cms_db_prefix().'module_selfreg_paidpkgs WHERE %s = ? AND id != ?',$fld);
      $parms = array($rec[$fld],$pkgid);
    }
    $tmp = $db->GetOne($query,$parms);
    if( $tmp ) {
      $val = $rec[$fld];
      if( $fld == 'gid' ) $val = $groups[$rec[$fld]];
      $error = $this->Lang('error_pkgexists',$lbl,$val);
      break;
    }
  }

  if( $rec['cost'] < 0.0 ) $error = $this->Lang('error_pkgcost');

  if( !$error ) {
    // we're ready to insert or update.
    $res = '';
    if( !$pkgid ) {
      $query = 'INSERT INTO '.cms_db_prefix().'module_selfreg_paidpkgs
                (name,prompt,description,gid,cost,subscr_num,subscr_type)
                VALUES (?,?,?,?,?,?,?)';
      $res = $db->Execute($query,
			  array($rec['name'],$rec['prompt'],$rec['description'],
				$rec['gid'],$rec['cost'],
				$rec['subscr_num'],$rec['subscr_type']));
    }
    else {
      $query = 'UPDATE '.cms_db_prefix().'module_selfreg_paidpkgs
                SET name = ?, prompt = ?, description = ?, gid = ?, cost = ?,
                    subscr_num = ?, subscr_type = ?
                WHERE id = ?';
      $res = $db->Execute($query,
			  array($rec['name'],$rec['prompt'],$rec['description'],
				$rec['gid'],$rec['cost'],
				$rec['subscr_num'],$rec['subscr_type'],
				$pkgid));
    }

    if( !$res ) $error = $db->sql.'<br/>'.$db->ErrorMsg();
  }

  if( !$error ) $this->RedirectToTab($id);
}

// build the form
if( !empty($error) )  echo $this->ShowErrors($error);
$smarty->assign('grouplist',$groups);
$smarty->assign('pkgdata',$rec);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_addpaidpkg',$returnid,$params));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('input_description',$this->CreateTextArea(true,$id,$rec['description'],'pkg_description'));
$subscr_type = array();
$subscr_type['none'] = $this->Lang('none');
$subscr_type['month'] = $this->Lang('month');
$subscr_type['year'] = $this->Lang('year');
$smarty->assign('subscr_types',$subscr_type);

$tmp = array();
for( $i = 1; $i < 25; $i++ ) {
  $tmp[$i]=$i;
}
$smarty->assign('nums',$tmp);

if( $this->GetModuleInstance('CGEcommerceBase') ) {
  $smarty->assign('currency_symbol',cg_ecomm::get_currency_symbol());
  $smarty->assign('currency_code',cg_ecomm::get_currency_code());
}

$obj = cms_utils::get_module('CGEcommerceBase');
if( is_object($obj) ) {
  $smarty->assign('can_edit_cost',1);
}
echo $this->ProcessTemplate('admin_addpaidpkg.tpl');

#
# EOF
#
?>