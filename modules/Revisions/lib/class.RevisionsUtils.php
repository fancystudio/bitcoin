<?php
#-------------------------------------------------------------------------
#
# Author: Jonathan Schmid, <hi@jonathanschmid.de>
# Web: www.jonathanschmid.de
#
#-------------------------------------------------------------------------
#
# Revisions is a CMS Made Simple module that logs changes in content, CSS,
# GCBs and enables the web developer to revert to earlier versions of it. 
#
#-------------------------------------------------------------------------

class RevisionsUtils {

	protected function __construct() {}

	static final public function &array_to_object($array)
	{
		$obj = new StdClass();
		foreach($array as $key=>$value) {
		
			$obj->$key = $value;
		}
		
		return $obj;
	}

	static final public function array_insert(&$src, $pos, $ins, $rep=0)
	{ 
		array_splice($src, $pos, $rep, $ins); 
		return true;
	}

	static final public function CreateInputNumber($id, $name, $value='', $addttext='')
	{
		$value = cms_htmlentities($value);
		$id = cms_htmlentities($id);
		$name = cms_htmlentities($name);

		$value = str_replace('"', '&quot;', $value);

		$text = '<input type="number" class="cms_numberfield" name="'.$id.$name.'" id="'.$id.$name.'" value="'.$value.'"';
		if ($addttext != '')
		{
			$text .= ' ' . $addttext;
		}
		$text .= " />\n";
		return $text;
	}
}

?>