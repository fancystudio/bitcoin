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

class cg_fileupload
{
  const NOFILE = 'CGFILEUPLOAD_NOFILE';
  const FILESIZE = 'CGFILEUPLOAD_FILESIZE';
  const FILETYPE = 'CGFILEUPLOAD_FILETYPE';
  const FILEEXISTS = 'CGFILEUPLOAD_FILEEXISTS';
  const BADDESTDIR = 'CGFILEUPLOAD_BADDESTDIR';
  const BADPERMS = 'CGFILEUPLOAD_BADPERMS';
  const MOVEFAILED = 'CGFILEUPLOAD_MOVEFAILED';
  const UPLOADFAILED = 'CGFILEUPLOAD_UPLOADFAILED';
  const PREPROCESSING_FAILED = 'CGFILEUPLOAD_PREPROCESSING_FAILED';

  private $_maxfilesize;
  private $_errno = false;
  private $_errmsg = null;
  private $_prefix = null;
  private $_destdir;
  private $_filetypes;
  private $_allow_overwrite;
  private $_destname;
  private $_files;
  private $_preprocessor;
  private $_origname;


  public function __construct($prefix = '',$destdir = '')
  {
    $this->_errno = false;
    $this->_allow_overwrite = false;
    $this->_prefix = $prefix;
    $this->_files = $_FILES;
    $this->_preprocessor = null;

    $config = cmsms()->GetConfig();
    $this->_maxfilesize = $config['max_upload_size'];

    if( empty($destdir) ) {
      $destdir = $config['uploads_path'];
    }
    $this->_destdir = $destdir;
  }


  public function set_preprocessor($func)
  {
    $this->_preprocessor = $func;
  }


  public function get_accepted_filetypes()
  {
    return $this->_filetypes;
  }


  public function set_accepted_filetypes($filetypes)
  {
    if( is_array( $filetypes ) ) {
      $this->_filetypes = $filetypes;
    }
    else {
      if( empty($filetypes) ) {
	$this->_filetypes = false;
      }
      else if( is_array($filetypes) ) {
	$this->_filetypes = $filetypes;
      }
      else {
	$this->_filetypes = explode(',',$filetypes);
      }
    }
  }


  public function is_accepted_file($filename)
  {
    $filetypes = $this->get_accepted_filetypes();
    if( is_array($filetypes) && count($filetypes) ) {
      $extension = strrchr($filename,".");
      $found = false;
      foreach( $filetypes as $type ) {
	if( ".".strtolower(trim($type)) == strtolower($extension) ) {
	  $found = true;
	  break;
	}
      }
      if( count($filetypes) && $found === false ) {
	return false;
      }
    }
    return true;
  }


  public function set_max_filesize($size)
  {
    $this->_maxfilesize = $size * 1024;
  }


  public function set_allow_overwrite($flag = true)
  {
    $this->_allow_overwrite = $flag;
  }


  public function get_error()
  {
    return $this->_errno;
//     $cge = cge_utils::get_cge();
//     return "({$this->_errno}) ".$cge->Lang($this->_errno).': '.$this->_errmsg;
  }


  public function get_errormsg()
  {
    return $this->_errmsg;
  }


  public function reset_errors()
  {
    $this->_errno = null;
    $this->_errmsg = null;
  }

  protected function set_errno($val)
  {
    $this->_errno = $val;
  }


  protected function set_error($val)
  {
    $this->_errmsg = $val;
  }


  public function get_dest_dir()
  {
    return $this->_destdir;
  }


  public function set_dest_dir($dir)
  {
    $this->_destdir = $dir;
  }


  public function get_dest_filename()
  {
    return $this->_destname;
  }


  public function get_orig_filename()
  {
    // only useful after handle upload
    return $this->_origname;
  }

  public function check_upload_attempted($name,$subfield = false)
  {
    $fldname = $this->_prefix.$name;
    if( !isset($this->_files) || !isset($this->_files[$fldname]) ) {
      return FALSE;
    }

    if( !empty($subfield) ) {
      if( !isset($this->_files[$fldname][$subfield]) || !isset($this->_files[$fldname][$subfield]['name']) ||
	  empty($this->_files[$fldname][$subfield]['name']) ) {
	return FALSE;
      }
    }
    else {
      if( !is_array($this->_files[$fldname]) || !isset($this->_files[$fldname]['name']) ||
	  empty($this->_files[$fldname]['name']) ) {
	return FALSE;
      }
    }
    return TRUE;
  }

