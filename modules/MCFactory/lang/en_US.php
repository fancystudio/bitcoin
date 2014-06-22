<?php
$lang = array(
    'installed' => 'Module version %s installed.',
    'upgraded' => 'Module upgraded to version %s.',
    'uninstalled' => 'Module uninstalled.',

    'admindescription' => 'A module to generate modules for custom content types.',
    'installpostmessage' => 'M&amp;C Factory was successfully installed. You can access it and generate new modules through the Extensions menu.',
    'uninstallpremessage' => 'Are you sure you want to uninstall MC Factory? This will also remove all settings for generated modules.',
    'uninstallpostmessage' => 'M&amp;C Factory was successfully uninstalled. You can reinstall it at any time.',
    'error_occured_publishing' => 'An error occurred during the publication of the module',

    'edit' => 'Edit',
    'delete' => 'Delete',
    'move_up' => 'Move up',
    'move_down' => 'Move down',

    'import' => 'Import',
    'import_module' => 'Import module',
    'form_module_name' => 'Module name',
    'leave_empty' => 'You can leave this empty',
    'form_xmlfile' => 'Module XML File',

    'form_name' => 'Name',
    'form_code' => 'Code',
    'form_event_name' => 'Event name',
    'form_is_public' => 'Is a public action',
    'form_have_permission' => 'Have a specific permission',
    'form_button' => 'Place a button in the admin panel',
    'form_button_name' => 'Button name',

    'form_label' => 'Label',
    'form_type' => 'Type',
    'form_type_select' => 'Type',
    'form_place' => 'Place',
    'form_options' => 'Options',
    'form_column' => 'Show in column',
    'form_filter' => 'Filter',
    'form_frontend' => 'Usable in frontend',

    'Continue' => 'Continue',

    'main' => 'Main',
    'fields' => 'Fields',
    'actions' => 'Actions',
    'extra_features' => 'Extra features',
    'logic' => 'Custom logic',
    'options' => 'Options',

    'display_error' => '<h3>Access Denied</h3>
<p>You do not have sufficient privileges to manage this module.</p>',

    'help' => '
	<h3>Description</h3>
	<p>This module can generate new modules to manage custom content types.</p>
	<h3>How to use it</h3>
	<p>For the general help, you can find it under the generated module help.</p>
	<p>With the specific module logic, you can now add or override some methods from the object class itself. For example, you could overide the method "getTitle" to do something else.</p>
	<p>Specific methods that you could consider overriding:</p>
	<ul>
		<li><strong>getCoreSlug()</strong> This generate the url slug of the module. By default it take it from title.</li>
	</u>
	<p>Some tips</p>
	<p>For all fields, you can define options. Write them in a "css" way.</p>
	<ul>
		<li><strong>tips</strong> Add a tip in the end of the field.</li>
	</ul>
	<h4>Checkbox</h4>
	<ul>
	    <li><strong>text</strong> Checkbox text</li>
	    <li><strong>checked</strong> Check the checkbox by default</li>
	</ul>

	<h4>Select (Dropdown)</h4>
	<ul>
		<li><strong>values</strong> A list of values for the dropdown. You can use key=>value (ex: values:option1 => Option 1, option2 => Option 2). To retrieve the value, use getMyFieldNameValue()</li>
		<li><strong>default_value</strong> The default selected value</li>
		<li><strong>multiple</strong> Allows you to select multiple values.</li>
		<li><strong>expanded</strong> Shows Radio buttons or checkboxes instead of select box.</li>
	</ul>
	<h4>Module</h4>
	<p>For the field type "module", the option should be filed with the exact module name. ex: module_name:MyModule. You can also specify it to be a multiple file multiple:true and you can replace dropdown by a radio or checkbox list using the param expanded. Ex: "module_name:MyModule;multiple:true;expanded:true"</p>
	<ul>
		<li><strong>module_name</strong> The module name</li>
		<li><strong>selector</strong> The function to select items (take MCFCriteria for param)</li>
		<li><strong>multiple</strong> Allow multiple selection ?</li>
		<li><strong>expanded</strong> Show checkbox/radio button instead of selector ?</li>
	</ul>
	<h4>Date</h4>
	<p>For the field type "date", you can specify the start year and number of years. Example : "start_year:1950;number_years:70"</p>
	<h4>Time</h4>
	<ul>
		<li><strong>midnight</strong> Set the time to 0:0:0 by default</li>
	</ul>
	<h4>Page</h4>
	<p>For the pages, you can use the same information as for dropdown except the "values". You can also use the following parameters:</p>
	<ul>
		<li><strong>childrenof</strong> Show only the children\'s of a specified page.</li>
		<li><strong>start_page</strong> Show only the descendants of a specified page.</li>
	</ul>
	<h4>Documents</h4>
	<p>You can protect documents doing "indirect" downloads which will allow you to set user permissions on it for example.</p>
	<ul>
		<li><strong>protected</strong> Specify the absolute path where documents have to be safely stored. This folder needs write access.</li>
	</ul>
	<h4>Events</h4>
	<p>You can create events handler for the modules. Events are activated by other modules and in the Events module, you can attach those events to your module so your module is activated when those events happen. To create an event handler, you must first create it in your module by specifying the Module name and event name of this module, and then you can write a piece of code that will be executed each time this event happen. Then, after publishing your module, you can link this event handler to the module event in the module "Events".</p>
	<h3>Support</h3>
	<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>
	<h3>Copyright and License</h3>
	<p>Copyright &copy; 2008-2010, Jean-Christophe Cuvelier <a href="mailto:cybertotophe@gmail.com">&lt;cybertotophe@gmail.com&gt;</a> - Morris &amp; Chapman Belgium</p>
	<p>Contributors: Gerry Vandermaesen</p>
	<p>This module would\'nt exist without the strong support of <a href="http://www.morris-chapman.com/">Morris &amp; Chapman Belgium</a> company and team who have strongly supported with the construction and evolution of it.</p>
	<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using this module.</p>
',

    'changelog' => '
	<dl>
		<dt>Version 0.0.1 - 29 September 2008.</dt>
		<dd>Initial Release.</dd>
		<dt>Version 1.0 - 21 October 2009.</dt>
		<dd>First stable release.</dd>
		<dt>Version 1.0.1 - 22 October 2009.</dt>
		<dd>
			<ul>
				<li>Clean-up of the code.</li>
				<li>Models of already installed modules are auto-updated when adding new columns.</li>
			</ul>
		</dd>
	</dl>
');

