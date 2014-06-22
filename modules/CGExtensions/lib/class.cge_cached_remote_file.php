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

class cge_cached_remote_file
{
  private $_cache_timelimit = null;
  private $_src_spec = null;
  private $_cache_file = null;

  public function __construct($src, $timelimit = 0, $dest = '')
  {
    $this->_src_spec = $src;
    if( $timelimit <= 0 ) $timelimit = 24*60;
    $this->_cache_timelimit = $timelimit;
    if( empty($dest) ) {
      $bn = 'cache_'.md5($src);
      $config = cmsms()->GetConfig();
      $dest = cms_join_path(TMP_CACHE_LOCATION,$bn);
    }
    $this->_cache_file = $dest;
  }

  public function get_source()
  {
    return $this->_src_spec;
  }

  public function get_dest()
  {
    return $this->_cache_file;
  }

  public function get_cache_timelimit()
  {
    return $this->_cache_timelimit;
  }

  public function set_cache_timelimit($minutes)
  {
    $this->_cache_timelimit = max(1,(int)$minutes);
  }

  private function refresh_cache()
  {
    @unlink($this->_cache_file);
    $data = cge_http::get($this->_src_spec);
    if( $data ) @file_put_contents($this->_cache_file,$data);
  }

  private function check_cache()
  {
    $need_update = false;
    $mtime = -1;
    if( !file_exists($this->_cache_file) ) {
      $need_update = true;
    }
    else {
      $mtime = filemtime($this->_cache_file);
    }
    if( $mtime + ($this->_cache_timelimit * 60) < time() ) $need_update = true;
    if( $need_update ) $this->refresh_cache();
  }

  public function file()
  {
    $this->check_cache();
    return @file($this->_cache_file);
  }

  public function file_get_contents()
  {
    $this->check_cache();
    return @file_get_contents($this->_cache_file);
  }

  public function md5()
  {
    $this->check_cache();
    return @md5_file($this->_cache_file);
  }

  public function size()
  {
    $this->check_cache();
    return @filesize($this->_cache_file);
  }

  public function cleanup()
  {
    @unlink($this->_cache_file);
  }
}
#
# EOF
#
?>