<?php
#-------------------------------------------------------------------------
# Module: FormBuilder
# Version: 0.6, released 2008
#
# Copyright (c) 2007, Samuel Goldstein <sjg@cmsmodules.com>
# For Information, Support, Bug Reports, etc, please visit the
# CMS Made Simple Forge:
# http://dev.cmsmadesimple.org/projects/formbuilder/
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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
class FormBuilder extends CMSModule
{

	var $field_types;
	var $disp_field_types;
	var $std_field_types;
	var $all_validation_types;
	var $module_ptr;
	var $module_id;
	var $email_regex;
	var $email_regex_relaxed;
	var $dbHandle;

	function __construct()
	{
		parent::__construct();

		$this->module_ptr = &$this;
		$this->dbHandle =  cmsms()->GetDb();
		$this->module_id = '';
		$this->email_regex = "/^([\w\d\.\-\_])+\@([\w\d\.\-\_]+)\.(\w+)$/i";
		$this->email_regex_relaxed="/^([\w\d\.\-\_])+\@([\w\d\.\-\_])+$/i";
		
		require_once dirname(__FILE__).'/classes/Form.class.php';
		require_once dirname(__FILE__).'/classes/FieldBase.class.php';		
		
	}
	
	function initialize()
	{
		$dir=opendir(dirname(__FILE__).'/classes');
		$this->field_types = array();
		while($filespec=readdir($dir))
		{
		  if( !endswith($filespec,'.php') ) continue;
			if(strpos($filespec,'Field') === false && strpos($filespec,'Disposition') === false)
			{
				continue;
			}
			$shortname = substr($filespec,0,strpos($filespec,'.'));
			if (substr($shortname,-4) == 'Base')
			{
				continue;
			}
			$this->field_types[$this->Lang('field_type_'.$shortname)] = $shortname;
		}
		
		foreach ($this->field_types as $tName=>$tType)
		{
			if (substr($tType,0,11) == 'Disposition')
			{
				$this->disp_field_types[$tName]=$tType;
			}
		}
		$this->all_validation_types = array();
		ksort($this->field_types);
		$this->std_field_types = array(
			$this->Lang('field_type_TextField')=>'TextField',
			$this->Lang('field_type_TextAreaField')=>'TextAreaField',
			$this->Lang('field_type_CheckboxField')=>'CheckboxField',
			$this->Lang('field_type_CheckboxGroupField')=>'CheckboxGroupField',
			$this->Lang('field_type_PulldownField')=>'PulldownField',
			$this->Lang('field_type_RadioGroupField')=>'RadioGroupField',
			$this->Lang('field_type_DispositionEmail')=>'DispositionEmail',
			$this->Lang('field_type_DispositionFile')=>'DispositionFile',
			$this->Lang('field_type_PageBreakField')=>'PageBreakField',
			$this->Lang('field_type_StaticTextField')=>'StaticTextField');
		ksort($this->std_field_types);
	}

	function AllowAutoInstall()
	{
		return FALSE;
	}

	function AllowAutoUpgrade()
	{
		return FALSE;
	}

	function GetName()
	{
		return 'FormBuilder';
	}
	
	function GetFriendlyName()
	{
		return $this->Lang('friendlyname');
	}

	function GetVersion()
	{
		return '0.7.4';
	}

	function GetAuthor()
	{
		return 'Stikki';
	}

	function GetAuthorEmail()
	{
		return 'stikki@cmsmadesimple.org';
	}

	function GetAdminDescription($lang = 'en_US')
	{
		return $this->Lang('admindesc');
	}

	function GetChangeLog()
	{
		$fn = dirname(__FILE__).'/changelog.inc';
		return @file_get_contents($fn);
	}

	function IsPluginModule()
	{
		return true;
	}

	function HasAdmin()
	{
		return true;
	}

	function VisibleToAdminUser()
	{
		return $this->CheckPermission('Modify Forms');
	}

	function LazyLoadAdmin()
	{
	  return false;
	}
	
	function AdminStyle()
	{
		$output = '';
		
		$fn = dirname(__FILE__).'/includes/admin.css';
		$output .= @file_get_contents($fn);
		
		return $output;
	}

