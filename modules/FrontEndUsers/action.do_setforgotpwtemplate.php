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
if( !$this->_HasSufficientPermissions( 'templates' ) ) return;

if( isset( $params['defaults'] ) ) {
  $fn = dirname(__FILE__).'/templates/orig_forgotpassword1.tpl';
  $this->SetTemplate('feusers_forgotpasswordform', file_get_contents($fn) );
  
  $fn = dirname(__FILE__).'/templates/orig_forgotpassword2.tpl';
  $this->SetTemplate('feusers_forgotpasswordemailform', file_get_contents($fn) );
  
  $fn = dirname(__FILE__).'/templates/orig_forgotpassword3.tpl';
  $this->SetTemplate('feusers_forgotpasswordverifyform',file_get_contents($fn));
  $this->SetMessage($this->Lang('template_resetdefaults'));
}
else {
  $this->SetTemplate('feusers_forgotpasswordform', $params['templatecontent1']);
  $this->SetTemplate('feusers_forgotpasswordemailform', $params['templatecontent2']);;
  $this->SetTemplate('feusers_forgotpasswordverifyform', $params['templatecontent3']);;
  $this->SetMessage($this->Lang('template_saved'));
 }
$this->RedirectToTab($id, 'forgotpassword_template', '', 'admin_templates' );

#
# EOF
#
?>