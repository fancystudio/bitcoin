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
if( defined('CGEXTENSIONS_TABLE_COUNTRIES') ) return;

define('CGEXTENSIONS_TABLE_COUNTRIES',cms_db_prefix().'module_cge_countries');
define('CGEXTENSIONS_TABLE_STATES',cms_db_prefix().'module_cge_states');
define('CGEXTENSIONS_TABLE_ASSOCDATA',cms_db_prefix().'module_cge_assocdata');

class CGExtensions extends CMSModule
{
  private static $_initialized;
  private $_obj;
  public $_colors;

  // todo, improve this stuff.
  // should be protected.
  public $_actionid;
  public $_image_directories;
  public $_current_tab;
  public $_errormsg;
  public $_messages;
  public $_returnid;

  /*---------------------------------------------------------
   Constructor:
   ---------------------------------------------------------*/
  public function __construct()
  {
      spl_autoload_register(array($this,'autoload'));
      parent::__construct();

      global $CMS_INSTALL_PAGE, $CMS_PHAR_INSTALL;
      if( isset($CMS_INSTALL_PAGE) || isset($CMS_PHAR_INSTALL) ) return;

      $class = get_class($this);
      if( !defined('MOD_'.strtoupper($class)) ) define('MOD_'.strtoupper($class),$class);

      // setup caching
      if( $class == 'CGExtensions' && !is_object(cms_cache_handler::get_instance()->get_driver()) ) {
          $lifetime = (int)$this->GetPreference('cache_lifetime',300);
          $filelock = (int)$this->GetPreference('cache_filelock',1);
          $autoclean = (int)$this->GetPreference('cache_autoclean',1);
          if( $autoclean ) {
              // autoclean is enabled... but we don't want to search through the directory for files to delete
              // on each request... so we just do that once per interval.
              $tmp = $this->GetPreference('cache_autoclean_last',0);
              if( (time() - $tmp) < $lifetime ) {
                  $autoclean = 0;
              }
              else {
                  $autoclean = 1;
                  $this->SetPreference('cache_autoclean_last',time());
              }
          }
          $driver = new cms_filecache_driver(array('cache_dir'=>TMP_CACHE_LOCATION,'lifetime'=>$lifetime,'locking'=>$filelock,
                                                   'auto_cleaning'=>$autoclean));
          cms_cache_handler::get_instance()->set_driver($driver);
      }

      if( self::$_initialized ) return;
      self::$_initialized = TRUE;

      $this->_obj = false;
      $this->_actionid = '';

      $smarty = cmsms()->GetSmarty();
      if( !$smarty ) return;

      $smarty->register_function('cge_yesno_options','cge_smarty_plugins::smarty_function_cge_yesno_options');
      $smarty->register_function('cge_have_module', array('cge_smarty_plugins','smarty_function_have_module'));

      $smarty->register_block('cgerror', array('cge_smarty_plugins','blockDisplayError'));
      $smarty->register_block('jsmin', array('cge_smarty_plugins','jsmin'));

      $smarty->register_function('cge_cached_url',array('cge_smarty_plugins','cge_cached_url'));
      $smarty->register_function('cgimage',array('cge_smarty_plugins','smarty_function_cgimage'));
      $smarty->register_function('cge_helptag',array('cge_smarty_plugins','smarty_function_helptag'));
      $smarty->register_function('cge_helphandler',array('cge_smarty_plugins','smarty_function_helphandler'));
      $smarty->register_function('cge_helpcontent',array('cge_smarty_plugins','smarty_function_helpcontent'));
      $smarty->register_function('cge_state_options', array('cge_smarty_plugins','smarty_function_cge_state_options'));
      $smarty->register_function('cge_country_options', array('cge_smarty_plugins','smarty_function_cge_country_options'));
      $smarty->register_function('cge_textarea', array('cge_smarty_plugins','smarty_function_cge_textarea'));
      $smarty->register_function('get_current_url', array('cge_smarty_plugins','smarty_function_get_current_url'));
      $smarty->register_function('cge_str_to_assoc',array('cge_smarty_plugins','smarty_function_str_to_assoc'));
      $smarty->register_modifier('rfc_date', array('cge_smarty_plugins','smarty_modifier_rfc_date'));
      $smarty->register_modifier('time_fmt', array('cge_smarty_plugins','smarty_modifier_time_fmt'));
      $smarty->register_modifier('cge_entity_decode', array('cge_smarty_plugins','smarty_modifier_cge_entity_decode'));
      $smarty->register_compiler_function('cge_cache',array('cge_smarty_plugins','cache_start'));
      $smarty->register_compiler_function('cge_cacheclose',array('cge_smarty_plugins','cache_end'));

      $smarty->register_function('cge_module_hint',array('cge_smarty_plugins','cge_module_hint'));
      $smarty->register_function('cge_file_list',array('cge_smarty_plugins','cge_file_list'));
      $smarty->register_function('cge_image_list',array('cge_smarty_plugins','cge_image_list'));
      $smarty->register_function('cge_array_set',array('cge_smarty_plugins','cge_array_set'));
      $smarty->register_function('cge_array_erase',array('cge_smarty_plugins','cge_array_erase'));
      $smarty->register_function('cge_array_get',array('cge_smarty_plugins','cge_array_get'));
      $smarty->register_function('cge_array_getall',array('cge_smarty_plugins','cge_array_getall'));
      $smarty->register_function('cge_admin_error',array('cge_smarty_plugins','cge_admin_error'));
      $smarty->register_function('cge_wysiwyg',array('cge_smarty_plugins','cge_wysiwyg'));
      $smarty->register_modifier('cge_createurl',array('cge_smarty_plugins','smarty_modifier_createurl'));
      $smarty->register_function('cge_setlist',array('cge_smarty_plugins','cge_setlist'));
      $smarty->register_function('cge_unsetlist',array('cge_smarty_plugins','cge_unsetlist'));
      $smarty->register_function('cge_message',array('cge_smarty_plugins','cge_message'));

      $smarty->register_function('cge_isbot',array('cge_smarty_plugins','cge_isbot'));
      $smarty->register_function('cge_is_smartphone',array('cge_smarty_plugins','cge_is_smartphone'));
      $smarty->register_function('cge_getbrowser',array('cge_smarty_plugins','cge_get_browser'));
      $smarty->register_function('cge_isie',array('cge_smarty_plugins','cge_isie'));

      $smarty->register_function('cge_content_type',array('cge_smarty_plugins','cge_content_type'));
      $smarty->register_function('cge_start_tabs',array('cge_smarty_plugins','cge_start_tabs'));
      $smarty->register_function('cge_end_tabs',array('cge_smarty_plugins','cge_end_tabs'));
      $smarty->register_function('cge_tabheader',array('cge_smarty_plugins','cge_tabheader'));
      $smarty->register_function('cge_tabcontent_start',array('cge_smarty_plugins','cge_tabcontent_start'));
      $smarty->register_function('cge_tabcontent_end',array('cge_smarty_plugins','cge_tabcontent_end'));

      $db = cmsms()->GetDb();
      if( is_object($db) ) {
          $query = 'SET @CG_ZEROTIME = NOW() - INTERVAL 150 YEAR,@CG_FUTURETIME = NOW() + INTERVAL 5 YEAR';
          $db->Execute($query);
      }
  }


