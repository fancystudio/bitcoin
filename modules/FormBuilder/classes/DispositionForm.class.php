<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

class fbDispositionForm extends  fbFieldBase
{


  function __construct(&$form_ptr, &$params)
  {
    parent::__construct($form_ptr, $params);
    $mod = $form_ptr->module_ptr;
    $this->Type = 'DispositionForm';
    $this->IsDisposition = true;
    $this->NonRequirableField = true;
    $this->DisplayInForm = false;
    $this->sortable = false;
   }

  function StatusInfo()
  {
    $mod=$this->form_ptr->module_ptr;
    return $this->GetOption('method').' '.$this->GetOption('url');
  }

	function DisposeForm($returnid)
  {
    $mod=$this->form_ptr->module_ptr;
    $fptr=$this->form_ptr;
    $msg = '';
    $submission = $this->GetOption('url');
    $payload = array();
	 $theFields = $fptr->GetFields();
	 $unspec = $fptr->GetAttr('unspecified',$mod->Lang('unspecified'));

	 for($i=0;$i<count($theFields);$i++)
      {
      if ($this->GetOption('sub_'.$theFields[$i]->GetId(),'0') == '1')
         {
         $pl = urlencode($this->GetOption('fld_'.$theFields[$i]->GetId())).'='.
            urlencode($theFields[$i]->GetHumanReadableValue());
         array_push($payload,$pl);
         }
		}
    if ($this->GetOption('additional','') != '')
      {
       array_push($payload,$this->GetOption('additional'));
      }
    $send_payload = implode('&',$payload);
    if ($this->GetOption('method','POST') == 'POST')
         {
         $ch = curl_init($this->GetOption('url'));
         curl_setopt($ch, CURLOPT_POST,1);
         curl_setopt($ch, CURLOPT_POSTFIELDS,$send_payload);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,0);
         $res = curl_exec($ch);
         if (!$res)
            {
            $msg = curl_error($ch);
            }
         curl_close($ch);
         }
      else
         {
         $url = $this->GetOption('url');
         if (strpos($url,'?'))
            {
            $url .= '&'.$send_payload;
            }
         else
            {
            $url .= '?'.$send_payload;
            }
         $ch = curl_init($url);
         curl_setopt($ch, CURLOPT_HTTPGET,1);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER,0);
         $res = curl_exec($ch);
         if (!$res)
            {
            $msg = curl_error($ch);
            }
         curl_close($ch);
         }
    return array($res,$msg);
  }


  function PrePopulateAdminForm($formDescriptor)
  {
	global $gCms;
    $mod = $this->form_ptr->module_ptr;
    $fpt = $this->form_ptr;

    $main = array();
    $adv = array();
    $methods = array('POST'=>'POST','GET'=>'GET');
    if (!function_exists('curl_init'))
      {
      array_push($main,array('',$mod->Lang('title_install_curl')));
      }
    else
      {
    array_push($main,array($mod->Lang('title_method'),
				$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_method', $methods, -1,
               $this->GetOption('method'))));
    array_push($main,array($mod->Lang('title_url'),
			   $mod->CreateInputText($formDescriptor, 'fbrp_opt_url',
						 $this->GetOption('url',''),40,255).'<br />'.
                   $mod->Lang('title_url_help')));
     $fields = $fpt->GetFields();
      foreach($fields as $tf)
         {
         $al = $tf->GetAlias();
         if (empty($al))
            {
            $al = $tf->GetVariableName();
            }
         array_push($adv,array($mod->Lang('title_maps_to',$tf->GetName()),
			   $mod->CreateInputText($formDescriptor, 'fbrp_opt_fld_'.$tf->GetId(),
						 $this->GetOption('fld_'.$tf->GetId(),$al),40,255).
            $mod->CreateInputHidden($formDescriptor,'fbrp_opt_sub_'.$tf->GetId(),'0').
            $mod->CreateInputCheckbox($formDescriptor,'fbrp_opt_sub_'.$tf->GetId(),'1',
               $this->GetOption('sub_'.$tf->GetId(),($tf->DisplayInSubmission()?'1':'0'))).
            $mod->Lang('title_include_in_submission')));
         }
      array_push($adv,array($mod->Lang('title_additional'),
			   $mod->CreateInputText($formDescriptor, 'fbrp_opt_additional',
						 $this->GetOption('additional'),40,255).'<br />'.
                   $mod->Lang('title_additional_help')));

      }
    return array('main'=>$main,'adv'=>$adv);
  }

  function PostPopulateAdminForm(&$mainArray, &$advArray)
  {
    $this->HiddenDispositionFields($mainArray, $advArray);
  }
}

?>
