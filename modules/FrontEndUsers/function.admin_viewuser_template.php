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
if( !$this->_HasSufficientPermissions('templates') ) return;

$smarty->assign('startform',
		$this->CreateFormStart( $id, 'admin_setviewuser_template'));
$smarty->assign('endform',$this->CreateFormEnd());

$smarty->assign('prompt_template1',$this->Lang('viewuser_template'));
$smarty->assign('input_template1',
		$this->CreateTextArea( false, $id,
			  $this->GetTemplate ('feusers_viewuser'),
				       'viewuser_template'));

$smarty->assign('submit',
		$this->CreateInputSubmit ($id, 'submit',$this->Lang('submit')));
$smarty->assign('defaults',
		$this->CreateInputSubmit ($id, 'defaults',
					  $this->Lang('defaults')));

echo $this->ProcessTemplate('viewuser_templateform.tpl');

/*
 * EOF
 */
?>