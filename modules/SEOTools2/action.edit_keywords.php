<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Action: edit_keywords
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
if (!isset($_REQUEST['content_id']))
  return;

$db = cmsms()->GetDb();
$smarty = cmsms()->GetSmarty();
$contentops = cmsms()->GetContentOperations();
$cont_id = $_REQUEST['content_id'] ;
$content_obj = $contentops->LoadContentFromId($cont_id);

if (isset($_POST['set_keywords'])) {
	$query = "INSERT INTO ".cms_db_prefix()."module_seotools2 SET content_id = ?, keywords = ?, indexable = 1 ON DUPLICATE KEY UPDATE keywords = ?";
	if (!$result = $db->Execute($query,array($cont_id, $_POST['keywords'],$_POST['keywords']))){
	  echo $db->sql;
	  die;
	}
	$this->redirect(null, 'defaultadmin', null, Array('tab'=>'pagedescriptions'));
}

$query = "SELECT * FROM ".cms_db_prefix().'module_seotools2 WHERE content_id = ?';
if (!$result = $db->Execute($query,array($cont_id))) {
  echo 'this is the fail<br />';
  echo $db->sql;
  die;
}

$info = $result->fetchRow();

if (!isset($info['keywords']) || $info['keywords'] == '') {
  	$info['keywords'] = strtolower(implode(', ',seo2_utils::getKeywordSuggestions($cont_id)));
}


$output  = $this->CreateFormStart(null, 'edit_keywords');
$output .= $this->CreateInputHidden(null, 'content_id', $cont_id);
$output .= '<p class="pagetext">'.$this->Lang('enter_new_keywords').':</p>';

$output .= '<p class="pageinput">'.$this->CreateTextArea(false, null, $info['keywords'], 'keywords').' '.$this->Lang('help_new_keywords').'</p>';

$output .= '<p class="pagetext"></p>';
$output .= '<p class="pageinput">'.$this->CreateInputSubmit(null, 'set_keywords',$this->lang('save')).'</p>';

$output .= $this->CreateFormEnd();

$output .= '<br /><br />';

// Get the main content block
$content_en = $content_obj->GetPropertyValue('content_en');

if (isset($content_en)) {
  $output .= '<p class="pagetext">'.$this->Lang('page_name').':</p>';
  
  $output .= '<p class="pageinput">'.$content_obj->Name().'</p>';
  $output .= '<p class="pagetext">'.$this->Lang('admin_view').':</p>';
  $output .= '<div class="pageinput">'.seo2_utils::compile_udts($content_en).'</div>';
    
  // Get the meta description
  $metadescription = $content_obj->GetPropertyValue($this->GetPreference('description_block'));
  
      $output .= '<br /><br /><p class="pagetext">'.$this->Lang('metadescription_content').':</p>';
  
  if (!empty($metadescription)) {
      $output .= '<div class="pageinput">'.seo2_utils::compile_udts($metadescription).'</div>';
    
  } else {
    $output .= '<p class="pageinput">'.$this->Lang('no_metadescription').':</p>';
  }
  
}
$output .= '<br /><br /><p><a href="editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$cont_id.'">'.$this->Lang('edit_page').'</a> ';
$output .= '<a href="'.$content_obj->GetURL().'" target="_blank">'.$this->Lang('view_page').'</a></p>';

echo $output;
?>