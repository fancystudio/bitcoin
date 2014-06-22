<ul>
<li>0.0.1 - October, 2005 - Initial NRPT (Not Ready for Prime Time) release</li>
<li>0.1.0 - October, 2005 - Initial release</li>
<li>0.1.1 - October, 2005 - Fixed issues with properties</li>
<li>0.1.2 - October, 2005 - Added forgotten password functionality</li>
<li>0.1.3 - November, 2005
    <p>Added the ability to specify a redirect page on login, logout, forgot password, and change settings, and added the returnto and form parameters to the user side of things, also did a couple lf little cleanups.  This version requires v0.11 and above for certain.</p></li>
<li>0.1.4 - November, 2005 - Very minor change with respect to a forgotten and no longer needed function call</li>
<li>0.1.5 - November, 2005
    <p>Another very minor change, added some text to the PostInstall message.</p></li>
<li>0.1.6 - January, 2006
    <p>Changes to the permission model, and minor bug fixes to the preferences.  Also some php5 fixes but I am sure that there are more out there.</p></li>
<li>0.1.7 - January, 2006
    <p>Many thanks to <b>katon</b> for adding the textarea and dropdown property types.</p>
    <p>Fixes to the property adding to fix problems with spaces in property names (we no longer let that happen).</p>
</li>
<li><p>1.0.0 - February, 2006<p>
    <p>Added filtering and row limiting to the admin panel. This will have big benefits to those that are using this module for high trafic, and high user sites.</p>
    <p>Added sorting to the admin panel</p>
    <p>Added max length ability to text and email fields</p>
    <p>Fixed a small problem with the default group not being checked when adding a user</p>
    <p>Save filter settings in preferences, and the active tab too.</p>
    <p>Delete user properties when a property is deleted <em>Note</em>, not when it is disabled in the edit group dialog</p>
    <p>Add confirmation message in edit groups.</p>
    <p>Added a couple more confirmation messages.</p>
    <p>Added CSV Export option</p>
    <p>Todo - Add preferences for username and password fieldlength</p>
</li>
<li>1.0.1 - March, 2006
    <p>Added the ability to check for duplicate email addresses</p>
    <p>Fix problem where expiry date was being modified when admin modified user settings</p>
    <p>Add a confirmation message to the preferences submit button</p>
    <p>Fixed a minor bug when couting the number of users in a group</p>
    <p>Fixes to the size of username and password fields, and maxlength</p>
    <p>Added advanced filtering on properties</p>
    <p>Changes to labeling in add or edit user</p>
    <p>Fixes to problems with inline and non inline forms, the password is never sent on the get line</p>
    <p>Changed to require CMS 0.12-beta2 at a minimum (for safety purposes)</p>
</li>
<li>1.0.2 - March, 2006
    <p>More field length fixes</p>
</li>
<li>1.0.3 - March, 2006
    <p>Export to smarty all of the user properties when they are logged in</p>
</li>
<li>1.0.4 - May, 2006
    <p>Fixes to the export code</p>
    <p>Code cleanup (alphabetize functions)</p>
    <p>Minor fixes and enhancements (recommended by nils73) for dealing with the change password stuff.</p>
    <p>Removed the requirement for CMS 0.12, and put it back to 0.11.2</p>
    <p>Added the \'silent\' form</p>
    <p>Cleaned up database access stuff for performance reasons (hopefully)</p>
    <p>Added copyright info</p>
    <p>Added macros for redirecto to a user specific page on login or logout</p>
    <p>Tweaks to the admin preferences tab</p>
</li>
<li>1.0.5 - May, 2006
    <p>Fixed a problem with expiry dates</p>
    <p>Start splitting the code up into several files</p>
<li>1.0.6 - May, 2006
    <p>Fixed a problem with editing dropdowns</p>
</li>
<li>1.1.0 - May, 2006
    <p>Events</p>
    <p>Optionally disallow repeated logins</p>
    <p>Export the user id to smarty</p>
    <p>Added optionally \{\$group\} for the pages to jump to on login</p>
</li>
<li>1.1.1 - Sept, 2006
    <p>Fixed a bug when a user was editing his settings with \'allow duplicate emails\' was off</p>
    <p>Changed the dropdown table to 255 characters</p>
    <p>Minor cleanups</p>
