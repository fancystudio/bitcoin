<?php
/*
 * FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
 * More info at http://dev.cmsmadesimple.org/projects/formbuilder
 *
 * A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
 * This project's homepage is: http://www.cmsmadesimple.org
 */

class fbForm {
	// Foaly: all public for now. need to find out which can be protected
	public $module_ptr = -1;
	public $module_params = -1;
	public $Id = -1;
	public $Name = '';
	public $Alias = '';
	public $loaded = 'not';
	public $formTotalPages = 0;
	public $Page;
	public $Attrs;
	public $Fields;
	public $formState;
	public $sampleTemplateCode;
	public $templateVariables;

	public function __construct(&$module_ptr, &$params, $loadDeep=false, $loadResp=false)
	{
		$this->module_ptr = $module_ptr;
		$this->module_params = $params;
		$this->Fields = array();
		$this->Attrs = array();
		$this->formState = 'new';

		// Stikki adding: $id overwrite possible with $param
		if ((!isset($this->module_ptr->module_id) || empty($this->module_ptr->module_id)) && isset($params['module_id']))
		{
			$this->module_ptr->module_id = $params['module_id'];
		}

		if (isset($params['form_id']))
		{
			$this->Id = $params['form_id'];
		}

		if (isset($params['fbrp_form_alias']))
		{	 
			$this->Alias = $params['fbrp_form_alias'];
		}

		if (isset($params['fbrp_form_name']))
		{
			$this->Name = $params['fbrp_form_name'];
		}

		$fieldExpandOp = false;
		foreach($params as $pKey=>$pVal)
		{
			if (substr($pKey,0,9) == 'fbrp_FeX_' || substr($pKey,0,9) == 'fbrp_FeD_')
			{
				// expanding or shrinking a field
				$fieldExpandOp = true;
			}
		}

		if ($fieldExpandOp)
		{
			$params['fbrp_done'] = 0;
			if (isset($params['fbrp_continue']))
			{
				$this->Page = $params['fbrp_continue'] - 1;
			}
			else
			{
				$this->Page = 1;
			}
		}
		else
		{
			if (isset($params['fbrp_continue']))
			{
				$this->Page = $params['fbrp_continue'];
			}
			else
			{
				$this->Page = 1;
			}

			if (isset($params['fbrp_prev']) && isset($params['fbrp_previous']))
			{
				$this->Page = $params['fbrp_previous'];
				$params['fbrp_done'] = 0;
			}
		}

		$this->formTotalPages = 1;
		if (isset($params['fbrp_done'])&& $params['fbrp_done']==1)
		{
			$this->formState = 'submit';
		}

		if (isset($params['fbrp_user_form_validate']) && $params['fbrp_user_form_validate']==true)
		{
			$this->formState = 'confirm';
		}

		if ($this->Id != -1)
		{
			if (isset($params['response_id']) && $this->formState == 'submit')
			{
				$this->formState = 'update';
			}

			$this->Load($this->Id, $params, $loadDeep, $loadResp);
		}

		foreach ($params as $thisParamKey=>$thisParamVal)
		{
			if (substr($thisParamKey,0,11) == 'fbrp_forma_')
			{
				$thisParamKey = substr($thisParamKey,11);
				$this->Attrs[$thisParamKey] = $thisParamVal;
			}
			elseif ($thisParamKey == 'fbrp_form_template' && $this->Id != -1)
			{
				$this->module_ptr->SetTemplate('fb_'.$this->Id,$thisParamVal);
			}
		}

		$this->templateVariables = Array(
			'{$sub_form_name}'=>$this->module_ptr->Lang('title_form_name'),
			'{$sub_date}'=>$this->module_ptr->Lang('help_submission_date'),
			'{$sub_host}'=>$this->module_ptr->Lang('help_server_name'),
			'{$sub_source_ip}'=>$this->module_ptr->Lang('help_sub_source_ip'),
			'{$sub_url}'=>$this->module_ptr->Lang('help_sub_url'),
			'{$fb_version}'=>$this->module_ptr->Lang('help_fb_version'),
			'{$TAB}'=>$this->module_ptr->Lang('help_tab'),
		);
	}

	public function SetAttributes($attrArray)
	{
		$this->Attrs = array_merge($this->Attrs,$attrArray);
	}

	public function SetTemplate($template)
	{
		$this->Attrs['form_template'] = $template;
		$this->module_ptr->SetTemplate('fb_'.$this->Id,$template);
	}

	public function GetId()
	{
		return $this->Id;
	}

	public function SetId($id)
	{
		$this->Id = $id;
	}

	public function GetName()
	{
		return $this->Name;
	}

	public function GetFormState()
	{
		return $this->formState;
	}

	public function GetPageCount()
	{
		return $this->formTotalPages;
	}

	public function GetPageNumber()
	{
		return $this->Page;
	}

	public function PageBack()
	{
		$this->Page--;
	}

	public function SetName($name)
	{
		$this->Name = $name;
	}

	public function GetAlias()
	{
		return $this->Alias;
	}

	public function SetAlias($alias)
	{
		$this->Alias = $alias;
	}

	// dump params
	public function DebugDisplay($params=array())
	{
		$tmp = $this->module_ptr;
		$this->module_ptr = '[mdptr]';

		if (isset($params['FORM']))
		{
			$fpt = $params['FORM'];
			$params['FORM'] = '[form_pointer]';
		}

		$template_tmp = $this->GetAttr('form_template','');
		$this->SetAttr('form_template',strlen($template_tmp).' characters');
		$field_tmp = $this->Fields;
		$this->Fields = 'Field Array: '.count($field_tmp);
		debug_display($this);
		$this->SetAttr('form_template',$template_tmp);
		$this->Fields = $field_tmp;
		foreach($this->Fields as $fld)
		{
			$fld->DebugDisplay();
		}
		$this->module_ptr = $tmp;
	}


	public function SetAttr($attrname, $val)
	{
		$this->Attrs[$attrname] = $val;
	}

	public function GetAttr($attrname, $default="")
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

	public function GetFieldCount()
	{
		return count($this->Fields);
	}

	public function HasFieldNamed($name)
	{
		$ret = -1;
		foreach($this->Fields as $fld)
		{
			if ($fld->GetName() == $name)
			{
				$ret = $fld->GetId();
			}
		}
		return $ret;
	}

	public function AddTemplateVariable($name,$def)
	{
		$theKey = '{$'.$name.'}';
		$this->templateVariables[$theKey] = $def;
	}

	public function createSampleTemplateJavascript($fieldName='opt_email_template', $button_text='', $suffix='')
	{
		$fldAlias = preg_replace('/[^\w\d]/','_',$fieldName).$suffix;
		$jsCode = "<script type=\"text/javascript\">\n
/* <![CDATA[ */
function populate".$fldAlias."(formname)
{
	var fname = 'IDfbrp_".$fieldName."';
	$(formname[fname]).val(|TEMPLATE|).change();
}
/* ]]> */
</script>";
		$jsCode .= "<input type=\"button\" value=\"".
		$button_text."\" onclick=\"javascript:populate".$fldAlias."(this.form)\" />";
		return $jsCode;
	}

	public function fieldValueTemplate()
	{
		$mod = $this->module_ptr;
		$ret = '<table class="module_fb_legend"><tr><th colspan="2">'.$mod->Lang('help_variables_for_computation').'</th></tr>';
		$ret .= '<tr><th>'.$mod->Lang('help_php_variable_name').'</th><th>'.$mod->Lang('help_form_field').'</th></tr>';
		$odd = false;
		$others = $this->GetFields();
		for($i=0;$i<count($others);$i++)
		{
			// Removed by Stikki: BUT WHY?
			//if (!$others[$i]->HasMultipleFormComponents())
			//{
			$ret .= '<tr><td class="'.($odd?'odd':'even').'">$fld_'.$others[$i]->GetId().'</td><td class="'.($odd?'odd':'even').'">' .$others[$i]->GetName() . '</td></tr>';
			//}
			$odd = ! $odd;
		}
		return $ret;
	}

	function createSampleTemplate($htmlish=false,$email=true, $oneline=false,$header=false,$footer=false)
	{
		$mod = $this->module_ptr;
		$ret = "";

		if ($email)
		{
			if ($htmlish)
			{
				$ret .= "<h1>".$mod->Lang('email_default_template')."</h1>\n";
			}
			else
			{
				$ret .= $mod->Lang('email_default_template')."\n";
			}
			foreach($this->templateVariables as $thisKey=>$thisVal)
			{
				if ($htmlish)
				{
					$ret .= '<strong>'.$thisVal.'</strong>: '.$thisKey."<br />";
				}
				else
				{
					$ret .= $thisVal.': '.$thisKey;
				}
				$ret .= "\n";
			}
			if ($htmlish)
			{
				$ret .= "\n<hr />\n";
			}
			else
			{
				$ret .= "\n-------------------------------------------------\n";
			}
		}
		elseif (!$oneline)
		{
			if ($htmlish)
			{
				$ret .= '<h2>';
			}
			$ret .= $mod->Lang('thanks');
			if ($htmlish)
			{
				$ret .= '</h2>';
			}
		}
		elseif ($footer)
		{
			$ret .= '------------------------------------------\nEOF\n';
			return $ret;
		}

		$others = $this->GetFields();
		for($i=0;$i<count($others);$i++)
		{
			if ($others[$i]->DisplayInSubmission())
			{
				if ($others[$i]->GetAlias() != '')
				{
					$fldref = $others[$i]->GetAlias();
				}
				else
				{
					$fldref = 'fld_'. $others[$i]->GetId();
				}

				$ret .= '{if $'.$fldref.' != "" && $'.$fldref.' != "'.$this->GetAttr('unspecified',$mod->Lang('unspecified')).'" }';
				$fldref = '{$'.$fldref.'}';

				if ($htmlish)
				{
					$ret .= '<strong>'.$others[$i]->GetName() . '</strong>: ' . $fldref. "<br />";
				}
				elseif ($oneline && !$header)
				{
					$ret .= $fldref. '{$TAB}';
				}
				elseif ($oneline && $header)
				{
					$ret .= $others[$i]->GetName().'{$TAB}';
				}
				else
				{
					$ret .= $others[$i]->GetName() . ': ' .$fldref;
				}
				$ret .= "{/if}\n";
			}
		}

	 /* Stikki says: Don't see any use for this, correct me if i'm wrong.
	  if ($oneline)
	  {
	  $ret = substr($ret,0,strlen($ret) - 6). "\n";
	  }
	  */
		return $ret;
	}

