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

switch( $oldversion ) {
 case '1.0.3':
   {
     $this->SetPreference('selfreg_emailconfirm_subject', $this->Lang('registration_confirmation'));
     $this->SetTemplate('selfreg_emailconfirm_texttemplate', $this->dflt_emailconfirm_texttemplate);
     $this->SetPreference('selfreg_useredited_subject', $this->Lang('registration_confirmation'));
     $this->SetPreference('selfreg_force_email_twice',0);
     $this->SetTemplate('selfreg_useredited_template', $this->dflt_emailuseredited_template);
     $this->SetTemplate('selfreg_useredited_texttemplate', $this->dflt_emailuseredited_texttemplate);
     $this->SetTemplate('selfreg_sendanotheremail_template', $this->dflt_sendanotheremail_template );
     $this->SetTemplate('selfreg_post_sendanotheremail_template', $this->dflt_post_sendanotheremail_template );

     // Permissions
     $this->RemovePermission('Modify SelfRegistration');
     $this->CreatePermission('Manage Registering Users','Manage Registering Users');
     // notice, no brerak
   }

 case '1.0.4':
   {
     $this->CreateEvent('onNewUser');
     $this->CreateEvent('onUserRegistered');
   }

 case '1.1.0':
 case '1.1.1':
 case '1.1.2':
 case '1.1.3':
 case '1.1.5':
 case '1.1.6':
 case '1.2.1':
 case '1.2.2':
 case '1.2.3':
 case '1.2.4':
 case '1.2.5':
 case '1.2.6':
 case '1.3':
 case '1.3.1':
 case '1.3.2':
 case '1.3.3':
   {
     $db = $this->GetDb();
     $dict = NewDataDictionary($db);
     $sqlarray = $dict->AddcolumnSQL(cms_db_prefix()."module_selfreg_users", "overwrite_uid I");
     $dict->ExecuteSQLArray($sqlarray);	
   }

 case '1.4':
 case '1.4.1':
 case '1.4.2':
 case '1.4.3': // just in case.
 case '1.5':
   {
     $db = $this->GetDb();
     $dict = NewDataDictionary($db);
     $taboptarray = array('mysql' => 'TYPE=MyISAM');

     $flds = 'id I AUTO KEY,
              name C(255) NOT NULL KEY,
              prompt C(255) NOT NULL,
              description X,
              gid I NOT NULL,
              subscr_num I,
              subscr_type C(10),
              cost F';
     $sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_selfreg_paidpkgs', $flds,$taboptarray);
     $dict->ExecuteSQLArray($sqlarray);

     $this->SetTemplate('selpkgtemplate', @file_get_contents(__DIR__.'/templates/orig_selpkg_template.tpl'));

     $this->AddEventHandler('CGEcommerceBase','CartAdjusted',false);
     $this->AddEventHandler('CGEcommerceBase','OrderCreated',false);
     $this->AddEventHandler('CGEcommerceBase','OrderUpdated',false);
     $this->AddEventHandler('CGEcommerceBase','OrderDeleted',false);
   }

 case '1.6':
 case '1.6.1':
 case '1.6.2':
   {
     $this->AddEventHandler('Core','ModuleInstalled',false);
     $this->AddEventHandler('Core','ModuleInstalled',false);
     $this->AddEventHandler('Core','ModuleUninstalled',false);
   }
 } // switch

if( version_compare($oldversion,'1.8') < 0 ) {
  $db = $this->GetDb();
  $dict = NewDataDictionary($db);
  $flds = "user I KEY NOT NULL,
           gid  I KEY NOT NULL";
  $sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_selfreg_grps',$flds,$taboptarray);
  $dict->ExecuteSQLArray( $sqlarray );

  $query = 'SELECT id,group_id FROM '.cms_db_prefix().'module_selfreg_users';
  $tmp = $db->GetArray($query);
  if( is_array($tmp) && count($tmp) ) {
    $iquery = 'INSERT INTO '.cms_db_prefix().'module_selfreg_grps (user,gid) VALUES (?,?)';
    foreach( $tmp as $one ) {
      $db->Execute($iquery,array($one['id'],$one['group_id']));
    }
  }

  // todo, drop group id column from selfreg_users table.
}

?>