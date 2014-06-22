<?php
/* 
   FormBrowser. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
if (!isset($gCms)) exit;
if (! $this->CheckAccess()) exit;

if (isset($params['cancel'])) {

	$parms['browser_id'] = $params['browser_id'];
	$this->Redirect($id, 'admin_browse', $returnid, $parms);
}

		$this->buildBrowseNav($id,$params,$returnid,false);
		$aebrowser = new fbrBrowser($this, $params, true);
		$params['in_formbrowser'] = 1;
		$params['in_admin'] = 1;
		$this->smarty->assign('in_admin',$params['in_admin']);
		$this->smarty->assign('fbr_id',$params['response_id']);
		$fb = $this->GetModuleInstance('FormBuilder');

		/* Bit stupid, but assigning placeholders to smarty */
		
		$smarty->assign('fb_form_header', false);
		$smarty->assign('fb_form_done', false);
		$smarty->assign('fb_form_start', false);
		$smarty->assign('fb_form_end', false);
		$smarty->assign('fb_form_footer', false);
		
		/* End of placeholders */
		
 		$params['form_id'] = $aebrowser->GetFormId();
 		$params['module_id'] = $id; // Stikki adds: fbForm couldn't get $id, so forcing it trought params. reason: module_ptr = $fb not $this
        $aeform = new fbForm($fb,$params,true,true);
	
        $finished = false;
        if (($aeform->GetPageCount() > 1 && $aeform->GetPageNumber() > 0) || (isset($params['fbrp_done'])&& $params['fbrp_done']==1))
            {
        	$res = $aeform->Validate();
			
			// handle uploads
			$res2 = $aeform->manageFileUploads();
			
            if ($res[0] === false || $res2[0] === false)
                {
				
				if (isset($res2[1]) && !empty($res2[1])) {
						array_push($res[1],$res2[1]);
				}				
								
                if (is_array($res[1]))
                  {
                  foreach ($res[1] as $r)
                     {
                     echo '<p class="pagemessage">'.$r."</p>\n";
                     }
                  }
				else
                  {
                  echo '<p class="pagemessage">'.$res[1]."</p>\n";
                  }
                $aeform->PageBack();
                }
				
            else if (isset($params['fbrp_done']) && $params['fbrp_done']==1)
            	{
            	$finished = true;
            	if (isset($params['response_id']))
					{
					$parms = array();
					$parms['browser_name']=$aebrowser->GetName();
					$parms['browser_alias']=$aebrowser->GetAlias();
					$parms['browser_id']=$aebrowser->GetId();
					$parms['record_id']=$params['response_id'];
					$parms['side']='admin';
					$this->SendEvent('OnFormBrowserRecordEdit',$parms);
					}
				else
					{
					$parms = array();
					$parms['browser_name']=$aebrowser->GetName();
					$parms['browser_alias']=$aebrowser->GetAlias();
					$parms['browser_id']=$aebrowser->GetId();
					$parms['side']='admin';
					$this->SendEvent('OnFormBrowserRecordAdd',$parms);
					}
					
					// Mod by request -Stikki-					
					foreach($aeform->Fields as $field) {
					
						if($field->Type == 'FileUploadField') {
					
							if(isset($params['fbrp_delete__'.$field->Id])) {
							
								$field->ResetValue();
					
							}
						}
					}
					// End of Mod
					
					
				$results = $aeform->Dispose($returnid, ($this->GetPreference('suppress_email_on_edit','1') == '1'));
            	if (isset($params['response_id']))
					{
					$parms = array();
					$parms['browser_name']=$aebrowser->GetName();
					$parms['browser_alias']=$aebrowser->GetAlias();
					$parms['browser_id']=$aebrowser->GetId();
					$parms['record_id']=$params['response_id'];
					$parms['side']='admin';
					$this->SendEvent('OnFormBrowserRecordEditPostSave',$parms);
					}
				else
					{
					$parms = array();
					$parms['browser_name']=$aebrowser->GetName();
					$parms['browser_alias']=$aebrowser->GetAlias();
					$parms['browser_id']=$aebrowser->GetId();
					$parms['side']='admin';
					$this->SendEvent('OnFormBrowserRecordAddPostSave',$parms);
					}

            	}
            }

		if (! $finished)
			{
			echo $aeform->RenderFormHeader();
        	echo $this->CreateFormStart($id, 'admin_edit_resp', $returnid, 'post', 'multipart/form-data');
        	echo $aeform->RenderForm($id, $params, $returnid);
			echo $this->module_ptr->CreateInputHidden($id, 'browser_id',$params['browser_id']);
			echo $this->CreateInputSubmit($id, 'cancel', lang('cancel'));
        	echo $this->CreateFormEnd();
			echo $aeform->RenderFormFooter();
        	}
        else
        	{
        	if ($results[0] == true)
        		{
        			$browser_id = $params['browser_id'];
        			unset($params);
					$params['module_message']=$this->Lang('updated');
        			$params['browser_id']=$browser_id;
				    $this->Redirect($id, 'admin_browse', $returnid, $params);
        		}
        	else
        		{
        		echo "Error!: ";
        		foreach ($results[1] as $thisRes)
        			{
        			echo $thisRes . '<br />';
        			}
        		}
        	}


?>
