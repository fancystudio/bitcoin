<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Action: defaultadmin
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

if (! $this->CheckAccess())
{
  return $this->DisplayErrorPage($id, $params, $returnid,$this->Lang('accessdenied'));
}

$db = cmsms()->GetDb();
$config = cmsms()->GetConfig();
$admin_dir = $config['admin_dir'];
$themeName = cms_userprefs::get('admintheme');
$root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];
$content_id = isset($_GET['content_id']) ? $_GET['content_id'] : '';
$tab = isset($_GET['tab']) ? $_GET['tab'] : '';
$j = 0;
if (isset($_GET['tab']))
  $this->SetCurrentTab($_GET['tab']);


$message = '';

// Do the action
// Update the indexable db field
// Do the action
if (isset($_GET['what']) && $_GET['what'] == 'toggle_index') {
  $query = 'SELECT * FROM '.cms_db_prefix().'module_seotools2 WHERE content_id = '.$_GET['content_id'];
  $result =& $db->Execute($query);
  $info = $result->fetchRow();
  if (!empty($info) && $info['indexable'] == "1") {
    $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET indexable = 0 WHERE content_id = '.$_GET['content_id'];
  }else{
    $query = 'INSERT INTO '.cms_db_prefix().'module_seotools2 SET content_id = '.$_GET['content_id'].', indexable = 0 ON DUPLICATE KEY UPDATE indexable = 1';
  }
  $db->Execute($query);


  if ($this->GetPreference('create_robots',1) == 1) {
    seo2_utils::createRobotsTXT();
  }
  if ($this->GetPreference('create_sitemap',1) == 1) {
    seo2_utils::createSitemap($this->GetPreference('push_sitemap',1) == 1);
  }
  $_GET['tab'] = 'pagedescriptions';
}

// Update the follow db field
if (isset($_GET['what']) && $_GET['what'] == 'toggle_follow') {
  $query = 'SELECT * FROM '.cms_db_prefix().'module_seotools2 WHERE content_id = '.$content_id;
  $result =& $db->Execute($query);
  $info = $result->fetchRow();
  if (!empty($info) && $info['follow'] == "1") {
    $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET follow = 0 WHERE content_id = '.$content_id;
  }else{
    $query = 'INSERT INTO '.cms_db_prefix().'module_seotools2 SET content_id = '.$content_id.', follow = 0 ON DUPLICATE KEY UPDATE follow = 1';
  }
  $db->Execute($query);

}
  if (isset($_GET['what']) && $_GET['what'] == 'set_priority') {
    $query = 'INSERT INTO '.cms_db_prefix().'module_seotools2 SET content_id = '.$content_id.', priority = '.$_GET['priority'].' ON DUPLICATE KEY UPDATE priority = '.$_GET['priority'];
    $db->Execute($query);
    $tab = 'pagedescriptions';
    if ($this->GetPreference('create_sitemap',1) == 1) {
      seo2_utils::createSitemap($this->GetPreference('push_sitemap',1) == 1);
    }
  }

  if (isset($_GET['what']) && $_GET['what'] == 'reset_priority') {
    $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET priority = NULL WHERE content_id = '.$content_id;
    $db->Execute($query);
    $tab = 'pagedescriptions';
    if ($this->GetPreference('create_sitemap',1) == 1) {
      seo2_utils::createSitemap($this->GetPreference('push_sitemap',1) == 1);
    }
  }

  if (isset($_GET['what']) && $_GET['what'] == 'reset_ogtype') {
    $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET ogtype = NULL WHERE content_id = '.$content_id;
    $db->Execute($query);
    $tab = 'pagedescriptions';
  }

  if (isset($_GET['what']) && $_GET['what'] == 'reset_keywords') {
    $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET keywords = NULL WHERE content_id = '.$content_id;
    $db->Execute($query);
    $tab = 'pagedescriptions';
  }

  if (isset($_GET['what']) && $_GET['what'] == 'edit_ogtype') {
    echo $this->Redirect(null, 'edit_ogtype', $this->returnid, Array('content_id'=>$content_id));
  }

  if (isset($_GET['what']) && $_GET['what'] == 'edit_keywords') {
    echo $this->Redirect(null, 'edit_keywords', $this->returnid, Array('content_id'=>$content_id));
  }

