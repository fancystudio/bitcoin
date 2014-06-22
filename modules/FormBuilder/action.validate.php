<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/

if (!isset($params['fbrp_f']) || !isset($params['fbrp_r']) || !isset($params['fbrp_c']))
	{
	echo $this->Lang('validation_param_error');
	return false;
	}

$params['response_id']=$params['fbrp_r'];
$params['form_id']=$params['fbrp_f'];
$params['fbrp_user_form_validate']=true;
$aeform = new fbForm($this, $params, true);

if (!$aeform->CheckResponse($params['fbrp_f'], $params['fbrp_r'], $params['fbrp_c']))
{
	echo $this->Lang('validation_response_error');
	return false;
}


/* Stikki removed: Old stuff, should be removed from Form.class.php aswell
else
{
	//[#2792] DeleteResponse is never called on validation;
	//$aeform->DeleteResponse($params['fbrp_r']);
}
*/

$fields = $aeform->GetFields();
$confirmationField = -1;
for($i=0;$i<count($fields);$i++)
	{
	if ($fields[$i]->GetFieldType() == 'DispositionEmailConfirmation')
		{
		$confirmationField = $i;
		break;
		}
	}
	
if ($confirmationField != -1)
	{
	$fields[$confirmationField]->ApproveToGo($params['fbrp_r']);
	$results = $aeform->Dispose($returnid);
	if ($results[0] == true)
		{
		$ret = $fields[$confirmationField]->GetOption('redirect_page','-1');
		if ($ret != -1)
			{
			$this->RedirectContent($ret);
			}
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
else
	{
		echo $this->Lang('validation_no_field_error');
	}
?>
