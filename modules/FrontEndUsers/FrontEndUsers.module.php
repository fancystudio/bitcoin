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

// a very important line that includes all of our api functions
final class FrontEndUsers extends CGExtensions
{
    const FIELDTYPE_TEXT = 0;
    const FIELDTYPE_CHECKBOX = 1;
    const FIELDTYPE_EMAIL = 2;
    const FIELDTYPE_TEXTAREA = 3;
    const FIELDTYPE_DROPDOWN = 4;
    const FIELDTYPE_MULTISELECT = 5;
    const FIELDTYPE_IMAGE = 6;
    const FIELDTYPE_RADIOBUTNS = 7;
    const FIELDTYPE_DATE = 8;
    const FIELDTYPE_DATA = 9;

    /**
     * The default template used for the login form
     */

    //How many seconds of inactivity before a user is automatically logged out.
    protected $expirytime;

    //Set this to true if user should be redirected to default page after
    // logging in/out.
    protected $logintarget;
    protected $otherintarget;
    protected $logouttarget;
    protected $otherouttarget;
    protected $allowuseradmin;
    protected $enableemailpw;
    protected $lang="";
    private $usermanip = false;
    protected $types = false;

    // constructor
    public function __construct()
    {
        parent::__construct();
        $this->types = array( 'text' => self::FIELDTYPE_TEXT,
        'checkbox' => self::FIELDTYPE_CHECKBOX,
        'email' => self::FIELDTYPE_EMAIL,
        'textarea' => self::FIELDTYPE_TEXTAREA,
        'dropdown' => self::FIELDTYPE_DROPDOWN,
        'multiselect' => self::FIELDTYPE_MULTISELECT,
        'image' => self::FIELDTYPE_IMAGE,
        'radiobuttons' => self::FIELDTYPE_RADIOBUTNS,
        'date' => self::FIELDTYPE_DATE,
        'data' => self::FIELDTYPE_DATA);

        global $CMS_ADMIN_PAGE;
        if( !isset($CMS_ADMIN_PAGE) ) {
            require_once(__DIR__."/lib/class.feu_smarty.php" );
            $smarty = cmsms()->GetSmarty();
            if( !$smarty ) return;
            $obj = new feu_smarty($this);
            $smarty->assign('feu_smarty',$obj);
        }
        $this->AddImageDir('icons');

        $contentops = cmsms()->GetContentOperations();
        $obj = new CmsContentTypePlaceholder();
        $obj->class = 'feu_protected_page';
        $obj->type  = strtolower($obj->class);
        $obj->filename = __DIR__.'/lib/class.feu_protected_page.php';
        $obj->loaded = false;
        $obj->friendlyname = $this->Lang('feu_protected_page');
        $contentops->register_content_type($obj);
    }

    private function _load()
    {
        if( $this->usermanip == NULL ) {
            // check a preference to see which user manipulator class
            // we should use.
            $manipulator = 'FrontEndUsersManipulator';
            $this->usermanip = new FrontEndUsersManipulator( $this );
            if( !is_object( $this->usermanip ) ) die("Error instantiationg $manipulator object");
            $this->usermanip->SetExpireNotifier(array($this,'NotifyExpiredUser'));
        }
    }

    /**
     * Get the User Manipulator Object
     * NOT FOR EXTERNAL USE
     *
     * @internal
     * @return object
     */
    public function &GetManipulator()
    {
        $this->_load();
        return $this->usermanip;
    }

    /**
     * Generate a random, printable string
     *
     * @deprecated
     */
    public function GenerateRandomPrintableString( $len = 10 )
    {
        return feu_utils::generate_random_printable_string($len);
    }

    function GetName() { return 'FrontEndUsers'; }
    function GetVersion() { return '1.23.4'; }
    function HasContentType() { return TRUE; }
    function IsPluginModule() { return TRUE; }
    function AllowAutoInstall() { return FALSE; }
    function AllowAutoUpgrade() { return FALSE; }
    function LazyLoadAdmin() { return TRUE; }
    function MinimumCMSVersion() { return '1.11.9'; }
    function GetAdminDescription () { return $this->Lang ('moddescription'); }
    function GetAdminSection () { return 'usersgroups'; }
    function GetDependencies() { return array( 'CMSMailer' => '1.73.9','CGExtensions' => '1.38.10' ); }
    function GetEventDescription ( $eventname ) { return $this->Lang('event_info_'.$eventname ); }
    function GetEventHelp ( $eventname ) { return $this->Lang('event_help_'.$eventname ); }
    function GetFriendlyName () { return $this->Lang('friendlyname'); }
    function HasAdmin () { return TRUE; }
    function InstallPostMessage() { return $this->Lang('postinstallmessage'); }
    function GetHelp() { return file_get_contents(__DIR__.'/help.inc'); }
    function GetAuthor() { return 'calguy1000'; }
    function GetAuthorEmail() { return 'calguy1000@hotmail.com'; }
    function GetChangeLog() { return file_get_contents(__DIR__.'/changelog.inc'); }

    protected function langifyKeys( $arr )
    {
        $out = array();
        foreach( $arr as $k=>$v ) {
            $k = $this->Lang($k);
            $out[ $k ] = $v;
        }
        return $out;
    }

