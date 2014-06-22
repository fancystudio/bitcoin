<?php

/**
 * MCFModuleAction Class
 * 
 * This class handle all the manipulations on the M&C Factory Module action object
 * 
 */

class MCFModuleAction //extends	CmsObject 
{
	
	protected $id;	
	protected $is_modified;	
	protected $vars = array();
	
	protected static $fields = array(
	'name',
	'module_id',
	'code',	
	'is_public',
	'have_permission',
	'button_name',
	'button'
	);
	
	public static $button_places = array(
    'options_top' => 'In the options tab on the top',
    'options_bottom' => 'In the options tab on the bottom',
    'items_top' => 'In the items tab on the top',
    'items_bottom' => 'In the items tab on the bottom',
    'filters' => 'Near the filters'
	);
	
	// TODO: Throw a warning error when user try to use that
	public static $forbiden_names = array(
		'assigntitles','count','default','defaultadmin','delete','deletetemplate','detail','edit','edittemplate',
		'export','geturl','ical','calendar','link_to','movedown','moveup','publish','rss','search','tagcloud',
		'template','template_delete','template_edit','updateObjects','url_for','user_form','user','file','img'
	);
	
	const DB_NAME = 'module_mcfactory_module_actions';
	const DB_ITEM = 'module_action';
		
	public function __toString()
	{
		try
		{
			return (string)	$this->name;
		}
		catch(Exception $e)
		{
			print($e);
            return null;
		}
	}
	
	public function __set($var, $val){
      $this->vars[$var] = $val;
			$this->is_modified = true;
  }

  public function __get($var){
		$method = 'get_'.$var;
		if(method_exists($this, $method))
		{
			return $this->$method();
		}
    elseif (array_key_exists($var, $this->vars))
		{
      return $this->vars[$var];
    } 
		else
		{
    	return null;
			//throw new Exception("Property $var does not exist");
    }
  }

