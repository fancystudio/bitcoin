<?php // -*- mode:php; c-file-style:linux; tab-width:2; indent-tabs-mode:t; c-basic-offset: 2; -*-
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This projects homepage is: http://www.cmsmadesimple.org
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

class FrontEndUsersManipulator extends UserManipulator
{
    private $_cached_propdefns;
    private $_encryption_key;
    private $_groupinfo_cache;
    private $_multiselect_options;
    private $_useridbyname;
    private $_grouppropmap;
    private $_last_userquery_matches;
    private $_last_userquery_count;

    private $_hasrun1 = null;
    private $_hasrun2 = null;
    private $_readdata1 = null;
    private $_hasread1 = null;

    private function get_salt()
    {
        $mod = $this->GetModule();
        return $mod->GetPreference('pwsalt','');
    }

    public function add_history($uid,$message)
    {
        if( $uid <= 0 || !is_string($message) || $message == '' )	return FALSE;

        $db = $this->GetDb();
        $now = $db->DbTimeStamp(time());
        $query = 'INSERT INTO '.cms_db_prefix()."module_feusers_history (userid,sessionid,action,refdate,ipaddress) VALUES (?,?,?,$now,?)";
        $ip = cge_utils::get_real_ip();
        $dbr = $db->Execute($query,array($uid,session_id(),$message,$ip));
        return TRUE;
    }

    function SetEncryptionKey($uid = -1,$force = FALSE )
    {
        global $CMS_ADMIN_PAGE;
        $gCms = cmsms();

        if( $CMS_ADMIN_PAGE ) {
// an administrator can see encrypted data.
            $res = $this->GetUserInfo($uid);
            if( !is_array($res) || $res[0] == FALSE ) return FALSE;

            $key = md5($gCms->config['root_url'].$uid.$res[1]['createdate'].$this->get_salt());
            $this->_encryption_key = $key;

            return TRUE;
        }
        else {
            $tuid = $this->LoggedInId();
            if( ($tuid != $uid || $tuid <= 0) && $force === FALSE ) return FALSE;

            $res = $this->GetUserInfo($uid);
            if( !is_array($res) || $res[0] == FALSE ) return FALSE;

            $key = md5($gCms->config['root_url'].$uid.$res[1]['createdate'].$this->get_salt());
            $this->_encryption_key = $key;
            return TRUE;
        }

        return FALSE;
    }

    function DecryptUserData($uid,$data)
    {
        $uid = (int)$uid;
        if( $uid < 1 ) return;
        $this->SetEncryptionKey($uid,TRUE);
        $x = trim(cge_encrypt::decrypt($this->_encryption_key,base64_decode($data)));
        return $x;
    }

    function CountTempCodeRecords()
    {
        $db = $this->GetDB();
        $q = "SELECT COUNT(*) AS count FROM ".cms_db_prefix()."module_feusers_tempcode";
        $dbresult = $db->Execute( $q );
        if( !$dbresult ) return 0;
        $row = $dbresult->FetchRow();
        return $row['count'];
    }

    function ExpireTempCodes($expirycode)
    {
        $db = $this->GetDb();
        $expires = strtotime( $expirycode );
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_tempcode WHERE created > ?";
        $dbresult = $db->Execute( $q, array( $expires ) );
        if( !$dbresult ) return false;
        return true;
    }

    function RemoveUserTempCode( $uid )
    {
        if( !$uid ) return false;
        $db = $this->GetDb();
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_tempcode WHERE userid = ?";
        $dbresult = $db->Execute( $q, array( $uid ) );
        if( !$dbresult ) return false;
        return true;
    }


    function GetUserTempCode( $uid )
    {
        if( !$uid ) return false;
        $db = $this->GetDb();
        $q = "SELECT * FROM ".cms_db_prefix()."module_feusers_tempcode WHERE userid = ?";
        $dbresult = $db->Execute( $q, array( $uid ));
        if( $dbresult == FALSE || $dbresult->RecordCount() == 0 ) return array(FALSE,$db->ErrorMsg());
        $row = $dbresult->FetchRow();
        return array(TRUE,$row);
    }


    function SetUserTempCode( $uid, $code, $replace=false )
    {
        if( !$uid ) return false;
        $db = $this->GetDb();
        $q = "INSERT INTO ".cms_db_prefix()."module_feusers_tempcode VALUES(?,?,?)";
        $dbresult = $db->Execute( $q, array( $uid, $code,
        trim($db->DBTimeStamp(time()),"'") ) );

        if( $dbresult == false ) {
            if ($replace) {
                $q = "update ".cms_db_prefix()."module_feusers_tempcode set code=?, created=? WHERE userid=?";
                $dbresult = $db->Execute( $q, array($code,
                trim($db->DBTimeStamp(time()),"'"),$uid ) );
                if ($dbresult == false) return false;
            }
            else {
                return false;
            }
        }
        return true;
    }


    function SetPropertyDefn( $name, $newname, $prompt, $length, $type, $maxlength = 0, $attribs = '', $force_unique = 0, $encrypt = 0 )
    {
        $db = $this->getDb();

        if( $maxlength == 0 ) $maxlength = $length;
        $q = "UPDATE ".cms_db_prefix()."module_feusers_propdefn
          SET name = ?, prompt = ?, type = ?, length = ?, maxlength = ?, attribs = ?, force_unique = ?, encrypt = ?
          WHERE name = ?";
        $dbresult = $db->Execute( $q, array( $newname, $prompt, $type, $length, $maxlength, $attribs, $force_unique, $encrypt, $name ));
        if( !$dbresult ) return false;
        return true;
    }


    function DeletePropertyDefn( $name, $full = FALSE )
    {
        $db = $this->GetDb();

        if( $full ) {
            $q = 'DELETE FROM '.cms_db_prefix().'module_feusers_properties WHERE title = ?';
            $dbr = $db->Execute($q,array($name));

            $query = 'SELECT group_id,sort_key FROM '.cms_db_prefix().'module_feusers_grouppropmap WHERE name = ?';
            $dbr = $db->GetArray($query,array($name));

            if( is_array($dbr) && count($dbr) ) {
                $q = 'UPDATE '.cms_db_prefix().'module_feusers_grouppropmap
              SET sort_key = sort_key - 1
              WHERE group_id = ? AND sort_key > ?';
                foreach( $dbr as $row ) {
                    $db->Execute($query,array($row['group_id'],$row['sort_key']));
                }
            }

            $q = 'DELETE FROM '.cms_db_prefix().'module_feusers_grouppropmap WHERE name = ?';
            $dbr = $db->GetArray($query,array($name));

        }

        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_propdefn WHERE name=?";
        $dbresult = $db->Execute( $q, array( $name ) );
        if( !$dbresult ) return false;
        return true;
    }


