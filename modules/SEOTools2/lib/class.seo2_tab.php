<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Class: seo2_tab
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
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
class seo2_tab
{

  private $block_name = array();
  private $value = '';
  private $adding = false;
  private $options = array();
  private $alias = '';
  private $field = '';
  private $tab = '';
  /**
   *
   * @param stribng $blockName
   * @param string $value
   * @param array $params
   * @param boolean $adding
   */
  public static function __construct() {
    
    $mod = cms_utils::get_module('SEOTools2');
    
    $blocks = array();
    $blocks['description_block'] = 'textarea';
    $blocks['keywords'] = 'textarea';
    $blocks['priority'] = 'dropdown';
    $blocks['index'] = 'checkbox';
    $blocks['follow'] = 'checkbox';

    $priorities = array(100,90,80,70,60,50,40,30,20,10,0);

    foreach ($blocks as $key=>$value) {
      $this->block_name = $blockName;
      $this->alias = munge_string_to_url($blockName, true);
      $this->value = $value;
      $this->adding = $adding;
    }
  }

  /**
   *  get content block
   * @return string
   */
  public static function get_content_block_input() {
    print_r($params);die;
    $function = 'get_' . $this->field;
    return $this->$function();
  }

  /**
   *
   * @return string
   */
  private function get_textarea() {
    $tmp = '<textarea name="%s" rows="%d" cols="%d">%s</textarea>';
    return sprintf($tmp, $this->block_name, $this->options["rows"], $this->options["cols"], $this->value);
  }

  /**
   *
   * @return string
   */
  private function get_input() {
    $tmp = '<input type="text" name="%s" size="%d" maxlength="%d" value="%s"/>';
    return sprintf($tmp, $this->block_name, $this->options["size"], $this->options["max_length"], $this->value);
  }

  private function get_dropdown() {
    $options = array();

    foreach ($priorities as $option) {

      $options[$option] = $option;
    }

    return $mod->CreateInputDropdown('', $this->block_name, $options, -1, $this->value);
  }

  /**
   *
   * @return string
   */
  private function get_checkbox() {

    return $mod->CreateInputHidden('', $this->block_name, 0) . $mod->CreateInputCheckbox('', $this->block_name, 1, $this->value);
  }

}



?>
