<?php

#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Method: install
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
Install()
When your module is installed, you may need to do some
setup. Typical things that happen here are the creation
and prepopulation of database tables, database sequences,
permissions, preferences, etc.
   
For information on the creation of database tables,
check out the ADODB Data Dictionary page at
http://phplens.com/lens/adodb/docs-datadict.htm

This function can return a string in case of any error,
and CMS will not consider the module installed.
Successful installs should return FALSE or nothing at all.
---------------------------------------------------------*/

// Typical Database Initialization
$db =cmsms()->GetDb();
	
// mysql-specific, but ignored by other database
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$dict = NewDataDictionary($db);

// table schema description
$flds = "
	content_id I KEY,
	indexable I(1),
	follow I(1),
	keywords C(255),
	priority I(3),
	ogtype C(32)
	";

// create it. This should do error checking, but I'm a lazy sod.
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_seotools2",
		$flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Test if installation worked:
$query = 'SELECT * FROM '.cms_db_prefix().'module_seotools2';
$result = $db->Execute($query);
if (!$result) {
	return $this->Lang('install_database_error');
}

// permissions
$this->CreatePermission('Edit SEO Settings','Edit SEO Settings');
$this->CreatePermission('Edit page descriptions','Edit page descriptions');

// add site preferences
$this->SetPreference('additional_meta_tags','<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">');
$this->SetPreference('create_robots',1);
$this->SetPreference('create_sitemap',1);
$this->SetPreference('default_keywords','');
$this->SetPreference('description_auto','This page covers the topics {keywords}');
$this->SetPreference('description_auto_generate',1);
$this->SetPreference('description_block','');
$this->SetPreference('detail_keywords_var','');
$this->SetPreference('keyword_content_weight',1);
$this->SetPreference('keyword_description_weight',4);
$this->SetPreference('keyword_exclude','i, me, my, myself, we, our, ours, ourselves, you, your, yours, yourself, yourselves, he, him, his, himself, she, her, hers, herself, it, its, itself, they, them, their, theirs, themselves, what, which, who, whom, this, that, these, those, am, is, are, was, were, be, been, being, have, has, had, having, do, does, did, doing, a, an, the, and, but, if, or, because, as, until, while, of, at, by, for, with, about, against, between, into, through, during, before, after, above, below, to, from, up, down, in, out, on, off, over, under, again, further, then, once, here, there, when, where, why, how, all, any, both, each, few, more, most, other, some, such, no, nor, not, only, own, same, so, than, too, very, lorem, coming');
$this->SetPreference('keyword_headline_weight',2);
$this->SetPreference('keyword_minimum_weight',7);
$this->SetPreference('keyword_minlength',5);
$this->SetPreference('keyword_title_weight',6);
$this->SetPreference('meta_contributor','');
$this->SetPreference('meta_copyright','(c) {custom_copyright} {sitename}. All rights reserved.');
$this->SetPreference('meta_dublincore',0);
$this->SetPreference('meta_latitude','');
$this->SetPreference('meta_location','');
$this->SetPreference('meta_longitude','');
$this->SetPreference('meta_opengraph',0);
$this->SetPreference('meta_opengraph_admins','');
$this->SetPreference('meta_opengraph_application','');
$this->SetPreference('meta_opengraph_image','');
$this->SetPreference('meta_opengraph_sitename','');
$this->SetPreference('meta_opengraph_title','{title}');
$this->SetPreference('meta_opengraph_type','');
$this->SetPreference('meta_publisher','{sitename}');
$this->SetPreference('meta_region','');
$this->SetPreference('meta_standard',1);
$this->SetPreference('push_sitemap',1);
$this->SetPreference('title','{title} | {$sitename} - {$title_keywords}');
$this->SetPreference('title_meta','{title} | {$sitename}');
$this->SetPreference('pref_verification','');
$this->SetPreference('meta_doctype',3);
$this->SetPreference('compile_udts',1);
$this->SetPreference('r_before','');
$this->SetPreference('r_after','');

// register events and add event handlers
$this->CreateEvent( 'PrefsUpdated' );
$this->AddEventHandler('Core','ContentEditPre',false);
$this->AddEventHandler('Core','ContentEditPost',false);
$this->AddEventHandler('Core','ContentDeletePost',false);
$this->AddEventHandler('Core','ContentPostRender',false);


// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
		
?>