</li>
<li>1.1.2 - Dec, 2006
    <p>Fixes (hopefuly) to the adodb/adodb-lite DATETIME issue</p>
    <p>Add captcha support to the login screen (optional), thanks dittman</p>
    <p>Fixes to cancel handling on the lost password and change settings screens</p>
    <p>Fixes to user expiry (more DBTimestamp issues), thanks again dittman</p>
    <p>Option to allow FEUsers to have its own set of permissions asside from the admin permissions.  Thanks _SjG_</p>
    <p>Option to allow duplicate password reminder requests and to specify text on the signin button.  Thanks _SjG_</p>
    <p>General cleanup of functions that were not being used and notices/warnings</p>
    <p>Added the only_groups param for login forms.  Thanks wishy</p>
    <p>Fixes to the length of the email field in the change password form</p>
    <p>Fixes to the email validation stuff</p>
</li>
    <li>1.2.0 - April, 2007
    <p>elijahlofgren - Fixes to captcha support, and some template cleanups.</p>
    <p>Add support for multi select lists</p>
    <p>Template cleanups (more of em)</p>
    <p>Add support for value=key stuff in the dropdown and multi select lists.</p>
    <p>better checking of the "at least one group required" stuff</p>
    <p>Output more smarty variables on the user settings page, to allow people to modify the template to something that is more accessibile</p>
    <p>Split into more files for performance</p>
    <p>You can now not delete a group that still has users</p>
    <p>Now handle regex problems better in the admin section users tab</p>
    <p>Email fields, when specified as optional, make em actually optional</p>
    <p>Add support for image uploads, this is a big feature.  Images are scaled to a maximum size in one dimension, and stored as files in a configurable directory under the uploads_path.</p>
    <p>Captcha mode is now on by default, unless you use the nocaptcha parameter in the tag.</p>
    <p>Fixes to CSV export... it was assuming the db_prefix is cms_</p>
    <p>Import Users from CSV</p>
    <p>Fixes to the install and uninstall methods, and now the allow_repeated_logins preference should work</p>
    <p>Adds proper user history tracking.  Now track failed logins, logins, expiries, and logouts, on a per user basis.</p>
    <p>Fixes to the cancel button of the user settings page, if the user settings form is on a different page.</p>
    <p>Fixes to the cancel button of the forgot password page, if the forgot password form is on a different page.</p>
    <p>Minor fixes to behaviour oaf the preferences panels.</p>
</li>
<li>1.2.1 - June, 2007
	<p>A cookie is now used to keep track of login state between sessions, however the cookie does not last any longer than the timeout specified in the user settings.</p>
	<p>Added the ability for an administrator to logout users</p>
	<p>Added the ability to filter by logged in status</p>
	<p>Added the ability for read-only properties.</p>
	<p>Added more variables in each object in the changesettings form</p>
</li>
<li>
	<p>1.2.2 - June, 2007</p>
	<p>tsw - Added event OnUpdateUser which gets called when user (or admin) updates user info</p>

