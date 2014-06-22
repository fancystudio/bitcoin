<?php

$GLOBALS['ADODB_QUOTE_FIELDNAMES'] = true;

class EditaciaCien extends CMSModule {


  public static $frontend_templates = array(
      'default'     => 'default (list)',
      'detail'       => 'detail', 
      'search'       => 'search',
      'calendar'     => 'calendar',
      'tagcloud'     => 'tagcloud', // TODO
      'rss'         => 'rss',
      'paginated'   => 'paginated',
      'user_form'   => 'user_form',
      'user_form_succes'   => 'user_form_succes',
      'direct_email'   => 'direct_email'
    );

  const MODULE_OBJECT_NAME = 'EditaciaCienObject';

  public function DoAction($name, $id, $params, $returnid = '') {
    $methods = get_class_methods($this);
    foreach ($methods as $method) {
      if (strpos($method, 'modifier') === 0) {
        $modifier =substr($method, 8);
        $modifier{0} = strtolower($modifier{0});
        $this->smarty->register_modifier($modifier, array($this, $method));
      }
    }
    parent::DoAction($name, $id, $params, $returnid);
  }

  public function __construct() {
    parent::__construct();
    $this->InitializeGlobal();
  }

  public function GetName() {               return 'EditaciaCien';  }
  public function GetObjectName() {         return 'EditaciaCienObject';  }
  public function GetFriendlyName() {       return 'Editacia cien';  }
  public function GetVersion() {            return '2';  }
  public  function GetHelp() {              return $this->Lang('help');  }
  public  function GetAuthor() {            return 'Auto-generated by M&C Factory';  }
  public  function GetAuthorEmail() {       return 'jcc@morris-chapman.com';  }
  public  function GetChangeLog() {         return $this->Lang('changelog');  }
  public  function IsPluginModule() {       return true;  }
  public  function HasAdmin() {             return true;}
  public  function GetAdminSection() {      return 'content';  }
  public  function GetAdminDescription() {  return $this->Lang('admindescription');  }
  public  function VisibleToAdminUser() {   return ($this->CheckAccess() || $this->CheckAccess('Modify Templates')); }
  public  function GetDependencies() {      return array('MCFactory' => '3.4.92');  }
  public  function CheckAccess($permission = 'Manage EditaciaCien') {    return $this->CheckPermission($permission);  }
  
  public  function DisplayErrorPage($id, &$params, $return_id, $message='') {
    $this->smarty->assign('title_error', $this->Lang('error'));
    $this->smarty->assign_by_ref('message', $message);
    echo $this->ProcessTemplate('error.tpl');
  }
  
  public  function HasCapability($capability, $params=array()) {
    $capabilities = array(
      'digest_export',
      'cms_users'
    );
    
    if (in_array($capability, $capabilities)) return true;
    return false;
  }

  function MinimumCMSVersion() {            return '1.9';  }
  function InstallPostMessage() {           return $this->Lang('postinstall');  }
  function UninstallPostMessage() {         return $this->Lang('postuninstall');  }
  function UninstallPreMessage() {          return $this->Lang('really_uninstall');  }
  public function Install() {
    
    $config = cms_utils::get_config();
    $db = cms_utils::get_db();
    $dict = NewDataDictionary($db);

    $fields = array(
    	'id I KEY',
		'user_id I',
		'parent_id I',
		'title C(255)',
				'EUR_k_dispozci_na_nkup C(255)',
				'btc_k_dispozci_na_predaj C(255)',
				'mara_v_Percent_na_nkup C(255)',
				'mara_v_Percent_na_predaj C(255)',
				'created_at D',
		'created_by I',
		'mcfi_created_timestamp I',
		'updated_at D',
		'updated_by I',
		'mcfi_updated_timestamp I',
		'send_update_immediately I',
		'order_by I',
		'published I',
		'parent_item I',
		'full_text_search XL'
    );

    $sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_editaciacien', implode(',',$fields));
    $dict->ExecuteSQLArray($sqlarray);
    $db->CreateSequence(cms_db_prefix().'module_editaciacien_seq');
    
    //$this->SetTemplate('display_list', $this->GetTemplateFromFile('template.list'));
    //$this->SetTemplate('display_paginated', $this->GetTemplateFromFile('template.paginated'));
    //$this->SetTemplate('display_details', $this->GetTemplateFromFile('template.details'));
    //$this->SetTemplate('display_search', $this->GetTemplateFromFile('template.search'));
    //$this->SetTemplate('display_calendar', $this->GetTemplateFromFile('template.calendar'));
    
    //@mkdir($config['root_path'].'/uploads/EditaciaCien');
    $this->CreateEvent('ContentEditPost');
    cms_utils::get_module('MCFactory')->AddEventHandler($this->getName(), 'ContentEditPost', false);
    $this->CreatePermission('Manage EditaciaCien', 'Manage EditaciaCien');  
    $this->CreatePermission('Admin EditaciaCien', 'Admin EditaciaCien');  
    $this->SetPreference('index_content', 'true');
    $this->SetPreference('twitter_template', '{$title} - {$url}');
    $this->SetPreference('mcfactory_version', '3.4.92');
  }

