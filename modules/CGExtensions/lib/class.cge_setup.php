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

class cge_setup
{
  static public function &get_watermarker()
  {
    $mod = cge_utils::get_cge();
    $txt = $mod->GetPreference('watermark_text');
    $img = $mod->GetPreference('watermark_file');

    $obj = new cg_watermark();
    if( !empty($img) )
      {
	$config = cmsms()->GetConfig();
	$obj->set_watermark_image($config['uploads_path'].'/'.$img);
      }
    else if( !empty($txt) )
      {
	$obj->set_watermark_text($txt);
	$font = $mod->GetPreference('watermark_font');
	$obj->set_font($font);
	$obj->set_text_size($mod->GetPreference('watermark_textsize'));
	$obj->set_text_angle($mod->GetPreference('watermark_textangle'));
	$tmp = $mod->GetPreference('watermark_textcolor');
	$r = hexdec(substr($tmp,1,2)); $g = hexdec(substr($tmp,3,2)); $b = hexdec(substr($tmp,5,2));
	$obj->set_text_color($r,$g,$b);
	$tmp = $mod->GetPreference('watermark_bgcolor');
	$r = hexdec(substr($tmp,1,2)); $g = hexdec(substr($tmp,3,2)); $b = hexdec(substr($tmp,5,2));
	$obj->set_background_color($r,$g,$b,$mod->GetPreference('watermark_transparent',1));
      }

    $obj->set_alignment($mod->GetPreference('watermark_alignment'));
    $obj->set_translucency($mod->GetPreference('watermark_translucency',100));
    return $obj;
  }


  static public function &get_uploader($prefix = '',$destdir = '')
  {
    $mod = cge_utils::get_cge();
    $obj = new cge_uploader($prefix,$destdir);
    $obj->set_accepted_filetypes($mod->GetPreference('alloweduploadfiles'));
    $obj->set_accepted_imagetypes($mod->GetPreference('imageextensions'));
    $obj->set_preview($mod->GetPreference('allow_resizing',0));
    $obj->set_preview_size($mod->GetPreference('resizeimage',0));
    $obj->set_watermark($mod->GetPreference('allow_watermarking',0));
    $obj->set_thumbnail($mod->GetPreference('allow_thumbnailing',0));
    $obj->set_thumbnail_size($mod->GetPreference('thumbnailsize'));
    $obj->set_delete_orig($mod->GetPreference('delete_orig_image'));
    return $obj;
  }
}

#
# EOF
#
?>