  public function autoload($classname)
  {
    if( !is_object($this) ) return FALSE;

    // check for classes.
    if( strpos($classname,'\\') !== FALSE ) {
        $bn = basename(str_replace('\\','/',$classname));
        $dn = dirname(str_replace('\\','/',$classname));
        $fn = $this->GetModulePath()."/lib/$dn/class.{$bn}.php";
        if( file_exists($fn) ) require_once($fn);
        $classname = $bn;
    }

    global $CMS_ADMIN_PAGE;
    $prefix = '';

    $fn = $prefix.$this->GetModulePath()."/lib/class.{$classname}.php";
    if( file_exists($fn) ) {
      require_once($fn);
      return TRUE;
    }

    // check for interfaces
    $fn = $prefix.$this->GetModulePath()."/lib/interface.{$classname}.php";
    if( file_exists($fn) ) {
      require_once($fn);
      return TRUE;
    }

    // check for a master file
    $fn = $prefix.$this->GetModulePath()."/lib/extraclasses.php";
    if( file_exists($fn) ) {
      require_once($fn);
      return TRUE;
    }

    return FALSE;
  }


  public function SetParameters()
  {
    parent::SetParameters();

    $this->RestrictUnknownParams();
    $this->SetParameterType('cge_msg',CLEAN_STRING);
    $this->SetParameterType('cge_error',CLEAN_INT);
    $this->SetParameterType('nocache',CLEAN_INT);
    $this->CreateParameter('nocache',0,$this->Lang('param_nocache'));
  }


