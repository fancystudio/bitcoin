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

final class cge_debug
{
  private function __construct() {}
  static private $_output;
  static private $_instant;
  static private $_html;
  static private $_filename;

  static public function _construct()
  {
    self::$_instant = 1;
    self::$_html = 1;
  }
 
  static function set_html($var = true)
  {
    self::$_html = (bool)$var;
  }

  static public function is_html()
  {
    return self::$_html;
  }

  static public function set_instant($var = true)
  {
    self::$_instant = (bool)$var;
  }

  static public function is_instant()
  {
    return self::$_instant;
  }

  static public function set_filename($str)
  {
    self::$_filename = $str;
  }

  static public function output_to_file()
  {
    return self::output(TMP_CACHE_LOCATION.'/cge_debug.log');
  }

  static public function output($filename = '')
  {
    if( !$filename ) {
      if( self::$_filename ) $filename = self::$_filename;
    }

    if( !count(self::$_output) ) return;

    if( !empty($filename) ) {
      $fh = @fopen($filename,'a');
      if( !$fh ) {
	trigger_error('Problem opening debug file: '.$filename);
	return;
      }

      foreach( self::$_output as $one ) {
	fputs($fh,$one);
      }
      fclose($fh);
      return;
    }

    foreach( self::$_output as $one ) {
      echo $one;
    }
  }

  static public function add($var,$title = '')
  {
    $out = '';
    if( !$var ) return;

    if( empty($title) )	$title = 'DEBUG: ';
    if( self::is_html() ) {
      $out .= '<b>{$title}:</b>';
    }
    else {
      $out .= $title.": ";
    }

    ob_start();
    if( self::is_html() ) echo '<pre>';
    if( is_array($var) ) {
      echo "\nNumber of elements: " . count($var) . "\n";
      print_r($var);
    }
    elseif(is_object($var)) {
      print_r($var);
    }
    elseif(is_string($var)) {
      print_r(htmlentities(str_replace("\t", '  ', $var)));
    }
    elseif(is_bool($var)) {
      echo $var === true ? 'true' : 'false';
    }
    else {
      print_r($var);
    }
    if( self::is_html() ) echo '</pre>';

    $out .= ob_get_contents();
    ob_end_clean();
    $out .= "\n";

    if( self::is_instant() ) {
      echo $out;
    }
    else {
      self::$_output[] = $out;
    }
  }
}

#
# EOF
#
?>