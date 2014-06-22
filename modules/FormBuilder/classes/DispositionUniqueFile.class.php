<?php
/* 
   FormBuilder. Copyright (c) 2005-2010 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbDispositionUniqueFile extends fbFieldBase
{

	function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'DispositionUniqueFile';
		$this->IsDisposition = true;
		$this->NonRequirableField = true;
		$this->DisplayInForm = false;
		$this->sortable = false;

		$this->IsComputedOnSubmission = true;
	}

	function ComputeOrder()
	{
		return $this->GetOption('order','1');
	}

	function Compute()
	{
		$config = cmsms()->GetConfig();
		$mod=$this->form_ptr->module_ptr;
		$form=$this->form_ptr;
		$form->setFinishedFormSmarty();

		$filespec = $this->GetOption('filespec','');
		if ($filespec == '')
		{
			$filespec = 'form_submission_'.date("Y-m-d_His").'.txt';
		}
		$evald_filename = preg_replace("/[^\w\d\.]|\.\./", "_", $mod->ProcessTemplateFromData($filespec));
		$filespec = $this->GetOption('fileroot',$config['uploads_path']).'/'.$evald_filename;
		if (strpos($filespec,$config['root_path']) !== FALSE)
		{
			$relurl = str_replace($config['root_path'],'',$filespec);
		}
		$url = $config['root_url'].$relurl;
		$url = str_replace("\\", "/", $url);
		$this->SetValue(array($filespec, $url, $relurl, $evald_filename));
	}

	function StatusInfo()
	{
		$mod=$this->form_ptr->module_ptr;
		return $this->GetOption('filespec',$mod->Lang('unspecified'));
	}

	function DisposeForm($returnid)
	{
		$config = cmsms()->GetConfig();
		$mod=$this->form_ptr->module_ptr;
		$form=$this->form_ptr;
		$count = 0;
		while (! $mod->GetFileLock() && $count<200)
		{
			$count++;
			usleep(500);
		}
		if ($count == 200)
		{
			return array(false, $mod->Lang('submission_error_file_lock'));
		}

		$form->setFinishedFormSmarty();

		$filespec = $this->GetOption('filespec','');
		if ($filespec == '')
		{
			$filespec = 'form_submission_'.date("Y-m-d_His").'.txt';
		}
		$evald_filename = preg_replace("/[^\w\d\.]|\.\./", "_", $mod->ProcessTemplateFromData($filespec));

		$filespec = $this->GetOption('fileroot',$config['uploads_path']).'/'.$evald_filename;

		$line = '';
		if ($this->GetOption('file_type','false') == 0)
		{ // If File Type is "TXT"
			// Check if first time, write header
			if (! file_exists($filespec))
			{
				$header = $this->GetOption('file_header','');

				if($header != '')
				{
					$header = $mod->ProcessTemplateFromData($header);
				}
			}

			// Make newline  
			$template = $this->GetOption('file_template','');
			if ($template == '')
			{
				$template = $form->createSampleTemplate();
			}
			$line = $template;

			$newline = $mod->ProcessTemplateFromData($line);
			$replchar = $this->GetOption('newlinechar','');
			if ($replchar != '')
			{
				$newline = rtrim($newline,"\r\n");
				$newline = preg_replace('/[\n\r]/',$replchar,$newline);
			}
			if (substr($newline,-1,1) != "\n")
			{
				$newline .= "\n";
			}

			// Get footer
			$footer = $this->GetOption('file_footer','');

			if($footer != '')
			{
				$footer = $mod->ProcessTemplateFromData($footer);
			}

			// Write file
			if(file_exists($filespec))
			{
				$rows = file($filespec);
				$fp = fopen($filespec, 'w');

				foreach($rows as $oneline)
				{
					if(substr($footer, 0, strlen($oneline)) == $oneline)
					{
						break;
					}
					fwrite($fp,$oneline);
				}
			}
			else
			{
				$fp = fopen($filespec, 'w');
			}

			fwrite($fp,$header.$newline.$footer);
			fclose($fp);
		}
		else if ($this->GetOption('file_type','false') == 1)
		{ // If File Type is "RTF"
			$header = $this->GetOption('file_header','');
			if ($header != '') {
				$header = $mod->ProcessTemplateFromData($header);
			}
			$header = preg_replace('/(\r\n)/', '\par$1', $header);
			if ($this->GetOption('rtf_template_type') == 0)
			{ // If the RTF Template Type is Basic
				$template = $this->GetOption('file_template','');
				if ($template == '') {
					$template = $form->createSampleTemplate();
				}
				$template = $mod->ProcessTemplateFromData($template);
				$template = preg_replace('/(\r\n)/', '\par$1', $template);
			}
			else if ($this->GetOption('rtf_template_type') == 1)
			{ // If the RTF Template Type is Advanced
				$template = file_get_contents(dirname(__FILE__).'/../templates/'.$this->GetOption('rtf_file_template','RTF_TemplateAdvanced.rtf'));

				// To avoid the Smarty Parser eating the RTF Tags (which also use curly braces), we need to swap the curly braces temporarily
				// to parse "Smarty" tags in the RTF Template. To use Smarty tags in the template, we'll have to use a unique enclosure of 
				// percent sign and square bracket (%[TAG]%) instead of curly braces.
				$search = array("{", "}", "%[", "]%");
				$replace = array("<RTF_TAG>", "</RTF_TAG>", "{", "}");
				$template = str_replace($search, $replace, $template);
				$template = $mod->ProcessTemplateFromData($template);
				$search = array("<RTF_TAG>", "</RTF_TAG>");
				$replace = array("{", "}");
				$template = str_replace($search, $replace, $template);
			}
			$footer = $this->GetOption('file_footer','');
			if ($footer != '') {
				$footer = $mod->ProcessTemplateFromData($footer);
			}
			$footer = preg_replace('/(\r\n)/', '\par$1', $footer);

			if ($this->GetOption('rtf_template_type') == 0)
			{ // Basic
				$rtf_template = file_get_contents(dirname(__FILE__).'/../templates/'.$this->GetOption('rtf_file_template','RTF_TemplateBasic.rtf'));
				$search = array("%%HEADER%%", "%%FIELDS%%", "%%FOOTER%%");
				$replace = array($header, $template, $footer);
				$rtf_content = str_replace($search, $replace, $rtf_template);
			}
			else if ($this->GetOption('rtf_template_type') == 1)
			{ // Advanced
				$search = array("%%HEADER%%", "%%FOOTER%%");
				$replace = array($header, $footer);
				$rtf_content = str_replace($search, $replace, $template);
			}

			$put = file_put_contents($filespec, $rtf_content);
		}

		if (strpos($filespec,$config['root_path']) !== FALSE)
		{
			$relurl = str_replace($config['root_path'],'',$filespec);
		}
		$url = $config['root_url'].$relurl;
		$url = str_replace("\\", "/", $url);

		$this->SetValue(array($filespec, $url, $relurl, $evald_filename));

		$mod->ReturnFileLock();
		return array(true,'');
	}

	function SetValue($valStr)
	{
		//error_log($this->GetName().':'.print_r($valStr,true));
		$fm = $this->form_ptr;
		if ($this->Value === false)
		{
			if (is_array($valStr))
			{
				$this->Value = $valStr;
				for ($i=0;$i<count($this->Value);$i++)
				{
					while ($this->Value[$i] != $fm->unmy_htmlentities($this->Value[$i]))
					{
						$this->Value[$i] = $fm->unmy_htmlentities($this->Value[$i]);
					}
				}
			}
			else
			{
				while ($this->Value !== $fm->unmy_htmlentities($valStr))
				{
					$this->Value = $fm->unmy_htmlentities($valStr);
				}
			}
		}
		else
		{
			if (is_array($valStr))
			{
				for ($i=0;$i<count($valStr);$i++)
				{
					while ($valStr[$i] != $fm->unmy_htmlentities($valStr[$i]))
					{
						$valStr[$i] = $fm->unmy_htmlentities($valStr[$i]);
					}
				}
				$this->Value = $valStr;
			}
			else
			{
				while ($valStr != $fm->unmy_htmlentities($valStr))
				{
					$valStr = $fm->unmy_htmlentities($valStr);
				}
				if (! is_array($this->Value))
				{
					$this->Value = array($this->Value);
				}
				array_push($this->Value,$valStr);
			}
		}
	}

	function GetHumanReadableValue($as_string=true)
	{
		$mod = $this->form_ptr->module_ptr;
		if ($as_string && is_array($this->Value) && isset($this->Value[1]))
		{
			return $this->Value[1];
		}
		else
		{
			return $this->Value;
		}
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		$config = cmsms()->GetConfig();
		$file_type = $this->GetOption('file_type','false');
		$rtf_template_type = $this->GetOption('rtf_template_type','false');

		$main = array();
		$adv = array();
		$parmMain = array();
		$parmMain['opt_file_template']['is_oneline']=true;
		$parmMain['opt_file_header']['is_oneline']=true;
		$parmMain['opt_file_header']['is_header']=true;
		$parmMain['opt_file_footer']['is_oneline']=true;
		$parmMain['opt_file_footer']['is_footer']=true;

		array_push($main,array($mod->Lang('title_file_root'),
			$mod->CreateInputText($formDescriptor, 'fbrp_opt_fileroot',
				$this->GetOption('fileroot',$config['uploads_path']),80,255).'<br />'.
				$mod->Lang('title_file_root_help')));

		array_push($main,array($mod->Lang('title_file_name'),
			array($mod->CreateInputText($formDescriptor, 'fbrp_opt_filespec',
					$this->GetOption('filespec',''),80,255),
				$this->form_ptr->AdminTemplateHelp($formDescriptor,$parmMain))));

		array_push($main,array($mod->Lang('title_newline_replacement'),
			$mod->CreateInputText($formDescriptor, 'fbrp_opt_newlinechar',
				$this->GetOption('newlinechar',''),5,15).'<br />'.
				$mod->Lang('title_newline_replacement_help')));

		// array("Text displayed in option tag" => "Value of option tag");
		$file_type_list = array("TXT"=>0,
			"RTF"=>1);
		array_push($adv,array($mod->Lang('title_file_type'),
			$mod->CreateInputDropdown($formDescriptor,
					'fbrp_opt_file_type',$file_type_list,
					$file_type)));

		array_push($adv,array($mod->Lang('title_rtf_file_template'),
			array($mod->CreateInputText($formDescriptor, 'fbrp_opt_rtf_file_template', $this->GetOption('rtf_file_template','RTF_TemplateBasic.rtf'), 50, 255),
				$mod->Lang('help_rtf_file_template'))));

		$rtf_template_type_list = array("Basic"=>0,
			"Advanced"=>1);
		array_push($adv,array($mod->Lang('title_rtf_template_type'),
			array($mod->CreateInputDropdown($formDescriptor,
					'fbrp_opt_rtf_template_type',$rtf_template_type_list,
					$rtf_template_type),
				$mod->Lang('help_rtf_template_type')
			)));

		array_push($adv,array($mod->Lang('title_unique_file_template'),
			array($mod->CreateTextArea(false, $formDescriptor, $this->GetOption('file_template',''), 'fbrp_opt_file_template', 'module_fb_area_wide', '','','',11,26),
				$mod->Lang('help_unique_file_template')."\n".
						$this->form_ptr->AdminTemplateHelp($formDescriptor,$parmMain))));

		array_push($adv,array($mod->Lang('title_file_header'),
			array($mod->CreateTextArea(false, $formDescriptor, $this->GetOption('file_header',''),'fbrp_opt_file_header', 'module_fb_area_short'),
				$mod->Lang('help_file_header_template'))));

		array_push($adv,array($mod->Lang('title_file_footer'),
			array($mod->CreateTextArea(false, $formDescriptor, $this->GetOption('file_footer',''), 'fbrp_opt_file_footer', 'module_fb_area_short'),
				$mod->Lang('help_file_footer_template'))));

		return array('main'=>$main,'adv'=>$adv);
	}

	function PostPopulateAdminForm(&$mainArray, &$advArray)
	{
		$this->HiddenDispositionFields($mainArray, $advArray);
	}

}

?>