  public function Upgrade($oldversion, $newversion)  {
    $db = $this->GetDb();
    $dict = NewDataDictionary($db);
    
    $oldversion = $this->GetPreference('mcfactory_version', '2.5.0');
    
    switch(true) {
      case version_compare($oldversion, '2.9.0', '<'):
        $this->GetPreference('index_content',$this->GetPreference('index_content', 'true'));
      case version_compare($oldversion, '2.9.9', '<'):
        $this->AddDefaultTemplate('default', 'display_list');
        $this->AddDefaultTemplate('detail', 'display_details');
        $this->AddDefaultTemplate('paginated', 'display_paginated');
        $this->AddDefaultTemplate('search', 'display_search');
        $this->AddDefaultTemplate('calendar', 'display_calendar');
      case version_compare($oldversion, '2.9.16', '<'):
          $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_editaciacien', 'user_id I');
          $dict->ExecuteSQLArray($sqlarray);
      case version_compare($oldversion, '2.12.1', '<'):
          $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_editaciacien', 'mcfi_created_timestamp I');
          $dict->ExecuteSQLArray($sqlarray);
          $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_editaciacien', 'mcfi_updated_timestamp I');
          $dict->ExecuteSQLArray($sqlarray);
      case version_compare($oldversion, '3.1.8', '<'):
          $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_editaciacien', 'send_update_immediately I');
          $dict->ExecuteSQLArray($sqlarray);
      
      
    }
    
    $this->SetPreference('mcfactory_version', '3.4.92');
  }

  public function Uninstall() {
    $db = cms_utils::get_db();
    $dict = NewDataDictionary($db);
    $sql = $dict->DropTableSQL(cms_db_prefix().'module_editaciacien');
    $dict->ExecuteSQLArray($sql);
    $db->DropSequence(cms_db_prefix().'module_editaciacien_seq');
    cms_utils::get_module('MCFactory')->RemoveEventHandler($this->getName(), 'ContentEditPost');
    $this->RemoveEvent('ContentEditPost');
    $this->RemovePreference();
  }

  function XtendedModule () {
    return true;
  }

  function GetHeaderHTML() {
    $html = '';
    
    $mcf = cms_utils::get_module('MCFactory');
    
    if(is_object($mcf))
    {      
        $html .= '<link rel="stylesheet" type="text/css" href="' . $mcf->loadResource('public/css/jquery-ui.min.css') . '" />';

        // SELECT2
        $html .= '<link rel="stylesheet" type="text/css" href="'.$mcf->GetModuleURLPath(). '/lib/vendor/select2/select2.css" />';
        $html .= '<script type="text/javascript" src="'.$mcf->GetModuleURLPath(). '/lib/vendor/select2/select2.js"></script>';
        
        $html .= '
        <script type="text/javascript">
          $(document).ready(function() {
            $(".chzn-select").select2();
          });
        </script>';
    }
    
    return $html;
  }

  function setParameters()  {  $this->InitializeGlobal(); }

  function InitializeGlobal() {  
    $this->RegisterModulePlugin();
    // $this->RegisterRoute('/editaciacien\/(?P<item_id>[0-9]+)(\/.*?)?$/', array('action' => 'detail', 'returnid' => cmsms()->GetContentOperations()->GetDefaultPageID()));
    $this->RegisterRoute('/editaciacien\/(?P<item_id>[0-9]+)\/(?P<returnid>[0-9]+)(\/.*?)?$/', array('action' => 'detail'));
    $this->RegisterRoute('/editaciacien\/rss\/(?P<maction>[a-zA-Z0-9_-]+)(\/.*?)?$/', array('action' => 'rss', 'showtemplate' => 'false','returnid' => cmsms()->GetContentOperations()->GetDefaultPageID()));
    $this->RegisterRoute('/editaciacien\/api\/(?P<command>[a-zA-Z0-9_-]+)(\/.*?)?$/', array('action' => 'api', 'showtemplate' => 'false','returnid' => cmsms()->GetContentOperations()->GetDefaultPageID()));
    
    $this->RegisterRoute('/editaciacien\/download\/(?P<item_id>[0-9]+)\/(?P<field>[a-zA-Z0-9_-]+)(\/.*?)?$/', 
      array(
      'action' => 'download', 
      'showtemplate' => 'false',
      'returnid' => cmsms()->GetContentOperations()->GetDefaultPageID()
      ));

		$this->RegisterParameters();
  }


