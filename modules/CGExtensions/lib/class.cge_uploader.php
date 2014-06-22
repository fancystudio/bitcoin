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

class cge_uploader extends cg_fileupload
{
  private $_do_preview = false;
  private $_preview_size = 800;
  private $_do_watermark = false;
  private $_watermarker = null;
  private $_do_thumbnail = false;
  private $_thumbnail_size = 75;
  private $_delete_orig = 0;
  private $_imagetypes;


  public function set_preview($flag = true)
  {
    $this->_do_preview = $flag;
  }


  public function set_preview_size($size)
  {
    $this->_preview_size = $size;
  }


  public function set_watermark($flag = true)
  {
    $this->_do_watermark = $flag;
  }


  public function set_thumbnail($flag = true)
  {
    $this->_do_thumbnail = $flag;
  }


  public function &get_watermark_obj()
  {
    if( !is_object($this->_watermarker) ) {
      $this->_watermarker = cge_setup::get_watermarker();
    }

    return $this->_watermarker;
  }


  public function set_thumbnail_size($size)
  {
    $this->_thumbnail_size = $size;
  }


  public function set_delete_orig($flag = true)
  {
    $this->_delete_orig = $flag;
  }


  public function is_accepted_imagefile($filename)
  {
    $imagetypes = $this->get_accepted_imagetypes();
    if( is_array($imagetypes) && count($imagetypes) )
      {
	$extension = strrchr($filename,".");
	$found = false;
	foreach( $imagetypes as $type )
	  {
	    if( ".".strtolower($type) == strtolower($extension) )
	      {
		$found = true;
		break;
	      }
	  }
	if( count($imagetypes) && $found === false )
	  {
	    return false;
	  }
      }
    return true;
  }


  public function get_accepted_imagetypes()
  {
    return $this->_imagetypes;
  }


  public function set_accepted_imagetypes($imagetypes)
  {
    if( is_array( $imagetypes ) )
      {
	$this->_imagetypes = $imagetypes;
      }
    else
      {
	if( empty($imagetypes) )
	  {
	    $this->_imagetypes = false;
	  }
	else if( is_array($imagetypes) )
	  {
	    $this->_imagetypes = $imagetypes;
	  }
	else
	  {
	    $this->_imagetypes = explode(',',$imagetypes);
	  }
      }
  }
  
  
  protected function preprocess_upload($fileinfo)
  {
    $srcname = $fileinfo['tmp_name'];
    if( !$this->is_accepted_imagefile($fileinfo['name']) ) {
      return $srcname;
    }

    if( $this->_do_preview && $this->_preview_size > 0 ) {
      // I guess we're resizing the master image.
      $destdir = dirname($srcname);
      $destname = 'rs_'.basename($srcname);
      $tmpname = $destdir.'/'.$destname;

      cge_image::transform_image($srcname,$tmpname,$this->_preview_size);
      if( !file_exists($tmpname) ) {
	$mod = cge_utils::get_cge();
	$this->set_error($mod->Lang('error_image_transform'));
	return FALSE;
      }
      else if( $this->_delete_orig ) {
	@unlink($srcname);
	@rename($tmpname,$srcname);
      }
      else {
	$srcname = $tmpname;
      }
    }    

    if( $this->_do_watermark ) {
      // I guess we're creating a watermark image.
      $destdir = dirname($srcname);
      $destname = 'wm_'.basename($srcname);
      $tmpname = $destdir.'/'.$destname;
      $obj = $this->get_watermark_obj();

      $res = $obj->create_watermarked_image($srcname,$tmpname);
      if( FALSE === $res ) {
	// watermarking failed.
	$mod = cge_utils::get_cge();
	$this->set_error('WATERMARKING: '.$mod->GetWatermarkError($obj->get_error()));
	return FALSE;
      }
      else {
	@unlink($srcname);
	$srcname = $tmpname;
      }
    }

    return $srcname;
  }


  public function handle_upload($name,$destfilename = '',$subfield = false)
  {
    $res = parent::handle_upload($name,$destfilename,$subfield);
    if( !$res )
      {
	return false;
      }

    $src = $this->get_dest_filename();
    if( !$this->is_accepted_imagefile($src) ) 
      {
	// not an image file, nothing more to do.
	return $res;
      }

    if( $this->_do_thumbnail && $this->_thumbnail_size > 0 )
      {
	// I guess we're making a thumbnail.
	$bn = basename($this->get_dest_filename());
	$filename = 'thumb_'.$bn;
	$dest = cms_join_path($this->get_dest_dir(),$filename);

	// todo: check to see if the input is greater than the thumbnail size.
	cge_image::transform_image($src,$dest,$this->_thumbnail_size);
      }

    return basename($this->get_dest_filename());
  }


}

#
# EOF
#
?>