</li>
<li>1.3 - October, 2007
<p>Added support for 'remember me' so that login information is stored in a cookie.  And support for a form to allow that cookie to be reset.</p>
<p>No longer support non alphanumeric characters in property names.</p>
<p>Numerous small bugfixes.</p>
<p>Require CMS 1.2 or greater.</p>
</li>
<li>1.3.1 - November, 2007
<p>Fixes problems with parameters not being cleaned in the change settings dialog on the front end.</p>
<p>Fixes an updrade issue in the database schema</p>
<p>Fixes an issue in a GetSmarty() call that was apparently causing people difficulties with the login form.</p>
<p>Add a preference that allows admins to specify a page to redirect to after the forgot password validation form is complete.</p>
<p>Fixes a problem with hidden properties being lost after a user changed their settings.</p>
<p>The Forgot Password and Lost Username forms are now inline</p>
<p>Fixes to errors in encryption with the sessioning</p>
<p>Fixes to the lost username functionality.</p>
</li>
<li>1.3.3 - December, 2007
<p>Now optionally allow some frontend forms to be inlined.</p>
<p>Add email notifications when user changes their settings, or on any other event.</p>
<p>Change the maximum data size for properties from 255 characters to longtext</p>
<p>Fixes an issue where the logout links did not obey the preference which dictated which page to redirect to after logout.</p>
</lI>
<li>1.4 - February, 2008
<p>Adds the viewuser action to view the properties for a specific user</p>
<li>1.4.1 - February, 2008
<p>Adds the GetUserHistory method to the api</p>
<p>Adds a preference for page to redirect to after change settings</p>
<p>Use the after_verifycode preference</p>
</li>
<li>1.4.2 - March, 2008
<p>Fixes problems with cancel buttons</p>
<p>Makes it easier for text on various buttons and links to be changed</p>
<p>Update dependencies, etc.</p>
<p>Update all files and the help to reflect the new license</p>
<p>Adjustments so the signin and signout text can be changed easily</p>
<p>Cleanups and bug fixes</p>
</li>
<li>1.4.3 - June, 2008
<p>Now use session variables to keep track of user variables between steps of the forms for adding and editing users.</p>
<p>Get rid of the time fields for the expiry date, and just expire at 23:59:59 on that specified day</p>
<p>Added the ability for external modules to interact (somewhat) with feu, and specify a return location</p>
<p>Added the GetFullUsersInGroup() method into the api</p>
</li>
<li>1.4.4 - August, 2008
<p>Thanks to _SjG_ we now support using email addresses as username (there is a preference in the admin).</p>
<p>Adds a GetEmail method to the api to return the first email address found for the specified user.</p>
</li>
<li>1.5 - August, 2008
<p>Add the feu_smarty class with a few functions in it, for iterating through users in smarty.</p>
</li>
<li>1.5.1 - August, 2008
<p>Keep the loginid in a variable, to cut down on the number of repeat queries.</p>
<p>Fixes to properties with spaces in the values.</p>
</li>
<li>1.5.2 - August, 2008
<p>Split out a few more files to shrink memory footprint a bit more</p>
<p>Fixes some tab name stuff</p>
<p>Small validation issue with default template</p>
<p>Minor enhancemetns to the viewuser template.</p>
<p>Get rid of commented out code to shrink the file down a bit.</p>
<p>Fix forgot password form to handle the case where username == email address.</p>
<p>Add pretty url support into the lost password email.</p>
</li>
<li>1.5.3 - September, 2008
<p>Numerous small, but annoying bug fixes</p>
<li>1.5.4 - December, 2008
<p>More and more bug fixes.</p>
<p>The starts of pretty url support (thank you Nuno)</p>
</li>
<li>1.6 - Janusary, 2009
  <ul>
  <li>Complete rewrite of property creation and editing stuff.</li>
  <li>Add the ability to optionally enable a wysiwyg for text area properties.</li>
  <li>No longer allow auto install or upgrade.</li>
  <li>Complete rewrite of group creation and editing stuff.... re-ordering is simpler now.</li>
  <li>Re-organize the preferences tab, and the users filtering stuff to be a bit more presentable.</li>
  <li>Add new preference for the default expiry age for users.</li>
  <li>Add new preference indicating wether we should attempt to create random usernames or not.</li>
  <li>Add bulk user delete capabilities.</li>
  </ul>
</li>
<li>1.6.1 - Janusary, 2009
  <ul>
    <li>Minor template changes to the change settings stuff.</li>
    <li>Fix text property length issues.</li>
    <li>Remove stupid die and debug statements from the remember me stuff.</li>
  </ul>
</li>
<li>1.6.2 - Janusary, 2009
  <ul>
    <li>Begin implementing the tablesorter stuff</li>
    <li>Fix problems with image fields.</li>
  </ul>
</li>
<li>1.6.3 - February, 2009
  <ul>
  <li>Fix cookie issues permanently. (I hope).</li>
  </ul>
</li>
<li>1.6.4 - April, 2009
  <ul>
  <li>Add field type as a member of the control object in various forms.</li>
  <li>Added radio buttons field type (_SjG_)</li>
  <li>More fixes to user export stuff.</l>i
  <li>Fix for returnto param in login form</li>
  </ul>
</li>
<li>1.6.5 - May, 2009
  <ul>
  <li>Numerous bug fixes.</li>
  </ul>
</li>
<li>1.6.6 - July, 2009
  <ul>
  <li>Numerous bug fixes.</li>
  <li>Add Date field type.</li>
  </ul>
</li>
<li>1.6.7 - July, 2009
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.6.8 - July, 2009
  <ul>
  <li>Minor bug fixes.</li>
  <li>Add more functionality to the feu_smarty object.</li>
  </ul>
</li>
<li>1.6.8.1 - July, 2009
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.6.9 - August, 2009
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.6.10 - October, 2009
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.6.11 - November, 2009
  <ul>
  <li>Now convert property names to contain only valid chars hopefully.</li>
  </ul>
</li>
<li>1.6.12 - January, 2010
  <ul>
  <li>Minor improvements.</li>
  </ul>
