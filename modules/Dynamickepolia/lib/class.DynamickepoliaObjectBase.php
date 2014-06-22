<?php
$config = cms_utils::get_config();
require_once(cms_join_path($config['root_path'], 'lib', 'classes', 'module_support', 'modtemplates.inc.php'));

class DynamickepoliaObjectBase extends MCFModuleObject {

  protected $childrens;
  protected $level;

  const MODULE_NAME = 'Dynamickepolia';
  const MODULE_OBJECT_NAME = 'DynamickepoliaObject';

  const DB_NAME = 'module_dynamickepolia';
  const DB_ITEM = 'dynamickepolia';
  const UPLOADS_RELATIVE_URL = '/uploads/Modules/Dynamickepolia';

  protected static $fields = array('title',  'parent_id',  'parent_item',  'order_by', 'published', 'send_update_immediately', 'pole1',   'pole2',    'full_text_search'  );

    
    
    
    
  

  /**
   * @param $name
   * @param $value
   * @deprecated
   */
  public function set($name, $value) {
    if ($this->$name != $value) {
      $this->__set($name, $value);
    }
  }

  /**
   * @param $name
   * @return mixed
   * @deprecated
   */
  public function get($name) {
    // DEPRECATED
    return $this->__get($name);
  }



  public function full_text_search()  {
    $text = $this->title;
                  $text .= ' ' . $this->pole1;
                        $text .= ' ' . $this->pole2;
              return $text;
  }

  // OLD WAY
    
  public function __toString()
    {
        return (string)$this->title;
    }

