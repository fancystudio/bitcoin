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

$db =& $this->GetDb();
$dict = NewDataDictionary( $db );
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_users" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_groups" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_loggedin" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_belongs" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_properties" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_propdefn" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_dropdowns" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_grouppropmap" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_tempcode" );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_feusers_history" );
$dict->ExecuteSQLArray($sqlarray);

$db->DropSequence( cms_db_prefix()."module_feusers_users_seq" );
$db->DropSequence( cms_db_prefix()."module_feusers_groups_seq" );
$db->DropSequence( cms_db_prefix()."module_feusers_properties_seq" );

// templates
$this->DeleteTemplate();

// preferences
$this->RemovePreference();

// permissions
$this->RemovePermission('Modify FrontEndUserProps');

// FEUsers-specific permissions ... may or may not exist
$this->RemovePermission('FEU Add Users');
$this->RemovePermission('FEU Modify Users');
$this->RemovePermission('FEU Remove Users');
$this->RemovePermission('FEU Add Groups');
$this->RemovePermission('FEU Modify Groups');
$this->RemovePermission('FEU Modify Group Assignments');
$this->RemovePermission('FEU Remove Groups');
$this->RemovePermission('FEU Modify Site Preferences');
$this->RemovePermission('FEU Modify FrontEndUserProps');
$this->RemovePermission('FEU Modify Templates');

// Events
$this->RemoveEvent( 'OnLogin' );
$this->RemoveEvent( 'OnLogout' );
$this->RemoveEvent( 'OnExpireUser' );
$this->RemoveEvent( 'OnCreateUser' );
$this->RemoveEvent( 'OnDeleteUser' );
$this->RemoveEvent( 'OnCreateGroup' );
$this->RemoveEvent( 'OnDeleteGroup' );
$this->RemoveEvent( 'OnUpdateUser' );

$this->RemoveEventHandler('Core','ContentPostRender');
$this->RemoveEventHandler('CGEcommerceBase','OrderUpdated');
$this->RemoveEventHandler('CGEcommerceBase','OrderDeleted');

?>