  private function _load_main()
  {
    if( is_object($this->_obj) ) return;
    require_once(__DIR__.'/class.cgextensions.tools.php');
    $this->_obj = new cgextensions_tools($this);
  }


  private function _load_form()
  {
    require_once(__DIR__.'/form_tools.php');
  }


  public function &GetDatastore()
  {
    $this->_load_datastore();
    return $this->_datastore_obj;
  }


  public function GetName() { return 'CGExtensions'; }
  public function GetFriendlyName() { return $this->Lang('friendlyname'); }
  public function GetVersion() { return '1.38.11'; }
  public function GetHelp() { return file_get_contents(__DIR__.'/help.inc'); }
  public function GetAuthor() { return 'calguy1000'; }
  public function GetAuthorEmail() { return 'calguy1000@cmsmadesimple.org'; }
  public function GetChangeLog() { return file_get_contents(__DIR__.'/changelog.inc'); }
  public function IsPluginModule() { return true; }
  public function HasAdmin() { return true; }
  public function HandlesEvents() { return true; }
  public function GetAdminSection() { return 'extensions'; }
  public function GetAdminDescription() { return $this->Lang('moddescription'); }
  public function GetDependencies() { return array(); }
  public function InstallPostMessage() { return $this->Lang('postinstall'); }
  public function MinimumCMSVersion() { return '1.11.9'; }
  public function UninstallPostMessage() { return $this->Lang('postuninstall'); }

  public function VisibleToAdminUser()
  {
    return $this->CheckPermission('Modify Site Preferences') ||  $this->CheckPermission('Modify Templates');
  }

  public function GetHeaderHTML()
  {
    $mod = cms_utils::get_module('CGExtensions');
    $css = $mod->GetModuleURLPath().'/css/admin_styles.css';
    $out = '<link rel="stylesheet" href="'.$css.'"/>'."\n";
    return $out;
  }

  /*
   * A replacement for the built in DoAction method
   */
  public function DoAction($name,$id,$params,$returnid='')
  {
    if( !method_exists($this,'set_action_id') && $this->GetName() != 'CGExtensions' ) {
      die('FATAL ERROR: A module derived from CGExtensions is not handling the set_action_id method');
    }
    $this->set_action_id($id);

    // handle the stupid input type='image' problem.
    foreach( $params as $key => $value ) {
      if( endswith($key,'_x') ) {
        $base = substr($key,0,strlen($key)-2);
        if( isset($params[$base.'_y']) && !isset($params[$base]) ) $params[$base] = $base;
      }
    }

    $hints = cms_utils::get_app_data('__MODULE_HINT__'.$this->GetName());
    if( is_array($hints) ) {
      foreach( $hints as $key => $value ) {
	if( isset($params[$key]) ) continue;
	$params[$key] = $value;
      }
    }

    $smarty = cmsms()->GetSmarty();
    $smarty->assign('actionid',$id);
    $smarty->assign('actionparams',$params);
    $smarty->assign('returnid',$returnid);
    $smarty->assign('mod',$this);
    $smarty->assign($this->GetName(),$this);
    cge_tmpdata::set('module',$this->GetName());

    if( $returnid == '' ) {
      if( isset($params['cg_activetab']) ) {
	$this->_current_tab = trim($params['cg_activetab']);
	unset($params['cg_activetab']);
      }
      if( isset($params['cg_error']) ) {
	$this->_errormsg = explode(':err:',$params['cg_error']);
	unset($params['cg_error']);
      }
      if( isset($params['cg_message']) ) {
	$this->_messages = explode(':msg:',$params['cg_message']);
	unset($params['cg_message']);
      }

      $this->DisplayErrors();
      $this->DisplayMessages();
    }

    parent::DoAction($name,$id,$params,$returnid);
  }


  function encrypt($key,$data)
  {
    return cge_encrypt::encrypt($key,$data);
  }


  function decrypt($key,$data)
  {
    return cge_encrypt::decrypt($key,$data);
  }


  /*
   * A convenience function to create a url
   */
  function CreateURL($id,$action,$returnid,$params=array(),$inline=false,$prettyurl='')
  {
    $this->_load_main();
    return $this->_obj->__CreatePrettyLink($id,$action,$returnid,'',$params,'',true,$inline,'',false,$prettyurl);
  }


