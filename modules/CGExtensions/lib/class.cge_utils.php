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

final class cge_utils
{
  private function __construct() {}

  private static function &_get_cge()
  {
    return self::get_module('CGExtensions');
  }

  public static function db_time($unixtime,$trim = true)
  {
    $db = cmsms()->GetDb();
    $tmp = $db->DbTimeStamp($unixtime);
    if( $trim ) $tmp = trim($tmp,"'");
    return $tmp;
  }

  public static function unix_time($string)
  {
    // snarfed from smarty.
    $string = trim($string);
    $time = '';
    if(empty($string)) {
      // use "now":
      $time = time();

    } elseif (preg_match('/^\d{14}$/', $string)) {
      // it is mysql timestamp format of YYYYMMDDHHMMSS?
      $time = mktime(substr($string, 8, 2),substr($string, 10, 2),substr($string, 12, 2),
		     substr($string, 4, 2),substr($string, 6, 2),substr($string, 0, 4));

    } elseif (preg_match("/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/", $string, $dt)) {
      $time = mktime($dt[4],$dt[5],$dt[6],$dt[2],$dt[3],$dt[1]);
    } elseif (is_numeric($string)) {
      // it is a numeric string, we handle it as timestamp
      $time = (int)$string;
    } else {
      // strtotime should handle it
      $time = strtotime($string);
      if ($time == -1 || $time === false) {
	// strtotime() was not able to parse $string, use "now":
	// but try one more thing
	list($p1,$p2) = explode(' ',$string,2);

	$db = cmsms()->GetDb();
	$time = $db->UnixTimeStamp($string);
	if( !$time ) {
	  $time = time();
	}
      }
    }

    return $time;
  }

  public static function get_image_extensions()
  {
    $cge = self::_get_cge();
    return $cge->GetPreference('imageextensions');
  }

  public static function &get_module($module_name = '',$version = '',$op = '')
  {
    if( empty($module_name) && cge_tmpdata::exists('module') ) $module_name = cge_tmpdata::get('module');
    return cms_utils::get_module($module_name,$version);
  }

  public static function &get_cge()
  {
    return self::get_module('CGExtensions');
  }

  public static function get_mime_type($filename)
  {
    if( !function_exists('finfo_open') ) throw new Exception('Problem with host setup.  the finfo_open function does not exist');
    $mime_type = null;
    $fh = finfo_open(FILEINFO_MIME_TYPE);
    if( $fh ) {
      $mime_type = finfo_file($fh,$filename);
      finfo_close($fh);
      return $mime_type;
    }
    return $mime_type;
  }

  public static function send_data_and_exit($data,$content_type = 'text/plain',$filename = 'report.txt')
  {
    $handlers = ob_list_handlers();
    for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Description: File Transfer');
    header('Content-Type: '.$content_type);
    header("Content-Disposition: attachment; filename=\"$filename\"" );
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . count($data));

    // send the data
    print($data);

