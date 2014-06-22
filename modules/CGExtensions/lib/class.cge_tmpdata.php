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

final class cge_tmpdata 
{
  private static $_data;

  private static function _setup()
  {
    if( !is_array(self::$_data) )
      {
	self::$_data = array();
      }
  }

  public static function exists($key)
  {
    if( empty($key) ) return FALSE;
    if( !is_array(self::$_data) ) return FALSE;
    if( !isset(self::$_data[$key]) ) return FALSE;
    return TRUE;
  }

  public static function get($key)
  {
    if( self::exists($key) )
      {
	return self::$_data[$key];
      }
  }

  public static function set($key,$value)
  {
    if( !empty($key) )
      {
	self::_setup();
	self::$_data[$key] = $value;
      }
  }

  public static function erase($key)
  {
    if( self::exists($key) )
      {
	unset(self::$_data[$key]);
      }
  }
} // end of class

#
# EOF
#
?>