  /* ======================================== */
  /* FORM FUNCTIONS                           */
  /* ======================================== */
  function CreateSortableListArea($id,$name,$items, $selected = '', $allowduplicates = true, $max_selected = -1,
				  $template = '', $label_left = '', $label_right = '')
  {
    $cge = $this->GetModuleInstance('CGExtensions');
    if( empty($label_left) ) $label_left = $cge->Lang('selected');
    if( empty($label_right) ) $label_right = $cge->Lang('available');
    $smarty = cmsms()->GetSmarty();
    if( !empty($selected) ) {
      $sel = explode(',',$selected);
      $tmp = array();
      foreach($sel as $theid) {
	if( array_key_exists($theid,$items) ) $tmp[$theid] = $items[$theid];
      }
      $smarty->assign('selectarea_selected_str',$selected);
      $smarty->assign('selectarea_selected',$tmp);
    }
    $smarty->assign_by_ref('cge',$cge);
    $smarty->assign('max_selected',$max_selected);
    $smarty->assign('label_left',$label_left);
    $smarty->assign('label_right',$label_right);
    $smarty->assign('selectarea_masterlist',$items);
    $smarty->assign('selectarea_prefix',$id.$name);
    if( $allowduplicates ) $allowduplicates = 1; else $allowduplicates = 0;
    $smarty->assign('allowduplicates',$allowduplicates);
    $smarty->assign('upstr',$cge->Lang('up'));
    $smarty->assign('downstr',$cge->Lang('down'));
    if( empty($template) ) $template = $cge->GetPreference('dflt_sortablelist_template');
    return $cge->ProcessTemplateFromDatabase('sortablelists_'.$template);
  }


  function CreateInputYesNoDropdown($id,$name,$selectedvalue='',$addtext='')
  {
    $this->_load_form();
    return cge_CreateInputYesNoDropdown($this,$id,$name,$selectedvalue,$addtext);
  }


  function CGCreateInputSubmit($id,$name,$value='',$addtext='',$image='', $confirmtext='',$class='')
  {
    $this->_load_form();
    return cge_CreateInputSubmit($this,$id,$name,$value,$addtext,$image,$confirmtext,$class);
  }


  function CreateInputCheckbox($id,$name,$value='',$selectedvalue='', $addtext='')
  {
    $this->_load_form();
    return cge_CreateInputCheckbox($this,$id,$name,$value,$selectedvalue,$addtext);
  }


  /*
   * A Convenience function for creating forms
   */
  function CGCreateFormStart($id,$action='default',$returnid='',$params=array(),$inline=false,$method='post',
			     $enctype='',$idsuffix='',$extra='')
  {
    if( !empty($this->_current_tab) ) $params['cg_activetab'] = $this->_current_tab;
    if( $enctype == '' ) $enctype = 'multipart/form-data';
    return $this->CreateFormStart($id,$action,$returnid,$method,$enctype,$inline,$idsuffix,$params,$extra);
  }


  /*
   * A convenience function for creating a frontend form
   */
  function CGCreateFrontendFormStart($id,$action='default',$returnid='', $params=array(),$inline=true,$method='post',
				     $enctype='',$idsuffix='',$extra='')
  {
    $this->_load_form();
    return $this->CreateFrontendFormStart($id,$returnid,$action,$method,$enctype,$inline,$idsuffix,$params,$extra);
  }


  function CreateInputHidden($id,$name,$value='',$addtext='',$delim=',')
  {
    $this->_load_form();
    return cge_CreateInputHidden($this,$id,$name,$value,$addtext,$delim);
  }


  function RedirectToTab( $id = '', $tab = '', $params = '', $action = '' )
  {
    if( $id == '' ) $id = 'm1_';
    $this->_load_main();
    return $this->_obj->RedirectToTab($id,$tab,$params,$action);
  }


  function Redirect($id,$action,$returnid='',$params = array(),$inline=false)
  {
    $parms = array();
    if( is_array( $params ) ) $parms = $params;
    if( is_array($this->_errormsg) && count($this->_errormsg) ) $parms['cg_error'] = implode(':err:',$this->_errormsg);
    if( is_array($this->_messages) && count($this->_messages) ) $parms['cg_message'] = implode(':msg:',$this->_messages);

    parent::Redirect( $id, $action, $returnid, $parms, $inline );
  }


  // todo: remove me.
  function CGRedirect($id,$action,$returnid='',$params=array(),$inline = false)
  {
    $this->Redirect($id,$action,$returnid,$params,$inline);
  }


