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

final class feu_smarty
{
    private $_module;
    private $_properties;


    public function __construct(&$module)
    {
        $this->_module =& $module;
    }

    function get_userid($username,$assign = '')
    {
        $username = trim($username);
        $uid = null;
        if( $username ) $uid = (int)$this->_module->GetUserID($username);
        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign(trim($assign),$uid);
            return;
        }
        return $uid;
    }

    function get_userinfo($uid,$assign = '')
    {
        $uid = (int)$uid;
        if( $uid > 0 ) {
            if( is_object($this->_module) ) {
                $uinfo = $this->_module->GetUserInfo($uid,TRUE);
                if( !is_array($uinfo) || count($uinfo) == 0 ) {
                    if( $uinfo[0] == FALSE ) {

                        if( isset($uinfo[1]['fprops']) ) {
                            $tmp = array();
                            foreach( $uinfo[1]['fprops'] as $oneprop ) {
                                $tmp[$oneprop['title']] = $oneprop['data'];
                            }

                            unset($uinfo[1]['fprops']);
                            $uinfo[1]['props'] = $tmp;
                        }
                    }
                }
            }
        }

        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign(trim($assign),$uinfo[1]);
            return;
        }

        return $uinfo[1];
    }

    function get_users_by_groupname($groupname,$assign = '')
    {
        if( !empty($groupname) ) {
            if( !is_object($this->_module) ) {

                $gid = $this->_module->GetGroupID($groupname);
                if( $gid ) {
                    $usersfull = $this->_module->GetUsersInGroup($gid);

                    $users = array();
                    foreach( $usersfull as $oneuser ) {
                        $users[] = array('id'=>$oneuser['id'],'username'=>$oneuser['username']);
                    }
                }
            }
        }

        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign($assign,$users);
        }
    }

    function get_user_expiry($uid,$assign = '')
    {
        $res = null;
        if( $uid > 0 ) {
            if( is_object($this->_module) ) {
                $res = $this->_module->GetExpiryDate($uid);
            }
        }

        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign($assign,$res);
            return;
        }

        return $res;
    }

    function user_expired($uid,$assign = '')
    {
        if( empty($uid) ) return;
        if( !is_object($this->_module) ) return;

        $res = $this->_module->IsAccountExpired($uid);

        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign($assign,$res);
            return;
        }
        return $res;
    }

    function get_user_properties($uid,$assign = '')
    {
        $res2 = null;
        try {
            $uid = (int)$uid;
            if( $uid < 1 ) throw new Exception('a');
            if( empty($assign) ) throw new Exception('b');
            if( !is_object($this->_module) ) throw new Exception('c');

            $res = $this->_module->GetUserProperties($uid);
            if( !$res ) throw new Exception('d');

            $res2 = array();
            foreach( $res as $one ) {
                $res2[$one['title']] = $one['data'];
            }
        }
        catch( Exception $e ) {
        }

        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign($assign,$res2);
            return;
        }
        return $res2;
    }

    function get_dropdown_text($propname,$propvalue,$assign = '')
    {
        $res = null;

        try {
            if( !is_object($this->_module) ) throw new Exception('a');
            if( $this->_properties == null ) {
                $this->_properties = array();
                $tmp = $this->_module->GetPropertyDefns();
                foreach( $tmp as $one ) {
                    if( $one['type'] == 4 || $one['type'] == 5 ) {
                        $tmp2 = $this->_module->GetSelectOptions($one['name']);
                        $one['options'] = array();
                        foreach( $tmp2 as $k => $v ) {
                            $one['options'][$v] = $k;
                        }
                    }
                    $this->_properties[$one['name']] = $one;
                }
            }

            if( !isset($this->_properties[$propname]) ) throw new Exception('b');

            if( ($this->_properties[$propname]['type'] != 4 &&
            $this->_properties[$propname]['type'] != 5) ||
            !isset($this->_properties[$propname]['options']) ) throw new Exception('c');

            if( !isset($this->_properties[$propname]['options'][$propvalue]) ) throw new Exception('d');

            $res = $this->_properties[$propname]['options'][$propvalue];
        }
        catch( Exception $e ) {
        }

        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign($assign,$res);
            return;
        }
        return $res;
    }

    function get_multiselect_text($propname,$propvalue,$assign = '')
    {
        $values = explode(',',$propvalue);
        $res = array();
        foreach( $values as $one ) {
            $res[] = $this->get_dropdown_text($propname,$one);
        }

        if( $assign ) {
            $smarty = cmsms()->GetSmarty();
            $smarty->assign($assign,$res);
            return;
        }
        return $res;
    }
}

#
# EOF
#
?>