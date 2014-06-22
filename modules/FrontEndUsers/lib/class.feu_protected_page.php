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

class feu_protected_page extends Content
{
  private $_data;
  const FEU_PROPNAME = '__feu_date__'; // oops: typo, can't change it now though.
  const TAB_FEU = 'cc_feu';

  private function _getData()
  {
    if( !is_array($this->_data) ) {
      $tmp = $this->GetPropertyValue(self::FEU_PROPNAME);
      $this->_data = array();
      if( $tmp ) $this->_data = unserialize($tmp);
    }
  }

  private function _setData()
  {
    if( is_array($this->_data) && count($this->_data) ) {
      $this->SetPropertyValue(self::FEU_PROPNAME,serialize($this->_data));
    }
    else {
      $this->SetPropertyValue(self::FEU_PROPNAME,'');
    }
  }

  private function _isAuthorized()
  {
    // do we have access to it?
    $this->_getData();

    $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
    if( !$feu ) return FALSE;
    $uid = $feu->LoggedInId();
    if( !$uid ) return FALSE; // not logged in is a false.

    if( !isset($this->_data['groups']) || count($this->_data['groups']) == 0 ) {
      return TRUE;
      // no member groups selected, but still logged in, we can display this.
    }

    // get member groups and do a cross reference.
    $groups = $feu->GetMemberGroupsArray($uid);
    if( !is_array($groups) || count($groups) == 0 ) return FALSE;
    $membergroups = cge_array::extract_field($groups,'groupid');
    for( $i = 0; $i < count($this->_data['groups']); $i++ ) {
      if( in_array($this->_data['groups'][$i],$membergroups) ) return TRUE;
    }

    // no match.
    return FALSE;
  }

  public function FriendlyName()
  {
    return cms_utils::get_module(MOD_FRONTENDUSERS)->Lang(get_class());
  }

  public function GetModifiedDate()
  {
    // on frontend requests this will force the template to be recompiled
    // and therefore evaluation to be done for each request.
    if( cmsms()->is_frontend_request() ) return time();
    return parent::GetModifiedDate();
  }

  public function SetProperties()
  {
    parent::SetProperties();
    $this->RemoveProperty('cachable',false);
    $captcha = cms_utils::get_module('Captcha');
    if( version_compare(CMS_VERSION,'1.98') < 0 ) {
        $this->AddContentProperty('__feu_groups__',1);
        if( is_object($captcha) ) $this->AddContentProperty('__feu_captcha__',2);
    }
    else {
      $this->AddProperty('__feu_groups__',1,self::TAB_FEU);
      if( is_object($captcha) ) $this->AddProperty('__feu_captcha__',1,self::TAB_FEU);
    }
  }

  public function Show($param = '')
  {
    $smarty = cmsms()->GetSmarty();
    $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
    if( !$feu ) return; // todo: throw exception here.

    $action = $feu->GetPreference('pagetype_action','showlogin');
    $smarty->assign('show_what',$param,TRUE);
    $auth = $this->_isAuthorized()?1:0;
    if( $auth ) $smarty->assign('output',parent::Show($param));
    $smarty->assign('feu_authorized',$auth,TRUE);
    $smarty->assign('action',$action,TRUE);
    $smarty->assign('feu_page',$feu->GetPreference('pagetype_redirectto',-1),TRUE);
    $this->_getData();
    $smarty->assign('docaptcha',1,TRUE);
    if( isset($this->_data['captcha']) && $this->_data['captcha'] == 0 ) $smarty->assign('docaptcha',0,TRUE);

    $tpl = file_get_contents($feu->GetModulePath().'/templates/protectedcontent.tpl');
    return $feu->ProcessTemplateFromData($tpl);
  }

  // CMSMS 1.11.x and previous only
  public function TabNames()
  {
    $res = parent::TabNames();
    if( check_permission(get_userid(),'Manage All Content') ) {
      $res[] = cms_utils::get_module(MOD_FRONTENDUSERS)->Lang('frontend_access');
    }
    return $res;
  }