  /*
   * Test if the current code is handling an admin action or
   * a frontend action
   */
  function IsAdminAction()
  {
    if( cmsms()->test_state(CmsApp::STATE_ADMIN_PAGE) && !cmsms()->test_state(CmsApp::STATE_INSTALL) &&
	!cmsms()->test_state(CmsApp::STATE_STYLESHEET) ) {
      return TRUE;
    }
    return FALSE;
  }


  /*
   * Set an error
   */
  function SetError($str)
  {
    if( !is_array( $this->_errormsg ) ) $this->_errormsg = array();
    if( !is_array($str) ) $str = array($str);
    $this->_errormsg = array_merge($this->_errormsg,$str);
  }


  /*
   * Set an error
   */
  function SetMessage($str)
  {
    if( !is_array( $this->_messages ) ) $this->_messages = array();
    $this->_messages[] = $str;
  }


  /*
   * Display errors using the current default template
   */
  function DisplayErrors()
  {
    if( is_array($this->_errormsg) && count($this->_errormsg) ) {
      echo $this->ShowErrors($this->_errormsg);
      $this->_errormsg = array();
    }
  }


  /*
   * Display errors using the current default template
   */
  function DisplayMessages()
  {
    if( is_array($this->_messages) && count($this->_messages) ) {
      $message = implode('<br/>',$this->_messages);
      echo $this->ShowMessage($message);
      $this->_messages = array();
    }
  }


  /*
   * Set the current tab
   * Used for the various template forms.
   */
  function SetCurrentTab($tab)
  {
    $this->_current_tab = $tab;
  }


  /*
   * A replacement for the built in SetTabHeader
   */
  function SetTabHeader($name,$str,$state = 'unknown')
  {
    if( $state == 'unknown' || $state == '') $state = ($name == $this->_current_tab);
    return parent::SetTabHeader($name,$str,$state);
  }


  /*
   * A function for using a template to display an error message
   */
  function DisplayErrorMessage($txt,$class = 'error')
  {
    $smarty = cmsms()->GetSmarty();
    $smarty->assign('cg_errorclass',$class);
    $smarty->assign('cg_errormsg',$txt);
    $res = $this->ProcessTemplateFromDatabase('cg_errormsg','',true,'CGExtensions');
    return $res;
  }


  /*
   * A convenience function for retrieving the current error template
   */
  function GetErrorTemplate()
  {
    return $this->GetTemplate('cg_errormsg','CGExtensions');
  }


  /*
   * Reset the error template to factory defaults
   */
  function ResetErrorTemplate()
  {
    $fn = cms_join_path(__DIR__,'templates','orig_error_template.tpl');
    if( file_exists( $fn ) ) {
      $template = @file_get_contents($fn);
      $this->SetTemplate( 'cg_errormsg', $template,'CGExtensions' );
    }
  }


  /*
   * Set the error template
   */
  function SetErrorTemplate($tmpl)
  {
    return $this->SetTemplate('cg_errormsg',$tmpl,'CGExtensions');
  }


  /*
   * A function to return an array of of country codes and country names.
   * i.e:  array( array('code'=>'AB','name'=>'Alberta'), array('code'=>'MB','code'=>'Manitoba'));
   */
  protected function get_state_list()
  {
    $db = cmsms()->GetDb();
    $query = 'SELECT * FROM '.CGEXTENSIONS_TABLE_STATES.' ORDER BY sorting DESC,name ASC';
    $tmp = $db->GetAll($query);
    return $tmp;
  }


  /*
   * A function to return an array of of country codes and country names.
   * i.e:  array( array('code'=>'AB','name'=>'Alberta'), array('code'=>'MB','code'=>'Manitoba'));
   */
  protected function get_state_list_options()
  {
    $tmp = $this->get_state_list();
    $result = array();
    for( $i = 0; $i < count($tmp); $i++ ) {
      $rec =& $tmp[$i];
      $result[$rec['code']] = $rec['name'];
    }
    return $result;
  }


  /*
   * A convenience function to create a state dropdown list
   */
  function CreateInputStateDropdown($id,$name,$value='AL',$selectone=false,$addtext='')
  {
    $tmp = $this->get_state_list();

    $states = array();
    if( $selectone !== false ) {
      if( is_string($selectone) ) {
	$states[$selectone] = '';
      }
      else {
	$states[$this->Lang('select_one')] = '';
      }
    }
    foreach($tmp as $row) {
      $states[$row['name']] = $row['code'];
    }
    return $this->CreateInputDropdown($id,$name,$states,-1,strtoupper($value),$addtext);
  }


