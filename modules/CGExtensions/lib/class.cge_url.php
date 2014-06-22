<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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

class cge_url
{
  /**
   * protected constructor
   */
  protected function __construct() {}

  /**
   * Convert a standard url into an SSL url
   *
   * @param string The input URL
   */
  public static function ssl_url($url)
  {
    $config = cmsms()->GetConfig();

    $ssl_url = '';
    if( isset($config['ssl_url']) ) 
      {
	$ssl_url = $config['ssl_url'];
      }
    if( empty($ssl_url) )
      {
	$ssl_url = str_replace('http://','https://',$config['root_url']);
      }
    
    if( startswith($url,$ssl_url) )
      {
	return $url;
      }
    else if( startswith($url,$config['root_url']) )
      {
	$url = str_replace($config['root_url'],$ssl_url,$url);
	return $url;
      }
    return FALSE;
  }

  public static function current_url()
  {
    // rebuild the current url.
    $config = cmsms()->GetConfig();
    $uri_parts = explode('/',$_SERVER['REQUEST_URI']);
    $uri_parts = cge_array::remove_by_value($uri_parts);
    $tmp = parse_url($config['root_url']);
    $root_parts = array();
    if( isset($tmp['path']) ) {
      $root_parts = explode('/',$tmp['path']);
      $root_parts = cge_array::remove_by_value($root_parts);
    }
    
    $newdata = array();
    for($i = 0; $i < max(count($uri_parts),count($root_parts)); $i++ ) {
      if( ($i < count($uri_parts)) && ($i < count($root_parts)) && 
	  ($root_parts[$i] == $uri_parts[$i]) ) {
	continue;
      }
      $newdata[] = $uri_parts[$i];
    }
    $url = $config['root_url'].'/'.implode('/',$newdata);
    return $url;
  }

  public static function page_url()
  {
    $content_obj = cmsms()->get_variable('content_obj');
    if( is_object($content_obj) )
      {
	return $content_obj->GetURL();
      }
  }

  /**
   * Given an existing URL, add or adjust one of the parameters
   *
   * @param string The input url
   * @param string The key name
   * @param string The value for the variable
   * @returns string  The resulting URL
   */
  public static function set_param($url,$key,$value)
  {
    if( !$url ) return;
    $tmp = parse_url($url);
    if( $tmp === FALSE ) return;

    $query = array();
    if( isset($tmp['query']) )
      {
	parse_str($tmp,$query);
      }
    $query[$key] = $value;
    $tmp['query'] = http_build_query($query,'','&');
    return http_build_url($tmp);
  }
}

#
# EOF
#
?>
