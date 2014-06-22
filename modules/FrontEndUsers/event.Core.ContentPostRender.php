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
if( !isset($gCms) ) exit();
return;

// 0.  Check cms version
global $CMS_VERSION;
if( version_compare($CMS_VERSION,'2.0-beta1') < 0 ) {
  // not CMS 2.0, don't go any further.
  return;
}

// 1.  Get the content_id
$content_id = cms_utils::get_current_pageid();
if( $content_id <= 0 ) return;

// 2.  Get the content object
if( class_exists('CMSContent'))
$content_obj = CmsContentOperations::load_content_from_id($content_id);
if( !is_object($content_obj) )
  {
    return;
  }

// 3.  Get the properties.
$content_obj->load_properties();
$feu_groups = $content_obj->get_property_value('feu_groups');
$feu_redirect = $content_obj->get_property_value('feu_redirect');

// if the groups list is empty, return.
if( $feu_groups == '' ) return;

// check this users member groups
$passed = false;
$uid = $this->LoggedInId();
if( $uid )
  {
    // get the member groups.
    $t1 = $this->GetMemberGroups($uid);
    if( is_array( $t1 ) )
      {
	// user is a member of at least one group
	$membergroups = array();
	foreach( $t1 as $row )
	  {
	    $membergroups[] = $row['groupid'];
	  }

	// test membership.
	$t1 = explode(',',$feu_groups);
	if( in_array($t1,'-1') )
	  {
	    // any group will do.
	    $passed = true;
	  }
	else
	  {
	    $tmp = array_intersect($membergroups,$t2);
	    if( is_array($tmp) && count($tmp) > 0 )
	      {
		$passed = true;
	      }
	  }
      }
  }

if( !$passed )
  {
    if( $feu_redirect != -1 )
      {
	redirect_to_alias($feu_redirect);
      }
  }
#
# EOF
#
?>