    function GetPropertyGroupRelations( $title )
    {
        $db = $this->GetDb();

        $q = "SELECT * FROM ".cms_db_prefix()."module_feusers_grouppropmap WHERE name = ? ORDER BY sort_key DESC";
        $dbresult = $db->Execute( $q, array( $title ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        $result = array();
        while( $row = $dbresult->FetchRow() ) {
            array_push( $result, $row );
        }
        return $result;
    }


/**
 * Return the unix timestamp of the users expiry date
 * or false;
 */
    function GetExpiryDate($uid)
    {
        if( !$uid ) return false;
        $res = feu_user_cache::get_user($uid);
        if( is_array($res) && $res['expires'] != '' ) {
            $db = $this->GetDb();
            return $db->UnixTimeStamp($res['expires']);
        }
        return false;
    }


    function IsAccountExpired( $uid )
    {
        if( !$uid ) return true; // dunno about this
        $expiry = $this->GetExpiryDate( $uid );

        if( !$expiry ) return true;
        if( $expiry < time() ) return true;
        return false;
    }


    function GetUserPropertyRelations( $uid )
    {
        $groups = $this->GetMemberGroupsArray($uid);
        if( !is_array($groups) || count($groups) == 0 ) return;

        $uprops = array();
        for( $a = 0; $a < count($groups); $a++ ) {
            $gid = $groups[$a]['groupid'];
            $relns = $this->GetGroupPropertyRelations($gid);
            $uprops = RRUtils::array_merge_by_name_required($uprops,$relns);
            usort($uprops, array('cge_array','compare_elements_by_sortorder_key'));
        }
        return $uprops;
    }

    function GetGroupPropertyRelations( $grpid )
    {
        if( !is_array($this->_grouppropmap) ) {
            $db = $this->GetDb();
            $q = "SELECT * FROM ".cms_db_prefix()."module_feusers_grouppropmap ORDER BY group_id,sort_key DESC";
            $this->_grouppropmap = $db->GetArray($q);
            if( !$this->_grouppropmap ) return array(FALSE,$db->ErrorMsg());
        }

        $res = array();
        for( $i = 0; $i < count($this->_grouppropmap); $i++ ) {
            $row = $this->_grouppropmap[$i];
            if( $row['group_id'] < $grpid ) continue;
            if( $row['group_id'] > $grpid ) break;

            $res[] = $row;
        }
        if( !count($res) ) return array(FALSE,'notfound');

        return $res;
    }


    function AddGroupPropertyRelation( $grpid, $propname, $sortkey, $lostun, $val )
    {
        $db = $this->GetDb();

        $q = "INSERT INTO ".cms_db_prefix()."module_feusers_grouppropmap VALUES(?,?,?,?,?)";
        $dbresult = $db->Execute( $q, array( $propname, $grpid, $sortkey, $val, $lostun ));
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        return array(TRUE);
    }


    function DeleteAllGroupPropertyRelations( $grpid )
    {
        $db = $this->GetDb();

        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_grouppropmap WHERE group_id = ?";
        $dbresult = $db->Execute( $q, array( $grpid ));
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        return array(TRUE);
    }


    function DeleteGroupPropertyRelation( $grpid, $propname )
    {
        $db = $this->GetDb();

        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_grouppropmap
          WHERE name = ? AND group_id = ?";
        $dbresult = $db->Execute( $q, array( $propname, $grpid ));
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        return array(TRUE);
    }


    function AddPropertyDefn( $name, $prompt, $type, $length, $maxlength = 0, $attribs = '', $force_unique = 0, $encrypt = 0 )
    {
        $db = $this->GetDb();
        if( $maxlength == 0 ) $maxlength == $length;

        $p = array( $name, $prompt, $type, $length, $maxlength, $attribs, $force_unique, $encrypt );
        $q = "INSERT INTO ".cms_db_prefix()."module_feusers_propdefn
          (name,prompt,type,length,maxlength,attribs,force_unique,encrypt)
          VALUES (?,?,?,?,?,?,?,?)";
        $dbresult = $db->Execute( $q, $p );
        if( $dbresult == false ) return array(FALSE, $db->sql.'<br/>'.$db->ErrorMsg());
        $new_id = $db->Insert_ID();

        $this->_cached_propdefn = null;
        return array(TRUE);
    }

    function SetPropertyDefnExtra($name,$extra)
    {
        if( is_array($extra) ) $extra = serialize($extra);
        $db = cmsms()->GetDb();
        $query = 'UPDATE '.cms_db_prefix().'module_feusers_propdefn SET extra = ? WHERE name = ?';
        $dbr = $db->Execute($query,array($extra,$name));
    }

    function AddSelectOptions( $name, $options )
    {
        $db = $this->GetDb();
        $insert_vals = '';
        $order_id = 0;
        foreach ($options as $opttext){
// if no actual text in the line, make sure it equals '',
// in order not to add it to the db
            $opttext = trim($opttext);
            if(trim($opttext) == '' || trim($opttext) == '__' ) continue;

            $optname = trim($opttext);
            if( strchr( $opttext, '=' ) !== FALSE ) {
                $tmp = explode('=',$opttext,2);
                $optname = trim($tmp[1]);
                $opttext = trim($tmp[0]);
            }

            $order_id++;
            $insert_vals .= "('"
                . $order_id . "', '"
                . $optname . "', '"
                . $opttext . "', '"
                . $name. "'), ";
        }

        $insert_vals = substr($insert_vals, 0, -2);

        $db = $this->getDb();
        $query = "INSERT INTO ".cms_db_prefix()."module_feusers_dropdowns
			(order_id, option_name, option_text, control_name)
			VALUES " . $insert_vals;
        $dbresult = $db->Execute($query);
        if( $dbresult == false ) return array(FALSE, $db->ErrorMsg());

        $this->_multiselect_options = null;
        return array(TRUE);
    }



    function DeletePropertyDefns()
    {
        $db = $this->GetDb();
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_propdefn";
        $dbresult = $db->Execute( $q );
        if( $dbresult == false ) return array(FALSE,$db->ErrorMsg());
        $this->_cached_propdefn = null;
        return array(TRUE);
    }


    function DeleteSelectOptions( $name )
    {
        $db = $this->GetDb();
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_dropdowns WHERE control_name = ?";
        $dbresult = $db->Execute( $q, array( $name ) );
        if( $dbresult == false ) return array(FALSE,$db->ErrorMsg());
        $this->_multiselect_options = null;
        return array(TRUE);
    }


    function GenerateRandomUsername( $prefix = 'user' )
    {
        srand(time());
        $db = $this->GetDb();
        $mod = $this->GetModule();

        $num = rand(100,99999);
        $count = 0;
        $suffix = '';
        if ($mod->GetPreference("username_is_email")) $suffix = '@sample.com';
        while( $count < 100 ) { // todo, 100 should be configurable?
            $q = "SELECT id FROM ".cms_db_prefix()."module_feusers_users WHERE username = ?";
            $tmp = $db->GetOne( $q, array( $prefix.$num.$suffix ) );
            if( !$tmp ) return $prefix.$num.$suffix;
            $num = rand(100,99999);
            ++$count;
        }
        return false;
    }


    function ClearPropertyCache()
    {
        unset($this->_cached_propdefns);
    }


    function _cache_propertydefns()
    {
        if( !is_array($this->_cached_propdefns) ) {
            $db = $this->GetDb();
            $this->_cached_propdefns = array();

            $query = 'SELECT * FROM '.cms_db_prefix().'module_feusers_propdefn';
            $data = $db->GetArray($query);
            if( !$data ) return;

            for( $i = 0; $i < count($data); $i++ ) {
                if( isset($data[$i]['extra']) ) $data[$i]['extra'] = unserialize($data[$i]['extra']);
                $this->_cached_propdefns[$data[$i]['name']] = $data[$i];
            }
        }
    }


    function GetPropertyDefn( $name )
    {
        $this->_cache_propertydefns();
        if( !is_array($this->_cached_propdefns) ) return FALSE;
        if( !isset($this->_cached_propdefns[$name])) return FALSE;
        return $this->_cached_propdefns[$name];
    }


    function GetPropertyDefns()
    {
        $this->_cache_propertydefns();
        if( !is_array($this->_cached_propdefns) ) return FALSE;
        return $this->_cached_propdefns;
    }

/**
 * Returns select options as a simple or a 2 dimensional array
 *
 * @param String $controlname - name of the dropdown as in the propdefn table
 * @param int $dim - dimension of the array
 * 	if $dim == 1, returns a 1 dimensional array text=>name
 *    if $dim == 2, returns a 2 dimensional array, each item being an
 * 		array with properties 'option_name', 'option_text', 'control_name'.
 */
    function GetSelectOptions( $controlname, $dim=1 )
    {
        if( !$this->_multiselect_options ) {
            $db = $this->GetDb();

            $q = "SELECT * FROM ".cms_db_prefix()."module_feusers_dropdowns ORDER BY order_id";
            $dbr = $db->GetArray($q);
            if( is_array($dbr) ) $this->_multiselect_options = $dbr;
        }

        if( !count($this->_multiselect_options) ) return false;

        $ret = array();
        for( $i = 0; $i < count($this->_multiselect_options); $i++ ) {
            $row = $this->_multiselect_options[$i];

            if( $row['control_name'] == $controlname ) {
                if( $dim == 2 ) {
                    $ret[] = $row;
                }
                else {
                    $ret[trim($row['option_text'])] = trim($row['option_name']);
                }
            }
        }
        if( !count($ret) ) return false;

        return $ret;
    }


    function Login( $username, $password, $groups = '', $md5pw = false, $force_logout = false)
    {
        $error = '';
        $uid = -1;
        $gCms = cmsms();
        $db = $this->GetDb();
        $mod = $this->GetModule();
        $config = $gCms->GetConfig();

        if( !$this->CheckPassword( $username, $password, $groups, $md5pw ) ) {
            $uid = $this->GetUserID( $username );
            if( !$uid ) $uid = -1;
            $error = $mod->Lang('error_loginfailed');
            $this->add_history($uid,'fail');
            return array(FALSE,$error);
        }
        else {
            $uid = $this->GetUserID( $username );
            if( $force_logout ) $this->Logout($uid);

            if( $this->IsAccountExpired( $uid ) ) {
                return array(FALSE,$mod->Lang('error_accountexpired'));
            }
            else if( $mod->GetPreference('allow_repeated_logins') == 0 ) {
// make sure this user isn't already logged in
                $q = "SELECT * FROM ".cms_db_prefix()."module_feusers_loggedin WHERE USERID = ?";
                $dbresult = $db->Execute( $q, array( $uid ) );
                if( $dbresult && $dbresult->RecordCount() ) {
                    $error = $mod->Lang('error_norepeatedlogins');
                    return array(FALSE,$error);
                }
            }
        }

        $this->__reset();
        $this->_set_saved_logindetails($uid);

// and add history info
        $this->add_history($uid,'login');

// send the event.
        $ip = cge_utils::get_real_ip();
        $module = $this->GetModule();
        $module->SendEvent('OnLogin',array('id'=>$uid,'username'=>$username,'ip'=>$ip));

        return array($uid);
    }


    function FeusersManipulator( $the_module )
    {
        parent::UserManipulator( $the_module );
    }


// userid api function
// returns true/false
    function AssignUserToGroup( $uid, $gid )
    {
        if( !$uid ) return false;
        // validate the user id
        if( !$this->UserExistsByID( $uid ) ) return false;

        // validate the group id
        if( !$this->GroupExistsByID( $gid ) ) return false;

        $db = $this->GetDb();
        // make sure it already doesn't exist
        $q = 'SELECT * FROM '.cms_db_prefix().'module_feusers_belongs WHERE userid = ? AND groupid = ?';
        $tmp = $db->GetRow($q,array($uid,$gid));
        if( $tmp ) return true;

        // add the record to the table to make this
        // user a member of this group
        $q = "INSERT INTO ".cms_db_prefix()."module_feusers_belongs (userid, groupid) VALUES (?,?)";
        $dbresult = $db->Execute( $q, array( $uid, $gid ) );
        return( $dbresult != false );
    }


// userid api function
// returns true/false
    function IsValidPassword( $password )
    {
        // a password is valid, if it's length is
        // within certain ranges
        $module = $this->GetModule();
        $minlen = $module->GetPreference('min_passwordlength', 6 );
        $maxlen = $module->GetPreference('max_passwordlength', 20 );
        $len = strlen($password);
        if( $len < $minlen ) {
            return false;
        }
        else if( $len > $maxlen ) {
            return false;
        }

        return true;
    }


// userid api function
// returns an array
    function DeleteUserFull( $id )
    {
        // log the user out
        $this->LogoutUser( $id );

        // delete user properties
        $this->DeleteAllUserPropertiesFull( $id );

        // delete user from groups
        $ret = $this->RemoveUserFromGroup( $id, '' );
        if( $ret[0] == false ) return $ret;

        // delete user record
        $db = $this->GetDb();
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_users WHERE id = ?";
        $dbresult = $db->Execute( $q, array( $id ) );
        if( !$dbresult ) return array( FALSE, $db->ErrorMsg() );

        // and delete anything from the tempcodes table too
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_tempcode WHERE userid = ?";
        $dbresult = $db->Execute( $q, array( $id ) );
        if( !$dbresult ) return array( FALSE, $db->ErrorMsg() );

        $this->_useridbyname = array();
        feu_user_cache::del_user($id);
        return array( TRUE, "" );
    }


    private function _get_groupinfo($with_count = false)
    {
        if( !is_array($this->_groupinfo_cache) ) {
            $auth_consumer = feu_utils::get_auth_consumer();
            if( $auth_consumer->has_capability($auth_consumer::CAPABILITY_LISTGROUPS) ) {
                $tmp = $auth_consumer->get_group_list(TRUE);
                $out = array();
                foreach( $tmp as $gid => $rec ) {
                    $tmp2 = array('id'=>$gid,'groupdesc'=>'');
                    if( is_string($rec) && !is_array($rec) ) {
                        $tmp2['groupname'] = $rec;
                    }
                    else if ( isset($rec['name']) ) {
                        $tmp2['groupname'] = $rec['name'];
                    }
                    else if ( isset($rec['groupname']) ) {
                        $tmp2['groupname'] = $rec['groupname'];
                    }
                    else {
                        continue;
                    }

                    if( is_array($rec) ) {
                        if( isset($rec['desc']) ) {
                            $tmp2['groupdesc'] = $rec['desc'];
                        }
                        else if( isset($rec['description']) ) {
                            $tmp2['groupdesc'] = $rec['description'];
                        }
                        else if( isset($rec['groupdesc']) ) {
                            $tmp2['groupdesc'] = $rec['groupdesc'];
                        }

                        if( isset($rec['count']) ) $tmp2['count'] = $rec['count'];
                    }

                    $out[$gid] = $tmp2;
                }
                $this->_groupinfo_cache = $out;
                return;
            }

            // the consumer does not provide group info.... so we gotta list em.
            $db = $this->GetDb();
            $query = 'SELECT * FROM '.cms_db_prefix().'module_feusers_groups';
            if( $with_count ) {
                $query = 'SELECT g.*,count(b.userid) AS count FROM '.cms_db_prefix().'module_feusers_groups g
                  LEFT JOIN '.cms_db_prefix().'module_feusers_belongs b
                  ON g.id = b.groupid GROUP BY g.id';
            }
            $dbr = $db->GetArray($query);
            if( is_array($dbr) ) $this->_groupinfo_cache = cge_array::to_hash($dbr,'id');
        }
    }


// userid api function
// returns an array
    function GetGroupInfo( $gid )
    {
        $this->_get_groupinfo();
        if( is_array($this->_groupinfo_cache) && isset($this->_groupinfo_cache[$gid]) ) return $this->_groupinfo_cache[$gid];
    }

/**
 * Return an array of user information
 *
 * @param array An array of integer user ids
 * @param booolean flag indicating wether to return property information
 * @return array of user info.  Or null.
 * @deprecated
 */
    function GetBulkUserInfo( $uids, $deep = TRUE )
    {
        feu_user_cache::load_users($uids,$deep);

        $out = array();
        foreach( $uids as $one ) {
            $one = (int)$one;
            if( $one < 1 ) continue;
            $t = feu_user_cache::get_user_noload($one);
            if( is_array($t) ) $out[] = $t;
        }
        return $out;
    }

// userid api function
// returns an array
// second element of array may be an array
    function GetUserInfo( $uid, $deep = FALSE )
    {
        if( !$uid ) return array(FALSE); // todo, add a message
        $row = feu_user_cache::get_user($uid,$deep);
        if( !is_array($row) ) return array(FALSE);
        return array( TRUE, $row );
    }


// userid api function
// returns an array
// second element of array may be an array
    function GetUserInfoByName( $username )
    {
        if( !$username ) return array(FALSE); // todo, add a message

        $uid = $this->GetUserID($username);
        if( !$uid ) {
            $module = $this->GetModule();
            return array(FALSE,$module->Lang('error_usernotfound'));
        }
        return $this->GetUserInfo($uid);
    }


    function GetUserInfoByProperty($propname,$propvalue = null)
    {
        // note... cannot work on encrypted properties.
        $module = $this->GetModule();
        $defns = $this->GetPropertyDefns();
        if( !is_array($defns) ) return array(FALSE,$module->Lang('error_dberror'));
        if( !isset($defns[$propname]) ) return array(FALSE,$module->Lang('error_dberror'));
        if( $defns[$propname]['encrypt'] ) return array(FALSE,$module->Lang('error_dberror'));

        $db = $this->GetDb();
        $parms = array($propname);
        $query = 'SELECT userid FROM '.cms_db_prefix().'module_feusers_properties up WHERE up.title = ? AND data = ?';

        if( !is_null($propvalue) ) {
            $query .= ' AND data = ?';
            $parms[] = $propvalue;
        }
        $uid = $db->GetOne($query,$parms);
        if( !$uid ) return array(FALSE,$module->Lang('error_usernotfound'));

        return $this->GetUserInfo( $uid );
    }


    function GetUserHistory($uid,$action='',$count=-1)
    {
        $db = $this->GetDb();
        $parms = array($uid);
        $query = 'SELECT * FROM '.cms_db_prefix().'module_feusers_history WHERE userid = ?';
        if( !empty($action) ) {
            $query .= ' AND action = ?';
            $parms[] = $action;
        }

        $results = '';
        if( $count <= 0 ) {
            $results = $db->GetArray($query,$parms);
        }
        else {
            $dbr = $db->SelectLimit($query,(int)$count);
            while( $dbr && ($row = $dbr->FetchRow()) ) {
                $results[] = $row;
            }

            if( count($results) == 1 ) {
                $tmp = $results[0];
                $results = $tmp;
            }
        }
        return $results;
    }


    public function GetLoggedInUsers($not_active_since = '')
    {
        $db = $this->GetDb();

        $q = 'SELECT userid FROM '.cms_db_prefix().'module_feusers_loggedin';
        $qparms = array();
        if( $not_active_since ) {
            $q .= " WHERE lastused < ?";
            $qparms[] = $not_active_since;
        }

        $res = $db->GetCol($q,$qparms);
        return $res;
    }


// userid api function
// returns an array or false
    function CountUsersInGroup( $groupid )
    {
        $db = $this->GetDb();

        $q = '';
        $parms = array();
        if( $groupid == '' || $groupid < 0 ) {
            $q = "SELECT count(id) as num FROM ".cms_db_prefix()."module_feusers_users";
        }
        else {
            $q = "SELECT count(id) as num FROM ".cms_db_prefix()."module_feusers_users,".
                cms_db_prefix()."module_feusers_belongs WHERE id=userid AND groupid = ?";
            $parms[] = $groupid;
        }

        $dbresult = $db->Execute( $q, $parms );
        if( !$dbresult ) return false;

        $row = $dbresult->FetchRow();
        return $row['num'];
    }


/**
 * Replace this code with a user query
 */
    function GetFullUsersInGroup($gid)
    {
        $db = $this->GetDb();
        $query = 'SELECT userid FROM '.cms_db_prefix().'module_feusers_belongs WHERE groupid = ?';
        $tmp = $db->GetCol($query,array($gid));
        if( !$tmp ) return FALSE;

        feu_user_cache::load_users($tmp,TRUE);
        $out = array();
        foreach( $tmp as $one ) {
            $one = (int)$one;
            if( $one < 1 ) continue;

            $rec = feu_user_cache::get_user_noload($one,TRUE);
            if( is_array($rec) && isset($rec['fprops']) ) {
                $tmp2 = array();
                foreach( $rec['fprops'] as $one_prop ) {
                    $tmp2[$one_prop['title']] = $one_prop['data'];
                }
                $rec['props'] = $tmp2;
            }
            $out[] = $rec;
        }

        if( count($out) ) return $out;
        return FALSE;
    }


// deprecated
    function GetUsersInGroup( $groupid = '', $userregex = '', $limit = '', $sort = '', $property = '', $propregex = '',
    $loggedinonly = 0, $start_record = 0)
    {
        // todo: this should go into the consumer.
        $this->reset_lastuserquery();
        $query = new feu_user_query();
        if( (int)$limit > 0 ) $query->set_pagelimit($limit);
        if( (int)$start_record > 0 ) $query->set_offset($start_record);
        if( $groupid > 0 ) $query->add_and_opt(feu_user_query_opt::MATCH_GROUPID,$groupid);
        if( $userregex ) $query->add_and_opt(feu_user_query_opt::MATCH_USERNAME_RE,$userregex);
        if( $property && $propregex ) $query->add_and_opt_obj(new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY_RE,$property,$propregex));
        if( $loggedinonly ) $query->add_and_opt(feu_user_query_opt::MATCH_LOGGEDIN,1);
        $query->set_result_type(feu_user_query::RESULT_TYPE_FULL);

        switch( $sort ) {
        case 'username':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_USERNAME);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_ASC);
            break;
        case 'username desc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_USERNAME);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_DESC);
            break;
        case 'createdate':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_CREATED);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_ASC);
            break;
        case 'createdate desc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_CREATED);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_DESC);
            break;
        case 'expires':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_EXPIRES);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_ASC);
            break;
        case 'expires desc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_EXPIRES);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_DESC);
            break;
        }

        $rs = $query->execute();
        $total_matches = $rs->get_found_rows();
        $data = array();
        while( !$rs->EOF ) {
            $data[] = $rs->fields;
            $rs->MoveNext();
        }
        $this->_last_userquery_matches = $data;
        $this->_last_userquery_count = $total_matches;
        return $data;
    }