	private function RegisterParameters()
	{
        // NOTICE: Due to the dynamic behind MCFactory, it is not possible to clean parameters properly. Although it is not possible to have the admin logs full of alert. For the moment, this is the only alternative.
		$this->RestrictUnknownParams(true);
        $this->SetParameterType(CLEAN_REGEXP . '/[-a-zA-Z0-9_]*/',CLEAN_NONE);
	}
	
  function createLink($id, $action, $returnid='', $contents='', $params=array(), $warn_message='', $onlyhref=false, $inline=false, $addttext='', $targetcontentonly=false, $prettyurl='',  $withslash = false) {
    if ($targetcontentonly || ($returnid != '' && !$inline)) {
      $id = 'cntnt01';
    }
    if (!$returnid) {  
        $returnid = cms_utils::get_current_pageid();
    }
    
    if (empty($prettyurl)) {
      if ($action == 'detail') {
        $item_id = $params['item_id'];
        $prettyurl = 'editaciacien/' . $item_id . '/' . $returnid;
       
        if (!empty($params['title'])) {
          $prettyurl .= '/' . munge_string_to_url($params['title'],false,$withslash);
        }
        
        $query = array();
        foreach ($params as $name => $value) {
          if (!in_array($name, array(
            'module', 'action', 'item_id', 'title',
            'orderby','limit'
            ))) {
            $query[$id . $name] = $value;
          }
        }
        if (count($query)) {
          $prettyurl .= '?' . http_build_query($query);
        }
      }
    }
    return parent::createLink($id, $action, $returnid, $contents, $params, $warn_message, $onlyhref, $inline, $addttext, $targetcontentonly, $prettyurl);
  }

  function SearchReindex() {
    $c = new MCFCriteria();
    $c->add('published', 1);
    $items = EditaciaCienObject::doSelect($c);
    foreach ($items as $item) {
      $this->index($item, true);
    }
  }
  
  function SearchDeindex() {
    $c = new MCFCriteria();
    $c->add('published', 1);
    $items = EditaciaCienObject::doSelect($c);
    foreach ($items as $item) {
      $this->deindex($item);
    }
  }

  function index($item, $force = false) {
    if ($this->getPreference('index_content') == 'true' || $this->getPreference('index_content') == '1' || $force)
    {
      $search = $this->GetModuleInstance('Search');
      if ($search) {
        $search->AddWords(
          'EditaciaCien',
          $item->getId(),
          'editaciacien_item',
          $item->getSearchString()
        );
      }
    }
  }

  function deindex($item) {
    $search = $this->GetModuleInstance('Search');
    if ($search) {
      $search->DeleteWords('EditaciaCien', $item->getId(), 'editaciacien_item');
    }
  }

  function SearchResult($returnid, $id, $attr = '') {
    $result = array();
    if ($attr == 'editaciacien_item') {
      $c = new MCFCriteria();
      $c->add('id', $id);
      $c->add('published', 1);
      $item = EditaciaCienObject::doSelectOne($c);
      if ($item) {
        $result[0] = $this->GetFriendlyName();
        $result[1] = $item->getTitle();
        $result[2] = $this->CreateLink('cntnt01', 'detail', $returnid, '', array('item_id' => $id, 'title' => $item->getTitle()), '', true);
      }
    }
    return $result;
  }
  
  /*
  * Digest: New notification tool function
  */
  
  public function Digest($timestamp, $params)
  {
    return $this->NTList(date('Y-m-d', $timestamp), $params['template'], $params);
  }
  
  /**
   * NTList: Notification Tool function: Return the list of items uploaded since a certain date 
   */

