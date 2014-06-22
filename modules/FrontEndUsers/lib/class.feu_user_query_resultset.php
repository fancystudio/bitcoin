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

final class feu_user_query_resultset
{
  private $_query;
  private $_executed;
  private $_rs;
  private $_found_rows;
  private $_groups;

  public function __construct(feu_user_query &$query)
  {
    $this->_query = $query;
    $this->_execute($query);
  }

  private function _get_groups()
  {
    if( !is_array($this->_groups) ) {
      $feu = cge_utils::get_module('FrontEndUsers');
      $tmp = $feu->GetGroupListFull();
      if( is_array($tmp) && count($tmp) ) $this->_groups = cge_array::to_hash($tmp,'groupname');
    }
    return $this->_groups;
  }

  private function _execute()
  {
    $db = cmsms()->GetDb();
    $where  = array();
    $qparms = array();
    $joins  = array();
    $jcount = 0;
    $having = null;

    $qrec = 'SELECT SQL_CALC_FOUND_ROWS u.*,count(li.userid) AS loggedin FROM '.cms_db_prefix().'module_feusers_users u';
    $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_feusers_loggedin li ON u.id = li.userid';

    foreach( $this->_query->get_opts() as $opt ) {
      switch( $opt->get_type() ) {
      case feu_user_query_opt::MATCH_USERNAME:
	$where[]  = 'u.username LIKE ?';
	$expr = str_replace('*','%',$opt->get_expr());
	$expr = str_replace('%%','%',$expr);
	$qparms[] = $expr;
	break;

      case feu_user_query_opt::MATCH_USERNAME_RE:
	$where[]  = 'u.username REGEXP '.$db->qstr($opt->get_expr());
	break;

      case feu_user_query_opt::MATCH_PASSWORD:
	$where[]  = 'u.password = ?';
	$qparms[] = $opt->get_expr();
	break;
	  
      case feu_user_query_opt::MATCH_EXPIRES_LT:
	$tmp = $db->DbTimeStamp($opt->get_expr());
	$where[] = "u.expires < {$tmp}";
	break;

      case feu_user_query_opt::MATCH_CREATED_GE:
	$tmp = $db->DbTimeStamp($opt->get_expr());
	$where[] = "u.createdate >= {$tmp}";
	break;

      case feu_user_query_opt::MATCH_CREATED_LT:
	$tmp = $db->DbTimeStamp($opt->get_expr());
	$where[] = "u.createdate < {$tmp}";
	break;

      case feu_user_query_opt::MATCH_GROUP:
	$tmp = $this->_get_groups();
	if( !isset($tmp[$opt->get_expr()]) ) {
	  throw new Exception('invalid value');
	}
	$joins[] = 'LEFT JOIN '.cms_db_prefix().'module_feusers_belongs bl ON u.id = bl.userid';
	$where[] = 'bl.groupid = ?';
	$qparms[] = $opt->get_expr();
	break;

      case feu_user_query_opt::MATCH_LOGGEDIN:
	$having = 'count(li.userid) > 0';
	break;

      case feu_user_query_opt::MATCH_GROUPID:
	$expr = $opt->get_expr();
	if( is_array($expr) ) {
	  $tmp = array();
	  foreach( $expr as $one ) {
	    $one = (int)$one;
	    if( $one < 1 ) continue;
	    if( !in_array($one,$tmp) ) $tmp[] = $one;
	  }
	  if( count($tmp) == 0 ) throw new Exception('No valid group ids specified');
	  $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_feusers_belongs bl ON u.id = bl.userid';
	  $where[] = 'bl.groupid IN ('.implode(',',$tmp).')';
	}
	else {
	  $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_feusers_belongs bl ON u.id = bl.userid';
	  $where[] = 'bl.groupid = ?';
	  $qparms[] = $expr;
	}
	break;

      case feu_user_query_opt::MATCH_USERNAMELIST:
	$tmp = $opt->get_expr();
	if( !is_array($tmp) ) $tmp = explode(',',$tmp);
	$tmp2 = array();
	foreach( $tmp as $one ) {
	  $tmp2[] = "'".trim($one)."'";
	}
	$tmp2 = array_unique($tmp2);
	$where[] = 'u.username IN ('.implode(',',$tmp2).')';
	break;

      case feu_user_query_opt::MATCH_USERLIST:
	$tmp = $opt->get_expr();
	if( !is_array($tmp) ) $tmp = explode(',',$tmp);
	$tmp2 = array();
	foreach( $tmp as $one ) {
	  if( (int)$one < 1 ) continue;
	  $tmp2[] = (int)$one;
	}
	$tmp2 = array_unique($tmp2);
	$where[] = 'u.id IN ('.implode(',',$tmp2).')';
	break;
      
      case feu_user_query_opt::MATCH_PROPERTY:
	$feu = cge_utils::get_module('FrontEndUsers');
	$defns = $feu->GetPropertyDefns();
	if( !in_array($opt->get_expr(),array_keys($defns)) ) throw new Exception('invalid value');
	$jcount++;
	$joins[] = 'LEFT JOIN '.cms_db_prefix()."module_feusers_properties pr{$jcount}
                    ON pr{$jcount}.userid = u.id";
        $where[] = "pr{$jcount}.title = '".$opt->get_expr()."'";
	if( $opt->get_opt() ) {
	  if( strstr($opt->get_opt(),'*') === FALSE ) {
	    $where[] = "pr{$jcount}.data = '".$opt->get_opt()."'";
	  }
	  else {
	    $where[] = "pr{$jcount}.data LIKE '".str_replace('*','%',$opt->get_opt())."'";
	  }
	}
	break;

      case feu_user_query_opt::MATCH_PROPERTY_RE:
	$feu = cge_utils::get_module('FrontEndUsers');
	$defns = $feu->GetPropertyDefns();
	if( !in_array($opt->get_expr(),array_keys($defns)) ) {
	  throw new Exception('invalid value');
	}
	$jcount++;
	$joins[] = 'LEFT JOIN '.cms_db_prefix()."module_feusers_properties pr{$jcount} 
                      ON pr{$jcount}.userid = u.id 
                     AND pr{$jcount}.title = '".$opt->get_expr()."'";
	$where[] = "pr{$jcount}.data REGEXP ".$db->qstr($opt->get_opt());
	break;
      }
    }

    // assembly
    if( count($joins) ) $qrec .= ' '.implode(' ',$joins);
    if( count($where) ) $qrec .= "\nWHERE ".implode(' AND ',$where);

    $orderby = 'username';
    switch( $this->_query->get_sortby() ) {
    case feu_user_query::RESULT_SORTBY_USERNAME:
      $orderby = 'username';
      break;
    case feu_user_query::RESULT_SORTBY_CREATED:
      $orderby = 'createdate';
      break;
    case feu_user_query::RESULT_SORTBY_EXPIRES:
      $orderby = 'expires';
      break;
    }

    switch( $this->_query->get_sortorder() ) {
    case feu_user_query::RESULT_SORTORDER_ASC:
      $orderby .= ' ASC';
      break;
    case feu_user_query::RESULT_SORTORDER_DESC:
      $orderby .= ' DESC';
      break;
    }

    $qrec .= ' GROUP BY u.id';
    if( $having ) $qrec .= ' HAVING '.$having;
    $qrec .= ' ORDER BY '.$orderby;

    $this->_rs = $db->SelectLimit($qrec,$this->_query->get_pagelimit(),$this->_query->get_offset(),$qparms);
    if( !$this->_rs ) throw new Exception('INTERNAL ERROR: Query failed - '.$db->sql.' -- '.$db->ErrorMsg());

    $uids = array();
    while( !$this->_rs->EOF ) {
      feu_user_cache::set_new_user($this->_rs->fields);
      $uids[] = $this->_rs->fields['id'];
      $this->_rs->MoveNext();
    }
    $this->_rs->MoveFirst();
    
    if( count($uids) && $this->_query->get_deep() ) {
      // users are already loaded (shallow)... this will get property information.
      feu_user_cache::load_users($uids,TRUE);
    }

    $this->_found_rows = $db->GetOne('SELECT FOUND_ROWS()');
    $this->_executed = TRUE;
  }

