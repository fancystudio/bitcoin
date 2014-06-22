<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Method: uninstall
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
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


if (!isset($gCms)) exit;

/*---------------------------------------------------------
Uninstall()
Sometimes, an exceptionally unenlightened or ignorant
admin will wish to uninstall your module. While it
would be best to lay into these idiots with a cluestick,
we will do the magnanimous thing and remove the module
and clean up the database, permissions, and preferences
that are specific to it.
This is the method where we do this.
---------------------------------------------------------*/

// Typical Database Removal
$db = cmsms()->GetDb();

// remove the database table
$dict = NewDataDictionary( $db );
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_seotools2" );
$dict->ExecuteSQLArray($sqlarray);

// remove the permissions
$this->RemovePermission('Edit SEO Settings');
$this->RemovePermission('Edit page descriptions');

// remove site preferences
$this->RemovePreference('additional_meta_tags');
$this->RemovePreference('create_robots');
$this->RemovePreference('create_sitemap');
$this->RemovePreference('default_keywords');
$this->RemovePreference('description_auto');
$this->RemovePreference('description_auto_generate');
$this->RemovePreference('description_block');
$this->RemovePreference('detail_keywords_var');

$this->RemovePreference('keyword_content_weight');
$this->RemovePreference('keyword_description_weight');
$this->RemovePreference('keyword_exclude');
$this->RemovePreference('keyword_headline_weight');
$this->RemovePreference('keyword_minimum_weight');
$this->RemovePreference('keyword_minlength');
$this->RemovePreference('keyword_title_weight');
$this->RemovePreference('meta_contributor');
$this->RemovePreference('meta_copyright');
$this->RemovePreference('meta_dublincore');
$this->RemovePreference('meta_latitude');
$this->RemovePreference('meta_location');
$this->RemovePreference('meta_longitude');
$this->RemovePreference('meta_opengraph');
$this->RemovePreference('meta_opengraph_admins');
$this->RemovePreference('meta_opengraph_application');
$this->RemovePreference('meta_opengraph_image');
$this->RemovePreference('meta_opengraph_sitename');
$this->RemovePreference('meta_opengraph_title');
$this->RemovePreference('meta_opengraph_type');
$this->RemovePreference('meta_publisher');
$this->RemovePreference('meta_region');
$this->RemovePreference('meta_standard');
$this->RemovePreference('push_sitemap');
$this->RemovePreference('title');
$this->RemovePreference('title_meta');
$this->RemovePreference('pref_verification');
$this->RemovePreference('meta_doctype');
$this->RemovePreference('compile_udts');
$this->RemovePreference('r_before');
$this->RemovePreference('r_after');


// remove events and event handlers
$this->RemoveEventHandler( 'PrefsUpdated' );
$this->RemoveEvent( 'PrefsUpdated' );
$this->RemoveEventHandler('Core','ContentEditPre',false);
$this->RemoveEventHandler('Core','ContentEditPost',false);
$this->RemoveEventHandler('Core','ContentDeletePost',false);
$this->RemoveEventHandler('Core','ContentPostRender',false);


// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));

?>