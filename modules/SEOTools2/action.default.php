<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Action: default
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


// Get page data
$smarty = cmsms()->GetSmarty();
$db =& cmsms()->GetDb();
$config = cmsms()->GetConfig();
$html = "";
$html_version = $this->GetPreference('meta_doctype');
$close_tag = $html_version < 3 ? " />\n" : ">\n";

$root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];

$tpl_vars = $smarty->get_template_vars();
if (!$curcontent = $tpl_vars['content_obj'])
  return;  // No page

$page_url = !empty($tpl_vars['canonical']) ? $tpl_vars['canonical'] : $curcontent->GetURL();
$page_id = $curcontent->Id();


$modified_date = $curcontent->getModifiedDate();
$modified_date = date('Y-m-d\TH:i:sP',$modified_date);

// Keyword generator
$default_keywords = $this->GetPreference('default_keywords','');
$keywords = !empty($default_keywords) ? array_map('trim',explode(',',$default_keywords)) : array();

$query = 'SELECT * FROM '.cms_db_prefix().'module_seotools2 WHERE content_id = ?';
if (!$result = $db->Execute($query,array($page_id))) {
  $html .=  "Problem with the database! Please contact your administrator.";
  die;
}

$page_info = $result->FetchRow();

if ($page_info['keywords'] != "") {
  $other_keywords = array_map('trim',explode(',',$page_info['keywords']));
}else{
  $other_keywords = seo2_utils::getKeywordSuggestions($page_id);
}

if (!empty($tpl_vars[$this->GetPreference('detail_keywords_var')])) {
  $other_keywords = explode(',',$tpl_vars[$this->GetPreference('detail_keywords_var')]);
}

$seo_keywords = implode(", ",array_unique(array_merge($keywords, $other_keywords)));

$smarty->assign('seo_keywords', $seo_keywords);
$title_keywords = implode(",",array_unique(array_merge($keywords, $other_keywords)));




$smarty->assign('title_keywords', str_replace(',',' ',htmlspecialchars($title_keywords, ENT_QUOTES)));
$smarty->assign('default_keywords', htmlspecialchars(implode(', ', $keywords), ENT_QUOTES));
$smarty->assign('page_keywords',    htmlspecialchars(implode(', ', $other_keywords), ENT_QUOTES));



// Page description
$description_id = str_replace(' ','_',$this->GetPreference('description_block',''));
if ($curcontent !== false) {
  $description = strip_tags($smarty->fetch('string:'.$curcontent->GetPropertyValue($description_id)));
}

if (($description == "") && ($this->GetPreference('description_auto_generate',1) == 1) && $curcontent !== NULL) {
  $kw = $other_keywords;
  $last_keyword = array_pop($kw);
  $keywords = implode(', ',$kw) . " " . $this->lang('and') . " " . $last_keyword;
  
  $description = str_replace('{keywords}',$keywords,$this->GetPreference('description_auto',''));
  $description = str_replace('{title}',$curcontent->Name(),$description);
  $description = $smarty->fetch('string:'.htmlspecialchars($description, ENT_QUOTES));

}
// META tag for content type
if ($html_version < 3) {
  $html .=  "<meta http-equiv='Content-Type' content='text/html; charset=".$config['default_encoding']."'" .$close_tag;
} else {
  $html .= '<meta charset="'.strtoupper($config['default_encoding']).'"'. $close_tag;
}

// Show base?
if (isset($params['showbase']) && $params['showbase'] != false) {
  $html .=  "<base href='".$root_url."/'" . $close_tag;
}


// Page title
if ($curcontent !== NULL){
  $title = $this->GetPreference('title','{title} | {sitename} - {seo_keywords}');
  $title = $smarty->fetch('string:'.$title);

  $meta_title = $this->GetPreference('title_meta','{title} | {sitename}');
  $meta_title = str_replace('{title}',$curcontent->Name(),$meta_title);
  $meta_title = str_replace('{sitename}',$tpl_vars['sitename'],$meta_title);
  $meta_title = str_replace('{seo_keywords}',$title_keywords,$meta_title);
  $meta_title = $smarty->fetch('string:'.$meta_title);

  $opengraph_title = $this->GetPreference('meta_opengraph_title','{title}');
  $opengraph_title = str_replace('{title}',$curcontent->Name(),$opengraph_title);
  $opengraph_title = $smarty->fetch('string:'.$opengraph_title);

  $html .=  "<title>".$title."</title>\n";
}