    function SetParameters()
    {
        $this->RestrictUnknownParams();
        $this->RegisterModulePlugin();
        $this->SetParameterType('code',CLEAN_STRING);
        $this->SetParameterType('form',CLEAN_STRING);
        $this->SetParameterType('returnto',CLEAN_STRING);
        $this->SetParameterType('only_groups',CLEAN_STRING);
        $this->SetParameterType('nocaptcha',CLEAN_INT);
        $this->SetParameterType('input_username',CLEAN_STRING);
        $this->SetParameterType('input_password',CLEAN_STRING);
        $this->SetParameterType('input_repeatpassword',CLEAN_STRING);
        $this->SetParameterType('error',CLEAN_INT);
        $this->SetParameterType('message',CLEAN_STRING);
        $this->SetParameterType('lostun_group',CLEAN_STRING);
        $this->SetParameterType('input_captcha',CLEAN_STRING);
        $this->SetParameterType('submit',CLEAN_STRING);
        $this->SetParameterType('cancel',CLEAN_STRING);
        $this->SetParameterType('input_returnto',CLEAN_INT);
        $this->SetParameterType('input_uid',CLEAN_INT);
        $this->SetParameterType('input_code',CLEAN_STRING);
        $this->SetParameterType('skipformdisplay',CLEAN_INT);
        $this->SetParameterType('uid',CLEAN_INT);
        $this->SetParameterType('checkonly',CLEAN_INT);
        $this->SetParameterType('returnlast',CLEAN_INT);
        $this->CreateParameter('returnlast','',$this->Lang('help_returnlast'));
        $this->SetParameterType('noinline',CLEAN_INT);
        $this->CreateParameter('noinline','',$this->Lang('help_noinline'));
        $this->SetParameterType(CLEAN_REGEXP.'/feu_.*/',CLEAN_STRING);

        $this->RegisterRoute('/[fF]eu\/verify\/(?P<returnid>[0-9]+)\/(?P<uid>[0-9]+)\/(?P<code>.*?)$/',array('action'=>'verifycode'));
        $this->RegisterRoute('/[fF]eu\/reset\/(?P<uid>[0-9]+)$/',array('action'=>'reset_session','showtemplate'=>'false','checkonly'=>'1'));
        $this->RegisterRoute('/[fF]eu\/edit\/(?P<returnid>[0-9]+)$/',array('action'=>'changesettings'));
        $this->RegisterRoute('/[fF]eu\/logout\/(?P<returnid>[0-9]+)$/',array('action'=>'logout'));
        $this->RegisterRoute('/[fF]eu\/forgot\/(?P<returnid>[0-9]+)$/',array('action'=>'forgotpw'));
        $this->RegisterRoute('/[fF]eu\/lostusername\/(?P<returnid>[0-9]+)$/',array('action'=>'lostusername'));
    }

    private function _ExportLoggedInUserVariables($id,&$params,$returnid)
    {
        // replace {$username} with the user name
        $uid = $this->LoggedInId();
        if( !$uid ) return;
        $username = $this->LoggedInName();

        // replace {$groupname} with the first groupname we can find that matches
        $smarty = cmsms()->GetSmarty();
        $groups = $this->GetMemberGroupsArray( $uid );
        $groupname = $this->GetGroupName( $groups[0]['groupid'] );

        $smarty->assign('userid', $uid);
        $smarty->assign('username', $username );
        $smarty->assign('link_logout', $this->CreateLink($id,"logout",$returnid, $this->Lang('logout')));
        $prettyurl_logout = 'feu/logout/'.$returnid;
        $logout_feu = $this->CreateLink($id, 'logout', $returnid, '', array(), '', true, false, '', false, $prettyurl_logout);
        $smarty->assign('url_logout', $logout_feu);

        $page = $this->ProcessTemplateFromData($this->GetPreference('pageid_changesettings'));
        if( $page ) {
            $pageid = ContentManager::get_instance()->GetPageIDFromAlias( $page );
            if( $pageid == false ) {
                $smarty->assign('link_changesettings','<!-- Error could not determine page from alias/id -->');
            }
            else {
                $smarty->assign('link_changesettings',
                $this->CreateLink($id,'default',$pageid,$this->Lang('prompt_changesettings'),array('form'=>'changesettings')));
                //nuno-dev-Pretty Url's
                $prettyurl_changesettings = 'feu/edit/'.$pageid;
                $changesettings_feu = $this->CreateLink($id, 'default', $pageid, '', array('form'=>'changesettings'), '',
                true, false, '', false, $prettyurl_changesettings);
                $smarty->assign('url_changesettings',$changesettings_feu);
            }
        }
        else {
            $smarty->assign('link_changesettings', $this->CreateLink($id,'default',$returnid, $this->Lang('prompt_changesettings'), array('form'=>'changesettings')));
            //nuno-dev-Pretty Url's
            $prettyurl_changesettings = 'feu/edit/'.$returnid;
            $changesettings_feu = $this->CreateLink($id, 'default', $returnid,  '', array('form'=>'changesettings'), '', true, false, '', false, $prettyurl_changesettings);
            $smarty->assign('url_changesettings',$changesettings_feu);
        }
        $props = $this->GetUserProperties( $this->LoggedInId() );
        foreach( $props as $p ) {
            $smarty->assign($p['title'],$p['data']);
        }
    }

    function get_tasks()
    {
        $tmp = $this->GetPreference('forcelogout_times');
        if( $tmp != '' ) {
            $obj = new FEUForcedLogoutTask();
            return $obj;
        }
        $tmp = null;
        return $tmp;
    }

    protected function _HasSufficientPermissions( $perm = '' )
    {
        if ($this->GetPreference('feusers_specific_permissions','0') == '1') {
            $p1 = $this->CheckPermission( 'FEU Add Users' );
            $p2 = $this->CheckPermission( 'FEU Modify Users' );
            $p3 = $this->CheckPermission( 'FEU Remove Users' );
            $p4 = $this->CheckPermission( 'FEU Add Groups' );
            $p5 = $this->CheckPermission( 'FEU Modify Groups' );
            $p6 = $this->CheckPermission( 'FEU Modify Group Assignments' );
            $p7 = $this->CheckPermission( 'FEU Remove Groups' );
            $p8 = $this->CheckPermission( 'FEU Modify Site Preferences' );
            $p9 = $this->CheckPermission( 'FEU Modify FrontEndUserProps' );
            $p10 = $this->CheckPermission( 'FEU Modify Templates' );
        }
        else {
            $p1 = $this->CheckPermission( 'Add Users' );
            $p2 = $this->CheckPermission( 'Modify Users' );
            $p3 = $this->CheckPermission( 'Remove Users' );
            $p4 = $this->CheckPermission( 'Add Groups' );
            $p5 = $this->CheckPermission( 'Modify Groups' );
            $p6 = $this->CheckPermission( 'Modify Group Assignments' );
            $p7 = $this->CheckPermission( 'Remove Groups' );
            $p8 = $this->CheckPermission( 'Modify Site Preferences' );
            $p9 = $this->CheckPermission( 'Modify FrontEndUserProps' );
            $p10 = $this->CheckPermission( 'Modify Templates' );
        }

        $consumer = feu_utils::get_auth_consumer();
        $ret = 0;
        switch( $perm ) {
        case '':  // any permission
            $ret = ($p1 || $p2 || $p3 || $p4 || $p5 || $p6 || $p7 || $p8 || $p9 || $p10 );
            break;

        case 'users':
            $ret = ($p1 || $p2 || $p3);
            break;

        case 'adduser':
            $ret = ($p1);
            break;

        case 'addprop':
        case 'addprop2':
        case 'editprop':
        case 'deleteprop':
            $ret = ($p9) && $consumer->has_capability($consumer::CAPABILITY_EDITPROPS);
            break;

        case 'properties':
            $ret = ($p9) && $consumer->has_capability($consumer::CAPABILITY_LISTPROPS);
            break;

        case 'listusers':
            $ret = ($p2 || $p3);
            break;

        case 'listgroups':
            $ret = ($p5 || $p6) &&
                ($consumer->has_capability($consumer::CAPABILITY_USESTDGROUPS) || $consumer->has_capability($consumer::CAPABILITY_LISTGROUPS));
            break;

        case 'groups':
            $ret = ($p4 || $p5 || $p7) &&
                ($consumer->has_capability($consumer::CAPABILITY_USESTDGROUPS) || $consumer->has_capability($consumer::CAPABILITY_LISTGROUPS));
            break;

        case 'addgroup':
            $ret = ($p4) && ($consumer->has_capability($consumer::CAPABILITY_USESTDGROUPS) || $consumer->has_capability($consumer::CAPABILITY_EDITGROUPS));
            break;

        case 'strict_editgroups':
            $ret = ($p5 || $p6) && ($consumer->has_capability($consumer::CAPABILITY_USESTDGROUPS) || $consumer->has_capability($consumer::CAPABILITY_EDITGROUPS));
            break;

        case 'editgroups':
            $ret = ($p5 || $p6) && $consumer->has_capability($consumer::CAPABILITY_USESTDGROUPS,$consumer::CAPABILITY_EDITGROUPS,$consumer::CAPABILITY_EDITGROUPPROPS);
            break;

        case 'editusers':
            $ret = ($p2);
            break;

        case 'removegroups':
            $ret = ($p7) && $consumer->has_capability($consumer::CAPABILITY_USESTDGROUPS,$consumer::CAPABILITY_EDITGROUPS);
            break;

        case 'removeusers':
            $ret = ($p3);
            break;

        case 'editprefs':
        case 'siteprefs':
            $ret = ($p8);
            break;

        case 'usersngroups':
            $ret = ($p1 || $p2 || $p3 || $p4 || $p5 || $p6 || $p7);
            break;

        case 'templates':
            $ret = ($p10);
            break;

        default:
            $ret = 0;
            break;
        }

        return $ret;
    }

