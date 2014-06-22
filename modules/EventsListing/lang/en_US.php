<?php
$lang['active'] = 'Active';
$lang['addevent']		= 'Add an event';
$lang['addcategory']		= 'Add a category';
$lang['addeventslisting']	= 'EventsListing: Add an event';
$lang['addtemplate']		= 'Add a template';
$lang['areyousure']		= 'Are you sure?';
$lang['cancel'] = 'Cancel';
$lang['categories']		= 'Categories';
$lang['changessaved']		= 'Your changes have been successfully saved.';
$lang['delete']			= 'Delete entry';
$lang['delete_image'] = 'Delete image';
$lang['edit'] = 'Edit entry';
$lang['enddate']		= 'End date';
$lang['friendlyname'] 		= 'Events Listing';
$lang['headername']		= 'Name';			  
$lang['id'] = 'ID';
$lang['makeactive'] = 'Activate it';
$lang['makeinactive'] = 'Make in inactive';
$lang['moddescription']		= 'EventsListing is used to manage and search events.';
$lang['modeventslisting']	= 'EventsListing: Modify, add or delete events';
$lang['modcategories']	= 'Event Kalender: Add/Edit/Remove Categories';
$lang['modtemplates']		= 'EventsListing: Modify, add or delete templates';
$lang['needpermission']		= 'You are not allowed to make use of the "%s" permission. Please ask your administrator for further information.';
$lang['no_long_desc']		= 'No detailed description is given. Please enter one.';
$lang['no_short_desc']		= 'No short description is given. Please enter one.';
$lang['bad_end_date']		= 'End Date must be greater than Start Date.';
$lang['newtemplates']		= 'There are new templates with new placeholders (default2 and hcdefault2). Please modify your existing templates!';
$lang['nosuchid']		= 'There is no entry with the given ID (%u).';
$lang['postdelete']		= 'The entry has been successfully deleted.';
$lang['postinstall'] = 'EventsListing has successfully been installed.';
$lang['postupgrade'] = 'EventsListing has successfully been upgraded.';
$lang['postuninstall'] = 'EventsListing has successfully been removed.';
$lang['prompt_long']		= 'Detailed description';
$lang['prompt_name']		= 'Name';
$lang['prompt_short']		= 'Short description';
$lang['prompt_category']	= 'Categories';
$lang['prompt_image'] = 'Image';
$lang['prompt_start_date']	= 'Start Date';
$lang['prompt_end_date']	= 'End Date';
$lang['prompt_link']		= 'Link to a detail page';
$lang['prompt_template_name']	= 'Template Name';
$lang['prompt_template_code']	= 'Template Code';
$lang['reallydelete'] = 'Delete it really?';
$lang['reallymakeactive'] = 'Activate it really?';
$lang['reallymakeinactive'] = 'Deactivate it really?';
$lang['events']			= 'Events';
$lang['startdate']		= 'Start date';
$lang['submit'] = 'Submit';
$lang['template']		= 'Template';
$lang['templates']		= 'Templates';
$lang['timestamp']		= '%H:%M on %b %d, %Y';

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
	- Added a new field for a detail link to an event.<br />
	- Added categories.
	</dd>
<dt>1.6.1</dt>
	<dd>Compatibility to CMSms 1.10 and above.</dd>
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

<h3>Support</h3>
<p>This module does not contain any commercial support. If you have problems, ask in the <a href="http://forum.cmsmadesimple.de">forums</a>, the <a href="http://dev.cmsmadesimple.org/projects/eventslisting/">Forge</a> or write an email to <a href="mailto:andi@petzoldt.net?subject=EventsListing">Andi</a>, or <a href="mailto:nmcgran@telus.net?subject=EventsListing">Noel</a>.<p>';

$lang['help param template'] = 
'Specifies the name of a template used to format the Data. If not specified, the value of this parameter is "default" which is the standard default template created during installation.';
$lang['help param categories'] = 
'Limit the events to this categories (name of an category). You use more categories - just using a comma as limiter (category1,category2).';
$lang['help param cutoff'] = 
'Set the number of days prior to the current date to cut off the display of events. Events with end dates more than this number of days old will not be displayed.';
$lang['help param sortdesc'] = 
'Set the sorting order to descending. Valid entries are "true" or "false". If not set, default is "false".';
$lang['help param eventslimit'] = 
'Limit the number of events to show. If not set, default is to show all.';
$lang['help param pastonly'] = 
'Show events in the past only.';
// EOF