// deprecated
    public function get_lastuserquery_count()
    {
        return $this->_last_userquery_count;
    }

// deprecated
    public function get_lastuserquery_matches()
    {
        return $this->_last_userquery_matches;
    }

// deprecated
    public function reset_lastuserquery()
    {
        $this->_last_userquery_count = null;
        $this->_last_userquery_matches = null;
    }

// userid api function
// returns true/false
    function GroupExistsByID( $gid )
    {
        $data = $this->GetGroupInfo( $gid );
        return( $data != false );
    }


// userid api function
// returns true/false
    function GroupExistsByName( $name )
    {
        $gid = $this->GetGroupID( $name );
        return( $gid != false );
    }


    function LoggedInEmail()
    {
        $userid=$this->LoggedInId();
        return $this->GetEmail($userid);
    }


    function GetEmail($uid)
    {
        $module = $this->GetModule();
        $db = $this->GetDb();
        $result = false;

        if ($module->GetPreference('username_is_email')) {
            $tmp = feu_user_cache::get_user($uid);
            if( !is_array($tmp) ) return FALSE;
            $result = $tmp['username'];
        }
        else {
            // get the users first email address.
            $q = 'SELECT data FROM '.cms_db_prefix().'module_feusers_propdefn,'.
                cms_db_prefix().'module_feusers_properties WHERE name=title AND type=2 AND userid = ?';
            $result = $db->GetOne( $q, array( $uid ) );
        }
        return $result;
    }