	//  function AdminTemplateHelp($formDescriptor,$fields='opt_email_template',
	//  	$includeHTML=true, $includeText=true, $oneline = false, $headerName='')
	public function AdminTemplateHelp($formDescriptor,$fieldStruct)
	{
		$mod = $this->module_ptr;
		$ret = '<table class="module_fb_legend"><tr><th colspan="2">'.$mod->Lang('help_variables_for_template').'</th></tr>';
		$ret .= '<tr><th>'.$mod->Lang('help_variable_name').'</th><th>'.$mod->Lang('help_form_field').'</th></tr>';
		$odd = false;
		foreach($this->templateVariables as $thisKey=>$thisVal)
		{
			$ret .= '<tr><td class="'.($odd?'odd':'even').'">'.$thisKey.'</td><td class="'.($odd?'odd':'even').'">'.$thisVal.'</td></tr>';
			$odd = ! $odd;
		}

		$others = $this->GetFields();
		for($i=0;$i<count($others);$i++)
		{
			if ($others[$i]->DisplayInSubmission())
			{
				$ret .= '<tr><td class="'.($odd?'odd':'even').'">{$'.$others[$i]->GetVariableName().'} / {$fld_'.$others[$i]->GetId().'}';
				if ($others[$i]->GetAlias() != '')
				{
					$ret .= ' / {$'.$others[$i]->GetAlias().'}';
				}
				$ret .= '</td><td class="'.($odd?'odd':'even').'">' .$others[$i]->GetName() . '</td></tr>';
				$odd = ! $odd;
			}
		}

		$ret .= '<tr><td colspan="2">'.$mod->Lang('help_array_fields').'</td></tr>';
		$ret .= '<tr><td colspan="2">'.$mod->Lang('help_other_fields').'</td></tr>';

		$sampleTemplateCode = '';
		foreach ($fieldStruct as $key=>$val)
		{
			$html_button = (isset($val['html_button']) && $val['html_button']);
			$text_button = (isset($val['text_button']) && $val['text_button']);
			$is_oneline = (isset($val['is_oneline']) && $val['is_oneline']);
			$is_email = (isset($val['is_email']) && $val['is_email']);
			$is_header = (isset($val['is_header']) && $val['is_header']);
			$is_footer = (isset($val['is_footer']) && $val['is_footer']);

			if ($html_button)
			{
				$button_text = $mod->Lang('title_create_sample_html_template');
			}
			elseif ($is_header)
			{
				$button_text = $mod->Lang('title_create_sample_header_template');
			}
			elseif ($is_footer)
			{
				$button_text = $mod->Lang('title_create_sample_footer_template');
			}
			else
			{
				$button_text = $mod->Lang('title_create_sample_template');
			}

			if ($html_button && $text_button)
			{
				$sample = $this->createSampleTemplate(false, $is_email, $is_oneline, $is_header, $is_footer);
				$sample = preg_replace('/\'/',"\\'",$sample);
				$sample = preg_replace('/\n/',"\\n'+\n'", $sample);
				$sampleTemplateCode .= preg_replace('/\|TEMPLATE\|/',"'".$sample."'",
				$this->createSampleTemplateJavascript($key, $mod->Lang('title_create_sample_template'),'text'));
			}

			$sample = $this->createSampleTemplate($html_button,$is_email, $is_oneline,$is_header, $is_footer);
			$sample = preg_replace('/\'/',"\\'",$sample);
			$sample = preg_replace('/\n/',"\\n'+\n'", $sample);
			$sampleTemplateCode .= preg_replace('/\|TEMPLATE\|/',"'".$sample."'",
			$this->createSampleTemplateJavascript($key, $button_text));
		}

		$sampleTemplateCode = preg_replace('/ID/',$formDescriptor, $sampleTemplateCode);
		$ret .= '<tr><td colspan="2">'.$sampleTemplateCode.'</td></tr>';
		$ret .= '</table>';

		return $ret;
	}

