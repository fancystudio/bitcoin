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
if( !$gCms ) exit();

// if( ! $this->CheckPermission('Modify Templates') )
//   {
//     // todo, permissions message here
//     return;
//   }

$the_action = 'defaultadmin';
if( isset($params['destaction']) )
{
  $the_action = trim($params['destaction']);
}


if( !isset( $params['modname'] ) )
  {
    $module->SetError($this->Lang('error_missingparam'));
    $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
    return;
  }
$module = $this->GetModuleInstance($params['modname']);
if( !$module )
  {
    $module->SetError($this->Lang('error_missingparam'));
    $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
    return;
  }


if( isset( $params['cancel'] ) )
  {
    $module->_current_tab = $this->_current_tab;
    $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
  }


$template = "";
if( isset( $params['template'] ) )
  {
    $template = trim($params['template']);
    if($template == '' || !preg_match('/^[a-zA-Z0-9\_]+$/',$template) ) {
      $module->SetError($this->Lang('error_templatenamebad'));
      $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
    }
    $template = munge_string_to_url(trim($template));
  }
  
$prefix = "";
if( isset( $params['prefix'] ) )
  {
    $prefix = trim($params['prefix']);
  }

if( !isset($params['templatecontent']) || empty($params['templatecontent']) )
  {
    $module->SetError($this->Lang('error_missingparam'));
    $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
    return;
  }

if( $template == "" || $prefix == "" )
  {
    $module->SetError($this->Lang('error_missingparam'));
    $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
    return;
  }


$newtemplate = $prefix . $template;

// check if this template already exists
$txt = trim($module->GetTemplate($newtemplate));
if( $txt != "" )
  {
    $module->SetError($this->Lang('error_templatenameexists'));
    $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
    return;
  }

// we're ready to set it
$text = $params['templatecontent'];
//$text = cms_html_entity_decode($params['templatecontent'],ENT_QUOTES,get_encoding());
$module->SetTemplate($newtemplate,$text);
audit('',$module->GetName(),'Added Template '.$newtemplate);

if( $this->_current_tab != '' )
  {
    $module->RedirectToTab($id,$this->_current_tab,'',$the_action);
    return;
  }
$module->Redirect($id,$the_action);

?>