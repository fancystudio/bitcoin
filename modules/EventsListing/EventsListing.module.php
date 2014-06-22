<?php
/*======================================================================================
Module:		EventsListing
Title:		Main class
Version:	1.6.2
Descript.:	An addon module for CMS Made Simple to show an Event Calendar.
Last Mod.:	28.05.2013
Author:		Noel McGran / Andi Petzoldt
Email:		nmcgran@telus.net / andi@petzoldt.net
Licence:	This program is free software; you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation; either version 2 of the License, or
			(at your option) any later version.
			However, as a special exception to the GPL, this software is distributed
			as an addon module to CMS Made Simple.  You may not use this software
			in any Non GPL version of CMS Made simple, or in any version of CMS
			Made Simple that does not indicate clearly and obviously in its admin
			section that the site was built with CMS Made Simple.
			Find more information about CMS Made Simple on its website:
			http://www.cmsmadesimple.org/
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
			GNU General Public License for more details.
			You should have received a copy of the GNU General Public License
			along with this program; if not, write to the Free Software
			Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
			Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
======================================================================================*/

// Check authorisation
if ( !isset($gCms) ) exit;

// force locale date settings
if (isset($GLOBALS['config']['locale'])) setlocale(LC_ALL, $GLOBALS['config']['locale']);

/**
 * Class EventsListing.
 *
 * This class provides basic functions for the CMSms addon "EventsListing"
 *
 */
class EventsListing extends CMSModule{

/*
	* Constructor function
	*/
	public final function __construct() {
		// Set gCms
		$this->elgCms = cmsms();
		// Set db
		$this->eldb = $this->elgCms->GetDb();
		// Set smarty
		$this->elsmarty = $this->elgCms->GetSmarty();
		// Check version
		if (!$this->elversion) $this->elversion = $this->eldb->GetOne('SELECT version FROM '.cms_db_prefix().'modules WHERE module_name="EventsListing"', array());
		parent::CMSModule();
	}

	/**
	* Get the real name of this module.
	* @return string
	*/
	public final function GetName() {
		return 'EventsListing';
	}

	/**
	* Get a friendly (translated) name of this module.
	* @return string
	*/
	public final function GetFriendlyName() {
		return $this->Lang('friendlyname');
	}

	/**
	* Get the version of this module.
	* @return string
	*/
	public final function GetVersion() {
		return '1.6.2';
	}

	/**
	* Is this an module only for the CMSms backend?.
	* @return bloolean
	*/
	public final function IsAdminOnly() {
		return false;
	}

	/**
	* Gets a help text for this module.
	* @return string
	*/
	public final function GetHelp() {
		return $this->Lang('help');
	}

	/**
	* Gets the author of this module
	* @return string
	*/
	public final function GetAuthor() {
		return 'Andi Petzoldt';
	}

	/**
	* Gets the module authors email address.
	* @return string
	*/
	public final function GetAuthorEmail() {
		return 'andi@petzoldt.net';
	}

	/**
	* Get the changelog of this module
	* @return string
	*/
	public final function GetChangeLog() {
		return $this->Lang('changelog');
	}

	/**
	* Get the dependencies for this module.
	* @return array
	*/
	public final function GetDependencies() {
		return array();
	}

	/**
	* Is this an optional module for CMSms?
	* @return boolean
	*/
	public final function IsPluginModule() {
		return true;
	}

	/**
	* Has this module an admin
	* @return boolean
	*/
	public final function HasAdmin() {
		return true;
	}

	/**
	* Shall this module handle events?
	* @return boolean
	*/
	public final function HandlesEvents() {
		false;
	}

	/**
	* In which main menu of the backend shall this module be?
	* @return string
	*/
	public final function GetAdminSection() {
		return 'content';
	}

	/**
	* Get an module description for the backend.
	* @return string
	*/
	public final function GetAdminDescription() {
		return $this->Lang('moddescription');
	}

	/**
	* Sets the permission for this module.
	* @return string
	*/
	public final function VisibleToAdminUser() {
		return $this->CheckPermission('EventsListing: modify events');
	}

	/**
	* What is the minimum version of CMSms for this module?
	* @return string
	*/
	public final function MinimumCMSVersion() {
		return '1.10';
	}

	/**
	* Set parameters for this module.
	* @return string
	*/
	public final function SetParameters() {

		$this->RegisterModulePlugin();
		#$this->RegisterEvents();

		$this->RestrictUnknownParams();

		// Module params
		// $this->CreateParameter('paramName','defaultValue','HelpDescription');
		$this->CreateParameter('template', 'default', $this->Lang('help param template'));
		$this->CreateParameter('categories', '', $this->lang('help param categories'));
		$this->CreateParameter('cutoff', '', $this->lang('help param cutoff'));
		$this->CreateParameter('sortdesc', '', $this->lang('help param sortdesc'));
		$this->CreateParameter('eventslimit', '', $this->lang('help param eventslimit'));
		$this->CreateParameter('pastonly', '', $this->lang('help param pastonly'));

		// Form params
		// $this->SetParameterType('paramName',CLEAN_TYPE);
		// CLEAN_TYPE could be CLEAN_NONE / CLEAN_STRING / CLEAN_INT / CLEAN_FLOAT / CLEAN_FILE
		$this->SetParameterType('template',CLEAN_STRING);
		$this->SetParameterType('categories',CLEAN_STRING);
		$this->SetParameterType('cutoff',CLEAN_INT);
		$this->SetParameterType('sortdesc',CLEAN_STRING);
		$this->SetParameterType('eventslimit',CLEAN_INT);
		$this->SetParameterType('pastonly',CLEAN_STRING);

	}

	/**
	* Gets a message to display after installing the module
	* @return string
	*/
	public final function InstallPostMessage() {
		return $this->Lang('postinstall');
	}

	/**
	* Gets a message to disply after uninstalling this module.
	* @return string
	*/
	public final function UninstallPostMessage() {
		return $this->Lang('postuninstall');
	}

	/**
	* Gets a message before uninstalling this module
	* @return string
	*/
	public final function UninstallPreMessage() {
		return $this->Lang('preuninstall');
	}

	/**
	* Get a page alias for a given page id
	* @param integer $pageid Page ID
	* @return string
	*/
	public final function GetLinkAlias($pageid) {
		$alias = $this->eldb->GetOne('SELECT content_alias FROM '.cms_db_prefix().'content WHERE active=1 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($pageid));
		return $alias ? $alias : false;
	}

	public function LazyLoadFrontend() {
		return TRUE;
	}

	public function LazyLoadAdmin() {
		return TRUE;
	}
	
} // End of class

// EOF