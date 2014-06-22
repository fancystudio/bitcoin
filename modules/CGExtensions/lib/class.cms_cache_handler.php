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

class cms_cache_handler
{
  const TYPE_ANY = 0;
  const TYPE_PAGE = 1;
  const TYPE_CONTENT = 2;
  const TYPE_MODULE = 3;
  const TYPE_TEMPLATE = 4;
  const TYPE_STYLESHEET = 5;

  static private $_instance;
  private $_driver;

  private function __construct() {}
  private function __clone() {}

  final public static function get_instance()
  {
    if( !is_object(self::$_instance) )
      {
	self::$_instance = new cms_cache_handler;
      }
    return self::$_instance;
  }

  final public function set_driver(cms_cache_driver& $driver)
  {
    $this->_driver = $driver;
  }

  final public function get_driver()
  {
    return $this->_driver;
  }

  final public function clear($group = '')
  {
    if( !self::can_cache() ) return FALSE;

    if( is_object($this->_driver) ) {
      return $this->_driver->clear();
    }
    return FALSE;
  }

  final public function get($key,$group = '')
  {
    if( !$this->can_cache() ) return FALSE;

    if( is_object($this->_driver) ) {
      return $this->_driver->get($key,$group);
    }
    return FALSE;
  }

  final public function exists($key,$group = '')
  {
    if( !self::can_cache() ) return FALSE;
    if( is_object($this->_driver) ) {
      return $this->_driver->exists($key,$group);
    }
    return FALSE;
  }

  final public function erase($key,$group = '')
  {
    if( !self::can_cache() ) return FALSE;
    if( is_object($this->_driver) ) {
      return $this->_driver->erase($key,$group);
    }
    return FALSE;
  }

  final public function set($key,$value,$group = '')
  {
    if( !self::can_cache() ) return FALSE;
    if( is_object($this->_driver) ) {
      return $this->_driver->set($key,$value,$group);
    }
    return FALSE;
  }


  final public static function can_cache($type = 0)
  {
    global $CMS_ADMIN_PAGE;
    global $CMS_INSTALL_PAGE;
    global $CMS_MODULE_PAGE;
    global $CMS_STYLESHEET;

    if( isset($CMS_INSTALL_PAGE) ) return FALSE;
    if( isset($CMS_ADMIN_PAGE) ) return FALSE;
    if( isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ) return FALSE;

    $config = cmsms()->GetConfig();
    if( isset($config['debug']) && $config['debug'] == true ) return FALSE;

    $uid = get_userid(false);
    if( $uid ) return FALSE; // caching disabled for logged in administrators

    return TRuE;
  }
}

?>