	function GetHeaderHTML()
	{
		global $gCms;
		$tmpl = '';

		if( version_compare($GLOBALS['CMS_VERSION'],'1.9') < 0 )
		  {
		    $tmpl .= '<script type="text/javascript" src="'.$gCms->config['root_url'].'/modules/'.$this->GetName().'/includes/jquery-1.4.2.min.js"></script>';
		  }
	
		$tmpl .= '<script type="text/javascript" src="'.$gCms->config['root_url'].'/modules/'.$this->GetName().'/includes/fb_jquery_functions.js"></script>';
		$tmpl .= '<script type="text/javascript" src="'.$gCms->config['root_url'].'/modules/'.$this->GetName().'/includes/fb_jquery.js"></script>';
		
        return $this->ProcessTemplateFromData($tmpl);
	}
	
	function SetParameters()
	{
		$this->RegisterModulePlugin();
		$this->RestrictUnknownParams();
		$this->CreateParameter('fbrp_*','null',$this->Lang('formbuilder_params_general'));
		$this->SetParameterType(CLEAN_REGEXP.'/fbrp_.*/',CLEAN_STRING);
		$this->CreateParameter('form_id','null',$this->Lang('formbuilder_params_form_id'));
		$this->SetParameterType('form_id',CLEAN_INT);
		$this->CreateParameter('form','null',$this->Lang('formbuilder_params_form_name'));
		$this->SetParameterType('form',CLEAN_STRING);
		
		$this->CreateParameter('field_id','null',$this->Lang('formbuilder_params_field_id'));
		$this->SetParameterType('field_id',CLEAN_INT);
		
		$this->CreateParameter('value_*','null',$this->Lang('formbuilder_params_passed_from_tag'));
		$this->SetParameterType(CLEAN_REGEXP.'/value_.*/',CLEAN_STRING);
		
		$this->CreateParameter('response_id','null',$this->Lang('formbuilder_params_response_id'));
		$this->SetParameterType('response_id',CLEAN_INT);
	}

	function DoAction($name,$id,$params,$returnid='')
	{
	
		global $gCms;
		$smarty =& $gCms->GetSmarty();
		
		$this->module_id = $id;
		parent::DoAction($name,$id,$params,$returnid);

	}

	function GetDependencies()
	{
		return array('CMSMailer'=>'1.73');
	}

	// may be too stringent, but better safe than sorry.
	function MinimumCMSVersion()
	{
		return '1.9.4.3';
	}

	function InstallPostMessage()
	{
		return $this->Lang('post_install');
	}


	function CheckAccess($permission='Modify Forms')
	{
		$access = $this->CheckPermission($permission);
		if (!$access)  {
			echo "<p class=\"error\">".$this->Lang('you_need_permission',$permission)."</p>";
			return false;
		}
		else return true;
	}

	/*
	DO NOT allow parameters to be used for passing the order_by! It is not escaped before
	database access. If we let ADODB quote it, the SQL is not valid (not that MySQL cares,
	but Postgres does).
	*/
	
	function GetForms($order_by='name')
	{
		$db = $this->GetDb();
		$sql = "SELECT * FROM ".cms_db_prefix().'module_fb_form ORDER BY '.$order_by;
		$result = array();
		$rs = $db->Execute($sql);
		if($rs && $rs->RecordCount() > 0)
		{
			$result = $rs->GetArray();
		}
		return $result;
	}

	function GetFormIDFromAlias($form_alias)
	{
		$db = $this->GetDb();
		$sql = 'SELECT form_id from '.cms_db_prefix().'module_fb_form WHERE alias = ?';
		$rs = $db->Execute($sql, array($form_alias));
		if($rs && $rs->RecordCount() > 0)
		{
			$result = $rs->FetchRow();
			return $result['form_id'];
		}
		return -1;
	}

	function GetFormNameFromID($form_id)
	{
		$db = $this->GetDb();
		$sql = 'SELECT name from '.cms_db_prefix().'module_fb_form WHERE form_id = ?';
		$rs = $db->Execute($sql, array($form_id));
		if($rs && $rs->RecordCount() > 0)
		{
			$result = $rs->FetchRow();
		}
		return $result['name'];
	}

