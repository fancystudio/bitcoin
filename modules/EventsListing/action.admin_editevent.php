<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify events') ) exit;
$errors = array();

// get parameters
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$event = isset($params['event']) ? (int)$params['event'] : 0;
$active = $params['active'] ? 1 : 0;
$short_desc = isset($params['short_desc']) ? $params['short_desc'] : '';
$long_desc = isset($params['long_desc']) ? $params['long_desc'] : '';
$detail_link = preg_replace('/[^0-9]/','',$params['detail_link']);
$start_date	= (isset($params['start_date_Month']) ? mktime($params['start_date_Hour'], $params['start_date_Minute'], $params['start_date_Second'], $params['start_date_Month'], $params['start_date_Day'], $params['start_date_Year']) : 'time()');
$end_date	= (isset($params['end_date_Month']) ? mktime($params['end_date_Hour'], $params['end_date_Minute'], $params['end_date_Second'], $params['end_date_Month'], $params['end_date_Day'], $params['end_date_Year']) : 'time()');
$image = '';
$image_del = isset($params['image_del']) ? $params['image_del'] : 0;

// Save event changes
if (isset($params['submit']) || isset($params['cache']) || isset($params['add']) || isset($params['cacheadd']) || isset($params['apply'])) {
	// Edit event
	if ($event) {
		$sql = 'UPDATE '.cms_db_prefix().'module_eventslisting_events SET short_desc=?, long_desc=?, active=?, start_date=?, end_date=?, detail_link=? WHERE entry_id=?';
		$res = $db->Execute($sql,array($short_desc, $long_desc, $active, trim($db->DBTimeStamp($start_date), "'"), trim($db->DBTimeStamp($end_date), "'"), $detail_link, $event));
		if(!$res) { $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')'; }
		// Update categories
		$db->Execute('DELETE FROM '.cms_db_prefix().'module_eventslisting_category_events WHERE event_id=?', array($event));
		#print_r($params);exit;
		if (is_array($params['cats'])) {
			foreach ($params['cats'] as $catid) {
				$catid=(int)$catid;
				if ($catid>0) {
					$query = 'INSERT '.cms_db_prefix().'module_eventslisting_category_events (cat_id,event_id,modified_date) VALUES (?,?,?)';
					$db->Execute($query, array($catid,$event,trim($db->DBTimeStamp(time()), "'")));
				}
			}
		}
	// Insert new event
	} else {
		$sql = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_events (short_desc, long_desc, active, start_date, end_date, detail_link) VALUES (?, ?, ?, ?, ?, ?)';
		$res = $db->Execute($sql,array($short_desc, $long_desc, $active, trim($db->DBTimeStamp($start_date), "'"), trim($db->DBTimeStamp($end_date), "'"), $detail_link));
		$event = $db->GetOne('SELECT entry_id FROM '.cms_db_prefix().'module_eventslisting_events WHERE short_desc = ? ORDER BY entry_id DESC LIMIT 1', array($short_desc));
		// Insert categories
		if (is_array($params['cats'])) {
			foreach ($params['cats'] as $catid) {
				$catid=(int)$catid;
				if ($catid>0) {
					$query = 'INSERT '.cms_db_prefix().'module_eventslisting_category_events (cat_id,event_id,modified_date) VALUES (?,?,?)';
					$db->Execute($query, array($catid,$event,trim($db->DBTimeStamp(time()), "'")));
				}
			}
		}
	}
	// Delete image
	if ($image_del) {
		$filename = $db->GetOne('SELECT image_url FROM '.cms_db_prefix().'module_eventslisting_events WHERE entry_id = ?', array($event));
		if ($filename) {
			$deldir = cms_join_path($config['image_uploads_path'],'Events','events',$event);
			$delfile = cms_join_path($deldir,$filename);
			if (is_file($delfile)) unlink($delfile);			
		}
		$db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_events SET image_url = "" WHERE entry_id = ?', array($event));
	}
	// Upload image
	if (is_array($_FILES)) {
		$params_prefix_tmp = explode(',',$_REQUEST['mact']);
		$params_prefix = $params_prefix_tmp[1];
		$iname = $params_prefix.'image';
		$image = isset($_FILES[$iname]) ? $_FILES[$iname]['name']: '';
		#echo $image;exit;
		if ($image) {
			#$base = cms_join_path($config['image_uploads_path'],'Events'.DIRECTORY_SEPARATOR.'events');
			$newdir = cms_join_path($config['image_uploads_path'],'Events','events',$event);
			$dest = cms_join_path($newdir,basename($image));
			#print_r($_FILES);echo "<br />newdir:'$newdir'<br />dest:'$dest'<br />image:'$image'";exit;
			if (!is_dir($newdir)) {
				if (!mkdir($newdir)) $errors[] = "Error creating dir $newdir";
			}
			if (is_dir($newdir)) {
				if (move_uploaded_file($_FILES[$iname]['tmp_name'],$dest)) { $db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_events SET image_url = ? WHERE entry_id = ?', array(basename($image),$event)); }
				else { $errors[] = "Upload failed : Unable to write $dest"; }
			}
		}
		
	}
}

// Redirect
if (isset($params['submit']) || isset($params['add'])) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto, 'errors' => implode(',',str_replace(',',';',$errors)), 'message' => $this->Lang('changessaved')));
elseif (isset($params['cancel'])) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto));
else $this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto, 'event'=>$event ));

// EOF