// todo: move this to main module.
    function IsValidEmailAddress( $email, $uid = -1, $check_existing = true )
    {
        $module = $this->GetModule();
        $result = array();
        if( !is_email($email) ) {
            $result[0] = false;
            $result[1] = $module->Lang('error_improperemailformat');
            return $result;
        }

        $db = $this->GetDb();

        if( $check_existing ) {
            if ($module->GetPreference('username_is_email')) {
                $q = 'SELECT username FROM '.cms_db_prefix().'module_feusers_users WHERE username = ?';
                $parm = array($email);
                if ($uid > -1) {
                    $q .= ' AND id != ?';
                    $parm[] = $uid;
                }
                $dbresult = $db->Execute( $q, $parm );
                if( $dbresult && $dbresult->RecordCount() ) {
                    $result[0] = false;
                    $result[1] = $module->Lang('error_emailalreadyused');
                    return $result;
                }
            }
            else if( !$module->GetPreference('allow_duplicate_emails') ) {
                $q = "SELECT data FROM ".cms_db_prefix()."module_feusers_propdefn,".
                    cms_db_prefix()."module_feusers_properties WHERE name=title AND type=2 AND data LIKE ?";
                $parms = array( $email );
                if( $uid > -1 ) {
                    $q .= ' AND userid != ?';
                    $parms[] = $uid;
                }
                $dbresult = $db->Execute( $q, array( $email ) );
                if( $dbresult && $dbresult->RecordCount() ) {
                    $result[0] = false;
                    $result[1] = $module->Lang('error_emailalreadyused');
                    return $result;
                }
            }
        }

        $result[0] = true;
        return $result;
    }


    function GetUsernamePrompt()
    {
        $consumer = feu_utils::get_auth_consumer();
        return $consumer->get_username_prompt();
    }

