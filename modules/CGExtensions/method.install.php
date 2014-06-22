<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

$db = cmsms()->GetDb();
$taboptarray = array( 'mysql' => 'TYPE=MyISAM' );
$dict = NewDataDictionary($db);

// tables
$flds = "id   I KEY AUTO,
         code C(2) KEY,
         name C(50),
         sorting I DEFAULT 0";
$sqlarray = $dict->CreateTableSQL(CGEXTENSIONS_TABLE_COUNTRIES,$flds,$taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateTableSQL(CGEXTENSIONS_TABLE_STATES,$flds,$taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "id I KEY AUTO,
         key1 C(255),
         key2 C(255),
         key3 C(255),
         key4 C(255),
         data X,
         type C(20),
         expiry C(20),
         create_date ".CMS_ADODB_DT.",
         modified_date ".CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(CGEXTENSIONS_TABLE_ASSOCDATA,$flds,$taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// default content
$fn = cms_join_path(dirname(__FILE__),'countries.txt');
$raw_countries = @file($fn);
$query = 'INSERT INTO '.CGEXTENSIONS_TABLE_COUNTRIES.' (code,name,sorting) VALUES (?,?,0)';
foreach($raw_countries as $one)
{
  list($acronym,$country_name) = explode(',',$one);
  $acronym = trim($acronym);
  $country_name = trim($country_name);
  $db->Execute($query,array($acronym,$country_name));
}

$fn = cms_join_path(dirname(__FILE__),'states.txt');
$raw_states = @file($fn);
$query = 'INSERT INTO '.CGEXTENSIONS_TABLE_STATES.' (code,name,sorting) VALUES (?,?,0)';
foreach($raw_states as $one)
{
  list($acronym,$state_name) = explode(',',$one);
  $acronym = trim($acronym);
  $state_name = trim($state_name);
  $db->Execute($query,array($acronym,$state_name));
}


// Preferences
$this->SetPreference('imageextensions','jpg,png,gif');
$this->SetPreference('thumbnailsize',75);
$this->SetPreference('watermark_text',get_site_preference('sitename','CMSMS Site'));
$this->SetPreference('watermark_textsize',12);
$this->SetPreference('watermark_angle',0);
$this->SetPreference('watermark_font','ARIAL.TTF');
$this->SetPreference('watermark_bgcolor','#FFFFFF');
$this->SetPreference('watermark_textcolor','#000000');
$this->SetPreference('watermark_transparent',1);

// templates
$this->ResetErrorTemplate();

$fn = dirname(__FILE__).'/templates/orig_sortablelist_template.tpl';
if( file_exists($fn) ) {
  $template = @file_get_contents($fn);
  $this->SetPreference('dflt_sortablelist_template_content',$template);
  $this->SetTemplate('sortablelists_Sample',$template);
  $this->SetPreference('dflt_sortablelist_template','Sample');
}

// add a contentpostrender event
$this->AddEventHandler('Core','ContentPostRender',false);

?>
