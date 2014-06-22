<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: SelfRegistration (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to register themselves
#  with a website.
# 
# Version: 1.2
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

// an order has been updated.
if( !isset($params['order_id']) ) return;
if( !$this->GetPreference('allowpaidregistration') ) return;

// handle the case of attempted recursion.
if( cge_tmpdata::exists(__FILE__) ) return;
cge_tmpdata::set(__FILE__,1);

// here we grab the order directly.
$order_modified = FALSE;
$order_id = (int)$params['order_id'];
$order_obj = orders_ops::load_by_id($order_id);
if( !$order_obj ) 
  {
    return;
  }

if( $order_obj->get_status() != ORDERSTATUS_SUBSCRIBED && $order_obj->get_status() != ORDERSTATUS_PAID )
  {
    // don't do anything unless we're dealing with a subscribed order.
    return;
  }

// get the list of packages
$pkgs = '';
{
  $query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_paidpkgs';
  $tmp = $db->GetArray($query);
  if( !$tmp ) 
    {
      return; // no packages
    }
  $pkgs = cge_array::to_hash($tmp,'id');
}

// find the line item with a SelfReg Subscription.
for( $s = 0; $s < $order_obj->count_destinations(); $s++ )
  {
    $shipping = $order_obj->get_shipping($s);
    for( $i = 0; $i < $shipping->count_all_items(); $i++ )
      {
	$item = $shipping->get_item($i);
	if( $item->get_source() != $this->GetName() ) 
	  {
	    continue;
	  }
	if( $item->get_item_type() != line_item::ITEMTYPE_SERVICE ) continue;
	//if( !$item->is_subscription() ) continue;

	$temp_uid = $item->get_item_id();
	$sku = $item->get_sku();
	if( !$sku ) continue; // no sku
  
	list($code,$pkgid,$tmpuid) = explode('-',$sku,3);
	$pkgid = (int)$pkgid;
	$tmpuid = (int)$tmpuid;
	if( $code != 'sr' && $tmpuid != $temp_uid ) continue; // bad sku
	if( !isset($pkgs[$pkgid]) )
	  {
	    continue; // package deleted?
	  }

	// see if we can find this temp user
	$query = 'SELECT * FROM '.cms_db_prefix().'module_selfreg_users
             WHERE id = ?';
	$tmp_user = $db->GetRow($query,array($temp_uid));
	if( !$tmp_user )
	  {
	    continue; // no temp user found.
	  }

	// push the user live.
	$pkg = $pkgs[$pkgid];
	$expires = '';
	switch($pkg['subscr_type'])
	  {
	  case 'month':
	  case 'months':
	    $expires = strtotime(sprintf("+%d months",$pkg['subscr_num']));
	    break;
	  case 'year':
	  case 'years':
	    $expires = strtotime(sprintf("+%d years",$pkg['subscr_num']));
	    break;
	  }
	if( $expires < time() ) $expries = ''; // fallback for a wraparound

	$res = $this->_CreateFrontendUser($temp_uid,$tmp_user['username'],$tmp_user['passsword'],$expires,FALSE);
	$feu_uid = '';
	if( is_array($res) && $res[0] !== FALSE ) $feu_uid = $res[1];
	$this->Audit($temp_uid,$this->GetName(),
		     sprintf('Moved Selfreg Temporary User %d to FrontEndUsers with uid %d to expire on %s',$temp_uid,$feu_uid,strftime('%x %X',$expires)));

	// delete the temp user.
	$this->DeleteTempUserProperties($temp_uid);
	$this->DeleteTempUser($temp_uid);

	// update the line item with the FEU uid
	$item->set_extra('feu_uid',$feu_uid);
	$order_modified = TRUE;
      }
  }

// and save the order.
if( $order_modified ) $order_obj->save();

// setup for another order... shouldn't happen, but just in case.
cge_tmpdata::erase(__FILE__);
#
# EOF
#
?>