// todo: move this to the main module.
    function IsValidUsername( $username, $check_email = true, $uid = -1 )
    {
        $consumer = feu_utils::get_auth_consumer();
        return $consumer->validate_username($username,$check_email,$uid);
    }


// userid api function
// returns an array
    function RemoveUserFromGroup( $uid, $gid )
    {
        if( !$uid ) return array( FALSE ); // todo, return error message
        $db = $this->GetDb();
        $parms = array( $uid );
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_belongs WHERE userid = ?";
        if( $gid != '' ) {
            $q .= " AND groupid = ?";
            array_push( $parms, $gid );
        }
        $dbresult = $db->Execute( $q, $parms );
        if( $dbresult == false ) return array( FALSE, $db->ErrorMsg() );
        return array( TRUE );
    }


// userid api function
// returns array
    function SetGroup( $id, $name, $desc )
    {
        $this->_groupinfo_cache = null;
        if( !isset( $name ) || $name == '' ) {
            $this->_DisplayErrorPage ($id, $params, $return_id,	$this->Lang ('error_insufficientparams'));
            return;
        }

        $db = $this->GetDb();

        $eid = $this->GetGroupID( $name );
        if( $eid != false && $eid != $id ) {
            $mod = $this->GetModule();
            return array(FALSE,$mod->Lang('error_groupname_exists'));
        }

        $q = "UPDATE ".cms_db_prefix()."module_feusers_groups SET groupname = ?, groupdesc = ? WHERE id = ?";
        $dbresult = $db->Execute( $q, array( $name, $desc, $id ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());

        $this->_groupinfo_cache = null;
        return array( TRUE, '');
    }


    function SetUserPassword( $uid, $password )
    {
        $mod = $this->GetModule();
        if( !$uid ) return array(FALSE,$mod->Lang('error_invalidparams'));
        $db = $this->GetDb();
        $q = "UPDATE ".cms_db_prefix()."module_feusers_users SET password = ? WHERE id = ?";
        $dbresult = $db->Execute( $q, array( md5($password.$this->get_salt()), $uid ));
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());

        feu_user_cache::del_user($uid);
        return array(TRUE,"");
    }


// userid api function
// returns array
    function SetUser( $uid, $username, $password, $expires = false, $do_md5 = true )
    {
        if( !$uid ) return array(FALSE,"");
        $db = $this->GetDb();
        $module = $this->GetModule();

        // make sure that this user exists
        $ret = $this->GetUserInfo( $uid );
        if( $ret[0] == FALSE ) return array(FALSE, $module->Lang('error_usernotfound'));

        // make sure that this username is not taken by some other id
        $nuid = $this->GetUserID($username);
        if( $nuid != false && $nuid != $uid ) return array(FALSE, $module->Lang('error_usernametaken',$uid));

        $dbresult = '';
        $parms = array();
        $q = "UPDATE ".cms_db_prefix()."module_feusers_users SET username = ?";

        $parms[] = $username;
        if( trim( $password ) != '' ) {
            $q .= ", password = ?";
            if( $do_md5 ) {
                $parms[] = md5($password.$this->get_salt());
            }
            else {
                $parms[] = $password;
            }
        }
        if( $expires != false ) {
            $q .= ", expires = ?";
            $parms[] = trim($db->DBTimeStamp($expires),"'");
        }
        $q .= " WHERE id = ?";
        $parms[] = $uid;
        $dbresult = $db->Execute( $q, $parms );

        if( $dbresult == false ) return array( FALSE, $db->ErrorMsg() );

        $this->_useridbyname = array();
        feu_user_cache::del_user($uid);

        // Changed to pass $uid back so it matches AddUser()
        return array( TRUE, $uid );
    }


/**
 * Set the user group memberships
 * does not alter any user properties.
 * does not validate group ids, but does validate uid
 *
 * @param int userid
 * @param array array of integer group ids
 * @return array (status,msg)
 */
    function SetUserGroups( $uid, $grpids )
    {
        if( !$uid ) return array(FALSE,"");
        $db = $this->GetDb();

        // first make sure this user exists
        $ret = $this->GetUserInfo( $uid );
        if( $ret[0] == FALSE ) return array(FALSE, "User does not exist");

        // then remove all his current assignments
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_belongs WHERE userid = ?";
        $dbresult = $db->Execute( $q, array( $uid ));
        if( !$dbresult ) return array( FALSE, $db->ErrorMsg()  );

        if( is_array($grpids) && count($grpids) ) {
            // and add all of them in
            $q = "INSERT INTO ".cms_db_prefix()."module_feusers_belongs VALUES (?,?)";
            foreach( $grpids as $grpid ) {
                $dbresult = $db->Execute( $q, array( $uid, $grpid ) );
                if( !$dbresult ) return array( FALSE, $db->ErrorMsg()  );
            }
        }
        return array( TRUE, "" );
    }

    function AddUserToGroup( $uid, $gid )
    {
        return $this->AssignUserToGroup($uid,$gid);
    }

// userid api function
// returns true/false
    function SetUserProperties( $uid, $props )
    {
        if( !$uid ) return FALSE;
        // Delete all the user properties
        // and set new ones
        $this->DeleteUserPropertyFull( '', $uid, true );
        feu_user_cache::del_user($uid);

        if( is_array($props) && count($props) ) {
            if( cge_array::is_hash($props) ) {
                foreach( $props as $key => $val ) {
                    if ( ($r = $this->SetUserPropertyFull( $key, $val, $uid )) == false) return FALSE;
                }
            }
            else {
                foreach( $props as $prop ) {
                    list( $key, $val ) = explode('=',$prop,2);
                    if ( ($r = $this->SetUserPropertyFull( $key, $val, $uid )) == false) return FALSE;
                }
            }
        }

        return TRuE;
    }


// userid api function
// returns true/false
    function UserExistsByID( $uid )
    {
        if( !$uid ) return false;
        $data = $this->GetUserInfo( $uid );
        return( $data[0] !== FALSE );
    }


// userid api function
// returns an array or false
    function GetUserProperties($uid)
    {
        if( !$uid ) return false;
        $uinfo = feu_user_cache::get_user($uid,TRUE);
        if( !is_array($uinfo ) || !isset($uinfo['fprops']) ) return FALSE;

        return $uinfo['fprops'];
    }


// userid api function
// returns an array of records or false
    function GetMemberGroupsArray($userid)
    {
        $auth_consumer = feu_utils::get_auth_consumer();
        if( $auth_consumer->has_capability($auth_consumer::CAPABILITY_GROUPMEMBERSHIP) ) {
            $out = $auth_consumer->get_group_membership($userid);
            if( !is_array($out) || count($out) == 0 ) return false;
            $res = array();
            foreach( $out as $one ) {
                $res[] = array('userid'=>$userid,'groupid'=>$one);
            }
            return $res;
        }

        // shouldn't be used any more... but just in case.
        $db = $this->GetDb();
        $q = "SELECT * FROM ".cms_db_prefix()."module_feusers_belongs WHERE userid=?";
        $dbresult=$db->Execute($q,array($userid));
        if ($dbresult && $dbresult->RecordCount()) {
            $result=array();;
            while ($row=$dbresult->FetchRow()) {
                $result[] = $row;
            }
            return $result;
        } else {
            return false;
        }
    }

//
// end of rc functions
//

// userid api function
    function GetUserProperty($title,$defaultvalue=false)
    {
        $userid=$this->LoggedInId();
        if ($userid===false) return false;
        return $this->GetUserPropertyFull($title,$userid,$defaultvalue);
    }


// userid api function
    function GetUserPropertyFull($title,$userid, $defaultvalue=false)
    {
        if ($userid===false) return false;
        $uinfo = feu_user_cache::get_user($userid,TRUE);

        $defn = $this->GetPropertyDefn($title);
        if( !$defn ) return false;

        if( isset($uinfo['fprops']) ) {
            foreach( $uinfo['fprops'] as $oneprop ) {
                if( $oneprop['title'] == $title ) return $oneprop['data'];
            }
        }
        return $defaultvalue;
    }


