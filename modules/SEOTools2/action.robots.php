<?php

#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Action: robots - updates the robots.txt file in the root dir
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


$config = cmsms()->GetConfig();
$root_path = str_replace('\\','/',$config['root_path']); // for Windows
$server_root = $_SERVER['DOCUMENT_ROOT'];

// grab a copy of the existing robots.txt file and show it on the screen
$filename = $server_root. DIRECTORY_SEPARATOR .'robots.txt';

// just in case the server doubled up on the directory separators
$filename = str_replace('//','/',$filename);

// wasn't there to start with!
if (!file_exists ($filename)){
  $this->redirect(null,'changesettings',$_POST['do_regenerate']);
}

// you're going to delete the old one now!
if (isset($_POST['do_delete_robots'])){
  unlink ($filename);
  seo2_utils::createRobotsTXT();
  $this->Redirect($this->id, 'defaultadmin', '', Array('message'=>'sitemap_regenerated','tab'=>'sitemapsettings'));
    }
if (isset($_POST['dont_delete_robots'])){

  $this->audit("Test","SEO Tools","Manually regenerated sitemap.xml only");
  $this->Redirect($this->id, 'defaultadmin', '', Array('message'=>'sitemap_only_regenerated','tab'=>'sitemapsettings'));
}

// OK, show me what's there in the robots.txt file in the root directory
$handle = fopen($filename, "rb");
$contents = fread($handle, filesize($filename));
fclose($handle);

$robots  = $this->CreateFormStart(null, 'robots');
$robots .= '<p class="pagetext">'.$this->Lang('robots_old_file').':</p>';
$robots .= '<p class="pageinput">'.nl2br($contents).'</p>';

$robots .= '<p class="pagetext">'.$this->Lang('robots_sure_delete').':</p>';
$robots .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'do_delete_robots', $this->lang('confirm')).'&nbsp;&nbsp;&nbsp;'.$this->CreateInputSubmit(null, 'dont_delete_robots', $this->lang('cancel')).'</p>';


$robots .= $this->CreateFormEnd();

$robots .= '<br /><br />';
echo $robots;

?>