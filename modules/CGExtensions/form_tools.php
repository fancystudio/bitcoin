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

/*
 * Create a yes/no dropdown
 */
function cge_CreateInputYesNoDropdown(&$mod,$id,$name,$selectedvalue='',$addtext='')
{
  $cgextensions =& $mod->GetModuleInstance('CGExtensions');
  $items = array($cgextensions->Lang('yes')=>1,$cgextensions->Lang('no')=>0);
  return $mod->CreateInputDropdown($id,$name,$items,-1,$selectedvalue,$addtext);
}
  

function cge_CreateInputSubmit(&$mod,$id,$name,$value='',$addtext='',$image='',
			       $confirmtext='',$class='',$alt = '',$elid = '')
{
  $real_image = '';
  if( !empty($image) ) {
    $config = cmsms()->GetConfig();

    // check image_directories first
    if( isset($mod->_image_directories) && !empty($mod->_image_directories)) {
      foreach( $mod->_image_directories as $dir ) {
	$url = cms_join_path($dir,$image);
	$path = cms_join_path($config['root_path'],$url);

	if( is_readable($path) ) {
	  $real_image = $url;
	}
      }
    }

    $theme = cms_utils::get_theme_object();
    if( empty($real_image) ) {
      $path = $config['root_path'].'/'.$config['admin_dir'].'/themes/'.$theme->themeName.'/images/';
      if( file_exists($path.$image) ) {
	// its a theme image
	$real_image = $config['admin_dir']."/themes/".$theme->themeName.'/images/'.$image;
      }
    }

    if( empty($real_image) ) {
      if( is_object($theme) ) {
	// we're in the admin
	if( !$alt ) $alt = $value;
	$txt = $theme->DisplayImage($image,$alt,'','',$class);
	$real_image = $theme->imageLink[$image];
      }
    }

    $addtext .= ' title="'.$value.'"';
  }
 
  if( !empty($class) ) {
    $addtext .= ' class="'.$class.'"';
  }

  return $mod->CreateInputSubmit($id,$name,$value,$addtext,$real_image,$confirmtext);
}


/*
 * A convenience method to create a checkbox
 */
function cge_CreateInputCheckbox(&$mod,$id, $name, $value='', $selectedvalue='', 
  $addttext='')
{
  $text = '<input type="checkbox" name="'.$id.$name.'" value="'.$value.'"';
  $arr = explode(",",$selectedvalue);
  foreach( $arr as $a ) {
    if ($a == $value) {
      $text .= ' ' . 'checked="checked"';
    }
  }
  if ($addttext != '') {
    $text .= ' '.$addttext;
  }
  $text .= " />\n";
  return $text;
}

/*
 * A convenience function for creating a hidden form element
 */
function cge_CreateInputHidden( &$mod, $id, $name, $value='', $addtext='', $delim=',')
{
  if( is_array( $value ) ) {
    $val = cge_array::implode_with_key( $value );
  }
  else {
    $val = $value;
  }
  $val = str_replace('"', '&quot;', $val);
  $text = '<input type="hidden" name="'.$id.$name.'" value="'.$val.'"';
  if ($addtext != '') {
    $text .= ' '.$addtext;
  }
  $text .= " />\n";
  return $text;
}

  
/*
 * A convenience function for creating a color selector
 */
function cge_CreateColorDropdown(&$mod,$id,$name,$selectedvalue)
{
  if( !is_array($mod->_colors) ) {
    $tmp = explode(',',$mod->Lang('rgb_colors'));
    $colors = array();
    foreach( $tmp as $one ) {
      list($rgb,$tname) = explode('-',$one);
      $colors[trim($tname)] = trim($rgb);
    }
    $mod->_colors = $colors;
  }
  
  return $mod->CreateInputDropdown($id,$name,$mod->_colors,-1,$selectedvalue,
     'style="background-color: '.$selectedvalue.';" onChange="this.style.backgroundColor=this.options[this.selectedIndex].value" style="background-color:'.$selectedvalue.'"');
}
 


#
# EOF
#
?>