	public function Validate()
	{
		// Foaly: this should call the fields' method Validate
		$validated = true;
		$message = array();
		$formPageCount=1;
		$valPage = $this->Page - 1;
		for($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->GetFieldType() == 'PageBreakField')
			{
				$formPageCount++;
			}
			if ($valPage != $formPageCount)
			{
				continue;
			}

			$deny_space_validation = ($this->module_ptr->GetPreference('blank_invalid','0') == '1');
			/*	  debug_display($this->Fields[$i]->GetName().' '.
			 ($this->Fields[$i]->HasValue() === false?'False':'true'));
			 if ($this->Fields[$i]->HasValue())
			 debug_display($this->Fields[$i]->GetValue());
			 */
			if (/*! $this->Fields[$i]->IsNonRequirableField() && */
			$this->Fields[$i]->IsRequired() &&
			$this->Fields[$i]->HasValue($deny_space_validation) === false)
			{
				array_push($message,
				$this->module_ptr->Lang('please_enter_a_value',$this->Fields[$i]->GetName()));
				$validated = false;
				$this->Fields[$i]->SetOption('is_valid',false);
				$this->Fields[$i]->validationErrorText = $this->module_ptr->Lang('please_enter_a_value',$this->Fields[$i]->GetName());
				$this->Fields[$i]->validated = false;
			}
			else if ($this->Fields[$i]->GetValue() != $this->module_ptr->Lang('unspecified'))
			{
				$res = $this->Fields[$i]->Validate();
				if ($res[0] != true)
				{
					array_push($message,$res[1]);
					$validated = false;
					$this->Fields[$i]->SetOption('is_valid',false);
				}
				else
				{
				$this->Fields[$i]->SetOption('is_valid',true);
				}
			}
			$usertagops = cmsms()->GetUserTagOperations();
			$udt = $this->GetAttr('validate_udt','');
			$unspec = $this->GetAttr('unspecified',$this->module_ptr->Lang('unspecified'));

			if( $validated == true && !empty($udt) && "-1" != $udt )
			{
				$parms = $params;
				$others = $this->GetFields();
				for($i=0;$i<count($others);$i++)
				{
					$replVal = '';
					if ($others[$i]->DisplayInSubmission())
					{
						$replVal = $others[$i]->GetHumanReadableValue();
						if ($replVal == '')
						{
							$replVal = $unspec;
						}
					}
					$name = $others[$i]->GetVariableName();
					$parms[$name] = $replVal;
					$id = $others[$i]->GetId();
					$parms['fld_'.$id] = $replVal;
					$alias = $others[$i]->GetAlias();
					if (!empty($alias))
					{
						$parms[$alias] = $replVal;
					}
				}
				$res = $usertagops->CallUserTag($udt,$parms);
				if ($res[0] != true)
				{
					array_push($message,$res[1]);
					$validated = false;
				}
			}
		}
		return array($validated, $message);
	}


	public function HasDisposition()
	{
		$hasDisp = false;
		for($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->IsDisposition())
			{
				$hasDisp = true;
			}
		}
		return $hasDisp;
	}

	// return an array: element 0 is true for success, false for failure
	// element 1 is an array of reasons, in the event of failure.
	public function Dispose($returnid,$suppress_email=false)
	{
		// first, we run all field methods that will modify other fields
		$computes = array();
		for($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->ModifiesOtherFields())
			{
				$this->Fields[$i]->ModifyOtherFields();
			}
			if ($this->Fields[$i]->ComputeOnSubmission())
			{
				$computes[$i] = $this->Fields[$i]->ComputeOrder();
			}
		}

		asort($computes);
		foreach($computes as $cKey=>$cVal)
		{
			$this->Fields[$cKey]->Compute();
		}

		$resArray = array();
		$retCode = true;
		// for each form disposition pseudo-field, dispose the form results
		for($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->IsDisposition() && $this->Fields[$i]->DispositionIsPermitted())
			{
				if (! ($suppress_email && $this->Fields[$i]->IsEmailDisposition()))
				{
					$res = $this->Fields[$i]->DisposeForm($returnid);
					if ($res[0] == false)
					{
						$retCode = false;
						array_push($resArray,$res[1]);
					}
				}
			}
		}

		// handle any last cleanup functions
		for($i=0;$i<count($this->Fields);$i++)
		{
			$this->Fields[$i]->PostDispositionAction();
		}
		return array($retCode,$resArray);
	}

	public function RenderFormHeader()
	{
		if ($this->module_ptr->GetPreference('show_version',0) == 1)
		{
			return "\n<!-- Start FormBuilder Module (".$this->module_ptr->GetVersion().") -->\n";
		}
	}

	public function RenderFormFooter()
	{
		if ($this->module_ptr->GetPreference('show_version',0) == 1)
		{
			return "\n<!-- End FormBuilder Module -->\n";
		}
	}

	// returns a string.
	public function RenderForm($id, &$params, $returnid)
	{
		include(dirname(__FILE__) . '/../../../lib/replacement.php');

		// Check if form id given
		$mod = $this->module_ptr;
		if ($this->Id == -1)
		{
			return "<!-- no form -->\n";
		}
		 
		// Check if show full form
		if ($this->loaded != 'full')
		{
			$this->Load($this->Id,$params,true);
		}

		// Usual crap
		$reqSymbol = $this->GetAttr('required_field_symbol','*');

		$mod->smarty->assign('title_page_x_of_y',$mod->Lang('title_page_x_of_y',array($this->Page,$this->formTotalPages)));

		$mod->smarty->assign('css_class',$this->GetAttr('css_class',''));
		$mod->smarty->assign('total_pages',$this->formTotalPages);
		$mod->smarty->assign('this_page',$this->Page);
		$mod->smarty->assign('form_name',$this->Name);
		$mod->smarty->assign('form_id',$this->Id);
		$mod->smarty->assign('actionid',$id);

		// Build hidden
		$hidden = $mod->CreateInputHidden($id, 'form_id', $this->Id);
		if (isset($params['lang']))
		{
			$hidden .= $mod->CreateInputHidden($id, 'lang', $params['lang']);
		}
		$hidden .= $mod->CreateInputHidden($id, 'fbrp_continue', ($this->Page + 1));
		if (isset($params['fbrp_browser_id']))
		{
			$hidden .= $mod->CreateInputHidden($id,'fbrp_browser_id',$params['fbrp_browser_id']);
		}
		if (isset($params['response_id']))
		{
			$hidden .= $mod->CreateInputHidden($id,'response_id',$params['response_id']);
		}
		if ($this->Page > 1)
		{
			$hidden .= $mod->CreateInputHidden($id, 'fbrp_previous', ($this->Page - 1));
		}
		if ($this->Page == $this->formTotalPages)
		{
			$hidden .= $mod->CreateInputHidden($id, 'fbrp_done', 1);
		}

		// Start building fields
		$fields = array();
		$prev = array();
		$formPageCount = 1;

		for ($i=0; $i < count($this->Fields); $i++)
		{
			$thisField = &$this->Fields[$i];

			if ($thisField->GetFieldType() == 'PageBreakField')
			{
				$formPageCount++;
			}
			if ($formPageCount != $this->Page)
			{
				$testIndex = 'value_'.$this->Fields[$i]->GetAlias();
				if (isset($params[$testIndex]))
				{
					$hidden .= $mod->CreateInputHidden($id, $testIndex, $this->unmy_htmlentities($params[$testIndex]));
				}
				$testIndex = 'value_fld'.$this->Fields[$i]->GetId();
				if (isset($params[$testIndex]))
				{
					$hidden .= $mod->CreateInputHidden($id, $testIndex, $this->unmy_htmlentities($params[$testIndex]));
				}

				$testIndex = 'fbrp__'.$this->Fields[$i]->GetId();

				// Ryan's ugly fix for Bug 4307
				// We should figure out why this field wasn't populating its Smarty variable
				if ($thisField->GetFieldType() == 'FileUploadField')
				{
					$mod->smarty->assign('fld_'.$thisField->GetId(),$thisField->GetHumanReadableValue());
					$hidden .= $mod->CreateInputHidden($id,$testIndex,$this->unmy_htmlentities($thisField->GetHumanReadableValue()));
					$thisAtt = $thisField->GetHumanReadableValue(false);
					$mod->smarty->assign('test_'.$thisField->GetId(), $thisAtt);
					$mod->smarty->assign('value_fld'.$thisField->GetId(), $thisAtt[0]);
				}

				if (isset($params[$testIndex]) && is_array($params[$testIndex]))
				{
					foreach ($params[$testIndex] as $val)
					{
						$hidden .= $mod->CreateInputHidden($id,$testIndex.'[]',$this->unmy_htmlentities($val));
					}
				}
				elseif (isset($params[$testIndex]))
				{
					$hidden .= $mod->CreateInputHidden($id,$testIndex,$this->unmy_htmlentities($params[$testIndex]));
				}

				if ($formPageCount < $this->Page && $this->Fields[$i]->DisplayInSubmission())
				{
					$oneset = new stdClass();
					$oneset->value = $this->Fields[$i]->GetHumanReadableValue();

					$mod->smarty->assign($this->Fields[$i]->GetName(),$oneset);

					if ($this->Fields[$i]->GetAlias() != '')
					{
						$mod->smarty->assign($this->Fields[$i]->GetAlias(),$oneset);
					}

					array_push($prev,$oneset);
				}
				continue;
			}
			$oneset = new stdClass();
			$oneset->display = $thisField->DisplayInForm()?1:0;
			$oneset->required = $thisField->IsRequired()?1:0;
			$oneset->required_symbol = $thisField->IsRequired()?$reqSymbol:'';
			$oneset->css_class = $thisField->GetOption('css_class');
			$oneset->helptext = $thisField->GetOption('helptext');
			$oneset->field_helptext_id = 'fbrp_ht_'.$thisField->GetID();
			//	$oneset->valid = $thisField->GetOption('is_valid',true)?1:0;
			$oneset->valid = $thisField->IsValid();
			$oneset->error = $thisField->GetOption('is_valid',true)?'':$thisField->validationErrorText;
			$oneset->hide_name = 0;
			if( ((!$thisField->HasLabel()) || $thisField->HideLabel()) && ($thisField->GetOption('fbr_edit','0') == '0' || $params['in_admin'] != 1) )
			{
				$oneset->hide_name = 1;
			}
			$oneset->has_label = $thisField->HasLabel();
			$oneset->needs_div = $thisField->NeedsDiv();
			$oneset->name = $thisField->GetName();
			$oneset->input = $thisField->GetFieldInput($id, $params, $returnid);
			$oneset->logic = $thisField->GetFieldLogic();
			$oneset->values = $thisField->GetAllHumanReadableValues();
			$oneset->smarty_eval = $thisField->GetSmartyEval()?1:0;

			$oneset->multiple_parts = $thisField->HasMultipleFormComponents()?1:0;
			$oneset->label_parts = $thisField->LabelSubComponents()?1:0;
			$oneset->type = $thisField->GetDisplayType();
			$oneset->input_id = $thisField->GetCSSId();

			// Added by Stikki STARTS
			$name_alias = $thisField->GetName();
			$name_alias = str_replace($toreplace, $replacement, $name_alias);
			$name_alias = strtolower($name_alias);
			$name_alias = preg_replace('/[^a-z0-9]+/i','_',$name_alias);

			$mod->smarty->assign($name_alias,$oneset);
			// Added by Stikki ENDS

			if ($thisField->GetAlias() != '')
			{
				$mod->smarty->assign($thisField->GetAlias(),$oneset);
				$oneset->alias = $thisField->GetAlias();
			}
			else
			{
				$oneset->alias = $name_alias;
			}

			$fields[$oneset->input_id] = $oneset;
			//array_push($fields,$oneset);
		}
		 
		$mod->smarty->assign_by_ref('fb_hidden',$hidden);
		$mod->smarty->assign_by_ref('fields',$fields);
		$mod->smarty->assign_by_ref('previous',$prev);

		$jsStr = '';
		$jsTrigger = '';
		if ($this->GetAttr('input_button_safety','0') == '1')
		{
			$jsStr = '<script type="text/javascript">
	/* <![CDATA[ */
    var submitted = 0;
    function LockButton ()
       {
       var ret = false;
       if ( ! submitted )
          {
           var item = document.getElementById("'.$id.'fbrp_submit");
           if (item != null)
             {
             setTimeout(function() {item.disabled = true}, 0);
             }
           submitted = 1;
           ret = true;
          }
        return ret;
        }
/* ]]> */
</script>';
			$jsTrigger = " onclick='return LockButton()'";
		}

		$js = $this->GetAttr('submit_javascript');

		if ($this->Page > 1)
		{
			$mod->smarty->assign('prev','<input class="cms_submit fbsubmit_prev" name="'.$id.'fbrp_prev" id="'.$id.'fbrp_prev" value="'.$this->GetAttr('prev_button_text').'" type="submit" '.$js.' />');
		}
		else
		{
			$mod->smarty->assign('prev','');
		}

		$mod->smarty->assign('has_captcha','0');
		if ($this->Page < $formPageCount)
		{

			$mod->smarty->assign('submit','<input class="cms_submit fbsubmit_next" name="'.$id.'fbrp_submit" id="'.$id.'fbrp_submit" value="'.$this->GetAttr('next_button_text').'" type="submit" '.$js.' />');
		}
		else
		{
			$captcha = $mod->getModuleInstance('Captcha');
			if ($this->GetAttr('use_captcha','0')== '1' && $captcha != null)
			{
				$mod->smarty->assign('graphic_captcha',$captcha->getCaptcha());
				$mod->smarty->assign('title_captcha',$this->GetAttr('title_user_captcha',$mod->Lang('title_user_captcha')));
				$mod->smarty->assign('input_captcha',$mod->CreateInputText($id, 'fbrp_captcha_phrase',''));
				$mod->smarty->assign('has_captcha','1');
			}
				
			$mod->smarty->assign('submit','<input class="cms_submit fbsubmit" name="'.$id.'fbrp_submit" id="'.$id.'fbrp_submit" value="'.$this->GetAttr('submit_button_text').'" type="submit" '.$js.' />');
		}

		return $mod->ProcessTemplateFromDatabase('fb_'.$this->Id);
	}

	public function LoadForm($loadDeep=false)
	{
		return $this->Load($this->Id, array(), $loadDeep);
	}

	public function unmy_htmlentities($val)
	{
		if ($val == "")
		{
			return "";
		}
		$val = html_entity_decode($val);
		$val = str_replace("&amp;","&",$val);
		$val = str_replace("&#60;&#33;--","<!--",$val);
		$val = str_replace("--&#62;","-->",$val);
		$val = str_replace("&gt;",">", $val);
		$val = str_replace("&lt;","<",$val);
		$val = str_replace("&quot;","\"",$val);
		$val = str_replace("&#036;","\$",$val);
		$val = str_replace("&#33;","!",$val);
		$val = str_replace("&#39;","'",$val);

		// Uncomment if you need to convert unicode chars
		return $val;
	}

	public function Load($formId, &$params, $loadDeep=false, $loadResp=false)
	{

		$mod = $this->module_ptr;

		//error_log("entering Form Load with usage ".memory_get_usage());
		$sql = 'SELECT * FROM '.cms_db_prefix().'module_fb_form WHERE form_id=?';
		$rs = $this->module_ptr->dbHandle->Execute($sql, array($formId));
		if($rs && $rs->RecordCount() > 0)
		{
			$result = $rs->FetchRow();
			$this->Id = $result['form_id'];
			if (!isset($params['fbrp_form_name']) || empty($params['fbrp_form_name']))
			{
				$this->Name = $result['name'];
			}
			if (!isset($params['fbrp_form_alias']) || empty($params['fbrp_form_alias']))
			{
				$this->Alias = $result['alias'];
			}
		}
		else
		{
			return false;
		}
		$sql = 'SELECT name,value FROM '.cms_db_prefix().'module_fb_form_attr WHERE form_id=?';
		$rs = $this->module_ptr->dbHandle->Execute($sql, array($formId));
		while ($rs && $result=$rs->FetchRow())
		{
			$this->Attrs[$result['name']] = $result['value'];
		}

		$this->loaded = 'summary';

		if (isset($params['response_id']))
		{
			$loadDeep = true;
			$loadResp = true;
		}

		if ($loadDeep)
		{
			if ($loadResp)
			{
				// if it's a stored form, load the results -- but we need to manually merge them,
				// since $params[] should override the database value (say we're resubmitting a form)
				$fbf = $mod->GetFormBrowserField($formId);
				if ($fbf != false)
				{
					// if we're binding to FEU, get the FEU ID, see if there's a response for
					// that user. If so, load it. Otherwise, bring up an empty form.
					if ($fbf->GetOption('feu_bind','0')=='1')
					{
						$feu = $mod->GetModuleInstance('FrontEndUsers');
						if ($feu == false)
						{
							debug_display("FAILED to instatiate FEU!");
							return;
						}
						if (!isset($_COOKIE['cms_admin_user_id']))
						{
							// Fix for Bug 5422. Adapted from Mike Hughesdon's code.
							$response_id = $mod->GetResponseIDFromFEUID($feu->LoggedInId(), $formId);
							if ($response_id !== false)
							{
								$check = $this->module_ptr->dbHandle->GetOne('select count(*) from '.cms_db_prefix().'module_fb_formbrowser where fbr_id=?',array($response_id));
								if ($check == 1)
								{
									$params['response_id'] = $response_id;
								}
							}
						}
					}
				}
				if (isset($params['response_id']))
				{
					$loadParams = array('response_id'=>$params['response_id']);
					$loadTypes = array();
					$this->LoadResponseValues($loadParams, $loadTypes);
					foreach ($loadParams as $thisParamKey=>$thisParamValue)
					{
						if (! isset($params[$thisParamKey]))
						{
							if ($this->GetFormState() == 'update' && $loadTypes[$thisParamKey] == 'CheckboxField')
							{
								$params[$thisParamKey] = '';
							}
							else
							{
								$params[$thisParamKey] = $thisParamValue;
							}
						}
					}
				}
			}
			$sql = 'SELECT * FROM '.cms_db_prefix().'module_fb_field WHERE form_id=? ORDER BY order_by';
			$result = $this->module_ptr->dbHandle->GetArray($sql, array($formId));
			/*$result = array();
			if ($rs && $rs->RecordCount() > 0)
			{
		    	$result = $rs->GetArray();
		    }
		    */
			$fieldCount = 0;
			if (count($result) > 0)
			{
				foreach($result as $thisRes)
				{
					//error_log("Instantiating Field. usage ".memory_get_usage());
			    	// create the field object
			    	if ((isset($thisRes['field_id']) && (isset($params['fbrp__'.$thisRes['field_id']]) || isset($params['fbrp___'.$thisRes['field_id']]))) ||
					    (isset($thisRes['field_id']) && isset($params['value_'.$thisRes['name']])) || (isset($thisRes['field_id']) && isset($params['value_fld'.$thisRes['field_id']])) ||
					    (isset($params['field_id']) && isset($thisRes['field_id']) && $params['field_id'] == $thisRes['field_id']))
				    {
				    	$thisRes = array_merge($thisRes,$params);
				    }
				    $this->Fields[$fieldCount] = $this->NewField($thisRes);
				    $fieldCount++;
			    }
			}
			$this->loaded = 'full';
		}

		for ($i=0; $i < count($this->Fields); $i++)
		{
			if ($this->Fields[$i]->Type == 'PageBreakField')
			{
				$this->formTotalPages++;
			}
		}

		return true;
	}

	/* notable params:
	 fbrp_xml_file -- source file for the XML
	 xml_string -- source string for the XML
	 */
	public function ImportXML(&$params)
	{
		// xml_parser_create, xml_parse_into_struct
		$parser = xml_parser_create('');
		xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
		xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 0 ); // was 1
		if (isset($params['fbrp_xml_file']) && ! empty($params['fbrp_xml_file']))
		{
			xml_parse_into_struct($parser, file_get_contents($params['fbrp_xml_file']), $values);
		}
		elseif (isset($params['xml_string']) && ! empty($params['xml_string']))
		{
			xml_parse_into_struct($parser, $params['xml_string'], $values);
		}
		else
		{
			return false;
		}
		xml_parser_free($parser);
		$elements = array();
		$stack = array();
		$fieldMap = array();
		foreach ( $values as $tag )
		{
			$index = count( $elements );
			if ( $tag['type'] == "complete" || $tag['type'] == "open" )
			{
				$elements[$index] = array();
				$elements[$index]['name'] = $tag['tag'];
				$elements[$index]['attributes'] = empty($tag['attributes']) ? "" : $tag['attributes'];
				$elements[$index]['content']    = empty($tag['value']) ? "" : $tag['value'];
				if ( $tag['type'] == "open" )
				{
					# push
					$elements[$index]['children'] = array();
					$stack[count($stack)] = &$elements;
					$elements = &$elements[$index]['children'];
				}
			}
			if ( $tag['type'] == "close" )
			{    # pop
				$elements = &$stack[count($stack) - 1];
				unset($stack[count($stack) - 1]);
			}
		}
		//debug_display($elements);
		if (!isset($elements[0]) || !isset($elements[0]) || !isset($elements[0]['attributes']))
		{
			//parsing failed, or invalid file.
			return false;
		}
		$params['form_id'] = -1; // override any form_id values that may be around
		$formAttrs = &$elements[0]['attributes'];

		if (isset($params['fbrp_import_formalias']) && !empty($params['fbrp_import_formalias']))
		{
			$this->SetAlias($params['fbrp_import_formalias']);
		}
		else if ($this->inXML($formAttrs['alias']))
		{
			$this->SetAlias($formAttrs['alias']);
		}
		if (isset($params['fbrp_import_formname']) && !empty($params['fbrp_import_formname']))
		{
			$this->SetName($params['fbrp_import_formname']);
		}
		$foundfields = false;
		// populate the attributes and field name first. When we see a field, we save the form and then start adding the fields to it.

		foreach ($elements[0]['children'] as $thisChild)
		{
			if ($thisChild['name'] == 'form_name')
			{
				$curname =  $this->GetName();
				if (empty($curname))
				{
					$this->SetName($thisChild['content']);
				}
			}
			elseif ($thisChild['name'] == 'attribute')
			{
				$this->SetAttr($thisChild['attributes']['key'], $thisChild['content']);
			}
			else
			{
				// we got us a field
				if (! $foundfields)
				{
					// first field
					$foundfields = true;
					if( isset($params['fbrp_import_formname']) && trim($params['fbrp_import_formname']) != '')
					{
						$this->SetName(trim($params['fbrp_import_formname']));
					}
					if( isset($params['fbrp_import_formalias']) && trim($params['fbrp_import_formname']) != '')
					{
						$this->SetAlias(trim($params['fbrp_import_formalias']));
					}
					$this->Store();
					$params['form_id'] = $this->GetId();
				}
				//debug_display($thisChild);
				$fieldAttrs = &$thisChild['attributes'];
				$className = $this->MakeClassName($fieldAttrs['type'], '');
				//debug_display($className);
				$newField = new $className($this, $params);
				$oldId = $fieldAttrs['id'];

				if ($this->inXML($fieldAttrs['alias']))
				{
					$newField->SetAlias($fieldAttrs['alias']);
				}
				$newField->SetValidationType($fieldAttrs['validation_type']);
				if ($this->inXML($fieldAttrs['order_by']))
				{
					$newField->SetOrder($fieldAttrs['order_by']);
				}
				if ($this->inXML($fieldAttrs['required']))
				{
					$newField->SetRequired($fieldAttrs['required']);
				}
				if ($this->inXML($fieldAttrs['hide_label']))
				{
					$newField->SetHideLabel($fieldAttrs['hide_label']);
				}
				foreach ($thisChild['children'] as $thisOpt)
				{
					if ($thisOpt['name'] == 'field_name')
					{
						$newField->SetName($thisOpt['content']);
					}
					if ($thisOpt['name'] == 'options')
					{
						foreach ($thisOpt['children'] as $thisOption)
						{
							$newField->OptionFromXML($thisOption);
						}
					}
				}
				$newField->Store(true);
				array_push($this->Fields,$newField);
				$fieldMap[$oldId] = $newField->GetId();
			}
		}

		// clean up references
		if (isset($params['fbrp_xml_file']) && ! empty($params['fbrp_xml_file']))
		{
			// need to update mappings in templates.
			$tmp = $this->updateRefs($this->GetAttr('form_template',''), $fieldMap);
			$this->SetAttr('form_template',$tmp);
			$tmp = $this->updateRefs($this->GetAttr('submit_response',''), $fieldMap);
			$this->SetAttr('submit_response',$tmp);

			// need to update mappings in field templates.
			$options = array('email_template','file_template');
			foreach($this->Fields as $fid=>$thisField)
			{
				$changes = false;
				foreach ($options as $to)
				{
					$templ = $thisField->GetOption($to,'');
					if (!empty($templ))
					{
						$tmp = $this->updateRefs($templ, $fieldMap);
						$thisField->SetOption($to,$tmp);
						$changes = true;
					}
				}
				// need to update mappings in FormBrowser sort fields
				if ($thisField->GetFieldType() == 'DispositionFormBrowser')
				{
					for ($i=1;$i<6;$i++)
					{
						$old = $thisField->GetOption('sortfield'.$i);
						if (isset($fieldMap[$old]))
						{
							$thisField->SetOption('sortfield'.$i,$fieldMap[$old]);
							$changes = true;
						}
					}
				}
				if ($changes)
				{
					$thisField->Store(true);
				}
			}
			 
			$this->Store();
		}

		return true;
	}

	public function updateRefs($text, &$fieldMap)
	{
		foreach ($fieldMap as $k=>$v)
		{
			$text = preg_replace('/([\{\b\s])\$fld_'.$k.'([\}\b\s])/','$1\$fld_'.$v.'$2',$text);
		}
		return $text;
	}

	public function inXML(&$var)
	{
		if (isset($var) && strlen($var) > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// storeDeep also stores all fields and options for a form
	public function Store($storeDeep=false)
	{

		$db = $this->module_ptr->dbHandle;
		$params = $this->module_params;

		// Check if new or old form
		if ($this->Id == -1) {

			$this->Id = $db->GenID(cms_db_prefix().'module_fb_form_seq');
			$sql = "INSERT INTO ".cms_db_prefix()."module_fb_form (form_id, name, alias) VALUES (?, ?, ?)";
			$res = $db->Execute($sql, array($this->Id, $this->Name, $this->Alias));
		} else {

			$sql = "UPDATE ".cms_db_prefix()."module_fb_form set name=?, alias=? where form_id=?";
			$res = $db->Execute($sql, array($this->Name, $this->Alias, $this->Id));
		}
		 
		// Save out the attrs
		$sql = "DELETE FROM ".cms_db_prefix()."module_fb_form_attr WHERE form_id=?";
		$res = $db->Execute($sql, array($this->Id));

		foreach ($this->Attrs as $thisAttrKey=>$thisAttrValue) {

			$formAttrId = $db->GenID(cms_db_prefix().'module_fb_form_attr_seq');
			$sql = "INSERT INTO ".cms_db_prefix()."module_fb_form_attr (form_attr_id, form_id, name, value) VALUES (?, ?, ?, ?)";
			$res = $db->Execute($sql, array($formAttrId, $this->Id, $thisAttrKey, $thisAttrValue));

			if ($thisAttrKey == 'form_template') {

				$this->module_ptr->SetTemplate('fb_'.$this->Id,$thisAttrValue);
			}
		}

		// Update field position
		$order_list = false;
		if (isset($params['fbrp_sort']))
		{
			$order_list = explode(',',$params['fbrp_sort']);
		}

		if(is_array($order_list) && count($order_list) > 0) {

			$count = 1;
			$sql = "UPDATE ".cms_db_prefix()."module_fb_field SET order_by=? WHERE field_id=?";

			foreach ($order_list as $onefldid) {

				$fieldid = substr($onefldid,5);
				$db->Execute($sql, array($count, $fieldid));
				$count++;
			}
		}

		// Reload everything
		$this->Load($this->Id,$params,true);

		return $res;
}

	public function Delete()
	{
		if ($this->Id == -1)
		{
			return false;
		}
		if ($this->loaded != 'full')
		{
			$this->Load($this->Id,array(),true);
		}
		foreach ($this->Fields as $field)
		{
			$field->Delete();
		}
		$this->module_ptr->DeleteTemplate('fb_'.$this->Id);
		$sql = 'DELETE FROM ' . cms_db_prefix() . 'module_fb_form where form_id=?';
		$res = $this->module_ptr->dbHandle->Execute($sql, array($this->Id));
		$sql = 'DELETE FROM ' . cms_db_prefix() . 'module_fb_form_attr where form_id=?';
		$res = $this->module_ptr->dbHandle->Execute($sql, array($this->Id));
		return true;
	}

	// returns a class name, and makes sure the file where the class is
	// defined has been loaded.
	public function MakeClassName($type, $classDirPrefix)
	{
		// perform rudimentary security, since Type could come in from a form
		$type = preg_replace("/[\W]|\.\./", "_", $type);
		if ($type == '' || strlen($type) < 1)
		{
			$type = 'Field';
		}
		$classFile='';
		if (strlen($classDirPrefix) > 0)
		{
			$classFile = $classDirPrefix .'/'.$type.'.class.php';
		}
		else
		{
			$classFile = $type.'.class.php';
		}
		require_once cms_join_path(dirname(__FILE__), $classFile);
		// class names are prepended with "fb" to prevent namespace clash.
		return ( 'fb'.$type );
	}

	public function AddEditForm($id, $returnid, $tab, $message='')
	{
		$mod = $this->module_ptr;
		$config = $mod->GetConfig();

		if(!empty($message))
		{
			$mod->smarty->assign('message',$mod->ShowMessage($message));
		}
		$mod->smarty->assign('formstart', $mod->CreateFormStart($id, 'admin_store_form', $returnid));
		$mod->smarty->assign('formid', $mod->CreateInputHidden($id, 'form_id', $this->Id));
		$mod->smarty->assign('tab_start',$mod->StartTabHeaders().
			$mod->SetTabHeader('maintab',$mod->Lang('tab_main'),('maintab' == $tab)?true:false).
			$mod->SetTabHeader('submittab',$mod->Lang('tab_submit'),('submittab' == $tab)?true:false).
			$mod->SetTabHeader('symboltab',$mod->Lang('tab_symbol'),('symboltab' == $tab)?true:false).
			$mod->SetTabHeader('captchatab',$mod->Lang('tab_captcha'),('captchatab' == $tab)?true:false).
			$mod->SetTabHeader('udttab',$mod->Lang('tab_udt'),('udttab' == $tab)?true:false).
			$mod->SetTabHeader('templatelayout',$mod->Lang('tab_templatelayout'),('templatelayout' == $tab)?true:false).
			$mod->SetTabHeader('submittemplate',$mod->Lang('tab_submissiontemplate'),('submittemplate' == $tab)?true:false).
			$mod->EndTabHeaders() . $mod->StartTabContent());

		$mod->smarty->assign('tabs_end',$mod->EndTabContent());
		$mod->smarty->assign('maintab_start',$mod->StartTab("maintab"));
		$mod->smarty->assign('submittab_start',$mod->StartTab("submittab"));
		$mod->smarty->assign('symboltab_start',$mod->StartTab("symboltab"));
		$mod->smarty->assign('udttab_start',$mod->StartTab("udttab"));
		$mod->smarty->assign('templatetab_start',$mod->StartTab("templatelayout"));
		$mod->smarty->assign('submittemplatetab_start',$mod->StartTab("submittemplate"));
		$mod->smarty->assign('captchatab_start',$mod->StartTab("captchatab"));
		$mod->smarty->assign('tab_end',$mod->EndTab());
		$mod->smarty->assign('form_end',$mod->CreateFormEnd());
		$mod->smarty->assign('title_form_name',$mod->Lang('title_form_name'));
		$mod->smarty->assign('input_form_name', $mod->CreateInputText($id, 'fbrp_form_name', $this->Name, 50));

		$mod->smarty->assign('title_load_template',$mod->Lang('title_load_template'));
		$modLink = $mod->CreateLink($id, 'admin_get_template', $returnid, '', array(), '', true);
		$mod->smarty->assign('security_key',CMS_SECURE_PARAM_NAME.'='.$_SESSION[CMS_USER_KEY]);

		$templateList = array(
			''=>'',
			$mod->Lang('default_template')=>'RenderFormDefault.tpl',
			$mod->Lang('table_left_template')=>'RenderFormTableTitleLeft.tpl',
			$mod->Lang('table_top_template')=>'RenderFormTableTitleTop.tpl'
		);

		$allForms = $mod->GetForms();
		foreach ($allForms as $thisForm)
		{
			if ($thisForm['form_id'] != $this->Id)
			{
				$templateList[$mod->Lang('form_template_name',$thisForm['name'])] = $thisForm['form_id'];
			}
		}

		$mod->smarty->assign('input_load_template',$mod->CreateInputDropdown($id,
			'fbrp_fb_template_load', $templateList, -1, '', 'id="fb_template_load" onchange="jQuery(this).fb_get_template(\''.
			$mod->Lang('template_are_you_sure').'\',\''.$modLink.'\');"'));
		$mod->smarty->assign('help_template_variables',$mod->Lang('template_variable_help'));
		$mod->smarty->assign('title_form_unspecified',$mod->Lang('title_form_unspecified'));
		$mod->smarty->assign('input_form_unspecified',
		$mod->CreateInputText($id, 'fbrp_forma_unspecified',$this->GetAttr('unspecified',$mod->Lang('unspecified')), 50));
		$mod->smarty->assign('title_form_status',$mod->Lang('title_form_status'));
		$mod->smarty->assign('text_ready',$mod->Lang('title_ready_for_deployment'));
		$mod->smarty->assign('title_form_alias',$mod->Lang('title_form_alias'));
		$mod->smarty->assign('input_form_alias',$mod->CreateInputText($id, 'fbrp_form_alias',$this->Alias, 50));
		$mod->smarty->assign('title_form_css_class',$mod->Lang('title_form_css_class'));
		$mod->smarty->assign('input_form_css_class',
			$mod->CreateInputText($id, 'fbrp_forma_css_class',$this->GetAttr('css_class','formbuilderform'), 50,50));
		$mod->smarty->assign('title_form_fields',$mod->Lang('title_form_fields'));
		$mod->smarty->assign('title_form_main',$mod->Lang('title_form_main'));
		if( $mod->GetPreference('show_fieldids',0) != 0 )
		{
			$mod->smarty->assign('title_field_id',
			$mod->Lang('title_field_id'));
		}
		if( $mod->GetPreference('show_fieldaliases',1) != 0 )
		{
			$mod->smarty->assign('title_field_alias',
			$mod->Lang('title_field_alias_short'));
		}

		$mod->smarty->assign('back', $mod->CreateLink($id, 'defaultadmin', '', $mod->Lang('back_top'), array()));

		$mod->smarty->assign('title_field_name', $mod->Lang('title_field_name'));
		$mod->smarty->assign('title_field_type', $mod->Lang('title_field_type'));
		$mod->smarty->assign('title_field_type', $mod->Lang('title_field_type'));
		$mod->smarty->assign('title_form_template', $mod->Lang('title_form_template'));
		$mod->smarty->assign('title_list_delimiter', $mod->Lang('title_list_delimiter'));
		$mod->smarty->assign('title_redirect_page', $mod->Lang('title_redirect_page'));

		$mod->smarty->assign('title_submit_action', $mod->Lang('title_submit_action'));
		$mod->smarty->assign('title_submit_response', $mod->Lang('title_submit_response'));
		$mod->smarty->assign('title_must_save_order', $mod->Lang('title_must_save_order'));


		$mod->smarty->assign('title_inline_form', $mod->Lang('title_inline_form'));

		$mod->smarty->assign('title_submit_actions', $mod->Lang('title_submit_actions'));
		$mod->smarty->assign('title_submit_labels', $mod->Lang('title_submit_labels'));
		$mod->smarty->assign('title_submit_javascript', $mod->Lang('title_submit_javascript'));
		$mod->smarty->assign('title_submit_help',
			$mod->cms->variables['admintheme']->DisplayImage('icons/system/info.gif','true','','','systemicon'). $mod->Lang('title_submit_help'));
		$mod->smarty->assign('title_submit_response_help',
			$mod->cms->variables['admintheme']->DisplayImage('icons/system/info.gif','true','','','systemicon'). $mod->Lang('title_submit_response_help'));

		$submitActions = array($mod->Lang('display_text')=>'text', $mod->Lang('redirect_to_page')=>'redir');
		$mod->smarty->assign('input_submit_action',
			$mod->CreateInputRadioGroup($id, 'fbrp_forma_submit_action', $submitActions, $this->GetAttr('submit_action','text')));

		$captcha = $mod->getModuleInstance('Captcha');
		if ($captcha == null)
		{
			$mod->smarty->assign('title_install_captcha',
			$mod->Lang('title_captcha_not_installed'));
			$mod->smarty->assign('captcha_installed',0);
		}
		else
		{
			$mod->smarty->assign('title_use_captcha', $mod->Lang('title_use_captcha'));
			$mod->smarty->assign('captcha_installed',1);

			$mod->smarty->assign('input_use_captcha',$mod->CreateInputHidden($id,'fbrp_forma_use_captcha','0').
				$mod->CreateInputCheckbox($id,'fbrp_forma_use_captcha','1',$this->GetAttr('use_captcha','0')).
				$mod->Lang('title_use_captcha_help'));
		}
		$mod->smarty->assign('title_information',$mod->Lang('information'));
		$mod->smarty->assign('title_order',$mod->Lang('order'));
		$mod->smarty->assign('title_field_required_abbrev',$mod->Lang('title_field_required_abbrev'));
		$mod->smarty->assign('hasdisposition',$this->HasDisposition()?1:0);
		$maxOrder = 1;
		if($this->Id > 0)
		{
			$mod->smarty->assign('fb_hidden', $mod->CreateInputHidden($id, 'fbrp_form_op',$mod->Lang('updated')).
				$mod->CreateInputHidden($id, 'fbrp_sort','','class="fbrp_sort"') . $mod->CreateInputHidden($id, 'active_tab','','class="fbr_atab"'));
			$mod->smarty->assign('adding',0);
			$mod->smarty->assign('save_button', $mod->CreateInputSubmit($id, 'fbrp_submit', $mod->Lang('save')));
			$mod->smarty->assign('submit_button', $mod->CreateInputSubmit($id, 'fbrp_submit', $mod->Lang('save_and_continue'),'onclick="jQuery(this).fb_set_tab()"'));

			$fieldList = array();
			$currow = "row1";
			$count = 1;
			$last = $this->GetFieldCount();
			foreach ($this->Fields as $thisField)
			{
				$oneset = new stdClass();
				$oneset->rowclass = $currow;
				$oneset->name = $mod->CreateLink($id, 'admin_add_edit_field', '', $thisField->GetName(), array('field_id'=>$thisField->GetId(),'form_id'=>$this->Id));
				if( $mod->GetPreference('show_fieldids',0) != 0 )
				{
					$oneset->id = $mod->CreateLink($id, 'admin_add_edit_field', '', $thisField->GetId(), array('field_id'=>$thisField->GetId(),'form_id'=>$this->Id));
				}
				$oneset->type = $thisField->GetDisplayType();
				$oneset->alias = $thisField->GetAlias();
				$oneset->id = $thisField->GetID();

				if (!$thisField->DisplayInForm() || $thisField->IsNonRequirableField())
				{
					$no_avail = $mod->Lang('not_available');
					if($mod->cms->variables['admintheme']->themeName == 'NCleanGrey')
					{
						$oneset->disposition = '<img src="'.$config['root_url'].'/modules/'.$mod->GetName().'/images/stop.gif" width="20" height="20" alt="'.$no_avail.'" title="'.$no_avail.'" />';
					}
					else
					{
						$oneset->disposition = '<img src="'.$config['root_url'].'/modules/'.$mod->GetName().'/images/stop.gif" width="16" height="16" alt="'.$no_avail.'" title="'.$no_avail.'" />';
					}
				}
				elseif ($thisField->IsRequired())
				{
					$oneset->disposition = $mod->CreateLink($id, 'admin_update_field_required', '',
						$mod->cms->variables['admintheme']->DisplayImage('icons/system/true.gif','true','','','systemicon'),
						array('form_id'=>$this->Id,'fbrp_active'=>'off','field_id'=>$thisField->GetId()),'', '', '',
						'class="true" onclick="jQuery(this).fb_admin_update_field_required(); return false;"');
				}
				else
				{
					$oneset->disposition = $mod->CreateLink($id, 'admin_update_field_required', '',
						$mod->cms->variables['admintheme']->DisplayImage('icons/system/false.gif','false','','','systemicon'),
						array('form_id'=>$this->Id,'fbrp_active'=>'on','field_id'=>$thisField->GetId()),'', '', '',
						'class="false" onclick="jQuery(this).fb_admin_update_field_required(); return false;"');
				}

				$oneset->field_status = $thisField->StatusInfo();
				$oneset->editlink = $mod->CreateLink($id, 'admin_add_edit_field', '',
					$mod->cms->variables['admintheme']->DisplayImage('icons/system/edit.gif',$mod->Lang('edit'),'','','systemicon'),
					array('field_id'=>$thisField->GetId(),'form_id'=>$this->Id));
				$oneset->deletelink = $mod->CreateLink($id, 'admin_delete_field', '',
					$mod->cms->variables['admintheme']->DisplayImage('icons/system/delete.gif',$mod->Lang('delete'),'','','systemicon'),
					array('field_id'=>$thisField->GetId(),'form_id'=>$this->Id),'', '', '',
					'onclick="jQuery(this).fb_delete_field(\''.$mod->Lang('are_you_sure_delete_field',htmlspecialchars($thisField->GetName())).'\'); return false;"');

				/* Removed By Stikki, reinstated by SjG with Javascript to hide it if Javascript's enabled. */
				if ($count > 1)
				{
					$oneset->up = $mod->CreateLink($id, 'admin_update_field_order', '',
						$mod->cms->variables['admintheme']->DisplayImage('icons/system/arrow-u.gif','up','','','systemicon'),
						array('form_id'=>$this->Id,'fbrp_dir'=>'up','field_id'=>$thisField->GetId()));
				}
				else
				{
					$oneset->up = '&nbsp;';
				}
				if ($count < $last)
				{
					$oneset->down = $mod->CreateLink($id, 'admin_update_field_order', '',
						$mod->cms->variables['admintheme']->DisplayImage('icons/system/arrow-d.gif','down','','','systemicon'),
						array('form_id'=>$this->Id,'fbrp_dir'=>'down','field_id'=>$thisField->GetId()));
				}
				else
				{
					$oneset->down = '&nbsp;';
				}

				$currow = $currow == "row1" ? "row2" : "row1";
				$count++;
				if ($thisField->GetOrder() >= $maxOrder)
				{
					$maxOrder = $thisField->GetOrder() + 1;
				}
				array_push($fieldList, $oneset);
			}

			$mod->smarty->assign('fields',$fieldList);
			$mod->smarty->assign('add_field_link',
			$mod->CreateLink($id, 'admin_add_edit_field', $returnid,
				$mod->cms->variables['admintheme']->DisplayImage('icons/system/newobject.gif',$mod->Lang('title_add_new_field'),'','','systemicon'),
				array('form_id'=>$this->Id, 'fbrp_order_by'=>$maxOrder), '', false) . $mod->CreateLink($id, 'admin_add_edit_field', $returnid,$mod->Lang('title_add_new_field'),
				array('form_id'=>$this->Id, 'fbrp_order_by'=>$maxOrder), '', false));

			if ($mod->GetPreference('enable_fastadd',1) == 1)
			{
				$mod->smarty->assign('fastadd',1);
				$mod->smarty->assign('title_fastadd',$mod->Lang('title_fastadd'));
				$typeInput = "<script type=\"text/javascript\">
/* <![CDATA[ */
function fast_add(field_type)
{
	var type=field_type.options[field_type.selectedIndex].value;
	var link = '".$mod->CreateLink($id, 'admin_add_edit_field', $returnid,'',array('form_id'=>$this->Id, 'fbrp_order_by'=>$maxOrder), '', true,true)."&".$id."fbrp_field_type='+type;
	this.location=link;
	return true;
}
/* ]]> */
</script>";
				$typeInput = str_replace('&amp;','&',$typeInput);
				$mod->initialize();
				if ($mod->GetPreference('show_field_level','basic') == 'basic')
				{
					$mod->smarty->assign('input_fastadd',
						$typeInput.
						$mod->CreateInputDropdown($id, 'fbrp_field_type',array_merge(array($mod->Lang('select_type')=>''),$mod->std_field_types), -1,'', 'onchange="fast_add(this)"').
						$mod->Lang('title_switch_advanced').
						$mod->CreateLink($id, 'admin_add_edit_form', $returnid,$mod->Lang('title_switch_advanced_link'),array('form_id'=>$this->Id, 'fbrp_set_field_level'=>'advanced')));
				}
				else
				{
					$mod->smarty->assign('input_fastadd',
						$typeInput.
						$mod->CreateInputDropdown($id, 'fbrp_field_type',array_merge(array($mod->Lang('select_type')=>''),$mod->field_types), -1,'', 'onchange="fast_add(this)"').
						$mod->Lang('title_switch_basic').
						$mod->CreateLink($id, 'admin_add_edit_form', $returnid,$mod->Lang('title_switch_basic_link'),array('form_id'=>$this->Id, 'fbrp_set_field_level'=>'basic')));
				}
			}
		}
		else
		{
			$mod->smarty->assign('save_button','');
			$mod->smarty->assign('submit_button',
			$mod->CreateInputSubmit($id, 'fbrp_submit', $mod->Lang('add')));
			$mod->smarty->assign('fb_hidden',
			$mod->CreateInputHidden($id, 'fbrp_form_op',$mod->Lang('added')).$mod->CreateInputHidden($id, 'fbrp_sort','','id="fbrp_sort"'));
			$mod->smarty->assign('adding',1);
		}
		$mod->smarty->assign('cancel_button', $mod->CreateInputSubmit($id, 'fbrp_cancel', $mod->Lang('cancel')));
		$mod->smarty->assign('link_notready',
			"<strong>".$mod->Lang('title_not_ready1')."</strong> ".$mod->Lang('title_not_ready2')." ".
			$mod->CreateLink($id, 'admin_add_edit_field', $returnid,$mod->Lang('title_not_ready_link'),
			array('form_id'=>$this->Id, 'fbrp_order_by'=>$maxOrder,'fbrp_dispose_only'=>1), '', false, false,'class="module_fb_link"')." ".
			$mod->Lang('title_not_ready3'));
		 
		$mod->smarty->assign('input_inline_form',$mod->CreateInputHidden($id,'fbrp_forma_inline','0').
			$mod->CreateInputCheckbox($id,'fbrp_forma_inline','1',$this->GetAttr('inline','0')).$mod->Lang('title_inline_form_help'));

		$mod->smarty->assign('title_form_submit_button',$mod->Lang('title_form_submit_button'));
		$mod->smarty->assign('input_form_submit_button',
			$mod->CreateInputText($id, 'fbrp_forma_submit_button_text',$this->GetAttr('submit_button_text',$mod->Lang('button_submit')), 35, 35));
		$mod->smarty->assign('title_submit_button_safety',$mod->Lang('title_submit_button_safety_help'));
		$mod->smarty->assign('input_submit_button_safety',$mod->CreateInputHidden($id,'fbrp_forma_input_button_safety','0').
			$mod->CreateInputCheckbox($id,'fbrp_forma_input_button_safety','1',$this->GetAttr('input_button_safety','0')).
			$mod->Lang('title_submit_button_safety'));
		$mod->smarty->assign('title_form_prev_button',$mod->Lang('title_form_prev_button'));
		$mod->smarty->assign('input_form_prev_button',
			$mod->CreateInputText($id, 'fbrp_forma_prev_button_text',$this->GetAttr('prev_button_text',$mod->Lang('button_previous')), 35, 35));

		$mod->smarty->assign('input_title_user_captcha',
			$mod->CreateInputText($id, 'fbrp_forma_title_user_captcha',$this->GetAttr('title_user_captcha',$mod->Lang('title_user_captcha')),35,80));
		$mod->smarty->assign('title_title_user_captcha',$mod->Lang('title_title_user_captcha'));

		$mod->smarty->assign('input_title_user_captcha_error',
			$mod->CreateInputText($id, 'fbrp_forma_captcha_wrong',$this->GetAttr('captcha_wrong',$mod->Lang('wrong_captcha')),35,80));
		$mod->smarty->assign('title_user_captcha_error',$mod->Lang('title_user_captcha_error'));

		$mod->smarty->assign('title_form_next_button',$mod->Lang('title_form_next_button'));
		$mod->smarty->assign('input_form_next_button',
			$mod->CreateInputText($id, 'fbrp_forma_next_button_text',$this->GetAttr('next_button_text',$mod->Lang('button_continue')), 35, 35));
		$mod->smarty->assign('title_form_predisplay_udt',$mod->Lang('title_form_predisplay_udt'));
		$mod->smarty->assign('title_form_predisplay_each_udt',$mod->Lang('title_form_predisplay_each_udt'));

		$usertagops = cmsms()->GetUserTagOperations();
		$usertags = $usertagops->ListUserTags();
		$usertaglist = array();
		$usertaglist[$mod->lang('none')] = -1;
		foreach( $usertags as $key => $value )
		{
			$usertaglist[$value] = $key;
		}

		$mod->smarty->assign('input_form_predisplay_udt',
			$mod->CreateInputDropdown($id,'fbrp_forma_predisplay_udt',$usertaglist,-1,$this->GetAttr('predisplay_udt',-1)));
		$mod->smarty->assign('input_form_predisplay_each_udt',
			$mod->CreateInputDropdown($id,'fbrp_forma_predisplay_each_udt',$usertaglist,-1,$this->GetAttr('predisplay_each_udt',-1)));

		$mod->smarty->assign('title_form_validate_udt',
		$mod->Lang('title_form_validate_udt'));

		$mod->smarty->assign('input_form_validate_udt',
			$mod->CreateInputDropdown($id,'fbrp_forma_validate_udt',$usertaglist,-1,$this->GetAttr('validate_udt',-1)));

		$mod->smarty->assign('title_form_required_symbol',$mod->Lang('title_form_required_symbol'));
		$mod->smarty->assign('input_form_required_symbol',
			$mod->CreateInputText($id, 'fbrp_forma_required_field_symbol',$this->GetAttr('required_field_symbol','*'), 50));
		$mod->smarty->assign('input_list_delimiter',
			$mod->CreateInputText($id, 'fbrp_forma_list_delimiter',$this->GetAttr('list_delimiter',','), 50));

		$contentops = cmsms()->GetContentOperations();
		$mod->smarty->assign('input_redirect_page',$contentops->CreateHierarchyDropdown('',$this->GetAttr('redirect_page','0'), $id.'fbrp_forma_redirect_page'));

		$mod->smarty->assign('input_form_template',
			$mod->CreateTextArea(false, $id, $this->GetAttr('form_template',$this->DefaultTemplate()), 'fbrp_forma_form_template','','fb_form_template', '', '', '80', '15','','html'));

		$mod->smarty->assign('input_submit_javascript',
			$mod->CreateTextArea(false, $id, $this->GetAttr('submit_javascript',''), 'fbrp_forma_submit_javascript','module_fb_area_short','fb_submit_javascript','', '', '80', '15','','js').
			'<br />'.$mod->Lang('title_submit_javascript_long'));

		 
		$mod->smarty->assign('input_submit_response',
			$mod->CreateTextArea(false, $id, $this->GetAttr('submit_response',$this->createSampleTemplate(true,false)), 'fbrp_forma_submit_response','module_fb_area_wide','','', '', '80', '15','','html'));

		$parms = array();
		$parms['forma_submit_response']['html_button'] = true;
		$parms['forma_submit_response']['txt_button'] = false;
		$parms['forma_submit_response']['is_one_line'] = false;
		$parms['forma_submit_response']['is_email'] = false;
		$mod->smarty->assign('help_submit_response', $this->AdminTemplateHelp($id,$parms));

		return $mod->ProcessTemplate('AddEditForm.tpl');
}

	// Add new field
	public function &NewField(&$params)
	{
		$aefield = false;
		if (isset($params['field_id']) && $params['field_id'] != -1 )
		{
			// we're loading an extant field
			$sql = 'SELECT type FROM ' . cms_db_prefix() . 'module_fb_field WHERE field_id=?';
			$rs = $this->module_ptr->dbHandle->Execute($sql, array( $params['field_id']));
			if($rs && $result = $rs->FetchRow())
			{
				if ($result['type'] != '')
				{
					$className = $this->MakeClassName($result['type'] , '');
					$aefield = new $className($this, $params);
					$aefield->LoadField($params);
				}
			}
		}
		if ($aefield === false)
		{
			// new field
			if (! isset($params['fbrp_field_type']))
			{
				// unknown field type
				$aefield = new fbFieldBase($this,$params);
			}
			else
			{
				// specified field type via params
				$className = $this->MakeClassName($params['fbrp_field_type'], '');
				$aefield = new $className($this, $params);
			}
		}
		return $aefield;
	}

	public function AddEditField($id, &$aefield, $dispose_only, $returnid, $message='')
	{
		$mod = $this->module_ptr;

		if(!empty($message)) $mod->smarty->assign('message',$mod->ShowMessage($message));
		$mod->smarty->assign('backtoform_nav',$mod->CreateLink($id, 'admin_add_edit_form', $returnid, $mod->Lang('link_back_to_form'), array('form_id'=>$this->Id)));
		$mainList = array();
		$advList = array();
		$baseList = $aefield->PrePopulateBaseAdminForm($id, $dispose_only);
		if ($aefield->GetFieldType() == '')
		{
			// still need type
			$mod->smarty->assign('start_form',$mod->CreateFormStart($id, 'admin_add_edit_field', $returnid));
			$fieldList = array('main'=>array(),'adv'=>array());
		}
		else
		{
			// we have our type
			$mod->smarty->assign('start_form',$mod->CreateFormStart($id, 'admin_add_edit_field', $returnid));
			$fieldList = $aefield->PrePopulateAdminForm($id);
		}
		$mod->smarty->assign('end_form', $mod->CreateFormEnd());
		$mod->smarty->assign('tab_start',$mod->StartTabHeaders().
			$mod->SetTabHeader('maintab',$mod->Lang('tab_main')).
			$mod->SetTabHeader('advancedtab',$mod->Lang('tab_advanced')).
			$mod->EndTabHeaders() . $mod->StartTabContent());
		$mod->smarty->assign('tabs_end',$mod->EndTabContent());
		$mod->smarty->assign('maintab_start',$mod->StartTab("maintab"));
		$mod->smarty->assign('advancedtab_start',$mod->StartTab("advancedtab"));
		$mod->smarty->assign('tab_end',$mod->EndTab());
		$mod->smarty->assign('notice_select_type',$mod->Lang('notice_select_type'));

		if($aefield->GetId() != -1)
		{
			$mod->smarty->assign('op',$mod->CreateInputHidden($id, 'fbrp_op',$mod->Lang('updated')));
			$mod->smarty->assign('submit',$mod->CreateInputSubmit($id, 'fbrp_aef_upd', $mod->Lang('update')));
		}
		else if($aefield->GetFieldType() != '')
		{
			$mod->smarty->assign('op',$mod->CreateInputHidden($id, 'fbrp_op', $mod->Lang('added')));
			$mod->smarty->assign('submit',$mod->CreateInputSubmit($id, 'fbrp_aef_add', $mod->Lang('add')));
		}

		$mod->smarty->assign('cancel',$mod->CreateInputSubmit($id, 'fbrp_cancel', $mod->Lang('cancel')));
		 
		if ($aefield->HasAddOp())
		{
			$mod->smarty->assign('add',$mod->CreateInputSubmit($id,'fbrp_aef_optadd',$aefield->GetOptionAddButton()));
		}
		else
		{
			$mod->smarty->assign('add','');
		}
		if ($aefield->HasDeleteOp())
		{
			$mod->smarty->assign('del',$mod->CreateInputSubmit($id,'fbrp_aef_optdel',$aefield->GetOptionDeleteButton()));
		}
		else
		{
			$mod->smarty->assign('del','');
		}


		$mod->smarty->assign('fb_hidden', $mod->CreateInputHidden($id, 'form_id', $this->Id) . $mod->CreateInputHidden($id, 'field_id', $aefield->GetId()) . $mod->CreateInputHidden($id, 'fbrp_order_by', $aefield->GetOrder()).
		$mod->CreateInputHidden($id,'fbrp_set_from_form','1'));

		if (/*!$aefield->IsDisposition() && */ !$aefield->IsNonRequirableField())
		{
			$mod->smarty->assign('requirable',1);
		}
		else
		{
			$mod->smarty->assign('requirable',0);
		}
			
		if (isset($baseList['main']))
		{
			foreach ($baseList['main'] as $item)
			{
				$titleStr=$item[0];
				$inputStr=$item[1];
				$oneset = new stdClass();
				$oneset->title = $titleStr;
				if (is_array($inputStr))
				{
					$oneset->input = $inputStr[0];
					$oneset->help = $inputStr[1];
				}
				else
				{
					$oneset->input = $inputStr;
					$oneset->help='';
				}
				array_push($mainList,$oneset);
			}
		}
		if (isset($baseList['adv']))
		{
			foreach ($baseList['adv'] as $item)
			{
				$titleStr = $item[0];
				$inputStr = $item[1];
				$oneset = new stdClass();
				$oneset->title = $titleStr;
				if (is_array($inputStr))
				{
					$oneset->input = $inputStr[0];
					$oneset->help = $inputStr[1];
				}
				else
				{
					$oneset->input = $inputStr;
					$oneset->help='';
				}
				array_push($advList,$oneset);
			}
		}
		if (isset($fieldList['main']))
		{
			foreach ($fieldList['main'] as $item)
			{
				$titleStr=$item[0];
				$inputStr=$item[1];
				$oneset = new stdClass();
				$oneset->title = $titleStr;
				if (is_array($inputStr))
				{
					$oneset->input = $inputStr[0];
					$oneset->help = $inputStr[1];
				}
				else
				{
					$oneset->input = $inputStr;
					$oneset->help='';
				}
				array_push($mainList,$oneset);
			}
		}
		if (isset($fieldList['adv']))
		{
			foreach ($fieldList['adv'] as $item)
			{
				$titleStr=$item[0];
				$inputStr=$item[1];
				$oneset = new stdClass();
				$oneset->title = $titleStr;
				if (is_array($inputStr))
				{
					$oneset->input = $inputStr[0];
					$oneset->help = $inputStr[1];
				}
				else
				{
					$oneset->input = $inputStr;
					$oneset->help='';
				}
				array_push($advList,$oneset);
			}
		}

		$aefield->PostPopulateAdminForm($mainList, $advList);
		$mod->smarty->assign('mainList',$mainList);
		$mod->smarty->assign('advList',$advList);
		return $mod->ProcessTemplate('AddEditField.tpl');
	}

	public function MakeAlias($string, $isForm=false)
	{
		$string = trim(htmlspecialchars($string));
		if ($isForm)
		{
			return strtolower($string);
		}
		else
		{
			return 'fb'.strtolower($string);
		}
	}

	public function SwapFieldsByIndex($src_field_index, $dest_field_index)
	{
		$srcField = $this->GetFieldByIndex($src_field_index);
		$destField = $this->GetFieldByIndex($dest_field_index);
		$tmpOrderBy = $destField->GetOrder();
		$destField->SetOrder($srcField->GetOrder());
		$srcField->SetOrder($tmpOrderBy);
		//it seems this makes php4 go crazy fixed by reloading form before showing it again
		#        $this->Fields[$dest_field_index] = $srcField;
		#        $this->Fields[$src_field_index] = $destField;
		$srcField->Store();
		$destField->Store();
	}

	public function &GetFields()
	{
		return $this->Fields;
	}

	public function &GetFieldById($field_id)
	{
		$index = -1;
		$ret = false;
		for ($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->GetId() == $field_id)
			{
				$index = $i;
			}
		}
		if ($index != -1)
		{
			$ret = $this->Fields[$index];
		}
		return $ret;
	}


	public function &GetFieldByAlias($field_alias)
	{
		$index = -1;
		$ret = false;
		for ($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->GetAlias() == $field_alias)
			{
				$index = $i;
			}
		}
		if ($index != -1)
		{
			$ret = $this->Fields[$index];
		}
		return $ret;
	}

	public function &GetFieldByName($field_name)
	{
		$index = -1;
		$ret = false;
		for ($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->GetName() == $field_name)
			{
				$index = $i;
			}
		}
		if ($index != -1)
		{
			$ret = $this->Fields[$index];
		}
		return $ret;
	}


	public function &GetFieldByIndex($field_index)
	{
		return $this->Fields[$field_index];
	}


	public function GetFieldIndexFromId($field_id)
	{
		$index = -1;
		for ($i=0;$i<count($this->Fields);$i++)
		{
			if ($this->Fields[$i]->GetId() == $field_id)
			{
				$index = $i;
			}
		}
		return $index;
}

	public function DefaultTemplate()
	{
		return file_get_contents(dirname(__FILE__).'/../templates/RenderFormDefault.tpl');
	}

	public function DeleteField($field_id)
	{
		$index = $this->GetFieldIndexFromId($field_id);
		if ($index != -1)
		{
			$this->Fields[$index]->Delete();
			array_splice($this->Fields,$index,1);
		}
	}

	public function ResetFields()
	{
		for($i=0;$i<count($this->Fields);$i++)
		{
			$this->Fields[$i]->ResetValue();
		}
	}

	// FormBrowser >= 0.3 Response load method. This populates the Field values directly
	// (as opposed to LoadResponseValues, which places the values into the $params array)
	public function LoadResponse($response_id)
	{
		$mod = $this->module_ptr;
		$db = $this->module_ptr->dbHandle;

		$oneset = new StdClass();
		$res = $db->Execute('SELECT response, form_id FROM '.cms_db_prefix().
				'module_fb_formbrowser WHERE fbr_id=?', array($response_id));

		if ($res && $row=$res->FetchRow())
		{
			$oneset->xml = $row['response'];
			$oneset->form_id = $row['form_id'];
		}
		if ($oneset->form_id != $this->GetId())
		{
			return false;
		}
		$fbField = $this->GetFormBrowserField();
		if ($fbField == false)
		{
			// error handling goes here.
			echo($mod->Lang('error_has_no_fb_field'));
		}
		$mod->HandleResponseFromXML($fbField, $oneset);

		list($fnames, $aliases, $vals) = $mod->ParseResponseXML($oneset->xml, false);
		$this->ResetFields();
		foreach ($vals as $id=>$val)
		{
			//error_log("setting value of field ".$id." to be ".$val);
			$index = $this->GetFieldIndexFromId($id);
			if($index != -1 &&  is_object($this->Fields[$index]) )
			{
				$this->Fields[$index]->SetValue($val);
			}
		}
		return true;
	}

	// Check if FormBroweiser field exists
	public function GetFormBrowserField()
	{
		$fields = $this->GetFields();
		$fbField = false;
		foreach($fields as $thisField)
		{
			if ($thisField->GetFieldType() == 'DispositionFormBrowser')
			{
				$fbField = $thisField;
			}
		}
		if ($fbField == false)
		{
			// error handling goes here.
			return false;
		}
		return $fbField;
	}


	public function ReindexResponses()
	{
		@set_time_limit(0);
		$mod = $this->module_ptr;
		$db = $this->module_ptr->dbHandle;
		$responses = array();
		$res = $db->Execute('SELECT fbr_id FROM '.cms_db_prefix().'module_fb_formbrowser WHERE form_id=?', array($this->Id));
		while ($res && $row=$res->FetchRow())
		{
			array_push($responses,$row['fbr_id']);
		}
		$fbr_field = $this->GetFormBrowserField();
		foreach($responses as $this_resp)
		{
			if ($this->LoadResponse($this_resp))
			{
				$this->StoreResponse($this_resp,'',$fbr_field);
			}
		}
	}

	// FormBrowser >= 0.3 Response load method. This populates the $params array for later processing/combination
	// (as opposed to LoadResponse, which places the values into the Field values directly)
	public function LoadResponseValues(&$params, &$types)
	{
		$mod = $this->module_ptr;
		$db = $this->module_ptr->dbHandle;
		$oneset = new StdClass();
		$form_id = -1;
		$res = $db->Execute('SELECT response, form_id FROM '.cms_db_prefix().'module_fb_formbrowser WHERE fbr_id=?', array($params['response_id']));

		if ($res && $row=$res->FetchRow())
		{
			$oneset->xml = $row['response'];
			$form_id = $row['form_id'];
		}
		// loaded a response -- at this point, we check that the response
		// is for the correct form_id!
		if ($form_id != $this->GetId())
		{
			return false;
		}
		$fbField = $mod->GetFormBrowserField($form_id);
		if ($fbField == false)
		{
			// error handling goes here.
			echo($mod->Lang('error_has_no_fb_field'));
		}
		$mod->HandleResponseFromXML($fbField, $oneset);
		list($fnames, $aliases, $vals) = $mod->ParseResponseXML($oneset->xml, false);
		$types = $mod->ParseResponseXMLType($oneset->xml);
		foreach ($vals as $id=>$val)
		{
			if (isset($params['fbrp__'.$id]) && !is_array($params['fbrp__'.$id]))
			{
				$params['fbrp__'.$id] = array($params['fbrp__'.$id]);
				array_push($params['fbrp__'.$id], $val);
			}
			elseif (isset($params['fbrp__'.$id]))
			{
				array_push($params['fbrp__'.$id], $val);
			}
			else
			{
				$params['fbrp__'.$id] = $val;
			}
		}
		return true;
	}

	// FormBrowser < 0.3 Response load method
	public function LoadResponseValuesOld(&$params)
	{
		$db = $this->module_ptr->dbHandle;
		// loading a response -- at this point, we check that the response
		// is for the correct form_id!
		$sql = 'SELECT form_id FROM ' . cms_db_prefix().'module_fb_resp where resp_id=?';
		if($result = $db->GetRow($sql, array($params['response_id'])))
		{
			if ($result['form_id'] != $this->GetId())
			{
				return false;
			}
			$sql = 'SELECT * FROM '.cms_db_prefix().'module_fb_resp_val WHERE resp_id=? order by resp_val_id';
			$dbresult = $db->Execute($sql, array($params['response_id']));
			while ($dbresult && $row = $dbresult->FetchRow())
			{ // was '__'
				if (isset($params['fbrp__'.$row['field_id']]) && !is_array($params['fbrp__'.$row['field_id']]))
				{
					$params['fbrp__'.$row['field_id']] = array($params['fbrp__'.$row['field_id']]);
					array_push($params['fbrp__'.$row['field_id']], $row['value']);
				}
				elseif (isset($params['fbrp__'.$row['field_id']]))
				{
					array_push($params['fbrp__'.$row['field_id']], $row['value']);
				}
				else
				{
					$params['fbrp__'.$row['field_id']] = $row['value'];
				}
			}
		}
		else
		{
			return false;
		}
	}

	// Validation stuff action.validate.php
	public function CheckResponse($form_id, $response_id, $code)
	{
		$db = $this->module_ptr->dbHandle;
		$sql = 'SELECT secret_code FROM ' . cms_db_prefix(). 'module_fb_formbrowser WHERE form_id=? AND fbr_id=?';
		if($result = $db->GetRow($sql, array($form_id,$response_id)))
		{
			if ($result['secret_code'] == $code)
			{
				return true;
			}
		}
		return false;
	}

	// Master response inputter
	public function StoreResponse($response_id=-1,$approver='',&$formBuilderDisposition)
	{
		$mod = $this->module_ptr;
		$db = $this->module_ptr->dbHandle;
		$fields = $this->GetFields();
		$newrec = false;

		$crypt = false;
		$hash_fields = false;
		$sort_fields = array();

		// Check if form has Database fields, do init
		if (is_object($formBuilderDisposition) &&
		($formBuilderDisposition->GetFieldType()=='DispositionFormBrowser' ||
		$formBuilderDisposition->GetFieldType()=='DispositionDatabase'))
		{
			$crypt = ($formBuilderDisposition->GetOption('crypt','0') == '1');
			$hash_fields = ($formBuilderDisposition->GetOption('hash_sort','0') == '1');
			for ($i=0;$i<5;$i++)
			{
				$sort_fields[$i] = $formBuilderDisposition->getSortFieldVal($i+1);
			}
		}

		// If new field
		if ($response_id == -1)
		{
			if (is_object($formBuilderDisposition) && $formBuilderDisposition->GetOption('feu_bind','0') == '1')
			{
				$feu = $mod->GetModuleInstance('FrontEndUsers');
				if ($feu == false)
				{
					debug_display("FAILED to instatiate FEU!");
					return;
				}
				$feu_id = $feu->LoggedInId();
			}
			else
			{
				$feu_id = -1;
			}
			$response_id = $db->GenID(cms_db_prefix(). 'module_fb_formbrowser_seq');
			foreach ($fields as $thisField)
			{
				// set the response_id to be the attribute of the database disposition
				if (($thisField->GetFieldType() == 'DispositionDatabase')||
				($thisField->GetFieldType() == 'DispositionFormBrowser'))
				{
					$thisField->SetValue($response_id);
				}
			}
			$newrec = true;
		}
		else
		{
			$feu_id = $mod->getFEUIDFromResponseID($response_id);
		}

		// Convert form to XML
		$xml = $this->ResponseToXML();

		// Do the actual adding
		if (! $crypt)
		{
			$output = $this->StoreResponseXML(
				$response_id,
				$newrec,
				$approver,
				isset($sort_fields[0])?$sort_fields[0]:'',
				isset($sort_fields[1])?$sort_fields[1]:'',
				isset($sort_fields[2])?$sort_fields[2]:'',
				isset($sort_fields[3])?$sort_fields[3]:'',
				isset($sort_fields[4])?$sort_fields[4]:'',
				$feu_id,
				$xml
			);
		}
		elseif (! $hash_fields)
		{
			list($res, $xml) = $mod->crypt($xml,$formBuilderDisposition);
			if (! $res)
			{
				return array(false, $xml);
			}
			$output = $this->StoreResponseXML(
				$response_id,
				$newrec,
				$approver,
				isset($sort_fields[0])?$sort_fields[0]:'',
				isset($sort_fields[1])?$sort_fields[1]:'',
				isset($sort_fields[2])?$sort_fields[2]:'',
				isset($sort_fields[3])?$sort_fields[3]:'',
				isset($sort_fields[4])?$sort_fields[4]:'',
				$feu_id,
				$xml
			);
		}
		else
		{
			list($res, $xml) = $mod->crypt($xml,$formBuilderDisposition);
			if (! $res)
			{
				return array(false, $xml);
			}
			$output = $this->StoreResponseXML(
				$response_id,
				$newrec,
				$approver,
				isset($sort_fields[0])?$mod->getHashedSortFieldVal($sort_fields[0]):'',
				isset($sort_fields[1])?$mod->getHashedSortFieldVal($sort_fields[1]):'',
				isset($sort_fields[2])?$mod->getHashedSortFieldVal($sort_fields[2]):'',
				isset($sort_fields[3])?$mod->getHashedSortFieldVal($sort_fields[3]):'',
				isset($sort_fields[4])?$mod->getHashedSortFieldVal($sort_fields[4]):'',
				$feu_id,
				$xml
			);
		}
		//return array(true,''); Stikki replaced: instead of true, return actual data, didn't saw any side effects.
		return $output;
	}

	// Converts form to XML
	public function &ResponseToXML()
	{
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<response form_id=\"".$this->Id."\">\n";
		foreach($this->Fields as $thisField)
		{
			$xml .= $thisField->ExportXML(true);
		}
		$xml .= "</response>\n";
		return $xml;
	}

	// Inserts parsed XML data to database
	public function StoreResponseXML($response_id=-1,$newrec=false,$approver='',$sortfield1,
		$sortfield2,$sortfield3,$sortfield4,$sortfield5, $feu_id,$xml)
	{
		$db = $this->module_ptr->dbHandle;
		$secret_code = '';

		if ($newrec)
		{
			// saving a new response
			$secret_code = substr(md5(session_id().'_'.time()),0,7);
			//$response_id = $db->GenID(cms_db_prefix(). 'module_fb_formbrowser_seq');
			$sql = 'INSERT INTO ' . cms_db_prefix().'module_fb_formbrowser '.
				'(fbr_id, form_id, submitted, secret_code, index_key_1, index_key_2, index_key_3, index_key_4, index_key_5, feuid, response)'.
				'VALUES (?,?,?,?,?,?,?,?,?,?,?)';
			$res = $db->Execute($sql, array(
				$response_id,
				$this->GetId(),
				$this->clean_datetime($db->DBTimeStamp(time())),
				$secret_code,
				$sortfield1,$sortfield2,$sortfield3,$sortfield4,$sortfield5,
				$feu_id,
				$xml
			));
		}
		else if ($approver != '')
		{
			$sql = 'UPDATE ' . cms_db_prefix().'module_fb_formbrowser set user_approved=? where fbr_id=?';
			$res = $db->Execute($sql,
			array($this->clean_datetime($db->DBTimeStamp(time())),$response_id));
			audit(-1, (isset($name)?$name:""), $this->module_ptr->Lang('user_approved_submission',array($response_id,$approver)));
		}
		if (! $newrec)
		{
			$sql = 'UPDATE ' . cms_db_prefix().'module_fb_formbrowser set index_key_1=?, index_key_2=?, index_key_3=?, index_key_4=?, index_key_5=?, response=? where fbr_id=?';
			$res = $db->Execute($sql,array($sortfield1,$sortfield2,$sortfield3,$sortfield4,$sortfield5,$xml,$response_id));
		}
		return array($response_id,$secret_code);
	}

	// Some stupid date function
	public function clean_datetime($dt)
	{
		return substr($dt,1,strlen($dt)-2);
}

	// When downloading form.
	public function ExportXML($exportValues = false)
	{
		$xmlstr = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xmlstr .= "<form id=\"".$this->Id."\"\n";
		$xmlstr .= "\talias=\"".$this->Alias."\">\n";
		$xmlstr .= "\t\t<form_name><![CDATA[".$this->Name."]]></form_name>\n";
		foreach ($this->Attrs as $thisAttrKey=>$thisAttrValue)
		{
			$xmlstr .= "\t\t<attribute key=\"$thisAttrKey\"><![CDATA[$thisAttrValue]]></attribute>\n";
		}
		foreach($this->Fields as $thisField)
		{
			$xmlstr .= $thisField->ExportXML($exportValues);
		}
		$xmlstr .= "</form>\n";
		return $xmlstr;
	}

	public function GetFormBrowsersForForm()
	{
		$db = $this->module_ptr->dbHandle;
		$fbr = $this->module_ptr->GetModuleInstance('FormBrowser');
		$browsers = array();
		if ($fbr != FALSE)
		{
			$res = $db->Execute('SELECT browser_id from '. cms_db_prefix(). 'module_fbr_browser where form_id=?',
			array($this->GetId()));
			while ($res && $row=$res->FetchRow())
			{
				array_push($browsers, $row['browser_id']);
			}
		}
		return $browsers;
	}

	public function AddToSearchIndex($response_id)
	{
		// find browsers keyed to this
		$browsers = $this->GetFormBrowsersForForm();
		if (count($browsers) < 1)
		{
			return;
		}

		$module =& $this->module_ptr->GetModuleInstance('Search');
		if ($module != FALSE)
		{
			$submitstring = '';
			foreach ($this->Fields as $thisField)
			{
				if ($thisField->DisplayInSubmission())
				{
					$submitstring .= ' '.$thisField->GetHumanReadableValue($as_string=true);
				}
			}
			foreach ($browsers as $thisBrowser)
			{
				$module->AddWords( 'FormBrowser', $response_id, 'sub_'.$thisBrowser, $submitstring, null);
			}
		}
	}

	public function setFinishedFormSmarty($htmlemail=false)
	{
		$mod = $this->module_ptr;
		$theFields = $this->GetFields();
		$unspec = $this->GetAttr('unspecified',$mod->Lang('unspecified'));
		$formInfo = array();
		for($i=0;$i<count($theFields);$i++)
		{
			$replVal = $unspec;
			$replVals = array();
			if ($theFields[$i]->DisplayInSubmission())
			{
				$replVal = $theFields[$i]->GetHumanReadableValue();
				if ($htmlemail)
				{
					// allow <BR> as delimiter or in content
					$replVal = preg_replace('/<br(\s)*(\/)*>/i','|BR|',$replVal);
					$replVal = preg_replace('/[\n\r]+/','|BR|',$replVal);
					$replVal = htmlspecialchars($replVal);
					$replVal = preg_replace('/\|BR\|/','<br />',$replVal);
				}
				if ($replVal == '')
				{
					$replVal = $unspec;
				}
			}

			$mod->smarty->assign($theFields[$i]->GetVariableName(),$replVal);
			$mod->smarty->assign('fld_'.$theFields[$i]->GetId(),$replVal);
			$fldobj = $theFields[$i]->ExportObject();
			$mod->smarty->assign($theFields[$i]->GetVariableName().'_obj',$fldobj);
			$mod->smarty->assign('fld_'.$theFields[$i]->GetId().'_obj',$fldobj);
			if ($theFields[$i]->GetAlias() != '')
			{
				$mod->smarty->assign($theFields[$i]->GetAlias(),$replVal);
				$mod->smarty->assign($theFields[$i]->GetAlias().'_obj',$fldobj);
			}
		}
		// general form details
		$mod->smarty->assign('sub_form_name',$this->GetName());
		$mod->smarty->assign('sub_date',date('r'));
		$mod->smarty->assign('sub_host',$_SERVER['SERVER_NAME']);
		$mod->smarty->assign('sub_source_ip',$_SERVER['REMOTE_ADDR']);
		$mod->smarty->assign('sub_url',(empty($_SERVER['HTTP_REFERER'])?$mod->Lang('no_referrer_info'):$_SERVER['HTTP_REFERER']));
		$mod->smarty->assign('fb_version',$mod->GetVersion());
		$mod->smarty->assign('TAB',"\t");
	}

	public function manageFileUploads()
	{
		$theFields = $this->GetFields();
		$mod = $this->module_ptr;

		// build rename map
		$mapId = array();
		$eval_string = false;
		for($j=0;$j<count($theFields);$j++)
		{
			$mapId[$theFields[$j]->GetId()] = $j;
		}

		for($i=0;$i<count($theFields);$i++)
		{
			if (strtolower(get_class($theFields[$i])) == 'fbfileuploadfield' )
			{
				// Handle file uploads
				// if the uploads module is found, and the option is checked in
				// the field, then the file is added to the uploads module
				// and a link is added to the results
				// if the option is not checked, then the file is merely uploaded to
				// the "uploads" directory

				$_id = $mod->module_id.'fbrp__'.$theFields[$i]->GetId();
				if( isset( $_FILES[$_id] ) && $_FILES[$_id]['size'] > 0 )
				{
					$thisFile =& $_FILES[$_id];
					$thisExt = substr($thisFile['name'],strrpos($thisFile['name'],'.'));

					if ($theFields[$i]->GetOption('file_rename','') == '')
					{
						$destination_name = $thisFile['name'];
					}
					else
					{
						$flds = array();
						$destination_name = $theFields[$i]->GetOption('file_rename');
						preg_match_all('/\$fld_(\d+)/', $destination_name, $flds);
						foreach ($flds[1] as $tF)
						{
							if (isset($mapId[$tF]))
							{
								$ref = $mapId[$tF];
								$destination_name = str_replace('$fld_'.$tF,
								$theFields[$ref]->GetHumanReadableValue(),$destination_name);
							}
						}
						$destination_name = str_replace('$ext',$thisExt,$destination_name);
					}

					if( $theFields[$i]->GetOption('sendto_uploads') )
					{
						// we have a file we can send to the uploads
						$uploads = $mod->GetModuleInstance('Uploads');
						if( !$uploads )
						{
							// no uploads module
							audit(-1, $mod->GetName(), $mod->Lang('submit_error'),$mail->GetErrorInfo());
							return array($res, $mod->Lang('nouploads_error'));
						}

						$parms = array();
						$parms['input_author'] = $mod->Lang('anonymous');
						$parms['input_summary'] = $mod->Lang('title_uploadmodule_summary');
						$parms['category_id'] = $theFields[$i]->GetOption('uploads_category');
						$parms['field_name'] = $_id;
						$parms['input_destname'] = $destination_name;
						if ($theFields[$i]->GetOption('allow_overwrite','0') == '1')
						{
							$parms['input_replace'] = 1;
						}
						$res = $uploads->AttemptUpload(-1,$parms,-1);

						if( $res[0] == false )
						{
							// failed upload kills the send.
							audit(-1, $mod->GetName(), $mod->Lang('submit_error',$res[1]));
							return array($res[0], $mod->Lang('uploads_error',$res[1]));
						}

						$uploads_destpage = $theFields[$i]->GetOption('uploads_destpage');
						$url = $uploads->CreateLink ($parms['category_id'], 'getfile', $uploads_destpage, '',
						array ('upload_id' => $res[1]), '', true);

						$url = str_replace('admin/moduleinterface.php?','index.php?',$url);

						$theFields[$i]->ResetValue();
						$theFields[$i]->SetValue($url);
					}
					else
					{
						// Handle the upload ourselves
						$src = $thisFile['tmp_name'];
						$dest_path = $theFields[$i]->GetOption('file_destination', cmsms()->config['uploads_path']);

						// validated message before, now do it for the file itself
						$valid = true;
						$ms = $theFields[$i]->GetOption('max_size');
						$exts = $theFields[$i]->GetOption('permitted_extensions','');
						if ($ms != '' && $thisFile['size'] > ($ms * 1024))
						{
							$valid = false;
						}
						else if ($exts != '')
						{
							$match = false;
							$legalExts = explode(',',$exts);
							foreach ($legalExts as $thisExt)
							{
								if (preg_match('/\.'.trim($thisExt).'$/i',$thisFile['name']))
								{
									$match = true;
								}
								else if (preg_match('/'.trim($thisExt).'/i',$thisFile['type']))
								{
									$match = true;
								}
							}
							if (! $match)
							{
								$valid = false;
							}
						}
						if (! $valid)
						{
							unlink($src);
							audit(-1, $mod->GetName(), $mod->Lang('illegal_file',array($thisFile['name'],$_SERVER['REMOTE_ADDR'])));
							return array(false, '');
						}
						$dest = $dest_path.DIRECTORY_SEPARATOR.$destination_name;
						if (file_exists($dest) && $theFields[$i]->GetOption('allow_overwrite','0')=='0')
						{
							unlink($src);
							return array(false,$mod->Lang('file_already_exists', array($destination_name)));
						}
						if (! move_uploaded_file($src,$dest))
						{
							audit(-1, $mod->GetName(), $mod->Lang('submit_error',''));
							return array(false, $mod->Lang('uploads_error',''));
						}
						else
						{
							if (strpos($dest_path, cmsms()->config['root_path']) !== FALSE)
							{
								$url = str_replace(cmsms()->config['root_path'],'',$dest_path).'/'.$destination_name;
							}
							else
							{
								$url = $mod->Lang('uploaded_outside_webroot',$destination_name);
							}
							$theFields[$i]->ResetValue();
							$theFields[$i]->SetValue($destination_name);
						}
					}
				}
			}
		}
		return array(true,'');
	}
}
?>