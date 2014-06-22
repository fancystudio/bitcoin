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

// an order has been deleted.
if( !isset($params['order_id']) ) return;

// handle the case of attempted recursion.
if( cge_tmpdata::exists(__FILE__) ) return;
cge_tmpdata::set(__FILE__,1);

// here we grab the order directly.
$order_id = (int)$params['order_id'];
$order_obj = orders_ops::load_by_id($order_id);
if( !$order_obj )
  {
    return;
  }

// find the line item with a SelfReg Subscription.
for( $s = 0; $s < $order_obj->count_destinations(); $s++ )
  {
    $shipping = $order_obj->get_shipping($s);
    for( $i = 0; $i < $shipping->count_all_items(); $i++ )
      {
	$item = $shipping->get_item($i);
	if( $item->get_source() != 'SelfRegistration' )
	  {
	    continue;
	  }
	if( $item->get_item_type() != line_item::ITEMTYPE_SERVICE ) continue;
	if( !$item->is_subscription() ) continue;

	$uid = $item->get_extra('feu_uid');
	if( !$uid ) continue;  // no assocdata, maybe this user never paid.

	$uinfo = $this->GetUserInfo( $uid );
	if( !is_array($uinfo) || $uinfo[0] == FALSE )
	  {
	    $this->Audit($uid,$this->GetName(),
			 sprintf('Order %d deleted but cannot find user account',$order_id));
	    return;
	  }
	$uinfo = $uinfo[1];

	switch( $this->GetPreference('ecomm_orderdeleted') )
	  {
	  case 'delete':
	    $this->DeleteAllUserProperties('',$uid,true);
	    $this->DeleteUserFull($uid);
	    $this->Audit($uid,$this->GetName(),
			 sprintf('Deleted user %s because order %d was deleted',$uinfo['username'],$order_id));
	    break;

	  case 'expire':
	    $this->SetUser($uid,$uinfo['username'],$uinfo['password'],time()-3600,false);
	    $this->Audit($uid,$this->GetName(),
			 sprintf('Expired user %s because order %d was deleted',$uinfo['username'],$order_id));
	    break;

	  case 'none':
	  default:
	    break;
	  }

      }
  }

// setup for another order... shouldn't happen, but just in case.
cge_tmpdata::erase(__FILE__);

#
# EOF
#
?>