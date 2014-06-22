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

if( isset($_SESSION['cge_edittemplate']) ) {
  $params = array_merge($_SESSION['cge_edittemplate'],$params);
  unset($_SESSION['cge_edittemplate']);
}

if( !isset( $params['modname'] ) ) {
  $params['errors'] = $this->Lang('error_insufficientparams');
  $this->Redirect($id,'defaultadmin',$returnid,$params);
  return;
}

$module = $this->GetModuleInstance($params['modname']);
if( !$module ) {
  $params['errors'] = $this->Lang('error_insufficientparams');
  $this->Redirect($id,'defaultadmin',$returnid,$params);
  return;
}

// check if we have a template name
if( !(isset($params['template']) || isset($params['prefix'])) ) {
  $params['errors'] = $this->Lang('error_insufficientparams');
  $module->Redirect($id,'defaultadmin','',$params);
  return;
}

if( !isset($params['mode']) || !isset($params['title']) ) {
  $params['errors'] = $this->Lang('error_insufficientparams');
  $module->Redirect($id,'defaultadmin','',$params);
  return;
}

// handle errors.
if( isset($params['errors']) ) echo $module->ShowErrors($params['errors']);

$params['origaction'] = $params['action'];
$contents = "";
if( $params['mode'] == 'add' ) {
  $smarty->assign('formstart', $this->CreateFormStart ($id, 'do_addtemplate',$returnid,'post','', false, '', $params));
  $smarty->assign('templatename', $this->CreateInputText( $id, 'template', "", 40, 200 ));
  $smarty->assign('hidden',
		  $this->CreateInputHidden($id, 'prefix', $params['prefix']).
		  $this->CreateInputHidden($id, 'cg_activetab', $this->_current_tab));
  if( isset($params['defaulttemplatepref']) && $params['defaulttemplatepref'] != '' ) {
    if( endswith($params['defaulttemplatepref'],'.tpl') ) {
      $contents = @file_get_contents($module->GetModulePath().'/templates/'.$params['defaulttemplatepref']);
    }
    else {
      $contents = $module->GetTemplate($params['defaulttemplatepref']);
      if( !$contents ) $contents = $module->GetPreference($params['defaulttemplatepref']);
    }
  }
 }
else {
  $smarty->assign('formstart', $this->CreateFormStart ($id, 'do_edittemplate',$returnid,'post','', false, '', $params));
  $smarty->assign('templatename',$params['template']);
  $smarty->assign('hidden',
		  $this->CreateInputHidden($id, 'template', $params['template'] ).
		  $this->CreateInputHidden($id, 'cg_activetab', $this->_current_tab));
  $contents = $module->GetTemplate($params['prefix'].$params['template']);
  $smarty->assign('apply',$this->CreateInputSubmit ($id, 'applybutton', $this->Lang('apply')));
}

if( method_exists($module, 'GetEditTemplateMessage') ) {
  $txt = $module->GetEditTemplateMessage($params['prefix']);
  $smarty->assign('template_info',$txt);
}
else if( isset($params['info']) && !empty($params['info']) ) {
  $txt = trim($params['info']);
  for( $i = 0; $i < 5; $i++ ) {
    $tmp = cms_html_entity_decode($txt);
    if( $tmp == $txt ) break;
    $txt = $tmp;
  }
  $smarty->assign('template_info',$txt);
}
if( isset($params['moddesc']) ) $smarty->assign('module_description',trim($params['moddesc']));

$title = trim($params['title']);
for( $i = 0; $i < 5; $i++ ) {
  $tmp = cms_html_entity_decode($title);
  if( $tmp == $title ) break;
  $title = $tmp;
}
$smarty->assign('title',cms_html_entity_decode($title));

$smarty->assign('prompt_templatename',$this->Lang('prompt_templatename'));
$smarty->assign('prompt_template',$this->Lang('prompt_template'));
$smarty->assign('template', $this->CreateSyntaxArea($id,$contents,'templatecontent'));
$smarty->assign('submit',$this->CreateInputSubmit ($id, 'submitbutton', $this->Lang('submit')));
$smarty->assign('cancel',$this->CreateInputSubmit ($id, 'cancel', $this->Lang('cancel')));
$smarty->assign('formend',$this->CreateFormEnd());
echo $this->ProcessTemplate('edittemplate.tpl');

?>