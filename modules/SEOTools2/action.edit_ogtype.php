<?php

#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Action: edit_ogtype
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
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
if (!isset($gCms)) exit;

$db = cmsms()->GetDb();

if (isset($_POST['set_ogtype'])) {
	if ($_POST['og_type'] != "") {
		$query = "INSERT INTO ".cms_db_prefix()."module_seotools2 SET content_id = ".$_POST['content_id'].", ogtype = '".$_POST['og_type']."', indexable = 1 ON DUPLICATE KEY UPDATE ogtype = '".$_POST['og_type']."'";
	}else{
		$query = "UPDATE ".cms_db_prefix()."module_seotools2 SET ogtype = NULL WHERE content_id = ".$_POST['content_id'];
	}
	
	echo $query;
	
	$db->Execute($query);
	$this->Redirect(null, 'defaultadmin', null, Array('tab'=>'pagedescriptions'));
}

$query = "SELECT * FROM ".cms_db_prefix().'module_seotools2 WHERE content_id = '.$_GET['content_id'];
$result = $db->Execute($query);
$info = $result->fetchRow();

$output  = $this->CreateFormStart(null, 'edit_ogtype');
$output .= $this->CreateInputHidden(null, 'content_id', $_GET['content_id']);
$output .= '<p class="pagetext">'.$this->Lang('enter_new_ogtype').':</p>';
$output .= '<p class="pageinput">'.$this->CreateInputText(null, 'og_type', $info['ogtype'], 30, 30).' '.$this->Lang('help_new_ogtype').'</p>';
$output .= '<p class="pageinput"><br />'.$this->Lang('help_opengraph').'<br /><br />';
$output .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'set_ogtype',$this->Lang('save')).'</p>';

$output .= $this->CreateFormEnd();

echo $output;


?>