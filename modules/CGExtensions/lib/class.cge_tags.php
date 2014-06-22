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

final class cge_tags
{
  private function __construct() {}

  public static function img_tag($params)
  {
    $image = get_parameter_value($params,'image');
    $alt = get_parameter_value($params,'alt',$image);
    $class = get_parameter_value($params,'class');
    $rel = get_parameter_value($params,'rel');
    $width = get_parameter_value($params,'width');
    $height = get_parameter_value($params,'height');
    $id = get_parameter_value($params,'id');

    $output .= '<img src="'.$image.'" alt="'.$alt.'"';
    if( $id ) $output .= ' id="'.$id.'"';
    if( $class ) $output .= ' class="'.$class.'"';
    if( $rel ) $output .= ' rel="'.$rel.'"';
    if( $width ) $output .= ' width="'.$width.'"';
    if( $height ) $output .= ' height="'.$height.'"';
    $output .= '/>';
    return $output;
  }

  public static function link_tag($params)
  {
    $url = get_parameter_value($params,'url');
    $text = get_parameter_value($params,'text',$url);
    $linkclass = get_parameter_value($params,'linkclass');

    // build the tag.
    $output = '<a href="'.$url.'" title="'.$text.'"';
    if( $linkclass ) $output .= ' class="'.$linkclass.'"';
    $output .= '>';
    if( isset($params['image']) ) {
      if( isset($params['imgclass']) ) {
	$params['class'] = $imgclass;
      }
      $params['alt'] = $text;
      $output .= self::img_tag($params);
    }
    else {
      $output .= $text;
    }
    $output .= '</a>';
    return $output;
  }
} // end of class

?>