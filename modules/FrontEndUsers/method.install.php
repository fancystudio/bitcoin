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
if( !isset($gCms) ) exit;

    $db =& $this->GetDb();
    $dict = NewDataDictionary($db);

    $taboptarray = array('mysql' => 'TYPE=MyISAM');

    //User list
    $flds = "
             id I KEY,
	     username C(80) NOT NULL,
             password C(32) NOT NULL,
             createdate ".CMS_ADODB_DT.",
             expires    ".CMS_ADODB_DT.",
             nonstd   I1";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_feusers_users",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );
    $db->CreateSequence( cms_db_prefix()."module_feusers_users_seq" );

    //Group list
    $flds = "
	     id I KEY,
	     groupname C(32),
	     groupdesc C(128)
	    ";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_feusers_groups",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );
    $db->CreateSequence( cms_db_prefix()."module_feusers_groups_seq" );

    // loggedin
    $flds = "
	     sessionid C(255),
	     lastused I,
	     userid I
	    ";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_feusers_loggedin",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );

    //Connections between users and groups
    $flds = "
	     userid I KEY,
	     groupid I KEY
	    ";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_feusers_belongs",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );

    //property definition
    $flds = "
             name      C(40) KEY,
             prompt    C(255) NOT NULL,
             type      C(20) NOT NULL,
             length    I,
             maxlength I,
             attribs   C(255),
             force_unique I1,
             encrypt   I1,
             extra     X
            ";
    $sqlarray = $dict->CreateTableSql(cms_db_prefix()."module_feusers_propdefn",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );

    //dropdown select options
    $flds = "
             order_id		I,
             option_name	C(40) NOT NULL,
             option_text	C(255) NOT NULL,
             control_name	C(40) NOT NULL;
            ";
    $sqlarray = $dict->CreateTableSql(cms_db_prefix()."module_feusers_dropdowns",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );

    // group property map
    // used to associate a property to a group
    $flds = "
              name    C(40) KEY,
              group_id I KEY,
              sort_key I,
              required I NOT NULL,
              lostunflag I
            ";
    $sqlarray = $dict->CreateTableSql(cms_db_prefix()."module_feusers_grouppropmap",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );

    //user properties
    $flds = "
	     id I KEY,
	     userid I,
	     title C(100),
	     data X2
	    ";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_feusers_properties",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );
    $db->CreateSequence( cms_db_prefix()."module_feusers_properties_seq" );

    // forgotten password stuff
    $flds = "
	     userid I KEY,
             code C(25),
             created ".CMS_ADODB_DT;
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_feusers_tempcode",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );

    // login history stuff
    $flds = "
             userid I,
	     sessionid C(32),
             action C(32),
             refdate ".CMS_ADODB_DT.",
             ipaddress C(20)";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_feusers_history",
				      $flds, $taboptarray );
    $dict->ExecuteSQLArray( $sqlarray );

// indexes
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'feu_idx_username',cms_db_prefix().'module_feusers_belongs','groupid');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'feu_idx_username',cms_db_prefix().'module_feusers_users','username');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'feu_idx_expires',cms_db_prefix().'module_feusers_users','expires');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'feu_idx_refdate',cms_db_prefix().'module_feusers_history','userid,refdate,action');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'feu_idx_propusertitle',cms_db_prefix().'module_feusers_properties','userid,title');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix().'feu_idx_proptitle',cms_db_prefix().'module_feusers_properties','title');
$dict->ExecuteSQLArray($sqlarray);


    // templates
    $fn = __DIR__.'/templates/orig_loginform.tpl';
    $this->SetTemplate('feusers_loginform', file_get_contents($fn) );

    $fn = __DIR__.'/templates/orig_logoutform.tpl';
    $this->SetTemplate('feusers_logoutform', file_get_contents($fn) );

    $fn = __DIR__.'/templates/orig_changesettings.tpl';
    $this->SetTemplate('feusers_changesettingsform', file_get_contents($fn) );

    $fn = __DIR__.'/templates/orig_forgotpassword1.tpl';
    $this->SetTemplate('feusers_forgotpasswordform',file_get_contents($fn));

    $fn = __DIR__.'/templates/orig_forgotpassword2.tpl';
    $this->SetTemplate('feusers_forgotpasswordemailform', file_get_contents($fn) );

    $fn = __DIR__.'/templates/orig_forgotpassword3.tpl';
    $this->SetTemplate('feusers_forgotpasswordverifyform',file_get_contents($fn));

