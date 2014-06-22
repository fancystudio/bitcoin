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

if (!isset($gCms)) exit();
if (!$this->CheckPermission('Modify Site Preferences')) return false;

if( isset($params['submit_template']) ) {
  if( isset($params['error_template'] ) ) $this->SetErrorTemplate(trim($params['error_template']));
}
else if( isset($params['resettofactory']) ) {
  $this->ResetErrorTemplate();
}
else if( isset($params['graphical_submit']) ) {
  $this->SetPreference('watermark_text',trim($params['watermark_text']));
  $this->SetPreference('watermark_textsize',(int)($params['watermark_textsize']));
  $angle = (int)$params['watermark_angle'];
  $angle = min(359,$angle);
  $angle = max(0,$angle);
  $this->SetPreference('watermark_textangle',sprintf("%d",$angle));
  $this->SetPreference('watermark_font',trim($params['watermark_font']));
  $this->SetPreference('watermark_textcolor',trim($params['watermark_textcolor']));
  $this->SetPreference('watermark_bgcolor',trim($params['watermark_bgcolor']));
  $this->SetPreference('watermark_transparent',(int)($params['watermark_transparent']));
  $this->SetPreference('watermark_file',trim($params['watermark_file']));
  $this->SetPreference('watermark_alignment',trim($params['watermark_alignment']));
  $this->SetPreference('watermark_translucency',trim($params['watermark_translucency']));
  $this->SetPreference('thumbnailsize',(int)$params['thumbnailsize']);
  $this->SetPreference('imageextensions',trim($params['imageextensions']));
  $this->SetPreference('allow_watermarking',(int)$params['allow_watermarking']);
  $this->SetPreference('allow_resizing',(int)$params['allow_resizing']);
  $this->SetPreference('delete_orig_image',(int)$params['delete_orig_image']);
  $this->SetPreference('resizeimage',(int)$params['resizeimage']);
  $this->SetPreference('allow_thumbnailing',(int)$params['allow_thumbnailing']);
}
else if( isset($params['cache_submit']) ) {
  $this->SetPreference('cache_lifetime',(int)$params['cache_lifetime']);
  $this->SetPreference('cache_filelock',(int)$params['cache_filelock']);
  $this->SetPreference('cache_autoclean',(int)$params['cache_autoclean']);
}
else if( isset($params['submit']) ) {
  $this->SetPreference('assume_memory_limit',trim($params['assume_memory_limit']));
  $this->SetPreference('alloweduploadfiles',trim($params['alloweduploadfiles']));
  $this->SetPreference('prioritycountries',trim($params['prioritycountries']));
  $pris = explode(',',trim($params['prioritycountries']));
  $db = $this->GetDb();

  $query = 'UPDATE '.CGEXTENSIONS_TABLE_COUNTRIES.' SET sorting = 0';
  $dbr = $db->Execute($query);
  if( !$dbr ) die($db->sql.'<br/>'.$db->ErrorMsg());

  $query = 'UPDATE '.CGEXTENSIONS_TABLE_COUNTRIES.' SET sorting = ? WHERE code = ?';
  $i = 999;
  foreach( $pris as $one ) {
    $dbr = $db->Execute($query,array($i,trim($one)));
    if( !$dbr ) die($db->sql.'<br/>'.$db->ErrorMsg());
    $i--;
  }
}

echo $this->StartTabHeaders();
if ($this->CheckPermission('Modify Site Preferences')) {
  echo $this->SetTabHeader('general',$this->Lang('general_settings'));
  echo $this->SetTabHeader('graphics',$this->Lang('graphics_settings'));
  echo $this->SetTabHeader('cache_settings',$this->Lang('cache_settings'));
}
if( $this->CheckPermission('Modify Templates') ) {
  echo $this->SetTabHeader('sortablelists',$this->Lang('sortablelist_templates'));
  echo $this->SetTabHeader('default_templates',$this->Lang('default_templates'));
}
echo $this->EndTabHeaders();

echo $this->StartTabContent();

if ($this->CheckPermission('Modify Site Preferences')) {
  echo $this->CreateFormStart($id,'defaultadmin',$returnid);
  echo $this->StartTab('general',$params);
  include(__DIR__.'/function.admin_generaltab.php');
  echo $this->EndTab();

  echo $this->StartTab('graphics',$params);
  echo $this->CreateFormStart($id,'defaultadmin',$returnid);
  include(__DIR__.'/function.admin_graphicstab.php');
  echo $this->EndTab();

  echo $this->StartTab('cache_settings');
  include(__DIR__.'/function.admin_cache_settings_tab.php');
  echo $this->EndTab();
  echo $this->CreateFormEnd();
}

if( $this->CheckPermission('Modify Templates') ) {
  echo $this->StartTab('sortablelists');
  include(__DIR__.'/function.admin_sortablelists_tab.php');
  echo $this->EndTab();

  echo $this->StartTab('default_templates');
  include(__DIR__.'/function.admin_default_templates_tab.php');
  echo $this->EndTab();
}
echo $this->EndTabContent();
echo $this->CreateFormEnd();

?>