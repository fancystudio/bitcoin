<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbFileUploadField extends fbFieldBase {

	public function __construct(&$form_ptr, &$params)
	{
		parent::__construct($form_ptr, $params);
		$mod = $form_ptr->module_ptr;
		$this->Type = 'FileUploadField';
		//    $this->DisplayType = $mod->Lang('field_type_file_upload');
		$this->ValidationTypes = array(
		$mod->Lang('validation_none')=>'none');
		$this->sortable = false;
	}

	public function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;
		$js = $this->GetOption('javascript','');
		$txt = '';
		if($this->Value != '')
		{
			$txt .= $this->GetHumanReadableValue()."<br />";	// Value line
		}
		$txt .= $mod->CreateFileUploadInput($id,'fbrp__'.$this->Id,$js.$this->GetCSSIdTag()); // Input line
		if($this->Value != '')
		{
			$txt .= $mod->CreateInputCheckbox($id, 'fbrp_delete__'.$this->Id, -1).'&nbsp;'.$mod->Lang('delete')."<br />"; // Delete line
		}

		// Extras
		if ($this->GetOption('show_details','0') == '1')
		{
			$ms = $this->GetOption('max_size');
			if ($ms != '')
			{
				$txt .= ' '.$mod->Lang('maximum_size').': '.$ms.'kb';
			}
			$exts = $this->GetOption('permitted_extensions');
			if ($exts != '')
			{
				$txt .= ' '.$mod->Lang('permitted_extensions') . ': '.$exts;
			}
		}
		return $txt;
	}

	public function Load($id, &$params, $loadDeep=false)
	{
		$mod = $this->form_ptr->module_ptr;
		parent::Load($id,$params,$loadDeep);

		if( isset( $_FILES ) && isset( $_FILES[$mod->module_id.'fbrp__'.$this->Id] ) && $_FILES[$mod->module_id.'fbrp__'.$this->Id]['size'] > 0 )
		{
			// Okay, a file was uploaded
			$this->SetValue($_FILES[$mod->module_id.'fbrp__'.$this->Id]['name']);
		}
	}

	public function GetHumanReadableValue($as_string=true)
	{
		if ($this->GetOption('suppress_filename','0') != '0')
		{
			return '';
		}
		return $this->Value;
	}

	public function StatusInfo()
	{
		$mod = $this->form_ptr->module_ptr;
		$ms = $this->GetOption('max_size','');
		$exts = $this->GetOption('permitted_extensions','');
		$ret = '';
		if ($ms != '')
		{
			$ret .= $mod->Lang('maximum_size').': '.$ms.'kb, ';
		}
		if ($exts != '')
		{
			$ret .= $mod->Lang('permitted_extensions') . ': '.$exts.', ';
		}
		if ($this->GetOption('file_destination','') != '')
		{
			$ret .= $this->GetOption('file_destination','');
		}
		if ($this->GetOption('allow_overwrite','0') != '0')
		{
			$ret .= ' '.$mod->Lang('overwrite');
		}
		else
		{
			$ret .= ' '.$mod->Lang('nooverwrite');
		}
		return $ret;
	}


	public function PrePopulateAdminForm($formDescriptor)
	{
		global $gCms;
		$mod = $this->form_ptr->module_ptr;
		$ms = $this->GetOption('max_size');
		$exts = $this->GetOption('permitted_extensions');
		$show = $this->GetOption('show_details','0');
		$sendto_uploads = $this->GetOption('sendto_uploads','false');
		$uploads_category = $this->GetOption('uploads_category');
		$uploads_destpage = $this->GetOption('uploads_destpage');

		$main = array(
			array($mod->Lang('title_maximum_size'),
				$mod->CreateInputText($formDescriptor,'fbrp_opt_max_size', $ms, 5, 5).' '.$mod->Lang('title_maximum_size_long')),
			array($mod->Lang('title_permitted_extensions'),
				$mod->CreateInputText($formDescriptor,'fbrp_opt_permitted_extensions',$exts,25,80).'<br/>'.
				$mod->Lang('title_permitted_extensions_long')),
			array($mod->Lang('title_show_limitations'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_show_details','0').
				$mod->CreateInputCheckbox($formDescriptor,'fbrp_opt_show_details', '1', $show).' '.
				$mod->Lang('title_show_limitations_long')),
			array($mod->Lang('title_allow_overwrite'),
				$mod->CreateInputHidden($formDescriptor,'fbrp_opt_allow_overwrite','0').
				$mod->CreateInputCheckbox($formDescriptor,'fbrp_opt_allow_overwrite', '1', $this->GetOption('allow_overwrite','0')).' '.
				$mod->Lang('title_allow_overwrite_long'))
		);

		$uploads = $mod->GetModuleInstance('Uploads');
		$sendto_uploads_list = array($mod->Lang('no')=>0,$mod->Lang('yes')=>1);
		$adv = array();

		$file_rename_help = $mod->Lang('file_rename_help') . $this->form_ptr->fieldValueTemplate().
			'<tr><td>$ext</td><td>'.$mod->Lang('original_file_extension').'</td></tr></table>';

		array_push($adv, array($mod->Lang('title_file_rename'),
			$mod->CreateInputText($formDescriptor,'fbrp_opt_file_rename',$this->GetOption('file_rename',''),60,255).$file_rename_help));
		array_push($adv, array($mod->Lang('title_suppress_filename'),
			$mod->CreateInputHidden($formDescriptor,'fbrp_opt_suppress_filename','0').
			$mod->CreateInputCheckbox($formDescriptor,'fbrp_opt_suppress_filename', '1', 
			$this->GetOption('suppress_filename','0'))));

		array_push($adv, array($mod->Lang('title_suppress_attachment'),
			$mod->CreateInputHidden($formDescriptor,'fbrp_opt_suppress_attachment',0).
			$mod->CreateInputCheckbox($formDescriptor, 'fbrp_opt_suppress_attachment', 1, $this->GetOption('suppress_attachment',1))));

		array_push($main, array($mod->Lang('title_remove_file_from_server'),
			$mod->CreateInputHidden($formDescriptor,'fbrp_opt_remove_file','0').
			$mod->CreateInputCheckbox($formDescriptor,'fbrp_opt_remove_file', '1', $this->GetOption('remove_file','0')).
		$mod->Lang('help_ignored_if_upload')));
		array_push($main, array($mod->Lang('title_file_destination'),
			$mod->CreateInputText($formDescriptor,'fbrp_opt_file_destination',$this->GetOption('file_destination',$gCms->config['uploads_path']),60,255).
			$mod->Lang('help_ignored_if_upload')));

		if( $uploads )
		{
			$categorylist = $uploads->getCategoryList();
			array_push($adv,array($mod->Lang('title_sendto_uploads'),
				$mod->CreateInputDropdown($formDescriptor,'fbrp_opt_sendto_uploads',$sendto_uploads_list,
				$sendto_uploads)));

			array_push($adv,array($mod->Lang('title_uploads_category'),
				$mod->CreateInputDropdown($formDescriptor,'fbrp_opt_uploads_category',$categorylist,'',
				$uploads_category)));
			array_push($adv,array($mod->Lang('title_uploads_destpage'),
				$mod->CreatePageDropdown($formDescriptor,'opt_uploads_destpage',$uploads_destpage)));
		}

		return array('main'=>$main,'adv'=>$adv);
	}

	public function PostDispositionAction()
	{
		if (!empty($this->Value) && $this->GetOption('remove_file','0') == '1')
		{
			$filepath = cms_join_path($this->GetOption('file_destination'), $this->Value);
			if (file_exists($filepath))
			{
				unlink($filepath);
			}
		}
	}

	public function Validate()
	{
		$this->validated = true;
		$this->validationErrorText = '';
		$ms = $this->GetOption('max_size');
		$exts = $this->GetOption('permitted_extensions','');
		$mod = $this->form_ptr->module_ptr;
		//$fullAlias = $this->GetValue(); -- Stikki modifys: Now gets correct alias
		$fullAlias = $mod->module_id.'fbrp__'.$this->Id;
		if ($_FILES[$fullAlias]['size'] < 1 && ! $this->Required)
		{
			return array(true,'');
		}
		if ($_FILES[$fullAlias]['size'] < 1 && $this->Required )
		{
			$this->validated = false;
			$this->validationErrorText = $mod->Lang('required_field_missing');
		}
		else if ($ms != '' && $_FILES[$fullAlias]['size'] > ($ms * 1024))
		{
			$this->validationErrorText = $mod->Lang('file_too_large'). ' '.$ms.'kb';//($ms * 1024).'kb'; // Stikki mods
			$this->validated = false;
		}
		else if ($exts != '')
		{
			$match = false;
			$legalExts = explode(',',$exts);
			foreach ($legalExts as $thisExt)
			{
				if (preg_match('/\.'.trim($thisExt).'$/i',$_FILES[$fullAlias]['name']))
				{
					$match = true;
				}
				else if (preg_match('/'.trim($thisExt).'/i',$_FILES[$fullAlias]['type']))
				{
					$match = true;
				}
			}
			if (! $match)
			{
				$this->validationErrorText = $mod->Lang('illegal_file_type');
				$this->validated = false;
			}
		}
		return array($this->validated, $this->validationErrorText);
	}
}
?>