</li>
<li>1.6.13 - February, 2010
  <ul>
  <li>More Minor improvements.</li>
  </ul>
</li>
<li>1.7 - February, 2010
  <ul>
  <li>Adds the reset_session action.</li>
  <li>Bug fixes</li>
  </ul>
</li>
<li>1.7.1 - February, 2010
  <ul>
  <li>Fixes and enhancements to the jquery reset session template.</li>
  </ul>
</li>
<li>1.7.1 - March, 2010
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.7.3 - March, 2010
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.8 - March, 2010
  <ul>
  <li>Now the redirect_to page preferences are smarty templates.</li>
  </ul>
</li>
<li>1.8.2 - April, 2010
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.8.3 - April, 2010
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.8.4 - April, 2010
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.8.5 - May, 2010
  <ul>
  <li>Adds the returnlast parameter to allow returning back to the previous url on login or logout.</li>
  <li>Fixes the reset to defaults button in the lost username template(s) form.</li>
<li>1.9 - May, 2010
  <ul>
    <li>Adds the ability to specify unique fields.</li>
    <li>Various minor bug fixes.</li>
  </ul>
</li>
<li>1.9.1 - May, 2010
  <ul>
    <li>Re-adds a function needed by Availability.</li>
    <li>Minor addition to the view user template.</li>
  </ul>
</li>
<li>1.9.2 - May, 2010
  <ul>
    <li>Remove pretty urls for lost username, and change settings forms because they were losing parameters like the lang parameter.</li>
    <li>(Ted): Fix ability to uncheck checkboxes while editing a user in the admin</li>
  </ul>
</li>
<li>1.9.3 - June, 2010
  <ul>
    <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.10 - June, 2010
  <ul>
    <li>Adds suppport for additional authentication mechanisms (still testing).</li>
    <li>Fixes a minor issue with returnto.</li>
  </ul>
</li>
<li>1.10.1 - July, 2010
  <ul>
    <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.10.2 - July, 2010
  <ul>
    <li>Adds the GetExpriryDate api method.</li>
  </ul>
</li>
<li>1.11 - July, 2010
  <ul>
    <li>Adds optional encryption for property definitions.</li>
    <li>Various minor bug fixes.</li>
    <li>Improvement to the CSV export stuff.</li>
  </ul>
</li>
<li>1.12 - August, 2010
  <ul>
    <li>Now works in conjunction with SelfRegistration to handle paid subscriptions.</li>
    <li>The content_module tag now provides a multi-select list (Ted)</li>
  </ul>
</li>
<li>1.12.3 - September, 2010
  <ul>
    <li>Adds an overall preference for paid registration, which triggers the event handlers.</li>
  </ul>
</li>
<li>1.12.4 - October, 2010
  <ul>
    <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.12.4 - October, 2010
  <ul>
    <li>Minor bug fixes.</li>
    <li>Fixes for support for CMSMS 1.9</li>
    <li>Requires CGExteions 1.21 or better</li>
  </ul>
</li>
<li>1.12.6 - November, 2010
  <ul>
    <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.12.7 - December, 2010
  <ul>
    <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.12.8 - December, 2010
  <ul>
    <li>Minor bug fixes.</li>
    <li>Some minor bug fixes related to E_STRICT and E_DEPRECATED.</li>
  </ul>
</li>
<li>1.12.10 - January, 2011
  <ul>
    <li>Fixes problem with add/edit group with lots of properties.</li>
  </ul>
</li>
<li>1.12.12 - February, 2011
  <ul>
    <li>Minor API Fixes.</li>
    <li>Adds a method to clear the property cache.</li>
  </ul>
</li>
<li>1.12.13 - March, 2011
  <ul>
    <li>Fixes to export.</li>
    <li>Fixes to user editing.</li>
  </ul>
</li>
<li>1.12.13 - March, 2011
  <ul>
    <li>Fixes problem with image fields when editing a user.</li>
  </ul>
</li>
<li>1.12.15 - May, 2011
  <ul>
    <li>Numerous small bug fixes.</li>
  </ul>
</li>
<li>1.12.16 - May, 2011
  <ul>
    <li>Bug fixes wrt lost password functionality.</li>
  </ul>
