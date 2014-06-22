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

  /*---------------------------------------------------------
   DisplayAdminReg1TemplateTab($id, $params, $return_id)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _DisplayAdminReg1TemplateTab( &$module, $id, $params, $returnid )
  {
    echo $module->CreateFormStart ($id, 'set_reg1template');
    echo '<p>Registration Template</p>';
    echo '<br/><p>'.$module->CreateTextArea (false, $id,
					   $module->GetTemplate ('selfreg_reg1template'),
					   'reg1_templatecontent', '').'</p>';
    echo '<p>Post Registration Template</p>';
    echo '<br/><p>'.$module->CreateTextArea (false, $id,
					   $module->GetTemplate ('selfreg_postreg1_template'),
					   'postreg1_templatecontent', '').'</p>';
    echo $module->CreateInputSubmit ($id, 'submitbutton',
				   $module->Lang ('submit'));
    echo $module->CreateInputSubmit ($id, 'defaultbutton',
				   $module->Lang ('default'));
    echo $module->CreateFormEnd ();
  }


  /*---------------------------------------------------------
   DisplayAdminReg2TemplateTab($id, $params, $return_id)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _DisplayAdminReg2TemplateTab( &$module, $id, $params, $returnid )
  {
    echo $module->CreateFormStart ($id, 'set_reg2template');
    echo '<br/><p>'.$module->CreateTextArea (false, $id,
					   $module->GetTemplate ('selfreg_reg2template'),
					   'templatecontent', '').'</p>';
    echo $module->CreateInputSubmit ($id, 'submitbutton',
				   $module->Lang ('submit'));
    echo $module->CreateInputSubmit ($id, 'defaultbutton',
				   $module->Lang ('default'));
    echo $module->CreateFormEnd ();
  }


  /*---------------------------------------------------------
   DisplayAdminEmailConfirmationTemplateTab($id, $params, $return_id)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _DisplayAdminEmailConfirmationTemplateTab( &$module, $id, $params, $returnid )
  {
    echo $module->CreateFormStart ($id, 'set_emailconfirm_template');
    echo '<table>';
    echo '<tr valign="top"><td>'.$module->Lang('subject').':*</td><td>'.$module->CreateInputText( $id, 'input_subject',
					    $module->GetPreference('selfreg_emailconfirm_subject'), 80, 200 ).'</td></tr>'; 
    
    echo '<tr valign="top"><td>'.$module->Lang('textbody').':*</td><td>'.$module->CreateTextArea (false, $id,  
					   $module->GetTemplate ('selfreg_emailconfirm_texttemplate'),
					   'texttemplatecontent', '').'</td></tr>';
    echo '<tr valign="top"><td>'.$module->Lang('htmlbody').':</td><td>'.$module->CreateTextArea (false, $id,  
					   $module->GetTemplate ('selfreg_emailconfirm_template'),
					   'templatecontent', '').'</td></tr>';
    echo '</table>';  
    echo $module->CreateInputSubmit ($id, 'submitbutton',
				   $module->Lang ('submit'));
    echo $module->CreateInputSubmit ($id, 'defaultbutton',
				   $module->Lang ('default'));
    echo $module->CreateFormEnd ();
  }


  /*---------------------------------------------------------
   DisplayAdminFinalMessageTemplateTab($id, $params, $return_id)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _DisplayAdminFinalMessageTemplateTab( &$module, $id, $params, $returnid )
  {
    echo $module->CreateFormStart ($id, 'set_finalmessage_template');
    echo '<br/><p>'.$module->CreateTextArea (false, $id,
					   $module->GetTemplate ('selfreg_finalmessage_template'),
					   'templatecontent', '').'</p>';
    echo $module->CreateInputSubmit ($id, 'submitbutton',
				   $module->Lang ('submit'));
    echo $module->CreateInputSubmit ($id, 'defaultbutton',
				   $module->Lang ('default'));
    echo $module->CreateFormEnd ();
  }


  /*---------------------------------------------------------
   DisplayAdminEmailUserEditedTemplateTab($id, $params, $return_id)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _DisplayAdminEmailUserEditedTemplateTab( &$module, $id, $params, $returnid )
  {
    echo $module->CreateFormStart ($id, 'set_emailuseredited_template');
    echo '<table>';
    echo '<tr valign="top"><td>'.$module->Lang('subject').':*</td><td>'.$module->CreateInputText( $id, 'input_subject',
					    $module->GetPreference('selfreg_emailuseredited_subject'), 80, 200 ).'</td></tr>'; 
    
    echo '<tr valign="top"><td>'.$module->Lang('textbody').':*</td><td>'.$module->CreateTextArea (false, $id,  
					   $module->GetTemplate('selfreg_emailuseredited_texttemplate'),
					   'texttemplatecontent', '').'</td></tr>';
    echo '<tr valign="top"><td>'.$module->Lang('htmlbody').':</td><td>'.$module->CreateTextArea (false, $id,  
					   $module->GetTemplate('selfreg_emailuseredited_template'),
					   'templatecontent', '').'</td></tr>';
    echo '</table>';  
    echo $module->CreateInputSubmit ($id, 'submitbutton',
				   $module->Lang ('submit'));
    echo $module->CreateInputSubmit ($id, 'defaultbutton',
				   $module->Lang ('default'));
    echo $module->CreateFormEnd ();
  }


  /*---------------------------------------------------------
   DisplayAdminSendAnotherEmailTemplateTab($id, $params, $return_id)
   NOT PART OF THE MODULE API
   ---------------------------------------------------------*/
function _DisplayAdminSendAnotherEmailTemplateTab( &$module, $id, $params, $returnid )
  {
    echo $module->CreateFormStart ($id, 'set_sendanotheremail_template');
    echo '<br/>'.$module->Lang('title_sendanotheremail_template').
      '<p>'.$module->CreateTextArea (false, $id,
				   $module->GetTemplate ('selfreg_sendanotheremail_template'),
				   'templatecontent', '').'</p>';
    echo '<br/>'.$module->Lang('title_post_sendanotheremail_template').
      '<p>'.$module->CreateTextArea (false, $id,
					   $module->GetTemplate ('selfreg_post_sendanotheremail_template'),
					   'templatecontent2', '').'</p>';
    echo $module->CreateInputSubmit ($id, 'submitbutton',
				   $module->Lang ('submit'));
    echo $module->CreateInputSubmit ($id, 'defaultbutton',
				   $module->Lang ('default'));
    echo $module->CreateFormEnd ();
  }

?>
