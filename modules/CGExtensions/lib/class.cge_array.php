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

final class cge_array
{
  private function __construct() {}

  /**
   * A functon to test if an array element exists
   * and if it does not, add the value specified.
   * @returns array
   */
  static public function insert_unique($arr,$val)
  {
    if( !in_array($str,$arr) ) $arr[] = $val;
    return $arr;
  }


  /***
   * A method to test if an array element exists by testing
   * a subset of it's key
   *
   * @param array  The array to test
   * @param string The substring expression to test for
   * @returns bool
   */
  static public function key_exists_substr($arr,$expr)
  {
    $keys = array_keys( $arr );
    foreach( $keys as $k ) {
      if( strstr( $k, $expr ) ) return true;
    }
    return false;
  }


  /**
   * Test if an array key exists, given a regular expression
   *
   * @param array  The array to search
   * @param string The regular expression to use in the search
   * @returns FALSE or actual key name.
   */
  static public function find_key_regexp($arr,$expr)
  {
    $keys = array_keys( $arr );
    foreach( $keys as $k ) {
      if( preg_match( $expr, $k ) ) return $k;
    }
    return FALSE;
  }


  /**
   * Merge two arrays of hashes based on certain keys
   *
   * @param array array1  The primary array
   * @param array array2  The array to be merged
   * @param string key1   The key field in the first array
   * @param string key2   The key field in the second array
   */
  static public function merge_by_keys($arr1,$arr2,$key1 = 'name',$key2 = 'name')
  {
    if( !is_array( $arr1 ) || !is_array( $arr2 ) ) return;

    $xxresult = array();
    foreach( $arr1 as $a1 ) {
      $key1val = $a1[$key1];
      $found = false;
      foreach( $arr2 as $a2 ) {
	if( $a2[$key2] == $key1val ) {
	  // found an item to merge
	  $xxresult[] = array_merge($a1,$a2);
	  $found = true;
	  break;
	}
      }

      if( !$found ) $xxresult[] = $a1;
    }

    return $xxresult;
  }

  /*
   * re-arrange an array of arrays into a hash of arrays
   * by a specified key.
   */
  static public function to_hash($input,$key)
  {
      $tmp = array();
    if( is_array($input) ) {
      foreach( $input as $one ) {
	if( !isset($one[$key]) ) continue;
	$tmp[$one[$key]] = $one;
      }
    }
    return $tmp;
  }

  /*
   * Extract one field from an array of hashes into a flat array
   */
  public static function extract_field($input,$key)
  {
    if( !is_array($input) ) return;
    $tmp = array();
    foreach( $input as $one ) {
      if( !isset($one[$key]) ) continue;
      $tmp[] = $one[$key];
    }
    return $tmp;
  }

  /*
   * Compare two hashes by the key 'sort_key'
   * This function is useful for sorting arrays of hashes.
   */
  static public function compare_elements_by_sortorder_key( $e1, $e2, $key = 'sort_key' )
  {
    if( $e1[$key] < $e2[$key] ) {
      return -1;
    }
    else if( $e1[$key] > $e2[$key] ) {
      return 1;
    }
    return 0;
  }


  /**
   * Sort array of hashes by key
   **/
  static public function hashsort(&$input,$key,$is_string = false,$casecompare = false)
  {
    $func = function($a,$b) use ($key,$is_string,$casecompare) {
      if( $is_string ) {
	if( $casecompare ) {
	  return strcasecmp($a[$key],$b[$key]);
	}
	else {
	  return strcmp($a[$key],$b[$key]);
	}
      }
      if( $a[$key] == $b[$key] ) return 0;
      if( $a[$key] < $b[$key] ) return -1;
      return 1;
    };

    return usort($input,$func);
  }

  /**
   * Sort array of objects by member
   **/
  static public function objsort(&$input,$member,$is_string = false,$casecompare = false)
  {
    $func = function($a,$b) use ($member,$is_string,$casecompare) {
      if( $is_string ) {
	if( $casecompare ) {
	  return strcasecmp($a->$member,$b->$member);
	}
	else {
	  return strcmp($a->$member,$b->$member);
	}
      }
      if( $a->$member == $b->$member ) return 0;
      if( $a->$member < $b->$member ) return -1;
      return 1;
    };

    return usort($input,$func);
  }


  /**
   * Sort array of hashes by key in reverse order
   */
  static public function hashrsort(&$input,$key,$is_string = false,$casecompare = false)
  {
    $tmp = self::hashsort($input,$key,$is_string,$casecompare);
    if( $tmp ) {
      $tmp2 = array_reverse($input);
      $input = $tmp2;
    }
  }


  /*
   * Explode an array into a hash
   * useful for separating params on a URL into a hash
   *
   * @param input string
   * @param inner_glue string (separates name from value)
   * @param outer_glue string (separates each variable/value combination)
   */
  static public function explode_with_key($str, $inglue='=', $outglue='&')
  {
    $ret = array();
    $a1 = explode($outglue,$str);
    foreach( $a1 as $a2 ) {
      $a2 = trim($a2);
      $k = $v = $a2;
      $got_inglue = 0;
      if( strstr($a2,$inglue) !== FALSE ) {
	$got_inglue = 1;
	list( $k, $v ) = explode( $inglue, $a2, 2 );
      }
      $ret[ $k ] = ( $v == '' && !$got_inglue ) ? $k : $v ;
    }
    return $ret;
  }


