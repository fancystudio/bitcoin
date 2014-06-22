<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Tab: Keyword Settings
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

  $ksettings  = $this->CreateFormStart(null, 'changesettings');

  $ksettings .= $this->CreateFieldsetStart(null, 'keyword_weight_description', $this->Lang('title_keyword_weight'));
  $ksettings .= '<p class="pagetext">'.$this->lang('keyword_minlength_title').':</p>';
  $ksettings .= '<p class="pageinput">'.$this->CreateInputText(null, 'keyword_minlength', $this->GetPreference('keyword_minlength','6'), 2).' '.$this->lang('keyword_minlength_help').'</p>';
  $ksettings .= '<p class="pagetext">'.$this->lang('keyword_title_weight_title').':</p>';
  $ksettings .= '<p class="pageinput">'.$this->CreateInputText(null, 'keyword_title_weight', $this->GetPreference('keyword_title_weight','6'), 2).' '.$this->lang('keyword_title_weight_help').'</p>';
  $ksettings .= '<p class="pagetext">'.$this->lang('keyword_description_weight_title').':</p>';
  $ksettings .= '<p class="pageinput">'.$this->CreateInputText(null, 'keyword_description_weight', $this->GetPreference('keyword_description_weight','4'), 2).' '.$this->lang('keyword_description_weight_help').'</p>';
  $ksettings .= '<p class="pagetext">'.$this->lang('keyword_headline_weight_title').':</p>';
  $ksettings .= '<p class="pageinput">'.$this->CreateInputText(null, 'keyword_headline_weight', $this->GetPreference('keyword_headline_weight','2'), 2).' '.$this->lang('keyword_headline_weight_help').'</p>';
  $ksettings .= '<p class="pagetext">'.$this->lang('keyword_content_weight_title').':</p>';
  $ksettings .= '<p class="pageinput">'.$this->CreateInputText(null, 'keyword_content_weight', $this->GetPreference('keyword_content_weight','1'), 2).' '.$this->lang('keyword_content_weight_help').'</p>';
  $ksettings .= '<p class="pagetext">'.$this->lang('keyword_minimum_weight_title').':</p>';
  $ksettings .= '<p class="pageinput">'.$this->CreateInputText(null, 'keyword_minimum_weight', $this->GetPreference('keyword_minimum_weight','7'), 2).' '.$this->lang('keyword_minimum_weight_help').'</p>';
  $ksettings .= $this->CreateFieldsetEnd();

  $ksettings .= $this->CreateFieldsetStart(null, 'keyword_exclude_description', $this->Lang('title_keyword_exclude'));
  $ksettings .= '<p class="pagetext">'.$this->lang('keyword_exclude_title').':</p>';
  $ksettings .= '<p class="pageinput">'.$this->CreateTextArea(false, null, $this->GetPreference('keyword_exclude',''), 'keyword_exclude').' '.$this->lang('keyword_exclude_help').'</p>';
  $ksettings .= $this->CreateFieldsetEnd();

  $ksettings .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'save_keyword_settings', $this->lang('save')).'</p>';
  $ksettings .= $this->CreateFormEnd();

  $ksettings .= '<br /><br />'.$this->lang('help_keyword_generator');
	echo $ksettings;
?>