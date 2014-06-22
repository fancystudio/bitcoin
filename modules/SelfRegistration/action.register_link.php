<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: SelfRegistration (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to register themselves
#  with a website.
# 
# Version: 1.2
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

$onlyhref = false;
$linktext = $this->Lang('user_registration');
$inline = $this->GetPreference('inline_forms',true);

if( !isset($params['group']) ) return;

if( isset($params['destpage']) )
  {
    $destpage = trim($params['destpage']);
    $contentops = $gCms->GetContentOperations();
    $destpageid = $contentops->GetPageIDFromAlias($destpage);
    if( $destpageid ) $returnid = $destpageid;
    unset($params['destpage']);
  }
if( isset($params['onlyhref']) )
  {
    $onlyhref = (int)$params['onlyhref'];
    unset($params['onlyhref']);
  }
if( isset($params['returnid']) )
  {
    $returnid = (int)$params['returnid'];
    unset($params['returnid']);
  }
if( isset($params['linktext']) )
  {
    $linktext = trim($params['linktext']);
    unset($params['linktext']);
  }
if( isset($params['noinline']) )
  {
    $inline = false;
    unset($params['noinline']);
  }

$params['mode'] = 'signup';
$pretty_url = "Selfreg/register/{$returnid}/{$params['group']}";
$output = $this->CreateLink($id,'default',$returnid,$linktext,$params,'',$onlyhref,$inline,'',false,$pretty_url);
echo $output;

#
# EOF
#
?>