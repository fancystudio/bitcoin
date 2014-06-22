<?php
#-------------------------------------------------------------------------
# Module: FormBrowser - Form browser allows you to build simple database applications based upon the forms from Form Builder.
# Version: 0.3, SjG
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
# This file originally created by ModuleMaker module, version 0.2
# Copyright (c) 2008 by Samuel Goldstein (sjg@cmsmadesimple.org) 
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
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

class FormBrowser extends CMSModule
{

	var $module_ptr;
	var $dbHandle;

	function __construct()
	{
		parent::__construct();
		$this->module_ptr = &$this;
		$this->dbHandle = cmsms()->GetDb();
		
		require_once dirname(__FILE__).'/classes/Browser.class.php';
	}

	function AllowAutoInstall()
	{
		return false;
	}

	function AllowAutoUpgrade()
	{
		return false;
	}

	function GetName()
	{
		return 'FormBrowser';
	}

	function GetFriendlyName()
	{
		return $this->Lang('friendlyname');
	}

	function GetVersion()
	{
		return '0.4.2';
	}

	function GetHelp($lang = 'en_US')
	{
		return $this->Lang('help');
	}

	function GetAuthor()
	{
		return 'Stikki';
	}

	function GetAuthorEmail()
	{
		return 'stikki@cmsmadesimple.org';
	}

	function GetChangeLog()
	{
		return @file_get_contents(dirname(__FILE__) . '/changelog.inc');
	}

	function IsPluginModule()
	{
		return true;
	}

	function HasAdmin()
	{
		return true;
	}

	function GetAdminSection()
	{
		return 'content';
	}

	function GetAdminDescription($lang = 'en_US')
	{
		return $this->Lang('admindescription');
	}

	function VisibleToAdminUser()
	{
        return $this->CheckPermission('Modify Browsers');
	}
	
    function AdminStyle()
    {
      return "\n.module_fbr_table {font-size: 10px;}\n.module_fbr_area_wide {width: 500px;}\n.module_fbr_legend{font-size: 9px; margin: 6px; border: 1px solid black;}.module_fbr_area_short {width: 500px; height: 100px;}\n.module_fbr_link {text-decoration: underline;}\n.module_bfr_innernav{ padding: 5px;}\n.module_bfr_browsenav{ padding: 5px;}\n";
    }
	
