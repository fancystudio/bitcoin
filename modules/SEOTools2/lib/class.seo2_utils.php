<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2012 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow creating image tags in a smart
#  way to optimize performance.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
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
#END_LICENSE

class seo2_utils
{

  public function __construct()
  {
    cms_utils::get_module('SEOTools2');
  }
    
  public static function createRobotsTXT() {
    return self::_createRobotsTXT();
  }


  public static function compile_udts($data)
  {
    $mod = cms_utils::get_module('SEOTools2');
    $udts = $mod->GetPreference('compile_udts');
    $smarty = cmsms()->GetSmarty();
    $output = $data;
    $caching = '';
    if ($udts == 1) {
       
      // Load User Defined Tags
      $utops = cmsms()->GetUserTagOperations();
      $usertags = $utops->ListUserTags();
       
      foreach( $usertags as $id => $name )
      {
        $function = $utops->CreateTagFunction($name);
        $smarty->registerPlugin('function',$name,$function,$caching);
      }
       
      try {
        $output = $smarty->fetch('string:'.$data);
      } catch (Exception $e) {
        
      }

    }
    return $output;
  }
  

  public static function getUrgentAlerts() {
    return self::_getUrgentAlerts();
  }

  public static function get_headlines($file) {
    return self::_get_headlines($file);
  }
  
  public static function getKeywordSuggestions($content_id) {
    return self::_getKeywordSuggestions($content_id);
  }
  
  public static function get_keywords($source, $minlength = 6) {
    return self::_get_keywords($source, $minlength);
  }
  
  public static function getImportantAlerts() {
    return self::_getImportantAlerts();
  }
  
  public static function getNoticeAlerts(){
    return self::_getNoticeAlerts();
  }
  
  public static function createSitemap($push){
    return self::_createSitemap($push);
  }
  
  public static function GetNotificationOutput($priority = 3) {
    return self::_GetNotificationOutput($priority);
  }
  
  public static function seotools2_db_update() {
    return self::_seotools2_db_update();
  }
  
  
  /*********** PRIVATE FUNCTIONS *****************/


  
  private static function _getUrgentAlerts() {
    $mod = cms_utils::get_module('SEOTools2');
    $config = cmsms()->GetConfig();
    $db = cmsms()->GetDb();
    $root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];

    $alerts = Array();
    // Enable Pretty URLs
    if (($config['url_rewriting'] != "mod_rewrite") && ($config['url_rewriting'] != 'internal')) {
      $alert = Array();
      $alert['group'] = 'system';
      $alert['message'] = $mod->Lang('activate_pretty_urls');
      $alert['links'][] = $mod->Lang('pretty_urls_help');
      $alerts[] = $alert;
    }
    // No Meta tags are inserted
    if (($mod->GetPreference('meta_standard',0) != 1) && ($mod->GetPreference('meta_dublincore',0) != 1)) {
      $alert = Array();
      $alert['group'] = 'settings';
      $alert['message'] = $mod->Lang('use_standard_or_dublincore_meta');
      $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
      $alerts[] = $alert;
    }

    if ($mod->GetPreference('description_auto_generate',0) != 1) {
      if ($mod->GetPreference('description_block','') != '') {
        // Pages without description
        $query = 'SELECT *,c.content_id AS cid, c.type AS ctype FROM '.cms_db_prefix().'content c LEFT JOIN '.cms_db_prefix().'content_props p ON (c.content_id = p.content_id AND p.prop_name = "'.str_replace(' ','_',$mod->GetPreference('description_block','')).'") WHERE (p.content IS NULL OR p.content = "") AND c.type = "content" LIMIT 0,21';
        $result =& $db->Execute($query);
        while (is_object($result) && $problem = $result->fetchRow()) {
   		  	  if ($problem['ctype'] == 'content') {
   		  	    $alert = Array();
   		  	    $alert['group'] = 'pages';
   		  	    $alert['message'] = $mod->Lang('meta_description_missing',Array($problem['content_name']));
		  	    $alert['links'][] = '<a href="'.$root_url.'/'.$config['admin_dir'].'/editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$problem['cid'].'">'.$mod->Lang('edit_page_to_fix').'</a>';
   		  	    
   		  	    $alerts[] = $alert;
   		  	  }
        }
      }else{
        $alert = Array();
        $alert['group'] = 'settings';
        $alert['message'] = $mod->Lang('set_up_description_block');
        $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
        $alerts[] = $alert;
      }
    }elseif(strpos($mod->GetPreference('description_auto',''),'{keywords}') === false) {
      $alert = Array();
      $alert['group'] = 'settings';
      $alert['message'] = $mod->Lang('set_up_auto_description');
      $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
      $alerts[] = $alert;
    }

