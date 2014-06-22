<?php
/* 
   FormBuilder. Copyright (c) 2005-2007 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2007 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;

		$db = $this->GetDb();
		$dict = NewDataDictionary($db);
		$flds = "
			form_id I KEY,
			name C(255),
			alias C(255)
		";
		$taboptarray = array('mysql' => 'TYPE=MyISAM');
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_form', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_form_seq');
		$db->Execute('create index '.cms_db_prefix().'module_fb_form_idx on '.cms_db_prefix().'module_fb_form (alias)');
		
		$flds = "
			form_attr_id I KEY,
			form_id I,
			name C(35),
			value X
		";
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_form_attr', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_form_attr_seq');
		$db->Execute('create index '.cms_db_prefix().'module_fb_form_attr_idx on '.cms_db_prefix().'module_fb_form_attr (form_id)');

		$flds = "
			field_id I KEY,
			form_id I,
			name C(255),
			type C(50),
			validation_type C(50),
			required I1,
			hide_label I1,
			order_by I
		";
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_field', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_field_seq');
		$db->Execute('create index '.cms_db_prefix().'module_fb_field_idx on '.cms_db_prefix().'module_fb_field (form_id)');


		$flds = "
			option_id I KEY,
			field_id I,
			form_id I,
			name C(255),
			value X
		";
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_field_opt', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_field_opt_seq');
		$db->Execute('create index '.cms_db_prefix().'module_fb_field_opt_idx on '.cms_db_prefix().'module_fb_field_opt (field_id,form_id)');

		$flds = "
			flock_id I KEY,
			flock T
		";

		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_flock', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$flds = "
			resp_id I KEY,
			form_id I,
			feuser_id I,
			user_approved ".CMS_ADODB_DT.",
			secret_code C(35),
			admin_approved ".CMS_ADODB_DT.",
			submitted ".CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_resp', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$flds = "
			resp_attr_id I KEY,
			resp_id I,
			name C(35),
			value X
		";
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_resp_attr', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_resp_attr_seq');


		$db->CreateSequence(cms_db_prefix().'module_fb_resp_seq');

		$flds = "
			resp_val_id I KEY,
			resp_id I,
			field_id I,
			value X
		";
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_resp_val', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_resp_val_seq');

		$flds = "
			sent_id I KEY,
			src_ip C(16),
			sent_time ".CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_ip_log', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_ip_log_seq');

		$flds = "
				fbr_id I KEY,
				form_id I,
				index_key_1 C(80),
				index_key_2 C(80),
				index_key_3 C(80),
				index_key_4 C(80),
				index_key_5 C(80),
				feuid I,
				response XL,
				user_approved ".CMS_ADODB_DT.",
				secret_code C(35),
				admin_approved ".CMS_ADODB_DT.",
				submitted ".CMS_ADODB_DT;
				
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_fb_formbrowser', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$db->CreateSequence(cms_db_prefix().'module_fb_formbrowser_seq');
		$db->CreateSequence(cms_db_prefix().'module_fb_uniquefield_seq');

		$this->CreatePermission('Modify Forms', 'Modify Forms');

		$this->CreateEvent( 'OnFormBuilderFormSubmit' );
		$this->CreateEvent( 'OnFormBuilderFormDisplay' );
		$this->CreateEvent( 'OnFormBuilderFormSubmitError' );

		$css = file_get_contents(cms_join_path(dirname(__FILE__), 'includes','default.css'));
		$css_id = $db->GenID(cms_db_prefix().'css_seq');
		$db->Execute('insert into '.cms_db_prefix().'css (css_id, css_name, css_text, media_type, create_date) values (?,?,?,?,?)',
			array($css_id,'FormBuilder Default Style',$css,'screen',date('Y-m-d')));

		//include 'includes/FormBuilderSampleData.inc';	
		$path = cms_join_path(dirname(__FILE__),'includes');
		$dir=opendir($path);
   		while ($filespec=readdir($dir))
   			{
   			$params = array();
   			$aeform = '';
       		if (preg_match('/.xml$/',$filespec) > 0)
       			{
       			$params['fbrp_xml_file'] = cms_join_path($path,$filespec);
       			$aeform = new fbForm($this, $params, true);
				$res = $aeform->ImportXML($params);
       			}
       		}

		$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
?>
