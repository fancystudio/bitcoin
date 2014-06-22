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
if( !isset($gCms) ) exit;
if( !isset($params['status']) ) return;
if( !isset($params['extra']) || $params['extra'] == 'gateway-complate' ) return;

$status = cms_utils::get_app_data('orders_gateway_complete');
if( $status == 1 ) {
  // called via the orders gateway complete stuff... 
  // cart probably being emptied.
  // lets not do anything.
  return;
}

switch($params['status']) {
 case 'before':
   $sess = new cge_session($this->GetName());
   if( count($params['cart_items']) > 1 ) {
     // there's more than one item
     return;
   }
   $tmp = serialize($params['cart_items']);
   $sess->put('cart_before',$tmp);
   break;

 case 'after':
   $sess = new cge_session($this->GetName());
   $before = $sess->get('cart_before');
   $sess->clear('cart_before');
   if( empty($before) ) return; // we only care if something was deleted.

   $before = unserialize($before);
   $after = $params['cart_items'];

   // now we gotta figure out what changed.
   $tmp = array_keys($before);
   $cartname = $tmp[0];

   $after_ser = array();
   if( is_array($after) && count($after) ) {
     $after_ser = array();
     foreach( $after as $one ) {
       $after_ser[] = serialize($one);
     }
   }

   $items = $before[$cartname]['items'];
   $before_ser = array();
   for( $i = 0; $i < count($items); $i++ ) {
     $before_ser[] = serialize($items[$i]);
   }

   $deleted_ser = array_diff($before_ser,$after_ser);

   // now deserialize everything
   // and catch the ones that originated from this module
   $deleted = array();
   for( $i = 0; $i < count($deleted_ser); $i++ ) {
     $tmp = unserialize($deleted_ser[$i]);
     if( !($tmp instanceof cg_ecomm_cartitem) ) continue;
     if( $tmp->get_source() != $this->GetName() ) continue;
     $deleted[] = $tmp;
   }

   if( count($deleted) ) {
     // we have a list of deleted selfreg items.
     for( $i = 0; $i < count($deleted); $i++ ) {
       $temp_user_id = $deleted[$i]->get_product_id();

       // delete this temporary user.
       // we don't track errors, because this event is also called
       // from the gateway complete process (which erases the cart)
       // therefore the user may have already been pushed live
       // by the checkout process.
       $this->DeleteTempUserProperties( $temp_user_id );
       $this->DeleteTempUser( $temp_user_id );
       audit('',$this->GetName(),'Deleted temp user '.$temp_user_id);
     }
   }
   break;
 }

#
# EOF
#
?>