  /**
   * Given an array and a value, return the index of that value
   *
   * @param data array
   * @param value mixed
   * @returns index or FALSE
   */
  function find_index( $data, $needle )
  {
    return array_search($needle,$data);
  }


  /**
   * Implode a hash into an array
   * suitable for forming a URL string with multiple key/value pairs
   *
   * @param hash input hash
   * @param string inner glue
   * @param string outer glue
   * @returns string;
   */
  static public function implode_with_key($assoc, $inglue = '=', $outglue = '&')
  {
    $return = null;
    foreach ($assoc as $tk => $tv) $return .= $outglue.$tk.$inglue.$tv;
    return substr($return,strlen($outglue));
  }


  /**
   * Given an array, implode it into a string with non empty values quoted.
   *
   */
  static public function implode_quoted($data,$glue = ',',$quote = '"')
  {
      $return = '';
      $values = array_values($data);
      for( $i = 0; $i < count($values); $i++ ) {
          if( $values[$i] !== '' ) $values[$i] = $quote.$values[$i].$quote;
      }
      return implode($glue,$values);
  }


  /***
   * Convert a hash into a stdclass object
   *
   * @param hash input array
   * @returns stdclass object.
   */
  static public function &to_object($array,$recursive = FALSE)
  {
    $obj = new StdClass();
    foreach( $array as $key => $value ) {
      if( is_array($value) && $recursive ) {
	$obj->$key = self::to_object($value,$recursive);
      }
      else {
	$obj->$key = $value;
      }
    }
    return $obj;
  }


  /**
   * Prepend a key/value pair to a hash
   *
   * @param hash input array
   * @param string key
   * @param mixed value
   * @returns hash
   */
  static public function hash_prepend($input,$key,$value)
  {
    $tmp = array();
    $tmp[$key] = $value;
    if( is_array($input) ) {
      foreach( $input as $key => $value ) {
	$tmp[$key] = $value;
      }
    }
    return $tmp;
  }


  static public function remove_by_value($input,$value = '')
  {
    $tmp = array();
    foreach( $input as $key => $one ) {
      if( $one != $value ) $tmp[] = $one;
    }
    return $tmp;
  }


  static public function is_hash($hash)
  {
    if( !is_array($hash) ) return FALSE;
    $keys = array_keys($hash);
    if( !is_array($keys) ) return FALSE;

    $n = 0;
    foreach( $keys as $one ) {
      if( is_int($one) ) return FALSE;
      $n++;
    }

    return TRUE;
  }


  static public function explode_to_tree($hash, $delimiter = '.', $baseval = false)
  {
    if(!is_array($hash)) return false;
    $splitRE   = '/' . preg_quote($delimiter, '/') . '/';
    $returnArr = array();
    foreach ($hash as $key => $val) {
      // Get parent parts and the current leaf
      $parts    = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
      $leafPart = array_pop($parts);

      // Build parent structure
      // Might be slow for really deep and large structures
      $parentArr = &$returnArr;
      foreach ($parts as $part) {
	if (!isset($parentArr[$part])) {
	  $parentArr[$part] = array();
	} elseif (!is_array($parentArr[$part])) {
	  if ($baseval) {
	    $parentArr[$part] = array('__base_val' => $parentArr[$part]);
	  } else {
	    $parentArr[$part] = array();
	  }
	}
	$parentArr = &$parentArr[$part];
      }

      // Add the final part to the structure
      if (empty($parentArr[$leafPart])) {
	$parentArr[$leafPart] = $val;
      } elseif ($baseval && is_array($parentArr[$leafPart])) {
	$parentArr[$leafPart]['__base_val'] = $val;
      }
    }
    return $returnArr;
  }


  public static function smart_explode($str,$delim = ',',$safe_char = '"')
  {
    $out = array();
    $col = '';
    $is_safe = 0;
    $prev_char = '';
    for( $i = 0; $i < strlen($str); $i++ ) {
      switch($str[$i]) {
      case $delim:
	if( !$is_safe ) {
	  $out[] = $col;
	  $col = '';
	}
	else {
	  $col .= $str[$i];
          //$is_safe = !$is_safe;
	}
	break;

      case $safe_char:
	if( $prev_char != '\\' ) {
	  $is_safe = !$is_safe;
	}
	else {
	  $col .= $str[$i];
	}
	break;

      default:
	$col .= $str[$i];
	break;
      }

      $prev_char = $str[$i];
    }

    if( strlen($col) != 0 ) $out[] = $col;
    return $out;
  }


  public function search_recursive($input,$needle)
  {
    foreach( $input as $key => $value ) {
      if( $key == $needle ) return $value;
      if( is_array($value) ) {
	$res = self::search_recursive($value,$needle);
	if( $res ) return $res;
      }
    }
  }

} // class

#
# EOF
#
?>
