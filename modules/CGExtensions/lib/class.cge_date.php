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

class cge_date
{
  private $_time;

  public function __construct($time = '')
  {
    $ntime = $time;
    if( !$time )
      {
	$ntime = time();
      }
    else if( !is_numeric($time) )
      {
	$ntime = strtotime($time);
	if( !$ntime )
	  {
	    $db = cmsms()->GetDb();
	    $ntime = $db->UnixTimeStamp($time);
	  }
      }
    $this->_time = $ntime;
  }

  private static function _explode($the_date)
  {    
    $res = array();
    $res['day'] = date('d',$the_date);
    $res['month'] = date('m',$the_date);
    $res['year'] = date('Y',$the_date);
    $res['hour'] = date('H',$the_date);
    $res['minutes'] = date('i',$the_date);
    $res['seconds'] = date('s',$the_date);
    return $res;
  }

  private static function _implode($data)
  {
    $time = mktime(
                   (isset($data['hour']))?$data['hour']:0,
                   (isset($data['minutes']))?$data['minutes']:0,
                   (isset($data['seconds']))?$data['seconds']:0,
                   (isset($data['month']))?$data['month']:0,
                   (isset($data['day']))?$data['day']:0,
                   (isset($data['year']))?$data['year']:0);
    return $time;
  }

  public static function is_leapyear($year = '')
  {
    if( !$year ) $year = date('Y',time());

    $f = 0;
    if( $year % 4 == 0 ) $f = 1;
    if( $year % 100 == 0 ) $f == 0;
    if( $year % 400 == 0 ) $f = 1;
    return $f;
  }

  public function to_timestamp()
  {
    return $this->_time;
  }

  public function to_dbformat()
  {
    $db = cmsms()->GetDb();
    return trim($db->DbTimeSTamp($this->_time),"'");
  }

  public function day()
  {
    return date('d',$this->_time);
  }

  public function set_day($d)
  {
    $tmp = self::_explode($this->_time);
    $tmp['day'] = $d;
    $this->_time = self::_implode($tmp);
  }

  public function month()
  {
    return date('m',$this->_time);
  }

  public function set_month($m)
  {
    $tmp = self::_explode($this->_time);
    $tmp['month'] = $m;
    $this->_time = self::_implode($tmp);
  }

  public function year()
  {
    return date('Y',$this->_time);
  }

  public function set_year($y)
  {
    $tmp = self::_explode($this->_time);
    $tmp['year'] = $y;
    $this->_time = self::_implode($tmp);
  }

  public function hour()
  {
    return date('H',$this->_time);
  }

  public function set_hour($h)
  {
    $tmp = self::_explode($this->_time);
    $tmp['hour'] = $h;
    $this->_time = self::_implode($tmp);
  }

  public function minutes()
  {
    return date('i',$this->_time);
  }

  public function set_minutes($m)
  {
    $tmp = self::_explode($this->_time);
    $tmp['minutes'] = $m;
    $this->_time = self::_implode($tmp);
  }

  public function seconds()
  {
    return date('s',$this->_time);
  }

  public function set_seconds($s)
  {
    $tmp = self::_explode($this->_time);
    $tmp['seconds'] = $s;
    $this->_time = self::_implode($tmp);
  }

  public function set_time($h,$m)
  {
    $tmp = self::_explode($this->_time);
    $tmp['hour'] = $h;
    $tmp['minutes'] = $m;
    $this->_time = self::_implode($tmp);
  }

  public function set_time_from_str($time_str)
  {
    $tmp = self::_explode($this->_time);
    list($h1,$m1) = explode(':',trim($time_str));
    $tmp['hour'] = $h1;
    $tmp['minutes'] = $m1;
    $this->_time = self::_implode($tmp);
  }

  public function get_rfc_date()
  {
    $fmt = '%Y-%m-%dT%H:%M:%S';
    $tmp = strftime($fmt,$this->_time);
    $tmp .= date('P');
    return $tmp;
  }
}

#
# EOF
#
?>