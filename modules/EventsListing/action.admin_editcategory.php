<?php
/*======================================================================================
Module: Eventslisting
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;
if ( !$this->CheckPermission('EventsListing: modify categories') ) exit;
$errors = array();

// get parameters
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$category = isset($params['category']) ? (int)$params['category'] : 0;
$active = $params['active'] ? 1 : 0;
$short_desc = isset($params['short_desc']) ? $params['short_desc'] : '';
$long_desc = isset($params['long_desc']) ? $params['long_desc'] : '';
$image = '';
$image_del = isset($params['image_del']) ? $params['image_del'] : 0;

// Save category changes
if (isset($params['submit']) || isset($params['cache']) || isset($params['add']) || isset($params['cacheadd']) || isset($params['apply'])) {
	// Edit category
	if ($category) {
		$sql = 'UPDATE '.cms_db_prefix().'module_eventslisting_category SET short_desc=?, long_desc=?, active=? WHERE entry_id=?';
		$res = $db->Execute($sql,array($short_desc, $long_desc, $active, $category));
		if(!$res) { $errors[] = 'SQL ERROR: ' . $db->ErrorMsg() . '(with ' . $db->sql . ')'; }
	// Insert new category
	} else {
		$sql = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_category (short_desc, long_desc, active) VALUES (?, ?, ?)';
		$res = $db->Execute($sql,array($short_desc, $long_desc, $active));
		$category = $db->GetOne('SELECT entry_id FROM '.cms_db_prefix().'module_eventslisting_category WHERE short_desc = ? ORDER BY entry_id DESC LIMIT 1', array($short_desc));
	}
	// Delete image
	if ($image_del) {
		$filename = $db->GetOne('SELECT image_url FROM '.cms_db_prefix().'module_eventslisting_category WHERE entry_id = ?', array($category));
		if ($filename) {
			$deldir = cms_join_path($config['image_uploads_path'],'Events','categories',$category);
			$delfile = cms_join_path($deldir,$filename);
			if (is_file($delfile)) unlink($delfile);
		}
		$db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_category SET image_url = "" WHERE entry_id = ?', array($category));
	}
	// Upload image
	if (is_array($_FILES)) {
		$params_prefix_tmp = explode(',',$_REQUEST['mact']);
		$params_prefix = $params_prefix_tmp[1];
		$iname = $params_prefix.'image';
		$image = isset($_FILES[$iname]) ? $_FILES[$iname]['name']: '';
		#echo $image;exit;
		if ($image) {
			#$base = cms_join_path($config['image_uploads_path'],'Events'.DIRECTORY_SEPARATOR.'categories');
			$newdir = cms_join_path($config['image_uploads_path'],'Events','categories',$category);
			$dest = cms_join_path($newdir,basename($image));
			#print_r($_FILES);echo "<br />newdir:'$newdir'<br />dest:'$dest'<br />image:'$image'";exit;
			if (!is_dir($newdir)) {
				if (!mkdir($newdir)) $errors[] = "Error creating dir $newdir";
			}
			if (is_dir($newdir)) {
				if (move_uploaded_file($_FILES[$iname]['tmp_name'],$dest)) { $db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_category SET image_url = ? WHERE entry_id = ?', array(basename($image),$category)); }
				else { $errors[] = "Upload failed : Unable to write $dest"; }
			}
		}
		
	}
}

// Redirect
if (isset($params['submit']) || isset($params['add'])) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto, 'errors' => implode(',',str_replace(',',';',$errors)), 'message' => $this->Lang('changessaved')));
elseif (isset($params['cancel'])) $this->Redirect($id, 'defaultadmin', $returnid, array('tabto'=>$tabto));
else $this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto, 'category'=>$category ));

// EOF