  function NTList($date, $template = null, $params = array())
  {
    $returnid = $this->getPreference('default_page', $this->cms->GetContentOperations()->GetDefaultPageID());
    $c = new MCFCriteria();
    $c->add('published', '1');
    if(isset($params['created_at']))
    {
      $c->add('created_at', $date, MCFCriteria::GREATER_EQUAL);  
    }
    elseif(isset($params['date_field']))
    {
      $c->add($params['date_field'], $date, MCFCriteria::GREATER_EQUAL);  
    }
    else
    {
      $c->add('updated_at', $date, MCFCriteria::GREATER_EQUAL);
    }    
    
    EditaciaCienObject::buildFrontendFilters($c, $params);
    $c->addAscendingOrderByColumn('updated_at');
    $items = EditaciaCienObject::doSelect($c);

    if (empty($items))
    {
      return null;
    }
    
    if (!is_null($template))
    {
      $params['template'] = $template;
    }

    $detailpage = $returnid;
    if (isset($params['detailpage'])) {
        $manager = cmsms()->GetHierarchyManager();
        $node = $manager->sureGetNodeByAlias($params['detailpage']);
        if ($node) {
            $content = $node->GetContent();
            if ($content)
            {
                $detailpage = $content->Id();
            }
        } else {
            $node = $manager->sureGetNodeById($params['detailpage']);
            if ($node) {
                $detailpage = $params['detailpage'];
            }
        }
        $params['origid'] = $returnid;
    }

    foreach ($items as &$item) {
      $params['item_id'] = $item->getId();
      $params['title'] = $item->getTitle();
      $newparams = $params;
      unset($newparams['showtemplate']);
      $item->detail_link = $this->createLink($id, 'detail', $detailpage, $contents='', $newparams, '', true);
      if(class_exists('MX_XtendedModule'))
      {
        $xtended_felist = MX_XtendedModule::getRelatedItems($this->getName(), $item->getId());        
      }
    }
    unset($item);

    $this->smarty->assign('items', $items);    
    $this->smarty->assign('EditaciaCien', $items);
    $this->smarty->assign('editaciacien', $items);
    $paramsobj = new stdClass();
    $paramsobj->params = $params;
    $this->smarty->assign('mcfactory', $paramsobj);
    $this->smarty->assign('editaciacien_params', $paramsobj);
    return $this->ProcessTemplateFor('default', $params);
  }
  
    
  public function updateItem($item_id)
  {
    $item = EditaciaCienObject::retrieveByPk($item_id);
    
    if ($item !== false)
    {
      $item->forceUpdateObject('magic');  
    }
  }

  public function getAdminList($id,$returnid,$third=null)
  {

  }
  
  public static function ExportDatas()  {
    $datas = array();
    $c = new MCFCriteria();
    $items = EditaciaCienObject::doSelect($c);

    $datas[0] = array(
      'id',
      'title',
                      'EUR K Dispozci Na Nkup',
                              'Btc K Dispozci Na Predaj',
                              'Mara V Percent Na Nkup',
                              'Mara V Percent Na Predaj',
                    'created_at',
      'created_by',
      'mcfi_created_timestamp',
      'updated_at',
      'updated_by',
      'mcfi_updated_timestamp',
      'order_by',
      'published',
      'parent_item',
      'parent_id',
      'user_id'
      );
      
    foreach($items as $item)
    {
      $datas[] = array(
        'id' => $item->getId(),
        'title' => $item->getTitle(),
                            'EUR K Dispozci Na Nkup' => $item->getEURKDispozciNaNkup(),
                                      'Btc K Dispozci Na Predaj' => $item->getBtcKDispozciNaPredaj(),
                                      'Mara V Percent Na Nkup' => $item->getMaraVPercentNaNkup(),
                                      'Mara V Percent Na Predaj' => $item->getMaraVPercentNaPredaj(),
                          'created_at' => $item->getCreatedAt(),
        'created_by' => $item->getCreatedBy(),
        'mcfi_created_timestamp' => $item->getMcfiCreatedTimestamp(),
        'updated_at' => $item->getUpdatedAt(),
        'updated_by' => $item->getUpdatedBy(),
        'mcfi_updated_timestamp' =>  $item->getMcfiUpdatedTimestamp(),
        'order_by' => $item->getOrderBy(),
        'published' => $item->getPublished(),
        'parent_item' => $item->getParentItem(),
        'parent_id' => $item->getParentId(),
        'user_id' => $item->getUserId()
      );
    }
      
    return $datas;
  }
  