// userid api function
    function IsUserPropertyValueUnique($uid,$title,$data)
    {
        $db = $this->GetDb();
        $dbr = '';
        if( $uid > 0 ) {
            $q = 'SELECT id FROM '.cms_db_prefix().'module_feusers_properties
            WHERE title = ? AND userid != ? AND data = ?';
            $dbr = $db->GetOne($q,array($title,$uid,$data));
        }
        else {
            $q = 'SELECT id FROM '.cms_db_prefix().'module_feusers_properties
            WHERE title = ? AND data = ?';
            $dbr = $db->GetOne($q,array($title,$data));
        }
        if( $dbr ) return FALSE;
        return TRUE;
    }


// userid api function
    function SetUserProperty($title,$data)
    {
        $userid=$this->LoggedInId();
        if ($userid===false) return false;
        return $this->SetUserPropertyFull($title,$data,$userid);
    }


// userid api function
    function SetUserPropertyFull($title,$data,$userid)
    {
        if ($userid===false) return FALSE;
        $defn = $this->GetPropertyDefn($title);
        if( !$defn ) return FALSE;

        if( $defn['encrypt'] ) {
            // gotta encrypt.
            $this->SetEncryptionKey($userid,TRUE);
            $data = base64_encode(cge_encrypt::encrypt($this->_encryption_key,$data));
        }

        if( $defn['force_unique'] && !$this->IsUserPropertyValueUnique($userid,$title,$data) ) {
            return FALSE;
        }

        $db=$this->GetDB();
        $q="SELECT * FROM ".cms_db_prefix()."module_feusers_properties WHERE title=? AND userid=?";
        $p=array($title,$userid);
        $r=$db->Execute($q,$p);
        if (!$r || ($r->NumRows()==0)) {
            $newid=$db->GenID(cms_db_prefix()."module_feusers_properties_seq");
            $q="INSERT INTO ".cms_db_prefix()."module_feusers_properties (id,userid,title,data) VALUES (?,?,?,?)";
            $p=array($newid,$userid,$title,$data);
            $r=$db->Execute($q,$p);
        } else {
            $row=$r->FetchRow();
            $q="UPDATE ".cms_db_prefix()."module_feusers_properties SET data=? WHERE id=?";
            $p=array($data,(int)$row["id"]);
            $r=$db->Execute($q,$p);
        }

        feu_user_cache::del_user($userid);
        return ($r!=false);
    }


// delete all occurances of the userproperty by name
    function DeleteUserPropertyByName( $title )
    {
        $db = $this->GetDB();
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_properties WHERE title=?";
        $p = array( $title );
        $result = $db->Execute( $q, $p );

        feu_user_cache::clear_all();
        return ($result!=false);
    }


// userid api function
    function DeleteUserProperty($title,$all=false)
    {
        $userid=$this->LoggedInId();
        if ($userid===false) return false;
        return $this->DeleteUserPropertyFull($title,$userid,$all);
    }


// userid api function
    function DeleteUserPropertyFull($title,$userid,$all=false)
    {
        $db=$this->GetDB();
        $q="DELETE FROM ".cms_db_prefix()."module_feusers_properties WHERE userid=?";
        if (!$all) $q.=" AND title=?";
        $p=array();
        if ($all) $p=array($userid); else $p=array($userid,$title);
        $result=$db->Execute($q,$p);

        feu_user_cache::del_user($userid);
        return ($result!=false);
    }


// userid api function
    function DeleteAllUserProperties()
    {
        return $this->DeleteUserProperty("",true);
    }


// userid api function
    function DeleteAllUserPropertiesFull($userid)
    {
        return $this->DeleteUserPropertyFull("",$userid,true);
    }


// userid api function
    function CheckPassword($username,$password,$groups = '',$md5pw = false)
    {
        $db = $this->GetDb();
        $q="SELECT u.* FROM ".cms_db_prefix()."module_feusers_users u";
        if ($groups != '') {
            $q .= ' INNER JOIN '.cms_db_prefix().'module_feusers_belongs b ON u.id = b.userid INNER JOIN '.cms_db_prefix().'module_feusers_groups g ON g.id = b.groupid ';
        }
        $q .= ' WHERE u.username=? AND u.password=?';
        $p = '';
        if( $md5pw ) {
            $p=array($username,$password);
        }
        else {
            $p=array($username,md5(trim($password).$this->get_salt()));
        }
        if ($groups != '') {
            //split the string on the commas
            $groups = explode(',',$groups);
            for( $i = 0; $i < count($groups); $i++ ) {
                $groups[$i] = $db->qstr(trim($groups[$i]));
            }
            $groups = '('.implode(',',$groups).')';
            $q .= ' AND g.groupname IN '.$groups;
        }
        $result=$db->Execute($q,$p);
        if ($result && $result->RecordCount()) return true;
        return false;
    }


// userid api function
    function LoggedInName()
    {
        $userid=$this->LoggedInId();
        if ($userid) return $this->GetUserName($userid); else return "";
    }


// userid api function
    function Logout($uid = '',$message = 'logout')
    {
        $gCms = cmsms();
        $config = $gCms->GetConfig();
        $db = $this->GetDb();
        $q = '';
        $p = '';
        if( $uid == '' ) {
            $uid = $this->LoggedInId();
            if( !$uid ) return false;
        }

        $this->_clear_logindetails($uid);

        // and add history info
        $this->add_history($uid,$message);

        // send the event.
        $module = $this->GetModule();
        $module->SendEvent('OnLogout',array('id'=>$uid));
    }


// userid api function
    function LogoutUser($uid,$eventmsg = 'logout')
    {
        if( !$uid ) return;
        $db = $this->GetDb();
        $q="DELETE FROM ".cms_db_prefix()."module_feusers_loggedin WHERE userid=?";
        $p=array($uid);
        $result=$db->Execute($q,$p);

        $this->add_history($uid,$eventmsg);
    }


// userid api function
    function ExpireUsers()
    {
        // todo: moved to consumer...
        if( $this->_hasrun1 ) return;
        $module = $this->GetModule();
        $expire_interval = $module->GetPreference('expireusers_interval',60);
        $expire_lastrun = $module->GetPreference('expireusers_lastrun');
        debug_buffer('FEU ExpireUsers '.$expire_interval.' -- '.$expire_lastrun);
        if( time() - $expire_lastrun >= $expire_interval ) {
            $expirytime = $module->GetPreference('user_session_expires');
            $db = $this->GetDb();
            $q="SELECT * FROM ".cms_db_prefix()."module_feusers_loggedin WHERE lastused<?";
            $p=array(time()-$expirytime);
            $dbresult = $db->Execute( $q, $p );
            while( $dbresult && ($row = $dbresult->FetchRow()) ) {
                $this->add_history($row['userid'],'expire');
                if( isset($_SESSION['__FEU__']) && $_SESSION['__FEU__'] != '' ) {
                    $data = unserialize(base64_decode($_SESSION['__FEU__']));
                    if( isset($data['uid']) && $data['uid'] == $row['userid'] ) {
                        $this->_clear_logindetails($row['userid'],TRUE);
                    }
                }
                $this->NotifyExpiredUser( $row['userid'] );
            }

            $q="DELETE FROM ".cms_db_prefix()."module_feusers_loggedin WHERE lastused<?";
            $result=$db->Execute($q,$p);

            $module->SetPreference('expireusers_lastrun',time());
        }
        $this->_hasrun1 = 1;
    }