	function SuppressAdminOutput(&$request)
   {
      if (strpos($_SERVER['QUERY_STRING'],'admin_export_xls') !== false)
         {
         return true;
         }
	elseif (isset($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'],'admin_get_template') !== false)
		{
			return true;
		}
      return false;
   }
	
    function DisplayErrorPage($id, &$params, $return_id, $message='')
    {
		$this->smarty->assign('title_error', $this->Lang('error'));
		$this->smarty->assign_by_ref('fbrp_message', $message);

        // Display the populated template
        echo $this->ProcessTemplate('error.tpl');
    }
	
	function GetDependencies()
	{
		return array('FormBuilder'=>'0.7');
	}

	function SetParameters()
    {
		$this->RegisterModulePlugin();
     	$this->RestrictUnknownParams();

		// pretty url to browse
		$this->RegisterRoute('/[Ff]orm[Bb]rowser\/(?P<browser>[a-zA-Z_\-0-9]+)\/(?P<returnid>[0-9]+)$/',array('action'=>'default'));
		// pretty url to response
		$this->RegisterRoute('/[Ff]orm[Bb]rowser\/(?P<browser_id>[0-9]+)\/(?P<response_id>[0-9]+)\/(?P<returnid>[0-9]+)$/',array('action'=>'user_browse_resp'));

     	$this->CreateParameter('fbrp_*','null',$this->Lang('formbrowser_params_general'));
    	$this->SetParameterType(CLEAN_REGEXP.'/fbrp_.*/',CLEAN_STRING);
    	$this->CreateParameter('form_id','null',$this->Lang('formbrowser_params_form_id'));
     	$this->SetParameterType('form_id',CLEAN_INT);
   
    	$this->CreateParameter('browser_id','null',$this->Lang('formbrowser_params_browser_id'));
     	$this->SetParameterType('browser_id',CLEAN_INT);
   
    	$this->CreateParameter('form','null',$this->Lang('formbrowser_params_form_name'));
     	$this->SetParameterType('form',CLEAN_STRING);  	
   
    	$this->CreateParameter('browser','null',$this->Lang('formbrowser_params_browser_name'));
     	$this->SetParameterType('browser',CLEAN_STRING);  	
   
    	$this->CreateParameter('field_id','null',$this->Lang('formbrowser_params_field_id'));
     	$this->SetParameterType('field_id',CLEAN_INT);
   
    	$this->CreateParameter('response_id','null',$this->Lang('formbrowser_params_response_id'));
     	$this->SetParameterType('response_id',CLEAN_INT);
   
    	$this->CreateParameter('record_id','null',$this->Lang('formbrowser_params_record_id'));
     	$this->SetParameterType('record_id',CLEAN_INT);

    	$this->CreateParameter('page','null',$this->Lang('formbrowser_params_page'));
     	$this->SetParameterType('page',CLEAN_INT);

		$this->CreateParameter('sort_field','null',$this->Lang('formbrowser_params_sort_field'));
		$this->SetParameterType('sort_field',CLEAN_STRING);

		$this->CreateParameter('sort_dir','null',$this->Lang('formbrowser_params_sort_dir'));
		$this->SetParameterType('sort_dir',CLEAN_STRING);

		$this->CreateParameter('filter_field','null',$this->Lang('formbrowser_params_filter_field'));
		$this->SetParameterType('filter_field',CLEAN_STRING);

		$this->CreateParameter('filter_value','null',$this->Lang('formbrowser_params_filter_value'));
		$this->SetParameterType('filter_value',CLEAN_STRING);

   	}

    function SearchResult($returnid, $articleid, $attr = '')
    {
		$result = array();
		$db =& $this->GetDb();
		$row=array('index_key_1'=>$this->Lang('unspecified'),'index_key_2'=>$this->Lang('unspecified'));
		if (substr($attr,0,4) == 'sub_')
			{
			$browser_id=substr($attr,4);
			$parm = array('browser_id'=>$browser_id, 'response_id'=>$articleid);
			$aebrowser = new fbrBrowser($this, $parm, true);
			$resp = $aebrowser->LoadResponse($id,$this,$parm,'full_fields');
			
			// check whether this record is approved for viewing
			if (($aebrowser->GetAttr('require_admin_approval','0') == '1' && $resp->admin_approved == '') ||
			    ($aebrowser->GetAttr('require_user_approval','0') == '1' && $resp->user_approved == ''))
				{
				return $result;
				}
			$ind = $aebrowser->GetAttr('search_field','');
			
	      	$prettyurl = 'formbrowser/' . $browser_id.'/'.$articleid.'/'.$returnid;
	      	$result[0] = $this->GetFriendlyName();
			
	      	//1 position is the title
			$result[1] = '';
			if ($ind != '')
				{
				for ($i=0;$i<count($resp->names);$i++)
					{
					if ($resp->names[$i] == $ind)
						{
						$result[1] = $resp->values[$i];
						}
					}
				}
			if ($result[1] == '')
				{
				$result[1] = $resp->submitted;
				}			
	      	$result[2] = $this->CreateLink('cntnt01', 'user_browse_resp', $returnid, '', array('browser_id' => $browser_id, 'response_id'=>$articleid) ,'', true, false, '', true, $prettyurl);
	    	}
      return $result;
    }

	function MinimumCMSVersion()
	{
		return "1.10";
	}

	function InstallPostMessage()
	{
		return $this->Lang('postinstall');
	}

	function UninstallPostMessage()
	{
		return $this->Lang('postuninstall');
	}

	function UninstallPreMessage()
	{
		return $this->Lang('really_uninstall');
	}

	function CheckAccess($permission='Modify Browsers')
	{

		$access = $this->CheckPermission($permission);
		if (!$access)  {
			echo "<p class=\"error\">".$this->Lang('you_need_permission',$permission)."</p>";
			return false;
		}
		else return true;
	}


	function buildBrowseNav($id,&$params,$returnid,$isclientside=true)
	{
		$navstr = '';
		if ($isclientside)
			{
			$navstr .= $this->CreateFrontendLink( $id, $returnid, 'default', $this->Lang('back'),
				array('form_id'=>$params['form_id'],'browser_id'=>$params['browser_id'],'fbrp_page'=>$params['fbrp_page'],
				'fbrp_sort_dir'=>$params['fbrp_sort_dir'],'fbrp_sort_field'=>$params['fbrp_sort_field']), '', false, true, '', false, '' ); // pretty url fix
			}
		else
			{
			$navstr .= $this->CreateLink($id, 'defaultadmin', $returnid, $this->Lang('friendlyname'));
			if (isset($params['browser_id']) && isset($params['form_id']) && isset($params['response_id']))
				{
            $navstr .= ' &gt; '.$this->CreateLink($id, 'admin_browse', $returnid, $this->Lang('response_list'),array('browser_id'=>$params['browser_id']));
				}
			}
		$this->smarty->assign('inner_nav',$navstr);
	}

	/*
	DO NOT allow parameters to be used for passing the order_by! It is not escaped before
	database access. If we let ADODB quote it, the SQL is not valid (not that MySQL cares,
	but Postgres does).
	*/
	function GetBrowsers($order_by='br.name')
	{
        global $gCms;
		$db = $gCms->GetDb();
		$sql = 'SELECT br.*, f.name as form_name FROM '.cms_db_prefix().'module_fbr_browser br, '.cms_db_prefix().'module_fb_form f where f.form_id=br.form_id ORDER BY '.$order_by;
	    $result = array();
	    $rs = $db->Execute($sql);
	    if($rs && $rs->RecordCount() > 0)
	    	{
	        $result = $rs->GetArray();
	    	}
	    return $result;
	}

  function GetEventDescription ( $eventname )
  {
    return $this->Lang('event_info_'.$eventname );
  }

  function GetEventHelp ( $eventname )
  {
    return $this->Lang('event_help_'.$eventname );
  }

	// contributed by Stikki to FormBuilder, borrowed here
	function GetHeaderHTML()
	{

		$config = cmsms()->GetConfig();
		$tmpl = '';
		
		$tmpl .= '<script type="text/javascript" src="'.$config['root_url'].'/modules/FormBuilder/includes/jquery.tablednd.js"></script>';		
		$tmpl .= '<script type="text/javascript" src="'.$config['root_url'].'/modules/FormBrowser/includes/fbr_jquery_functions.js"></script>';
		
      return $this->ProcessTemplateFromData($tmpl);
		
	}		

	function GetActiveTab(&$params)
		{
		if (FALSE == empty($params['active_tab']))
			{
		    return $params['active_tab'];
		  	}
		else
			{
			return 'maintab';
			}
	}

}
?>