</li>
<li>1.13 - June, 2011
  <ul>
    <li>Fixes a minor bug in the Logout() method.</li>
    <li>Adds the ability to force logout users at specified times.</li>
    <li>Modifies the behavior of the (default) change settings form to display the logout form when completed.</li>
    <li>Adds a preference to specify a (minimum) time interval between expiry actions.  This should save a few queries for most requests.</li>
    <li>Adds a preference to specify a time interval between user checkins touching the database.  This should save a few more db queries for most requests.</li>
  </ul>
</li>
<li>1.14 - July, 2011
  <ul>
    <li>Adds the ability to adjust the password salt (only if there are no users).</li>
    <li>Improvemetns to the CSV export/import routines.</li>
  </ul>
</li>
<li>1.15 - July, 2011
  <ul>
    <li>Adds the ability to add additional properties to the view.</li>
  </ul>
</li>
<li>1.15.1 - August 2011
 <ul>
   <li>Minor bug fix.</li>
 </ul>
<li>1.15.4 - October 2011
  <ul>
    <li>Optimizations.</li>
    <li>Minor bug fixes.</li>
    <li>Minor API enhancements.</li>
  </ul>
</li>
<li>1.15.5 - October, 2011
  <ul>
    <li>Bug fixes.</li>
  </ul>
</li>
<li>1.16 - October, 2011
  <ul>
    <li>Adds a new &quot;Protected Content&quot; content type.  Along with a few related preferences.</li>
  </ul>
</li>
<li>1.16.1 - October, 2011
  <ul>
    <li>Fixes a minor bug wrt caching of user properties.</li>
  </ul>
</li>
<li>1.16.2 - October, 2011
  <ul>
    <li>Fixes an upgrade issue.</li>
    <li>Fixes a redirect call.</li>
  </ul>
</li>
<li>1.16.4 - October, 2011
  <ul>
    <li>Fixes for additional content blocks.</li>
    <li>Fix for notice generated in the API.</li>
  </ul>
</li>
<li>1.16.6 - December, 2011
  <ul>
    <li>Numerous minor bug fix.</li>
  </ul>
</li>
<li>1.17 - February, 2012
  <ul>
    <li>Many methods are protected now... for better security.</li>
    <li>Adds captcha support to the forgot password form.</li>
  </ul>
</li>
<li>1.17.1 - March, 2012
  <ul>
   <li>Minor bug fixes.</li>
  </ul>
</li>
<li>1.18.x - March, 2012
  <ul>
   <li>Improved users tab.</li>
   <li>Adds the ability to allow users to change their username.</li>
  </ul>
</li>
<li>1.18.x - March, 2012
  <ul>
    <li>Added the data property type (not editable by admins).</li>
    <li>Modified the api to allow deleting data from the users when deleting properties.</li>
  </ul>
</li>
<li>1.19 - September, 2012
  <ul>
    <li>Numerous gui improvements.</li>
    <li>Numerous bug fixes and minor enhancements.</li>
  </ul>
</li>
<li>1.20 - October, 2012
  <ul>
    <li>Fxxes to the behavior of checkbox fields.</li>
    <li>Adds the ability to specify the default value of checkboxes.</li>
    <li>Numerous other bug fixes.</li>
  </ul>
</li>
<li>1.21.x
  <ul>
    <li>Refactoring to allow alternate forms of authentication.</li>
    <li>Refactoring to expand the use of the consumer class.</li>
    <li>Now allow other modules to control group membership.</li>
    <li>Refactoring of preferences and settings.</li>
    <li>Refactoring of cookie, session, logging, and history functionalities.</li>
    <li>Numerous minor enhancements and bug fixes.</li>
    <li>** 1.21.11 - Fixed significant problem with the protected content content type ... everybody should upgrade ASAP **</li>
  </ul>
</li>
<li>1.22.x
  <ul>
    <li>Fixes to ascii import</li>
    <li>Encrypted properties are no longer exported to ASCII</li>
    <li>Fixes to group export/import</li>
    <li>Administrators can no longer see and/or edit encrypted properties.</li>
    <li>Admin users tab filtering has been rewritten, is now a user preference.</li>
    <li>Improved error checking in the admin users tab.</li>
    <li>Improvements to the feu_user_query stuff.</li>
  </ul>
</li>
<li>1.23.x
  <ul>
	<li>Rewrite ASCII export and import code.</li>
	<li>Rewrite FEU Change settings template:  NOTE: You may need to adjust your change settings template.</li>
	<li>Rewrite FEU login form template.</li>
	<li>Adds a trivial, optional honeypot captcha field to the login form.  Reset your login form to default values to see it, and its use.</li>
  </ul>
</li>
</ul>
