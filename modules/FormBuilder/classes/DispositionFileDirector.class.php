<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org

   This file: Copyright (c) 2007 Robert Campbell <calguy1000@hotmail.com>
   All rights reserved.
*/

class fbDispositionFileDirector extends fbFieldBase 
{
  var $fileCount;
  var $fileAdd;
  var $sampleTemplateCode;
  var $sampleHeader;
  var $dflt_filepath;

  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'DispositionFileDirector';
    $this->IsDisposition = true;
    $this->DisplayInSubmission = false;
    $this->DisplayInForm = true;
    $this->HasAddOp = true;
    $this->HasDeleteOp = true;
    $this->sortable = false;
    $this->fileAdd = 0;

    global $gCms;
    $config = $gCms->getConfig();
    $this->dflt_filepath = $config['uploads_path'];
  }


  function DoOptionAdd(&$params)
  {
    $this->fileAdd = 1;
  }

  function DoOptionDelete(&$params)
  {
    $delcount = 0;
    foreach ($params as $thisKey=>$thisVal)
      {
	if (substr($thisKey,0,9) == 'fbrp_del_')
	  {
	    $this->RemoveOptionElement('destination_filename', $thisVal - $delcount);
	    $this->RemoveOptionElement('destination_displayname', $thisVal - $delcount);
	    $delcount++;
	  }
      }
  }

  function countFiles()
  {
    $tmp = $this->GetOptionRef('destination_filename');
    if (is_array($tmp))
      {
	$this->fileCount = count($tmp);
      }
    elseif ($tmp !== false)
      {
	$this->fileCount = 1;
      }
    else
      {
	$this->fileCount = 0;
      }
  }

  function GetFieldInput($id, &$params, $returnid)
  {
    $mod = $this->form_ptr->module_ptr;
    $js = $this->GetOption('javascript','');
	
    // why all this? Associative arrays are not guaranteed to preserve
    // order, except in "chronological" creation order.
    $sorted =array();
    if ($this->GetOption('select_one','') != '')
      {
	$sorted[' '.$this->GetOption('select_one','')]='';
      }
    else
      {
	$sorted[' '.$mod->Lang('select_one')]='';
      }
    $displaynames = $this->GetOptionRef('destination_displayname');
    
    if (count($displaynames) > 1)
      {
	for($i=0;$i<count($displaynames);$i++)
	  {
	    $sorted[$displaynames[$i]]=($i+1);
	  }
      }
    else
      {
	$sorted[$displaynames] = '1';
      }
    return $mod->CreateInputDropdown($id, 'fbrp__'.$this->Id, $sorted, -1, $this->Value, $js.$this->GetCSSIdTag());
  }

  function StatusInfo()
  {
    $this->countFiles();
    $mod=$this->form_ptr->module_ptr;
    $ret= $mod->Lang('file_count',$this->fileCount);
    return $ret;
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


    $dir = $this->GetOption('file_path',$this->dflt_filepath).'/';
    $filespec = $dir.
      preg_replace("/[^\w\d\.]|\.\./", "_", 
		   $this->GetOptionElement('destination_filename',
					   ($this->Value - 1)));

    $line = '';
    if (! file_exists($filespec))
      {
	$header = $this->GetOption('file_header','');
	if ($header == '')
	  {
	    $header = $form->createSampleTemplate(false,false,false,true);
	  } 
	$header .= "\n";
      }
    $template = $this->GetOption('file_template','');
    if ($template == '')
      {
	$template = $form->createSampleTemplate();
      }
    $line = $template;

	$form->setFinishedFormSmarty();
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
    $f2 = fopen($filespec,"a");
    fclose($f2); 
    $mod->ReturnFileLock();
    return array(true,'');        
  }

  function createSampleHeader()
  {
    $mod = $this->form_ptr->module_ptr;
    $others = $this->form_ptr->GetFields();
    $fields = array();
    for($i=0;$i<count($others);$i++)
      {
	if ($others[$i]->DisplayInSubmission())
	  {
	    array_push($fields,$others[$i]->GetName());
	  }
      }
    return implode('{$TAB}',$fields);
  }


  function createSampleTemplate()
  {
    $mod = $this->form_ptr->module_ptr;
    $others = $this->form_ptr->GetFields();
    $fields = array();
    for($i=0;$i<count($others);$i++)
      {
	if ($others[$i]->DisplayInSubmission())
	  {
	    array_push($fields,'{$' . $others[$i]->GetVariableName() . '}');
	  }
      }
    return implode('{$TAB}',$fields);
  }


  function PrePopulateAdminForm($formDescriptor)
  {
    $mod = $this->form_ptr->module_ptr;

    $this->countFiles();
    if( $this->fileAdd > 0 )
      {
	$this->fileCount += $this->fileAdd;
	$this->fileAdd = 0;
      }

    $dests = '<table class="module_fb_table"><tr><th>'.$mod->Lang('title_selection_displayname').'</th><th>'.
      $mod->Lang('title_destination_filename').'</th><th>'.
      $mod->Lang('title_delete').'</th></tr>';

    for ($i=0;$i<($this->fileCount>1?$this->fileCount:1);$i++)
      {
	$dests .=  '<tr><td>'.
	  $mod->CreateInputText($formDescriptor, 'fbrp_opt_destination_displayname[]',$this->GetOptionElement('destination_displayname',$i),25,128).
	  '</td><td>'.
	  $mod->CreateInputText($formDescriptor, 'fbrp_opt_destination_filename[]',$this->GetOptionElement('destination_filename',$i),25,128).
	  '</td><td>'.
	  $mod->CreateInputCheckbox($formDescriptor, 'fbrp_del_'.$i, $i,-1).
	  '</td></tr>';
      }
    $dests .= '</table>';

    $main = array();
    $adv = array();
    $parmMain = array();
    $parmMain['opt_file_template']['is_oneline']=true;
    $parmMain['opt_file_header']['is_oneline']=true;
    $parmMain['opt_file_header']['is_header']=true;
    array_push($main,array($mod->Lang('title_select_one_message'),
			   $mod->CreateInputText($formDescriptor, 
						 'fbrp_opt_select_one',
	    $this->GetOption('select_one',$mod->Lang('select_one')),25,128)));
    array_push($main,array($mod->Lang('title_director_details'),$dests));

    array_push($adv,array($mod->Lang('title_file_path'),
			  $mod->CreateInputText($formDescriptor,
						'fbrp_opt_file_path',
						$this->GetOption('file_path',$this->dflt_filepath),40,128)));
    array_push($adv,array($mod->Lang('title_file_template'),
			  array($mod->CreateTextArea(false, $formDescriptor,
						     htmlspecialchars($this->GetOption('file_template','')),'fbrp_opt_file_template', 'module_fb_area_short', '','',0,0),$this->form_ptr->AdminTemplateHelp($formDescriptor,$parmMain))));
    array_push($adv,array($mod->Lang('title_file_header'),
			  $mod->CreateTextArea(false, $formDescriptor,
					       htmlspecialchars($this->GetOption('file_header','')),'fbrp_opt_file_header', 'module_fb_area_short', '','',0,0)));
    array_push($main,array($mod->Lang('title_newline_replacement'),
			   $mod->CreateInputText($formDescriptor, 'fbrp_opt_newlinechar',
						 $this->GetOption('newlinechar',''),5,15).'<br />'.
						$mod->Lang('title_newline_replacement_help')));

    return array('main'=>$main,'adv'=>$adv);
  }

}

?>