	function GetFormByID($form_id, $loadDeep=false)
	{
		$params = array('form_id'=>$form_id);
		return new fbForm($this, $params, $loadDeep);
	}

	function GetFormByParams(&$params, $loadDeep=false)
	{
		return new fbForm($this, $params, $loadDeep);
	}

	public function GetHelp()
	{
		$smarty = cmsms()->GetSmarty();
		$smarty->assign('mod', $this);

		return $this->ProcessTemplate('help.tpl');
	}		
	
	function GetResponse($form_id,$response_id,$field_list=array(), $dateFmt='d F y')
	{
		$names = array();
		$values = array();
		$db = $this->GetDb();
		$fbField = $this->GetFormBrowserField($form_id);
		if ($fbField == false)
			{
			// error handling goes here.
			echo($this->Lang('error_has_no_fb_field'));
			}

		$dbresult = $db->Execute('SELECT * FROM '.cms_db_prefix().
					'module_fb_formbrowser WHERE fbr_id=?', array($response_id));

		$oneset = new stdClass();
		if ($dbresult && $row = $dbresult->FetchRow())
		{
			$oneset->id = $row['fbr_id'];
			$oneset->user_approved = (empty($row['user_approved'])?'':date($dateFmt,$db->UnixTimeStamp($row['user_approved']))); 
			$oneset->admin_approved = (empty($row['admin_approved'])?'':date($dateFmt,$db->UnixTimeStamp($row['admin_approved'])));
			$oneset->submitted = date($dateFmt,$db->UnixTimeStamp($row['submitted']));
			$oneset->user_approved_date = (empty($row['user_approved'])?'':$db->UnixTimeStamp($row['user_approved'])); 
			$oneset->admin_approved_date = (empty($row['admin_approved'])?'':$db->UnixTimeStamp($row['admin_approved']));
			$oneset->submitted_date = $db->UnixTimeStamp($row['submitted']);
			$oneset->xml = $row['response'];
			$oneset->fields = array();
			$oneset->names = array();
			$oneset->fieldsbyalias = array();
		}

		$populate_names = true;
		$this->HandleResponseFromXML($fbField, $oneset);
		list($fnames, $aliases, $vals) = $this->ParseResponseXML($oneset->xml);

		foreach ($fnames as $id=>$name)
			{
			if (isset($field_list[$id]) && $field_list[$id] > -1)
				{
				$oneset->values[$field_list[$id]]=$vals[$id];
				$oneset->names[$field_list[$id]]=$fnames[$id];
				}
			if (isset($aliases[$id]))
				{
				$oneset->fieldsbyalias[$aliases[$id]] = $vals[$id];
				}
			}
		return $oneset;
	}

	function ParseResponseXML($xmlstr, $human_readable_values = true)
	{
		$names = array();
		$aliases = array();
		$vals = array();
		$xml = new SimpleXMLElement($xmlstr);
		foreach ($xml->field as $xmlfield)
			{
			if ($human_readable_values)
				{
				if (isset($xmlfield['display_in_submission']) && $xmlfield['display_in_submission'] == '1')
					{
					$id = (int)$xmlfield['id'];
					$names[$id] = ((string)$xmlfield->field_name);
					$vals[$id] = ((string)$xmlfield->human_readable_value);
					if (isset($xmlfield->options))
						{
						foreach ($xmlfield->options->option as $to)
							{
							if ($to['name'] == 'field_alias')
								{
								$aliases[$id]=((string)$to);
								}
							}
						}
					}
				}
			else
				{
				$id = (int)$xmlfield['id'];
				$arrTypes = $xmlfield->xpath('options/value'); 
				if (count($arrTypes) > 1)
					{
					$vals[$id] = array();
					foreach($arrTypes as $tv)
						{
						array_push($vals[$id],(string)$tv);
						}
					}
				else
					{
					$vals[$id] = (string)$xmlfield->options->value;
					}
				}
			}
		return array($names, $aliases, $vals);
	}