	public function __clone()
	{
		$this->id = null;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function checkName()
	{
		if (in_array($this->name, self::$forbiden_names)) {
				return false; // Meaning you CAN'T use this name
		}
		
		$currents = self::doSelect(array('where' => array('name' => $this->name, 'module_id' => $this->module_id)));
		if (count($currents) > 1)
		{
			return false;
		}
		elseif(count($currents) < 1)
		{
			return true;
		}
		else
		{
			if ($currents[0]->getId() == $this->getId())
			{
				return true; // No duplicate, but it's the same
			}
			return false;
		}
	}
	
	public function getCleanCode()
	{
	  if(strpos($this->code, '<?php') === 0)
	  {
	    return '?>'.$this->code;
	  }
	  else
	  {
	    return $this->code;
	  }
	}
	
	public function cleanupName()
	{
		$this->name = preg_replace('/\W/', '', strtolower($this->name));
		if (!$this->checkName())
		{
			// In this case, we should change the name
			$name = $this->name;
			$i = 1;
			$this->name = $name.$i;
			while(!$this->checkName())
			{
				$i++;
				$this->name = $name.$i;
			}
		}
		return $this->name;
	}
	
	// DATABASE SPECIFIC
	//------------------
		
	public static function retrieveByPk($id)
  {
  	return self::doSelectOne(array('where' => array('id' => $id)));    
  }

  public static function doSelectOne($params = array())
  {
  	$items = self::doSelect($params);
  	if ($items)
  	{
  		return $items[0];
  	}
  	else 
  	{
  		return null;
  	}  	
 	}
		
	public function populate($row)
	{
		if (isset($row[self::DB_ITEM.'__id']))
		{
			$this->id = $row[self::DB_ITEM.'__id'];
		}		
		
		foreach (self::$fields as $field)
		{
			if (isset($row[self::DB_ITEM.'__'.$field]))
			{
				$this->$field = $row[self::DB_ITEM.'__'.$field];
			}
		}	
	}
	
	public static function generateSelectList()
	{
		$fields = array_merge(array('id','created_at','updated_at'), self::$fields);
		$list = array();
		foreach ($fields as $field)
		{
			$list[] = self::DB_ITEM . '.'.$field.' as '. self::getRowName($field);
		}
		return implode(' , ',$list);
	}

  public static function getRowName($name)
	{
		return self::DB_ITEM . '__' . $name;
	}


  public static function doSelect($params = array())
  {
    // $instance = new self();
    //     $db =& $instance->GetDb();
		$db = cms_utils::get_db();
		
    $query = 'SELECT 
		'.self::DB_ITEM.'.*,
		'.self::generateSelectList() . '
		FROM ' . cms_db_prefix() . self::DB_NAME . ' AS ' . self::DB_ITEM;

    $values = array();

    if (isset($params['where']))
    {

      $fields = array();
      foreach ($params['where'] as $field => $value) 
      {
        $fields[] = self::DB_ITEM.'.'.$field . ' =  ?';
        $values[] = $value;
      }

      $query .= ' WHERE ' . implode(' AND ', $fields);
    } 

    if(isset($params['order_by']))
    {
     $query .= ' ORDER BY ' . implode(', ' , $params['order_by']);
    }
    else
    {
      $query .= ' ORDER BY '.self::DB_ITEM.'.created_at';
    }

    $dbresult = $db->Execute($query, $values);
    $items = array();

   if ($dbresult && $dbresult->RecordCount() > 0)
    {
      while ($dbresult && $row = $dbresult->FetchRow())
      {	
        $item = new MCFModuleAction();
        $item->populate($row);
        $items[] = $item;
      }
    }
    return  $items;   
  }
  
	
	public function save() {
		if ($this->getId()) 
		{
			if ($this->is_modified)
			{			
				return $this->update();	
			}
		} 
		else
		{
			return $this->insert();
		}
		
		return false;
	}

	protected function insert() {
		// Cleanup name
		$this->cleanupName();
		//
    //$db =& $this->GetDb();
		$db = cms_utils::get_db();
		$query = 'INSERT INTO '.cms_db_prefix(). self::DB_NAME . ' SET created_at = NOW(),	updated_at = NOW() ';
		$values = array();				
		foreach(self::$fields as $field)
		{
			$query .= ', ' . $field . ' = ?';
			$values[] = $this->$field;
		}
																
		$result = $db->Execute($query,$values);
		if ($result === false) return false;
		$this->id = $db->Insert_ID();
		//cms_utils::get_module('Projects')->SendEvent('ContentEditPost', array());
		return true;
	}

	protected function update() {
    //$db =& $this->GetDb();
		$db = cms_utils::get_db();
		$query = 'UPDATE '.cms_db_prefix(). self::DB_NAME . '	SET updated_at = NOW()';			
		$values = array();				
		foreach(self::$fields as $field)
		{
			$query .= ', ' . $field . ' = ?';
			$values[] = $this->$field;
		}	
		$query .= ' WHERE id = ?';
		$values[] = $this->getId();
		$result = $db->Execute($query, $values);
		if ($result === false) return false;
		//cms_utils::get_module('Projects')->SendEvent('ContentEditPost',array());
		return true;
	}
	
	public function delete() {
		if ($this->getId()) {
    	// $db =& $this->GetDb();
			$db = cms_utils::get_db();
			$query = 'DELETE FROM '.cms_db_prefix().self::DB_NAME . ' WHERE id = ?';
			$result = $db->Execute($query, array($this->getId()));
			if($result !== false)
			{
				return true;
			} 
		}
		return false;
	}
	
	public static function sortByPlace($actions)
	{
	  $places = array();
	  foreach($actions as $action)
	  {	    
	    if(isset(self::$button_places[$action->button]))
	    {
	      $places[$action->button][] = $action;
	    }
	  }
	  return $places;
	}
	
}