    function VisibleToAdminUser()
    {
        if ($this->GetPreference('feusers_specific_permissions','0') == '1') {
            return $this->CheckPermission('FEU Modify Site Preferences') ||
                $this->CheckPermission('FEU Modify Templates') ||
                $this->CheckPermission('FEU Add Groups') ||
                $this->CheckPermission('FEU Modify Groups') ||
                $this->CheckPermission('FEU Remove Groups') ||
                $this->CheckPermission('FEU Add Users') ||
                $this->CheckPermission('FEU Modify Users') ||
                $this->CheckPermission('FEU Remove Users') ||
                $this->CheckPermission('FEU Modify FrontEndUserProps');
        }
        else {
            return $this->CheckPermission('Modify Site Preferences') ||
                $this->CheckPermission('Modify Templates') ||
                $this->CheckPermission('Add Groups') ||
                $this->CheckPermission('Modify Groups') ||
                $this->CheckPermission('Remove Groups') ||
                $this->CheckPermission('Add Users') ||
                $this->CheckPermission('Modify Users') ||
                $this->CheckPermission('Remove Users') ||
                $this->CheckPermission('Modify FrontEndUserProps');
        }
    }

    protected function _DisplayErrorPage($id, &$params, $returnid, $message='')
    {
        $smarty = cmsms()->GetSmarty();
        $smarty->assign('title_error', $this->Lang('error'));
        if ($message != '') $smarty->assign('message', $message);

        // Display the populated template
        echo $this->ProcessTemplate('error.tpl');
    }

    protected function _DoUserAction( $id, &$params, $returnid )
    {
        $gCms = cmsms();
        $form = 'login';
        if( isset($params['form']) ) $form = $params['form'];

        if( !isset($params['form'])) {
            $uid = $this->LoggedInId();
            if( $uid <= 0 ) {
                $form = 'login';
            }
            else {
                $form = 'logout';
            }
        }

        $auth_consumer = feu_utils::get_auth_consumer();
        switch( $form ) {
        case 'login':
            include __DIR__.'/function.user_loginform.php';
            break;
        case 'logout':
            include __DIR__.'/function.user_logoutform.php';
            break;
        case 'lostusername':
            include(__DIR__.'/function.default_lostusernameform.php');
            break;
        case 'forgotpw':
            include(__DIR__.'/function.user_forgotpassword.php');
            break;
        case 'changesettings':
            include(__DIR__.'/function.user_changesettings.php');
            break;
        case 'silent':
            $this->_ExportLoggedInUserVariables( $id, $params, $returnid );
            break;
        }
    }

