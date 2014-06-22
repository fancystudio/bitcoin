<?php
#-------------------------------------------------------------------------
#
# Author: Lukas Blatter, <lb@blattertech.ch>
# Web: www.blattertech.ch
#
#-------------------------------------------------------------------------
#
# Revisions is a CMS Made Simple module that logs changes in content, CSS,
# GCBs and enables the web developer to revert to earlier versions of it. 
#
#-------------------------------------------------------------------------

if (!$this->CheckPermission('revisions_use'))
	return;

if (isset($params['tab_message'])) {
	echo $this->ShowMessage($this->Lang($params['tab_message']));
}

if (isset($params['errors']) && count($params['errors'])) {
	echo $this->ShowErrors($params['errors']);
}


echo $this->_donate;

$smarty = cmsms()->GetSmarty();

$admintheme = cmsms()->get_variable('admintheme');

echo $this->StartTabHeaders();
if (!empty($params['active_tab'])) {
	$tab = $params['active_tab'];
} else {
	$tab = 'pagetab';
}

if($this->HasPerm('pagePerms'))
{
	echo $this->SetTabHeader('pagetab', $this->Lang('pages'), ($tab == 'pagetab'));
}
if($this->HasPerm('htmlPerms'))
{
	echo $this->SetTabHeader('gcbtab', $this->Lang('gcbs'), ($tab == 'gcbtab'));
}
if($this->HasPerm('templatePerms'))
{
	echo $this->SetTabHeader('templatetab', $this->Lang('templates'), ($tab == 'templatetab'));
}
if($this->HasPerm('cssPerms'))
{
	echo $this->SetTabHeader('stylesheettab', $this->Lang('css'), ($tab == 'stylesheettab'));
}
if($this->GetPreference('delete_revisions_with_content') == false && ($this->HasPerm('pagePerms') || $this->HasPerm('htmlPerms') || $this->HasPerm('templatePerms') || $this->HasPerm('cssPerms')))
{
	echo $this->SetTabHeader('recycletab', $this->Lang('recycle'), ($tab == 'recycletab'));
}
if($this->CheckPermission('revisions_options'))
{
	echo $this->SetTabHeader('optiontab', $this->Lang('options'), ($tab == 'optiontab'));
}

echo $this->EndTabHeaders();
echo $this->StartTabContent();

if($this->HasPerm('pagePerms'))
{
	echo $this->StartTab('pagetab', $params);
	$query = 'SELECT a.content_id, a.module_name, b.content_name AS name, b.hierarchy, COUNT(*) AS revisions FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'content b WHERE a.module_name = "content" AND a.content_id = b.content_id GROUP BY a.content_id ORDER BY b.hierarchy';
	$this->ListContent($query, $id, $returnid);
	echo $this->EndTab();
}

if($this->HasPerm('htmlPerms'))
{
	echo $this->StartTab('gcbtab', $params);
	$query = 'SELECT a.content_id, a.module_name, b.htmlblob_name AS name, COUNT(*) AS revisions FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'htmlblobs b WHERE a.module_name = "gcb" AND a.content_id = b.htmlblob_id GROUP BY a.content_id ORDER BY b.htmlblob_name';
	$this->ListContent($query, $id, $returnid);
	echo $this->EndTab();
}

if($this->HasPerm('templatePerms'))
{
	echo $this->StartTab('templatetab', $params);
	$query = 'SELECT a.content_id, a.module_name, b.template_name AS name, COUNT(*) AS revisions FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'templates b WHERE a.module_name = "template" AND a.content_id = b.template_id GROUP BY a.content_id ORDER BY b.template_name';
	$this->ListContent($query, $id, $returnid);
	echo $this->EndTab();
}

if($this->HasPerm('cssPerms'))
{
	echo $this->StartTab('stylesheettab', $params);
	$query = 'SELECT a.content_id, a.module_name, b.css_name AS name, COUNT(*) AS revisions FROM ' . cms_db_prefix() . 'module_revisions a, ' . cms_db_prefix() . 'css b WHERE a.module_name = "stylesheet" AND a.content_id = b.css_id GROUP BY a.content_id ORDER BY b.css_name';
	$this->ListContent($query, $id, $returnid);
	echo $this->EndTab();
}

if($this->GetPreference('delete_revisions_with_content') == false && ($this->HasPerm('pagePerms') || $this->HasPerm('htmlPerms') || $this->HasPerm('templatePerms') || $this->HasPerm('cssPerms')))
{
	echo $this->StartTab('recycletab', $params);
	$query = 'SELECT a.content_id, a.module_name, a.content_name AS name, a.hierarchy, a.depth, COUNT(b.revision_id) AS revisions FROM ' . cms_db_prefix() . 'module_revisions_recycle a LEFT JOIN ' . cms_db_prefix() . 'module_revisions b ON a.content_id = b.content_id WHERE ';
	$where = array();
	if($this->HasPerm('pagePerms'))
	{
		$where= "a.module_name = 'content'";
		$query2 = $query . ' ' . $where . ' GROUP BY b.content_id ORDER BY a.hierarchy, a.module_name';
		
		$smarty->assign('title',$this->Lang('pages'));
		$this->ListContent($query2, $id, $returnid, true);
	}
	if($this->HasPerm('htmlPerms'))
	{
		$where = "a.module_name = 'gcb'";
		$query2 = $query . ' ' . $where . ' GROUP BY b.content_id ORDER BY a.module_name';
		
		$smarty->assign('title',$this->Lang('gcbs'));
		$this->ListContent($query2, $id, $returnid, true);
	}
	if($this->HasPerm('templatePerms'))
	{
		$where = "a.module_name = 'template'";
		$query2 = $query . ' ' . $where . ' GROUP BY b.content_id ORDER BY a.module_name';
		
		$smarty->assign('title',$this->Lang('templates'));
		$this->ListContent($query2, $id, $returnid, true);
	}
	if($this->HasPerm('cssPerms'))
	{
		$where = "a.module_name = 'stylesheet'";
		$query2 = $query . ' ' . $where . ' GROUP BY b.content_id ORDER BY a.module_name';
		
		$smarty->assign('title',$this->Lang('css'));
		$this->ListContent($query2, $id, $returnid, true);
	}
	
	echo $this->EndTab();
}

if($this->CheckPermission('revisions_options'))
{
	echo $this->StartTab('optiontab', $params);
	include dirname(__FILE__) . '/function.admin_optiontab.php';
	echo $this->EndTab();
}

echo $this->EndTabContent();

?>