  /*
   * A function to return an array of of country codes and country names.
   * i.e:  array( array('code'=>'US','name'=>'United States'), array('code'=>'CA','code'=>'Canada'));
   */
  protected function get_country_list()
  {
    $db = $this->GetDb();
    $query = 'SELECT * FROM '.CGEXTENSIONS_TABLE_COUNTRIES.' ORDER BY sorting DESC,name ASC';
    $tmp = $db->GetAll($query);

    return $tmp;
  }


  /*
   * A function to return an array of of country codes and country names.
   * i.e:  array( array('code'=>'US','name'=>'United States'), array('code'=>'CA','code'=>'Canada'));
   */
  protected function get_country_list_options()
  {
    $tmp = $this->get_country_list();
    $result = array();
    for( $i = 0; $i < count($tmp); $i++ ) {
      $rec =& $tmp[$i];
      $result[$rec['code']] = $rec['name'];
    }
    return $result;
  }


  /*
   * A convenience function to create a country dropdown list
   */
  function CreateInputCountryDropdown($id,$name,$value='US',$selectone=false,$addtext='')
  {
    $tmp = $this->get_country_list();

    if( is_array($tmp) && count($tmp) ) {
      $countries = array();
      if( $selectone !== false ) $countries[$this->Lang('select_one')] = '';
      foreach($tmp as $row) {
	$countries[$row['name']] = $row['code'];
      }
      return $this->CreateInputDropdown($id,$name,$countries,-1,strtoupper($value),$addtext);
    }
  }


  /*
   * A convenience function to get the country name given the acronym
   */
  function GetCountry($the_acronym)
  {
    $db = $this->GetDb();
    $query = 'SELECT name FROM '.CGEXTENSIONS_TABLE_COUNTRIES.' WHERE code = ?';
    $name = $db->GetOne($query,array($the_acronym));
    return $name;
  }


  /*
   * A convenience function to get the state name given the acronym
   */
  function GetState($the_acronym)
  {
    $db = $this->GetDb();
    $query = 'SELECT name FROM '.CGEXTENSIONS_TABLE_STATES.' WHERE code = ?';
    $name = $db->GetOne($query,array($the_acronym));
    return $name;
  }


  /*
   * A convenience function to create an image dropdown
   */
  function CreateImageDropdown($id,$name,$selectedfile,$dir = '',$none = '')
  {
    $config = cmsms()->GetConfig();

    if( startswith( $dir, '.' ) ) $dir = '';
    if( $dir == '' ) $dir = $config['image_uploads_path'];
    if( !is_dir($dir) ) $dir = cms_join_path($config['uploads_path'],$dir);

    $extensions = $this->GetPreference('imageextensions');

    $filelist = cge_dir::get_file_list($dir,$extensions);
    if( $none ) {
      if( !is_string($none) ) {
	$cge = $this->GetModuleInstance('CGExtensions');
	$none = $cge->Lang('none');
      }
      $filelist = array_merge(array($none=>''),$filelist);
    }
    return $this->CreateInputDropdown($id,$name,$filelist,-1,$selectedfile);
  }


  /*
   * A convenience function to create a file dropdown
   */
  function CreateFileDropdown($id,$name,$selectedfile='',$dir = '',$extensions = '',$allownone = '',$allowmultiple = false,$size = 3)
  {
    $config = cmsms()->GetConfig();

    if( $dir == '' ) $dir = $config['uploads_path'];
    else {
      while( startswith($dir,'/') && $dir != '' ) $dir = substr($dir,1);
      $dir = $config['uploads_path'].$dir;
    }
    if( $extensions == '' ) $extensions = $this->GetPreference('fileextensions','');

    $tmp = cge_dir::get_file_list($dir,$extensions);
    $tmp2 = array();
    if( !empty($allownone) ) $tmp2[$this->Lang('none')] = '';
    $filelist = array_merge($tmp2,$tmp);

    if( $allowmultiple ) {
      if( !endswith($name,'[]') ) $name .= '[]';
      return $this->CreateInputSelectList($id,$name,$filelist,array(),$size);
    }
    return $this->CreateInputDropdown($id,$name,$filelist,-1,$selectedfile);
  }


  /*
   * A convenience function to create a file dropdown
   */
  function CreateColorDropdown($id,$name,$selectedvalue='')
  {
    $this->_load_form();
    $cgextensions = $this->GetModuleInstance('CGExtensions');
    return cge_CreateColorDropdown($cgextensions,$id,$name,$selectedvalue);
  }