// userid api function
    function LoggedInId()
    {
        // if the user is authenticated using the auth module
        $module = $this->GetModule();
        $auth_consumer = feu_utils::get_auth_consumer();
        if( !$auth_consumer->has_capability($auth_consumer::CAPABILITY_LOGIN) ) {
            // its the built in stuff.
            $res = $this->_std_LoggedInId();
            if( $res ) return $res;
        }

        // either the consumer doesn't provide absolute login (CAPABILITY_LOGIN) OR the user is not
        // authenticated via the old stuff.
        if( $auth_consumer->is_authenticated() ) {
            // authenticated via some external mechanism... still need to tie this to an
            // internal user record for properties and groups and cruft.

            // search for a userid based on a property
            $prop = $auth_consumer->get_connecting_property_name();
            $val  = $auth_consumer->get_unique_identifier();
            if( !$val ) return FALSE;

            $uinfo = '';
            $useprop = false;
            if( $prop == '' || $prop == feu_auth_consumer::PROPERTY_USERNAME ) {
                // get user by name
                $uinfo = $this->GetUserInfoByName( $auth_consumer->get_username($val) );
            }
            else if( $prop == feu_auth_consumer::PROPERTY_UID ) {
                // see if the uid exists.
                $uinfo = $this->GetUserInfo( $val );
            }
            else {
                // it's a property of some type.
                $uinfo = $this->GetUserInfoByProperty($prop,$val);
                $useprop = true;
            }

            if( !is_array($uinfo) || (is_array($uinfo) && $uinfo[0] == FALSE) ) {
                // user authenticated but not found, do we need to create one?
                if( $auth_consumer->has_capability(feu_auth_consumer::CAPABILITY_ALTLOGIN) || $module->GetPreference('auto_create_unknown') ) {

                    // we're gonna create a new user.
                    $username = '';

                    if( $auth_consumer->has_capability($auth_consumer::CAPABILITY_USERNAME) ) {
                        $username = $auth_consumer->get_username();
                    }

                    if( !$username ) {
                        $username = $val;
                        if( $module->GetPreference('use_randomusername') &&
                        $prop != feu_auth_consumer::PROPERTY_USERNAME &&
                        $prop != feu_auth_consumer::PROPERTY_UID &&
                        $prop != '' ) {
                            $username = $module->GenerateRandomUsername();
                        }
                    }

                    $tmp = $module->GetPreference('expireage_months',6);
                    $expires = strtotime(sprintf("+%d months",$tmp));

                    $ret = $this->AddUser( $username,
                    feu_utils::generate_random_printable_string(),
                    $expires, TRUE, TRUE );

                    if( $ret[0] == FALSE ) {
                        $module->Audit('',$module->GetName(),$ret[1]);
                        return FALSE;
                    }
                    $uid = $ret[1];

                    // set his groups.
                    $dflt_groups = $this->GetDfltGroups();
                    if( is_array($dflt_groups) && count($dflt_groups) ) {
                        $res = $this->SetUserGroups($uid,$dflt_groups);
                    }

                    // now set a property.
                    if( $useprop ) {
                        $ret = $this->SetUserPropertyFull($prop,$val,$uid);
                        if( $ret == false ) {
                            // should remove the user...
                            $module->Audit('',$module->GetName(),$module->Lang('error_problemsettinginfo'));
                            return FALSE;
                        }
                    }

                    $module->Audit($uid,$module->GetName(),$module->Lang('audit_user_created'));
                    return $uid;
                }
            }
            else {
                return $uinfo[1]['id'];
            }
        }
        return FALSE;
    }

    private function _decrypt($key,$encdata)
    {
        if( !function_exists('mcrypt_module_open') ) return FALSE;
        $data = FALSE;
        $td = @mcrypt_module_open(MCRYPT_DES,'',MCRYPT_MODE_ECB,'');
        if( $td === FALSE ) return FALSE;

        $key = substr($key,0,mcrypt_enc_get_key_size($td));
        $iv_size = @mcrypt_enc_get_iv_size($td);
        $iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);

        // initialize encryption handle
        $tmp = @mcrypt_generic_init($td,$key, $iv);
        if( $tmp != -1 ) {
            $data = @mdecrypt_generic($td,$encdata);
            mcrypt_generic_deinit($td);
        }
        @mcrypt_module_close($td);
        return $data;
    }

/**
 * NOT FOR EXTERNAL USE
 *
 * @internal
 */
    public function _std_LoggedInId()
    {
        $sessionid = session_id();
        if( $sessionid == "" ) return FALSE;
        $this->ExpireUsers();

        $data = $this->_get_saved_logindetails();
        if( !$data ) return FALSE;
        if( !isset($data['uid']) ) return FALSE;

        $uid = $data['uid'];
        $this->_set_saved_logindetails($uid);
        return $uid;
    }


// userid api function
    function LoggedIn()
    {
        if( !$this->LoggedInId() ) return false;
        return true;
    }


/**
 * Determine if the user id is a member of the group(s) specified.
 *
 * @param integer userid
 * @param mixed integer (positive) group id, or an array of positive integer group ids.
 * @return boolean
 */
    function MemberOfGroup($userid,$groupid)
    {
        if( $userid < 1 ) return FALSE;

        // cleanup the input groupid list.
        if( !is_array($groupid) ) $groupid = array((int)$groupid);
        $groupid = array_values($groupid);
        for( $i = 0; $i < count($groupid); $i++ ) {
            if( $groupid[$i] < 1 ) unset($groupid[$i]);
        }
        if( !is_array($groupid) || count($groupid) == 0 ) return FALSE;

        $tmp = $this->GetMemberGroupsArray($userid);
        if( !is_array($tmp) || count($tmp) == 0 ) return FALSE;
        $membership = cge_array::extract_field($tmp,'groupid');

        $tmp = array_intersect($membership,$groupid);
        if( is_array($tmp) && count($tmp) ) return TRUE;
        return FALSE;
    }


// userid api function
    function GetUserName($userid)
    {
        $row = feu_user_cache::get_user($userid);
        if( !$row ) return FALSE;
        return $row['username'];
    }


// userid api function
    function GetUserID($username)
    {
        if( !is_array($this->_useridbyname) ) $this->_useridbyname = array();
        if( !isset($this->_useridbyname[$username]) ) {
            $db = $this->GetDb();
            $q = "SELECT id FROM ".cms_db_prefix()."module_feusers_users WHERE username = ?";
            $uid = (int) $db->GetOne($q,array($username));
            $this->_useridbyname[$username] = $uid;
            return $uid;
        }
    }


