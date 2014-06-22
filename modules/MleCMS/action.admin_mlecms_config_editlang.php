<?php

# Module: Multilanguage CMS
# Zdeno Kuzmany (zdeno@kuzmany.biz) kuzmany.biz
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2009 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

if (!isset($gCms))
    exit;

$db = cmsms()->GetDb();
$config = cmsms()->GetConfig();

$direction = '';

if (!$this->CheckAccess()) {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
}

if (isset($params['cancel'])) {
    $this->RedirectToTab($id, "mle_config");
}

$compid = '';
if (isset($params['compid'])) {
    $compid = (int) $params['compid'];
}

$name = '';
if (isset($params['name'])) {
    $name = $params['name'];
}

$alias = '';
if (isset($params['alias'])) {
    $alias = $params['alias'];
}

$extra = '';
if (isset($params['extra'])) {
    $extra = $params['extra'];
}

$locale = get_site_preference('frontendlang', '');
if (isset($params['locale'])) {
    $locale = $params['locale'];
}

$flag = '';

if (isset($params['submit'])) {

    $destdir = cms_join_path($config['image_uploads_path'], $this->GetName());

    $errors = array();
    if (!is_dir($destdir))
        cge_dir::mkdirr($destdir);

    $handler = cge_setup::get_uploader($id, $destdir);
    $handler->set_allow_overwrite(true);
    $res = $handler->handle_upload('flag', '', '');
    $err = $handler->get_error();
    if ($res === FALSE) {
        if (empty($compid) == false) {
            // load flag from DB
            $tmp_lang = mle_tools::get_lang($compid);
            $flag = $tmp_lang["flag"];
        }
    } else {
        $flag = 'images/' . $this->GetName() . '/' . $res;
    }

    // handle image delete first
    if (isset($params['deleteimg'])) {
        $srcname = cms_join_path($destdir, $params['deleteimg']);
        @unlink($srcname);
        $flag = '';
    }



    if ($compid == "") {
        // insert the order record
        $sort = $db->GetOne('SELECT MAX(sort) FROM ' . cms_db_prefix() . 'module_mlecms_config');
        $query = 'INSERT INTO ' . cms_db_prefix() . 'module_mlecms_config
		(name,alias,extra,locale,setlocale,direction,flag,sort,created_date,modified_date)
		VALUES (?,?,?,?,?,?,?,?,NOW(),NOW())';
        $dbr = $db->Execute($query, array($name, $alias, $extra, $locale, $setlocale, $direction, $flag, ($sort + 1)));
        $cid = $db->Insert_ID();
        if (!$cid) {
            echo $this->ShowErrors($this->Lang('nonamegiven'));
        }
    } else {
        $query = 'UPDATE  ' . cms_db_prefix() . 'module_mlecms_config set
		name=?,
                alias = ?,
                extra = ?,
                locale = ?,
                setlocale = ?,
                direction = ?,
                flag  = ?,
                modified_date = NOW()
		WHERE id = ?';
        $dbr = $db->Execute($query, array($name, $alias, $extra, $locale, $setlocale, $direction, $flag, $compid));
        $cid = $compid;
    }

    $errors = array();
    // send event
    @$this->SendEvent('LangEdited', array('compid' => $cid));
    $this->SetMessage($this->Lang('info_success'));
    //redirect
    $this->RedirectToTab($id, "mle_config");
}

//if($compid != "")
#Display template
if ($compid) {
    $this->smarty->assign('startform', $this->CreateFormStart($id, 'admin_mlecms_config_editlang', $returnid, 'post', 'multipart/form-data', false, '', array("compid" => $compid)));
    $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_mlecms_config  WHERE id = ?';
    $row = $db->GetRow($query, array($compid));
    if ($row["name"])
        $name = $row["name"];
    if ($row["alias"])
        $alias = $row["alias"];
    if ($row["extra"])
        $extra = $row["extra"];
    if ($row["locale"])
        $locale = $row["locale"];
    if ($row["flag"])
        $flag = $row["flag"];
}else {
    $this->smarty->assign('startform', $this->CreateFormStart($id, 'admin_mlecms_config_editlang', $returnid, 'post', 'multipart/form-data'));
}
$this->smarty->assign('endform', $this->CreateFormEnd());


$this->smarty->assign('name', $this->CreateInputText($id, 'name', $name, 50, 255));
$this->smarty->assign('alias', $this->CreateInputText($id, 'alias', $alias, 50, 255));
$this->smarty->assign('extra', $this->CreateInputText($id, 'extra', $extra, 50, 255));
$this->smarty->assign('locale', $this->CreateInputDropdown($id, 'locale', mle_tools::getLangsLocale(), -1, (array_search($locale, mle_tools::getLangsLocale()) ? $locale : "custom")));
$this->smarty->assign('flag', $flag);
$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', $this->lang('submit')));
$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', $this->lang('cancel')));


echo $this->ProcessTemplate('editlang.tpl');
?>