	// New function as part of fix for Bug 5702 from Mike Hughesdon.
	function ParseResponseXMLType($xmlstr)
	{
		$types = array();
		$xml = new SimpleXMLElement($xmlstr);
		foreach ($xml->field as $xmlfield)
		{
			$id = (int)$xmlfield['id'];
			$types['fbrp__'.$id] = (string)$xmlfield['type'];
		}
		return $types;
	}

	function GetFormBrowserField($form_id)
	{
		$db = $this->GetDb();
		$sql = 'SELECT * FROM ' . cms_db_prefix().'module_fb_field WHERE form_id=? and type=?';
		$rs = $this->module_ptr->dbHandle->Execute($sql, array($form_id,'DispositionFormBrowser'));
		$result = array();
		if (! $rs || $rs->RecordCount() == 0)
			{
			return false;
			}
		$thisRes = $rs->GetArray();
		$params = array();
		$aeform = new fbForm($this,$params,false);

		$className = $aeform->MakeClassName($thisRes[0]['type'], '');
		// create the field object
		$field = $aeform->NewField($thisRes[0]);
		return $field;		
	}
	
	
	function HandleResponseFromXML(&$fbField, &$responseObj)
	{
		$crypt = $fbField->GetOption('crypt','0');
		if ($crypt == '1')
			{
			$cryptlib = $fbField->GetOption('crypt_lib');
			$keyfile = $fbField->GetOption('keyfile');
			if ($cryptlib == 'openssl')
				{
				$openssl = $this->GetModuleInstance('OpenSSL');
				$pkey = $fbField->GetOption('private_key');
				$openssl->Reset();
				$openssl->load_private_keyfile($pkey,$keyfile);
				}
			else
				{
				if (file_exists($keyfile))
			    	{
			        $keyfile = file_get_contents($keyfile);
			        }
				}
			}

		if ($crypt == '1')
			{
			if ($cryptlib == 'openssl')
				{
				$responseObj->xml = $openssl->decrypt_from_payload($responseObj->xml);
				if ($responseObj->xml == false)
					{
					debug_display($openssl->openssl_errors());
					}
				}
			else
				{
				$responseObj->xml = $this->fbdecrypt($responseObj->xml,$keyfile);
				}
			}
	}

	function GetSortedResponses($form_id, $start_point, $number=100, $admin_approved=false, $user_approved=false, $field_list=array(), $dateFmt='d F y', &$params)
	{
		$db = $this->GetDb();
		$names = array();
		$values = array();
		$sql = 'FROM '.cms_db_prefix().
				'module_fb_formbrowser WHERE form_id=?';
		$sqlparms = array($form_id);
		if ($user_approved)
		{
			$sql .= ' and user_approved is not null';
		}
		if ($admin_approved)
		{
			$sql .= ' and admin_approved is not null';
		}
		if( (! empty($params['fbrp_response_search'])) && (is_array($params['fbrp_response_search'])) )
		{
			$sql .= ' AND resp_id IN ('. implode(',', $params['fbrp_response_search']) .')';
		}
		if (isset($params['filter_field']) && substr($params['filter_field'],0,5) =='index')
			{
			$idxfld = intval(substr($params['filter_field'],5));
			$sql .= ' AND index_key_'.$idxfld.'=?';
			array_push($sqlparms,$params['filter_value']);
			}
		if (! isset($params['fbrp_sort_field']) || $params['fbrp_sort_field']=='submitdate' || empty($params['fbrp_sort_field']))
		{
			if (isset($params['fbrp_sort_dir']) && $params['fbrp_sort_dir'] == 'a')
			{
				$sql .= ' order by submitted asc';
			}
			else
			{
				$sql .= ' order by submitted desc';
			}
		}
		else if (isset($params['fbrp_sort_field']))
			{
			if (isset($params['fbrp_sort_dir']) && $params['fbrp_sort_dir'] == 'd')
				{
					$sql .= ' order by index_key_'.(int)$params['fbrp_sort_field'].' desc';
				}
				else
				{
					$sql .= ' order by index_key_'.(int)$params['fbrp_sort_field'].' asc';
				}
			}

		$dbcount = $db->Execute('SELECT COUNT(*) as num '.$sql,$sqlparms);

		$records = 0;
		if ($dbcount && $row = $dbcount->FetchRow())
		{
			$records = $row['num'];
		}

		if ($number > -1)
			{
			$dbresult = $db->SelectLimit('SELECT * '.$sql, $number, $start_point, $sqlparms);
			}
		else
			{
			$dbresult = $db->Execute('SELECT * '.$sql, $sqlparms);
			}
			
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			$oneset = new stdClass();
			$oneset->id = $row['fbr_id'];
			$oneset->user_approved = (empty($row['user_approved'])?'':date($dateFmt,$db->UnixTimeStamp($row['user_approved']))); 
			$oneset->admin_approved = (empty($row['admin_approved'])?'':date($dateFmt,$db->UnixTimeStamp($row['admin_approved']))); 
			$oneset->submitted = date($dateFmt,$db->UnixTimeStamp($row['submitted']));
			$oneset->user_approved_date = (empty($row['user_approved'])?'':$db->UnixTimeStamp($row['user_approved'])); 
			$oneset->admin_approved_date = (empty($row['admin_approved'])?'':$db->UnixTimeStamp($row['admin_approved'])); 
			$oneset->submitted_date = $db->UnixTimeStamp($row['submitted']);

			$oneset->xml = $row['response'];
			$oneset->fields = array();
			$oneset->fieldsbyalias = array();
			array_push($values,$oneset);
		}
		$fbField = $this->GetFormBrowserField($form_id);
		if ($fbField == false)
			{
			// error handling goes here.
			echo($this->Lang('error_has_no_fb_field'));
			}
		