    // sitemap.xml not writeable
    if ($mod->GetPreference('create_sitemap',1) == 1) {
      if (!is_writeable($config['root_path'] . '/sitemap.xml')) {
        $alert = Array();
        $alert['group'] = 'system';
        $alert['message'] = $mod->Lang('sitemap_not_writeable');
        $alert['links'][] = $mod->Lang('chmod_sitemap');
        $alerts[] = $alert;
      }
    }

    // robots.txt not writeable
    if ($mod->GetPreference('create_robots',1) == 1) {
      $fp = @fopen($config['root_path'] . '/robots.txt',"a");
      @fclose($fp);
      if (!is_writeable($config['root_path'] . '/robots.txt')) {
        $alert = Array();
        $alert['group'] = 'system';
        $alert['message'] = $mod->Lang('robots_not_writeable');
        $alert['links'][] = $mod->Lang('chmod_robots');
        $alerts[] = $alert;
      }
    }

    if ($mod->GetPreference('meta_opengraph',0) == 1) {
      // No OpenGraph admin set
      if (($mod->GetPreference('meta_opengraph_admins','') == '') && ($mod->GetPreference('meta_opengraph_application','') == '')) {
        $alert = Array();
        $alert['group'] = 'opengraph';
        $alert['message'] = $mod->Lang('no_opengraph_admins');
        $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
        $alerts[] = $alert;
      }
      // No OpenGraph page type set
      if ($mod->GetPreference('meta_opengraph_type','') == '') {
        $alert = Array();
        $alert['group'] = 'opengraph';
        $alert['message'] = $mod->Lang('no_opengraph_type');
        $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
        $alerts[] = $alert;
      }
      // No OpenGraph sitename set
      if ($mod->GetPreference('meta_opengraph_sitename','') == '') {
        $alert = Array();
        $alert['group'] = 'opengraph';
        $alert['message'] = $mod->Lang('no_opengraph_sitename');
        $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
        $alerts[] = $alert;
      }
      // No OpenGraph image set
      if ($mod->GetPreference('meta_opengraph_image','') == '') {
        $alert = Array();
        $alert['group'] = 'opengraph';
        $alert['message'] = $mod->Lang('no_opengraph_image');
        $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
        $alerts[] = $alert;
      }
    }