  /* ======================================== */
  /* IMAGE FUNCTIONS                         */
  /* ======================================== */


  // todo: remove me.
  function TransformImage($srcSpec,$destSpec,$size='')
  {
    return cge_image::transform_image($srcSpec,$destSpec,$size);
  }


  function CreateImageTag($id,$alt='',$width='',$height='',$class='', $addtext='')
  {
    $this->_load_main();
    return $this->_obj->CreateImageTag($id,$alt,$width,$height,$class,$addtext);
  }


  function DisplayImage($image,$alt='',$class='',$width='',$height='')
  {
    $this->_load_main();
    return $this->_obj->DisplayImage($image,$alt,$class,$width,$height);
  }


  function CreateImageLink($id,$action,$returnid,$contents,$image, $params=array(),$classname='',
			   $warn_message='',$imageonly=true, $inline=false,
			   $addtext='',$targetcontentonly=false,$prettyurl='')
  {
    $this->_load_main();
    return $this->_obj->CreateImageLink($id,$action,$returnid,$contents,$image, $params,$classname,$warn_message,
				 $imageonly,$inline,$addtext, $targetcontentonly,$prettyurl);
  }



  /*
   * Add a directory to the list of searchable directories
   */
  function AddImageDir($dir)
  {
    if( strpos('/',$dir) !== 0 ) $dir = "modules/".$this->GetName().'/'.$dir;
    $this->_image_directories[] = $dir;
  }


  // todo: delete me.
  function ListTemplatesWithPrefix($prefix='',$trim = false )
  {
    return cge_template_utils::get_templates_by_prefix($this,$prefix,$trim);
  }


  // todo: delete me.
  function CreateTemplateDropdown($id,$name,$prefix='',$selectedvalue=-1,$addtext='')
  {
    return cge_template_utils::create_template_dropdown($id,$name,$prefix,$selectedvalue,$addtext);
  }


  /*
   * Part of the multiple database template functionality
   * this function provides an interface for adding, editing,
   * deleting and marking active all templates that match
   * a prefix.
   *
   * @param id = module id (pass in the value from doaction)
   * @param returnid = destination page id
   * @param prefix = the template prefix
   * @param defaulttemplatepref = The name of the template containing the system default template.  This can either be the name of a database template or a filename ending with .tpl.
   * @param active_tab = The tab to return to
   * @param defaultprefname = The name of the preference that contains the name of the current default template.  If empty string then there will be no possibility to set a default template for this list.
   * @param title = Title text to display in the add/edit template form
   * @param info = Information text to display in the add/edit template form
   * @param destaction = The action to return to.
   */
  function ShowTemplateList($id,$returnid,$prefix, $defaulttemplatepref,$active_tab, $defaultprefname,
			    $title,$info = '',$destaction = 'defaultadmin')
  {
    $cgextensions = $this->GetModuleInstance('CGExtensions');
    return $cgextensions->_DisplayTemplateList($this,$id,$returnid,$prefix, $defaulttemplatepref,$active_tab,
			              $defaultprefname,$title,$info,$destaction);
  }


  function _DisplayTemplateList(&$module,$id,$returnid,$prefix,	$defaulttemplatepref,$active_tab,$defaultprefname,
				$title, $info = '',$destaction = 'defaultadmin')
  {
    $this->_load_main();
    return $this->_obj->_DisplayTemplateList($module,$id,$returnid,$prefix,$defaulttemplatepref,$active_tab,
					     $defaultprefname,$title,$info,$destaction);
  }



  /**
   * GetDefaultTemplateForm
   *
   * @deprecated
   */
  function GetDefaultTemplateForm(&$module,$id,$returnid,$prefname,$action,$active_tab,$title,$filename, $info = '')
  {
    return cge_template_admin::get_start_template_form($module,$id,$returnid,$prefname,$action,$active_tab,$title,
						       $filename,$info);
  }


  /***
   * EditDefaultTemplateForm
   *
   * @deprecated
   */
  function EditDefaultTemplateForm(&$module,$id,$returnid,$prefname, $active_tab,$title,$filename,$info = '',$action = 'defaultadmin')
  {
    echo cge_template_admin::get_start_template_form($module,$id,$returnid,$prefname, $action,$active_tab,$title, $filename,$info);
  }


