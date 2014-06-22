<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

// handle human readable fields
if (isset($params['browser']) && ! isset($params['fbrp_browser_alias']))
	{
	$params['fbrp_browser_alias']=$params['browser'];
	$params['fbrp_load']=true;
	}

// Some required functions
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'core.functions.php');

if(isset($params['fbrp_searchfield']))
{
 $fbrp_arr_getfield = array();
 $fbrp_arr_searchfield = explode(',', $params['fbrp_searchfield']);
 $this->smarty->assign_by_ref('fbrp_arr_searchfield', $fbrp_arr_searchfield);

 $this->smarty->assign('fbrp_startfbrsearchform', $this->CreateFormStart($id, 'default', $returnid, 'get', '', true));
 $_submit = (isset($params['fbrp_searchsubmit'])) ? $params['fbrp_searchsubmit'] : $this->Lang('fbrp_searchsubmit');
 $this->smarty->assign('submitbutton', $this->CreateInputSubmit($id, 'fbrp_searchsubmit', $_submit));
 $this->smarty->assign('fbrp_endfbrsearchform', $this->CreateFormEnd());
 
 $fb_form_id = GetFormIdFromName($params['browser']);
 if($fb_form_id !== false)
 {
  foreach($fbrp_arr_searchfield as $_field)
  {
   if( (! empty($_GET[$_field])) && (empty($params[$_field])) )
		{
		$params[$_field] = $_GET[$_field];	
		}
   if(! empty($params[$_field]))
   {
    $fb_field_id = GetFieldId($fb_form_id, $_field);
    if($fb_field_id !== false)
		{
		$fbrp_arr_getfield[$_field] = array('id'=>$fb_field_id, 'value'=>htmlspecialchars($params[$_field]));
		}
   }
   $params['fbrp_arr_getfield']= $fbrp_arr_getfield;
   $this->smarty->assign_by_ref('fbrp_arr_getfield', $fbrp_arr_getfield);
  }
 }

 $fbrp_response_search = GetRespId($fbrp_arr_getfield);
 $params['fbrp_response_search']= $fbrp_response_search;
}


if (isset($params['sort_field']) && ! isset($params['fbrp_sort_field']))
	{
	$params['fbrp_sort_field'] = $params['sort_field'];
	}
if (isset($params['sort_dir']) && ! isset($params['fbrp_sort_dir']))
	{
	$params['fbrp_sort_dir'] = $params['sort_dir'];
	}

$br = new fbrBrowser($this, $params, true);

$br->BrowserShowList($id,$returnid,$this,$params,'list_fields');
$this->smarty->assign('in_admin',0);
$this->smarty->assign('in_formbrowser',1);

echo $this->ProcessTemplateFromDatabase('fbr_ulist_'.$br->GetId());
?>