    protected function _DisplayAdminUserPage( $id, &$params, $returnid )
    {
        $smarty = cmsms()->GetSmarty();
        // populate the template
        $editing = 0;
        $hidden = array();
        $username = '';
        $password = '';
        $repeatpassword = '';
        $expires = '';
        $uinfo = null;

        if( isset($params['returnto']) ) $hidden['returnto'] = $params['returnto'];
        if( isset( $params['action'] ) && ($params['action'] == 'edituser'|| $params['action'] == 'do_edituser1' ) ) {
            $editing = 1;
            $hidden['user_id'] = $params['user_id'];
            $uinfo = $this->GetUserInfo($params['user_id']);
            $smarty->assign('title', $this->Lang('edituser'));
            $smarty->assign('startform',$this->CreateFormStart($id,'do_edituser1',$returnid));
        }
        else {
            $smarty->assign('title', $this->Lang('adduser'));
            $smarty->assign('startform',$this->CreateFormStart($id,'do_adduser1',$returnid));
        }

        if( !empty($hidden) ) {
            $txt = '';
            foreach( $hidden as $key => $value ) {
                $txt .= $this->CreateInputHidden($id,$key,$value);
            }
            $smarty->assign('hidden',$txt);
        }

        if( isset($params['error']) ) $smarty->assign('error',$params['error']);
        if( isset($params['message']) ) $smarty->assign('message',$params['message']);

        if( $this->GetPreference('use_randomusername',0) == 1 ) $username = $this->GenerateRandomUsername();
        if( isset($params['input_username']) )  $username = trim($params['input_username']);
        if( isset($params['input_password']) ) $password = trim($params['input_password']);
        if( isset($params['input_repeatpassword']) ) $repeatpassword = trim($params['input_repeatpassword']);
        if( isset($params['input_expires']) ) $expires = trim($params['input_expires']);

        $smarty->assign('endform', $this->CreateFormEnd());
        $smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', $this->Lang('next')));
        $smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', $this->Lang('cancel')));

        $auth_consumer = feu_utils::get_auth_consumer();
        $addtext = '';
        if( $editing && $uinfo[1]['nonstd'] ) {
            $addtext = 'readonly="readonly"';
            $smarty->assign('username_readonly',1);
        }
        $smarty->assign('prompt_username',$auth_consumer->get_username_prompt());
        $smarty->assign('input_username',
        $this->CreateInputText($id, 'input_username',$username,
        $this->GetPreference('usernamefldlength'),
        $this->GetPreference('max_usernamelength'),
        $addtext));

        $addtext = '';
        if( $editing && $uinfo[1]['nonstd'] ) {
            $addtext = 'readonly="readonly"';
            $smarty->assign('password_readonly',1);
        }
        $smarty->assign('prompt_password',$this->Lang('password'));
        $smarty->assign('input_password',
        $this->CreateInputPassword($id, 'input_password', $password,
        $this->GetPreference('passwordfldlength'),
        $this->GetPreference('max_passwordlength'),
        $addtext));
        $smarty->assign('prompt_repeatpassword',$this->Lang ('repeatpassword'));
        $smarty->assign('input_repeatpassword',
        $this->CreateInputPassword($id, 'input_repeatpassword', $repeatpassword,
        $this->GetPreference('passwordfldlength'),
        $this->GetPreference('max_passwordlength'),
        $addtext));

        if( $editing == 1 ) {
            $smarty->assign('info_password',$this->Lang('info_admin_password'));
            $smarty->assign('info_repeatpassword',$this->Lang('info_admin_repeatpassword'));
        }

        $smarty->assign('prompt_expires',$this->Lang('expires'));
        $smarty->assign('expires_dateprefix',$id.'expiresdate_');
        $tmp = $this->GetPreference('expireage_months',520);
        $expiresdate = strtotime("+{$tmp} months", time());
        if( isset( $params['input_expiresdate'] ) ) $expiresdate = $params['input_expiresdate'];
        $smarty->assign ('expiresdate', $expiresdate );

        // display and edit groups
        if( $this->_HasSufficientPermissions('strict_editgroups') ) {
            if( isset($params['memberof'] ) ) {
                $tmp = (int)$params['memberof'];
                $params['memberof_'.$tmp] = 1;
            }

            // now display a list of groups that this user may optionally be in
            $smarty->assign( 'idtext', $this->Lang('id') );
            $smarty->assign( 'nametext', $this->Lang('name') );
            $smarty->assign( 'desctext', $this->Lang('description') );

            $groups = $this->GetGroupListFull();
            $checked = -1;
            if( $this->GetPreference('require_onegroup') &&  count($groups) == 1 ) {
                $keys = array_keys($groups);
                $checked = $keys[0];
            }

            $rowarray = array();
            $rowclass = 'row1';
            foreach( $groups as $group ) {
                $onerow = new StdClass();
                $onerow->id = $group['id'];
                $onerow->name = $group['groupname'];
                $onerow->desc = $group['groupdesc'];
                if( isset($params['memberof_'.$group['id']]) ) $checked = $params['memberof_'.$group['id']];
                $onerow->member = $this->CreateInputCheckbox($id,'memberof_'.$group['id'], $group['id'],$checked);
                $onerow->rowclass = $rowclass;

                $rowarray[] = $onerow;
                ($rowclass == "row1" ? $rowclass = "row2" : $rowclass = "row1");
            }
            $smarty->assign('itemcount',count($rowarray));
            $smarty->assign('items',$rowarray);
        }

        $smarty->assign('propadd', $this->CreateInputSubmit( $id, 'propadd',$this->Lang('add')));
        $smarty->assign('groupstitle', $this->Lang('groups'));
        $smarty->assign('propertiestitle', $this->Lang('properties'));

        $smarty->assign('props', $this->CreateInputSubmit($id, 'props', $this->Lang('properties')."..."));
        echo $this->ProcessTemplate('adduser1.tpl');
    }

    function DoAction($action, $id, $params, $returnid = -1)
    {
        if( isset($params['feu_enc']) ) {
            // restore parameters saved in the session on redirect.
            $sig = $params['feu_enc'];
            if( isset($_SESSION[$sig]) ) {
                $tmp = $_SESSION[$sig];
                $params = array_merge($tmp,$params);
                unset($_SESSION[$sig]);
            }
            unset($params['feu_enc']);
        }

        $smarty = cmsms()->GetSmarty();
        $smarty->assign('feuactionid',$id);
        $smarty->assign('feuactionparams',$params);
        $smarty->assign('mod',$this);
        $smarty->assign($this->GetName(),$this);

        switch ($action) {
        case 'changesettings_url':
            break;

        case 'changesettings':
            $params['form'] = $action;
            $this->_DoUserAction( $id, $params, $returnid );
            break;

        case 'lostusername':
        case 'forgotpw':
            $params['form'] = $action;
            $this->_DoUserAction( $id, $params, $returnid );
            break;

        case "default":
            $this->_DoUserAction( $id, $params, $returnid );
            break;

        case 'edituser':
            if( $this->_HasSufficientPermissions( 'editusers' ) ) {
                $this->_DisplayAdminEditUserStep1Page( $id, $params, $returnid );
            }
            else {
                $this->_DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
            }
            break;

        case 'admin_bulkactions':
        case 'admin_importgroup':
        case 'admin_exportgroup':
        case 'admin_logout':
        case 'admin_setviewuser_template':
        case 'admin_setlostun_template':
        case 'addgroup':
        case 'adduser':
        case 'addprop':
        case 'defaultadmin':
        case 'do_deleteprop':
        case 'do_deletegroup':
        case 'do_login':
        case 'do_adduser1':
        case 'do_adduser3':
        case 'do_deleteuser':
        case 'do_addgroup':
        case 'do_edituser3':
        case 'do_userchangesettings':
        case 'do_forgotpw':
        case 'do_setprefs':
        case 'do_edituser1':
        case 'do_admintasks':
        case 'do_lostusername':
        case 'do_verifycode':
        case 'logout':
        case 'userhistory':
        case 'verifycode':
        case 'viewuser':
        case 'do_edituser2':
        case 'do_adduser2':
        case 'do_setforgotpwtemplate':
        case 'do_setlogintemplate':
        default:
            parent::DoAction($action,$id,$params,$returnid);
            break;
        }
    }


