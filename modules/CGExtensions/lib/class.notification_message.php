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

/**
 * A base class notification message object.  This is used to convey information that can be formatted and sent out via various channels
 *
 * This object is used to send data to various twitter, facebook, mail, and other modules.  some channels may not use all of the fields
 * or may aggregate the data in various ways.
 *
 * fields:
 *   subject:     string - the message subject
 *   body:        string - the message body
 *      Some channels may strip html out of the body, and/or shorten URLS or do other processing to make the text compliant with 
 *      channel requirements. 
 *   module:      string - The name of the originating module
 *   priority:    integer/const - A message priority (1 = high, 2 = normal, 3 = low)
 *   to:          integer - A user identifer
 *   lat:         float - Latitude
 *   long:        float - Longitude
 *   html:        boolean - May indicate that the message is an HTML message
 *   ischeckin:   boolean - May indicate that the message is a user checkin
 *   link:        string - URL to a link to attach to the message
 *   linkname:    string - A name for the link
 *   caption:     string - A caption for the link
 *   description: string - A description for the link
 *   picture:     string - URL to an image to attach to the message.
 *   shorten:     boolean - May indicate that URLS in the message body (and possibly the link) can be shortened.
 */
class notification_message 
{
  const PRIORITY_HIGH = 1;
  const PRIORITY_NORMAL = 2;
  const PRIORITY_LOW = 3;

  private static $_keys = array('subject','body','module','priority','to','lat','long','html','ischeckin','link','linkname',
				'caption','description','picture','shorten');
  private $_data = array();

  public function __get($okey)
  {
    // key translation
    if( $okey == 'message' || $okey == 'msg' ) $okey = 'body';

    $key = strtolower($okey);
    if( !in_array($key,self::$_keys) ) throw new Exception('Attempt to retrieve invalid key '.$okey.' from message object');
    if( isset($this->_data[$key]) ) return $this->_data[$key];
    
    switch($key) {
    case 'priority':
      return self::PRIORITY_NORMAL;

    case 'to':
      return 0;

    case 'html':
      return 0;

    case 'module':
      return -1;

    case 'shorten':
      return 0;
    }
  }

  public function __set($key,$value)
  {
    if( $key == 'message' || $key == 'msg' ) $key = 'body';

    $key = strtolower($key);
    if( !in_array($key,self::$_keys) ) throw new Exception('Attempt to store invalid data into message object');

    $this->_data[$key] = $value;
  }

  public function __isset($key)
  {
    if( !in_array($key,self::$_keys) ) throw new Exception('Attempt to retrieve invalid key '.$okey.' from message object');
    return isset($this->_data[$key]);
  }

  public function valid_key($key)
  {
    if( $key == 'message' || $key == 'msg' ) $key = 'body';
    return in_array($key,self::$_keys);
  }
} // end of class

#
# EOF
#
?>