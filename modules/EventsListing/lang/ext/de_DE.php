<?php
$lang['active'] = 'Aktiv';
$lang['addevent']		= 'Event hinzufügen';
$lang['addcategory']		= 'Kategorie hinzufügen';
$lang['addeventslisting']	= 'Event Kalender: Event hinzufügen';
$lang['addtemplate']		= 'Template hinzufügen';
$lang['areyousure']		= 'Sind sie sicher?';
$lang['cancel'] = 'Abbrechen';
$lang['categories']		= 'Kategorien';
$lang['changessaved']		= 'Ihre Änderungen wurden gespeichert.';
$lang['delete']			= 'Eintrag löschen';
$lang['delete_image'] = 'Bild löschen';
$lang['edit'] = 'Eintrag bearbeiten';
$lang['enddate']		= 'End-Datum';
$lang['friendlyname'] 		= 'Event Kalender';
$lang['headername']		= 'Titel';
$lang['id'] = 'ID';
$lang['makeactive'] = 'Aktivieren';
$lang['makeinactive'] = 'Deaktivieren';
$lang['moddescription']		= 'Der Event Kalender ist ein Modul zum verwalten von Events.';
$lang['modeventslisting']	= 'Event Kalender: Events modifizieren oder löschen';
$lang['modcategories']	= 'Event Kalender: Kategorien bearbeiten';
$lang['modtemplates']		= 'Event Kalender: Templates modifizieren oder löschen';
$lang['needpermission']		= '"%s" nicht erlaubt. Bitte wenden sie sich an den Administrator für mehr Informationen.';
$lang['no_long_desc']		= 'Kein Text eingetragen.';
$lang['no_short_desc']		= 'Kein titel eingetragen.';
$lang['bad_end_date']		= 'Das Enddatum muss größer sein als das Startdatum.';
$lang['newtemplates']		= 'Es gibt neue Templates mit neuen Platzhaltern (default2 und hcdefault2). Bitte ändere Deine existierenden Templates entsprechend ab!';
$lang['nosuchid']		= 'Es existiert kein Eintrag mit der ID (%u).';
$lang['postdelete']		= 'Eintrag erfolgreich gelöscht.';
$lang['postinstall'] = 'Event Kalender erfolgreich installiert.';
$lang['postupgrade'] = 'Event Kalender erfolgreich upgraded.';
$lang['postuninstall'] = 'Event Kalender erfolgreich entfernt.';
$lang['prompt_long']		= 'Text';
$lang['prompt_name']		= 'Name';
$lang['prompt_short']		= 'Titel';
$lang['prompt_category']	= 'Kategorien';
$lang['prompt_image'] = 'Bild';
$lang['prompt_link']		= 'Link zu einer Detailseite';
$lang['prompt_start_date']	= 'Start-Datum';
$lang['prompt_end_date']	= 'End-Datum';
$lang['prompt_template_name']	= 'Template Name';
$lang['prompt_template_code']	= 'Template Code';
$lang['reallydelete'] = 'Wirklich löschen?';
$lang['reallymakeactive'] = 'Wirklich aktivieren?';
$lang['reallymakeinactive'] = 'Wirklich deaktivieren?';
$lang['events']			= 'Events';
$lang['startdate']		= 'Start-Datum';
$lang['submit'] = 'Speichern';
$lang['template']		= 'Template';
$lang['templates']		= 'Templates';
$lang['timestamp']		= '%d %b %Y um %H:%M';

$lang['changelog'] 		= '
<dl>	
<dt>1.0</dt>
	<dd>Module published for the first time.</dd>
<dt>1.1</dt>
	<dd>Fixed bug in default template.</dd>
<dt>1.2</dt>
	<dd>Added a "cutoff" parameter to limit display of previous events and added a "past" item to pass to the display template. Added a "sortdesc" parameter to change the sort order.</dd>
<dt>1.3</dt>
	<dd>Added "hcstart" and "hcend" variables to support hCalendar microformats in the templates. Updated the default template to better format the display based on single/multi day events. Added a new default template "hcdefault", which uses the hCalendar microformat for date and time display.</dd>
<dt>1.4</dt>
	<dd>Fixed the hCalendar microformats in the "hcdefault" template. Added a new parameter "eventslimit", to set a limit to the number of events to display.</dd>
<dt>1.5</dt>
	<dd>
	- Neues Feld für einen Link (URL) zu den Eventdetails.<br />
	- Kategorien hinzugefügt.
	</dd>