/* Start the Admin output */
  
  
  echo $this->StartTabHeaders();
  echo $this->SetTabHeader('seoalerts',$this->Lang('title_seoalerts'));
  echo $this->SetTabHeader('pagedescriptions',$this->Lang('title_pagedescriptions'));
  echo $this->SetTabHeader('metasettings',$this->Lang('title_metasettings'));
  echo $this->SetTabHeader('sitemapsettings',$this->Lang('title_sitemapsettings'));
  echo $this->SetTabHeader('keywordsettings',$this->Lang('title_keywordsettings'));
  echo $this->EndTabHeaders();
  
  echo $this->StartTabContent();

  if (isset($_GET['message'])) {
    $this->smarty->assign('message',$this->showMessage($this->lang($_GET['message'])));
  } else {
    $this->smarty->assign('message','');
  }

  /* SEO Alerts Tab */
    echo $this->StartTab('seoalerts');
    include(dirname(__FILE__).'/function.admin_alerts_tab.php');
    echo $this->EndTab();


  /* Page settings Tab */
    echo $this->StartTab('pagedescriptions');
    include(dirname(__FILE__).'/function.admin_pagesettings_tab.php');
    echo $this->EndTab();


  /* SEO Settings Tab */
    echo $this->StartTab('metasettings');
    include(dirname(__FILE__).'/function.admin_seosettings_tab.php');
    echo $this->EndTab();

  /* SITEMAP Settings */
    echo $this->StartTab('sitemapsettings');
    include(dirname(__FILE__).'/function.admin_sitemapsettings_tab.php');
    echo $this->EndTab();


  /* KEYWORD Settings */
    echo $this->StartTab('keywordsettings');
    include(dirname(__FILE__).'/function.admin_keywordsettings_tab.php');
    echo $this->EndTab();
	
echo $this->EndTabContent();

$jq = '';
$jq .= '<script type="text/javascript" charset="utf-8">
/* <![CDATA[ */
(function ($) {
$.fn.hasB = function() {
		var hasB = $(this).parent().find("b").find(".priority:first").size();
		return hasB;
	}
	
	$.fn.autodepth = function() {
		$(this).parentsUntil("tbody").parent().find("tr").next().first().addClass("h");
		var pg = $(this).parentsUntil("tr").parent().find("td.pg:first").html();
		var a = $.map(pg, function(x) { return pg.charCodeAt(x) });
		var depth = $.grep( a, function(n,i){ return n == 187;});
		
		switch(depth.length) {
			case 0:
			  var autodepth = ($(this).parentsUntil("tr").parent().hasClass("h")) ? 100 : 80;
			  break;
			case 1:
			  var autodepth = 40;
			  break;
			default:
			  var autodepth = 20;
		}
		return autodepth;
	}
})(jQuery);

$(document).ready(function(){
	var spinner = "<img src=\"'.$root_url.'/modules/SEOTools2/img/ajax-loader.gif\" alt=\"Ajax loading...\" width=\"16\" height=\"16\" class=\"spinner\" />";
	
	$(".seo2ajax a").click(function(e){
		e.preventDefault();
		var img = $(this).find("img");
		var imgsrc = img.attr("src");
		var imgsrc = (imgsrc.indexOf("true") !== -1) ? imgsrc.replace("true","false") : imgsrc.replace("false","true");
		$(img).attr("src",imgsrc);
		var x = $(this).attr("href");
		$(this).append(spinner);
		$.get(x, function(data){
			$(".spinner:first").remove();
		});
	});
	$(".updown").click(function(e){
		e.preventDefault();
		$(this).append(spinner);
		var autodepth = $(this).autodepth();
		var priority  = ($(this).hasB() > 0) ? $(this).parent().find("b").find(".priority:first") : $(this).parent().find(".priority:first");
		var msgSpan   = $(this).parent().find(".pmsg:first");
		var id        = $(this).parentsUntil("tr").parent().find("td").first().text();
		
		var amt = ($(this).hasClass("up")) ? 10 : -10;
		var newval = Number(priority.text())+amt;
		if (newval != autodepth) {
			var pmsg = "<b class=\"reset100\">";
			pmsg	+= "<span class=\"priority\">";
			pmsg	+= newval;
			pmsg	+= "</span>%";
			pmsg	+= "<a href=\"'.$root_url.'/'.$config['admin_dir'].'/moduleinterface.php?mact=SEOTools2,,defaultadmin,0&amp;'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&amp;what=reset_priority&amp;content_id=";
			pmsg	+= id;
			pmsg	+= "&amp;tab=pagedescriptions";
			pmsg	+= "\" class=\"admin-tooltip\">";
			pmsg	+= "<img align=\"absmiddle\" src=\"'.$root_url.'/modules/SEOTools2/img/reset.png\" />";
			pmsg	+= "<span>";
			pmsg	+= "'.$this->Lang('reset_to_default') .'";
			pmsg	+= "</span>";
			pmsg	+= "</a></b>";
		} else {
			var pmsg = "(auto) <span class=\"priority\">" + $(this).autodepth() + "</span>% ";
		}
		
		var x = $(this).attr("href");
		$.get(x, function(data){
			$(priority).text(newval);
				$(msgSpan).addClass("pmsg").html(pmsg);
//				$(msgSpan).html(pmsg);
			$(".spinner:first").remove();
		});
	});
	
	
	$("span.pmsg a").click(function(e){
		e.preventDefault();
		$(this).append(spinner);
		var td = $(this).parentsUntil("td").parent();
		var msgSpan = $(td).find("span.pmsg");
	
		
		var pmsg = "(auto) <span class=\"priority\">" + $(this).autodepth() + "</span>% ";
		var x = $(this).attr("href");
		$.get(x, function(data){
			$(td).find(".spinner").remove();
			$(msgSpan).html(pmsg);

		});
		
	});
});
/* ]]> */
</script>';
echo $jq;
  ?>