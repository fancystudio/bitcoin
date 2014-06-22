<?php
if (!isset($gCms)) exit;

if (! isset($params['form_id']) && isset($params['form']))
  {
    // get the form by name, not ID
    $params['form_id'] = $this->GetFormIDFromAlias($params['form']);
  }

$aeform = new fbForm($this,$params,true);

$spec = $aeform->GetName().".xml";
$spec = preg_replace('/[^\w\d\.\-\_]/','_',$spec);
$xmlstr = $aeform->ExportXML(isset($params['fbrp_export_values'])?true:false);

    @ob_clean();
    @ob_clean();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Content-Description: File Transfer');
    header('Content-Type: application/force-download; charset=utf-8');
    header('Content-Length: ' . strlen($xmlstr));
    header('Content-Disposition: attachment; filename=' . $spec);
    echo $xmlstr;
    exit;
?>