<dt>1.6.1</dt>
	<dd>Kompatilität zu CMSms 1.10 und höher.</dd>
</dl>';

$lang['help'] 			= '
<h3>About</h3>
<p>This module provides a simple interface for the input and display of events, where the Calendar module is overkill for your needs. It is a rewrite of the sendeplan module, fixing some bugs and making the code more CMSMS-like.</p>
<h3>Usage</h3
><p>Simply add events in the EventsListing module page (Contents->Events Listing).You have to specify a short description (up to 255 characters), a long and detailed description, start date/time and end date/time. Both descriptions can contain Smarty-codes.</p>
<p>To show the events, place this code in your page:</p>
<code>{cms_module module="EventsListing" template="mytemplate" cutoff=30 sortdesc=true eventslimit=20}</code>
<p>Note: the template, cutoff, sortdesc, category, pastonly and eventslimit parameters are optional.</p>
<p>Two templates are installed - "default" (standard display of events) and "hcdefault" (includes hCalendar microformat info).</p>

<h3>Template for events</h3>
<p>In the template, the following variables are defined:</p>
<dl>
	<dt>$events</dt>
	<dd>The entries are in an object since version 1.6 (<strong>Caution!</strong> access with "->",	not ".") with the following elements:
		<dl>		
			<dt>event</dt><dd>ID of the event</dd>
			<dt>title</dt><dd>Title of the event</dd>
			<dt>content</dt><dd>Content of the event</dd>
			<dt>linkid</dt><dd>Page ID of an event detail page</dd>
			<dt>linkalias</dt><dd>Page Alias of an event detail page</dd>
			<dt>start</dt><dd>Start date as timestamp</dd>
 			<dt>end</dt><dd>End date as timestamp</dd>
			<dt>hcstart</dt><dd>Start date in hCalendar microformat</dd>
 			<dt>hcend</dt><dd>End date in hCalendar microformat</dd>
 			<dt>past</dt><dd>End date is prior to current date ("true" or "false")</dd>
			<dt>image</dt><dd>image url of the event</dd>
			<!--<dt>sort_order</dt><dd>Sort order of the event</dd>-->
		</dl>
	</dd>
</dl>

<h3>Template for categories</h3>
<p>In the template, the following variables are defined:</p>
<dl>
	<dt>$categories</dt>
	<dd>The entries are in an object since version 1.6 (<strong>Caution!</strong> access with "->",	not ".") with the following elements:
		<dl>		
			<dt>category</dt><dd>ID of the category</dd>
			<dt>title</dt><dd>Title of the category</dd>
			<dt>content</dt><dd>Content of the category</dd>
			<dt>linkid</dt><dd>Page ID of an category detail page</dd>
			<dt>linkalias</dt><dd>Page Alias of an category detail page</dd>
			<dt>image</dt><dd>image url of the category</dd>
			<!--<dt>sort_order</dt><dd>Sort order of the category</dd>-->
		</dl>
	</dd>
</dl>

<p><h3>Additional Parameters</h3></p> 
<ul>
<li><p>template="template_name" - Set the template name.</p></li>
<li><p>lang="de_DE" - Set the language.</p></li>
<li><p>cutoff=365 - Set the number of days prior to the current date to cut off the display of events. Events with end dates more than this number of days old will not be displayed.</p></li>
<li><p>sortdesc=true - Set the sorting order to descending. Valid entries are "true" or "false". If not set, default is "false".</p></li>
<li><p>eventslimit="999" - Limit the number of events to show. If not set, default is to show all.</p></li>
<li><p>categories="category_name" - Limit the events to this categories (name of an category).<br />You use more categories - just using a comma as limiter (category1,category2).</p></li>
<li><p>pastonly=true - Show events in the past only.</p></li>
</ul>

<h3>Support</h3>
<p>This module does not contain any commercial support. If you have problems, ask in the <a href="http://forum.cmsmadesimple.org">forums</a>, the <a href="http://dev.cmsmadesimple.org/projects/eventslisting/">Forge</a> or write an email to <a href="mailto:andi@petzoldt.net?subject=EventsListing">me</a>.<p>';

$lang['help param template'] = 
'<p id="param_template">Specifies the name of a template used to format the Data. If not specified, the value of this parameter is "default" which is the standard default template created during installation.</p>';

// EOF