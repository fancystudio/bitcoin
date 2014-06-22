<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbDispositionFile extends fbFieldBase 
{

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'DispositionFile';
    $this->IsDisposition = true;
    $this->NonRequirableField = true;
    $this->DisplayInForm = false;
    $this->sortable = false;

  }

  function StatusInfo()
  {
    $mod=$this->form_ptr->module_ptr;
    return $this->GetOption('filespec',$mod->Lang('unspecified'));
  }

	function DisposeForm($returnid)
  {
	global $gCms;
	$options = $gCms->GetConfig();
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

    $filespec = $this->GetOption('fileroot',$options['uploads_path']).'/'.
      preg_replace("/[^\w\d\.]|\.\./", "_", $this->GetOption('filespec','form_submissions.txt'));

    $form->setFinishedFormSmarty();

    $line = '';
	
	// Check if first time, write header
    if (! file_exists($filespec))
      {
		$header = $this->GetOption('file_header','');

		if($header != '') {
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

    $newline = $mod->ProcessTemplateFromData( $line );
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

	if($footer != '') {
		$footer = $mod->ProcessTemplateFromData($footer);
	}

	// Write file
	if(file_exists($filespec)) {
	
		$rows = file($filespec);
		$fp = fopen($filespec, 'w');
		
		foreach($rows as $oneline) {
		
			if(substr($footer, 0, strlen($oneline)) == $oneline) {
			
				break;
			}
			
			fwrite($fp,$oneline);
		}
	
	} else {
		
		$fp = fopen($filespec, 'w');
	}
	
	fwrite($fp,$header.$newline.$footer);
	fclose($fp);
	
	/*  Stikki removed: due new rewrite method
    $f2 = fopen($filespec,"a");
    fwrite($f2,$header.$newline);
    fclose($f2);*/ 
    $mod->ReturnFileLock();
    return array(true,'');        
  }

  function PrePopulateAdminForm($formDescriptor)
  {
  
	global $gCms;
    $mod = $this->form_ptr->module_ptr;
	$config = $gCms->GetConfig();

	
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
						 $this->GetOption('fileroot',$config['uploads_path']),45,255).'<br />'.
				$mod->Lang('title_file_root_help')));
				
    array_push($main,array($mod->Lang('title_file_name'),
			   $mod->CreateInputText($formDescriptor, 'fbrp_opt_filespec',
						 $this->GetOption('filespec','form_submissions.txt'),25,128)));

    array_push($main,array($mod->Lang('title_newline_replacement'),
			   $mod->CreateInputText($formDescriptor, 'fbrp_opt_newlinechar',
						 $this->GetOption('newlinechar',''),5,15).'<br />'.
						$mod->Lang('title_newline_replacement_help')));
						 
    array_push($adv,array($mod->Lang('title_file_template'),
			  array($mod->CreateTextArea(false, $formDescriptor, $this->GetOption('file_template',''),'fbrp_opt_file_template', 'module_fb_area_short', '','',0,0),$this->form_ptr->AdminTemplateHelp($formDescriptor,$parmMain))));
						   //htmlspecialchars($this->GetOption('file_template','')),'fbrp_opt_file_template', 'module_fb_area_short', '','',0,0),$this->form_ptr->AdminTemplateHelp($formDescriptor,$parmMain)))); Stikki changed: breiking template
												
    array_push($adv,array($mod->Lang('title_file_header'),
			  $mod->CreateTextArea(false, $formDescriptor, $this->GetOption('file_header',''),'fbrp_opt_file_header', 'module_fb_area_short', '','',0,0)));
					       //htmlspecialchars($this->GetOption('file_header','')),'fbrp_opt_file_header', 'module_fb_area_short', '','',0,0))); Stikki changed: breiking template
						   
    array_push($adv,array($mod->Lang('title_file_footer'),
			  $mod->CreateTextArea(false, $formDescriptor, $this->GetOption('file_footer',''), 'fbrp_opt_file_footer', 'module_fb_area_short', '','',0,0)));	   

    return array('main'=>$main,'adv'=>$adv);
  }

  function PostPopulateAdminForm(&$mainArray, &$advArray)
  {
    $this->HiddenDispositionFields($mainArray, $advArray);
  }
  
}

?>