    protected function _DisplayAdminEditUserStep1Page( $id, &$params, $returnid )
    {
        if( !isset( $params['user_id'] ) ) {
            $this->_DisplayErrorPage ($id, $params, $returnid, $this->Lang ('error_insufficientparams'));
            return;
        }

        // now get the user info
        $user = $this->GetUserInfo( $params['user_id'] );
        if( $user[0] == false ) {
            $this->_DisplayErrorPage ($id, $params, $returnid, $user[1] );
            return;
        }
        $user = $user[1];

        // get the user properties
        $this->SetEncryptionKey($params['user_id']);
        $props = $this->GetUserProperties( $params['user_id'] );

        // get the group memberships
        $groups = $this->GetMemberGroupsArray( $params['user_id'] );

        // populate the params with the appropriate stuff
        // that we just loaded
        $params['input_username'] = $user['username'];
        $params['input_expiresdate'] = $user['expires'];
        $userprops = '';
        if( is_array($props) && count($props) ) {
            foreach( $props as $prop ) {
                if( $userprops == '' ) {
                    $userprops = $prop['title']."=".$prop['data'];
                }
                else {
                    $userprops .= ",".$prop['title']."=".$prop['data'];
                }
            }
        }
        $params['userprops'] = $userprops;

        $memberof = '';
        if( $groups != false ) {
            foreach( $groups as $group ) {
                $params['memberof_'.$group['groupid']] = $group['groupid'];
            }
        }

        // and display the user page
        // todo, put a redirect here
        $this->_DisplayAdminUserPage( $id, $params, $returnid );
    }


    protected function _handleUserInfoValidation( $id, &$params, $returnid, &$message, $needpw = true,
    $doexpire = true, $checkusername = true )
    {
        // make sure the parameters are filled in
        $username = trim($params['input_username']);
        $password = trim($params['input_password']);
        $repeat   = trim($params['input_repeatpassword']);
        $consumer = feu_utils::get_auth_consumer();

        // make sure the username fits the rules
        if( $checkusername ) {
            $message = $this->Lang('error_invalidusername');
            if( $this->GetPreference('username_is_email',0) == 1 && get_class($consumer) == 'feu_std_consumer' ) {
                $message = $this->Lang('error_invalidemailaddress');
                if( strpos($username,'@') == false ) return -1;
            }
            if( !$this->IsValidUsername( $username ) ) return -1;
        }

        if( $username == ''
        || ($needpw && ($password == '' || $repeat == ''))  ) {
            //die("$username, $needpw, $password, $repeat");
            $message = $this->Lang('error_invalidparams');
            return -1;
        }

        // make sure the passwords match
        if( $password != $repeat ) {
            $message = $this->Lang('error_passwordmismatch');
            return -1;
        }

        // make sure the password fits the rules
        if( $needpw && !$this->IsValidPassword( $password ) ) {
            $message = $this->Lang('error_invalidpassword');
            return -1;
        }

        if( $doexpire == false ) return 1;

        // make sure an expiry date is set
        if( !isset($params['expiresdate_Month']) ) {
            $message = $this->Lang('error_invalidexpirydate');
            return -1;
        }

        $expires = mktime(23,59,59,$params['expiresdate_Month'], $params['expiresdate_Day'], $params['expiresdate_Year']);
        if( !$expires ) {
            $message = $this->Lang('error_invalidexpirydate');
            return -1;
        }
        $params['input_expiresdate'] = $expires;
        return 1;
    }

    function myRedirect( $id, $action, $returnid, $params = array(), $ignore_returnto = false )
    {
        // find any parameter values that are arrays
        // automatically store this data in the session
        unset($params['action']);

        $tmp = array();
        foreach($params as $key => $val) {
            if( is_array($val) ) {
                $tmp[$key] = $val;
                unset($params[$key]);
            }
        }
        if( count($tmp) ) {
            $sig = md5(serialize($tmp));
            $_SESSION[$sig] = $tmp;
            $params['feu_enc'] = $sig;
        }

        if( isset($params['returnto']) && !$ignore_returnto) {
            // this is probably not needed any more.
            list($mod,$act) = explode(',',$params['returnto']);
            die('aa1');
            $this->LoadRedirectMethods();
            $modobj = $this->GetModuleInstance($mod);
            $tmp = array();
            return cms_module_Redirect($modobj,$id,$act,$returnid);
        }
        $this->Redirect( $id, $action, $returnid, $params );
    }

    protected function feCreateFormStart( $id, $action, $returnid, $inline=true, $method='post', $enctype='', $idsuffix='', $params = array() )
    {
        return $this->CreateFormStart($id,$action,$returnid,$method,$enctype,$inline,$idsuffix, $params);
    }


    function GetHeaderHTML()
    {
        $tmpl =<<<EOT
{JQueryTools action='require' lib='tablesorter,JQueryTools'}
{JQueryTools action='placemarker'}
EOT;

    $obj = cms_utils::get_module('JQueryTools','1.2');
    if( is_object($obj) ) {
        $smarty = cmsms()->GetSmarty();
        return $smarty->fetch('string:'.$tmpl);
    }
    }


    // send an event that this user account has been expired
    protected function NotifyExpiredUser( $userid )
    {
        $user = $this->GetUserInfo( $userid );
        if( $user[0] == FALSE ) return; // this should be an error
        $parms = array();
        $parms['id'] = $userid;
        $parms['username'] = $user[1]['username'];
        $this->SendEvent('OnExpireUser',$parms);
        $this->_SendNotificationEmail('OnExpireUser',$parms);
    }


    protected function get_upload_dirname($uid)
    {
        $gCms = cmsms();
        $config = $gCms->GetConfig();
        $dn = cms_join_path($config['uploads_path'],$this->GetPreference('image_destination_path', 'feusers'));
        return $dn;
    }


