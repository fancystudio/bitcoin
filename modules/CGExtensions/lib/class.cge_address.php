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

class cge_address
{
  private $_company;
  private $_firstname;
  private $_lastname;
  private $_address1;
  private $_address2;
  private $_city;
  private $_state;
  private $_postal;
  private $_country;
  private $_phone;
  private $_fax;
  private $_email;

  public function __construct()
  {
    // nothing here yet.
  }

  public function set_company($str)
  {
    $this->_company = $str;
  }

  public function get_company()
  {
    return $this->_company;
  }

  public function set_firstname($str)
  {
    $this->_firstname = $str;
  }

  public function get_firstname()
  {
    return $this->_firstname;
  }

  public function set_lastname($str)
  {
    $this->_lastname = $str;
  }

  public function get_lastname()
  {
    return $this->_lastname;
  }

  public function set_address1($str)
  {
    $this->_address1 = $str;
  }

  public function get_address1()
  {
    return $this->_address1;
  }

  public function set_address2($str)
  {
    $this->_address2 = $str;
  }

  public function get_address2()
  {
    return $this->_address2;
  }

  public function set_city($str)
  {
    $this->_city = $str;
  }

  public function get_city()
  {
    return $this->_city;
  }

  public function set_state($str)
  {
    $this->_state = $str;
  }

  public function get_state()
  {
    return $this->_state;
  }

  public function set_postal($str)
  {
    $this->_postal = $str;
  }

  public function get_postal()
  {
    return $this->_postal;
  }

  public function set_country($str)
  {
    $this->_country = $str;
  }

  public function get_country()
  {
    return $this->_country;
  }

  public function set_phone($str)
  {
    $this->_phone = $str;
  }

  public function get_phone()
  {
    return $this->_phone;
  }

  public function set_fax($str)
  {
    $this->_fax = $str;
  }

  public function get_fax()
  {
    return $this->_fax;
  }

  public function set_email($str)
  {
    $this->_email = $str;
  }

  public function get_email()
  {
    return $this->_email;
  }

  public function is_valid()
  {
    if( $this->get_firstname() == '' ) return FALSE;
    if( $this->get_lastname() == '' ) return FALSE;
    if( $this->get_address1() == '' ) return FALSE;
    if( $this->get_city() == '' ) return FALSE;
    if( $this->get_state() == '' ) return FALSE;
    if( $this->get_postal() == '' ) return FALSE;
    if( $this->get_country() == '' ) return FALSE;
    if( $this->get_email() == '' ) return FALSE;
    return TRUE;
  }

  public function from_array($params,$prefix)
  {
    $flds = array('company','firstname','lastname','address1','address2', 'city','state', 'postal','country', 'phone','fax','email');

    foreach( $flds as $fld ) {
        if( isset($params[$prefix.$fld]) ) {
            $tmp = 'set_'.$fld;
            $this->$tmp($params[$prefix.$fld]);
        }

        if( isset($params[$prefix.'first_name']) ) {
            $this->set_firstname($params[$prefix.'first_name']);
        }

        if( isset($params[$prefix.'last_name']) ) {
            $this->set_lastname($params[$prefix.'last_name']);
        }
    }
  }

  public function to_array($prefix = '')
  {
    $result = array();
    $result[$prefix.'company'] = $this->get_company();
    $result[$prefix.'first_name'] = $this->get_firstname();
    $result[$prefix.'last_name'] = $this->get_lastname();
    $result[$prefix.'address1'] = $this->get_address1();
    $result[$prefix.'address2'] = $this->get_address2();
    $result[$prefix.'city'] = $this->get_city();
    $result[$prefix.'state'] = $this->get_state();
    $result[$prefix.'postal'] = $this->get_postal();
    $result[$prefix.'country'] = $this->get_country();
    $result[$prefix.'phone'] = $this->get_phone();
    $result[$prefix.'fax'] = $this->get_fax();
    $result[$prefix.'email'] = $this->get_email();
    return $result;
  }
} // class


#
# EOF
#
?>