$fn = cms_join_path(__DIR__,'templates','orig_lostunform_template.tpl');
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetTemplate('feusers_lostunform',$template);
  }

$fn = cms_join_path(__DIR__,'templates','orig_lostunform_confirm_template.tpl');
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetTemplate('feusers_lostunform_confirm',$template);
  }

$fn = cms_join_path(__DIR__,'templates','orig_notification_template.tpl');
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetTemplate('notification_template',$template);
  }

$fn = cms_join_path(__DIR__,'templates','orig_viewuser_template.tpl');
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetTemplate('feusers_viewuser',$template);
  }

$fn = cms_join_path(__DIR__,'templates','orig_resetsession_template.tpl');
if( file_exists( $fn ) ) {
  $template = @file_get_contents($fn);
  $this->SetTemplate('feusers_resetsession',$template);
 }

// preferences
$this->SetPreference('min_passwordlength', 6);
$this->SetPreference('max_passwordlength', 20);
$this->SetPreference('min_usernamelength', 4);
$this->SetPreference('max_usernamelength', 40);
$this->SetPreference('user_session_expires', 1800);
$this->SetPreference('cookie_keepalive',0);
$str = 'x'.substr(str_shuffle(md5(time().$config['root_url'].__FILE__)),0,7);
$this->SetPreference('cookiename',$str);
$this->SetPreference('default_group', -1);
$this->SetPreference('required_field_marker', '*');
$this->SetPreference('required_field_color', 'blue');
$this->SetPreference('require_onegroup', 1);
$this->SetPreference('hidden_field_marker', '!');
$this->SetPreference('hidden_field_color', 'green');
$this->SetPreference('pageid_forgotpasswd', '');
$this->SetPreference('pageid_changesettings', '');
$this->SetPreference('pageid_login','');
$this->SetPreference('pageid_logout','');
$this->SetPreference('pageid_afterverify','');
$this->SetPreference('allow_duplicate_emails',0);
$this->SetPreference('username_is_email',1);
$this->SetPreference('passwordfldlength', 20);
$this->SetPreference('usernamefldlength', 40);
$this->SetPreference('allow_repeated_logins',0);
$this->SetPreference('image_destination_path','feusers');
$this->SetPreference('allowed_image_extensions','.gif,.png,.jpg');
$this->SetPreference('notification_subject',$this->Lang('feu_event_notification'));
$this->SetPreference('expireage_months',60);

    $config = cmsms()->GetConfig();
    $this->SetPreference('pwsalt',substr(str_shuffle(md5(time().$config['root_url'].__FILE__)),0,5));

    // Events
    $this->CreateEvent( 'OnLogin' );
    $this->CreateEvent( 'OnLogout' );
    $this->CreateEvent( 'OnExpireUser' );
    $this->CreateEvent( 'OnCreateUser' );
    $this->CreateEvent( 'OnDeleteUser' );
    $this->CreateEvent( 'OnUpdateUser' );
    $this->CreateEvent( 'OnCreateGroup' );
    $this->CreateEvent( 'OnUpdateGroup');
    $this->CreateEvent( 'OnDeleteGroup' );
    $this->CreateEvent(' OnRefreshUser' );

//$this->AddEventHandler( 'Core', 'ContentPostRender', false );

    // permissions
    $this->CreatePermission('Modify FrontEndUserProps',
                            'Modify FrontEndUser Properties');

?>