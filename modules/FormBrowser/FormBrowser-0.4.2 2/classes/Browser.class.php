<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbrBrowser {

	var $module_ptr = -1;
    var $Id = -1;
    var $FormId=-1;
    var $Name = '';
    var $Alias = '';
    var $loaded = 'not';
    var $Attrs;
	var $Page;
	var $totalPages;
	var $listFields;
	var $fullFields;
	var $adminListFields;
	var $adminFullFields;

	function fbrBrowser(&$module_ptr, &$params, $loadDeep=false)
	{
	   $this->module_ptr = &$module_ptr;
	   $this->Attrs = array();
	   $this->listFields = array();
	   $this->fullFields = array();
	   $this->adminListFields = array();
	   $this->adminFullFields = array();

	   if (isset($params['browser_id']))
	       {
	       $this->Id = $params['browser_id'];
	       }
	   if (isset($params['form_id']))
	       {
	       $this->FormId = $params['form_id'];
	       }
	   if (isset($params['fbrp_browser_alias']))
	       {
	       $this->Alias = $params['fbrp_browser_alias'];
	       }
	   if (isset($params['fbrp_browser_name']))
	       {
	       $this->Name = $params['fbrp_browser_name'];
	       }
	   if (isset($params['fbrp_page']))
	       {
	       $this->Page = $params['fbrp_page'];
	       }
	   else
	   	  {
	   	  $this->Page = 1;
	   	  }
	   
	   if ($this->Id != -1)
	   		{
	   		$this->Load('id',$this->Id, $params, $loadDeep);
	   		}
	   	elseif (isset($params['fbrp_load']) && $params['fbrp_load'])
	   		{
	   		$this->Load('alias',$this->Alias, $params, $loadDeep);
	   		}
	   	foreach ($params as $thisParamKey=>$thisParamVal)
	   		{
	   		if (substr($thisParamKey,0,16) == 'fbrp_list_field_')
	   			{
	   			$this->listFields[substr($thisParamKey,16)] = $thisParamVal;
	   			}
	   		elseif (substr($thisParamKey,0,16) == 'fbrp_full_field_')
	   			{
	   			$this->fullFields[substr($thisParamKey,16)] = $thisParamVal;
	   			}
	   		elseif (substr($thisParamKey,0,22) == 'fbrp_admin_list_field_')
	   			{
	   			$this->adminListFields[substr($thisParamKey,22)] = $thisParamVal;
	   			}
	   		elseif (substr($thisParamKey,0,22) == 'fbrp_admin_full_field_')
	   			{
	   			$this->adminFullFields[substr($thisParamKey,22)] = $thisParamVal;
	   			}	
	   		elseif (substr($thisParamKey,0,14) == 'fbrp_browsera_')
	   			{
	   			$thisParamKey = substr($thisParamKey,14);
	   			$this->Attrs[$thisParamKey] = $thisParamVal;
	   		/*	if ($thisParamKey == 'fbrp_browsera_full_list_template' && $this->Id != -1)
	   				{
	   				$this->module_ptr->SetTemplate('fbr_l_'.$this->Id,$thisParamVal);
	   				}
	   			elseif ($thisParamKey == 'fbrp_browsera_full_template' && $this->Id != -1)
	   				{
	   				$this->module_ptr->SetTemplate('fbr_f_'.$this->Id,$thisParamVal);
	   				}
			*/
	   			}
				
	   		}
	}

	function SetAttributes($attrArray)
	{
		$this->Attrs = array_merge($this->Attrs,$attrArray);
	}

	function SetTemplate($template)
	{
		$this->Attrs['browser_template'] = $template;
		$this->module_ptr->SetTemplate('fbr_'.$this->Id,$template);
	}

	function GetId()
	{
		return $this->Id;
	}

	function GetFormId()
	{
		return $this->FormId;
	}


	function SetId($id)
	{
		$this->Id = $id;
	}

	function GetName()
	{
		return $this->Name;
	}
	
	function GetPageNumber()
	{
		return $this->Page;
	}

	function PageBack()
	{
		$this->Page--;
	}

	function SetName($name)
	{
		$this->Name = $name;
	}
	
	function GetAlias()
	{
		return $this->Alias;
	}

	function SetAlias($alias)
	{
		$this->Alias = $alias;
	}

	function DebugDisplay()
	{
	$tmp = $this->module_ptr;
		$this->module_ptr = '';
		$template_full_tmp = $this->GetAttr('full_template','');
		$template_list_tmp = $this->GetAttr('list_template','');
		$this->SetAttr('list_template',strlen($template_list_tmp).' characters');
		$this->SetAttr('full_template',strlen($template_full_tmp).' characters');
		debug_display($this);
		$this->SetAttr('full_template',$template_full_tmp);
		$this->SetAttr('list_template',$template_list_tmp);
		$this->module_ptr = $tmp;
	}

	
	function SetAttr($attrname, $val)
	{
		$this->Attrs[$attrname] = $val;
	}
	
	function GetAttr($attrname, $default="")
	{
		if (isset($this->Attrs[$attrname]))
			{
			return $this->Attrs[$attrname];
			}
		else
			{
			return $default;
			}
	}
	

    function RenderBrowserHeader()
    {
    	if ($this->module_ptr->GetPreference('show_version',0) == 1)
    	   {
    	   return "\n<!-- Start FormBrowser Module (".$this->module_ptr->GetVersion().") -->\n";
    	   }
    }

    function RenderBrowserFooter()
    {
    	if ($this->module_ptr->GetPreference('show_version',0) == 1)
    	   {
    	   return "\n<!-- End FormBrowser Module -->\n";
    	   }
    }

    function FieldOrderList($attrname)
    {
    	$ret = array();
    	$lst = explode(':',$this->GetAttr($attrname));
    	foreach ($lst as $thisElem)
    		{
    		$shrt = explode(',',$thisElem);
    		$ret[$shrt[0]] = $shrt[1];
    		}
    	return $ret;
    }

	function DeleteResponse(&$params)
	{
		global $gCms;
		$db = $gCms->GetDb();
		
		if (!is_array($params['response_id'])) {
		
			$params['response_id'] = array($params['response_id']);
		}
		
		$module = 'FormBrowser';
		$items = implode(',', $params['response_id']);
		$attr = 'sub_'.$this->Id;
		
		// Delete responses
		$sql = 'DELETE FROM ' . cms_db_prefix().'module_fb_formbrowser 
					   WHERE fbr_id IN ('.$items.')';
		$db->Execute($sql);
		
		if ($gCms->modules['Search']['installed'] == true && $gCms->modules['Search']['active'] == true) {
		
			// Delete responses from search items
			$sql = 'DELETE FROM '.cms_db_prefix().'module_search_items 
						   WHERE module_name=? 
						   AND content_id IN ('.$items.')
						   AND extra_attr=?';
			$db->Execute($sql, array($module, $attr));
			
			// Delete responses from search index
			$sql = 'DELETE FROM '.cms_db_prefix().'module_search_index 
						   WHERE item_id NOT IN (SELECT id FROM '.cms_db_prefix().'module_search_items)';
			$db->Execute($sql);
			@$this->module_ptr->SendEvent('SearchItemDeleted', array($module, $items, $attr));
		}

	}

    function LoadResponse($id,&$mod_ptr, &$params, $which_list='full_fields', $adminside=false)
    {
		global $gCms;
		// load this form
		$fb = $mod_ptr->GetModuleInstance('FormBuilder');
		$flds = $this->FieldOrderList($which_list);

		$fbf = $fb->GetFormBrowserField($this->FormId);

		if ($fbf != false)
			{
			// if we're binding to FEU, get the FEU ID, see if there's a response for
			// that user. If so, load it. Otherwise, bring up an empty form.
			if ($fbf->GetOption('feu_bind','0')=='1')
				{
				$db = $gCms->GetDb();
				$feu = $mod_ptr->GetModuleInstance('FrontEndUsers');
				if ($feu == false)
					{
					debug_display("FAILED to instatiate FEU!");
					return;
					}
            if ($adminside)
               {
               $response_id = isset($params['response_id'])?$params['response_id']:'-1';
               }
            else
               {
   				$response_id = $fb->GetResponseIDFromFEUID($feu->LoggedInId());
   				if ($response_id !== false)
   					{
   					$response_id = $feu->LoggedInId();
   					$check = $db->GetOne('select count(*) from '.cms_db_prefix().
   						'module_fb_formbrowser where fbr_id=?',array($response_id));
   					if ($check == 1)
   						{
   						$params['response_id'] = $response_id;
   						}
   					else
   						{
   						$params['response_id'] = -1;
   						}
   					}
					}
				}
			}
		if ($params['response_id'] == -1)
			{
			$response = new StdClass;
			$response->values = array();
			$response->names = array();
			$response->fieldsbyalias = array();
			}
		else
			{
			$response = $fb->GetResponse($this->FormId,$params['response_id'], $flds, $mod_ptr->GetPreference('date_format','d F y'));
			}
		$reqAdminApproval = $this->GetAttr('require_admin_approval','0')=='0'?false:true;
		$reqUserApproval = $this->GetAttr('require_user_approval','0')=='0'?false:true;
		$mod_ptr->smarty->assign('adminapproval',$reqAdminApproval?1:0);
		$mod_ptr->smarty->assign('userapproval',$reqUserApproval?1:0);
		$mod_ptr->smarty->assign('title_submit_date',$mod_ptr->Lang('title_submit_date'));
		$mod_ptr->smarty->assign('title_approval_date',$mod_ptr->Lang('title_approval_date'));
		$mod_ptr->smarty->assign('title_user_approved',$mod_ptr->Lang('title_user_approved'));
		$mod_ptr->smarty->assign('resp',$response);
		$mod_ptr->smarty->assign('count',count($response->names));
		$mod_ptr->smarty->assign('browser_title',$this->GetName());
		$mod_ptr->smarty->assign('fbrp_message','');
		foreach ($response->names as $id=>$name)
			{
			$obj = new stdClass();
			$obj->input = $response->values[$id];
			$obj->value = $response->values[$id];
			$tname = $this->MakeVar($name);
			$mod_ptr->smarty->assign($tname,$obj);
 			$mod_ptr->smarty->assign($name,$obj);
			$mod_ptr->smarty->assign('fld_'.$id,$obj);
			}
		return $response;
    }   

  function MakeVar($string)
  {
    $maxvarlen = 24;
    $string = strtolower(preg_replace('/\s+/','_',$string));
    $string = strtolower(preg_replace('/\W/','_',$string));
    if (strlen($string) > $maxvarlen)
      {
	$string = substr($string,0,$maxvarlen);
	$pos = strrpos($string,'_');
	if ($pos !== false)
	  {
	    $string = substr($string,0,$pos);
	  }
      }
    return $string;
  }


	function ApproveResponse(&$params)
	{
		global $gCms;
		$db = $gCms->GetDb();
		if ($params['fbrp_apr'] == 1)
			{
			$res = $db->Execute( 'UPDATE '.cms_db_prefix().'module_fb_formbrowser SET admin_approved=? where fbr_id=? and form_id=?',
					array(($params['fbrp_apr']==1?$this->clean_datetime($db->DBTimeStamp(time())):'0'),
						$params['response_id'],$params['form_id']));
			}
		elseif($params['fbrp_apr'] == 0)
			{
			$res = $db->Execute( 'UPDATE '.cms_db_prefix().'module_fb_formbrowser SET admin_approved=NULL where fbr_id=? and form_id=?',array($params['response_id'],$params['form_id']));
			}
	}

	function BrowserShowList($id, $returnid, &$mod_ptr,&$params, $which_list='list_fields', $adminside=false)
	{
		global $gCms;
		$count = 0;
		
		if ($which_list == 'admin_list_fields' && $this->GetAttr('browser_type') == 'advanced')
			{
			$flds = $this->FieldOrderList('admin_full_fields');
			}
		else if ($which_list == 'list_fields' && $this->GetAttr('browser_type') == 'advanced')
			{
			$flds = $this->FieldOrderList('full_fields');
			}
		else
			{
			$flds = $this->FieldOrderList($which_list);
			}

		$fb = $mod_ptr->GetModuleInstance('FormBuilder');
		$reqAdminApproval = $this->GetAttr('require_admin_approval','0')=='0'?false:true;
		$reqUserApproval = $this->GetAttr('require_user_approval','0')=='0'?false:true;
		$sortField = isset($params['fbrp_sort_field'])?$params['fbrp_sort_field']:'';
		if (empty($params['fbrp_sort_dir']))
			{
			$sortDir = 'd';
			$newSortDir = 'a';
			}
		if (isset($params['fbrp_sort_dir']) && $params['fbrp_sort_dir'] == 'a')
			{
			$sortDir = 'a';
			$newSortDir = 'd';
			}
		else
			{
			$sortDir = 'd';
			$newSortDir = 'a';	
			}
		
		$sortingnames = array();
		$sortableList = $fb->GetSortableFields($this->FormId);
		if ($adminside)
			{
			$perPage = $this->GetAttr('admin_rows_per_page','10');

			// we fetch all records for which admin needs access
			list($count,$names,$vals) = $fb->GetSortedResponses($this->FormId,(($this->Page - 1) * $perPage),
				$perPage, false, $reqUserApproval,$flds,$mod_ptr->GetPreference('date_format','d F y'),$params);
				
			// create sortable names
			foreach($names as $i=>$nval)
				{
				$fno = array_search($nval,$sortableList);
				if ($fno !== false)
					{
					$sortingnames[$i] = $mod_ptr->CreateLink($id,
						'admin_browse', '',
						$nval,
						array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,'fbrp_sort_field'=>$fno,
						'fbrp_sort_dir'=>$newSortDir));
					}
				else
					{
					$sortingnames[$i] = $nval;
					}
				}

			$mod_ptr->smarty->assign('title_sort_submit_date',$mod_ptr->CreateLink($id,
						'admin_browse', '',
						$mod_ptr->Lang('title_submit_date'),
						array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,'fbrp_sort_field'=>'submitdate',
						'fbrp_sort_dir'=>$newSortDir)));

			// we have a list of fields and their names, now we need to manipulate that according to our uses.
			for ($i=0;$i<count($vals);$i++)
				{
				if (! empty($vals[$i]->admin_approved))
					{
					$vals[$i]->admin_approval = $mod_ptr->CreateLink($id,
						'admin_approve_resp', '',
						$gCms->variables['admintheme']->DisplayImage('icons/system/true.gif',$mod_ptr->Lang('approved'),'','','systemicon'),
						array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_apr'=>0,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)).					
							$mod_ptr->CreateLink($id, 'admin_approve_resp', '', '('.$vals[$i]->admin_approved.')' , array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_apr'=>0,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir));
					}
				else
					{
					$vals[$i]->admin_approval = $mod_ptr->CreateLink($id, 'admin_approve_resp', '', $gCms->variables['admintheme']->DisplayImage('icons/system/false.gif','approve','','','systemicon'),
							array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_apr'=>1, 'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)).
								$mod_ptr->CreateLink($id, 'admin_approve_resp', '', $mod_ptr->Lang('unapproved') , array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_apr'=>1,'fbrp_page'=>$this->Page,
								'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir));
					}
					$vals[$i]->editlink = $mod_ptr->CreateLink($id,'admin_edit_resp', '',$gCms->variables['admintheme']->DisplayImage('icons/system/edit.gif',$mod_ptr->Lang('edit'),'','','systemicon'),
							array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page, 'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir));
					$vals[$i]->deletelink = $mod_ptr->CreateLink($id, 'admin_delete_resp', '', $gCms->variables['admintheme']->DisplayImage('icons/system/delete.gif',$mod_ptr->Lang('delete'),'','','systemicon'),
							array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page, 'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir), $mod_ptr->Lang('are_you_sure_delete_resp'));
					$vals[$i]->viewlink = $mod_ptr->CreateLink($id, 'admin_browse_resp', '', $gCms->variables['admintheme']->DisplayImage('icons/system/view.gif',$mod_ptr->Lang('view'),'','','systemicon'),
							array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page, 'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir));
					$vals[$i]->delbox = $mod_ptr->CreateInputCheckbox($id, 'response_id[]',$vals[$i]->id);
				}
			$mod_ptr->smarty->assign('addlink',$mod_ptr->CreateLink($id,
						'admin_edit_resp', '',
						$gCms->variables['admintheme']->DisplayImage('icons/system/newobject.gif',$mod_ptr->Lang('title_add_new_resp'),'',
						'','systemicon'),
						array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
			$mod_ptr->smarty->assign('addresp',$mod_ptr->CreateLink($id,
						'admin_edit_resp', '', $mod_ptr->Lang('title_add_new_resp'),
						array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_message'=>$mod_ptr->Lang('title_add_new_resp'),'fbrp_page'=>$this->Page,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
			}
		else
			{
			$perPage = $this->GetAttr('rows_per_page','10');

			list($count,$names,$vals) = $fb->GetSortedResponses($this->FormId,(($this->Page-1) * $perPage),
					$perPage, $reqAdminApproval, $reqUserApproval,$flds,$mod_ptr->GetPreference('date_format','d F y'), $params);

			// create sortable names
			foreach($names as $i=>$nval)
				{
				$fno = array_search($nval,$sortableList);
				if ($fno !== false)
					{
					$sortingnames[$i] = $mod_ptr->CreateFrontendLink($id,$returnid,
						'default',
						$nval,
						array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,'fbrp_sort_field'=>$fno,
						'fbrp_sort_dir'=>$newSortDir));
					}
				else
					{
					$sortingnames[$i] = $nval;
					}
				}

			$mod_ptr->smarty->assign('title_sort_submit_date', $mod_ptr->CreateFrontendLink($id,$returnid,
							'default',
							$mod_ptr->Lang('title_submit_date'),
							array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,'fbrp_sort_field'=>'submitdate',
							'fbrp_sort_dir'=>$newSortDir)));
			
// Start ALBY
$mod_ptr->smarty->assign('fbrp_searchcancel_url',$mod_ptr->CreateFrontendLink($id,$returnid,
 'default',
 $mod_ptr->Lang('fbrp_searchcancel'),
 array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'page'=>$this->Page), '', true));
$mod_ptr->smarty->assign('fbrp_searchcancel', $mod_ptr->Lang('fbrp_searchcancel'));
// End ALBY
			$allowUserAdd = $this->GetAttr('allow_user_add','0')=='0'?false:true;
			$allowUserEdit = $this->GetAttr('allow_user_edit','0')=='0'?false:true;
			$allowUserDelete = $this->GetAttr('allow_user_delete','0')=='0'?false:true;
			$mod_ptr->smarty->assign('allow_user_add',$allowUserAdd?1:0);
			$mod_ptr->smarty->assign('allow_user_edit',$allowUserEdit?1:0);
			$mod_ptr->smarty->assign('allow_user_delete',$allowUserDelete?1:0);

			for ($i=0;$i<count($vals);$i++)
				{
				$vals[$i]->editlink = $mod_ptr->CreateFrontendLink($id,$returnid,
						'user_edit_resp',
						'<img src="'.$gCms->config['root_url'].'/modules/FormBrowser/images/edit.gif" alt="'.$mod_ptr->Lang('edit').'" />',
						array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir));
				$vals[$i]->deletelink = $mod_ptr->CreateFrontendLink($id,$returnid,
						'user_delete_resp',
						'<img src="'.$gCms->config['root_url'].'/modules/FormBrowser/images/delete.gif" alt="'.$mod_ptr->Lang('delete').'" />',
						array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir),
						$mod_ptr->Lang('are_you_sure_delete_resp'));
				$vals[$i]->viewlink = $mod_ptr->CreateFrontendLink( $id, $returnid, 'user_browse_resp', '<img src="'.$gCms->config['root_url'].'/modules/FormBrowser/images/view.gif" alt="'.$mod_ptr->Lang('view').'" />', array('response_id'=>$vals[$i]->id,'form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page	,
						'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir), '', false, true, '', false, '' ); // replace last '' with prettyurl
				}
			$mod_ptr->smarty->assign('addlink',$mod_ptr->CreateFrontendLink($id,$returnid,
						'user_edit_resp',
						'<img src="'.$gCms->config['root_url'].'/modules/FormBrowser/images/newobject.gif" alt="'.$mod_ptr->Lang('title_add_new_resp').'" />',
						array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_page'=>$this->Page,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
			$mod_ptr->smarty->assign('addresp',$mod_ptr->CreateFrontendLink($id,$returnid,
						'user_edit_resp', $mod_ptr->Lang('title_add_new_resp'),
						array('form_id'=>$this->FormId,'browser_id'=>$this->Id,'fbrp_message'=>$mod_ptr->Lang('title_add_new_resp'),'fbrp_page'=>$this->Page,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
			}
		
		if ($count > $perPage)
			{
			$mod_ptr->smarty->assign('hasnav',1);
			$mod_ptr->smarty->assign('pageof',$mod_ptr->Lang('pageof',array($this->Page,ceil($count/$perPage))));
			$linkList = array();
			
			if ($adminside)
				{
				for ($i=1;$i<=ceil($count/$perPage);$i++)
					{
					array_push($linkList,$mod_ptr->CreateLink($id,
							'admin_browse', '',
							$i,
							array('fbrp_page'=>$i,'form_id'=>$this->FormId,'browser_id'=>$this->Id,
								'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
					}
				
				if ($this->Page > 1)
					{
					$mod_ptr->smarty->assign('prev',$mod_ptr->CreateLink($id,
						'admin_browse', '',
						$mod_ptr->Lang('previous'),
						array('fbrp_page'=>($this->Page - 1),'form_id'=>$this->FormId,'browser_id'=>$this->Id,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
					}
				else
					{
					$mod_ptr->smarty->assign('prev','');
					}
				if ((($this->Page) * $perPage) < $count)
					{
					$mod_ptr->smarty->assign('next',$mod_ptr->CreateLink($id,
						'admin_browse', '',
						$mod_ptr->Lang('next'),
						array('fbrp_page'=>($this->Page + 1),'form_id'=>$this->FormId,'browser_id'=>$this->Id,
							'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
					}
				else
					{
					$mod_ptr->smarty->assign('next','');
					}
				}
			else
				{
				for ($i=1;$i<=ceil($count/$perPage);$i++)
					{
					array_push($linkList,$mod_ptr->CreateFrontendLink($id,$returnid,
							'default',
							$i,
							array('fbrp_page'=>$i,'form_id'=>$this->FormId,'browser_id'=>$this->Id,
								'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir)));
					}

// Start ALBY
$_searchfield = array();
if(! empty($params['fbrp_arr_getfield']))
 foreach ($params['fbrp_arr_getfield'] as $field=>$val) $_searchfield[$field] = $val['value'];
// End ALBY
				if ($this->Page > 1)
					{
					$mod_ptr->smarty->assign('prev',$mod_ptr->CreateFrontendLink($id,$returnid,
						'default',
						$mod_ptr->Lang('previous'),
// Start ALBY
array_merge($_searchfield, array('fbrp_page'=>($this->Page - 1),'form_id'=>$this->FormId,'browser_id'=>$this->Id,
 'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir))));
// End ALBY
					}
				else
					{
					$mod_ptr->smarty->assign('prev','');
					}
				if ((($this->Page) * $perPage) < $count)
					{
					$mod_ptr->smarty->assign('next',$mod_ptr->CreateFrontendLink($id,$returnid,
						'default',
						$mod_ptr->Lang('next'),
// Start ALBY
array_merge($_searchfield, array('fbrp_page'=>($this->Page + 1),'form_id'=>$this->FormId,'browser_id'=>$this->Id,
 'fbrp_sort_field'=>$sortField,'fbrp_sort_dir'=>$sortDir))));
// End ALBY
					}
				else
					{
					$mod_ptr->smarty->assign('next','');
					}
				}
			$mod_ptr->smarty->assign('pagelinks',implode(':',$linkList));
			
			}
		else
			{
			$mod_ptr->smarty->assign('hasnav',0);
			}
			
		if ($this->GetAttr('udt_name','') != '')
			{
			// call UDT
			$parms = array('vals'=>&$vals,'names'=>&$names, 'sortingnames'=>&$sortingnames, 'side'=>($adminside?'admin':'user'));
		    $usertagops = $gCms->GetUserTagOperations();
		    $res = $usertagops->CallUserTag( $this->GetAttr('udt_name'), $parms);
			}

		$mod_ptr->smarty->assign('adminapproval',$reqAdminApproval?1:0);
		$mod_ptr->smarty->assign('userapproval',$reqUserApproval?1:0);
		$mod_ptr->smarty->assign('list',$vals);
		$mod_ptr->smarty->assign('names',$names);
		$mod_ptr->smarty->assign('sortingnames',$sortingnames);
		$mod_ptr->smarty->assign('fieldcount',count($names));
		$mod_ptr->smarty->assign('title_submit_date',$mod_ptr->Lang('title_submit_date'));
		$mod_ptr->smarty->assign('title_approval_date',$mod_ptr->Lang('title_approval_date'));
		$mod_ptr->smarty->assign('title_user_approved',$mod_ptr->Lang('title_user_approved'));
		$mod_ptr->smarty->assign('browser_title',$this->GetName());
		$mod_ptr->smarty->assign('browser_css_class',
								 $this->GetAttr('css_class','formbrowser'));
	}
	
	function BrowserShowListXLS(&$mod_ptr,&$params)
	{
		
		// rewritten
		global $gCms;
		$count = 0;

		$fb = $mod_ptr->GetModuleInstance('FormBuilder');
		$flds = array();
		$parms = array();			
		$strip = ($mod_ptr->GetPreference('strip_on_export','0') == '1');
		list($count,$names,$vals) = $fb->GetSortedResponses($this->FormId, -1, -1, false, false, $flds, $mod_ptr->GetPreference('date_format','d F y'),$parms);
		
		if ($strip)
         {
         for ($i=0;$i<count($names);$i++)
            {
            $names[$i] = strip_tags($names[$i]);
            }
         }
		
		$outstr = $mod_ptr->Lang('title_submit_date')."\t".
			$mod_ptr->Lang('title_approval_date')."\t".
			$mod_ptr->Lang('title_user_approved')."\t".
			implode("\t",$names)."\n";
		// we have a list of fields and their names, now we need to manipulate that according to our uses.
		
		for ($i=0;$i<count($vals);$i++)
			{
			$outstr .= $vals[$i]->submitted . "\t";
			$outstr .= $vals[$i]->admin_approved . "\t";
			$outstr .= $vals[$i]->user_approved . "\t";
			foreach ($vals[$i]->fields as $tv)
				{
				if ($strip)
               {
               $tv = strip_tags($tv);
               }
				$outstr .= preg_replace('/[\n\t\r]/',' ',$tv);
				$outstr .= "\t";
				}
			$outstr .= "\n";
			}
		return $outstr;
	}

	function BrowserShowListXLSFile(&$mod_ptr,&$params)
	{
		global $gCms;
		$config = $gCms->GetConfig();
		$count = 0;

		$fb = $mod_ptr->GetModuleInstance('FormBuilder');
		$flds = array();
		$parms = array();			
		$strip = ($mod_ptr->GetPreference('strip_on_export','0') == '1');
		$filespec = $config['uploads_path'].DIRECTORY_SEPARATOR.$params['filespec'];
		return $fb->WriteSortedResponsesToFile($this->FormId, $filespec, $strip, $mod_ptr->GetPreference('date_format','d F y'), $parms);
	}


    function LoadBrowser($loadDeep=false)
    {
    	$tmp = array();
    	return $this->Load('id',$this->Id, $tmp,$loadDeep);
    }
    
    function Load($loadType, $browserId, &$params,$loadDeep=false)
    {
    	if ($loadType == 'alias')
    		{
        	$sql = 'SELECT * FROM '.cms_db_prefix().'module_fbr_browser WHERE alias=?';
        	}
        else
        	{
        	$sql = 'SELECT * FROM '.cms_db_prefix().'module_fbr_browser WHERE browser_id=?';        	
        	}
	    $rs = $this->module_ptr->dbHandle->Execute($sql, array($browserId));
        if($rs && $rs->RecordCount() > 0)
	       {
	       $result = $rs->FetchRow();
           $this->Id = $result['browser_id'];
           $this->FormId = $result['form_id'];
           if (! isset($params['fbrp_browser_name']))
           		{
           		$this->Name = $result['name'];
           		}
           	if (! isset($params['fbrp_browser_alias']))
           		{
	       		$this->Alias = $result['alias'];
	       		}
           }
        else
           {
           return false;
           }
        $sql = 'SELECT name,value FROM '.cms_db_prefix().
        	'module_fbr_browser_attr WHERE browser_id=?';
	    $rs = $this->module_ptr->dbHandle->Execute($sql, array($this->Id));
        while ($rs && $result=$rs->FetchRow())
	       {
           $this->Attrs[$result['name']] = $result['value'];
           }
          
        $fullField = explode(':',$this->GetAttr('full_fields',''));
        if (count($fullField) > 0)
        	{
        	foreach($fullField as $field)
        		{
        		if ($field != '')
        			{
        			list($fKey,$fVal) = explode(',',$field);
        			$this->fullFields[$fKey]=$fVal;
        			}
        		}
        	}
        $listField = explode(':',$this->GetAttr('list_fields',''));
        if (count($listField) > 0)
        	{
        	foreach($listField as $field)
        		{
        		if ($field != '')
        			{
        			list($fKey,$fVal) = explode(',',$field);
        			$this->listFields[$fKey]=$fVal;
        			}
        		}
			}
        $fullField = explode(':',$this->GetAttr('admin_full_fields',''));
        if (count($fullField) > 0)
        	{
        	foreach($fullField as $field)
        		{
        		if ($field != '')
        			{
        			list($fKey,$fVal) = explode(',',$field);
        			$this->adminFullFields[$fKey]=$fVal;
        			}
        		}
        	}
        $listField = explode(':',$this->GetAttr('admin_list_fields',''));
        if (count($listField) > 0)
        	{
        	foreach($listField as $field)
        		{
        		if ($field != '')
        			{
        			list($fKey,$fVal) = explode(',',$field);
        			$this->adminListFields[$fKey]=$fVal;
        			}
        		}
			}
        $this->loaded = 'summary';
    }

    function Store()
    {
        if ($this->Id == -1)
            {
            $this->Id = $this->module_ptr->dbHandle->GenID(cms_db_prefix().
            	'module_fbr_browser_seq');
			$sql = 'INSERT INTO ' . cms_db_prefix().
				'module_fbr_browser (browser_id, form_id, name, alias) '.
				'VALUES (?, ?, ?, ?)';
			$res = $this->module_ptr->dbHandle->Execute($sql,
				array($this->Id, $this->FormId, $this->Name, $this->Alias));
            }
        else
            {
			$sql = 'UPDATE ' . cms_db_prefix().
				'module_fbr_browser set name=?, alias=?, form_id=? where browser_id=?';
			$res = $this->module_ptr->dbHandle->Execute($sql,
				array($this->Name, $this->Alias, $this->FormId, $this->Id));
            }
        // save out the attrs
		$sql = 'DELETE FROM '.cms_db_prefix().
			'module_fbr_browser_attr WHERE browser_id=?';
		$res = $this->module_ptr->dbHandle->Execute($sql,
			array($this->Id));
			
		$listField = array();
		foreach($this->listFields as $tKey=>$tVal)
			{
			array_push($listField,"$tKey,$tVal");
			}
		$this->SetAttr('list_fields',join(':',$listField));
		$fullField = array();
		foreach($this->fullFields as $tKey=>$tVal)
			{
			array_push($fullField,"$tKey,$tVal");
			}
		$this->SetAttr('full_fields',join(':',$fullField));
		$adminListField = array();
		foreach($this->adminListFields as $tKey=>$tVal)
			{
			array_push($adminListField,"$tKey,$tVal");
			}
		$this->SetAttr('admin_list_fields',join(':',$adminListField));
		$adminFullField = array();
		foreach($this->adminFullFields as $tKey=>$tVal)
			{
			array_push($adminFullField,"$tKey,$tVal");
			}
		$this->SetAttr('admin_full_fields',join(':',$adminFullField));
			
		foreach ($this->Attrs as $thisAttrKey=>$thisAttrValue)
			{
            $browserAttrId = $this->module_ptr->dbHandle->GenID(cms_db_prefix().
            	'module_fbr_browser_attr_seq');
			$sql = 'INSERT INTO ' . cms_db_prefix().
				'module_fbr_browser_attr (browser_attr_id, browser_id, name, value) '.
				'VALUES (?, ?, ?, ?)';
			$res = $this->module_ptr->dbHandle->Execute($sql,
				array($browserAttrId, $this->Id, $thisAttrKey,
				$thisAttrValue));
			if ($thisAttrKey == 'user_list_template')
				{
				$this->module_ptr->SetTemplate('fbr_ulist_'.$this->Id,$thisAttrValue);
				}
			elseif ($thisAttrKey == 'user_full_template')
				{
				$this->module_ptr->SetTemplate('fbr_ufull_'.$this->Id,$thisAttrValue);
				}
			elseif ($thisAttrKey == 'admin_list_template')
				{
				$this->module_ptr->SetTemplate('fbr_alist_'.$this->Id,$thisAttrValue);
				}
			elseif ($thisAttrKey == 'admin_full_template')
				{
				$this->module_ptr->SetTemplate('fbr_afull_'.$this->Id,$thisAttrValue);
				}
			}
		
        return $res;
    }

    function Delete()
    {
		if ($this->Id == -1)
		  {
		  return false;
		  }
		if ($this->loaded != 'full')
			{
			$this->LoadBrowser(true);
			}
        $this->module_ptr->DeleteTemplate('fbr_ulist_'.$this->Id);
        $this->module_ptr->DeleteTemplate('fbr_ufull_'.$this->Id);
        $this->module_ptr->DeleteTemplate('fbr_alist_'.$this->Id);
        $this->module_ptr->DeleteTemplate('fbr_afull_'.$this->Id);
		$sql = 'DELETE FROM ' . cms_db_prefix() . 'module_fbr_browser where browser_id=?';
		$res = $this->module_ptr->dbHandle->Execute($sql, array($this->Id));
		$sql = 'DELETE FROM ' . cms_db_prefix() . 'module_fbr_browser_attr where browser_id=?';
		$res = $this->module_ptr->dbHandle->Execute($sql, array($this->Id));
		return true;
    }

	function AddEditBrowser($id, $returnid, $tab, $message='')
	{
	$mod = $this->module_ptr;
	global $gCms;
		$mod->smarty->assign('fbrp_message',$message);
		$mod->smarty->assign('formstart',
			$mod->CreateFormStart($id, 'admin_store_browser', $returnid));
		$mod->smarty->assign('browser_id',
			$mod->CreateInputHidden($id, 'browser_id', $this->Id));
		$mod->smarty->assign('tab_start',$mod->StartTabHeaders().
			$mod->SetTabHeader('maintab',$mod->Lang('tab_main'),('maintab' == $tab)?true:false).
			$mod->SetTabHeader('useroptiontab',$mod->Lang('tab_user_options'),('useroptiontab' == $tab)?true:false).
			$mod->SetTabHeader('adminoptiontab',$mod->Lang('tab_admin_options'),('adminoptiontab' == $tab)?true:false).			
			$mod->SetTabHeader('ulisttab',$mod->Lang('title_browser_user_list_template'),('ulisttab' == $tab)?true:false).			
			$mod->SetTabHeader('ufulltab',$mod->Lang('title_browser_user_full_template'),('ufulltab' == $tab)?true:false).			
			$mod->SetTabHeader('alisttab',$mod->Lang('title_browser_admin_list_template'),('alisttab' == $tab)?true:false).			
			$mod->SetTabHeader('afulltab',$mod->Lang('title_browser_admin_full_template'),('afulltab' == $tab)?true:false).			
			$mod->EndTabHeaders() . $mod->StartTabContent());
		$mod->smarty->assign('tabs_end',$mod->EndTabContent());
		$mod->smarty->assign('maintab_start',$mod->StartTab("maintab"));
		$mod->smarty->assign('useroptiontab_start',$mod->StartTab("useroptiontab"));
		$mod->smarty->assign('adminoptiontab_start',$mod->StartTab("adminoptiontab"));
		$mod->smarty->assign('ulisttab_start',$mod->StartTab("ulisttab"));
		$mod->smarty->assign('ufulltab_start',$mod->StartTab("ufulltab"));
		$mod->smarty->assign('alisttab_start',$mod->StartTab("alisttab"));
		$mod->smarty->assign('afulltab_start',$mod->StartTab("afulltab"));
		$mod->smarty->assign('tab_end',$mod->EndTab());
		$mod->smarty->assign('form_end',$mod->CreateFormEnd());
		
		// Stikki's version of this code :)
		$mod->smarty->assign('title_load_template',$mod->Lang('title_load_template'));
		$modLink = $mod->CreateLink($id, 'admin_get_template', $returnid, '', array(), '', true);
		$mod->smarty->assign('security_key',CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY]);

		$templateList = array(''=>'',$mod->Lang('default_admin_list_template')=>'admin_browse_list.tpl',
			$mod->Lang('default_admin_full_template')=>'admin_browse_resp.tpl',
			$mod->Lang('default_user_list_template')=>'user_browse_list.tpl',
			$mod->Lang('default_user_full_template')=>'user_browse_resp.tpl');

		$allBrowsers = $mod->GetBrowsers();
		foreach ($allBrowsers as $thisBrowser)
			{
			if ($thisBrowser['browser_id'] != $this->Id)
				{
				$templateList[$mod->Lang('title_browser_admin_list_template').' '.$mod->Lang('browser_template_name',array($thisBrowser['name']))] =
					$thisBrowser['browser_id'].'.admin_list';
				$templateList[$mod->Lang('title_browser_admin_full_template').' '.$mod->Lang('browser_template_name',array($thisBrowser['name']))] =
					$thisBrowser['browser_id'].'.admin_full';
				$templateList[$mod->Lang('title_browser_user_list_template').' '.$mod->Lang('browser_template_name',array($thisBrowser['name']))] =
					$thisBrowser['browser_id'].'.user_list';
				$templateList[$mod->Lang('title_browser_user_full_template').' '.$mod->Lang('browser_template_name',array($thisBrowser['name']))] =
					$thisBrowser['browser_id'].'.user_full';
				}
			}
			
		$mod->smarty->assign('input_load_ul_template',$mod->CreateInputDropdown($id,
			'fbrp_fbr_ul_template_load', $templateList, -1, '', 'id="fbr_ul_template_load" onchange="jQuery(this).fbr_get_template(\''.$mod->Lang('template_are_you_sure').'\',\''.$modLink.'\',\'#fbr_user_list_template\');"'));
		$mod->smarty->assign('input_load_uf_template',$mod->CreateInputDropdown($id,
			'fbrp_fbr_uf_template_load', $templateList, -1, '', 'id="fbr_uf_template_load" onchange="jQuery(this).fbr_get_template(\''.$mod->Lang('template_are_you_sure').'\',\''.$modLink.'\',\'#fbr_user_full_template\');"'));
		$mod->smarty->assign('input_load_al_template',$mod->CreateInputDropdown($id,
			'fbrp_fbr_al_template_load', $templateList, -1, '', 'id="fbr_al_template_load" onchange="jQuery(this).fbr_get_template(\''.$mod->Lang('template_are_you_sure').'\',\''.$modLink.'\',\'#fbr_admin_list_template\');"'));
		$mod->smarty->assign('input_load_af_template',$mod->CreateInputDropdown($id,
			'fbrp_fbr_af_template_load', $templateList, -1, '', 'id="fbr_af_template_load" onchange="jQuery(this).fbr_get_template(\''.$mod->Lang('template_are_you_sure').'\',\''.$modLink.'\',\'#fbr_admin_full_template\');"'));

			
		$mod->smarty->assign('title_browser_name',$mod->Lang('title_browser_name'));
		$mod->smarty->assign('title_browser_search_field',$mod->Lang('title_browser_search_field'));
		$mod->smarty->assign('input_browser_name',
			$mod->CreateInputText($id, 'fbrp_browser_name',
			$this->Name, 50));
		$mod->smarty->assign('title_browser_alias',$mod->Lang('title_browser_alias'));
		$mod->smarty->assign('input_browser_alias',
			$mod->CreateInputText($id, 'fbrp_browser_alias',
			$this->Alias, 50));
		$mod->smarty->assign('title_browser_css_class',
			$mod->Lang('title_browser_css_class'));
		$mod->smarty->assign('input_browser_css_class',
			$mod->CreateInputText($id, 'fbrp_browsera_css_class',
				$this->GetAttr('css_class','formbrowser'), 50,50));
		$mod->smarty->assign('title_browser_user_list_template',
			$mod->Lang('title_browser_user_list_template'));
		$mod->smarty->assign('title_browser_user_full_template',
			$mod->Lang('title_browser_user_full_template'));
		$mod->smarty->assign('title_browser_admin_list_template',
			$mod->Lang('title_browser_admin_list_template'));
		$mod->smarty->assign('title_browser_admin_full_template',
			$mod->Lang('title_browser_admin_full_template'));
		$mod->smarty->assign('title_form_id',
			$mod->Lang('title_form_id'));

		$mod->smarty->assign('title_form_id',
			$mod->Lang('title_form_id'));
		$mod->smarty->assign('title_form_id',
			$mod->Lang('title_form_id'));
		$mod->smarty->assign('title_browser_type',
         $mod->Lang('title_browser_type'));

		if($this->Id > 0)
    	{
    		$mod->smarty->assign('submit_button',$mod->CreateInputHidden($id, 'active_tab', '').
    			$mod->CreateInputSubmit($id, 'fbrp_submit',
    			$mod->Lang('save_and_continue'),'onclick="jQuery(this).fbr_set_tab()"'));
    		$mod->smarty->assign('hidden',
    			$mod->CreateInputHidden($id, 'fbrp_browser_op',$mod->Lang('updated')));
			$mod->smarty->assign('adding',0);
			$mod->smarty->assign('save_button',
				$mod->CreateInputSubmit($id, 'fbrp_submit', $mod->Lang('save')));
			$mptr = $mod->GetModuleInstance('FormBuilder');
			$form = $mptr->GetFormByID($this->FormId, true);
			$mod->smarty->assign('input_form_id',$form->GetName());
			$mod->smarty->assign('input_browser_type',
            ($this->GetAttr('browser_type','simple')=='simple'?$mod->Lang('simple_browser'):$mod->Lang('advanced_browser')));

		 $field_names = array();
		 $fields = $form->GetFields();
		 for ($i=0;$i<count($fields);$i++)
				{
				if ($fields[$i]->DisplayInSubmission())
					{
					$field_names[$fields[$i]->GetName()]=$fields[$i]->GetName();
					}
				}
					
         if ($this->GetAttr('browser_type','simple')!='simple' &&
            $this->GetAttr('fs','') == '')
            {
            $mod->smarty->assign('savemsg',
               $mod->CreateInputHidden($id, 'fbrp_browsera_fs','1'));
            $mod->smarty->assign('fbrp_message',$mod->Lang('must_save'));
            
			}
         else
            {
            $mod->smarty->assign('savemsg','');
            }
			$field_count = 0;
			for ($i=0;$i<count($fields);$i++)
				{
				if ($fields[$i]->DisplayInSubmission())
					{
					$field_count++;
					}
				}
			$order = array($mod->Lang('do_not_display')=>'-1');
			for ($i=0;$i<$field_count+1;$i++)
				{
				$order[$i] = $i; 
				}
			$field_list = array();
			$incr = 0;
			for ($i=0;$i<count($fields);$i++)
				{
				if ($fields[$i]->DisplayInSubmission())
					{
					$onerow = new stdClass();
					$onerow->name = $fields[$i]->GetName();
					$onerow->id = $fields[$i]->GetId();
            $ulf = (isset($this->listFields[$fields[$i]->GetId()])?$this->listFields[$fields[$i]->GetId()]:'-1');
           $alf = (isset($this->adminListFields[$fields[$i]->GetId()])?$this->adminListFields[$fields[$i]->GetId()]:'-1');
            $uff = (isset($this->fullFields[$fields[$i]->GetId()])?$this->fullFields[$fields[$i]->GetId()]:'-1');
            $aff = (isset($this->adminFullFields[$fields[$i]->GetId()])?$this->adminFullFields[$fields[$i]->GetId()]:'-1');

         if ($this->GetAttr('browser_type','simple')=='simple')
            {
				$onerow->list_order = $mod->CreateInputDropdown($id, 'fbrp_list_field_'.$fields[$i]->GetId(),$order, -1, $ulf);
				$onerow->admin_list_order = $mod->CreateInputDropdown($id, 'fbrp_admin_list_field_'.$fields[$i]->GetId(),$order, -1, $alf);
				$onerow->full_order = $mod->CreateInputDropdown($id, 'fbrp_full_field_'.$fields[$i]->GetId(),$order, -1, $uff);
				$onerow->admin_full_order = $mod->CreateInputDropdown($id, 'fbrp_admin_full_field_'.$fields[$i]->GetId(),$order, -1, $aff);
			}
         else
            {
            // annoying bug requires explicit string cast for zeros.
            $onerow->list_order = $mod->CreateInputHidden($id,
               'fbrp_list_field_'.$fields[$i]->GetId(), ''.$ulf);
            $onerow->admin_list_order = $mod->CreateInputHidden($id,
               'fbrp_admin_list_field_'.$fields[$i]->GetId(),''.$alf);
					$onerow->full_order = $mod->CreateInputHidden($id,
                  'fbrp_full_field_'.$fields[$i]->GetId(),''.$incr);
            $onerow->admin_full_order = $mod->CreateInputHidden($id,
               'fbrp_admin_full_field_'.$fields[$i]->GetId(),''.$incr);
            }
					array_push($field_list, $onerow);
					$incr++;
					}
			$mod->smarty->assign('fields',$field_list);
			$mod->smarty->assign('title_field_name', $mod->Lang('title_field_name'));
			$mod->smarty->assign('title_list_order', $mod->Lang('title_list_order'));
			$mod->smarty->assign('title_full_order', $mod->Lang('title_full_order'));
			$mod->smarty->assign('title_admin_list_order', $mod->Lang('title_admin_list_order'));
			$mod->smarty->assign('title_admin_full_order', $mod->Lang('title_admin_full_order'));

			}
			$mod->smarty->assign('toggle_user_list','fbrp_list_field_');
			$mod->smarty->assign('toggle_user_full','fbrp_full_field_');
			$mod->smarty->assign('toggle_admin_list','fbrp_admin_list_field_');
			$mod->smarty->assign('toggle_admin_full','fbrp_admin_full_field_');
			$mod->smarty->assign('toggle_column',$mod->Lang('select_deselect_all'));
			$mod->smarty->assign('actionid',$id);
			
			$mod->smarty->assign('field_count',$field_count);
			$mod->smarty->assign('title_field_count', $mod->Lang('title_field_count',$field_count));			

			$mod->smarty->assign('input_browser_search_field',$mod->CreateInputDropdown($id,'fbrp_browsera_search_field',$field_names,-1,$this->GetAttr('search_field','')));


			if ($this->GetAttr('browser_type','simple')=='simple')
            {
            $mod->smarty->assign('mode_simple','1');
            }
         else
            {
            $mod->smarty->assign('mode_simple','0');
            }

		}
		else
		{
			$mptr = $mod->GetModuleInstance('FormBuilder');
			$formList = $mptr->GetForms();
			$formSelect = array();
			foreach($formList as $thisKey=>$thisVal)
				{
				$formSelect[$thisVal['name']] = $thisVal['form_id'];
				}
			$mod->smarty->assign('save_button','');
			$mod->smarty->assign('submit_button',
				$mod->CreateInputSubmit($id, 'fbrp_submit', $mod->Lang('add')));
    		$mod->smarty->assign('hidden',
    			$mod->CreateInputHidden($id, 'fbrp_browser_op',$mod->Lang('added')));
			$mod->smarty->assign('adding',1);
			$mod->smarty->assign('input_form_id', $mod->CreateInputDropdown($id, 'form_id',array_merge(array($mod->Lang('select_form')=>''),$formSelect), -1,$this->FormId));
			$mod->smarty->assign('field_count',0);
			$mod->smarty->assign('input_browser_type',
            $mod->CreateInputDropdown($id, 'fbrp_browsera_browser_type',
            array($mod->Lang('simple_browser')=>'simple',$mod->Lang('advanced_browser')=>'advanced')).
            '<br />'.$mod->Lang('type_help'));
		}
		
		$mod->smarty->assign('cancel', $mod->CreateInputSubmit($id, 'cancel', lang('cancel')));
		
	    $usertagops = $gCms->GetUserTagOperations();
	    $usertags = $usertagops->ListUserTags();
	    $usertaglist = array($mod->Lang('none')=>'');
	    foreach( $usertags as $key => $value )
			{
			$usertaglist[$value] = $key;
			}
		$mod->smarty->assign('input_udt_name',
			    $mod->CreateInputDropdown($id,'fbrp_browsera_udt_name',$usertaglist,-1,$this->GetAttr('udt_name','')));
		$mod->smarty->assign('title_udt_name',$mod->Lang('title_udt_name'));
	    
		
		$rowsOptions = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5',
			'6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10',
			'11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15',
			'16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20',
			'25'=>'25','30'=>'30','35'=>'35','40'=>'40','45'=>'45',
			'50'=>'50','60'=>'60','70'=>'70','80'=>'80','90'=>'90',
			'100'=>'100','200'=>'200', '300'=>'300','400'=>'400',
			'500'=>'500','1000'=>'1000','1500'=>'1500');
		$mod->smarty->assign('title_rows_per_page',$mod->Lang('title_rows_per_page'));
		$mod->smarty->assign('input_rows_per_page',$mod->CreateInputDropdown($id,'fbrp_browsera_rows_per_page',$rowsOptions,-1,$this->GetAttr('rows_per_page','10')));
		$mod->smarty->assign('title_admin_rows_per_page',$mod->Lang('title_admin_rows_per_page'));
		$mod->smarty->assign('input_admin_rows_per_page',$mod->CreateInputDropdown($id,'fbrp_browsera_admin_rows_per_page',$rowsOptions,-1,$this->GetAttr('admin_rows_per_page','10')));

		$mod->smarty->assign('title_require_admin_approval',$mod->Lang('title_require_admin_approval'));
		$mod->smarty->assign('input_require_admin_approval',$mod->CreateInputHidden($id,'fbrp_browsera_require_admin_approval','0').$mod->CreateInputCheckbox($id, 'fbrp_browsera_require_admin_approval', '1', $this->GetAttr('require_admin_approval','0')).$mod->Lang('title_require_admin_approval_long'));

		$mod->smarty->assign('title_require_user_approval',$mod->Lang('title_require_user_approval'));
		$mod->smarty->assign('input_require_user_approval',$mod->CreateInputHidden($id,'fbrp_browsera_require_user_approval','0').$mod->CreateInputCheckbox($id, 'fbrp_browsera_require_user_approval', '1', $this->GetAttr('require_user_approval','0')).$mod->Lang('title_require_user_approval_long'));

		$mod->smarty->assign('title_allow_user_add',$mod->Lang('title_allow_user_add'));
		$mod->smarty->assign('input_allow_user_add',$mod->CreateInputHidden($id,'fbrp_browsera_allow_user_add','0').$mod->CreateInputCheckbox($id, 'fbrp_browsera_allow_user_add', '1', $this->GetAttr('allow_user_add','0')).$mod->Lang('title_allow_user_add_long'));
		$mod->smarty->assign('title_allow_user_edit',$mod->Lang('title_allow_user_edit'));
		$mod->smarty->assign('input_allow_user_edit',$mod->CreateInputHidden($id,'fbrp_browsera_allow_user_edit','0').$mod->CreateInputCheckbox($id, 'fbrp_browsera_allow_user_edit', '1', $this->GetAttr('allow_user_edit','0')).$mod->Lang('title_allow_user_edit_long'));
		$mod->smarty->assign('title_allow_user_delete',$mod->Lang('title_allow_user_delete'));
		$mod->smarty->assign('input_allow_user_delete',$mod->CreateInputHidden($id,'fbrp_browsera_allow_user_delete','0').$mod->CreateInputCheckbox($id, 'fbrp_browsera_allow_user_delete', '1', $this->GetAttr('allow_user_delete','0')).$mod->Lang('title_allow_user_delete_long'));


		$mod->smarty->assign('input_browser_user_list_template',
			$mod->CreateTextArea(false, $id,
				$this->GetAttr('user_list_template',$this->DefaultUserListTemplate()), 'fbrp_browsera_user_list_template','','fbr_user_list_template',
				'', '', '80', '15','','html'));
		$mod->smarty->assign('input_browser_user_full_template',
			$mod->CreateTextArea(false, $id,
				$this->GetAttr('user_full_template',$this->DefaultUserFullTemplate()), 'fbrp_browsera_user_full_template','','fbr_user_full_template',
				'', '', '80', '15','','html'));
		$mod->smarty->assign('input_browser_admin_list_template',
			$mod->CreateTextArea(false, $id,
				$this->GetAttr('admin_list_template',$this->DefaultAdminListTemplate()), 'fbrp_browsera_admin_list_template','','fbr_admin_list_template',
				'', '', '80', '15','','html'));
		$mod->smarty->assign('input_browser_admin_full_template',
			$mod->CreateTextArea(false, $id,
				$this->GetAttr('admin_full_template',$this->DefaultAdminFullTemplate()), 'fbrp_browsera_admin_full_template','','fbr_admin_full_template',
				'', '', '80', '15','','html'));
        return $mod->ProcessTemplate('AddEditBrowser.tpl');
	}

    function MakeAlias($string, $isForm=false)
    {
    	$string = trim(htmlspecialchars($string));
        //$string = preg_replace("/[_-\W]+/", "_", $string);
		//$string = trim($string, '_');
		if ($isForm)
		  {
		  return strtolower($string);
		  }
		else
		  {
		  return 'fbr'.strtolower($string);
		  }
    }
   
	function DefaultUserListTemplate()
	{
		return file_get_contents(dirname(__FILE__).'/../templates/user_browse_list.tpl');
	}

	function DefaultUserFullTemplate()
	{
		return file_get_contents(dirname(__FILE__).'/../templates/user_browse_resp.tpl');
	}

	function DefaultAdminListTemplate()
	{
		return file_get_contents(dirname(__FILE__).'/../templates/admin_browse_list.tpl');
	}

	function DefaultAdminFullTemplate()
	{
		return file_get_contents(dirname(__FILE__).'/../templates/admin_browse_resp.tpl');
	}


    function clean_datetime($dt)
    {
    	return substr($dt,1,strlen($dt)-2);
    }


}

?>
