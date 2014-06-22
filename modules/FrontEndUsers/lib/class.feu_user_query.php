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

class feu_user_query_opt
{
  const MATCH_USERNAME    = '*username*';
  const MATCH_USERNAME_RE = '*username-re*';
  const MATCH_PASSWORD    = '*password*';
  const MATCH_EXPIRES_LT  = '*expires-lt*';
  const MATCH_GROUP       = '*group*';
  const MATCH_GROUPID     = '*gid*';
  const MATCH_PROPERTY    = '*property*';
  const MATCH_PROPERTY_RE = '*property-re*';
  const MATCH_USERLIST    = '*userlist*';
  const MATCH_USERNAMELIST = '*usernamelist*';
  const MATCH_LOGGEDIN    = '*loggedin*';
  const MATCH_CREATED_GE  = '*created_ge*';
  const MATCH_CREATED_LT  = '*created_lt*';

  private $_type;
  private $_expr;
  private $_opt;

  public function __construct($type,$expr,$opt = '')
  {
    if( empty($expr) ) throw new Exception('invalid value for expr');

    switch($type) {
    case self::MATCH_USERNAME:
    case self::MATCH_USERNAME_RE:
    case self::MATCH_PASSWORD:
    case self::MATCH_EXPIRES_LT:
    case self::MATCH_CREATED_GE:
    case self::MATCH_CREATED_LT:
    case self::MATCH_GROUP:
    case self::MATCH_GROUPID:
    case self::MATCH_USERLIST:
    case self::MATCH_USERNAMELIST:
    case self::MATCH_LOGGEDIN:
      $this->_type = $type;
      $this->_expr = $expr;
      break;

    case self::MATCH_PROPERTY_RE:
      if( empty($opt) ) throw new Exception('invalid opt value');

    case self::MATCH_PROPERTY:
      $this->_type = $type;
      $this->_expr = $expr;
      $this->_opt = $opt;
      break;

    default:
      throw new Exception('invalid value');
    }
  }
  
  public function get_type()
  {
    return $this->_type;
  }

  public function get_expr()
  {
    return $this->_expr;
  }

  public function get_opt()
  {
    return $this->_opt;
  }
} // class


class feu_user_query
{
  const RESULT_TYPE_ID = '*id*';
  const RESULT_TYPE_LIST = '*list*';
  const RESULT_TYPE_FULL = '*full*';
  const RESULT_SORTORDER_ASC = '*asc*';
  const RESULT_SORTORDER_DESC = '*desc*';
  const RESULT_SORTBY_USERNAME = '*username*';
  const RESULT_SORTBY_CREATED = '*createdate*';
  const RESULT_SORTBY_EXPIRES = '*expires*';

  private $_and_opts   = array();
  private $_groups = '';
  private $_pagelimit = 100000;
  private $_offset = 0;
  private $_result_type = self::RESULT_TYPE_ID;
  private $_sortby = self::RESULT_SORTBY_USERNAME;
  private $_sortorder = self::RESULT_SORTORDER_ASC;
  private $_deep = FALSE;
  private $_webready = FALSE;

  public function __construct()
  {
    // nothing here.
  }

  public function set_pagelimit($pagelimit)
  {
    $pagelimit = (int)$pagelimit;
    $pagelimit = max(1,$pagelimit);
    $this->_pagelimit = $pagelimit;
  }

  public function get_pagelimit()
  {
    return $this->_pagelimit;
  }

  public function set_offset($n)
  {
    $this->_offset = max(0,(int)$n);
  }

  public function get_offset()
  {
    return $this->_offset;
  }

  public function set_deep($flag = TRUE)
  {
    $this->_deep = (bool)$flag;
  }

  public function get_deep()
  {
    return $this->_deep;
  }

  public function set_webready($flag = TRUE)
  {
    $this->_webready = (bool)$flag;
  }

  public function get_webready()
  {
    return $this->_webready;
  }

  public function set_result_type($type)
  {
    switch( $type ) {
    case self::RESULT_TYPE_ID:
    case self::RESULT_TYPE_LIST:
    case self::RESULT_TYPE_FULL:
      $this->_result_type = $type;
      break;

    default:
      throw new CmsException('Invalid result type '.$type);
    }
  }

  public function get_result_type()
  {
    return $this->_result_type;
  }

  public function set_sortby($val)
  {
    switch( $val ) {
    case self::RESULT_SORTBY_USERNAME:
    case self::RESULT_SORTBY_CREATED:
    case self::RESULT_SORTBY_EXPIRES:
      $this->_sortby = $val;
      break;

    default:
      throw new CmsException('Invalid sortby value: '.$val);
    }
  }

  public function get_sortby()
  {
    return $this->_sortby;
  }
  
  public function set_sortorder($val)
  {
    switch( $val ) {
    case self::RESULT_SORTORDER_ASC:
    case self::RESULT_SORTORDER_DESC:
      $this->_sortorder = $val;
      break;

    default:
      throw new CmsException('Invalid sortorder value: '.$val);
    }
  }
  
  public function get_sortorder()
  {
    return $this->_sortorder;
  }
  
  public function add_and_opt($type,$value)
  {
    $this->_and_opts[] = new feu_user_query_opt($type,$value);
  }

  public function add_and_opt_obj(feu_user_query_opt& $opt)
  {
    $this->_and_opts[] = $opt;
  }

  public function count_opts()
  {
    return count($this->_and_opts);
  }

  public function get_opts()
  {
    return $this->_and_opts;
  }

  public function &execute()
  {
    $rs = new feu_user_query_resultset($this);
    return $rs;
  }

} // end of class



?>