<?php
if (!isset($gCms)) exit;

/*---------------------------------------------------------
 Upgrade()
 If your module version number does not match the version
 number of the installed module, the CMS Admin will give
 you a chance to upgrade the module. This is the function
 that actually handles the upgrade.
 Ideally, this function should handle upgrades incrementally,
 so you could upgrade from version 0.0.1 to 10.5.7 with
 a single call. For a great example of this, see the News
 module in the standard CMS install.
 ---------------------------------------------------------*/

$db = $this->GetDb();
$dict = NewDataDictionary($db);
$current_version = $oldversion;

switch($current_version)
{
  case "1.0":
  case "1.0.1":
  case "1.0.2":
  case "1.0.3":
  case "1.0.4":
    // register events
    $this->CreateEvent( 'PrefsUpdated' );
    
    // Add 'follow' field for <meta name=robots tag
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_seotools2','follow I');
    $dict->ExecuteSQLArray($sqlarray);

    $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET follow = ?';
    $db->Execute($query,array(1));
    
    // Set the viewport meta tag as a std additional tag
    $oldstuff = $this->GetPreference('additional_meta_tags');
    $viewport = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
    if (strpos($oldstuff, strtolower('<meta name="viewport"')) !== false){
      $viewport = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
      $newstuff = $oldstuff . $viewport;
      $this->SetPreference('additional_meta_tags', $newstuff);
    }
        // New Page Meta info preferences
    $this->SetPreference('meta_doctype',3);
    $this->SetPreference('compile_udts',1);
    $this->SetPreference('r_before','');
    $this->SetPreference('r_after','');
    $this->SetPreference('detail_keywords_var','');
    
    $this->AddEventHandler('Core','ContentEditPre',false);
    $this->AddEventHandler('Core','ContentEditPost',false);
    $this->AddEventHandler('Core','ContentDeletePost',false);
    $this->AddEventHandler('Core','ContentPostRender',false);
        
    break;
    
  case "1.0.5":
  case "1.0.6":
  case "1.0.7":
  case "1.0.8":
  case "1.0.9":
  case "1.0.10":
  case "1.0.11":
    // Add 'follow' field for <meta name=robots tag
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_seotools2','follow I');
    $dict->ExecuteSQLArray($sqlarray);

    $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET follow = ?';
    $db->Execute($query,array(1));
    
    // Set the viewport meta tag as a std additional tag
    $oldstuff = $this->GetPreference('additional_meta_tags');
    if (strpos($oldstuff, strtolower('<meta name="viewport"')) !== false){
      $viewport = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
      $newstuff = $oldstuff . $viewport;
      $this->SetPreference('additional_meta_tags', $newstuff);
    }
        
    // New Page Meta info preferences
    $this->SetPreference('meta_doctype',3);
    $this->SetPreference('compile_udts',1);
    $this->SetPreference('r_before','');
    $this->SetPreference('r_after','');
    $this->SetPreference('detail_keywords_var','');
    
    $this->AddEventHandler('Core','ContentEditPre',false);
    $this->AddEventHandler('Core','ContentEditPost',false);
    $this->AddEventHandler('Core','ContentDeletePost',false);
    $this->AddEventHandler('Core','ContentPostRender',false);
    
    break;
    
  case "1.1":
  case "1.1.1":
  case "1.1.2":
    $this->SetPreference('r_before','');
    $this->SetPreference('r_after','');
    $this->SetPreference('detail_keywords_var','');
    
    $query = "SELECT * FROM " . cms_db_prefix() . "module_seotools2";
    if (!$result = $db->Execute($query)) {
      echo "There was a problem accessing the ". $this->GetFriendlyName() . " table in the database";
      die;
    }
    
    if ($result->RecordCount() > 0 ) {
      while ($row = $result->fetchRow()) {
        $spaces = $row['keywords'];
        $content_id = $row['content_id'];
        if (!empty($spaces)){
          $keywords = str_replace(' ',',',$spaces);
          $query = 'UPDATE '.cms_db_prefix().'module_seotools2 SET keywords = ? WHERE content_id = ?';
          $db->Execute($query,array($keywords,$content_id));
        }
      }
    }
    $this->AddEventHandler('Core','ContentEditPre',false);
    $this->AddEventHandler('Core','ContentEditPost',false);
    $this->AddEventHandler('Core','ContentDeletePost',false);
    $this->AddEventHandler('Core','ContentPostRender',false);

  case "1.2":
  default:
    break;
    
}

// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('upgraded',$this->GetVersion()));

?>