	// Parent ID is the parent ID of the same module
  public function getParentId() {
    return $this->parent_id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getCreatedAt() {
    return $this->created_at;
  }

  public function getCreatedBy() {
    return $this->created_by;
  }

  public function getUpdatedAt() {
    return $this->updated_at;
  }

  public function getUpdatedBy() {
    return $this->updated_by;
  }

  public function getOrderBy() {
    return $this->order_by;
  }

	// Parent Item is the parent ID of the parent module (not the same one)
  public function getParentItem() {
    return $this->parent_item;
  }

  public function getParentItemObject() {
    return DynamickepoliaObject::doSelectOne(array('where' => array('id' => $this->parent_item)));
  }

  public function getPublished() {
    return $this->published;
  }
  
  public function getCoreSlug() {
    return $this->title;
  }

  public function getFullTextSearch() {
    return $this->full_text_search();
  }

  public function setParentId($value) {
    $this->__set('parent_id', $value);
  }

  public function setTitle($value) {
    $this->__set('title', $value);
  }

  public function setCreatedAt($value) {
    $this->created_at = $value;
  }

  public function setCreatedBy($value) {
    $this->created_by = $value;
  }

  public function setUpdatedAt($value) {
    $this->updated_at = $value;
  }

  public function setUpdatedBy($value) {
    $this->updated_by = $value;
  }

  public function setOrderBy($value) {
    $this->__set('order_by', $value);
  }

  public function setParentItem($value) {
    $this->__set('parent_item', $value);
  }

  public function setPublished($value) {
    $this->__set('published', $value);
  }

  public function setFullTextSearch($value) {
    $this->__set('full_text_search', $value);
  }

  

  

  /**
    * @param bool $parse
    */
  public function getPole1($parse = false) {
    if ($parse) {
      return cms_module_ProcessTemplateFromData(new stdClass(), $this->pole1);
    }
    return $this->pole1;
  }

  public function setPole1($value) {
        $this->__set('pole1', $value);
  }

  
  
  
  
  
  
  

  /**
    * @param bool $parse
    */
  public function getPole2($parse = false) {
    if ($parse) {
      return cms_module_ProcessTemplateFromData(new stdClass(), $this->pole2);
    }
    return $this->pole2;
  }

  public function setPole2($value) {
        $this->__set('pole2', $value);
  }

  
  
  
  
  
  
  
  protected static function getFilesPath()  {
        $config = cms_utils::get_config();
    $path = $config['root_path'];
        if (!is_dir($path . self::getUploadsRelativePath()))
    {
      mkdir($path . self::getUploadsRelativePath(),0777,true);
    }
    return $path;
  }
  
  protected static function getFilesFullPath()  {
    return self::getFilesPath() . self::getUploadsRelativePath();
  }
  
  protected static function getUploadsRelativePath()  {
    return str_replace('/', DIRECTORY_SEPARATOR, self::UPLOADS_RELATIVE_URL);
  }
  
  protected static function retrieveFilename($filename)  {
    // To try: return end(explode(DIRECTORY_SEPARATOR, $filename));
    $clean = str_replace(self::UPLOADS_RELATIVE_URL, '', $filename);
    $clean = str_replace('/', '', $clean);
    $clean = str_replace('\\', '', $clean);
    return $clean;
  }

  protected function checkFilename($file)  {
    $pathinfo = pathinfo($file['name']);
    $filename = self::cleanFilename($pathinfo['filename']);
    $final_filename = self::cleanFilename($pathinfo['filename']);
    $i = 2;
    while (file_exists(self::getFilesFullPath() . DIRECTORY_SEPARATOR . $final_filename . '.' . $pathinfo['extension'])) {
      $final_filename = $filename.'-'.$i;
      ++$i;
    }
    return $final_filename . '.' . $pathinfo['extension'];
  }

  //function

    public function downloadMCFFile($field) {
      switch($field)
      {
                                    default:
        return false;
      }
    }

  public function deleteFiles($params) {
                          }

  public function uploadFiles($id) {
                            
    
  }

  public function getSearchString() {
    $fields[] = $this->getTitle();
                $fields[] = $this->getPole1();
                      $fields[] = $this->getPole2();
              return implode(' ', $fields);
  }

  public function getAsArray()  {
    $array = $this->vars;
    $array['id'] = $this->id;
    $array['item_id'] = $this->getId();


    
        
          
    
        
          
        
//    unset($array['xtended_felist']);
//    unset($array['full_text_search']);
    return $array;
  }

  public function getJson()  {
    return json_encode($this->getAsArray());
  }

  
  public function getParent() {
      if ($this->parent_id) {
          return self::getById($this->parent_id);
      }
    return false;
  }
  
  public function getPossibleParents() {
    $objects = self::doSelect(new MCFCriteria());
    $possible_objects = array(0 => '');
    foreach ($objects as $object) {
      if (($object->getId() != $this->getId()) && !$object->isDescendantOf($this->getId())) {
        $possible_objects[$object->getId()] = (string)$object;
      }
    }

    return $possible_objects;
  }
  
  public function getPossibleParentsHierarchy($separator = ' - ', $root_only = false)  {
    $c = new MCFCriteria();
    $c->add('parent_id', '', MCFCriteria::ISEMPTY);
    if($this->getId() != '')
    $c->add('id', $this->getId(), MCFCriteria::NOT_EQUAL);
    $roots = self::doSelect($c);
    $array = array();

    foreach($roots as $root)
    {
      $array[$root->getId()] = (string)$root;
      if(!$root_only)
      {
       $array = $array + self::getChildrenHierarchy($root->getId(), $separator, 1, $this->getId());
      }
    }

    return $array;
  }
  
  public static function getChildrenHierarchy($id,$separator = ' - ', $level = 1, $without_childrens_of = null) {
    $array = array();
    $direct_childrens = self::getChildrensOf($id);
    foreach($direct_childrens as $children)
    {
      if ($children->getId() != $without_childrens_of)
      {
        $sep = '';
        for($i = 0; $i < $level; $i++){$sep .= $separator;}
        $array[$children->getId()] = $sep . $children->getTitle();
        $array = $array + self::getChildrenHierarchy($children->getId(), $separator, $level+1,$without_childrens_of);
      }
    }
    return $array;
  }
  
  public static function getChildrensOf($id)  {
    $c = new MCFCriteria();
    $c->add('parent_id', $id, MCFCriteria::EQUAL);
    return self::doSelect($c);
  }
  
  public function getChildrens()  {
    if(!isset($this->childrens))
    {
      $this->childrens = self::getChildrensOf($this->getId());
    }
    return $this->childrens;
  }

	public function setLevel($value)
	{
		$this->level = (int)$value;
	}
	
	public function getLevel()
	{
		return $this->level;
	}

  public function retrieveChildrensItems()
  {
    return $this->childrens;
  }
  
  public function addChildrenItem(&$item)
  {
    $this->childrens[$item->getId()] = $item;
  }

	public function pushChildrens(&$childrends)
	{
		foreach($childrends as &$item)
		{
			$this->addChildrenItem($item);
		}
	}
	
	public function hasChildrens()
	{
		if(!is_array($this->childrends))
		{
			$c = new MCFCriteria();
	    $c->add('parent_id', $this->getId(), MCFCriteria::EQUAL);
	    return (bool)self::doCount($c);
		}
		elseif(is_array($this->childrends) && count($this->childrends) > 0)
		{
			return true;
		}
		return false;
	}

  public function isDescendantOf($id) {
    $item = $this;
    while ($item = $item->getParent()) {
      if ($item->getId() == $id) {
        return true;
      }
    }
    return false;
  }

	public function countSibling($parent_key = 'parent_id')
	{
		$c = new MCFCriteria();
		switch($parent_key)
		{
			case 'parent_item':
				$c->add('parent_item', $this->parent_item);
				break;
			default:
				$c->add('parent_id', $this->parent_id);
				break;
		}
		return self::doCount($c);
	}

  public static function doCount(MCFCriteria $crit) {
    $c = clone $crit;
    $db = cms_utils::get_db();
    $c->addSelectColumn('COUNT(*) AS nbitems');
    $query = $c->buildQuery(cms_db_prefix().self::DB_NAME);
    $result = $db->execute($query, $c->values);
    if($result)
    {
      $row = $result->FetchRow();
      return $row['nbitems'];
    }
    else
    {
      return 0;
    }
  }
  
  public static function buildObjects($result, $extra_fields = array(), $by_id = true)
  {
    $objects = array();
    while ($result && $row = $result->FetchRow()) {
      $object = new DynamickepoliaObject();
      $object->populateFromArray($row);
      $object->is_modified = false;
      if(count($extra_fields))
      {
        foreach($extra_fields as $key => $col)
        {
          $object->$key = $row[$col];
        }
      }
      if($by_id)
      {
        $objects[$object->getId()] = $object;
      }
      else
      {
        $objects[] = $object;
      }
    }
    return $objects;
  }

  public static function buildTree(&$results)
  {
    $tree = array();
    foreach($results as &$result)
    {
      if(is_null($result->parent_id) || ($result->parent_id == 0))
      {
        $tree[$result->getId()] = $result;
      }
      else
      {
        if(isset($results[$result->parent_id]))
        {
          // We want the full tree to the roots without orphans... Poor of them.
          $results[$result->parent_id]->addChildrenItem($result);
        }
      }
    }
    return $tree;
  }

  public static function doSelect(MCFCriteria $crit) {
    $c = clone $crit;
    $db = cms_utils::get_db();
    $query = $c->buildQuery(cms_db_prefix().self::DB_NAME, true);
    $result = $db->execute($query, $c->values);
    return self::buildObjects($result);
  }

  /** @return DynamickepoliaObject */

  public static function doSelectOne(MCFCriteria $crit) {
    $c = clone $crit;
    $c->setLimit(1);
    $objects = self::doSelect($c);
    return current($objects);
  }

  public static function getById($id) {
    return self::retrieveByPk($id);
  }
  
  public static function retrieveByPk($id)  {
    $c = new MCFCriteria();
    $c->add('id', $id);
    return self::doSelectOne($c);
  }
  
  public static function retrieveByUser($user_id)
  {
    // For profiles
    $c = new MCFCriteria();
    $c->add('user_id', $user_id);
    return self::doSelectOne($c);
  }

	public static function retrieveByParentItem($parent_item)
	{
		$c = new MCFCriteria();
    $c->add('parent_item', $parent_item);
    return self::doSelect($c);
	}

  public static function getTitles() {
    $db = cms_utils::get_db();
    $c = new MCFCriteria();
    $c->addAscendingOrderByColumn(cms_utils::get_module(self::MODULE_NAME)->getPreference('order_by', 'order_by'));
    $query = $c->buildQuery(cms_db_prefix().self::DB_NAME);
    $result = $db->execute($query, $c->values);
    $objects = array();
    while ($result && $row = $result->FetchRow()) {
      $objects[$row['id']] = $row['title'];
    }
    //asort($objects);
    return $objects;
  }

  public static function query($sql, $values = array()) {
    $db = cms_utils::get_db();
    return $db->execute($sql, $values);
  }
  
  public function populateFromArray(array $params, $prefix = null) {
    if(!is_null($prefix)) $prefix .= '.';
    if (isset($params[$prefix.'id'])) {
      $this->setId($params[$prefix.'id']);
    }
    if (isset($params[$prefix.'user_id'])) {
      $this->setUserId($params[$prefix.'user_id']);
    }
    if (isset($params[$prefix.'parent_id'])) {
      $this->parent_id = $params[$prefix.'parent_id'];
    }
    if (isset($params[$prefix.'title'])) {
      $this->setTitle($params[$prefix.'title']);
    }
    if (isset($params[$prefix.'created_at'])) {
      $this->setCreatedAt($params[$prefix.'created_at']);
    }
    if (isset($params[$prefix.'created_by'])) {
      $this->setCreatedBy($params[$prefix.'created_by']);
    }
    if (isset($params[$prefix.'updated_at'])) {
      $this->setUpdatedAt($params[$prefix.'updated_at']);
    }
    if (isset($params[$prefix.'updated_by'])) {
      $this->setUpdatedBy($params[$prefix.'updated_by']);
    }
    if (isset($params[$prefix.'mcfi_created_timestamp'])) {
      $this->setMcfiCreatedTimestamp($params[$prefix.'mcfi_created_timestamp']);
    }
    if (isset($params[$prefix.'mcfi_updated_timestamp'])) {
      $this->setMcfiUpdatedTimestamp($params[$prefix.'mcfi_updated_timestamp']);
    }
    if (isset($params[$prefix.'order_by'])) {
      $this->setOrderBy($params[$prefix.'order_by']);
    }
    if (isset($params[$prefix.'parent_item'])) {
      $this->setParentItem($params[$prefix.'parent_item']);
    }
    if (isset($params[$prefix.'published'])) {
      $this->setPublished($params[$prefix.'published']);
    }
    if (isset($params[$prefix.'send_update_immediately'])) {
      $this->send_update_immediately = $params[$prefix.'send_update_immediately'];
    }
    if (isset($params[$prefix.'full_text_search']))
    {
      $this->setFullTextSearch($params[$prefix.'full_text_search']);
    }
        if (isset($params[$prefix.'pole1'])) {
      $this->setPole1($params[$prefix.'pole1']);
    }
        if (isset($params[$prefix.'pole2'])) {
      $this->setPole2($params[$prefix.'pole2']);
    }
      }

  public function toArray()
  {
    $array = array();

    $array['id'] = $this->getId();
    $array['user_id'] = $this->getUserId();
    $array['parent_id'] = $this->parent_id;
    $array['title'] = $this->title;
    $array['created_at'] = $this->created_at;
    $array['created_by'] = $this->created_by;
    $array['updated_at'] = $this->updated_at;
    $array['updated_by'] = $this->updated_by;
    $array['mcfi_created_timestamp'] = $this->mcfi_created_timestamp;
    $array['mcfi_updated_timestamp'] = $this->mcfi_updated_timestamp;
    $array['parent_item'] = $this->parent_item;
    $array['published'] = $this->published;

        $array['pole1'] = $this->getPole1();
        $array['pole2'] = $this->getPole2();
        
    return $array;
  }

  public function isNew() {
    return $this->getId() ? false : true;
  }

  public function populate($row)  {
    if (isset($row[self::DB_ITEM.'__id']))
    {
      $this->setId($row[self::DB_ITEM.'__id']);
    }

    if (isset($params['user_id'])) {
        $this->user_id = $row[self::DB_ITEM.'__user_id']; //$params['created_at'];
    }
    if (isset($params['created_at'])) {
        $this->created_at = $row[self::DB_ITEM.'__created_at']; //$params['created_at'];
      }
    if (isset($params['created_by'])) {
      $this->created_by = $row[self::DB_ITEM.'__created_by']; //$params['created_by'];
    }
    if (isset($params['updated_at'])) {
      $this->updated_at = $row[self::DB_ITEM.'__updated_at']; //$params['updated_at'];
    }
    if (isset($params['updated_by'])) {
      $this->updated_by = $row[self::DB_ITEM.'__updated_by']; //$params['updated_by'];
    }
    if (isset($params['mcfi_created_timestamp'])) {
      $this->mcfi_created_timestamp = $row[self::DB_ITEM.'__mcfi_created_timestamp'];
    }
    if (isset($params['mcfi_updated_timestamp'])) {
      $this->mcfi_updated_timestamp = $row[self::DB_ITEM.'__mcfi_updated_timestamp'];
    }



    foreach (self::$fields as $field)
    {
      if (isset($row[self::DB_ITEM.'__'.$field]))
      {
        $this->$field = $row[self::DB_ITEM.'__'.$field];
      }
    }
  }

  public static function generateSelectList()  {
    $fields = array_merge(array('id','user_id','created_at','created_by','updated_at','updated_by', 'mcfi_created_timestamp', 'mcfi_updated_timestamp'), self::$fields);
    $list = array();
    foreach ($fields as $field)
    {
      $list[] = self::DB_ITEM . '.'.$field.' as '. self::getRowName($field);
    }
    return implode(' , ',$list);
  }

  public static function getRowName($name)  {
    return self::DB_ITEM . '__' . $name;
  }

  public function save($params = array(), $force_save = false) {
    $this->preSave();
    if ($this->getId() && !$force_save) {
        if ($this->is_modified) {
            $this->update($params);
        }
    } else {
      $this->insert($params);
    }
    $this->postSave();
    cms_utils::get_module(self::MODULE_NAME)->index($this);
    //  debug_display($entry); // TO IMPLEMENT: Show datas for debug
    return true;
  }

  public function delete() {
    if ($this->getId()) {
      $query = 'DELETE FROM '.cms_db_prefix().self::DB_NAME .' WHERE id = ?';
      $this->query($query, array($this->id));
      if(class_exists('MX_RelationLink'))  {
        MX_RelationLink::cleanRelatedItems(self::MODULE_NAME, $this->getId());
      }
    }
    // DELETE ALL RELATED DOCUMENTS
                            cms_utils::get_module(self::MODULE_NAME)->deindex($this);
    return true;
  }

  protected function insert($params = array()) {
    $db = cms_utils::get_db();

    if($this->getId() == null)  $this->setId($db->GenID(cms_db_prefix(). self::DB_NAME . '_seq'));

    $query = 'SELECT MAX(order_by) + 1 AS order_by FROM '.cms_db_prefix().self::DB_NAME;
    $values = array();
    if ($this->parent_item) {
      $query .= ' WHERE parent_item = ?';
      $values[] = $this->parent_item;
    } elseif ($this->parent_id > 0) {
      $query .= ' WHERE parent_id = ?';
      $values[] = $this->parent_id;
		} else {
			$query .= ' WHERE parent_id = 0 OR parent_id IS NULL';
		}
		$result = $db->execute($query, $values);
		if(!$result) return false;
    $row = $result->FetchRow();
    $order_by = $row['order_by'] ? $row['order_by'] : 1;
    if(isset($params['frontend']))
    {
      $userid = null;
    }
    else
    {
      $userid = get_userid();
    }
    $query = 'INSERT INTO '.cms_db_prefix().self::DB_NAME . '
      SET id = ?,
        user_id = ?,
        parent_id = ?,
        title = ?,
                pole1 = ?,
                pole2 = ?,
                created_by = ?,
        created_at = NOW(),
        mcfi_created_timestamp = ?,
        updated_by = ?,
        updated_at = NOW(),
        mcfi_updated_timestamp = ?,
        order_by = ?,
        parent_item = ?,
        published = ?,
        send_update_immediately = ?,
        full_text_search = ?';
    $db->Execute($query, array(
        $this->id,
        $this->user_id,
      $this->parent_id,
      $this->title,
            $this->pole1,
            $this->pole2,
            $userid,
      time(),
      $userid,
      time(),
      $order_by,
      $this->parent_item,
      $this->published,
      $this->send_update_immediately,
      $this->full_text_search()
    ));
    cms_utils::get_module(self::MODULE_NAME)->SendEvent('ContentEditPost', array());
    return true;
  }

  protected function update($params = array()) {
    $db = cms_utils::get_db();
    if(isset($params['frontend']))
    {
      $userid = null;
    }
    else
    {
      $userid = get_userid();
    }
    $query = 'UPDATE '.cms_db_prefix().self::DB_NAME. '
      SET 
        user_id = ?,
        parent_id = ?,
        title = ?,
                pole1 = ?,
                pole2 = ?,
                updated_by = ?,
        updated_at = NOW(),
        mcfi_updated_timestamp = ?,
        order_by = ?,
        parent_item = ?,
        published = ?,
        send_update_immediately = ?,
        full_text_search = ?
      WHERE id = ?';
    $db->Execute($query, array(
      $this->user_id,
      $this->parent_id,
      $this->title,
            $this->pole1,
            $this->pole2,
            $userid,
      time(),
      $this->order_by,
      $this->parent_item,
      $this->published,
      $this->send_update_immediately,
      $this->full_text_search(),
      $this->id
    ));
    cms_utils::get_module(self::MODULE_NAME)->SendEvent('ContentEditPost',array());
    return true;
  }
  
  public static function updateObjects()  {
    $c = new MCFCriteria();
    $objects = self::doSelect($c);
    foreach($objects as $object)
    {
      $object->is_modified = true;
      $object->save();
    }
  }
  
  public function forceUpdateObject($magic)  {
    if ($magic = 'magic')
    {
      $this->is_modified = true;
      $this->save();
    }
  }

  /**   @deprecated */

  public static function retrieveContextId()
  {
      return MCFTools::retrieveContextId();
  }
  
  // FILTERS
  
  public static function buildFiltersWidgets(CMSForm &$form, $filters)  {
                            
    
      }
  
  public static function buildFiltersCriteria(MCFCriteria &$c, $filters)  {
                              }
  
  // FRONTEND WIDGETS
  
  
  public static function getFEFilter(&$form, $filter, $options = array())  {
    switch($filter)
    {
          default:
        break;
    }
  }

  // Executed before the save action is fired
  public function preSave()  {

  }
  
  // Executed after the sace action is fired
  public function postSave()
  {
    if($this->published && $this->send_update_immediately)
    {
      if($digest = cms_utils::get_module('Digest'))
      {
        if(method_exists($digest, 'sendUpdateImmediately'))
        {
          $result = $digest->sendUpdateImmediately(self::MODULE_NAME);
        }
      }
    }
  }

  // TODO: MOVE THE TWO FUNCTIONS
  
  public function getUpdateSubject()
  {
    return $this->title;
  }
  
  public function getUpdateBody()
  {
    $module = cms_utils::get_module(self::MODULE_NAME);
    $module->smarty->assign('item', $this);
    return $module->ProcessTemplateFor('direct_email', array());
  }

  // Executed in the edit action when everything went fine (Executed after item save though)
  public function postActions()  {

  }
  
  // Allow you to restrict the frontend list and details with required filters
  public static function globalFrontendFilters(MCFCriteria &$c, $params = array())  {

  }
  
  public static function buildFrontendFilters(MCFCriteria &$c, $params)  {
    // Module Xtender filters
    if (isset($params['currentpage']) && class_exists('MX_RelationLink')) {
      $c->add('id', MX_RelationLink::getRelatedItemsIds(self::MODULE_NAME, cms_utils::get_current_pageid(), 'pages'), MCFCriteria::IN);
    }
    if (isset($params['pages']) && class_exists('MX_RelationLink')) {
      $glue = isset($params['all_pages']) ? 'AND' : 'OR';
      $c->add('id', MX_RelationLink::getRelatedItemsIds(self::MODULE_NAME, explode(',', $params['pages']), 'pages', $glue), MCFCriteria::IN);
    }
    if (isset($params['options']) && class_exists('MX_RelationLink')) {
      $glue = isset($params['all_options']) ? 'AND' : 'OR';
      $c->add('id', MX_RelationLink::getRelatedItemsIds(self::MODULE_NAME, explode(',', $params['options']), 'options', $glue), MCFCriteria::IN);
    }

    if (isset($params['mxfilters_options']) && is_array($params['mxfilters_options'])) {
      $options = array();
      foreach ($params['mxfilters_options'] as $option) {
        if ($option) {
          $options[] = $option;
        }
      }
      if (count($options)  && class_exists('MX_RelationLink')) {
        $c->add('id', MX_RelationLink::getRelatedItemsIds(self::MODULE_NAME, $options, 'options', 'AND'), MCFCriteria::IN);
      }
    }

    if (isset($params['mxfilters_pages']) && is_array($params['mxfilters_pages'])) {
      $pages = array();
      foreach ($params['mxfilters_pages'] as $page) {
        if ($page) {
          $pages[] = $page;
        }
      }
      if (count($pages)  && class_exists('MX_RelationLink')) {
        $c->add('id', MX_RelationLink::getRelatedItemsIds(self::MODULE_NAME, $pages, 'pages', 'AND'), MCFCriteria::IN);
      }
    }

    // SEARCH

    if (isset($params['filter_title'])) {
      $filter_title = trim(html_entity_decode($params['filter_title']));
      $filter_title = str_replace(array('%', '?'), ' ', $filter_title);
      if (!empty($filter_title)) {
        preg_match_all('/(?:"([^"]+)")|(\w+)/', $filter_title, $matches);
        $clauses = array();
        foreach ($matches[0] as $key => $value) {
          $clauses[$key] = $matches[1][$key] ? $matches[1][$key] : $matches[2][$key];
        }
        foreach ($clauses as $clause) {
          $c->add('title', '%' . $clause . '%', MCFCriteria::LIKE);
        }
      }
    }

    if (isset($params['filter_all'])) {
      $filter_all = trim(html_entity_decode($params['filter_all']));
      $filter_all = str_replace(array('%', '?'), ' ', $filter_all);
      if (!empty($filter_all)) {
        preg_match_all('/(?:"([^"]+)")|(\w+)/', $filter_all, $matches);
        $clauses = array();
        foreach ($matches[0] as $key => $value) {
          $clauses[$key] = $matches[1][$key] ? $matches[1][$key] : $matches[2][$key];
        }
        foreach ($clauses as $clause) {
          $c->add('full_text_search', '%' . $clause . '%', MCFCriteria::LIKE);
        }
      }
    }

    // Module Filters

    
  }

  public static function cleanFilterValue($name, $value)
  {
    $value = htmlentities($value);
    switch($name)
    {
            default:
        break;
    }
    
    return $value;
  }

  // Frontend events
  
  public function event($event)
  {
    // This allows you to track events from specific actions
    return null;
  }
  
  public static function events($event, $items)
  {
    // This allows you to track events from specific actions
    return null;
  }
  
  
  // FRONTEND FORMS : CHECK PERMISSIONS
  
  public static function checkPermissions($params = array())  {
    return true; // Can be overide in the custom logic
  }
  
  public function isUserItem()  {
    $user = CMSUsers::getUser();
    if (is_object($user))
    {
      if ($user->getId() == $item->geUserId())
      {
        return true;
      }
    }
    return false;
  }
  
  // Executed in the user_form action when everything went fine
  public function userPostActions($id, $returnid,$form = null)  {
    $this->postActions();
  }
}

?>