// Image-Link
$img = $curcontent->GetPropertyValue('image');
if (($img != -1) && ($img != ""))  {
  $html .=  "<link rel='image_src' href='".$config['image_uploads_url']. DIRECTORY_SEPARATOR.$img."'" . $close_tag;
}


// Standard META tags
if ($this->GetPreference('meta_standard',1) == 1) {
  $html .=  "<meta name='description' content='$description'" . $close_tag;
  
  $html .=  "<meta name='keywords' content='$seo_keywords'" . $close_tag;
  

  if ($html_version < 3){
    $html .=  "<meta name='title' content='". htmlspecialchars($meta_title,ENT_QUOTES)."'" . $close_tag;
    $html .=  "<meta name='date' content='". htmlspecialchars($modified_date,ENT_QUOTES)."'" . $close_tag;
    $html .=  "<meta name='lastupdate' content='$modified_date'" . $close_tag;
    $html .=  "<meta name='revised' content='$modified_date'" . $close_tag;
  }


// Start of META robots tag for INDEX/NOINDEX
if (($page_info['indexable'] == 1 || $page_info['indexable'] == null) && $page_info['indexable'] !==0) {
  $html .=  "<meta name='robots' content='index";
}else{
  $html .=  "<meta name='robots' content='noindex";
}

// End of META robots tag for FOLLOW/NOFOLLOW
if ($page_info['follow'] == 1 )  {
  $html .=  ", nofollow'" . $close_tag;
}else{
  $html .=  ", follow'" . $close_tag;
}


if ($this->GetPreference('verification','') != '') {
  $html .=  "<meta name='google-site-verification' content='".$this->GetPreference('verification','')."'" . $close_tag;
}
  
  
  
  if ($this->GetPreference('meta_publisher','') != ""){
$html .= "<meta name='author' content='".$smarty->fetch('string:'. htmlspecialchars($this->GetPreference('meta_publisher'), ENT_QUOTES))."'" . $close_tag;
  } else {
	$html .= "<meta name='author' content='". htmlspecialchars(cms_siteprefs::get('sitename'), ENT_QUOTES)."'". $close_tag;
  }
	
  if ($this->GetPreference('meta_location','') != "") {
    $html .=  "<meta name='geo.placename' content='". htmlspecialchars($this->GetPreference('meta_location',''), ENT_QUOTES)."'" . $close_tag;
  }
  if ($this->GetPreference('meta_region','') != "") {
    $html .=  "<meta name='geo.region' content='".$this->GetPreference('meta_region','')."'" . $close_tag;
  }
  if (($this->GetPreference('meta_latitude','') != "") && ($this->GetPreference('meta_longitude','') != "")) {
    $html .=  "<meta name='geo.position' content='". htmlspecialchars($this->GetPreference('meta_latitude',''), ENT_QUOTES).";".$this->GetPreference('meta_longitude','')."'" . $close_tag;
    $html .=  "<meta name='ICBM' content='".$this->GetPreference('meta_latitude','').", ".$this->GetPreference('meta_longitude','')."'" . $close_tag;
  }
  
}

if ($this->GetPreference('additional_meta_tags','') != '') {
	$html .= $smarty->fetch('string:'.$this->GetPreference('additional_meta_tags'));
}

