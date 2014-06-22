<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Tab: SEO Settings
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

  // Get image files from /uploads/images
  $files_list = Array($this->lang('none')=>"");
  
  
  $dp = opendir($config['root_path'].'/uploads/images');
  while ($file = readdir($dp)) {
    if (strpos(substr($file, -5),'.gif') !== false) {
      $files_list[$file] = $file;
    }
    if (strpos(substr($file, -5),'.png') !== false) {
      $files_list[$file] = $file;
    }
    if (strpos(substr($file, -5),'.jpg') !== false) {
      $files_list[$file] = $file;
    }
    if (strpos(substr($file, -5),'.jpeg') !== false) {
      $files_list[$file] = $file;
    }
  }
  closedir($dp);

  $settings  = $this->CreateFormStart(null, 'changesettings');

  /* Page Title */
  $settings .= $this->CreateFieldsetStart(null, 'title_description', $this->Lang('title_title_description'));
  $settings .= '<p class="pagetext">'.$this->lang('title_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'title', $this->GetPreference('title','{title} | {$sitename} - {$title_keywords}'), 32).' '.$this->lang('title_title_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('title_meta_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'title_meta', $this->GetPreference('title_meta','{title} | {$sitename}'), 32).' '.$this->lang('title_meta_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('description_block_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'description_block', $this->GetPreference('description_block',''), 32).' '.$this->lang('description_block_help').'</p>';
  $settings .= '<p class="pagetext">' . $this->Lang('description_auto_generate') . ': ' . $this->CreateInputCheckbox(null, 'description_auto_generate', 1, $this->GetPreference('description_auto_generate',1)) . '</p>';


  $settings .= '<p class="pagetext">'.$this->lang('description_auto_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'description_auto', $this->GetPreference('description_auto','This page covers the topics {keywords}'), 32).' '.$this->lang('description_auto_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('default_keywords_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'default_keywords', $this->GetPreference('default_keywords',''), 32).' '.$this->lang('default_keywords_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('detail_keywords_var_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'detail_keywords_var', $this->GetPreference('detail_keywords_var',''), 32).' '.$this->lang('detail_keywords_var_help').'</p>';
  
  /* Compile the UDTss on the Keyword Settings tab */
  $settings .= '<p class="pagetext">' . $this->Lang('compile_udts') . ':</p>';
  $settings .= '<p class="pageinput">' . $this->CreateInputCheckbox(null, 'compile_udts', 1, $this->GetPreference('compile_udts',1)).' '.$this->lang('compile_udts_help').'</p>';
  
  
  
  
  $settings .= $this->CreateFieldsetEnd();

  /* META Types */
  $settings .= $this->CreateFieldsetStart(null, 'meta_type', $this->Lang('title_meta_type'));
  
  /* Check the DOCTYPE */
  $items = array('HTML5' => 3,'XHTML' => 2,'HTML4' => 1);
  $settings .= '<p class="pagetext">'. $this->Lang('meta_doctype') . ':</p>';
  $settings .= '<p class="pageinput">'. $this->CreateInputDropdown(null, 'meta_doctype', $items, '', $this->GetPreference('meta_doctype',3), '').' '.$this->lang('meta_doctype_help').'</p><br />';
  
  $settings .= '<p class="pagetext">' . $this->Lang('meta_create_standard') . ': ' . $this->CreateInputCheckbox(null, 'meta_standard', 1, $this->GetPreference('meta_standard',1)) . '</p>';
  $settings .= '<p class="pagetext">' . $this->Lang('meta_create_dublincore') . ': ' . $this->CreateInputCheckbox(null, 'meta_dublincore', 1, $this->GetPreference('meta_dublincore',1)) . '</p>';
  $settings .= '<p class="pagetext">' . $this->Lang('meta_create_opengraph') . ': ' . $this->CreateInputCheckbox(null, 'meta_opengraph', 1, $this->GetPreference('meta_opengraph',1)) . '</p>';
  $settings .= $this->CreateFieldsetEnd();

  /* META Defaults */
  $settings .= $this->CreateFieldsetStart(null, 'meta_defaults', $this->Lang('title_meta_defaults'));
  $settings .= '<p class="pagetext">'.$this->lang('meta_publisher').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_publisher', $this->GetPreference('meta_publisher','{sitename}'), 32).' '.$this->lang('meta_publisher_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_contributor').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_contributor', $this->GetPreference('meta_contributor',''), 32).' '.$this->lang('meta_contributor_help').'</p>';

  $settings .= '<p class="pagetext">'.$this->lang('meta_copyright').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_copyright', $this->GetPreference('meta_copyright','(C) {custom_copyright} {sitename}. All rights reserved.'), 32).' '.$this->lang('meta_copyright_help').'</p><br />';

  $settings .= '<p class="pagetext">&nbsp;</p>';
  $settings .= '<p class="pageinput"><b>'.$this->lang('meta_location_description').'</b></p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_location').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_location', $this->GetPreference('meta_location',''), 32).' '.$this->lang('meta_location_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_region').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_region', $this->GetPreference('meta_region',''), 5, 5).' '.$this->lang('meta_region_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_latitude').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_latitude', $this->GetPreference('meta_latitude',''), 32).' '.$this->lang('meta_latitude_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_longitude').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_longitude', $this->GetPreference('meta_longitude',''), 32).' '.$this->lang('meta_longitude_help').'</p><br />';

  $settings .= '<p class="pagetext">&nbsp;</p>';
  $settings .= '<p class="pageinput"><b>'.$this->lang('meta_opengraph_description').'</b></p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_opengraph_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_opengraph_title', $this->GetPreference('meta_opengraph_title','{title}'), 32).' '.$this->lang('meta_opengraph_title_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_opengraph_type').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_opengraph_type', $this->GetPreference('meta_opengraph_type',''), 32).' '.$this->lang('meta_opengraph_type_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_opengraph_sitename').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_opengraph_sitename', $this->GetPreference('meta_opengraph_sitename',''), 32).' '.$this->lang('meta_opengraph_sitename_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_opengraph_image').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputDropdown(null, 'meta_opengraph_image', $files_list, null, $this->GetPreference('meta_opengraph_image','')).' '.$this->lang('meta_opengraph_image_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_opengraph_admins').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_opengraph_admins', $this->GetPreference('meta_opengraph_admins',''), 32).' '.$this->lang('meta_opengraph_admins_help').'</p>';
  $settings .= '<p class="pagetext">'.$this->lang('meta_opengraph_application').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateInputText(null, 'meta_opengraph_application', $this->GetPreference('meta_opengraph_application',''), 32).' '.$this->lang('meta_opengraph_application_help').'</p>';
  $settings .= $this->CreateFieldsetEnd();

  /* Additional Meta Tags */
  $settings .= $this->CreateFieldsetStart(null, 'additional_meta', $this->Lang('title_additional_meta_tags'));
  $settings .= '<p class="pagetext">'.$this->lang('additional_meta_tags_title').':</p>';
  $settings .= '<p class="pageinput">'.$this->CreateTextArea(false, null, $this->GetPreference('additional_meta_tags',''), 'additional_meta_tags').' '.$this->lang('additional_meta_tags_help').'</p>';
  $settings .= $this->CreateFieldsetEnd();

  $settings .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'save_meta_settings', $this->lang('save')).'</p>';
  $settings .= $this->CreateFormEnd();

  $settings .= '<br /><br />'.$this->lang('help_description_content');
  $settings .= '<br /><br />'.$this->lang('help_detail_keywords_content');
  echo $settings;
  ?>
