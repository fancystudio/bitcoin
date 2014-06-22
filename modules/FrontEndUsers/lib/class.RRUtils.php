<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

class RRUtils
{
  function array_key_exists_substr( $arr, $expr )
  {
    $keys = array_keys( $arr );
    foreach( $keys as $k )
      {
	if( strstr( $k, $expr ) ) return true;
      }
    return false;
  }

  function array_find_key_regexp( $arr, $expr )
  {
    $keys = array_keys( $arr );
    foreach( $keys as $k )
      {
	if( preg_match( $expr, $k ) ) return $k;
      }
    return false;
  }


  static public function array_merge_by_name_required( $arr1, $arr2 )
  {
    $xxresult = array();
    // add items common to arr1 and arr2
    // but favor required items
    if( !is_array( $arr1 ) || !is_array( $arr2 ) )
      {
	return;
      }
    foreach( $arr1 as $a1 )
      {
	foreach( $arr2 as $a2 )
	  {
	    if( $a1['name'] == $a2['name'] )
	      {
		if( $a1['required'] == 2 )
		  {
		    array_push( $xxresult, $a1 );
		    break;
		  }
		else
		  {
		    array_push( $xxresult, $a2 );
		    break;
		  }
	      }
	  }
      }

    // add items in arr1 not in result
    foreach( $arr1 as $a1 )
      {
	$found = false;
	foreach( $xxresult as $res )
	  {
	    if( $a1['name'] == $res['name'] )
	      {
		$found = true;
		break;
	      }
	  }
	if( !$found )
	  {
	    array_push( $xxresult, $a1 );
	  }
      }

    // add items in arr2 not in result
    foreach( $arr2 as $a2 )
      {
	$found = false;
	foreach( $xxresult as $res )
	  {
	    if( $a2['name'] == $res['name'] )
	      {
		$found = true;
		break;
	      }
	  }
	if( !$found )
	  {
	    array_push( $xxresult, $a2 );
	  }
      }
    return $xxresult;
  }


  function compare_elements_by_sortorder_key( $e1, $e2 )
  {
    if( $e1['sort_key'] < $e2['sort_key'] )
      {
	return -1;
      }
    else if( $e1['sort_key'] > $e2['sort_key'] )
      {
	return 1;
      }
    return 0;
  }


  static public function implode_with_key($assoc, $inglue = '=', $outglue = '&')
  {
    $return = null;
    foreach ($assoc as $tk => $tv) $return .= $outglue.$tk.$inglue.$tv;
    return substr($return,strlen($outglue));
  }



  static public function myCreateInputCheckbox($id, $name, $value='', $selectedvalue='',
				 $addttext='')
  {
    $text = '<input type="checkbox" name="'.$id.$name.'" value="'.$value.'"';
    $arr = explode(",",$selectedvalue);
    foreach( $arr as $a )
      {
	if ($a == $value)
	  {
	    $text .= ' ' . 'checked="checked"';
	  }
      }
    if ($addttext != '')
      {
	$text .= ' '.$addttext;
      }
    $text .= " />\n";
    return $text;
  }

  function myCreateInputSubmit($id, $name, $value='', $image='', $addttext='')
  {
      $gCms = cmsms();
    $text = '<input name="'.$id.$name.'" value="'.$value.'" type=';
    if ($image != '')
      {
	$text .= '"image"';
	$img = $gCms->config['root_url'].DIRECTORY_SEPARATOR.$image;
	$text .= ' src="'.$img.'"';
      }
    else
      {
	$text .= '"submit"';
      }
    if ($addttext != '')
      {
	$text .= ' '.$addttext;
      }
    $text .= ' />';
    return $text . "\n";
  }


  static public function myCreateInputHidden( $id, $name, $value='', $addtext='', $delim=',')
  {
    if( is_array( $value ) )
      {
	$val = RRUtils::implode_with_key( $value );
      }
    else
      {
	$val = $value;
      }
    $val = str_replace('"', '&quot;', $val);
    $text = '<input type="hidden" name="'.$id.$name.'" value="'.$val.'"';
    if ($addtext != '')
      {
	$text .= ' '.$addtext;
      }
    $text .= " />\n";
    return $text;
  }

  function is_associative(&$array){
    if (!is_array($array)) return false;
    foreach(array_keys($array) as $key=>$value) {
      if( !is_numeric($key) ) return true;
    }
    return false;
}

} // End of class
?>