  /*
   * A convenience function to create a url to a certain CMS page
   */
  function CreateContentURL($pageid)
  {
    die('this is still used');
    $config = cmsms()->GetConfig();

    $contentops = cmsms()->GetContentOperations();
    $alias = $contentops->GetPageAliasFromID( $pageid );

    $text = '';
    if ($config["assume_mod_rewrite"]) {
      // mod_rewrite
      if( $alias == false ) {
	return '<!-- ERROR: could not get an alias for pageid='.$pageid.'-->';
      }
      else {
	$text .= $config["root_url"]."/".$alias.(isset($config['page_extension'])?$config['page_extension']:'.shtml');
      }
    }
    else {
      $text .= $config["root_url"]."/index.php?".$config["query_var"]."=".$pageid;
      return $text;
    }
  }


  function GetAdminUsername($uid)
  {
    $user = UserOperations::LoadUserByID($uid);
    return $user->username;
  }


  function GetUploadErrorMessage($code)
  {
    $cgextensions = $this->GetModuleInstance('CGExtensions');
    return $cgextensions->Lang($code);
  }


  function is_alias($str)
  {
    if( !preg_match('/^[\-\_\w]+$/', $str) ) return false;
    return true;
  }


  function set_action_id($id)
  {
    $this->_actionid = $id;
  }


  function get_action_id()
  {
    return $this->_actionid;
  }


  function GetActionId()
  {
    if( !method_exists($this,'get_action_id') && $this->GetName() != 'CGExtensions' ) {
      die('FATAL ERROR: A module derived from CGExtensions is not handling the get_action_id method');
    }
    return $this->get_action_id();
  }


  /***
   * GetSingleTemplateForm
   *
   * @deprecated
   */
  function GetSingleTemplateForm(&$module,$id,$returnid,$tmplname,$active_tab,$title,$filename, $info = '',$destaction='defaultadmin')
  {
    return cge_template_admin::get_single_template_form($module,$id,$returnid,$tmplname,$active_tab,$title,$filename,
							$info,$destaction);
  }


  function GetWatermarkError($error)
  {
    if( empty($error) || $error === 0 ) return '';
    $mod = $this->GetModuleInstance('CGExtensions');
    return $mod->Lang('watermarkerror_'.$error);
  }


  function InitializeCharting()
  {
    require_once(__DIR__.'/lib/pData.class');
    require_once(__DIR__.'/lib/pChart.class');
  }


  function InitializeAssocData()
  {
    require_once(__DIR__.'/lib/class.AssocData.php');
  }


  // todo: remove me.
  function session_clear($key = '')
  {
    if( empty($key) ) {
      unset($_SESSION[$this->GetName()]);
    }
    else {
      unset($_SESSION[$this->GetName()][$key]);
    }
  }


  // todo: remove me.
  function session_put($key,$value)
  {
    if( !isset($_SESSION[$this->GetName()]) ) $_SESSION[$this->GetName()] = array();
    $_SESSION[$this->GetName()][$key] = $value;
  }


  // todo: remove me.
  function session_get($key,$dfltvalue='')
  {
    if( !isset($_SESSION[$this->GetName()]) ) return $dfltvalue;
    if( !isset($_SESSION[$this->GetName()][$key]) ) return $dfltvalue;
    return $_SESSION[$this->GetName()][$key];
  }


  function param_session_get(&$params,$key,$defaultvalue='')
  {
    if( isset($params[$key]) ) return $params[$key];
    return $this->session_get($key,$defaultvalue);
  }


  function resolve_alias_or_id($txt,$dflt = null)
  {
      $txt = trim($txt);
      if( $txt ) {
          $manager = cmsms()->GetHierarchyManager();
          $node = $manager->find_by_tag('alias',$txt);
          if( !isset($node) ) $node = $manager->find_by_tag('id',(int)$txt);
          if( is_object($node) ) return (int)$node->get_tag('id');
      }
      return $dflt;
  }


  // deprecated.
  function http_post($URL,$data = '',$referer='')
  {
    return cge_http::post($URL,$data,$referer);
  }

  // deprecated.
  function http_get($URL,$referer='')
  {
    return cge_http::get($URL,$referer);
  }

  /**
   * Similar to GetPreference except the default value is used even if the preference exists, but is blank.
   */
  public function CGGetPreference($pref_name,$dflt_value = null,$allow_empty = FALSE)
  {
    $tmp = trim($this->GetPreference($pref_name,$dflt_value));
    if( !empty($tmp) || is_numeric($tmp) ) return $tmp;
    if( $allow_empty ) return $tmp;
    return $dflt_value;
  }
} // class

// EOF
?>