  public function RecordCount()
  {
    if( $this->_rs ) return $this->_rs->RecordCount();
    return 0;
  }

  public function MoveNext()
  {
    if( $this->_rs ) return $this->_rs->MoveNext();
    return FALSE;
  }

  public function MoveFirst()
  {
    if( $this->_rs ) return $this->_rs->MoveFirst();
    return FALSE;
  }

  public function EOF()
  {
    if( $this->_rs ) return $this->_rs->EOF();
    return TRUE;
  }

  public function Close()
  {
    if( $this->_rs ) return $this->_rs->Close();
    return TRUE;
  }

  public function __get($key)
  {
    if( $key == 'EOF' && $this->_rs ) return $this->_rs->EOF;
    
    if( $key == 'fields' && $this->_rs ) {
      $rec = feu_user_cache::get_user($this->_rs->fields['id']);
      if( $this->_query->get_webready() ) {
	unset($rec['password']);
	$feu = cms_utils::get_module('FrontEndUsers');
  	$defns = $feu->GetPropertyDefns();
	if( isset($rec['fprops']) ) {
	  foreach( $rec['fprops'] as &$one ) {
	    if( $defns[$one['title']]['type'] == FrontEndUsers::FIELDTYPE_IMAGE ) {
	      // get the full url.
	      $config = cmsms()->GetConfig();
	      $one['url'] = $config['uploads_url'].'/feusers/'.$one['data'];
	    }
	  }
	}
      }
      return $rec;
    }
  }

  public function get_found_rows()
  {
    if( !$this->_rs ) return;
    return $this->_found_rows;
  }

} // class

?>