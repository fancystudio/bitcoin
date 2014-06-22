<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Event: CoreContentEditPost
# Function: Code to create and push sitemap to Google Webmasters if required
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
$mod = cms_utils::get_module('SEOTools2');


if (!$mod->CheckPermission('Edit SEO Settings') ==1 )
return;  // does not have permission to edit seo settings


$db = cmsms()->GetDb();

$content = $params['content'];
$contentops = ContentOperations::get_instance();
$content_id = $content->Id();
$contentobj = $contentops->LoadContentFromId($content_id);

if ($contentobj)
{
  $hid = $contentobj->Hierarchy();
  if (!$hid) {
    // New pages are only partially saved. We need to set/get the hierarchy stuff
    $contentops->SetHierarchyPosition($contentobj->Id());
    $hid = $contentobj->Hierarchy();
  }
  $contentops->CreateFriendlyHierarchyPosition($hid);

  // See if an inactive page has been made active during the edit
  if (isset($_SESSION['seo2_old_active']) && $contentobj->Active() == 1 && $mod->GetPreference('push_sitemap') == 1) {
    // Grab the pre save value of the Active status from the session then drop the session var
    $old_active = $_SESSION['seo2_old_active'];
    unset ($_SESSION['seo2_old_active']);

    // Force the page to appear in the sitemap. Not ideal but better than nothing
    $query = "SELECT content_id FROM " .cms_db_prefix() . 'module_seotools2 where content_id =?';
    $seo1 = $db->GetOne($query,array($content_id));
    
    if (!$seo1){
      $q2 = "INSERT INTO ".cms_db_prefix()."module_seotools2 SET content_id = ?, indexable = ?, follow = ?";
      $arr = array($content_id,1,0);
    } else {
    $q2 = "UPDATE ".cms_db_prefix()."module_seotools2 SET indexable = ?, follow = ? WHERE content_id = ?";
      $arr = array(1,0,$content_id);
    }

    if (!$result = $db->Execute($q2,$arr)){
      echo 'problem here<br />';
      echo $db->sql;
      die;
    }

  }
  $updated = seo2_utils::seotools2_db_update();

  if ($updated == true ) {
    seo2_utils::createSitemap($this->GetPreference('push_sitemap') == 1);
  }

}