<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

		$this->SetPreference('hide_errors',isset($params['fbrp_hide_errors'])?$params['fbrp_hide_errors']:0);
		$this->SetPreference('show_version',isset($params['fbrp_show_version'])?$params['fbrp_show_version']:0);
		$this->SetPreference('relaxed_email_regex',isset($params['fbrp_relaxed_email_regex'])?$params['fbrp_relaxed_email_regex']:0);

		$this->SetPreference('require_fieldnames',isset($params['fbrp_require_fieldnames'])?$params['fbrp_require_fieldnames']:0);

		$this->SetPreference('unique_fieldnames',isset($params['fbrp_unique_fieldnames'])?$params['fbrp_unique_fieldnames']:0);

		$this->SetPreference('enable_fastadd',isset($params['fbrp_enable_fastadd'])?$params['fbrp_enable_fastadd']:0);
		$this->SetPreference('enable_antispam',isset($params['fbrp_enable_antispam'])?$params['fbrp_enable_antispam']:0);

        $this->SetPreference('show_fieldids',isset($params['fbrp_show_fieldids'])?$params['fbrp_show_fieldids']:0);
        $this->SetPreference('show_fieldaliases',isset($params['fbrp_show_fieldaliases'])?$params['fbrp_show_fieldaliases']:0);

        $this->SetPreference('blank_invalid',isset($params['fbrp_blank_invalid'])?$params['fbrp_blank_invalid']:0);

		$params['fbrp_message'] = $this->Lang('configuration_updated');
        $this->DoAction('defaultadmin', $id, $params);

?>