// DublinCore META tags
if ($this->GetPreference('meta_dublincore',0) == 1) {
  $html .=  "<link rel='schema.DC' href='http://purl.org/dc/elements/1.1/'" . $close_tag;
  $html .=  "<link rel='schema.DCTERMS' href='http://purl.org/dc/terms/'" . $close_tag;
  $html .=  "<meta name='DC.type' content='Text' scheme='DCTERMS.DCMIType'" . $close_tag;
  $html .=  "<meta name='DC.format' content='text/html' scheme='DCTERMS.IMT'" . $close_tag;
  $html .=  "<meta name='DC.relation' content='http://dublincore.org/' scheme='DCTERMS.URI'" . $close_tag;
  if ($this->GetPreference('meta_publisher','') != "")
	$html .=  "<meta name='DC.publisher' content='". htmlspecialchars($this->GetPreference('meta_publisher',''), ENT_QUOTES)."'" . $close_tag;
  else
	$html .= "<meta name='DC.publisher' content='". htmlspecialchars(cms_siteprefs::get('sitename'), ENT_QUOTES)."'" . $close_tag;
  if ($this->GetPreference('meta_contributor','') != "")
	$html .=  "<meta name='DC.contributor' content='". htmlspecialchars($this->GetPreference('meta_contributor',''), ENT_QUOTES)."'" . $close_tag;

  if($felang = cms_siteprefs::get('frontendlang'))
    $html .=  "<meta name='DC.language' content='".$felang."' scheme='DCTERMS.RFC3066' />\n";

  if ($this->GetPreference('meta_copyright','') != "")
    $html .=  "<meta name='DC.rights' content='".$smarty->fetch('string:'. htmlspecialchars($this->GetPreference('meta_copyright'), ENT_QUOTES))."'" . $close_tag;

  $html .=  "<meta name='DC.title' content='$meta_title'" . $close_tag;
  $html .=  "<meta name='DC.description' content='$description'" . $close_tag;
  $html .=  "<meta name='DC.date' content='$modified_date' scheme='DCTERMS.W3CDTF'" . $close_tag;
  $html .=  "<meta name='DC.identifier' content='$page_url' scheme='DCTERMS.URI'" . $close_tag;
}

// OpenGraph META tags
if ($this->GetPreference('meta_opengraph',0) == 1) {
  $html .=  "<meta property='og:title' content='$opengraph_title' />\n";
  if ($page_info['ogtype'] == "") {
    $html .=  "<meta property='og:type' content='".$this->GetPreference('meta_opengraph_type','')."' " . $close_tag;
  }else{
    $html .=  "<meta property='og:type' content='".$page_info['ogtype']."'" . $close_tag;
  }
  $html .=  "<meta property='og:url' content='$page_url'" . $close_tag;

  if($curcontent != NULL) {
    $img = $curcontent->GetPropertyValue('image');;
    if (($img != -1) && ($img != ""))  {
      $image = $img;
       
    }else{
      $image = $this->GetPreference('meta_opengraph_image','');
    }
  }
  $html .=  "<meta property='og:image' content='".$config['image_uploads_url']."/".$image."'" . $close_tag;
  $html .=  "<meta property='og:site_name' content='". htmlspecialchars($this->GetPreference('meta_opengraph_sitename',cms_siteprefs::get('sitename'), ENT_QUOTES))."'" . $close_tag;
  $html .=  "<meta property='og:description' content='$description' />\n";
  if ($this->GetPreference('meta_opengraph_application','') != "") {
    $html .=  "<meta property='fb:app_id' content='". htmlspecialchars($this->GetPreference('meta_opengraph_application',''), ENT_QUOTES)."'" . $close_tag;
  }else{
    $html .=  "<meta property='fb:admins' content='". htmlspecialchars($this->GetPreference('meta_opengraph_admins',''), ENT_QUOTES)."'" . $close_tag;
  }
  if ($this->GetPreference('meta_location','') != "") {
    $html .=  "<meta property='og:locality' content='". htmlspecialchars($this->GetPreference('meta_location',''), ENT_QUOTES)."'" . $close_tag;
  }
  if ($this->GetPreference('meta_region','') != "") {
    $html .=  "<meta property='og:region' content='". htmlspecialchars($this->GetPreference('meta_region',''), ENT_QUOTES)."'" . $close_tag;
  }
  if (($this->GetPreference('meta_latitude','') != "") && ($this->GetPreference('meta_longitude','') != "")) {
    $html .=  "<meta property='og:latitude' content='".$this->GetPreference('meta_latitude','')."'" . $close_tag;
    $html .=  "<meta property='og:longitude' content='".$this->GetPreference('meta_longitude','')."'" . $close_tag;
  }
}
$smarty->display('string:'.$html);
?>