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

abstract class cge_report_base
{
  private $_page_separator; // code.
  private $_report_header; // hash
  private $_report_footerr; // hash
  private $_page_header; // hash
  private $_page_footer; // hash
  private $_rsrc;        // smarty resource.

  private $_query;
  private $_pagenumber = -1;

  public function __construct()
  {
    // nothing here
  }

  abstract public function &get_module();

  abstract public function get_name();

  abstract public function get_description();

  abstract protected function get_page_template();

  abstract protected function get_page_count();

  abstract protected function get_page_data($page_number);

  abstract protected function get_pagelimit();

  protected function get_page_separator() {return '<div style="page-break-after: always;"></div>';}

  protected function get_page_header_data($pagenum) {}

  protected function get_page_footer_data($pagenum) {}

  protected function get_report_header_data() {}

  protected function get_report_footer_data() {}


  public function generate()
  {
    $mod = $this->get_module();
    if( !$mod ) return FALSE;

    $firstpage = FALSE;
    $lastpage = FALSE;
    if( $this->_pagenumber < 0  )
      {
	$firstpage = TRUE;
	$this->_pagenumber = 0;
      }
    if( $this->get_page_count() <= 0 )
      {
	return FALSE;
      }
    if( $this->get_page_count() > 0 && $this->_pagenumber + 1 == $this->get_page_count() )
      {
	$lastpage = TRUE;
      }

    $gCms = cmsms();
    $smarty = cmsms()->GetSmarty();

    //
    // give stuff to smarty.
    //

    // user info.
    $uid = get_userid(false);
    if( $uid )
      {
	$userops = $gCms->GetUserOperations();
	$user = $userops->LoadUserById($uid);
	if( is_object($user) )
	  {
	    $smarty->assign('user',$user);
	  }
      }

    $pagination = array();
    $pagination['firstpage'] = $firstpage;
    $pagination['lastpage'] = $lastpage;
    $pagination['pagecount'] = $this->get_page_count();
    $pagination['pagenum'] = $this->_pagenumber + 1;
    $smarty->assign('pagination',$pagination);
    $smarty->assign('report_name',$this->get_name());
    $smarty->assign('report_description',$this->get_description());
    $smarty->assign('mod',$mod);
    $smarty->assign('pagebreak',$this->get_page_separator());

    if( $firstpage )
      {
	$smarty->assign('report_header_data',$this->get_report_header_data());
      }
    if( $lastpage )
      {
	$smarty->assign('report_footer_data',$this->get_report_footer_data());
      }

    $report = '';
    for( $page = 0; $page < $this->get_page_count(); $page++ )
      {
	if( $page == 0 )
	  {
	    $smarty->assign('page_header_data',$this->get_page_header_data($page));
	  }

	$smarty->assign('page_footer_data',$this->get_page_footer_data($page));
	$pagination['pagenum'] = $page + 1;
	$smarty->assign('pagination',$pagination);
	
	$data = $this->get_page_data($page);
	if( !is_array($data) || count($data) == 0 ) break;
	
	$smarty->assign('report_data',$data);

	$rendered_page = $mod->ProcessTemplateFromDatabase($this->get_page_template());

	if( $page + 1 < $this->get_page_count() )
	  {
	    $rendered_page .= $this->get_page_separator();
	  }

	$report .= $rendered_page;
      }
    return $report;
  }
} // end of class.

#
# EOF
#
?>