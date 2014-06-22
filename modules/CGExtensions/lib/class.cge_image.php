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

class cge_image
{
  public static function transform_image($srcSpec,$destSpec,$size = '')
  {
    $config = cmsms()->GetConfig();
    require_once($config['root_path'].'/lib/filemanager/ImageManager/Classes/Transform.php');

    if( $size == '' )
      {
	$cge = cge_utils::get_cge();
	$size = $cge->GetPreference('thumbnailsize');
      }

    $it = new Image_Transform;
    $img = $it->factory($config['image_manipulation_prog']);
    $img->load($srcSpec);
    if ($img->img_x < $img->img_y)
      {
	$long_axis = $img->img_y;
      }
    else
      {
	$long_axis = $img->img_x;
      }
     
    if ($long_axis > $size)
      {
	$img->scaleByLength($size);
	$img->save($destSpec, 'jpeg');
      }
    else
      {
	$img->save($destSpec, 'jpeg');
      }
    $img->free();
  }
} // end of class

#
# EOF
#
?>