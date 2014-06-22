<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Tab: Page Settings
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
if( !isset($gCms) ) exit;
$db = cmsms()->GetDb();
$root_url = empty($_SERVER['HTTPS']) ? $config['root_url'] : $config['ssl_url'];
  $pagesettings  = '<table class="pagetable">';
  $pagesettings .= '<tr>';
  $pagesettings .= '<th>'.$this->lang('page_id').'</th>';
  $pagesettings .= '<th>'.$this->lang('page_name').'</th>';
  $pagesettings .= '<th>'.$this->lang('priority').'</th>';
  $pagesettings .= '<th>'.$this->lang('og_type').'</th>';
  $pagesettings .= '<th>'.$this->lang('keywords').'</th>';
  $pagesettings .= '<th>'.$this->lang('description').'</th>';
  $pagesettings .= '<th>'.$this->lang('index').'</th>';
  $pagesettings .= '<th>'.$this->lang('follow').'</th>';
  $pagesettings .= '</tr>';


	$all_content = cmsms()->GetContentOperations()->GetAllContent();
	foreach ($all_content as $content_obj) {
		if ($content_obj->Active() !== true)
			continue;
		$prefix = "";
		$auto_priority = 80;
		for ($i = 0; $i < substr_count($content_obj->Hierarchy(),'.'); $i++) {
		  $prefix .= '&raquo; ';
		  $auto_priority  = $auto_priority / 2;
		}
		if ($content_obj->DefaultContent() == 1) {
		  $auto_priority = 100;
		}

		$description = $content_obj->GetPropertyValue(str_replace(' ','_',$this->GetPreference('description_block','')));
		
		
		$query = "SELECT * FROM ".cms_db_prefix().'module_seotools2 WHERE content_id = ?';
        if (!$result = $db->Execute($query,array($content_obj->Id()))) {
          echo 'this is the fail<br />';
          echo $db->sql;
          die;
        }
        
        $kw = array();
        $info = array();
        
        if (is_object($result) && $result->RecordCount() > 0) {
          $info = $result->fetchRow();
          if (!isset($info['keywords']) || $info['keywords'] == '') {
            $kw = seo2_utils::getKeywordSuggestions($content_obj->Id());
          } else {
            $kw = explode(',',$info['keywords']);
          }
        }
            
		$description_auto = false;
		if (($description == "") && ($this->GetPreference('description_auto_generate','false') == 'true')) {
		  $last_keyword = array_pop($kw);
		  $keywords = implode(', ',$kw) . " " . $this->lang('and') . " " . $last_keyword;
		  $description = $this->lang('auto_generated').": ".str_replace('{keywords}',$keywords,$this->GetPreference('description_auto',''));
		  $description = str_replace('{title}',$content_obj['content_name'],$description);
		  $description_auto = true;
		}
		$default_ogtype = $this->GetPreference('meta_opengraph_type','');

		// to reformat with commas
		$auto_keywords = str_replace (' ',', ',implode(' ',$kw));
		
		
		$priority = '(auto) <span class="priority">'.$auto_priority.'</span>% ';
		$ogtype = '(default) '.$default_ogtype.' '.$this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/modules/SEOTools2/img/edit.png" align="absmiddle" />', $this->lang('edit_value'), Array("what"=>"edit_ogtype","content_id"=>$content_obj->Id()));

		
		$keywords = '(auto) '.count($kw).' '.$this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/modules/SEOTools2/img/edit.png" align="absmiddle" />', $auto_keywords.'; '.$this->lang('edit_value'), Array("what"=>"edit_keywords","content_id"=>$content_obj->Id()));
		
		$indexable = 'true';
		$follow = 'true';

		if ($info && $info['content_id'] != "") {
		  if ($info['priority'] != 0) {
			$priority = '<b class="reset100"><span class="priority">'.$info['priority'] . '</span>% '.$this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/modules/SEOTools2/img/reset.png" align="absmiddle" />', $this->lang('reset_to_default'), Array("what"=>"reset_priority","content_id"=>$content_obj->Id())) . '</b>';
			$auto_priority = $info['priority'];
		  }
		  if ($info['ogtype'] != "") {
			$ogtype = '<b>'.$info['ogtype'] . ' ' . $this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/modules/SEOTools2/img/reset.png" align="absmiddle" />', $this->lang('reset_to_default'), Array("what"=>"reset_ogtype","content_id"=>$content_obj->Id())) . $this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/modules/SEOTools2/img/edit.png" align="absmiddle" />', $this->lang('edit_value'), Array("what"=>"edit_ogtype","content_id"=>$content_obj->Id())).'</b>';
		  }
		  if ($info['keywords'] != "") {
			$keywords = '<b>'.count(explode(',',$info['keywords'])) .$this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/modules/SEOTools2/img/reset.png" align="absmiddle" />', $this->lang('reset_to_default'), Array("what"=>"reset_keywords","content_id"=>$content_obj->Id())) .'</b>' . $this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/modules/SEOTools2/img/edit.png" align="absmiddle" />', ' '. implode(', ',$kw) . '; ' . $this->lang('edit_value'), Array("what"=>"edit_keywords","content_id"=>$content_obj->Id()));
		  }
		  if ($info['indexable'] == 0) {
			$indexable = 'false';
		  }
		  if (!empty($info['follow']) && $info['follow'] == 1 ) {
			$follow = 'false';
		  }
		}

		$updown  = $this->CreateLink (null, 'defaultadmin', '', '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/arrow-d.gif" border="0" align="absmiddle" />', Array('what'=>'set_priority','priority'=>$auto_priority-10,'content_id'=>$content_obj->Id()), '', false, false, 'class="updown down"', false, '');
		$updown .= $this->CreateLink (null, 'defaultadmin', '', '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/arrow-u.gif" border="0" align="absmiddle" />', Array('what'=>'set_priority','priority'=>$auto_priority+10,'content_id'=>$content_obj->Id()), '', false, false, 'class="updown up"', false, '');
		$updown .= " " . $this->lang('decrease_priority');
		
		
		$pagesettings .= '<tr class="row'.($j % 2 + 1).'">';
		$pagesettings .= '<td>'.$content_obj->Id().'</td>';
		$pagesettings .= '<td class="pg">'.$prefix .' '.$content_obj->Name().'</td>';


		if (strpos($content_obj->Type(), 'content') !== false || strpos($content_obj->Type(), 'link') !== false ) {
		  $pagesettings .= '<td>'.$updown.' <span class="pmsg">'.$priority.'</span></td>';
		  //      $pagesettings .= '<td>'. $ogtype.'</td>';
		  $pagesettings .= strpos($content_obj->Type(), 'link') !== false ? '<td>---</td>' : '<td>'. $ogtype.'</td>';
		  $pagesettings .= strpos($content_obj->Type(), 'link') !== false ? '<td>---</td>' : '<td>'. $keywords.'</td>';

		  //      $pagesettings .= '<td>'.$keywords.'</td>';
		  if (strpos($content_obj->Type(), 'content') !== false ) {

			if ($description != "") {
			  if ($description_auto) {
				$pagesettings .= '<td><img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/warning.gif" title="'.strip_tags($description).' alt="'.strip_tags($description).' /></td>';
			  }else{
				$pagesettings .= '<td><a href="editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$content_obj->Id().'"><img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/true.gif" title="'.strip_tags($description).' alt="'.strip_tags($description).'" /></a></td>';
			  }
			}else{
			  $pagesettings .= '<td><a href="editcontent.php?'.CMS_SECURE_PARAM_NAME.'='.$_GET[CMS_SECURE_PARAM_NAME].'&content_id='.$content_obj->Id().'"><img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/false.gif" border="0" title="'.$this->lang('click_to_add_description').'" alt="'.$this->lang('click_to_add_description').'"/></a></td>';
			}
		  } else {
			$pagesettings .= '<td>---</td>';
		  }
		  // Index/Noindex Follow/Nofollow
		  $pagesettings .= '<td class="seo2ajax">'.$this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/'.$indexable.'.gif" />', '', Array('what'=>'toggle_index','content_id'=>$content_obj->Id())).'</td>';
		  $pagesettings .= '<td class="seo2ajax">'.$this->CreateTooltipLink(null, 'defaultadmin', '', '<img src="'.$root_url.'/'.$admin_dir.'/themes/'.$themeName.'/images/icons/system/'.$follow.'.gif" />', '', Array('what'=>'toggle_follow','content_id'=>$content_obj->Id())).'</td>';
		}else{
		  $pagesettings .= '<td>---</td>';
		  $pagesettings .= '<td>---</td>';
		  $pagesettings .= '<td>---</td>';
		  $pagesettings .= '<td>---</td>';
		  $pagesettings .= '<td>---</td>';
		  $pagesettings .= '<td>---</td>';
		}
		$pagesettings .= '</tr>';
		$j++;

}

  $pagesettings .= '</table>';
  echo $pagesettings;
?>