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

class cge_http
{
  static private $_http;

  static public function reset()
  {
/*
    if( class_exists('cms_http_request') )
      {
	// use the CMSMS 1.10 class
	self::$_http = new cms_http_request;
      }
    else
*/
      {
	require_once(dirname(__FILE__).'/http/class.http.php');
	self::$_http = new Http;
	self::$_http->setTimeout(60); // todo, make this a preference.
      }
  }


  static public function &get_http()
  {
    if( is_null(self::$_http) )
      {
	self::reset();
      }
    return self::$_http;
  }


  static public function post($URL,$data = '',$referer = '')
  {
    self::reset();
    $http = self::get_http();
    $http->setMethod('POST');
    if( $data )	$http->setParams($data);
    return $http->execute($URL);
  }


  static public function get($URL,$referer = '',$use_curl = TRUE)
  {
    if( $use_curl == FALSE || !in_array('curl',get_loaded_extensions()) )
      {
	return file_get_contents($URL);
      }
    else
      {
	self::reset();
	$http = self::get_http();
	$http->setMethod('GET');
	$tmp = $http->execute($URL);
	return $tmp;
      }
  }

  
  static public function status()
  {
    $http = self::get_http();
    return $http->getStatus();
  }


  static public function result()
  {
    $http = self::get_http();
    return $http->getResult();
  }
} // class

#
# EOF
#
?>