    protected function ManageImageUpload($id, $fldprefix, $fldname, $uid)
    {
        $gCms = cmsms();

        if( !isset($_FILES[$id.$fldprefix.$fldname]) || !isset( $_FILES ) ) return array(false,$this->Lang('error_missing_upload'));

        $file =& $_FILES[$id.$fldprefix.$fldname];
        if( !isset($file['name']) || !isset($file['size']) || $file['size'] == 0 ) return array(false,$this->Lang('error_problem_upload'));

        if (!isset ($file['type'])) $file['type'] = '';
        if (!isset ($file['size'])) $file['size'] = '';
        if (!isset ($file['tmp_name'])) $file['tmp_name'] = '';
        $file['name'] =
            preg_replace('/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/', '',
            str_replace (array (' ', '%20'), array ('_', '_'), $file['name']));

        // check the filename
        $allowed_extensions=$this->GetPreference('allowed_image_extensions','.gif,.png,.jpg');
        $tmp = explode( ',', $allowed_extensions);
        if( !is_array($tmp) ) return array(false,$this->Lang('error_invalidfileextension'));
        $found = false;
        foreach( $tmp as $ext ) {
            if( endswith( $file['name'], $ext ) ) {
                $found = true;
                break;
            }
        }
        if( !$found ) return array(false,$this->Lang('error_invalidfileextension'));

        // set the destination name
        $ext = strchr($file['name'],'.');
        $destname = $uid.'_'.$fldname.$ext;

        // Create the destination directory if necessary
        $destDir = $this->get_upload_dirname($uid);
        @mkdir($destDir);
        if( !is_writable( $destDir ) ) return array(false,$this->Lang('error_destinationnotwritable'));
        @cms_move_uploaded_file($file['tmp_name'], cms_join_path($destDir,$destname));

        return array(true,$destname);
    }


    protected function _SendNotificationEmail($event,$params)
    {
        $notifications = explode(',',$this->GetPreference('notifications',''));
        if( !in_array( $event, $notifications ) ) return;
        $dest = trim($this->GetPreference('notification_address'));
        if( empty($dest) ) return;

        // Setup some smarty stuff.
        $smarty = cmsms()->GetSmarty();
        $smarty->assign('event',$event);
        $smarty->assign('event_name',$this->Lang($event));
        $smarty->assign('plaintext_event',$this->Lang('event'));
        foreach( $params as $key => $value ) {
            $smarty->assign('param_'.$key,$value);
        }
        $text = $this->ProcessTemplateFromDatabase('notification_template');

        $cmsmailer = $this->GetModuleInstance('CMSMailer');
        $cmsmailer->reset();
        $cmsmailer->AddAddress($dest);
        $cmsmailer->SetSubject($this->GetPreference('notification_subject'));
        $cmsmailer->SetBody($text);
        $cmsmailer->IsHTML(false);
        $cmsmailer->Send();
    }


    protected function _params_to_session(&$params, $key = 'feu_params')
    {
        $_SESSION[$key] = $params;
    }

    protected function _session_to_params($key = 'feu_params')
    {
        if( !isset($_SESSION[$key]) ) return false;
        $tmp = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $tmp;
    }

    public function SetPostLoginURL($url)
    {
        if( $url ) $this->session_put('postlogin_url',$url);
    }

    //////////////////////////////////////////
    //  API FUNCTIONS //
    //////////////////////////////////////////

    function add_history( $uid, $message )
    {
        $this->_load();
        return $this->usermanip->add_history( $uid, $message );
    }

    function AddGroup( $name, $description )
    {
        $this->_load();
        return $this->usermanip->AddGroup( $name, $description );
    }


    function AddGroupPropertyRelation( $grpid, $propname, $sortkey, $lostun, $val )
    {
        $this->_load();
        return $this->usermanip->AddGroupPropertyRelation( $grpid, $propname, $sortkey, $lostun, $val );
    }


    function AddPropertyDefn( $name, $prompt, $type, $length, $maxlength = 0, $attribs = '', $force_unique = 0, $encrypt = 0 )
    {
        $this->_load();
        return $this->usermanip->AddPropertyDefn( $name, $prompt, $type, $length, $maxlength, $attribs, $force_unique, $encrypt  );
    }


    function AddSelectOptions( $name, $seloptions )
    {
        $this->_load();
        return $this->usermanip->AddSelectOptions( $name, $seloptions );
    }


    function AddUser( $name, $password, $expires, $do_md5 = true )
    {
        $this->_load();
        return $this->usermanip->AddUser( $name, $password, $expires, $do_md5 );
    }


    function AssignUserToGroup( $uid, $gid )
    {
        $this->_load();
        return $this->usermanip->AssignUserToGroup( $uid, $gid );
    }


    function CheckPassword($username,$password,$groups = '',$md5pw = false)
    {
        $this->_load();
        return $this->usermanip->CheckPassword($username,$password,$groups,$md5pw);
    }


    function CountTempCodeRecords()
    {
        $this->_load();
        return $this->usermanip->CountTempCodeRecords();
    }


    function CountUsersInGroup( $gid = '' )
    {
        $this->_load();
        return $this->usermanip->CountUsersInGroup( $gid );
    }


    /* what's this? */
    function DeleteAllGroupPropertyRelations( $grpid )
    {
        $this->_load();
        return $this->usermanip->DeleteAllGroupPropertyRelations( $grpid );
    }


    function DeleteAllGroupPropertyRelation( $grpid, $propname )
    {
        $this->_load();
        return $this->usermanip->DeleteAllGroupPropertyRelations( $grpid, $propname );
    }


    function DeletePropertyDefn( $name, $full = FALSE )
    {
        $this->_load();
        return $this->usermanip->DeletePropertyDefn( $name, $full );
    }


    function DeletePropertyDefns()
    {
        $this->_load();
        return $this->usermanip->DeletePropertyDefns();
    }


    function DeleteSelectOptions( $name )
    {
        $this->_load();
        return $this->usermanip->DeleteSelectOptions( $name );
    }


    function DeleteUserFull( $uid )
    {
        $this->_load();
        return $this->usermanip->DeleteUserFull( $uid );
    }


    function DeleteUserPropertyByName( $title )
    {
        $this->_load();
        return $this->usermanip->DeleteUserPropertyByName($title);
    }

    /*What is this?*/
    function DeleteUserProperty($title,$all=false)
    {
        $this->_load();
        return $this->usermanip->DeleteUserProperty($title,$all);
    }

    function DeleteAllUserProperties()
    {
        $this->_load();
        return $this->usermanip->DeleteAllUserProperties();
    }

    function DeleteAllUserPropertiesFull($userid)
    {
        $this->_load();
        return $this->usermanip->DeleteAllUserPropertiesFull($userid);
    }

    function DeleteUserPropertyFull($title,$userid,$all=false)
    {
        $this->_load();
        return $this->usermanip->DeleteUserPropertyFull($title,$userid,$all);
    }

    function DeleteGroupFull( $gid )
    {
        $this->_load();
        return $this->usermanip->DeleteGroupFull( $gid );
    }


    function DeleteUser($id)
    {
        $this->_load();
        return $this->usermanip->DeleteUser( $id );
    }

    function ExpireUsers()
    {
        $this->_load();
        return $this->usermanip->ExpireUsers();
    }