  // CMS User
  public function getUserFunction()
  {
    // Is User Module ?
          // First one win
                                                                      return false;
  }
  
  // TEMPLATES
  
  public function GetDefaultTemplates()
  {
    $array = unserialize($this->GetPreference('default_templates'));
    if (is_array($array))
    {
      return $array;
    }
    return array();
  } 
  
  public function SetDefaultTemplates($list = array())
  {
    return $this->SetPreference('default_templates', serialize($list));
  }
  
  public function AddDefaultTemplate($action, $template)
  {
    $list = $this->GetDefaultTemplates();
    $list[$action] = $template;
    $this->SetDefaultTemplates($list);
  }
  
  public function GetDefaultTemplate($action)
  {
      $list = $this->GetDefaultTemplates();
      if (!is_array($list)) $list = array();
      if (array_key_exists($action, $list)) // TODO: Possible problem with list
      {
        return $list[$action];
      }
      else
      {
        return false;
      }
  }
  
  public function isDefaultTemplate($template)
  {    
    $list = $this->GetDefaultTemplates();
    $action = array_search($template, $list);
    if($action !== false)
    {
      return $action;
    }
    return false;
  }  
  
  public function removeDefaultTemplate($template)
  {    
    $list = $this->GetDefaultTemplates();
    $action = array_search($template, $list);
    if($action !== false)
    {
      unset($list[$action]);
      $this->SetDefaultTemplates($list);
    }
    return false;
  }
  
  public function ProcessTemplateFor($action, $params = array())
  {
    if (isset($params['template']) && $this->GetTemplate($params['template'])) {
      return $this->ProcessTemplateFromDatabase($params['template']);
    }
    elseif (($template = $this->GetDefaultTemplate($action))  &&  ($this->GetTemplate($template) !== false))
    {
      return $this->ProcessTemplateFromDatabase($template);
    }
    else
    {
      return $this->ProcessTemplate('frontend.'.$action.'.tpl');
    }
  }
  
  public function ParamsForLink($params,$include = array(),$exclude = array())
  {
    $new_params = array();
    
    foreach($params as $key => $value)
    {
      if (!in_array($key, $exclude))
      {
        $new_params[$key] = $value;
      }
    }
    
    foreach($include as $key => $value)
    {
      if (!in_array($key, $exclude))
      {
        $new_params[$key] = $value;
      }
    }
    
    // Now we'll treath the complex array problem
    
    $query = http_build_query($new_params);
    $entries = explode('&', $query);
    $output = array();
    foreach($entries as $entry)
    {
      $data = explode('=', $entry);
      $output[$data[0]] = urldecode($data[1]);
    }  
    
    return $output;
  }
  
  public function buildFiltersCriteria(MCFCriteria &$c, $filters)
  {
    // DEPRECATED
    EditaciaCienObject::buildFiltersCriteria($c, $filters);
  }
  
  public function buildFrontendFilters(MCFCriteria &$c, $params)
  {
    // DEPRECATED
    EditaciaCienObject::buildFrontendFilters($c, $params);
  }
  
  public static function jumpTo($url)
  {
    $url = self::parseUrl($url);
    if (headers_sent())
    {
      echo '
      <script type="text/javascript">
      <!--
        location.replace("'.$url.'");
      // -->
      </script>
      <noscript>
        <meta http-equiv="Refresh" content="0;URL='.$url.'">
      </noscript>';
      exit;
    }
    else
    {
      header('Location: '.$url);
    }
  }
  
  private static function parseUrl($url)
  {
    if (strpos($url,'http') === 0)
    {
      return $url;
    }
    else
    {
      $manager = cmsms()->GetHierarchyManager();
      $node = $manager->sureGetNodeByAlias($url);
      if ($node) {
        $content = $node->GetContent();
        if ($content)
        {
          return $content->GetUrl();
        }
      }
      else
      {
        $node = $manager->sureGetNodeById($url);
        if ($node) {
          $content = $node->GetContent();
          if ($content)
          {
            return $content->GetUrl();
          }
        }
      }
    }  
    return null;
  }

	  
  // EXTRA ACTIONS
  
  public function getButtonsFor($place)
  {
    global $id;
    global $returnid;
    
    switch($place)
    {
            default:
      break;
    }

  }
  
  public static function getTitleLabel()
  {
    return (string)'Title';
  }

	public function doSelect(MCFCriteria $c)
	{
		return EditaciaCienObject::doSelect($c);
	}
}

?>