    return $alerts;
  }

  
  private static function _getImportantAlerts() {
    $mod = cms_utils::get_module('SEOTools2');
    $config = cmsms()->GetConfig();
    $db = cmsms()->GetDb();
    $alerts = Array();
    $root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];

    // Pages with short description
    $query = 'SELECT *,c.content_id AS cid FROM '.cms_db_prefix().'content c INNER JOIN '.cms_db_prefix().'content_props p ON (c.content_id = p.content_id AND p.prop_name = "'.str_replace(' ','_',$mod->GetPreference('description_block','')).'") WHERE CHAR_LENGTH(p.content) < 75 AND c.type = "content" AND p.content <> "" LIMIT 0,21';
    $result =& $db->Execute($query);
    if (is_object($result) && $result->RecordCount() > 0) {
      while ($problem = $result->fetchRow()) {
        $alert = Array();
        $alert['group'] = 'descriptions';
        $alert['message'] = $mod->Lang('meta_description_short',Array($problem['content_name']));
        $alert['links'][] = '<a href="'.$root_url.'/'.$config['admin_dir'].'/editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$problem['cid'].'">'.$mod->Lang('edit_page_to_fix').'</a>';
        $alerts[] = $alert;
      }
    }

    // Pages with duplicate title
    $query = 'SELECT c1.content_alias AS c1name, c1.content_id AS c1id, c2.content_alias AS c2name, c2.content_id AS c2id FROM '.cms_db_prefix().'content c1 INNER JOIN '.cms_db_prefix().'content c2 ON (c1.content_name = c2.content_name AND c1.content_id < c2.content_id) WHERE c1.type = "content" AND c2.type = "content" LIMIT 0,21';
    $result =& $db->Execute($query);
    if (is_object($result) && $result->RecordCount() > 0) {

      while ($problem = $result->fetchRow()) {
        $alert = Array();
        $alert['group'] = 'titles';
        $alert['message'] = $mod->Lang('duplicate_titles',Array($problem['c1name'],$problem['c2name']));
        $alert['links'][] = '<a href="'.$root_url.'/'.$config['admin_dir'].'/editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$problem['c1id'].'">'.$mod->Lang('edit_page',Array($problem['c1name'])).'</a>';
        $alert['links'][] = '<a href="'.$root_url.'/'.$config['admin_dir'].'/editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$problem['c2id'].'">'.$mod->Lang('edit_page',Array($problem['c2name'])).'</a>';
        $alerts[] = $alert;
      }
    }
    // Pages with duplicate description
    $query = 'SELECT p1.content_id AS c1id, p2.content_id AS c2id FROM '.cms_db_prefix().'content_props p1 INNER JOIN '.cms_db_prefix().'content_props p2 ON (p1.prop_name = p2.prop_name AND p1.prop_name = "'.str_replace(' ','_',$mod->GetPreference('description_block','')).'" AND p1.content_id < p2.content_id AND p1.content <> "" AND p2.content <> "") WHERE p1.content = p2.content LIMIT 0,21';
    $result =& $db->Execute($query);
    if (is_object($result) && $result->RecordCount() > 0) {

      while ($problem = $result->fetchRow()) {
        $query = 'SELECT content_id, content_name FROM '.cms_db_prefix().'content WHERE content_id = '.$problem['c1id'].' OR content_id = '.$problem['c2id'];
        $result1 =& $db->Execute($query);
        $first = $result1->fetchRow();
        $second = $result1->fetchRow();
        $alert = Array();
        $alert['group'] = 'descriptions';
        $alert['message'] = $mod->Lang('duplicate_descriptions',Array($first['content_name'],$second['content_name']));
        $alert['links'][] = '<a href="'.$root_url.'/'.$config['admin_dir'].'/editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$first['content_id'].'">'.$mod->Lang('edit_page',Array($first['content_name'])).'</a>';
        $alert['links'][] = '<a href="'.$root_url.'/'.$config['admin_dir'].'/editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$second['content_id'].'">'.$mod->Lang('edit_page',Array($second['content_name'])).'</a>';
        $alerts[] = $alert;
      }
    }
    // No author provided
    if ($mod->GetPreference('meta_publisher','') == '') {
      $alert = Array();
      $alert['group'] = 'settings';
      $alert['message'] = $mod->Lang('provide_an_author');
      $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
      $alerts[] = $alert;
    }
    return $alerts;
  }
  
  private static function _getNoticeAlerts() {
    $mod = cms_utils::get_module('SEOTools2');
    $alerts = Array();
    // No standard meta
    if ($mod->GetPreference('meta_standard',1) != 1) {
      $alert = Array();
      $alert['message'] = $mod->Lang('use_standard_meta');
      $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'metasettings'));
      $alerts[] = $alert;
    }
    // Submit a sitemap
    if ($mod->GetPreference('create_sitemap',1) != 1) {
      $alert = Array();
      $alert['message'] = $mod->Lang('create_a_sitemap');
      $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'sitemapsettings'));
      $alerts[] = $alert;
    }elseif($mod->GetPreference('push_sitemap',1) != 1) {
      // Automatically submit the sitemap
      $alert = Array();
      $alert['message'] = $mod->Lang('automatically_upload_sitemap');
      $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'sitemapsettings'));
      $alerts[] = $alert;
    }
    // Create a robots.txt file
    if ($mod->GetPreference('create_robots',1) != 1) {
      $alert = Array();
      $alert['message'] = $mod->Lang('create_robots');
      $alert['links'][] = $mod->createLink(null, 'defaultadmin', null, $mod->Lang('visit_settings'), Array('tab'=>'sitemapsettings'));
      $alerts[] = $alert;
    }
    // Set a default image
    return $alerts;
  }

  private static function _get_keywords($source, $minlength = 6) {
    $source = preg_replace('/\{[^\}]+\}/isU', '', utf8_decode($source));
    $source = str_replace("\n"," ",strip_tags($source));
    $source = str_replace('-',' ',$source);
    $source = str_replace('.',' ',$source);
    $source = str_replace(',',' ',$source);
    $source = str_replace('!',' ',$source);
    $source = str_replace('?',' ',$source);
    $source = str_replace(':',' ',$source);
    $source = str_replace('  ',' ',$source);
    $keywords = explode(' ',$source);
    foreach ($keywords as $key=>$value) {
      if (strlen($value) < $minlength) {
        unset($keywords[$key]);
      }else{
        $keywords[$key] = htmlentities(trim($value));
      }
    }
    return $keywords;
  }

  private static function _get_headlines($file){
    $h1tags = preg_match_all("/(<h1.*>)(\w.*)(<\/h1>)/isxmU",$file,$patterns);
    $content = "";
    foreach($patterns[2] as $tag) {
      $content .= " ".$tag;
    }
    $h2tags = preg_match_all("/(<h2.*>)(\w.*)(<\/h2>)/isxmU",$file,$patterns);
    foreach($patterns[2] as $tag) {
      $content .= " ".$tag;
    }
    $h3tags = preg_match_all("/(<h3.*>)(\w.*)(<\/h3>)/isxmU",$file,$patterns);
    foreach($patterns[2] as $tag) {
      $content .= " ".$tag;
    }
    $h4tags = preg_match_all("/(<h4.*>)(\w.*)(<\/h4>)/isxmU",$file,$patterns);
    foreach($patterns[2] as $tag) {
      $content .= " ".$tag;
    }
    $h5tags = preg_match_all("/(<h5.*>)(\w.*)(<\/h5>)/isxmU",$file,$patterns);
    foreach($patterns[2] as $tag) {
      $content .= " ".$tag;
    }
    $h6tags = preg_match_all("/(<h6.*>)(\w.*)(<\/h6>)/isxmU",$file,$patterns);
    foreach($patterns[2] as $tag) {
      $content .= " ".$tag;
    }
    return $content;
  }

  private static function _getKeywordSuggestions($content_id) {
    $mod = cms_utils::get_module('SEOTools2');
    $smarty = cmsms()->GetSmarty();
    $db = cmsms()->GetDb();
    
    $contentops = cmsms()->GetContentOperations();
    if (!$curcontent = $contentops->LoadContentFromId ($content_id)) {
      return;
    }
    $description_id = str_replace(' ','_',$mod->GetPreference('description_block',''));

    /* Generate keywords from page title, description and content */
    $title_keywords = seo2_utils::get_keywords($curcontent->GetPropertyValue('content_en'), $mod->GetPreference('keyword_minlength','6'));

    $description_keywords = seo2_utils::get_keywords($curcontent->GetPropertyValue($description_id), $mod->GetPreference('keyword_minlength','6'));

    $headline_keywords = seo2_utils::get_keywords(seo2_utils::get_headlines($curcontent->Name()), $mod->GetPreference('keyword_minlength','6'));

    $content_keywords = seo2_utils::get_keywords($curcontent->GetPropertyValue('content_en'), $mod->GetPreference('keyword_minlength','6'));

    $other_keywords = Array();

    foreach($title_keywords as $keyword) {
      if (!isset($other_keywords[$keyword])) {
        $other_keywords[$keyword] = 0;
      }
      $other_keywords[$keyword] = $mod->GetPreference('keyword_title_weight','6');
    }
    foreach($description_keywords as $keyword) {
      if (!isset($other_keywords[$keyword])) {
        $other_keywords[$keyword] = 0;
      }
      $other_keywords[$keyword] += $mod->GetPreference('keyword_description_weight','4');
    }
    foreach($headline_keywords as $keyword) {
      if (!isset($other_keywords[$keyword])) {
        $other_keywords[$keyword] = 0;
      }
      $other_keywords[$keyword] += $mod->GetPreference('keyword_headline_weight','2');
    }
    foreach($content_keywords as $keyword) {
      if (!isset($other_keywords[$keyword])) {
        $other_keywords[$keyword] = 0;
      }
      $other_keywords[$keyword] += $mod->GetPreference('keyword_content_weight','1');
    }

    arsort($other_keywords);

    $exclude_list = explode(' ',strtoupper(utf8_decode($mod->GetPreference('keyword_exclude',''))));

    foreach ($other_keywords as $key=>$value) {
      if ($value < $mod->GetPreference('keyword_minimum_weight','7')) {
        unset($other_keywords[$key]);
      }elseif (in_array(strtoupper($key),$exclude_list)) {
        unset($other_keywords[$key]);
      }
    }
    $other_keywords = array_flip($other_keywords);
    return $other_keywords;
  }

  private static function _createRobotsTXT() {
    $mod = cms_utils::get_module('SEOTools2');
    $config = cmsms()->GetConfig();
    $db = cmsms()->GetDb();
    $cms_root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];
    
    $root_path = str_replace('\\','/',$config['root_path']); // for Windows
    $server_root = $_SERVER['DOCUMENT_ROOT'];
    $cms_path = str_replace($server_root,'',$root_path);
    
    $leading_slash = strpos($cms_path, '/') === 0 ? '' : '/';

    $filename = $server_root. DIRECTORY_SEPARATOR .'robots.txt';
    
    // just in case the server doubled up on the directory separators
    $filename = str_replace('//','/',$filename);
    
   
    // warn the user they're about to delete the robots.txt file
    if (file_exists($filename)) {
      	$mod->redirect(null, 'robots', null, '');
    }
    
    touch($filename);
    
    $fp = fopen($filename,'wb');

    // Create robots.txt
    if ($mod->GetPreference('create_sitemap',1) == 1) {
      fwrite($fp, "Sitemap: ".$cms_root_url."/sitemap.xml\r\n");
    }
    
    $before = $mod->GetPreference('r_before','');
    if (!empty($before)) {
      fwrite($fp, $before ."\r\n");
    }
    fwrite($fp, "User-agent: *\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path. "/".$config['admin_dir']."/\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path."/contrib/\r\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path."/doc/\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path."/lib/\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path."/modules/\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path."/plugins/\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path."/scripts/\r\n");
    fwrite($fp, "Disallow: ". $leading_slash . $cms_path."/tmp/\r\n");

    $query = "SELECT * FROM ".cms_db_prefix()."module_seotools2 WHERE indexable = 0";
    $result = $db->Execute($query);

    $contentops = cmsms()->GetContentOperations();
    while ($page = $result->fetchRow()) {

      if ($curcontent = $contentops->LoadContentFromId ($page['content_id'])) {
        $page_path = $cms_path . "/" . $curcontent->HierarchyPath() . $config['page_extension'];
        fwrite($fp, "Disallow: ".$page_path."\r\n");
      }
    }
    $after = $mod->GetPreference('r_after','');
    if (!empty($after)) {
      fwrite($fp, $after ."\r\n");
    }
    
    fclose($fp);
  }

  private static function _createSitemap($push = false) {
    $mod = cms_utils::get_module('SEOTools2');
    $config = cmsms()->GetConfig();
    $db = cmsms()->GetDb();
    $root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];
    $root_path = $config['root_path'];
    $map_path = $root_path.DIRECTORY_SEPARATOR.'sitemap.xml';
    
    $fp = fopen($map_path,'w');

    // Write the sitemap
    fwrite($fp, "<?xml version='1.0' encoding='UTF-8'?>\r\n");
    fwrite($fp, "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\r\n");

    $contentops = cmsms()->GetContentOperations();

    $query = 'SELECT * FROM '.cms_db_prefix().'content WHERE active = 1 AND type != "errorpage" ORDER BY hierarchy ASC';
    $result =& $db->Execute($query);
    
    
    if ($result->RecordCount() > 0 ) {
      while ($page = $result->fetchRow()) {
        
        if ($curcontent = $contentops->LoadContentFromId ($page['content_id'])) {

          if ($curcontent->Active()) {
            $url = $curcontent->GetURL();
            if ($url == "#") {
              continue;
            }
        
            
            
            if (strpos(strstr($url,':'), strstr($root_url,':')) === false) {
              continue;
            }

            $priority = 80;
            for ($i = 0; $i < substr_count($page['hierarchy'],'.'); $i++) {
              $priority  = $priority / 2;
            }
            if ($page['default_content'] == 1) {
              $priority = 100;
            }

            $query = 'SELECT * FROM '.cms_db_prefix().'module_seotools2 WHERE content_id = '.$page['content_id'];
            $result2 =& $db->Execute($query);
                        
            $info = $result2->fetchRow();
            if (isset($info['priority']) && ($info['priority'] != 0) && ($info['priority'] != "")) {
              $priority = $info['priority'];
            }
            
            if (!isset($info['indexable']) || ($info['indexable'] == "") || ($info['indexable'] == 1)) {
              fwrite($fp, "<url>\r\n");
              fwrite($fp, "<loc>".$url."</loc>\r\n");
              fwrite($fp, "<lastmod>".date("Y-m-d", strtotime($page['modified_date']))."</lastmod>\r\n");
              fwrite($fp, "<changefreq>always</changefreq>\r\n");
              fwrite($fp, "<priority>".number_format($priority / 100, 1)."</priority>\r\n");
              fwrite($fp, "</url>\r\n");
            }
          }
        }
      }
    }
    
    fwrite($fp, "</urlset>");
    fclose($fp);
    
    if ($push != false && $push !==0) {
      // Push sitemap to google
      if (file_exists($map_path)) {
        $google = "http://www.google.com/webmasters/tools/ping?sitemap=".urlencode($map_path);
        $f = @fopen($google,"r");
        if (is_resource($f))
        fclose($f);
      }

    }
  }
  
  private static function _GetNotificationOutput($priority = 3) {
    $mod = cms_utils::get_module('SEOTools2');
    if (count(seo2_::getUrgentAlerts()) > 0) {
      $text = $mod->Lang('problem_alert',Array($mod->createLink(null, 'defaultadmin', '', $mod->Lang('problem_link_title'))));

      $obj = new StdClass;
      $obj->priority = 3;
      $obj->html = $text;

      return $obj;
    }
  }
  
  private static function _seotools2_db_update() {
    $db = cmsms()->GetDb();
    $html = '';
    // First up, we do some database maintenance
    // Ensure all the active pages are in the seotools2 database
    $query = 'SELECT `content_id` FROM '.cms_db_prefix().'content WHERE (`type` LIKE "%content%" OR `type` LIKE "%link%" OR `type` LIKE "%catalog%" )AND `content_id` NOT IN (SELECT `content_id` FROM ' . cms_db_prefix(). 'module_seotools2)';
    if (!$result = $db->Execute($query)) {
      $html =  "<br />Problem with the database! Please contact your administrator.";
    }
    
    
    if ($result->RecordCount() > 0) {
      // OK we have some new pages
      $q2 = 'INSERT INTO '.cms_db_prefix().'module_seotools2 SET content_id = ?, indexable = ?';
      while ($one_page = $result->fetchRow()) {
        $db->Execute($q2,array($one_page['content_id'],1));
      }
    }
    
    // Now check that we have removed from seotools2 any pages that have been deleted
    $query = 'SELECT `content_id` FROM '.cms_db_prefix().'module_seotools2 WHERE `content_id` NOT IN (SELECT `content_id` FROM ' . cms_db_prefix(). 'content)';
    if (!$result = $db->Execute($query)) {
      $html =  "<br />Problem with the database! Please contact your administrator.";
    }
    
    if ($result->RecordCount() > 0) {
      // OK we have some deleted pages
      $q3 = 'DELETE FROM '.cms_db_prefix().'module_seotools2 WHERE content_id = ?';
      while ($one_page = $result->fetchRow()) {
        $db->Execute($q3,array($one_page['content_id']));
      }
    }
    
    // Next, ensure that all inactive pages are marked as not indexable in seotools2
    $query = 'SELECT content_id FROM ' . cms_db_prefix() . 'content WHERE active = 0';
    if (!$result = $db->Execute($query)) {
      $html =  "<br />Problem with the database! Please contact your administrator.";
    }
    
    if ($result->RecordCount() > 0) {
      // OK we have to prevent the inactive pages from being indexed.
      $q4 = 'UPDATE '.cms_db_prefix().'module_seotools2 SET indexable = 0 WHERE content_id = ?';
      while ($one_page = $result->fetchRow()) {
        $db->Execute($q4,array($one_page['content_id']));
      }
    }
    
    
    
    if (!empty($html)) {
      echo $html;
      die;
    } else {
      return true;
    }
    // Phew, that's all done so we can move on to the real business of the day
    
  }
  
}

?>