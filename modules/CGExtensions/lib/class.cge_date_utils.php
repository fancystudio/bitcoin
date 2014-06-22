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

class cge_date_utils
{
  static public function str_to_timestamp($str)
  {
    return strtotime($str);
  }

  static public function ts_set_time($timestamp,$hour,$minutes)
  {
    $obj = new cge_date($timestamp);
    $obj->set_time($hour,$minutes);
    return $obj->to_timestamp();
  }

  static public function ts_set_time_from_str($timestamp,$str)
  {
    $obj = new cge_date($timestamp);
    $obj->set_time_from_str($str);
    return $obj->to_timestamp();
  }

  static public function is_leapyear($year = '')
  {
    if( !$year )
      {
	$year = date('Y');
      }

    $f = 0;
    if( $year % 4 == 0 ) $f = 1;
    if( $year % 100 == 0 ) $f == 0;
    if( $year % 400 == 0 ) $f = 1;
    return $f;
  }

  static public function days_in_month($month = '',$year = '')
  {
    $days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    if( !$month )
      {
	$month = date('m');
      }
    if( !$year )
      {
	$year = date('Y');
      }

    if( self::is_leapyear($year) )
      {
	$days_in_year[1] = 29;
      }

    // month is a value from 1 to 12.
    return $days_in_year[$month-1];
  }

  static public function &date_at($month,$day,$year,$hour = 0,$minute = 0,$seconds = 0)
  {
    $tmp = mktime($hour,$minute,$seconds,$month,$day,$year);
    return new cge_date($tmp);
  }

  static public function ts_to_dbformat($ts)
  {
    $db = cmsms()->GetDb();
    return trim($db->DbTimeSTamp($ts),"'");
  }

} // end of class

#
# EOF
#
?>