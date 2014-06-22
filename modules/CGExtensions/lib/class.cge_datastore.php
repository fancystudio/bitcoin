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

class cge_datastore
{
  private $_expiry;
  private $_last_cleanup;
  private $_cleanup_interval;

  public function __construct($expiry = 3600,$cleanup_interval = '')
  {
    $expiry = max(1,$expiry);

    $this->_expiry = $expiry;
    if( empty($cleanup_interval) )
      {
	$cleanup_interval = $expiry;
      }
    $this->_cleanup_interval = $cleanup_interval;
    $this->_last_cleanup = -1;
  }

  public function set_expiry($num)
  {
    $num = max($num,30);
    $this->_expiry($num);
  }

  public function remove_expired()
  {
    $now = time();
    if( ($now - $this->_last_cleanup) > $this->_cleanup_interval )
      {
	$db = cmsms()->GetDb();
	$query = 'DELETE FROM '.CGEXTENSIONS_TABLE_ASSOCDATA.'
               WHERE expiry < NOW() AND expiry != -1';
	$db->Execute($query);

	$this->_last_cleanup = $now;
      }
  }


  public function erase($key1,$key2 = '',$key3 = '', $key4 = '')
  {
    $db = cmsms()->GetDb();
    $query = 'DELETE FROM '.CGEXTENSIONS_TABLE_ASSOCDATA.'
               WHERE key1 = ? AND key2 = ? AND key3 = ? AND key4 = ?';
    $db->Execute($query,array($key1,$key2,$key3,$key4));

    $this->remove_expired();
  }


  public function store($data,$key1,$key2='',$key3='',$key4='')
  {
    if( empty($data) ) return FALSE;

    $this->erase($key1,$key2,$key3,$key4);

    $query = 'INSERT INTO '.CGEXTENSIONS_TABLE_ASSOCDATA."
                (key1,key2,key3,key4,data,expiry,create_date,modified_date)
              VALUES (?,?,?,?,?,DATE_ADD(NOW(),INTERVAL ? SECOND),NOW(),NOW())";
    $db = cmsms()->GetDb();
    $dbr = $db->Execute($query,array($key1,$key2,$key3,$key4,$data,$this->_expiry));
    if( !$dbr )
      {
	echo "FATAL: ".$db->sql."<br/>".$db->ErrorMsg().'<br/>'; die();
      }
    $this->remove_expired();
    return TRUE;
  }
  

  public function get($key1,$key2 = '',$key3 = '', $key4 = '')
  {
    $this->remove_expired();
    $query = 'SELECT data FROM '.CGEXTENSIONS_TABLE_ASSOCDATA.'
               WHERE key1 = ? AND key2 = ? AND key3 = ? AND key4 = ?
                 AND expiry > NOW() ORDER BY modified_date LIMIT 1';
    $db = cmsms()->GetDb();
    $tmp = $db->GetOne($query,array($key1,$key2,$key3,$key4));
    if( !$tmp ) return FALSE;
    return $tmp;
  }


  public function listall($key1,$key2 = '',$key3 = '')
  {
    $parms = array();
    $where[] = array();

    $where[] = 'key1 = ?';
    $parms[] = $key1;

    $query = 'SELECT key1,key2,key3,key4 FROM '.CGEXTENSIONS_TABLE_ASSOCDATA;
    if( !empty($key2) )
      {
	$where[] = 'key2 = ?';
	$parms[] = $key2;

	if( !empty($key3) )
	  {
	    $where[] = 'key3 = ?';
	    $parms[] = $key3;
	  }
      }

    if( count($where) )
      {
	$query .= ' WHERE ' + implode(' AND ',$where);
      }
    $db = cmsms()->GetDb();
    $data = $db->GetArray($query,$parms);
    if( !$data ) return FALSE;
    return $data;
  }

  
}

?>