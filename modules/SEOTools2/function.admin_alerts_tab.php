<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Tab: Alerts
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

$alerts  = $this->CreateFieldsetStart(null, 'alerts_urgent', $this->Lang('title_alerts_urgent'));

  $urgent_alerts = seo2_utils::getUrgentAlerts();

  if (count($urgent_alerts) == 0) {
    $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/true.gif" align="absmiddle" /> '.$this->lang('nothing_to_be_fixed').'<br /><br />';
  }else{
    $groups = Array();
    foreach ($urgent_alerts as $alert) {
      $groups[$alert['group']][] = $alert;
    }
    foreach($groups as $group => $galerts) {
      $count = count($galerts);
      if (count($galerts) > 20) {
        $parts = array_chunk($galerts, 20);
        $galerts = $parts[0];
        $count = "> 20";
      }
      if (count($galerts) == 1) {
        $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/Notifications/1.gif" align="absmiddle" /> <b>'.$galerts[0]['message'].'</b> ['.implode(' | ',$galerts[0]['links']).']<br /><br />';
      }else{
        $group_title = $this->lang('grouptitle_'.$group, Array($count));
        $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/Notifications/1.gif" align="absmiddle" /> <b>'.$group_title.'</b> [<a href="javascript:void(null)" onClick="document.getElementById(\'urgent_group_'.$group.'\').style.display = \'block\'">'.$this->lang('view_all').'</a>]<br /><br />';
        $alerts .= '<div id="urgent_group_'.$group.'" style="padding-left: 30px; display: none;">';
        foreach ($galerts as $alert) {
          $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/Notifications/1.gif" align="absmiddle" /> <b>'.$alert['message'].'</b> ['.implode(' | ',$alert['links']).']<br /><br />';
        }
        $alerts .= '</div>';
      }
    }
  }

  $alerts .= $this->CreateFieldsetEnd();

  $alerts .= $this->CreateFieldsetStart(null, 'alerts_important', $this->Lang('title_alerts_important'));


  $important_alerts = seo2_utils::getImportantAlerts();
  if (count($important_alerts) == 0) {
    $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/true.gif" align="absmiddle" /> '.$this->lang('nothing_to_be_fixed').'<br /><br />';
  }else{
    $groups = Array();
    foreach ($important_alerts as $alert) {
      $groups[$alert['group']][] = $alert;
    }
    foreach($groups as $group => $galerts) {
      $count = count($galerts);
      if (count($galerts) > 20) {
        $parts = array_chunk($galerts, 20);
        $galerts = $parts[0];
        $count = "> 20";
      }
      if (count($galerts) == 1) {
        $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/Notifications/2.gif" align="absmiddle" /> <b>'.$galerts[0]['message'].'</b> ['.implode(' | ',$galerts[0]['links']).']<br /><br />';
      }else{
        $group_title = $this->lang('grouptitle_'.$group, Array($count));
        $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/Notifications/2.gif" align="absmiddle" /> <b>'.$group_title.'</b> [<a href="javascript:void(null)" onClick="document.getElementById(\'important_group_'.$group.'\').style.display = \'block\'">'.$this->lang('view_all').'</a>]<br /><br />';
        $alerts .= '<div id="important_group_'.$group.'" style="padding-left: 30px; display: none;">';
        foreach ($galerts as $alert) {
          $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/Notifications/2.gif" align="absmiddle" /> <b>'.$alert['message'].'</b> ['.implode(' | ',$alert['links']).']<br /><br />';
        }
        $alerts .= '</div>';
      }
    }
  }

  $alerts .= $this->CreateFieldsetEnd();

  $alerts .= $this->CreateFieldsetStart(null, 'alerts_notices', $this->Lang('title_alerts_notices'));

  $notice_alerts = seo2_utils::getNoticeAlerts();
  if (count($notice_alerts) == 0) {
    $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/true.gif" align="absmiddle" /> '.$this->lang('nothing_to_be_fixed').'<br /><br />';
  }else{
    foreach ($notice_alerts as $alert) {
      $alerts .= '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/Notifications/3.gif" align="absmiddle" /> <b>'.$alert['message'].'</b> ['.implode(' | ',$alert['links']).']<br /><br />';
    }
  }

  $alerts .= $this->CreateFieldsetEnd();
  echo $alerts;
?>