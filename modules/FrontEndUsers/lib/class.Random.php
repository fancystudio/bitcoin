<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

/**
 * Generate random characters.
 *
 * @author    Laurentiu Tanase <expertphp@yahoo.com>
 * @version   1.1
 */

class Random
{
	/**
	 * Set default characters.
     *
     * @var      string
     * @access   private
     */

	var $_vcrs;

	/**
	 * If have number
     *
     * @var      bool
     * @access   private
     */

	var $_vnum;

	/**
	 * If doesn't have number
     *
     * @var      bool
     * @access   private
     */

	var $_vnot;

	/**
	 * Constructor
	 *
	 * Set default values
	 *
	 * @param  string  $crs   Characters output
	 * @param  bool    $num   With number
	 * @param  bool    $not   With not number
	 */

	function Random($crs = false, $num = false, $not = false){
		$this->_vnum = $num;
		$this->_vnot = $not;
		if(!$crs){
			$this->_vcrs = "0123456789".
				"abcdefghijklmnopqrstuvwxyz".
				"ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		}else{
			$this->_vcrs = $crs;
			if(($num || $not) && !$this->_rec($crs, $num, $not)){
				if($num && $not) $err = "number or not number";
				elseif($num) $err = "number";
				elseif($not) $err = "not number";
				else $err = "comparation";
				trigger_error("Class Random - String input [ ".$crs." ] doesn't have ".$err, E_USER_ERROR);
			}
		}
	}

	/**
	 * Compare input string
	 *
	 * @access  private
	 * @param   string   $str      Characters input
	 * @param   bool     $number   Have number
	 * @param   bool     $notnum   Have not number
	 * @return  bool     If have number or/and not number
	 */

	function _rec($str, $number = true, $notnum = true){
		$cnt = strlen($str);
		$set1 = $set2 = false;
		if($number || $notnum){
			for($i=0;$i<$cnt;$i++){
				if($str{$i} === strval(intval($str{$i}))) $set1 = true;
				else $set2 = true;
				if($set1 && $set2) break;
			}
			if($number && $notnum) return ($set1 && $set2);
			elseif($number) return $set1;
			elseif($notnum) return $set2;
			else return true;
		}else return true;
	}

	/**
	 * Generate random characters
	 *
	 * @access  public
	 * @param   int      $len   Length of the string you want generated
	 * @return  string   Random characters
	 */

	function get($len){
		if(!(is_int($len) && $len > 0)) return $this->_vcrs;
		$ret = "";
		$cnt = strlen($this->_vcrs)-1;
		for($i=0;$i<$len;$i++) $ret .= $this->_vcrs{rand(0, $cnt)};
		if($this->_vnum || $this->_vnot) return $this->_rec($ret, $this->_vnum, $this->_vnot) ? $ret : Random::get($len);
		else return $ret;
	}

}

?>