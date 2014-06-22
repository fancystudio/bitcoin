<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: SelfRegistration (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to register themselves
#  with a website.
# 
# Version: 1.1.5
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
if( !isset($gCms) ) exit;

require_once(__DIR__.'/functions.adminpanel.php');

// the tabs
echo $this->StartTabHeaders();

if( $this->CheckPermission('Manage Registering Users' ) )
  {
    echo $this->SetTabHeader('adminusers',$this->Lang('users'));
  }
			       
if( $this->CheckPermission('Modify Templates' ) )
  {
    echo $this->SetTabHeader('selpkgtemplate',$this->Lang('selpkg_template'));
    echo $this->SetTabHeader('reg1template', $this->Lang('registration1_template'));
    echo $this->SetTabHeader('reg2template', $this->Lang('registration2_template'));
    echo $this->SetTabHeader('emailconfirm_template', $this->Lang('emailconfirm_template'));
    echo $this->SetTabHeader('emailuseredited_template', $this->Lang('emailuseredited_template'));
    echo $this->SetTabHeader('finalmessage_template',$this->Lang('finalmessage_template'));
    echo $this->SetTabHeader('sendanotheremail_template',
			     $this->Lang('sendanotheremail_template'));
  }

if( $this->CheckPermission('Modify Site Preferences') )
  {
    echo $this->SetTabHeader('preferences', $this->Lang('preferences'));
    echo $this->SetTabHeader('regpkgs',$this->Lang('regpkgs_tab'));
  }
echo $this->EndTabHeaders();

// the content of the tabs
echo $this->StartTabContent();

if( $this->CheckPermission('Manage Registering Users' ) )
  {
    echo $this->StartTab('adminusers',$params);
    include(__DIR__.'/function.admin_userstab.php');
    echo $this->EndTab();
  }

if( $this->CheckPermission('Modify Templates' ) )
  {
    echo $this->StartTab('selpkgtemplate',$params);
    include(__DIR__.'/function.admin_selpkg_template_tab.php');
    echo $this->EndTab();

    echo $this->StartTab('reg1template',$params);
    _DisplayAdminReg1TemplateTab( $this, $id, $params, $returnid );
    echo $this->EndTab();
	
    echo $this->StartTab('reg2template',$params);
    _DisplayAdminReg2TemplateTab( $this, $id, $params, $returnid );
    echo $this->EndTab();
	
    echo $this->StartTab('emailconfirm_template',$params);
    _DisplayAdminEmailConfirmationTemplateTab( $this, $id, $params, $returnid );
    echo $this->EndTab();
	
    echo $this->StartTab('emailuseredited_template',$params);
    _DisplayAdminEmailUserEditedTemplateTab( $this, $id, $params, $returnid );
    echo $this->EndTab();
	
    echo $this->StartTab('finalmessage_template',$params);
    _DisplayAdminFinalMessageTemplateTab( $this, $id, $params, $returnid );
    echo $this->EndTab();

    echo $this->StartTab('sendanotheremail_template',$params);
    _DisplayAdminSendAnotherEmailTemplateTab( $this, $id, $params, $returnid );
    echo $this->EndTab();
  }

if( $this->CheckPermission('Modify Site Preferences') )
  {
    echo $this->StartTab('preferences',$params);
    include(__DIR__.'/function.admin_prefstab.php');
    echo $this->EndTab();

    echo $this->StartTab('regpkgs',$params);
    include(__DIR__.'/function.admin_paidregistration_tab.php');
    echo $this->EndTab();
  }

echo $this->EndTabContent();



// EOF
?>