    // don't allow any further processing.
    exit();
  }

  public static function send_file_and_exit($file,$chunksize = 65535,$mime_type = '',$filename = '')
  {
    if( !file_exists($file) ) return false;

    if( empty($mime_type) ) {
      $mime_type = self::get_mime_type($file);
      if( $mime_type == 'unknown' ) $mime_type = 'application/octet-stream';
    }

    if( empty($filename) ) $filename = $file;
    $filename = basename($filename);

    $handlers = ob_list_handlers();
    for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Description: File Transfer');
    header('Content-Type: '.$mime_type);
    header("Content-Disposition: attachment; filename=\"$filename\"" );
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));

    $handle=fopen($file,'rb');
    $contents = '';
    do {
      $data = fread($handle,$chunksize);
      if( strlen($data) == 0 ) break;
      print($data);
    } while(true);
    fclose($handle);

    // don't allow any more processing
    exit();
  }

  /**
   * Use various methods to return the users real IP address.
   * including when using a proxy server.
   */
  public static function get_real_ip()
  {
    $ip = null;
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

  /**
   * Given a string input that theoretically represents a boolean value
   * return either true or false.
   *
   * @param string input
   * @param boolean Wether strict testing should be used.
   * @return boolean (or null)
   */
  public static function to_bool($in,$strict = FALSE)
  {
    if( is_bool($in) && $in === TRUE ) return TRUE;
    if( is_bool($in) && $in === FALSE ) return FALSE;
    $in = strtolower($in);
    if( in_array($in,array('1','y','yes','true','t','on')) ) return TRUE;
    if( in_array($in,array('0','n','no','false','f','off')) ) return FALSE;
    if( $strict ) return null;
    return ($in?TRUE:FALSE);
  }

  // see Browser.php
  public static function get_browser()
  {
    static $_browser = null;

    if( $_browser == null ) $_browser = new cge_browser();
    return $_browser;
  }

  /**
   * A platform independent fgets utility.
   *
   * Handles mac, linux, and dos line endings.
   * @see fgets
   */
  public static function fgets($fh)
  {
    if( !$fh || !is_resource($fh) ) return;
    $pos1 = ftell($fh);

    $line = fgets($fh);
    if( strpos($line,"\r") === FALSE ) return $line;

    // line is probably a crappy mac line.
    $len1 = strlen($line);
    $pos = strpos($line,"\r");

    $line = substr($line,0,$pos);
    fseek($fh,($len1 - $pos -1 ) * -1,SEEK_CUR);
    return $line;
  }

  /**
   * Return the first non null argument
   *
   * @param mixed This method accepts a variable number of arguments
   * @return The firt non null argument
   */
  public static function coalesce()
  {
    $args = func_get_args();
    if( !is_array($args) || count($args) == 0 ) return;

    for( $i = 0; $i < count($args); $i++ ) {
      if( $args[$i] ) return $args[$i];
    }
  }

  public static function get_param($params,$key,$dflt = null)
  {
    if( isset($params[$key]) ) {
      $tmp = $params[$key];
      if( $tmp ) return $tmp;
    }
    return $dflt;
  }

  /**
   * Given a src specification attempt to resolve it into a filename on the server
   *
   * algorithm:
   *  1.  Check for an absolute filename
   *  2.  Test if the string starts with the uploads url
   *      - replace with uploads path
   *      - check if file exists
   *  3.  Test if the string starts with the root url
   *      - replace with root path
   *      - check if file exists
   *  4.  If string starts with /
   *      - prepend root path
   *      - check if file exists
   *  5.  assume string is relative to uploads path
   *      - checkk if file exists
   *  6.  Test if string starts with the ssl url
   *      - replace with root path
   *      - check if file exists
   *
   * @param string the source
   * @return string The filename (if possible).
   */
  public static function src_to_file($src)
  {
    $src = urldecode($src);
    $srcfile = null;
    $config = cmsms()->GetConfig();

    if( file_exists($src) ) $srcfile = $src; // user specified the complete path to the file.
    if( !$srcfile && startswith($src,$config['uploads_url']) ) {
      $tmp = str_replace($config['uploads_url'],$config['uploads_path'],$src);
      if( file_exists($tmp) ) $srcfile = $tmp;
    }
    if( !$srcfile && startswith($src,$config['root_url']) ) {
      $tmp = str_replace($config['root_url'],$config['root_path'],$src);
      if( file_exists($tmp) ) $srcfile = $tmp;
    }
    if( !$srcfile && startswith($src,'/') ) {
      $tmp = cms_join_path($config['root_path'],$src);
      if( file_exists($tmp) ) $srcfile = $tmp;
    }
    if( !$srcfile ) {
      $tmp = cms_join_path($config['uploads_path'],$src);
      if( file_exists($tmp) ) $srcfile = $tmp;
    }
    if( !$srcfile && isset($config['ssl_url']) && startswith($src,$config['ssl_url']) ) {
      $tmp = str_replace($config['ssl_url'],$config['root_path'],$src);
      if( file_exists($tmp) ) $srcfile = $tmp;
    }

    return $srcfile;
  }

  public static function ssl_request()
  {
    if( !isset($_SERVER['HTTPS']) || empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' ) return FALSE;
    return TRUE;
  }

  public static function file_to_url($file,$force_ssl = FALSE)
  {
    $config = cmsms()->GetConfig();

    $url = null;
    if( !file_exists($file) ) return $url;

    if( startswith( $file, $config['image_uploads_path'] ) ) {
      $url = str_replace($config['image_uploads_path'],$config['image_uploads_url'],$file);
    }
    else if( startswith( $file, $config['uploads_path']) ) {
      if( self::ssl_request() || $force_ssl ) {
	$url = str_replace($config['uploads_path'],$config['ssl_uploads_url'],$file);
      }
      else {
	$url = str_replace($config['uploads_path'],$config['uploads_url'],$file);
      }
    }
    else if( startswith( $file, $config['root_path']) ) {
      if( self::ssl_request() || $force_ssl ) {
	$url = str_replace($config['root_path'],$config['ssl_url'],$file);
      }
      else {
	$url = str_replace($config['root_path'],$config['root_url'],$file);
      }
    }

    return $url;
  }

  static public function have_enough_memory($needed_memory,$fudge = 2.0)
  {
    $needed_memory = abs((int)$needed_memory);
    $fudge = min(10,max(1,abs((float)$fudge)));
    if( $needed_memory == 0 ) return;
    $needed_memory *= $fudge;

    $diff = self::get_available_memory() - $needed_memory;
    if( $diff > 0 ) return TRUE;
    return FALSE;
  }

  static public function get_available_memory()
  {
    $MB = 1048576;
    $memory_limit = ini_get('memory_limit');
    if( !$memory_limit ) $memory_limit = self::$_get_cge->GetPreference('assume_memory_limit');
    $memory_limit = trim($memory_limit);
    if( !$memory_limit ) $memory_limit = '128M';
    $memory_limit = intval($memory_limit);
    $memory_limit = max(1,$memory_limit);
    $memory_limit *= $MB;

    return $memory_limit - memory_get_usage();
  }

} // class

#
# EOF
#
?>