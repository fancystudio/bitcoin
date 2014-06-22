<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: SelfRegistration (c) 2008-2013 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to register themselves
#  with a website.
# 
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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

$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');

// validations in process
$flds = "
         id I KEY,
         group_id I NOT NULL,
         username C(80) NOT NULL,
         passsword C(32) NOT NULL,
         code C(20) NOT NULL,
         createdate ".CMS_ADODB_DT.",
         overwrite_uid I";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_selfreg_users", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );
$db->CreateSequence( cms_db_prefix()."module_selfreg_users_seq" );

$flds = "user I KEY NOT NULL,
         gid  I KEY NOT NULL";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_selfreg_grps',$flds,$taboptarray);
$dict->ExecuteSQLArray( $sqlarray );

$flds = "id I KEY,
         user I NOT NULL, 
         title C(100) NOT NULL,
         data X 
        "; 
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_selfreg_properties", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );
$db->CreateSequence( cms_db_prefix()."module_selfreg_properties_seq" );

$flds = 'id I AUTO KEY,
         name C(255) NOT NULL,
         prompt C(255) NOT NULL,
         description X,
         gid I NOT NULL,
         subscr_num I,
         subscr_type C(10),
         cost F';
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_selfreg_paidpkgs', $flds,$taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// preferences
$this->SetPreference('require_email_confirmation',1);
$this->SetPreference('send_emails_to','root@localhost.com');
$this->SetPreference('notify_on_registration',1);
$this->SetPreference('selfreg_emailconfirm_subject', $this->Lang('registration_confirmation'));
$this->SetPreference('selfreg_emailuseredited_subject', $this->Lang('registration_info_edited'));
$this->SetPreference('selfreg_force_email_twice',0);

// templates
$this->SetTemplate('selpkgtemplate',@file_get_contents(__DIR__.'/templates/orig_selpkg_template.tpl'));

$this->SetTemplate('selfreg_reg1template', file_get_contents(__DIR__.'/templates/orig_registration1.tpl'));
$this->SetTemplate('selfreg_postreg1_template', file_get_contents(__DIR__.'/templates/orig_postreg1.tpl'));
$this->SetTemplate('selfreg_reg2template', file_get_contents(__DIR__.'/templates/orig_registration2.tpl'));
$this->SetTemplate('selfreg_emailconfirm_template', $this->dflt_emailconfirm_template);
$this->SetTemplate('selfreg_emailconfirm_texttemplate', $this->dflt_emailconfirm_texttemplate);
$this->SetTemplate('selfreg_emailuseredited_template', $this->dflt_emailuseredited_template);
$this->SetTemplate('selfreg_emailuseredited_texttemplate', $this->dflt_emailuseredited_texttemplate);
$this->SetTemplate('selfreg_finalmessage_template', $this->dflt_finalmessage_template);
$this->SetTemplate('selfreg_sendanotheremail_template', $this->dflt_sendanotheremail_template );
$this->SetTemplate('selfreg_post_sendanotheremail_template', $this->dflt_post_sendanotheremail_template );

// Permissions
$this->CreatePermission('Manage Registering Users','Manage Registering Users');

// events
$this->CreateEvent('onNewUser');
$this->CreateEvent('onUserRegistered');

$this->AddEventHandler('CGEcommerceBase','CartAdjusted',false);
$this->AddEventHandler('CGEcommerceBase','OrderCreated',false);
$this->AddEventHandler('CGEcommerceBase','OrderUpdated',false);
$this->AddEventHandler('CGEcommerceBase','OrderDeleted',false);

$this->AddEventHandler('Core','ModuleInstalled',false);
$this->AddEventHandler('Core','ModuleInstalled',false);
$this->AddEventHandler('Core','ModuleUninstalled',false);

?>