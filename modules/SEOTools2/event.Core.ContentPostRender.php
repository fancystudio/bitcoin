<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Event: CoreContentPostRender
# Function: Ensures the meta description is correct and that there is a base tag
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

$smarty = cmsms()->GetSmarty();
$tpl_vars = $smarty->get_template_vars();
$html_version = $mod->GetPreference('meta_doctype');
$close_tag = $html_version < 3 ? " />\n" : ">\n";
$content = $params['content'];
$detail_keywords = '';

// Change the page meta description to a module detail page meta description eg News, CGBlog, Products, etc
if ($seo2blockname = $mod->GetPreference('description_block')) {
  $seo2blockcontent = $tpl_vars['content_obj']->GetPropertyValue ($seo2blockname);
  if ($tpl_vars['metadescription'] != $seo2blockcontent) {
    $newtag = "<meta name='description' content='".$tpl_vars['metadescription']."'" .$close_tag;
    $start = strpos($content,"<meta name='description'");
    $endoftag = strpos($content,">",$start);
    $length = $endoftag - $start + 1;
    $content = substr_replace($content,$newtag,$start,$length);
  }
}


// Change the page meta keywords to a module detail page meta keywords eg News, CGBlog, Products, etc
// First off, limit the area we're working in to <head> tag just in case the content contains strings we don't want replaced

$headstart = strpos($content,'<head>');
$headend   = strpos($content,'</head>');
$headlength = $headend - $headstart;
$headcontent = substr($content,$headstart,$headlength);

// Check to see if we have detail page keywords
  if (!empty($tpl_vars[$mod->GetPreference('detail_keywords_var')])){
    $detail_keywords = $tpl_vars[$mod->GetPreference('detail_keywords_var')];
    //{$seo_keywords}
    $headcontent = str_replace($tpl_vars['page_keywords'],$detail_keywords, $headcontent);
    
    //{$title_keywords}
    $page_title_kw = str_replace(',', ' ', $tpl_vars['page_keywords']);
    $detail_title_kw = str_replace(',', ' ', $detail_keywords);
    $headcontent = str_replace($page_title_kw,$detail_title_kw, $headcontent);
    
    // Now replace the old <head> with the new one
    $content = substr_replace($content,$headcontent,$headstart,$headlength);
  }



// Check to see if there is a <base href...> tag
$first = strpos($content,"<base href");
if ($first === false ) {
  $config = cmsms()->GetConfig();
  $root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];
  $basetag = '<base href="'.$root_url . '" ' . $close_tag;
  $content = str_replace('<title>',$basetag . '<title>',$content);

} else {
  // Make sure there is only one (not from both {metadata} and {SEOTools2})
  $last = strrpos($content,"<base href");

  if ($first !== $last) {
    // remove the duplicate tag
    $endlast = strpos($content,'>',$last);
    $length = $endlast - $last + 1;
    $content = substr_replace($content,'',$last,$length);

  }
}
$params['content'] = $content;
?>