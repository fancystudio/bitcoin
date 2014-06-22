<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Tab: Sitemap Settings
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
if( !isset($gCms) ) exit;

// General Sitemap and Robots stuff
  $ssettings  = $this->CreateFormStart(null, 'changesettings');
  $ssettings .= $this->CreateFieldsetStart(null, 'sitemap_description', $this->Lang('title_sitemap_description'));
  $ssettings .= '<p class="pagetext">' . $this->Lang('create_sitemap_title') . ': ' . $this->CreateInputCheckbox(null, 'create_sitemap', 1, $this->GetPreference('create_sitemap',1)) . '</p>';
  if (ini_get('allow_url_fopen')) {
    $ssettings .= '<p class="pagetext">' . $this->Lang('push_sitemap_title') . ': ' . $this->CreateInputCheckbox(null, 'push_sitemap', 1, $this->GetPreference('push_sitemap',0)) . '</p>';
  }else{
    $ssettings .= '<p class="pagetext">' . $this->Lang('push_sitemap_title') . ': ' . $this->Lang('no_url_fopen') . '</p>';
  }
  $ssettings .= '<p class="pagetext">' . $this->Lang('create_robots_title') . ': ' . $this->CreateInputCheckbox(null, 'create_robots', 1, $this->GetPreference('create_robots',1)) . '</p>';
  $ssettings .= '<p class="pagetext">'.$this->lang('verification_title').':</p>';
  $ssettings .= '<p class="pageinput">'.$this->CreateInputText(null, 'verification', $this->GetPreference('verification',''), 32).' '.$this->lang('verification_help').'</p>';
  $ssettings .= '<p class="pageinput">'.$this->lang('help_sitemap_robots').'</p>';
  $ssettings .= $this->CreateFieldsetEnd();
  $ssettings .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'save_sitemap_settings', $this->lang('save')).'</p>';
  
  $ssettings .= $this->CreateFormEnd();
  

  // Custom robots stuff
  $ssettings .= $this->CreateFormStart(null, 'changesettings');
  $ssettings .= $this->CreateFieldsetStart(null, 'custom_robots_description', $this->Lang('title_custom_robots_description'));
  $ssettings .= '<p class="pagetext">'.$this->lang('robots_before').'</p>';
  $ssettings .= '<p class="pageinput">'.$this->CreateTextArea(false, null, $this->GetPreference('r_before'), 'robots_before').' </p>';
  $ssettings .= '<p class="pagetext">'.$this->lang('robots_after').'</p>';
  $ssettings .= '<p class="pageinput">'.$this->CreateTextArea(false, null, $this->GetPreference('r_after'), 'robots_after').' </p>';
  $ssettings .= $this->CreateFieldsetEnd();
  $ssettings .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'save_custom_robots_settings', $this->lang('save')).'</p>';
  $ssettings .= $this->CreateFormEnd();
  
  
  // Regenerate sitemap.xml and robots.txt
  $ssettings .= $this->CreateFormStart(null, 'changesettings');
  $ssettings .= $this->CreateFieldsetStart(null, 'regenerate_sitemap', $this->Lang('title_regenerate_sitemap'));
  $ssettings .= '<p class="pagetext"></p>';
  $ssettings .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'do_regenerate', $this->lang('button_regenerate_sitemap')).'</p>';
  $ssettings .= '<p class="pageinput">'.$this->lang('text_regenerate_sitemap').'</p>';
  $ssettings .= $this->CreateFieldsetEnd();
  $ssettings .= $this->CreateFormEnd();

  echo $ssettings;
  
  
?>