    function ExpireTempCodes( $expirycode )
    {
        $this->_load();
        return $this->usermanip->ExpireTempCodes( $expirycode );
    }

    function GenerateRandomUsername( $prefix = 'user' )
    {
        $this->_load();
        return $this->usermanip->GenerateRandomUsername( $prefix );
    }

    function GetUserProperties($uid)
    {
        $this->_load();
        return $this->usermanip->GetUserProperties($uid);
    }

    function GetMemberGroupsArray($userid)
    {
        $this->_load();
        return $this->usermanip->GetMemberGroupsArray($userid);
    }

    function GetUserProperty($title,$defaultvalue=false)
    {
        $this->_load();
        return $this->usermanip->GetUserProperty( $title, $defaultvalue );
    }

    function GetUserPropertyFull($title,$userid, $defaultvalue=false)
    {
        $this->_load();
        return $this->usermanip->GetUserPropertyFull($title,$userid,$defaultvalue);
    }

    function GetUserTempCode( $uid )
    {
        $this->_load();
        return $this->usermanip->GetUserTempCode( $uid );
    }

    function GetPropertyGroupRelations( $title )
    {
        $this->_load();
        return $this->usermanip->GetPropertyGroupRelations( $title );
    }

    function GetUserPropertyRelations($uid)
    {
        $this->_load();
        return $this->usermanip->GetUserPropertyRelations( $uid );
    }

    function GetGroupPropertyRelations( $grpid )
    {
        $this->_load();
        return $this->usermanip->GetGroupPropertyRelations( $grpid );
    }

    function GetGroupInfo( $gid )
    {
        $this->_load();
        return $this->usermanip->GetGroupInfo( $gid );
    }

    function GetUserHistory( $uid, $action = '', $count = -1 )
    {
        $this->_load();
        return $this->usermanip->GetUserHistory($uid,$action,$count);
    }


    function GetLoggedInUsers( $not_active_since = '' )
    {
        $this->_load();
        return $this->usermanip->GetLoggedInUsers($not_active_since);
    }

    // deprecated
    function GetBulkUserInfo( $uids, $deep = TRUE )
    {
        $this->_load();
        return $this->usermanip->GetBulkUserInfo($uids,$deep);
    }


    function GetUserInfo( $uid, $deep = FALSE )
    {
        $this->_load();
        return $this->usermanip->GetUserInfo( $uid, $deep );
    }

    function GetUserInfoByName( $username )
    {
        $this->_load();
        return $this->usermanip->GetUserInfoByName( $username );
    }

    function GetUserInfoByProperty( $propname, $propvalue = null )
    {
        $this->_load();
        return $this->usermanip->GetUserInfoByProperty( $propname, $propvalue );
    }

    function GetFullUsersInGroup($gid)
    {
        $this->_load();
        return $this->usermanip->GetFullUsersInGroup($gid);
    }

    // deprecated
    function GetUsersInGroup( $gid = '', $regex = '', $limit = '', $sort = '',
    $property = '', $propregex = '', $loggedinonly = 0, $start_record = 0)
    {
        $this->_load();
        return $this->usermanip->GetUsersInGroup( $gid, $regex, $limit, $sort, $property, $propregex, $loggedinonly, $start_record );
    }

    // deprecated
    function get_lastuserquery_matches()
    {
        $this->_load();
        return $this->usermanip->get_lastuserquery_matches();
    }

    // deprecated
    function get_lastuserquery_count()
    {
        $this->_load();
        return $this->usermanip->get_lastuserquery_count();
    }

    // deprecated
    function reset_lastuserquery()
    {
        $this->_load();
        return $this->usermanip->reset_lastuserquery();
    }

    function GroupExistsByID( $gid )
    {
        $this->_load();
        return $this->usermanip->GroupExistsByID( $gid );
    }

    function GroupExistsByName( $name )
    {
        $this->_load();
        return $this->usermanip->GroupExistsByName( $name );
    }

    function LoggedInEmail()
    {
        $this->_load();
        return $this->usermanip->LoggedInEmail();
    }

    function GetEmail($uid)
    {
        $this->_load();
        return $this->usermanip->GetEmail($uid);
    }

    function ClearPropertyCache()
    {
        $this->_load();
        return $this->usermanip->ClearPropertyCache();
    }

    function GetPropertyDefns()
    {
        $this->_load();
        return $this->usermanip->GetPropertyDefns();
    }

    function GetPropertyDefn( $name )
    {
        $this->_load();
        return $this->usermanip->GetPropertyDefn( $name );
    }

    function GetSelectOptions( $name, $dim = 1 )
    {
        $this->_load();
        return $this->usermanip->GetSelectOptions( $name, $dim );
    }

    function GetUserName($userid)
    {
        $this->_load();
        return $this->usermanip->GetUserName($userid);
    }

    function GetUserID($username)
    {
        $this->_load();
        return $this->usermanip->GetUserID($username);
    }

    function GetGroupName($groupid)
    {
        $this->_load();
        return $this->usermanip->GetGroupName( $groupid );
    }

    function GetGroupDesc($groupid)
    {
        $this->_load();
        return $this->usermanip->GetGroupDesc( $groupid );
    }

    function GetGroupList()
    {
        $this->_load();
        return $this->usermanip->GetGroupList();
    }


    function GetGroupListFull($with_count = FALSE)
    {
        $this->_load();
        return $this->usermanip->GetGroupListFull($with_count);
    }

    function GetGroupID($groupname)
    {
        $this->_load();
        return $this->usermanip->GetGroupID( $groupname );
    }

    function GetMemberGroups($userid)
    {
        $this->_load();
        return $this->usermanip->GetMemberGroups($userid);
    }

    function GetExpiryDate( $uid )
    {
        $this->_load();
        return $this->usermanip->GetExpiryDate( $uid );
    }

    function IsAccountExpired( $uid )
    {
        $this->_load();
        return $this->usermanip->IsAccountExpired( $uid );
    }

    function IsValidPassword( $password )
    {
        $this->_load();
        return $this->usermanip->IsValidPassword( $password );
    }

    function GetUsernamePrompt()
    {
        $this->_load();
        return $this->usermanip->GetUsernamePrompt();
    }

    function IsValidEmailAddress( $email, $uid = -1, $check_existing = true )
    {
        $this->_load();
        return $this->usermanip->IsValidEmailAddress( $email, $uid, $check_existing );
    }

    function IsValidUsername( $username, $check = true, $uid = -1 )
    {
        $this->_load();
        return $this->usermanip->IsValidUsername( $username, $check, $uid );
    }