// userid api function
// returns array
    function AddGroup( $name, $description )
    {
        $db = $this->GetDb();

        // see if it exists already or not (by name)
        $q = "SELECT * FROM ".cms_db_prefix()."module_feusers_groups WHERE groupname = ?";
        $dbresult = $db->Execute( $q, array( $name ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        $row = $dbresult->FetchRow();
        if( $row ) {
            $module = $this->GetModule();
            return array(FALSE,$module->Lang('error_groupname_exists'));
        }

        $grpid = $db->GenID( cms_db_prefix()."module_feusers_groups_seq" );
        $q = "INSERT INTO ".cms_db_prefix()."module_feusers_groups VALUES (?,?,?)";
        $dbresult = $db->Execute( $q, array( $grpid, $name, $description ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        unset($this->_groupinfo_cache);
        return array(TRUE,$grpid);
    }


// userid api function
// returns array
    function AddUser( $name, $password, $expires, $do_md5 = true, $nonstd = FALSE )
    {
        $db = $this->GetDb();

        // see if it exists already or not (by name)
        $uid = $this->GetUserID($name);
        if( $uid ) {
            $module = $this->GetModule();
            return array(FALSE,$module->Lang('error_username_exists'));
        }

        // generate the sequence
        $uid = $db->GenID( cms_db_prefix()."module_feusers_users_seq" );

        $pwtxt = $password;
        if( $do_md5 == true ) $pwtxt = md5($password.$this->get_salt());

        // insert the record
        $q = "INSERT INTO ".cms_db_prefix().
            "module_feusers_users (id,username,password,createdate,expires,nonstd) VALUES (?,?,?,?,?,?)";
        $dbresult = $db->Execute( $q, array( $uid, $name, $pwtxt,
        trim($db->DbTimeStamp(time()),"'"),
        trim($db->DbTimeStamp($expires),"'"),
        $nonstd ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        return array(TRUE,$uid);
    }

// userid api function
    function GetGroupName($gid)
    {
        $this->_get_groupinfo();
        if( is_array($this->_groupinfo_cache) && isset($this->_groupinfo_cache[$gid]) ) {
            return $this->_groupinfo_cache[$gid]['groupname'];
        }
    }


// userid api function
    function GetGroupDesc($groupid)
    {
        $this->_get_groupinfo();
        if( is_array($this->_groupinfo_cache) && isset($this->_groupinfo_cache[$gid]) ) {
            return $this->_groupinfo_cache[$gid]['groupdesc'];
        }
    }


// userid api function
// returns an array
    function DeleteGroupFull( $id )
    {
        $db = $this->GetDB();
        $result = array();

        // delete all property relations from this group
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_grouppropmap WHERE group_id = ?";
        $dbresult = $db->Execute( $q, array( $id ) );
        if( !$dbresult ) return array( FALSE, $db->ErrorMsg() );

        // delete all indication that anybody is a member
        // of this group
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_belongs WHERE groupid = ?";
        $dbresult = $db->Execute( $q, array( $id ) );
        if( !$dbresult ) return array( FALSE, $db->ErrorMsg() );

        // and then delete the group
        $q = "DELETE FROM ".cms_db_prefix()."module_feusers_groups WHERE id = ?";
        $dbresult = $db->Execute( $q, array( $id ) );
        if( !$dbresult ) return array( FALSE, $db->ErrorMsg() );

        $this->_groupinfo_cache = null;
        return array( TRUE, '' );
    }


// userid api function
    function GetGroupList()
    {
        $this->_get_groupinfo();
        $result = array();
        if( is_array($this->_groupinfo_cache) ) {
            foreach( $this->_groupinfo_cache as $gid => $info ) {
                $result[$info['groupname']] = $gid;
            }
        }
        return $result;
    }


// userid api function
    function GetGroupListFull($with_count = FALSE)
    {
        $this->_get_groupinfo($with_count);
        $result = array();
        if( is_array($this->_groupinfo_cache) ) $result = $this->_groupinfo_cache;
        return $result;
    }


// old userid api function
    function GetGroupID($groupname)
    {
        $this->_get_groupinfo();
        if( is_array( $this->_groupinfo_cache ) ) {
            foreach( $this->_groupinfo_cache as $gid => $info ) {
                if( $info['groupname'] == $groupname ) return $gid;
            }
        }
        return false;
    }


/**
 * Return a list of groups that the user is a member of
 *
 * @deprecated
 * @param integer The user identifier
 * @return string A comma delimited string containing member group names.  or 'none'
 */
    function GetMemberGroups($userid)
    {
        $auth_consumer = feu_utils::get_auth_consumer();
        if( !$auth_consumer->has_capability($auth_consumer::CAPABILITY_GROUPMEMBERSHIP) ) {
            return 'none';
        }

        $out = $auth_consumer->get_group_membership($userid);
        if( !is_array($out) || count($out) == 0 ) return 'none';

        $info = $this->_get_groupinfo();
        $tmp = array();
        foreach( $out as $one ) {
            if( isset($info[$one]) ) $tmp[] = $info[$one]['groupname'];
        }
        if( count($out) == 0 ) return 'none';

        return implode(',',$tmp);
    }


// old userid api function
    function DeleteUser($id)
    {
        $db = $this->GetDb();
        if (isset($_GET[$id."userid"])) {
            $userid=str_replace("'",'_',$_GET[$id."userid"]);
        }
        else {
            return;
        }
        $q="DELETE FROM ".cms_db_prefix()."module_feusers_users WHERE id='$userid'";
        $dbresult=$db->Execute($q);
        $q="DELETE FROM ".cms_db_prefix()."module_feusers_belongs WHERE userid='$userid'";
        $dbresult=$db->Execute($q);

        $this->_useridbyname = array();
        feu_user_cache::del_user($userid);
    }

    protected function GetDfltGroups()
    {
        $consumer = feu_utils::get_auth_consumer();
        if( $consumer->has_capability($consumer::CAPABILITY_DEFAULTGROUPS) ) return $consumer->get_default_groups();

        $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
        $dflt_group = $feu->GetPreference('default_group');
        return array((int)$dflt_group);
    }

    private function _get_saved_logindetails()
    {
        $key = '__FEU__';
        $key2 = '__FEU__lr';
        $sessionid = session_id();
        if( !$sessionid ) return;
        $lastr = 0;
        $do_read = FALSE;
        $data = null;

        if( $this->_readdata1 ) return $this->_readdata1;

        if( isset($_SESSION[$key2]) ) $lastr = $_SESSION[$key2];
        if( $lastr < time() - 180 ) $do_read = TRUE;

        if( !$do_read ) {
            if( isset($_SESSION[$key]) && $_SESSION[$key] != '' ) $data = unserialize(base64_decode($_SESSION[$key]));
        }

        if( !$do_read && !$data ) {
            $module = $this->GetModule();
            if( $module->GetPreference('cookie_keepalive',0) ) $data = unserialize(base64_decode($_COOKIE[$key]));
        }

        if( !$do_read && !$data ) {
            if( ($cn = $this->GetPreference('cookiename')) != '' ) {
                // this is remember me functionality.
                $data = unserialize($_COOKIE[$cn]);
            }
        }

        if( !$do_read && $data ) {
            $this->_readdata1 = $data;
            return $data;
        }

        // read logged in data from database
        if( !$this->_hasread1 ) {
            $db = cmsms()->GetDb();
            $q = 'SELECT userid AS uid,lastused AS time FROM '.cms_db_prefix().'module_feusers_loggedin WHERE sessionid = ?';
            $this->_hasread1 = TRUE;
            $data = $db->GetRow($q,array($sessionid));
            if( is_array($data) && count($data) ) {
                $_SESSION[$key2] = time();
                $this->_readdata1 = $data;
                return $data;
            }
        }
    }

    private function _set_saved_logindetails($uid)
    {
        if( $this->_hasrun2 == TRUE ) return;
        $this->_hasrun2 = TRUE;

        $key = '__FEU__';
        $sessionid = session_id();
        if( !$sessionid ) return;
        $lastupdate = 0;
        if( isset($_SESSION[$key.'_lu']) ) $lastupdate = $_SESSION[$key.'_lu'];

        $data = array('uid'=>(int)$uid,'time'=>time(),'sessionid'=>$sessionid);
        $_SESSION[$key] = base64_encode(serialize($data));

        $module = $this->GetModule();
        if( $module->GetPreference('cookie_keepalive',0) ) {
            $user_session_expires = $module->GetPreference('user_session_expires');
            if( $user_session_expires ) @setcookie($key,base64_encode(serialize($data)),time()+$user_session_expires,'/'); // expiry to 24 hours.
        }

        if( time() - 180 > $lastupdate ) {
            // only update the user every 3 minutes...
            $db = cmsms()->GetDb();
            $query = 'UPDATE '.cms_db_prefix().'module_feusers_loggedin SET lastused = ? WHERE userid = ? AND sessionid = ?';
            $dbr = $db->Execute($query,array($data['time'],$data['uid'],$data['sessionid']));
            if( !$dbr || $db->Affected_Rows() == 0 ) {
                $query = 'INSERT INTO '.cms_db_prefix().'module_feusers_loggedin (sessionid,lastused,userid) VALUES (?,?,?)';
                $dbr = $db->Execute($query,array($data['sessionid'],$data['time'],$data['uid']));
            }
            $_SESSION[$key.'_lu'] = time();
        }
        return TRUE;
    }

    private function _clear_logindetails($uid,$session_only = FALSE)
    {
        $key = '__FEU__';
        $sessionid = session_id();
        if( !$sessionid ) return;

        foreach( $_SESSION as $k => $v ) {
            if( startswith($k,$key) ) unset($_SESSION[$k]);
        }

        if( $session_only == TRUE ) return;
        @setcookie($key,'',time()-60000,'/');
        $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
        if( ($cn = $feu->GetPreference('cookiename')) != '' ) @setcookie($cn,'',time()-60000,'/');

        $query = 'DELETE FROM '.cms_db_prefix().'module_feusers_loggedin WHERE userid = ?';
        $db = cmsms()->GetDb();
        $db->Execute($query,array($uid));
    }

    private function __reset()
    {
        $this->_hasrun1 = null;
        $this->_hasrun2 = null;
        $this->_readdata1 = null;
        $this->_hasread1 = null;
    }
} // class

?>