  public function check_upload($name,$subfield = false,$checkdir = TRUE)
  {
    $fldname = $this->_prefix.$name;
    if( !isset($this->_files) || !isset($this->_files[$fldname]) ) {
      $this->_errno = self::NOFILE;
      return false;
    }

    $file = '';
    if( empty($subfield) ) {
      if( !is_array($this->_files[$fldname]) || !isset($this->_files[$fldname]['name']) ||
	  empty($this->_files[$fldname]['name']) ) {
	// there's nothing to handle
	$this->_errno = self::NOFILE;
	return false;
      }
      else {
	$file = $this->_files[$fldname];
      }
    }
    else {
      // the files are an array, so each element is an array
      // we gotta build $file from the $_FILES one step at a time
      $tmp = array();
      foreach( $this->_files[$fldname] as $key => $value ) {
	if( isset($value[$subfield]) ) {
	  $tmp[$key] = $value[$subfield];
	}
      }
      $file = $tmp;

      if( !is_array($file) || 
	  !isset($file['name']) || 
	  empty($file['name']) ) {
	$this->_errno = self::NOFILE;
	return false;
      }
    }

    // Normalize the file variables
    if (!isset ($file['type'])) $file['type'] = '';
    if (!isset ($file['size'])) $file['size'] = '';
    if (!isset ($file['tmp_name'])) $file['tmp_name'] = '';
    $file['name'] =
      preg_replace('/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/', '',
		   str_replace(array(' ', '%20'),array ('_', '_'),$file['name']));
    $extension = strrchr($file['name'],".");

    // Check the file size
    if( ($this->_maxfilesize > 0) && 
	($file['size'] > $this->_maxfilesize) ) {
      $this->_errno = self::FILESIZE;
      return false;
    }

    // Check the file extension
    if( !$this->is_accepted_file($file['name']) ) {
      $this->_errno = self::FILETYPE;
      return false;
    }

    if( $checkdir ) {
      // check the destination directory
      if( !is_dir($this->_destdir) ) {
	$this->_errno = self::BADDESTDIR;
	return false;
      }
	
      if( !is_writable($this->_destdir) ) {
	$this->_errno = self::BADPERMS;
	return false;
      }
    }

    $newname = $file['name'];
    if( empty($destfilename) && !empty($this->_destname) ) {
      $destfilename = $this->_destname;
    }
    if( !empty($destfilename) ) {
      // put the extensionof the input file on the new destination name.
      // this prevents a .jpg from being named a .gif or something.
      $destfilename = basename($destfilename);
      $tmp = substr($destfilename,0,strlen($file['name'])-strlen($extension));
      $newname = $tmp.$extension;
    }
    $destname = cms_join_path($this->_destdir,$newname);
    if( file_exists($destname) ) {
      if( !$this->_allow_overwrite ) {
	$this->_errno = self::FILEEXISTS;
	return false;
      }
      else if( !is_writable($destname) ) {
	$this->_errno = self::BADPERMS;
	return false;
      }
    }

    return true;
  }


  public function handle_upload($name,$destfilename='',$subfield = false)
  {
    $fldname = $this->_prefix.$name;
    if( !isset($this->_files) || !isset($this->_files[$fldname]) ) {
      $this->_errno = self::NOFILE;
      return false;
    }

    $file = '';
    if( strlen($subfield) == 0 ) {
      if( !is_array($this->_files[$fldname]) || !isset($this->_files[$fldname]['name']) ||
	  empty($this->_files[$fldname]['name']) ) {
	// there's nothing to handle
	$this->_errno = self::NOFILE;
	return false;
      }
      else {
	$file = $this->_files[$fldname];
      }
    }
    else {
      // the files are an array, so each element is an array
      // we gotta build $file from the $_FILES one step at a time
      $tmp = array();
      foreach( $this->_files[$fldname] as $key => $value ) {
	if( isset($value[$subfield]) ) $tmp[$key] = $value[$subfield];
      }
      $file = $tmp;

      if( !is_array($file) || !isset($file['name']) || empty($file['name']) ) {
	$this->_errno = self::NOFILE;
	return false;
      }
    }

    // Normalize the file variables
    if (!isset ($file['type'])) $file['type'] = '';
    if (!isset ($file['size'])) $file['size'] = '';
    if (!isset ($file['tmp_name'])) $file['tmp_name'] = '';
    $file['name'] =
      preg_replace('/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/', '',
		   str_replace(array(' ', '%20'),array ('_', '_'),$file['name']));
    $extension = strrchr($file['name'],".");

    // Check the file size
    if( (($this->_maxfilesize > 0) && $file['size'] > $this->_maxfilesize) ||
	$file['size'] == 0 ) {
      $this->_errno = self::FILESIZE;
      return false;
    }

    // Check the file extension
    if( !$this->is_accepted_file($file['name']) ) {
      $this->_errno = self::FILETYPE;
      return false;
    }

    // check the destination directory
    if( !is_dir($this->_destdir) ) {
      $this->_errno = self::BADDESTDIR;
      return false;
    }

    if( !is_writable($this->_destdir) ) {
      $this->_errno = self::BADPERMS;
      return false;
    }

    $newname = $this->_origname = $file['name'];
    if( empty($destfilename) && !empty($this->_destname) ) $destfilename = $this->_destname;
    if( !empty($destfilename) ) {
      // put the extensionof the input file on the new destination name.
      // this prevents a .jpg from being named a .gif or something.
      $destfilename = basename($destfilename);
      $textension = strrchr($destfilename,'.');
      $tmp = substr($destfilename,0,strlen($destfilename)-strlen($textension));
      $newname = $tmp.$extension;
    }
    $destname = cms_join_path($this->_destdir,$newname);
    if( file_exists($destname) ) {
      if( !$this->_allow_overwrite ) {
	$this->_errno = self::FILEEXISTS;
	return false;
      }
      else if( !is_writable($destname) ) {
	$this->_errno = self::BADPERMS;
	return false;
      }
    }

    // here we could do any preprocessing on the file.
    $srcname = $file['tmp_name'];
    $tmp = $this->preprocess_upload($file);
    if( !$tmp ) {
      $this->_errno = self::PREPROCESSING_FAILED;
      return false;
    }
    $srcname = $tmp;

    // And Attempt the copy
    $this->_destname = $destname;
    $res = @copy( $srcname, $destname );
    if( !$res ) {
      $this->_errno = self::MOVEFAILED;
      return false;
    }

    return $newname;
  }


  protected function preprocess_upload($fileinfo)
  {
    if( !isset($fileinfo['tmp_name']) ) return FALSE;
    $srcname = $fileinfo['tmp_name'];
    if( $this->_preprocessor ) {
      $tmp = call_user_func($this->_preprocessor,$fileinfo);
      if( !$tmp ) return false;
      $srcname = $tmp;
    }

    return $srcname;
  }


  public function set_files(&$newfiles)
  {
    $this->_files = $newfiles;
  }

} // end of class

#
# EOF
#
?>