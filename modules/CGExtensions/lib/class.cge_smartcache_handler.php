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

class cge_smartcache_handler
{
  private $_group = '';
  private $_expiry = 3600;
  private $_driver;

  public function __construct($opts = null)
  {
    $driver_class = 'cms_filecache_driver';
    $driver_opts = array('cache_dir'=>TMP_CACHE_LOCATION,
			 'lifetime'=>3600,
			 'locking'=>1,
			 'autoclean'=>1);

    if( is_array($opts) && count($opts) ) {
      foreach( $opts as $key => $value ) {
	switch( $key ) {
	case 'group':
	  $value = trim($value);
	  if( !is_string($value) ) {
	    throw new Exception('Group '.$value.' is invalid');
	  }
	  $this->_group = $value;
	  break;

	case 'driver':
	  if( !class_exists($value) ) {
	    throw new Exception('Driver '.$value.' not specified');
	  }
	  $driver_class = $value;
	  break;

	case 'cache_dir':
	  if( !is_writable($value) ) {
	    throw new Exception('Directory '.$value.' is not writable');
	  }
	  $driver_opts['cache_dir'] = $value;
	  break;

	case 'lifetime':
	  if( !is_int($value) ) {
	    throw new Exception('Lifetime '.$value.' is invalid');
	  }
	  $value = max(30,min(12*3600,$value));
	  $driver_opts['lifetime'] = $value;
	  break;

	case 'locking':
	  $value = (int)$value;
	  if( $value > 0 ) $value = 1;
	  $driver_opts['locking'] = $value;
	  break;

	case 'autoclean':
	  $value = (int)$value;
	  if( $value > 0 ) $value = 1;
	  $driver_opts['autoclean'] = $value;
	}
      }
    }

    $this->_driver = new $driver_class($driver_opts);
  }

  public function set_group($group)
  {
    if( !is_array($group) && !is_object($group) ) {
      $this->_group = $group;
    }
  }

  final public function clear($group = '')
  {
    if( is_object($this->_driver) ) {
      if( !$group ) $group = $this->_group;
      return $this->_driver->clear($group);
    }
    return FALSE;
  }

  final public function get($key,$group = '')
  {
    if( is_object($this->_driver) ) {
      if( !$group ) $group = $this->_group;
      return $this->_driver->get($key,$group);
    }
    return FALSE;
  }

  final public function exists($key,$group = '')
  {
    if( is_object($this->_driver) ) {
      if( !$group ) $group = $this->_group;
      return $this->_driver->exists($key,$group);
    }
    return FALSE;
  }

  final public function erase($key,$group = '')
  {
    if( is_object($this->_driver) ) {
      if( !$group ) $group = $this->_group;
      return $this->_driver->erase($key,$group);
    }
    return FALSE;
  }

  final public function set($key,$value,$group = '')
  {
    if( is_object($this->_driver) ) {
      if( !$group ) $group = $this->_group;
      return $this->_driver->set($key,$value,$group);
    }
    return FALSE;
  }
} // end of class

?>