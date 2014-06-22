<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
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
#END_LICENSE
if( !isset($gCms) ) exit;

// this tab has merely one mofo list of uses and the ability to edit them, 
// see details about them, and then delete them

//
// initialization
//
$admintheme = cms_utils::get_theme_object();

if( $this->_HasSufficientPermissions('listusers') ) {

  $filter = $bare_filter = array('group'=>'','regex'=>'','loggedinonly'=>0,'limit'=>50,
				 'viewprops'=>array(),'propsel'=>'','propval'=>'','sortby'=>'username asc');
  $tmp = cms_userprefs::get('feu_filter');
  if( $tmp ) $filter = unserialize($tmp);

  // bulk action stuff
  if( isset( $params['bulkdelete']) ) {
    if( isset($params['selected']) && is_array($params['selected']) ) {
      $sel = serialize($params['selected']);
      $this->myRedirect( $id, 'admin_bulkactions', $returnid, array('job'=>'delete','uids'=>$sel));
    }
  }

  // filtering stuff
  if( isset( $params['filter_reset'] ) ) {
    cms_userprefs::remove('feu_filter');
    $filter = $bare_filter;
  }
  else if( isset( $params['filter']) ) {
    $filter['group'] = get_parameter_value($params,'filter_group');
    $filter['regex'] = trim(get_parameter_value($params,'filter_regex'));
    $filter['loggedinonly'] = (int)get_parameter_value($params,'filter_loggedinonly');
    $filter['limit'] = (int)get_parameter_value($params,'filter_limit');
    $filter['sortby'] = trim(get_parameter_value($params,'filter_sortby'));
    $filter['viewprops'] = get_parameter_value($params,'filter_viewprops');
    $filter['propsel'] = trim(get_parameter_value($params,'filter_propertysel'));
    if( $filter['propsel'] == 'none' ) $filter['propsel'] = '';
    $filter['propval'] = trim(get_parameter_value($params,'filter_property'));
    cms_userprefs::set('feu_filter',serialize($filter));
  }

  $smarty->assign('filter',$filter);
  $filterapplied = ($filter != $bare_filter);
  $smarty->assign('filter_applied',$filterapplied);

  // get a group list for the filter
  // it should be ready to go right into the dropdown (cool eh)
  $groups1 = $this->GetGroupList();
  if( count($groups) ) {
    $groups = array_merge( array($this->Lang('any') => -1), $groups1 );
    $smarty->assign('groups',array_flip($groups));
  }

  // a pulldown list for limits
  $limits = array( '10' => 10,
		   '25' => 25,
		   '50' => 50,
		   '100' => 100,
		   '250' => 250,
		   '500' => 500 );
  $smarty->assign('limits',$limits);

  // a pulldown list for property definitions
  $defns1 = $this->GetPropertyDefns();
  $defns = array();
  $defns['None'] = 'none';
  $alldefns = array();
  if( is_array($defns1) ) {
    foreach( $defns1 as $def ) {
      if( $def['prompt'] == '' || $def['name'] == '' ) continue;
      if( $def['encrypt'] ) continue; // you can't view encrypted properties in this list.
      $defns[$def['prompt']] = $def['name'];
      $alldefns[$def['name']] = $def['prompt'];
   }
  }
  $smarty->assign('defnlist',array_flip($defns));
	
  // a pulldown list for sorting
  $sorts = array( $this->Lang('sortby_username_asc') => 'username asc',
		  $this->Lang('sortby_username_desc') => 'username desc',
		  $this->Lang('sortby_create_asc') => 'createdate asc',
		  $this->Lang('sortby_create_desc') => 'createdate desc',
		  $this->Lang('sortby_expires_asc') => 'expires asc',
		  $this->Lang('sortby_expires_desc') => 'expires desc' );
  $smarty->assign('sortlist',array_flip($sorts));

  // now setup the template fields
  $smarty->assign( 'prompt_sort', $this->Lang('sort'));
  $smarty->assign( 'startform', $this->CGCreateFormStart( $id, 'defaultadmin', $returnid, array('cg_activetab'=>'users')));
  $smarty->assign( 'perm_removeusers', $this->_HasSufficientPermissions('removeusers')?1:0);
  $smarty->assign( 'usersfound', $this->Lang('usersfound'));
  $smarty->assign( 'alldefns',$alldefns);
  $smarty->assign( 'viewprops',$filter['viewprops']);
  $smarty->assign( 'endform', $this->CreateFormEnd ());

  // now get our users
  $users = null;
  $curpage = 1;
  $nmatches = 0;
  if( isset($params['page']) ) $curpage = (int)$params['page'];
  $offset = ($curpage - 1) * $filter['limit'];
  try {
    $users = $this->GetUsersInGroup( $filter['group'], $filter['regex'], $filter['limit'], $filter['sortby'], $filter['propsel'], 
				     $filter['propval'], $filter['loggedinonly'], $offset );
    $nmatches = $this->get_lastuserquery_count();
  }
  catch( Exception $e ) {
    $this->_DisplayErrorPage ($id, $params, $returnid, $e->GetMessage() );
  }
  if( !is_array($users) ) {
    // an error occurred
    $this->_DisplayErrorPage ($id, $params, $returnid, $db->ErrorMsg() );
  }

  // calculate pages and page links.
  $npages = (int)($nmatches / $filter['limit']);
  if( $nmatches % $filter['limit'] != 0 ) $npages++;
  $curpage = max(0,min($curpage,$npages));

  $nav = array();
  $nav['npages'] = $npages;
  $nav['curpage'] = $curpage;
  if( $curpage > 1 ) {
    $nav['firstpage_url'] = $this->create_url($id,'defaultadmin','', array('cg_activetab'=>'users','page'=>1));
    $nav['prevpage_url'] = $this->create_url($id,'defaultadmin','', array('cg_activetab'=>'users','page'=>$curpage-1));
  }
  if( $curpage < $npages ) {
    $nav['nextpage_url'] = $this->create_url($id,'defaultadmin','', array('cg_activetab'=>'users','page'=>$curpage+1));
    $nav['lastpage_url'] = $this->create_url($id,'defaultadmin','', array('cg_activetab'=>'users','page'=>$npages));
  }
  $smarty->assign('navigation',$nav);
  
  // get the total number of users
  $numusers = $this->CountUsersInGroup( $filter['group'] );
  
  // get the selected properties.
  if( is_array($filter['viewprops']) && count($filter['viewprops']) ) {
    if( count($users) ) {
      $uids = array();
      foreach( $users as $row ) {
	$uids[] = $row['id'];
      }

      $query = "SELECT A.id,";
      $flds = array();
      $conds = array();
      for( $i = 0; $i < count($filter['viewprops']); $i++ ) {
	$prop = $filter['viewprops'][$i];
	$nm = 'j'.$i;
	$flds[]  = "$nm.data as $prop";
	$conds[] = cms_db_prefix()."module_feusers_properties AS $nm ON A.id = $nm.userid AND ($nm.title = '$prop')";
      }
      $query .= implode(',',$flds).' FROM '.cms_db_prefix().'module_feusers_users A';
      $query .= ' LEFT JOIN '.implode(' LEFT JOIN ',$conds);
      $query .= ' WHERE A.id IN ('.implode(',',$uids).')';
      $dbr = $db->Execute('SET sql_big_selects = 1');
      $tmp = $db->GetArray($query);
      $extraprops = cge_array::to_hash($tmp,'id');
    }
  }

  // build the user list.
  $rowarray = array();
  $smarty->assign('numusers', $numusers );
  $consumer = feu_utils::get_auth_consumer();
  if( $this->GetPreference('username_is_email') && get_class($consumer) == 'feu_std_consumer' ) {
    $smarty->assign('usernametext', $this->Lang('prompt_email'));
  }
  else {
    $smarty->assign('usernametext', $this->Lang('username'));
  }
  $smarty->assign('emailtext', $this->Lang('email'));
  $smarty->assign('statustext', $this->Lang('status'));
  $smarty->assign('createdtext', $this->Lang('created'));
  $smarty->assign('expirestext', $this->Lang('expires'));
  if( is_array($users) ) {
    foreach( $users as $row ) {
      $onerow = new StdClass();
      $onerow->id = $row['id'];
      $onerow->created  = $row['createdate'];
      $onerow->username = $this->CreateLink($id, 'edituser', $returnid, $row['username'], array('user_id' => $row['id']));
      $onerow->expires  = $row['expires'];
      if( $this->_HasSufficientPermissions('listusers') ) {
	$onerow->historylink =
	  $this->CreateLink ($id, 'userhistory', $returnid,
			     $admintheme->DisplayImage('icons/system/info.gif',$this->Lang('history'),'','','systemicon'),
			     array('user_id'=>$row['id']));
      }
      
      if( $this->_HasSufficientPermissions('editusers') ) {
	$onerow->editlink =
	  $this->CreateLink ($id, 'edituser', $returnid,
			     $admintheme->DisplayImage('icons/system/edit.gif', $this->Lang ('edit'), '', '', 'systemicon'),
			     array ('user_id' => $row['id'] ));
	if( $row['loggedin'] ) {
	  $onerow->logoutlink =
	    $this->CreateLink ($id,'admin_logout',$returnid,
			       $admintheme->DisplayImage('icons/system/back.gif', $this->Lang('prompt_logout'),'','','systemicon'),
			       array('user_id'=>$row['id']));
	}
      }
	      
      if( $this->_HasSufficientPermissions('removeusers') ) {
	$onerow->deletelink = 
	  $this->CreateLink ($id,'do_deleteuser',$returnid,
			     $admintheme->DisplayImage('icons/system/delete.gif',$this->Lang ('delete'), '', '', 'systemicon'),
			     array ('user_id' => $row['id']),
			     $this->Lang ('areyousure_delete',$row['username']));
      }
	      
      if( is_array($filter['viewprops']) && count($filter['viewprops']) ) {
	$onerow->extra = array();
	foreach( $filter['viewprops'] as $one ) {
	  if( isset($extraprops[$onerow->id][$one]) ) $onerow->extra[$one] = $extraprops[$onerow->id][$one];
	}
      }
      
      $rowarray[] = $onerow;
    }
  }

  $smarty->assign('itemcount',count($rowarray));
  $smarty->assign('items',$rowarray);
} // listusers permission

if( $this->_HasSufficientPermissions('adduser') ) {
  if( $this->GetPreference('require_onegroup') == 0 || count($groups1) > 0 ) {
    $smarty->assign('addlink', 
		    $this->CreateLink($id,'adduser',$returnid,
				      $admintheme->DisplayImage('icons/system/newobject.gif',$this->Lang('adduser'),'','','systemicon'),
				      array(), '', false, false, '').' '.
		    $this->CreateLink( $id, 'adduser', $returnid, $this->Lang('adduser'), array(), '', false, false,
				       'class="pageoptions"'));
  }
  else {
    $smarty->clear_assign('addlink');
  }
}
if( $this->_HasSufficientPermissions('users') ) {
  if( count($groups) ) $smarty->assign('import_url',$this->create_url($id,'admin_import_users',$returnid));
  if( count($rowarray) ) $smarty->assign('export_url',$this->create_url($id,'admin_export_users',$returnid));
}

echo $this->ProcessTemplate( 'userlist.tpl' );

// EOF
?>