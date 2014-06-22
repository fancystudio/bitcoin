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

final class cge_redirect
{
  private function __construct() {}

  public static function redirect_abs301($url)
  {
    $handlers = ob_list_handlers(); 
    for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }
    header( "HTTP/1.1 301 Moved Permanently" );
    header( "Location: ".$url ); 
  }


  public static function redirect301($page_alias)
  {
    // 1... get the page object
    $contentops = cmsms()->GetContentOperations();
    $content = $contentops->LoadContentFromAlias($page_alias,true);
    if( is_object($content) ) {
      // 2... get the url
      $url = $content->GetURL();

      // 3... do the redirect.
      self::redirect_abs301($url);
    }
  }


  public static function redirect404()
  {
    $contentops = cmsms()->GetContentOperations();
    
    $url = '';
    $content = $contentops->LoadContentFromAlias('error404',true);
    if( is_object($content) ) {
      // 2... get the url
      $url = $content->GetURL();

      // 3... do the redirect
    }
    else {
      // using the old custom404 handler.
      // so just redirect to some nonsenseical url
      $config = cmsms()->GetConfig();
      $base_url = $config['root_url'];
      $junkpage = str_shuffle(md5(rand(0,1000)));
      $junkpage = 'junk_'.substr($junkpage,0,4);
      $url = $base_url.'/index.php?'.$config['query_var'].'='.$junkpage;
    }

    if( !empty($url) )
      redirect($url);
  }


  static public function redirect_https($url = '')
  {
    if( empty($url) ) {
      $url = cge_url::current_url();
    }

    if( startswith( $url, 'https:' ) ) {
      // nothing to do.
      redirect($url);
    }
    
    $config = cmsms()->GetConfig();
    if( startswith( $url, $config['root_url'] ) ) {
      $new_url = '';
      if( isset($config['ssl_url']) ) {
	$new_url = str_replace($config['root_url'],$config['ssl_url'],$url);
      }
      else {
	$new_url = str_replace('http://','https://',$url);
      }
      redirect($new_url);
    }
  }

  static public function redirect_http($url = '',$force = false)
  {
    if( empty($url) ) $url = cge_url::current_url();

    if( startswith( $url, 'http:' ) ) {
      // nothing to do.
      return;
    }
    
    $config = cmsms()->GetConfig();
    if( $force ) {
      $new_url = str_replace('https:','http:',$url);
      redirect($new_url);
    }
    else {
      if( startswith( $url, $config['ssl_url'] ) && isset($config['ssl_url']) ) {
	$new_url = str_replace($config['ssl_url'],$config['root_url'],$url);
	redirect($new_url);
      }
    }
  }

  static public function redirect_with_error($returnid,$message,$error=1)
  {
    $mod = cge_utils::get_module();
    $mod->Redirect( $id, 'showmessage', $returnid, 
		    array('cge_msg' => $message,
			  'cge_error' => (int)$error));
  }
}

#
# EOF
#
?>