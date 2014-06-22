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
if( !$this->_HasSufficientPermissions( 'removegroups' ) ) return;

if (!isset ($params['group_id']) || $params['group_id'] == "") {
  $this->_DisplayErrorPage ($id, $params, $returnid,
			    $this->Lang ('error_insufficientparams'));
  return;
}  

$group = $this->GetGroupInfo( $params['group_id'] );
if( !isset($group['id']) && $group[0] == FALSE ) {
  $this->_DisplayErrorPage ($id, $params, $returnid, $group[1] );
  return;
}

$query = new feu_user_query();
$query->add_and_opt(feu_user_query_opt::MATCH_GROUPID,$group['id']);
$rs = $query->execute();
if( $rs->get_found_rows() > 0 ) {
  $this->_DisplayErrorPage ($id, $params, $returnid,
			    $this->Lang ('error_notemptygroup'));
  return;
}

$ret = $this->DeleteGroupFull( $params['group_id'] );
if( $ret[0] == FALSE ) {
  $this->_DisplayErrorPage ($id, $params, $returnid, $group[1] );
  return;
}

$parms = array();
$parms['id'] = $params['group_id'];
$parms['name'] = $group['groupname'];
$this->SendEvent('OnDeleteGroup',$parms);
$this->_SendNotificationEmail('OnDeleteGroup',$parms);

$this->RedirectToTab($id, 'groups' );

?>