  // CMSMS 1.11.x and previous only
  public function EditAsArray($adding = false, $tab = 0, $showadmin = false)
  {
    $names = $this->TabNames();
    $str = cms_utils::get_module(MOD_FRONTENDUSERS)->Lang('frontend_access');
    if( !isset($names[$tab]) || $names[$tab] != $str ) return parent::EditAsArray($adding,$tab,$showadmin);

    $ret = array();
    // the permissions tab.
    $feu = cms_utils::get_module('FrontEndUsers');
    $grouplist = array_flip($feu->GetGroupList());

    $this->_getData();
    if( !isset($this->_data['groups']) ) {
      $tmp = explode(',',$feu->GetPreference('pagetype_groups'));
      if( is_array($tmp) && count($tmp) ) $this->_data['groups'] = $tmp;
    }
    $size = min(count($grouplist),10);
    $tmp = array($feu->Lang('groups').':');
    $opt = '<select name="__feu_groups__[]" multiple="multiple" size="'.$size.'">';
    foreach( $grouplist as $gid => $gname ) {
      $selected = '';
      if( isset($this->_data['groups']) && in_array($gid,$this->_data['groups']) ) $selected='selected="selected" ';
      $opt .= '<option '.$selected.'value="'.$gid.'">'.$gname.'</option>';
    }
    $opt .= '</select><br/>'.$feu->Lang('info_contentpage_grouplist');
    $tmp[] = $opt;
    $ret[] = $tmp;

    $captcha = $feu->GetModuleInstance('Captcha');
    if( is_object($captcha) ) {
      $val = (isset($this->_data['captcha']))?$this->_data['captcha']:1;
      $tmp = array($feu->Lang('enable_captcha').':');
      $tmp[] = $feu->CreateInputYesNoDropdown('','__feu_captcha__',$val).'<br/>'.$feu->Lang('info_enable_captcha');
      $ret[] = $tmp;
    }
    return $ret;
  }

  // CMSMS 2.0
  public function GetTabNames()
  {
    $out = parent::GetTabNames();
    if( !check_permission(get_userid(),'Manage All Content') ) {
      if( isset($out[self::TAB_FEU]) ) unset($out[self::TAB_FEU]);
    }
    else {
      if( isset($out[self::TAB_FEU]) ) $out[self::TAB_FEU] = cms_utils::get_module(MOD_FRONTENDUSERS)->Lang('frontend_access');
    }
    return $out;
  }

  public function FillParams($params,$editing = false)
  {
    $this->_getData();
    if( isset($params['__feu_groups__']) ) {
      $this->_data['groups'] = $params['__feu_groups__'];
    }
    else if( isset($this->_data['groups']) ) {
      unset($this->_data['groups']);
    }
    if( isset($params['__feu_captcha__']) ) $this->_data['captcha'] = $params['__feu_captcha__'];
    parent::FillParams($params,$editing);
    $this->SetCachable(false);
  }

  public function ShowInMenu()
  {
    $res = parent::ShowInMenu();
    if( !$res ) return $res;
    return $this->_isAuthorized();
  }

  public function Save()
  {
    $this->_setData();
    return parent::Save();
  }

  // possible for 1.11.x, required for CMSMS 2.0
  protected function display_single_element($one,$adding)
  {
      $feu = cms_utils::get_module(MOD_FRONTENDUSERS);

      switch( $one ) {
      case '__feu_groups__':
          $ret = array();
          // the permissions tab.
          $grouplist = array_flip($feu->GetGroupList());

          $this->_getData();
          if( !isset($this->_data['groups']) ) {
              $tmp = explode(',',$feu->GetPreference('pagetype_groups'));
              if( is_array($tmp) && count($tmp) ) $this->_data['groups'] = $tmp;
          }
          $size = min(count($grouplist),10);
          $tmp = array($feu->Lang('groups').':');
          $opt = '<select name="__feu_groups__[]" multiple="multiple" size="'.$size.'">';
          foreach( $grouplist as $gid => $gname ) {
              $selected = '';
              if( isset($this->_data['groups']) && in_array($gid,$this->_data['groups']) ) $selected='selected="selected" ';
              $opt .= '<option '.$selected.'value="'.$gid.'">'.$gname.'</option>';
          }
          $opt .= '</select><br/>'.$feu->Lang('info_contentpage_grouplist');
          $tmp[] = $opt;
          return $tmp;

      case '__feu_captcha__':
          $captcha = $feu->GetModuleInstance('Captcha');
          if( is_object($captcha) ) {
              $val = (isset($this->_data['captcha']))?$this->_data['captcha']:1;
              $tmp = array($feu->Lang('enable_captcha').':');
              $tmp[] = $feu->CreateInputYesNoDropdown('','__feu_captcha__',$val).'<br/>'.$feu->Lang('info_enable_captcha');
              return $tmp;
          }
          break;

      default:
          return parent::display_single_element($one,$adding);
      }
  }

} // end of class

#
# EOF
#
?>