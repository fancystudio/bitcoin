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
#-------------------------------------------------------------------------
# Module: Orders - A simple order processing module.
# Version: 1.0, calguy1000 <calguy1000@cmsmadesimple.org>
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
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in every page of
# its admin section that the site was built with CMS Made simple, and
# provide a link to the CMS Made Simple website.
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

class encrypted_store
{
  static private $_store;
  static private $_key;
  static private $_enckey;
  static private $_timeout = 600;

  private static function __make()
  {
    if( is_null(self::$_store) )
      {
	self::$_store = new cge_datastore(self::$_timeout);
	self::$_key = md5('encrypted_store');
	
	$config = cmsms()->GetConfig();
	$key = md5($config['root_url'] + $config['root_path'] + getenv('REMOTE_ADDR'));
	self::$_enckey = $key;
      }
  }


  static public function get_timeout()
  {
    return self::$_timeout;
  }


  static public function set_timeout($num)
  {
    $num = max($num,30);
    self::$_timeout = $num;
    if( is_object(self::$_store) )
      {
	self::$_store->set_expiry($num);
      }
  }


  static public function set_key($str)
  {
    self::$_key = $str;
  }
   

  static public function put($data,$key1,$key2='',$key3='')
  {
    self::__make();
    if( is_null(self::$_enckey) ) die('abort - no encryption key set');
    $ser = serialize($data);
    $tmp = cge_encrypt::encrypt(self::$_enckey,$ser);
    self::$_store->store(base64_encode($tmp),self::$_key,$key1,$key2,$key3);
  }

  static public function put_special($data,$specialkey,$key1,$key2='',$key3='')
  {
    self::__make();
    $tmp = cge_encrypt::encrypt($specialkey,serialize($data));
    self::$_store->store(base64_encode($tmp),self::$_key,$key1,$key2,$key3);
  }

  static public function get($key1,$key2='',$key3='')
  {
    self::__make();
    $tmp = self::$_store->get(self::$_key,$key1,$key2,$key3);
    $tmp = base64_decode($tmp);
    $data = unserialize(cge_encrypt::decrypt(self::$_enckey,$tmp));
    return $data;
  }

  static public function get_special($specialkey,$key1,$key2='',$key3='')
  {
    self::__make();
    $tmp = self::$_store->get(self::$_key,$key1,$key2,$key3);
    $tmp = base64_decode($tmp);
    $data = unserialize(cge_encrypt::decrypt($specialkey,$tmp));
    return $data;
  }

  static public function erase($key1,$key2='',$key3='')
  {
    self::__make();
    self::$_store->erase(self::$_key,$key1,$key2,$key3);
  }

  static public function cleanup()
  {
    self::__make();
    self::$_store->remove_expired();
  }
} // end of class

// EOF
?>