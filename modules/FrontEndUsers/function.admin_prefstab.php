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

// fill out the template
$smarty->assign('startform',$this->CreateFormStart( $id, 'do_setprefs'));

$months = array();
for( $i = 520; $i > 0; $i-- )
  {
    $months[$i] = $i;
  }

$smarty->assign('auto_create_unknown',$this->GetPreference('auto_create_unknown',0));

$auth_modules = module_helper::get_modules_with_method('GetFEUAuthConsumer');
$auth_modules = cge_array::hash_prepend($auth_modules,'__BUILTIN__',$this->Lang('auth_builtin'));
$smarty->assign('auth_modules',$auth_modules);
$smarty->assign('auth_module',$this->GetPreference('auth_module','__BUILTIN__'));

$smarty->assign('input_randomusername',
		RRUtils::myCreateInputCheckbox($id, 'input_randomusername', 1,
					       $this->GetPreference('use_randomusername',0)));

$smarty->assign('input_expireage',
		$this->CreateInputDropdown($id,'input_expireage',$months,-1,
                                          $this->GetPreference('expireage_months',120)));
   
$smarty->assign('prompt_sessiontimeout', $this->Lang('prompt_sessiontimeout'));
$smarty->assign('input_sessiontimeout', 
		$this->CreateInputText($id, 'input_sessiontimeout',
				       $this->GetPreference('user_session_expires'), 6, 6 ));


$smarty->assign('prompt_feusers_specific_permissions',
		$this->Lang('prompt_feusers_specific_permissions'));
$smarty->assign('input_feusers_specific_permissions',
		RRUtils::myCreateInputCheckbox($id, 'input_feusers_specific_permissions', 1,
					       $this->GetPreference('feusers_specific_permissions')));
$smarty->assign('info_feusers_specific_permissions', $this->Lang('info_feusers_specific_permissions'));



$smarty->assign('submit',
		$this->CreateInputSubmit ($id, 'submit',
					  $this->Lang('submit'),'','',
					  $this->Lang('confirm_submitprefs')));
$smarty->assign ('cancel',
		 $this->CreateInputSubmit ($id, 'cancel',
					   $this->Lang('cancel')));

$smarty->assign('prompt_allow_repeated_logins',
		$this->Lang('prompt_allow_repeated_logins'));
$smarty->assign('input_allow_repeated_logins',
		RRUtils::myCreateInputCheckbox( $id, 'input_allow_repeated_logins', 1,
						$this->GetPreference('allow_repeated_logins')));


$smarty->assign('prompt_image_destination_path',
				$this->Lang('prompt_image_destination_path'));
$smarty->assign('input_image_destination_path',
				$this->CreateInputText($id,'input_image_destination_path',
									   $this->GetPreference('image_destination_path'),40));
$smarty->assign('prompt_allowed_image_extensions',
				$this->Lang('prompt_allowed_image_extensions'));
$smarty->assign('input_allowed_image_extensions',
				$this->CreateInputText($id,'input_allowed_image_extensions',
						       $this->GetPreference('allowed_image_extensions'),40,40));

$notification_list = array();
$notification_list[$this->Lang('OnLogin')] = 'OnLogin';
$notification_list[$this->Lang('OnLogout')] = 'OnLogout';
$notification_list[$this->Lang('OnExpireUser')] = 'OnExpireUser';
$notification_list[$this->Lang('OnCreateUser')] = 'OnCreateUser';
$notification_list[$this->Lang('OnDeleteUser')] = 'OnDeleteUser';
$notification_list[$this->Lang('OnUpdateUser')] = 'OnUpdateUser';
$notification_list[$this->Lang('OnCreateGroup')] = 'OnCreateGroup';
$notification_list[$this->Lang('OnUpdateGroup')] = 'OnUpdateGroup';
$notification_list[$this->Lang('OnDeleteGroup')] = 'OnDeleteGroup';
$smarty->assign('prompt_notifications',$this->Lang('prompt_notifications'));
$notifications = explode(',',$this->GetPreference('notifications',''));
$smarty->assign('input_notifications',
		$this->CreateInputSelectList($id,'notifications[]',$notification_list, $notifications));

$smarty->assign('prompt_notification_address',$this->Lang('prompt_notification_address'));
$smarty->assign('input_notification_address',
		$this->CreateInputText($id,'notification_address',
				       $this->GetPreference('notification_address'),50,255));

$smarty->assign('prompt_notification_subject',$this->Lang('prompt_notification_subject'));
$smarty->assign('input_notification_subject',
		$this->CreateInputText($id,'notification_subject',
				       $this->GetPreference('notification_subject'),50,255));

$smarty->assign('prompt_notification_template',$this->Lang('prompt_notification_template'));
$smarty->assign('input_notification_template',
		$this->CreateTextArea(false,$id,
				      $this->GetTemplate('notification_template'),
				      'notification_template'));

$smarty->assign('info_star',$this->Lang('info_star'));
$num = $this->CountTempCodeRecords();
if( $num )
    {
      $smarty->assign('prompt_numresetrecords',
		      $this->Lang('prompt_numresetrecord'));
      $smarty->assign('data_numresetrecords', $num); //todo
      $smarty->assign('input_removeall',
		      $this->CreateInputSubmit($id,'input_removeall',
					       $this->Lang('removeall'),
					       'onclick="return confirm(\''.$this->Lang('areyousure').'\')"'));
      $smarty->assign('input_remove1week',
		      $this->CreateInputSubmit($id,'input_remove1week',
					       $this->Lang('remove1week'),
					       'onclick="return confirm(\''.$this->Lang('areyousure').'\')"'));
      
      $smarty->assign('input_remove1month',
		      $this->CreateInputSubmit($id,'input_remove1month',
					       $this->Lang('remove1month'),
					       'onclick="return confirm(\''.$this->Lang('areyousure').'\')"'));
    }

$smarty->assign('forcelogout_times',$this->GetPreference('forcelogout_times'));
$smarty->assign('forcelogout_sessionage',$this->GetPreference('forcelogout_sessionage'));
$smarty->assign('expireusers_interval',$this->GetPreference('expireusers_interval'));

$tmp = explode(',',$this->GetPreference('pagetype_groups',''));
$smarty->assign('pagetype_groups',$tmp);
$groups1 = $this->GetGroupList();
$smarty->assign('all_groups',array_flip($groups1));
$tmp = array('showlogin'=>$this->Lang('showloginform'),'redirect'=>$this->Lang('redirect'));
$smarty->assign('pagetype_action_opts',$tmp);
$smarty->assign('pagetype_action',$this->GetPreference('pagetype_action','showlogin'));
$contentops = cmsms()->GetContentOperations();
$smarty->assign('pagetype_redirectto',
		$contentops->CreateHierarchyDropdown(-1,$this->GetPreference('pagetype_redirectto'),$id.'pagetype_redirectto',TRUE));

$smarty->assign('endform',$this->CreateFormEnd());
echo $this->ProcessTemplate('adminprefs.tpl');

// EOF
?>
