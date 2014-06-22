<?php

class {{$module->getModuleName()}}ObjectPeer {

    public static function doSelect(MCFCriteria $c = null) {
		$db = cms_utils::get_db();
		$c = clone $c;
		$query = $c->buildQuery(cms_db_prefix() . 'module_{{$table_name}}');
		$result = $db->execute($query, $c->values);
		$objects = array();
		while ($result && $row = $result->FetchRow()) {
			$object = new self();
			$object->populateFromArray($row);
			$object->is_modified = false;
			$objects[] = $object;
		}
		return $objects;
    }

    public static function doSelectOne(MCFCriteria $c = null) {
        
    }

}

?>