    function Login( $username, $password, $groups = '', $md5pw = false, $force_logout = false)
    {
        $this->_load();
        return $this->usermanip->Login( $username, $password, $groups, $md5pw, $force_logout);
    }

    function LoggedInName()
    {
        $this->_load();
        $str = $this->usermanip->LoggedInName();
        return $str;
    }

    function Logout($uid = '',$message = 'logout')
    {
        $this->_load();
        return $this->usermanip->Logout($uid,$message);
    }

    function LogoutUser($uid,$eventmsg = 'logout')
    {
        $this->_load();
        return $this->usermanip->LogoutUser($uid,$eventmsg);
    }

    function LoggedInId()
    {
        $this->_load();
        return $this->usermanip->LoggedInId();
    }

    function LoggedIn()
    {
        $tmp = $this->LoggedInId();
        if( $tmp > 0 ) return TRUE;
        return FALSE;
    }

    function MemberOfGroup($userid,$groupid)
    {
        $this->_load();
        return $this->usermanip->MemberOfGroup($userid,$groupid);
    }

    function RemoveUserTempCode( $uid )
    {
        $this->_load();
        return $this->usermanip->RemoveUserTempCode( $uid );
    }

    function RemoveUserFromGroup( $uid, $gid )
    {
        $this->_load();
        return $this->usermanip->RemoveUserFromGroup( $uid, $gid );
    }

    function SetUserTempCode( $uid, $code )
    {
        $this->_load();
        return $this->usermanip->SetUserTempCode( $uid, $code, $this->GetPreference('allow_duplicate_reminders') );
    }

    function SetPropertyDefn( $name, $newname, $prompt, $length, $type, $maxlength = 0, $attribs = '', $force_unique = 0, $encrypt = 0 )
    {
        $this->_load();
        return $this->usermanip->SetPropertyDefn( $name, $newname, $prompt, $type, $length, $maxlength, $attribs, $force_unique, $encrypt );
    }

    function SetPropertyDefnExtra($name,$extra)
    {
        $this->_load();
        return $this->usermanip->SetPropertyDefnExtra($name,$extra);
    }

    function SetGroup( $gid, $name, $desc )
    {
        $this->_load();
        return $this->usermanip->SetGroup( $gid, $name, $desc );
    }

    function SetUserPassword( $uid, $password )
    {
        $this->_load();
        return $this->usermanip->SetUserPassword( $uid, $password );
    }

    function SetUser( $uid, $username, $password, $expires = false, $do_md5 = true )
    {
        $this->_load();
        return $this->usermanip->SetUser( $uid, $username, $password, $expires, $do_md5 );
    }

    function SetUserGroups( $uid, $grpids )
    {
        $this->_load();
        return $this->usermanip->SetUserGroups( $uid, $grpids );
    }

    /**
     * Add user to a group
     *
     * does not effect user properties
     * does not validate gid
     * userid is validated
     *
     * @param int user id
     * @param int group id
     * @return boolean
     */
    function AddUserToGroup( $uid, $gid )
    {
        $this->_load();
        return $this->usermanip->AddUserToGroup( $uid, $gid );
    }

    function SetUserProperties( $uid, $props )
    {
        $this->_load();
        return $this->usermanip->SetUserProperties( $uid, $props );
    }

    function SetUserProperty($title,$data)
    {
        $this->_load();
        return $this->usermanip->SetUserProperty($title,$data);
    }

    function IsUserPropertyValueUnique($uid,$title,$value)
    {
        $this->_load();
        return $this->usermanip->IsUserPropertyValueUnique($uid,$title,$value);
    }

    function SetUserPropertyFull($title,$data,$userid)
    {
        $this->_load();
        return $this->usermanip->SetUserPropertyFull($title,$data,$userid);
    }

    function UserExistsByID( $uid )
    {
        $this->_load();
        return $this->usermanip->UserExistsByID( $uid );
    }

    function SetEncryptionKey($uid = -1,$force = FALSE)
    {
        $this->_load();
        return $this->usermanip->SetEncryptionKey( $uid, $force );
    }

    /** for internal use only **/
    function DecryptUserData($uid,$data)
    {
        $this->_load();
        return $this->usermanip->DecryptUserData($uid,$data);
    }

    protected function _encrypt($key,$data)
    {
        if( !function_exists('mcrypt_module_open') ) return FALSE;
        srand((double) microtime() * 1000000);
        $encdata = FALSE;
        $td = @mcrypt_module_open(MCRYPT_DES,'',MCRYPT_MODE_ECB,'');
        if( $td === FALSE ) return FALSE;

        $key = substr($key,0,mcrypt_enc_get_key_size($td));
        $iv_size = mcrypt_enc_get_iv_size($td);
        $iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);

        // initialize encryption handle
        $tmp = @mcrypt_generic_init($td,$key, $iv);
        if( $tmp != -1 ) {
            $tmp = mcrypt_generic($td,$data);
            @mcrypt_generic_deinit($td);
            $encdata = $tmp;
        }
        @mcrypt_module_close($td);
        return $encdata;
    }

    function HasCapability($capability,$params = array())
    {
        switch( $capability ) {
        case 'content_types':
        case 'contentblocks':
        case 'content_attributes':
        case 'tasks':
            return TRUE;
        default:
            return FALSE;
        }
    }

    function get_content_attributes($content_type)
    {
        $tmp = array();
        $attr = new CmsContentTypeProfileAttribute('feu_groups','visitors');
        $attr->set_helper(feu_content_attribute_helper::get_instance());
        $tmp[] = $attr;
        return $tmp;
    }


    function GetContentBlockInput($blockName,$value,$params,$adding = false)
    {
        switch( $params['selecttype'] ) {
        case 'groupselect':
            $tmp1 = array();
            $tmp = $this->GetGroupList();
            $groups = array_merge($tmp1,$tmp);
            $value = explode(',', trim($value));
            return $this->CreateInputSelectList('',$blockName . '[]',$groups,$value);
            break;
        }
        return FALSE;
    }

    function GetContentBlockValue($blockName,$blockParams,$inputParams)
    {
        if( isset($blockParams['selecttype']) ) {
            if( isset($inputParams[$blockName]) ) {
                $val = $inputParams[$blockName];
                if (is_array($val)) {
                    $val = implode(',', $val);
                    return $val;
                }
            }
            return '-1';
        }
        return '';
    }

    function ValidateContentBlockValue($blockName,$value,$blockParams)
    {
        switch($blockParams['selecttype']) {
        case 'groupselect':
            break;
        }
        return '';
    }

} // class

// EOF
?>
