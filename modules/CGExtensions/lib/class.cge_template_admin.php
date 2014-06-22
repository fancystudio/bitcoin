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

class cge_template_admin
{
  /**
   * Get a form for displaying a 'start' template.  A start template
   * is read from a file, stored in the database, and is used when creating
   * a new template of that type.
   *
   * @param object  The module that this template is for
   * @param string  The module instance id.
   * @param integer The returnid (usually empty)
   * @param string  The preference (relative to the module supplied) that will hold this start template.
   * @param string  The return action (usually defaultadmin)
   * @param string  The name of the tab to return to.
   * @param string  The title for this form.  Usually indicates to the administrator what template he is editing.
   * @param string  The file name (relative to the modules templates directory) where the system default version of the 'start' template is.
   * @param string  The info string for the form.
   * @param bool    A flag indicating a simple form.
   * @return string An HTML form.
   */
  static public function get_start_template_form(&$module,$id,$returnid,
                                                 $prefname,$action,$active_tab,
                                                 $title,$filename,$info = '',$simple = false)
    {
      static $counter = 0;
      $smarty = cmsms()->GetSmarty();
      $cgextensions = cge_utils::get_module('CGExtensions');

      $the_template = $module->GetTemplate($prefname);
      if( !$the_template ) $the_template = $module->GetPreference($prefname);

      $smarty->assign('simple',$simple);
      $smarty->assign('defaulttemplateform_title',$title);
      $smarty->assign('info_title',$info);
      $smarty->assign('startform',
		      $cgextensions->CreateFormStart($id,'setdefaulttemplate',$returnid,'post','',false,'',
						     array('prefname'=>$prefname,
							   'destmodule'=>$module->GetName(),
							   'destaction'=>$action,
							   'cg_activetab'=>$active_tab,
							   'filename'=>$filename)));
      $smarty->assign('prompt_template',$cgextensions->Lang('template'));
      $smarty->assign('input_template',$cgextensions->CreateTextArea(false,$id,
								     $the_template,
								     'input_template'));
      $smarty->assign('submit',$cgextensions->CreateInputSubmit($id,'submit',$cgextensions->Lang('submit')));
      $smarty->assign('reset',$cgextensions->CreateInputSubmit($id,'resettodefault',
							       $cgextensions->Lang('resettofactory')));
      $smarty->assign('endform',$cgextensions->CreateFormEnd());
      $smarty->assign('prefname',$prefname);
      $smarty->assign('dflt_tpl_counter',$counter++);
      return $cgextensions->ProcessTemplate('editdefaulttemplate.tpl');
    }


  /**
   * A function to provide a form to edit a single template.  Provides restore
   * to factory default settings as well.
   *
   * @param object  The module that this template is for.
   * @param string  The module action id.
   * @param integer The returnid (usually empty)
   * @param string  The template name
   * @param string  The active tab name
   * @param string  A title for the form, usually indicates which template this form is editing.
   * @param string  The filename (relative to the modules templates directory) of the factory default template source.
   * @param string  Optional help for this template
   * @param string  The destination action (usually defaultadmin)
   * @param bool    whether to output a simple form
   * @return string An HTML form
   */
  public static function get_single_template_form(&$module,$id,$returnid,$tmplname,
                                                  $active_tab,$title,$filename,
                                                  $info = '',$destaction = 'defaultadmin',$simple = 0)
  {
      $cgextensions = cge_utils::get_module('CGExtensions');
      $smarty = cmsms()->GetSmarty();
      $title = trim($title);
      if( $title ) $smarty->assign('defaulttemplateform_title',$title);
      $smarty->assign('info_title',$info);
      $smarty->assign('startform',
                      $cgextensions->CreateFormStart($id,'setdefaulttemplate',$returnid,'post','',false,'',
                                                     array('prefname'=>$tmplname,
                                                           'usetemplate'=>'1',
                                                           'destmodule'=>$module->GetName(),
                                                           'cg_activetab'=>$active_tab,
                                                           'destaction'=>$destaction,
                                                           'filename'=>$filename)));
      $smarty->assign('prompt_template',$cgextensions->Lang('template'));
      $smarty->assign('input_template',$cgextensions->CreateTextArea(false,$id,
                                                                     $module->GetTemplate($tmplname),
                                                                     'input_template'));
      $smarty->assign('simple',$simple);
      $smarty->assign('submit',$cgextensions->CreateInputSubmit($id,'submit',$cgextensions->Lang('submit')));
      $smarty->assign('reset',$cgextensions->CreateInputSubmit($id,'resettodefault',
                                                               $cgextensions->Lang('resettofactory')));
      $smarty->assign('endform',
                      $cgextensions->CreateFormEnd());
      return $cgextensions->ProcessTemplate('editdefaulttemplate.tpl');
  }
} // end of class
#
# EOF
#
?>