		$populate_names = true;
		$mapfields = (count($field_list) > 0);
		for ($i=0;$i<count($values);$i++)
		{
			$this->HandleResponseFromXML($fbField, $values[$i]);
			list($fnames, $aliases, $vals) = $this->ParseResponseXML($values[$i]->xml);
			foreach ($fnames as $id=>$name)
				{
				if ($mapfields)
					{
					if (isset($field_list[$id]) && $field_list[$id] > -1)
						{
						if ($populate_names)
							{
							$names[$field_list[$id]] = $name;
							}
						$values[$i]->fields[$field_list[$id]]=$vals[$id];
						}
					if (isset($aliases[$id]))
						{
						$values[$i]->fieldsbyalias[$aliases[$id]] = $vals[$id];
						}
					}
				else
					{
					if ($populate_names)
						{
						$names[$id] = $name;
						}
					$values[$i]->fields[$id]=$vals[$id];
					if (isset($aliases[$id]))
						{
						$values[$i]->fieldsbyalias[$aliases[$id]] = $vals[$id];
						}
					}
				}
			$populate_names = false;
		}
		return array($records, $names, $values);
	}

	// writes all records into a flat file.
	function WriteSortedResponsesToFile($form_id, $filespec, $striptags=true, $dateFmt='d F y', &$params)
	{
		$db = $this->GetDb();
		$names = array();
		$values = array();
		$sql = 'FROM '.cms_db_prefix().
				'module_fb_formbrowser WHERE form_id=?';

		if (! isset($params['fbrp_sort_field']) || $params['fbrp_sort_field']=='submitdate' || empty($params['fbrp_sort_field']))
		{
			if (isset($params['fbrp_sort_dir']) && $params['fbrp_sort_dir'] == 'd')
			{
				$sql .= ' order by submitted desc';	
			}
			else
			{
				$sql .= ' order by submitted asc';
			}
		}
		else if (isset($params['fbrp_sort_field']))
			{
			if (isset($params['fbrp_sort_dir']) && $params['fbrp_sort_dir'] == 'd')
				{
					$sql .= ' order by index_key_'.(int)$params['fbrp_sort_field'].' desc';	
				}
				else
				{
					$sql .= ' order by index_key_'.(int)$params['fbrp_sort_field'].' asc';
				}
			}

		$fbField = $this->GetFormBrowserField($form_id);
		if ($fbField == false)
			{
			// error handling goes here.
			echo($this->Lang('error_has_no_fb_field'));
			}

		$fh = fopen($filespec, 'w+');
		if ($fh === false)
			{
			return false;
			}

		$dbresult = $db->Execute('SELECT * '.$sql, array($form_id));

		$populate_names = true;
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			$oneset = new stdClass();
			$oneset->id = $row['fbr_id'];
			$oneset->user_approved = (empty($row['user_approved'])?'':date($dateFmt,$db->UnixTimeStamp($row['user_approved']))); 
			$oneset->admin_approved = (empty($row['admin_approved'])?'':date($dateFmt,$db->UnixTimeStamp($row['admin_approved']))); 
			$oneset->submitted = date($dateFmt,$db->UnixTimeStamp($row['submitted']));
			$oneset->xml = $row['response'];
			$this->HandleResponseFromXML($fbField, $oneset);
			list($fnames, $aliases, $vals) = $this->ParseResponseXML($oneset->xml);
			if ($populate_names)
				{
				if ($striptags)
		         	{
					foreach ($fnames as $id=>$name)
						{
		            	$fnames[$id] = strip_tags($fnames[$id]);
		            	}
		         	}
				fputs ($fh, $this->Lang('title_submit_date')."\t".
					$this->Lang('title_approval_date')."\t".
					$this->Lang('title_user_approved')."\t".
					implode("\t",$fnames)."\n");
				$populate_names = false;
				}
			fputs ($fh,$oneset->submitted . "\t");
			fputs ($fh,$oneset->admin_approved . "\t");
			fputs ($fh,$oneset->user_approved . "\t");
			foreach ($vals as $tv)
				{
				if ($striptags)
	               {
	               $tv = strip_tags($tv);
	               }
				fputs ($fh,preg_replace('/[\n\t\r]/',' ',$tv));
				fputs ($fh,"\t");
				}
			fputs($fh,"\n");
		}
		fclose($fh);
		return true;
	}



	function GetSortableFields($form_id)
	{
		$ret = array();
		$parm = array('form_id'=>$form_id);
		$aeform = new fbForm($this, $parm, true);
		$fbField = $aeform->GetFormBrowserField();
		if ($fbField == false)
			{
			// error handling goes here.
			return $ret;
			}
		return $fbField->getSortFieldList();
	}

  function GetFEUIDFromResponseID($response_id)
	{
	$db = $this->GetDb();
    $sql = 'SELECT feuid FROM ' . cms_db_prefix().
      'module_fb_formbrowser where fbr_id=?';
    if($result = $db->GetRow($sql, array($response_id)))
      {
	    return $result['feuid'];
      }
    return -1;
	}

  function GetResponseIDFromFEUID($feu_id, $form_id=-1)
	{
	$db = $this->GetDb();

	// Fix for Bug 5422. Adapted from Mike Hughesdon's code.
	$sql = 'SELECT fbr_id FROM ' . cms_db_prefix().
			'module_fb_formbrowser where feuid=?';
	if ($form_id != -1)
	{
		$sql .= ' and form_id = '.$form_id.' ORDER BY submitted DESC';
	}

    if($result = $db->GetRow($sql, array($feu_id)))
      {
	    return $result['fbr_id'];
      }
    return false;
 	}

	function field_sorter_asc($a, $b)
	{
		return strcasecmp($a->fields[$a->sf], $b->fields[$b->sf]);
	}

	function field_sorter_desc($a, $b)
	{
		return strcasecmp($b->fields[$b->sf], $a->fields[$a->sf]);
	}

	
	// For a given form, returns an array of response objects
	function ListResponses($form_id, $sort_order='submitted')
	{
		$db = cmsms()->GetDb();
		$ret = array();
		$sql = 'SELECT * FROM '.cms_db_prefix().
				'module_fb_resp WHERE form_id=? ORDER BY ?';
		$dbresult = $db->Execute($sql, array($form_id,$sort_order));
		while ($dbresult && $row = $dbresult->FetchRow())
		{
			$oneset = new stdClass();
			$oneset->id = $row['resp_id'];
			$oneset->user_approved = $db->UnixTimeStamp($row['user_approved']);
			$oneset->admin_approved = $db->UnixTimeStamp($row['admin_approved']);
			$oneset->submitted = $db->UnixTimeStamp($row['submitted']);
			array_push($ret,$oneset);
		}
		return $ret;
	}

	function def(&$var)
	{
		if (!isset($var))
		{
			return false;
		}
		else if (is_null($var))
		{
			return false;
		}
		else if (!is_array($var) && empty($var))
		{
			return false;
		}
		else if (is_array($var) && count($var) == 0)
		{
			return false;
		}
		return true;
	}

	function ClearFileLock()
	{
		$db = $this->GetDb();
		$sql = "DELETE from ".cms_db_prefix().'module_fb_flock';
		$rs = $db->Execute($sql);
	}

	function GetFileLock()
	{
		$db = $this->GetDb();
		$sql = "insert into ".cms_db_prefix()."module_fb_flock (flock_id, flock) values (1,".$db->sysTimeStamp.")";
		$rs = $db->Execute($sql);
		if ($rs)
		{
			return true;
		}
		$sql = "SELECT flock_id FROM ".cms_db_prefix().
				"module_fb_flock where flock + interval 15 second < ".$db->sysTimeStamp;
		$rs = $db->Execute($sql);
		if ($rs && $rs->RecordCount() > 0)
		{
			$this->ClearFileLock();
			return false;
		}
		return false;
	}

	function ReturnFileLock()
	{
		$this->ClearFileLock();
	}

	function GetEventDescription ( $eventname )
	{
		return $this->Lang('event_info_'.$eventname );
	}

	function GetEventHelp ( $eventname )
	{
		return $this->Lang('event_help_'.$eventname );
	}

	function CreatePageDropdown($id,$name,$current='',
								$addtext='',$markdefault =true)
	{
      global $gCms;
		// we get here (hopefully) when the template is changed
		// in the dropdown.
		$db = $this->GetDb();
		$defaultid = '';
		if( $markdefault )
		{
			$contentops = $gCms->GetContentOperations();
			$defaultid = $contentops->GetDefaultPageID();
		}
		
		// get a list of the pages used by this template
		$mypages = array();

		if ($this->GetPreference('mle_version','0') == '1')
			{
			global $mleblock;
			$q = "SELECT content_id,content_name$mleblock as content_name FROM ".
				cms_db_prefix()."content WHERE type = ? AND active = 1";	
			}
		else
			{
			$q = "SELECT content_id,content_name FROM ".cms_db_prefix().
				"content WHERE type = ? AND active = 1";
			}
		$dbresult = $db->Execute( $q, array('content') );
		while( $row = $dbresult->FetchRow() )
		{
			if( $defaultid != '' && $row['content_id'] == $defaultid )
			{
				// use a star instead of a word here so I don't have to
				// worry about translation stuff
				$mypages[$row['content_name'].' (*)'] = $row['content_id'];
			}
			else
			{
				$mypages[$row['content_name']] = $row['content_id'];
			}
		}
		return $this->CreateInputDropdown($id,'fbrp_'.$name,$mypages,-1,$current,$addtext);
	}

	function SuppressAdminOutput(&$request)
	{
		if (isset($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'],'exportxml') !== false)
		{
			return true;
		}
		elseif (isset($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'],'admin_get_template') !== false)
		{
			return true;
		}
		return false;
	}

   function crypt($string, $dispositionField)
   {
   if ($dispositionField->GetOption('crypt_lib') == 'openssl')
      {
	   $openssl = $this->GetModuleInstance('OpenSSL');
	   if ($openssl === FALSE)
		    {
		    return array(false,$this->Lang('title_install_openssl'));
		    }
	   $openssl->Reset();
	   if (! $openssl->load_certificate($dispositionField->GetOption('crypt_cert')))
		   {
		   return array(false,$openssl->openssl_errors());
		   }
	   $enc = $openssl->encrypt_to_payload($string);
	   }
    else
      {
      $kf = $dispositionField->GetOption('keyfile');
      if (file_exists($kf))
         {
         $key = file_get_contents($kf);
         }
      else
         {
         $key = $kf;
         }
      $enc = $this->fbencrypt($string,$key);
      }
    return array(true,$enc);
   }


  function getHashedSortFieldVal($val)
	{
	if (strlen($val) > 4)
		{
		$val = substr($val,0,4). md5(substr($val,4));
		}
	return $val;
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
  
   function fbencrypt($string,$key)
      {
      $key = substr(md5($key),0,24);
      $td = mcrypt_module_open ('tripledes', '', 'ecb', '');
      $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
      mcrypt_generic_init ($td, $key, $iv);
      $enc = base64_encode(mcrypt_generic ($td, $string));
      mcrypt_generic_deinit ($td);
      mcrypt_module_close ($td);
      return $enc;
      }

   function fbdecrypt($crypt,$key)
      {
      $crypt = base64_decode($crypt);
      $td = mcrypt_module_open ('tripledes', '', 'ecb', '');
      $key = substr(md5($key),0,24);
      $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
      mcrypt_generic_init ($td, $key, $iv);
      $plain = mdecrypt_generic ($td, $crypt);
      mcrypt_generic_deinit ($td);
      mcrypt_module_close ($td);
      return $plain;
      }

  function fbCreateInputText($id, $name, $value='', $size='10', $maxlength='255', $addttext='', $type='text')
	{
  	$value = cms_htmlentities($value);
  	$id = cms_htmlentities($id);
  	$name = cms_htmlentities($name);
  	$size = cms_htmlentities($size);
  	$maxlength = cms_htmlentities($maxlength);

  	$value = str_replace('"', '&quot;', $value);

  	$text = '<input type="'.$type.'" name="'.$id.$name.'" value="'.$value.'" size="'.$size.'" maxlength="'.$maxlength.'"';
  	if ($addttext != '')
    	{
      	$text .= ' ' . $addttext;
    	}
  	$text .= " />\n";
  	return $text;
	}

	function fbCreateInputSubmit($id, $name, $value='', $addttext='', $image='', $confirmtext='')
	{
	  $id = cms_htmlentities($id);
	  $name = cms_htmlentities($name);
	  $image = cms_htmlentities($image);
		global $gCms;
		$config = $gCms->GetConfig();
		$text = '<input name="'.$id.$name.'" value="'.$value.'" type=';
		if ($image != '')
		{
			$text .= '"image"';
			$img = $config['root_url'] . '/' . $image;
			$text .= ' src="'.$img.'"';
		}
		else
		{
			$text .= '"submit"';
		}
		if ($confirmtext != '' )
		  {
			$text .= ' onclick="return confirm(\''.$confirmtext.'\');"';
		  }
		if ($addttext != '')
		{
			$text .= ' '.$addttext;
		}
		$text .= ' />';
		return $text . "\n";
	}


  function DeleteFromSearchIndex(&$params)
	{
		$aeform = new fbForm($this, $params, true);
		
		// find browsers keyed to this
		$browsers = $aeform->GetFormBrowsersForForm();
		if (count($browsers) < 1)
			{
			return;
			}

		$module =& $this->module_ptr->GetModuleInstance('Search');
	    if ($module != FALSE)
	      {
			foreach ($browsers as $thisBrowser)
				{
				$module->DeleteWords( 'FormBrowser', $params['response_id'], 'sub_'.$thisBrowser);	
				}
	      }
	}




  function RegisterTinyMCEPlugin() {
    
    $config=$this->GetConfig();
    $plugin = "
	tinymce.create('tinymce.plugins.formpicker', {
        createControl: function(n, cm) {
            switch (n) {
                 case 'formpicker':
                    var c = cm.createMenuButton('formpicker', {
                        title : '" . $this->GetFriendlyName() . "',
                        image : '" . $config["root_url"] . "/modules/FormBuilder/images/info-small.gif',
                        icons : false
                        });

                        c.onRenderMenu.add(function(c, m) {
                ";
    $forms = $this->GetForms();
    
    foreach ($forms as $form) {     
        $plugin .= "
            m.add({
                title : '" . $form['name'] . "',
                onclick : function() {
                  tinyMCE.activeEditor.execCommand('mceInsertContent', false, '&#123;FormBuilder form=\"".$form["alias"]."\"&#125;');
                }
      });
      ";
    }



    $plugin .= "
                });
              // Return the new menu button instance
              return c;
            }

          return null;
       }
});
";
 return array(array('formpicker', $plugin, $this->GetFriendlyName()));
  }




} // End of Class

# vim:ts=4 sw=4 noet
?>
