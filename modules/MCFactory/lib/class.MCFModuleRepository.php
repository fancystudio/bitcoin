<?php

// Contain global MCFModule actions

class MCFModuleRepository
{
	public static function doSelect(MCFCriteria $c) {
		$db = cms_utils::get_db();
		$query = $c->buildQuery(cms_db_prefix().'module_mcfactory_modules');
		$result = $db->execute($query, $c->values);
		$modules = array();
		while ($result && ($row = $result->FetchRow())) {
			$module = new MCFModule();
			$row['extra_fields'] = unserialize($row['extra_fields']);
			$row['structure'] = unserialize($row['structure']);
			$row['filters'] = unserialize($row['filters']);
			$row['extra_features'] = unserialize($row['extra_features']);
			$module->populateFromArray($row, false);
		    $modules[] = $module;
		}
		return $modules;
	}

    /**
     * @param MCFCriteria $c
     * @return MCFModule
     */
    public static function doSelectOne(MCFCriteria $c) {
		
		$c->setLimit(1);
		$result = self::doSelect($c);

		if (count($result) > 0) {
			reset($result);
			return current($result);
		} else {
			return null;
		}
	}
	
	public static function retrieveByPk($pk) {
		$c = new MCFCriteria();
		$c->add('id', $pk);
		return self::doSelectOne($c);
	}

	public static function retrieveByName($name) {
		$c = new MCFCriteria();
		$c->add('module_name', $name);
		return self::doSelectOne($c);
	}

	
	public static function getModulesWithFieldTypes(Array $field_types)
	{		
		$c = new MCFCriteria();
		$modules = self::doSelect($c);
		
		$filtered_modules  = array();
		
		foreach($modules as $module)
		{
			if($module->hasFieldWithTypes($field_types))
			{
				$filtered_modules[] = $module;
			}
		}
		
		return $filtered_modules;
	}
}