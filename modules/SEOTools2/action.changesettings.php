<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Action: changesettings
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

if (! $this->CheckAccess("Edit SEO Settings"))
{
  return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
}

// Regenerate Sitemap and robots.txt
if (isset($_POST['do_regenerate'])) {
  $push = $this->GetPreference('push_sitemap',1);
  seo2_utils::createSitemap($push == 1);
  $robots = $this->GetPreference('create_robots',1);
  if ($robots == 1) {
    seo2_utils::createRobotsTXT();
  }
  $this->audit("Test","SEOTools2","Manually regenerated sitemap.xml and robots.txt");
  $this->Redirect($this->id, 'defaultadmin', '', Array('message'=>'sitemap_regenerated','tab'=>'sitemapsettings'));
}

// save meta settings
if (isset($_POST['save_meta_settings'])) {
   
  $meta_standard = isset($_POST['meta_standard']) ? 1 : 0;
  $this->SetPreference('meta_standard',$meta_standard);

  $meta_dublincore = isset($_POST['meta_dublincore']) ? 1 : 0;
  $this->SetPreference('meta_dublincore',$meta_dublincore);

  $meta_opengraph = isset($_POST['meta_opengraph']) ? 1 : 0;
  $this->SetPreference('meta_opengraph',$meta_opengraph);

  $this->SetPreference('additional_meta_tags',$_POST['additional_meta_tags']);

  $this->SetPreference('meta_publisher',$_POST['meta_publisher']);
  $this->SetPreference('meta_contributor',$_POST['meta_contributor']);
  $this->SetPreference('meta_copyright',$_POST['meta_copyright']);

  $this->SetPreference('meta_location',$_POST['meta_location']);
  $this->SetPreference('meta_region',$_POST['meta_region']);
  $this->SetPreference('meta_latitude',$_POST['meta_latitude']);
  $this->SetPreference('meta_longitude',$_POST['meta_longitude']);

  $this->SetPreference('meta_opengraph_title',$_POST['meta_opengraph_title']);
  $this->SetPreference('meta_opengraph_type',$_POST['meta_opengraph_type']);
  $this->SetPreference('meta_opengraph_sitename',$_POST['meta_opengraph_sitename']);
  $this->SetPreference('meta_opengraph_image',$_POST['meta_opengraph_image']);
  $this->SetPreference('meta_opengraph_admins',$_POST['meta_opengraph_admins']);
  $this->SetPreference('meta_opengraph_application',$_POST['meta_opengraph_application']);

  $this->SetPreference('title',$_POST['title']);
  $this->SetPreference('title_meta',$_POST['title_meta']);
  $this->SetPreference('description_block',$_POST['description_block']);
  $this->SetPreference('detail_keywords_var',$_POST['detail_keywords_var']);

  $description_auto_generate = isset($_POST['description_auto_generate']) ? 1 : 0;

  $this->SetPreference('description_auto_generate',$description_auto_generate);

  $this->SetPreference('description_auto',$_POST['description_auto']);
  $this->SetPreference('default_keywords',$_POST['default_keywords']);

  $this->SetPreference('meta_doctype',$_POST['meta_doctype']);
  
  $compile_udts = isset($_POST['compile_udts']) ? 1 : 0;
  $this->SetPreference('compile_udts',$compile_udts);
    
  $this->audit("Test","SEOTools2","Edited Meta settings");
  $this->Redirect($this->id, 'defaultadmin', '', Array('message'=>'settings_updated','tab'=>'metasettings'));
}

// save sitemap settings
if (isset($_POST['save_sitemap_settings'])) {

  $create_sitemap = isset($_POST['create_sitemap']) ? 1 : 0;
  $this->SetPreference('create_sitemap',$create_sitemap);

  $push_sitemap = isset($_POST['push_sitemap']) ? 1 : 0;
  $this->SetPreference('push_sitemap',$push_sitemap);

  $create_robots = isset($_POST['create_robots']) ? 1 : 0;
  $this->SetPreference('create_robots',$create_robots);

  $this->SetPreference('verification',$_POST['verification']);

  $this->audit("Test","SEOTools2","Edited Sitemap settings");
  $this->Redirect($this->id, 'defaultadmin', '', Array('message'=>'settings_updated','tab'=>'sitemapsettings'));
}

// save custom robots settings
if (isset($_POST['save_custom_robots_settings'])) {
  $this->SetPreference('r_before',$_POST['robots_before']);
  $this->SetPreference('r_after', $_POST['robots_after']);

  $this->audit("Test","SEOTools2","Edited custom robots.txt settings");
  $this->Redirect($this->id, 'defaultadmin', '', Array('message'=>'settings_updated','tab'=>'sitemapsettings'));
  
}

// save keyword settings
if (isset($_POST['save_keyword_settings'])) {

  $this->SetPreference('keyword_minlength',$_POST['keyword_minlength']);
  $this->SetPreference('keyword_title_weight',$_POST['keyword_title_weight']);
  $this->SetPreference('keyword_description_weight',$_POST['keyword_description_weight']);
  $this->SetPreference('keyword_headline_weight',$_POST['keyword_headline_weight']);
  $this->SetPreference('keyword_content_weight',$_POST['keyword_content_weight']);
  $this->SetPreference('keyword_minimum_weight',$_POST['keyword_minimum_weight']);

  $this->SetPreference('keyword_exclude',$_POST['keyword_exclude']);

  $this->audit("Test","SEOTools2","Edited Keyword settings");
  $this->Redirect($this->id, 'defaultadmin', '', Array('message'=>'settings_updated','tab'=>'keywordsettings'));
}

// Do events
$this->SendEvent('PrefsUpdated',$_POST);


?>