<?php
/*
 *  Core functions contains all the functions needed by FormBrowser
 * 
 * Refactorised by Jean-Christophe Cuvelier on Feb 26, 2009
 * 
 */

if (!function_exists('GetFormIdFromName'))
{
	function GetFormIdFromName( $name='' )
	{
	 $result = false;
	 if($name != '')
	 {
	  global $gCms;
	  $db =& $gCms->GetDb();
	  $sql = "SELECT form_id FROM ".cms_db_prefix()."module_fbr_browser WHERE name = ? or alias=?";
	  $rs = $db->Execute($sql, array($name,$name));
	  if($rs && $rs->RecordCount() > 0)
	    {
	    $result = $rs->Fields('form_id');
	    }
	 }
	 return $result;
	}
}

if (!function_exists('GetFieldId'))
{
	function GetFieldId( $form_id='', $name='' )
	{
	 $result = false;
	 if( ($form_id != '') && ($name != '') )
	 {
	  global $gCms;
	  $db =& $gCms->GetDb();
	  $sql = "SELECT field_id FROM ".cms_db_prefix()."module_fb_field WHERE (form_id = ?) AND (name = ?)";
	  $rs = $db->Execute($sql, array($form_id, $name));
	  if($rs && $rs->RecordCount() > 0) $result = $rs->Fields('field_id');
	 }
	 return $result;
	}
}

if (!function_exists('GetRespId'))
{
	function GetRespId( $arr_field_val )
	{
	 $result = false;
	 if(! empty($arr_field_val))
	 {
	  $arr = array();
	  $q = '';
	  foreach($arr_field_val as $field=>$val)
	  {
	   $q .= " ( value LIKE CONCAT('%', ? ,'%') AND (field_id = ?) ) OR";
	   $arr[] = $val['value'];
	   $arr[] = $val['id'];
	  }
	  $q = substr($q, 0, -2);
	  global $gCms;
	  $db =& $gCms->GetDb();
	  $sql = "SELECT DISTINCT resp_id FROM ".cms_db_prefix()."module_fb_resp_val WHERE $q";
	  $rs = $db->Execute($sql, $arr);
	  while( ($rs && $rs->RecordCount() > 0) && ($row = $rs->FetchRow()) )
	  {
	   $result[] = $row['resp_id'];
	  }
	 }
	 return $result;
	}
}
?>