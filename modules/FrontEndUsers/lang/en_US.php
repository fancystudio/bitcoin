<?php
$lang['error_cantsetpropertytype'] = 'Cannot set property of this type';
$lang['info_import_format'] = '<p>For information on the import format you should create a sample user (or two) in the desired groups and export that information.  The resulting file can then be used as a template for further imports</p><br/>
 <p>Additionally, a txtpassword column can be added to the import file to define (in plain text) the password for users.  If the txtpassword column is empty for an existing user his password is not touched.  If this column is empty for a new user, or not provided at all the hardcoded password &quot;changeme&quot; is used.';
$lang['import_deleteduser'] = 'Deleted user %s';
$lang['error_export_nousers'] = 'No users found to export';
$lang['prompt_export_users'] = 'Export Users';
$lang['title_export_users'] = 'Export Users to an ASCII file';
$lang['info_encrypt'] = 'Encrypted properties cannot be exported to ASCII or viewed by an administrator.  They can only be edited by the authorized user';
$lang['error_importgroupname'] = 'Invalid, or empty group name specified';
$lang['error_import_columncount'] = 'Incorrect column count';
$lang['prompt_delimiter'] = 'Delimiter';
$lang['error_createtmpfile'] = 'Problem creating temporary file';
$lang['prompt_delete_users'] = 'Delete extra users';
$lang['info_import_delete_users'] = 'If enabled, and only <strong>one user group</strong> is mentioned in the import file, users that are members of that user group but not mentioned in the import file, will be deleted.  Caution should be used here, as no checks are done to see if the deleted users are members of any other groups.';
$lang['title_import_users'] = 'Import users from a CSV type file';
$lang['frontend_access'] = 'Viewers';
$lang['error_lostun_nocontrols'] = 'Cannot display lostusername form... no suitable fields found to display';
$lang['info_filter_sortby'] = '<strong>Note:</strong> Column sorting will provide additional sorting on matched elements';
$lang['any'] = 'Any';
$lang['sortby_username_asc'] = 'Username (ascending)';
$lang['sortby_username_desc'] = 'Username (descending)';
$lang['sortby_create_asc'] = 'Create Date (ascending)';
$lang['sortby_create_desc'] = 'Create Date (descending)';
$lang['sortby_expires_asc'] = 'Expiry Date (ascending)';
$lang['sortby_expires_desc'] = 'Expiry Date (descending)';

$lang['info_encrypted'] = 'Encrypted properties can only be seen and edited by the user.  Not even the site administrator can see or manage this data.';
$lang['encrypted'] = 'Encrypted';
$lang['info_cookiename'] = 'If set, the &quot;remember me&quot; functionality will be enabled.  This is similar to the cookie keepalive functionality, but lasts up to sixty days.';
$lang['msg_username_readonly'] = 'The authentication consumer does not permit changing the username for this account';
$lang['msg_password_readonly'] = 'The authentication consumer does not permit changing the password for this account';
$lang['prompt_normallogin'] = 'Direct Login';
$lang['move_up'] = 'Move Up';
$lang['move_down'] = 'Move Down';
$lang['title_propmodule'] = 'This property is created by a module, and cannot be edited';
$lang['not_available'] = 'Not Available';
$lang['prompt_dflt_checked'] = 'By default, this field should be checked';
$lang['operation_completed'] = 'Operation Completed';
$lang['members'] = 'Members';
$lang['view_filter'] = 'View Filter';
$lang['data'] = 'Data';
$lang['applied'] = 'Applied';
$lang['firstpage'] = '&lt;&lt;';
$lang['prevpage'] = '&lt;';
$lang['nextpage'] = '&gt;';
$lang['lastpage'] = '&gt;&gt;';
$lang['page'] = 'Page';
$lang['prompt_allow_changeusername'] = 'Allow Changing Username';
$lang['info_allow_changeusername'] = 'If enabled users will be permitted to change their username along with other settings';
$lang['template_saved'] = 'Template saved';
$lang['template_resetdefaults'] = 'Template reset to defaults';
$lang['lbl_settings'] = 'Settings';
$lang['lbl_templates'] = 'Templates';
$lang['enable_captcha'] = 'Enable captcha on the login form';
$lang['info_enable_captcha'] = 'If the user is not logged in, and the module preference states to display the login form, this option controls wether a captcha will be displayed on the login screen.  If captcha is available';
$lang['pagetype_unauthorized'] = 'You are not authorized to view this content';
$lang['info_contentpage_grouplist'] = 'Specify a list of FEU groups that may have access to this page.  Selecting no groups will allow any user logged in to FEU to view the page';
$lang['pagetype_settings'] = 'Protected Page Settings';
$lang['pagetype_groups'] = 'Allowed Groups';
$lang['info_pagetype_groups'] = 'Select the groups that are (by default) allowed to view protected pages.  An editor with the &quot;Manage All Content&quot; permission can override this for each page';
$lang['pagetype_action'] = 'Action for insufficient access';
$lang['info_pagetype_action'] = 'Specify the behavior for people accessing this page without sufficient permission.  You can either redirect to a specified page, or display the login form';
$lang['showloginform'] = 'Show the Login Form';
$lang['redirect'] = 'Redirect to a Page';
$lang['pagetype_redirectto'] = 'Redirect To';
$lang['info_pagetype_redirectto'] = 'Specify the page to redirect to.  If you select none, and the action is set to &quot;redirect&quot; the user will be presented with a message indicating that they do not hace access to the page';
$lang['permissions'] = 'Permissions';
$lang['feu_protected_page'] = 'Protected Content';
$lang['prompt_viewprops'] = 'Select Additional Properties to View';
$lang['view'] = 'View';
$lang['info_ignore_userid'] = 'If checked the import routine will attempt to add users independant of the userid column.  If a user with the name specified in the import file already exists, an error will be generated';
$lang['ignore_userid'] = 'Ignore UserID Column on Import';
$lang['export_passhash'] = 'Export the password hash to the file';
$lang['info_export_passhash'] = 'The password hash is only useful if the password salt on the import host is identical to that of the export host';
$lang['error_adjustsalt'] = 'The password salt cannot be adjusted';
$lang['prompt_pwsalt'] = 'Password Salt';
$lang['info_pwsalt'] = 'FrontEndUsers salts all passwords with this key which is created upon install.  Once users have been added to the database the salt cannot be changed. The salt may be empty for older installs.';
$lang['advanced_settings'] = 'Advanced Settings';
$lang['info_sessiontimeout'] = 'Specify the number of seconds before an inactive user is automatically logged out of the website';
$lang['prompt_expireusers_interval'] = 'User Expiry Interval';
$lang['info_expireusers_interval'] = 'Specify a value (in seconds) that indicates how often the system should force users whos session has expired to be logged out.  T"his is an optimization to save database queries.  If left empty or set to 0 expiry will be performed on every request.';
$lang['msg_settingschanged'] = 'Your settings were successfully updated';
$lang['forcedlogouttask_desc'] = 'Force users to logout at regular intervals';
$lang['prompt_forcelogout_times'] = 'Times for forced logout';
$lang['info_forcelogout_times'] = 'Specify a comma separated list of times like HH:MM,HH:MM where users will be forcibly logged out. Note, this uses the psuedocron mechanism so you must be sure that the times entered here will coincide reasonably with your &quot;pseudocron granularity&quot; and that sufficient requests will occur to your website to ensure that pseudocron is executed.';
$lang['prompt_forcelogout_sessionage'] = 'Exclude users that have been active in <em>(minutes)</em>';
$lang['info_forcelogout_sessionage'] = 'If specified, any users that have been active in this number of seconds will not be forcibly logged out';
$lang['areyousure_delete'] = 'Are you sure you want to delete the user %s';
$lang['error_invalidfileextension'] = 'The uploaded file does not match the list of allowed file types';
$lang['postuninstall'] = 'All data associated with the FrontEndUsers module has been deleted';
$lang['info_ecomm_paidregistration'] = 'If enabled, this module will listen to events from the Ecommerce suite.  The following settings only have effect if this setting is enabled.';
$lang['prompt_ecomm_paidregistration'] = 'Listen to Order Events';
$lang['info_paidreg_settings'] = 'The following settings only apply if using self registration and allowing for paid registration';
$lang['none'] = 'None';
$lang['delete_user'] = 'Delete User';
$lang['expire_user'] = 'Expire User';
$lang['prompt_action_ordercancelled'] = 'Action to perform when a subscription order is cancelled';
$lang['prompt_action_orderdeleted'] = 'Action to perform when a subscription order is deleted';
$lang['ecommerce_settings'] = 'Ecommerce Settings';
$lang['securefieldmarker'] = 'Secure Field Marker';
$lang['securefieldcolor'] = 'Secure Field Color';
$lang['prompt_encrypt'] = 'Store this data encrypted in the database';
$lang['error_notsupported'] = 'The chosen option is not supported given your current configuration';
$lang['audit_user_created'] = 'User automatically created';
$lang['info_auto_create_unknown'] = 'If a user is authenticated by an external authentication module but is not known in the FrontEndUsers module should an FEU account be created automatically?';
$lang['prompt_auto_create_unknown'] = 'Automatically Create Unknown Users';
$lang['display_settings'] = 'Display Settings';
$lang['info_std_auth_settings'] = 'The following settings are only applicable if using the &quot;Builtin Authentication&quot;.';
$lang['info_support_lostun'] = 'Selecting No will disable the ability for a user to request lost login information, irrespective of other settings';
$lang['info_support_lostpw'] = 'Selecting No will disable the ability for a user to a password reset, irrespective of other settings';
$lang['prompt_support_lostun'] = 'Allow users to request their username';
$lang['prompt_support_lostpw'] = 'Allow users to request a password change';
$lang['auth_settings'] = 'Authentication Settings';
$lang['authentication'] = 'Builtin Authentication';
$lang['auth_builtin'] = 'FEU Standard Authentication';
$lang['auth_module'] = 'Authentication Module/Method';
$lang['info_auth_module'] = 'The FrontendUsers module supports using alternate authentication methods, with varying capabilities.  Some functionality will not function or be disabled when not using the built in authentication method';
$lang['error_user_nonunique_field_value'] = 'The value specified for %s is already in use by another user';
$lang['unique'] = 'Unique';
$lang['error_nonunique_field_value'] = 'The value specified for %s (%s) is not unique';
$lang['prompt_force_unique'] = 'Force values of this property to be unique across all user accounts';
$lang['help_returnlast'] = 'Used with the login and logout forms, this parameter if specified will indicate that the user should be returned to the page (by url) that the user was viewing before the action occurred.  This parameter will override the redirect preferences, and the returnto parameter.';
$lang['help_noinline'] = 'Used with one of the forms, this parameter specifies that the forms should not be placed inline, instead the resulting output after form submission will replace the default content block';
$lang['title_reset_session'] = 'Login Session Timeout Warning';
$lang['msg_reset_session'] = 'Your login session is about to expire, please click "&quot;Ok&quot; to confirm your activity on this website.';
$lang['ok'] = 'Ok';
$lang['resetsession_template'] = 'Reset Session Template';
$lang['info_name'] = 'This is the field name, to be used for addressing in smarty.  It must consist of only alphanumeric characters and underscores.';
$lang['visitors_tab'] = 'Visitors';
$lang['feu_groups_prompt'] = 'Select one or more FEU groups that are allowed to view this page';
$lang['error_mustselect_group'] = 'A group must be selected';
$lang['selectone'] = 'Select One';
$lang['start_year'] = 'Start Year';
$lang['end_year'] = 'End Year';
$lang['date'] = 'Date';
$lang['prompt_thumbnail_size'] = 'Thumbnail Size';
$lang['OnUpdateGroup'] = 'On User Group Modified';
$lang['error_toomanyselected'] = 'Too many users are selected for bulk operations.... Please trim it to 250 or less';
$lang['confirm_delete_selected'] = 'Are you sure you want to delete the selected users?';
$lang['delete_selected'] = 'Delete Selected';
$lang['prompt_randomusername'] = 'Generate random username when adding new users';
$lang['months'] = 'months';
$lang['prompt_expireage'] = 'Default user expiry period';
$lang['notification_settings'] = 'Notification Settings';
$lang['property_settings'] = 'Property Settings';
$lang['redirection_settings'] = 'Redirection Settings';
$lang['general_settings'] = 'General Settings';
$lang['session_settings'] = 'Session and Cookie Settings';
$lang['field_settings'] = 'Field Settings';
$lang['error_lostun_nonrequired'] = 'The lostusername flag can only be used on required fields';
$lang['prop_textarea_wysiwyg'] = 'Allow use of wysiwyg on this text area';
$lang['editing_user'] = 'Editing User';
$lang['noinline'] = 'Do not inline forms';
$lang['info_lostun'] = 'Click here if you cannot remember your login details';
$lang['info_forgotpw'] = 'Click here if you cannot remember your password';
$lang['info_logout'] = 'Click here to sign out';
$lang['info_changesettings'] = 'Click here to adjust your password or other information';
$lang['viewuser_template'] = 'View User Template';
$lang['event'] = 'Event';
$lang['feu_event_notification'] = 'FEU Event Notification';
$lang['prompt_notification_address'] = 'Notification Email Address';
$lang['prompt_notification_template'] = 'Notification Email Template';
$lang['prompt_notification_subject'] = 'Notification Email Subject';
$lang['prompt_notifications'] = 'Email Notifications';
$lang['OnLogin'] = 'On Login';
$lang['OnLogout'] = 'On Logout';
$lang['OnExpireUser'] = 'On Session Expiry';
$lang['OnCreateUser'] = 'On New User Created';
$lang['OnDeleteUser'] = 'On User Deleted';
$lang['OnUpdateUser'] = 'On User Settings Changed';
$lang['OnCreateGroup'] = 'On User Group Created';
$lang['OnDeleteGroup'] = 'On User Group Deleted';

$lang['lostunconfirm_premsg'] = 'The lost login details functionality has successfully completed.  We have found a unique username that matches the details you entered.';
$lang['your_username_is'] = 'Your username is';
$lang['lostunconfirm_postmsg'] = 'We recommend you record this information in a secure, but retrievable location.';
$lang['prompt_after_change_settings'] = 'PageID/Alias to jump to after change settings';
$lang['prompt_after_verify_code'] = 'PageID/Alias to jump to after code verification *';
$lang['lostun_details_template'] = 'Lost Username Details Template';
$lang['lostun_confirm_template'] = 'Lost Username Confirm Template';
$lang['error_nonuniquematch'] = 'Error: More than one user account matched the properties specified';
$lang['error_cantfinduser'] = 'Error: Could not find a matching user';
$lang['error_groupnotfound'] = 'Error: Could not find a group by that name';
$lang['readonly'] = 'Read Only';
$lang['prompt_usermanipulator'] = 'User Manipulator Class';
$lang['admin_logout'] = 'Logged out by administrator';
$lang['prompt_loggedinonly'] = 'Show Only Logged In Users';
$lang['prompt_logout'] = 'Logout this user';
$lang['user_properties'] = 'User Properties';
$lang['userhistory'] = 'User History';
$lang['export'] = 'Export';
$lang['clear'] = 'Clear';
$lang['prompt_exportuserhistory'] = 'Export User History To ASCII that is at least';
$lang['prompt_clearuserhistory'] = 'Clear User History records that is at least';
$lang['title_lostusername'] = 'Forgot Your Login Details?';
$lang['title_rssexport'] = 'Export group definition (and properties) to XML';
$lang['title_userhistorymaintenance'] = 'User History Maintenance';
$lang['yes'] = 'Yes';
$lang['no'] = 'No';
$lang['prompt_of'] = 'Of';
$lang['date_allrecords'] = '** No Limit **';
$lang['date_onehourold'] = 'One Hour Old';
$lang['date_sixhourold'] = 'Six Hours Old';
$lang['date_twelvehourold'] = 'Twelve Hours Old';
$lang['date_onedayold'] = 'One Day Old';
$lang['date_oneweekold'] = 'One Week Old';
$lang['date_twoweeksold'] = 'Two weeks Old';
$lang['date_onemonthold'] = 'One Month Old';
$lang['date_threemonthsold'] = 'Three Months Old';
$lang['date_sixmonthsold'] = 'Six Months Old';
$lang['date_oneyearold'] = 'One Year Old';
$lang['title_groupsort'] = 'Grouping and Sorting';
$lang['prompt_recordsfound'] = 'Records matching the criteria';
$lang['sortorder_username_desc'] = 'Descending Username';
$lang['sortorder_username_asc'] = 'Ascending Username';
$lang['sortorder_date_desc'] = 'Descending Date';
$lang['sortorder_date_asc'] = 'Ascending Date';
$lang['sortorder_action_desc'] = 'Descending Event Type';
$lang['sortorder_action_asc'] = 'Ascending Event Type';
$lang['sortorder_ipaddress_desc'] = 'Descending Ip Address';
$lang['sortorder_ipaddress_asc'] = 'Ascending Ip Address';
$lang['info_nohistorydetected'] = 'No History Detected';
$lang['reset'] = 'Reset';
$lang['prompt_group_ip'] = 'Group By IP Address';
$lang['prompt_filter_eventtype'] = 'Event Type Filter';
$lang['prompt_filter_date'] = 'Display only events that are less than:';
$lang['prompt_pagelimit'] = 'Page Limit';
$lang['for'] = 'for';
$lang['title_userhistory'] = 'User History Report';
$lang['unknown'] = 'Unknown';
$lang['prompt_ipaddress'] = 'IP Address';
$lang['prompt_eventtype'] = 'Event Type';
$lang['prompt_date'] = 'Date';
$lang['prompt_return'] = 'Return';
$lang['import_complete_msg'] = 'Import Operation Complete';
$lang['prompt_linesprocessed'] = 'Lines Processed';
$lang['prompt_errors'] = 'Errors Encountered';
$lang['prompt_recordsadded'] = 'Records Added';
$lang['error_nogroupproprelns'] = 'Could not find properties for group %s';
$lang['error_noresponsefromserver'] = 'Could not get a response from the SMTP server';
$lang['error_importfilenotfound'] = 'File specified (%s) could not be found';
$lang['error_importfieldvalue'] = 'Invalid value for column %s';
$lang['error_importfieldlength'] = 'Field %s exceeds maximum length';
$lang['error_importinsertuser'] = 'Problem creating user: %s';
$lang['error_importupdateuser'] = 'Problem updating user: %s';
$lang['error_importusers'] = 'Import Error (line %s): %s';
$lang['error_propertydefns'] = 'Could not get the property definitions (internal error)';
$lang['error_problemsettinginfo'] = 'Problem setting user info';
$lang['error_importrequiredfield'] = 'Could not find a column to match the required field %s';
$lang['error_nogroupproperties'] = 'Could not find properties for the specified group';
$lang['error_importfileformat'] = 'The file specified for import is not in the correct format';
$lang['error_couldnotopenfile'] = 'Could not open file';
$lang['info_importusersfileformat2'] = '
<h5>File Format Information</h5>
<p>The input file must be in ASCII format using comma <em>(normally)</em> separated values.  Each line in this input file (with the exception of the header line, discussed below) represents one user record.  The order of the fields in each line must be identical.  This import routine accepts MAC and unix line endings.  Column values can be enclosed in double quotes if the delimiter may be contained within the column value.</p>
<h5>Header line</h5>
<ul>
<li>The first line of the file must begin with two pound (\#) characters, and names each of the fields in the file.  The names of these fields is significant.  There are some required field names (see below), and other field names must match the property names associated with the group users are going to be added into.</li>
<li>The import process will fail if the fields in the input file does not match all of the required properties associated with the group that users are being added into</li>
<li>The input file may contain fields representing some of the optional properties in the specified group.</li>
<li>The import process will ignore any fields in the input file that are either not known, or map to properties that are <em>off</em> in the specified user groups.</li>
</ul><br/>
<h6><strong>Columnar Data</strong></h6>
<ul>
<li>The <strong>username</strong> Field - The desired username.
    <p>This field must exist in the headerline, and in each and every line of the input file. If a user with the specified username already exists in the database his information will be overwritten.</p></li>
<li>The <strong>txtpassword</strong> Field - <em>(optional)</em>.  The password to set for the user in plain text.  If the password field is empty when creating new users the password &quot;changeme&quot; is hardcoded.  If the password field is empty when updating a user his password will not be adjusted.</li>
<li>The <strong>expires</strong> Field - <em>(optional)</em>.  The desired expiry date for the user.  If this field is specified and can be validated as a valid date then the expiry date will be used when creating a new user, otherwise a default value of 10 from the create date will be used.  If this field is empty when updating a user then his expiry will not be adjusted.</li>
<li>The <strong>groupname</strong> Field - A : separated list of the group names that you want to have the user be a member of. If all required fields are not filled in the insert/update of the record will fail.</li>
<li>Dropdown/Radio Fields
  <p>The value of dropdown properties in an import file is represented as the string that is shown in the dropdown control in the FrontEndUsers module.</p>
</li>
<li>Multiselect Fields
  <p>Multiselect fields are contained within the ASCII file as a : separated list of strings, where each string represents the text shown in the multiselect list</p>
</li>
<li>Email Fields
  <p>Must be a valid email address that can be validated by PHPs builtin functionality.</p>
</li>
<li>Date Fields
  <p>Must be in a format that can be converted to a unix timestamp by the strtotime() method.</p>
</li>
<li>Image Fields
    <p>Image are fields who\'s column name matches a property of type Image.  If this field is not empty then the filename specified in these columns must exist in image destination path as specified in the FEU preferences..  If the image does not exist, and the field is required, then the record will fail.</p></li>
</ul>
<h5>Notes</h5>
<p>The import process is a memory and database intensive routie.  It is subject to the limitations imposed by the host provider, such as memory limitations, processing time, file size upload, and safe mode restrictions.  Any one of these limitations may cause the import to fail. Therefore it is advisable to ensure that import files are smaller in size, and simpler in nature.</p>
<p>Though every effort has been made to ensure that database corruption will not occur, it is advisable to perform a database backup before doing a user import.</p>
<p>The Export data is the same format as needed for import.  However it may provide extra fields that are not required for import.</p>
<h5>Example</h5>
<pre>
##username,first_name,last_name,email,city,state,country,zip
user1,test,user,user1@somedomain.com,somewhere,TX,US,12345
</pre>
';
$lang['prompt_importdestgroup'] = 'Import Users Into This Group';
$lang['prompt_importfilename'] = 'Input CSV File';
$lang['prompt_importxmlfile'] = 'Input XML File';
$lang['prompt_exportusers'] = 'Export Users';
$lang['prompt_importusers'] = 'Import Users';
$lang['prompt_clear'] = 'Clear';
$lang['prompt_image_destination_path'] = 'Image Destination Path';
$lang['error_missing_upload'] = 'A problem occurred with a missing (but required) upload';
$lang['error_bad_xml'] = 'Could not parse the provided XML file';
$lang['error_notemptygroup'] = 'Cannot delete a group that still has users';
$lang['error_norepeatedlogins'] = 'This user is already logged in';
$lang['error_captchamismatch'] = 'The text from the image was not entered correctly';
$lang['prompt_allow_repeated_logins'] = 'Allow users to login more than once';
$lang['prompt_allowed_image_extensions'] = 'Image File Extensions that Users allowed to upload';
$lang['event_help_OnRefreshUser'] = '
<h3>OnRefreshUser</h3>
<p>An event generated when the user session is refreshed.</p>
<h4>Parameters:</h4>
<ul>
  <li><em>id</em> - The User id</li>
</ul>
';
$lang['event_help_OnDeleteUser'] = '
<h3>OnDeleteUser<h3>
<p>An event generated when a user is deleted</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The user name</li>
<li><em>id</em> - The user id</li>
<li><em>props</em> - A hash filled with the properties of the user</li>
</ul>
';
$lang['event_help_OnCreateUser'] = '
<h3>OnCreateUser<h3>
<p>An event generated when a user is created</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The user name</li>
<li><em>id</em> - The user id</li>
</ul>
';
$lang['event_help_OnUpdateUser'] = '
<h3>OnUpdateUser<h3>
<p>An event generated when a user is updated (either by user themself or admin)</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The user name</li>
<li><em>id</em> - The user id</li>
</ul>
';
$lang['event_help_OnCreateGroup'] = '
<h3>OnCreateGroup<h3>
<p>An event generated when a group is created</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The group name</li>
<li><em>description</em> - The group description</li>
<li><em>id</em> - The group id</li>
</ul>
';
$lang['event_help_OnDeleteGroup'] = '
<h3>OnDeleteGroup<h3>
<p>An event generated when a group is deleted</p>
<h4>Parameters</h4>
<ul>
<li><em>name</em> - The group name</li>
<li><em>id</em> - The group id</li>
</ul>
';
$lang['event_help_OnLogin'] = '
<h3>OnLogin<h3>
<p>An event generated when a user logs in</p>
<h4>Parameters</h4>
<ul>
<li><em>id</em> - The id of the logged in user</li>
<li><em>username</em> - The name of the logged in user</li>
<li><em>ip</em> - The ip address of the client</li>
</ul>
';
$lang['event_help_OnLogout'] = '
<p>An event generated when a user logs out</p>
<h4>Parameters</h4>
<ul>
<li><em>id</em> - The user id</li>
</ul>
';
$lang['event_help_OnExpireUser'] = '
<p>An event generated when a user session expires</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The name of the expired user</li>
<li><em>id</em> - The user id of the expired user</li>
</ul>
';
$lang['event_info_OnLogin'] = 'An event generated when a user logs in to the system';
$lang['event_info_OnLogout'] = 'An event generated when a user logs out of the system';
$lang['event_info_OnExpireUser'] = 'An event generated when a user session is expired';
$lang['event_info_OnCreateUser'] = 'An event generated when a new user is created';
$lang['event_info_OnRefreshUser'] = 'An event generated when the user session is refreshed';
$lang['event_info_OnUpdateUser'] = 'An event generated when a user info is updated';
$lang['event_info_OnDeleteUser'] = 'An event generated when a user account is deleted';
$lang['event_info_OnCreateGroup'] = 'An event generated when a user group is created';
$lang['event_info_OnUpdateGroup'] = 'An event generated when a user group is updated';
$lang['event_info_OnDeleteGroup'] = 'An event generated when a user group is deleted';
$lang['backend_group'] = 'Backend Group';
$lang['info_star'] = '* The following fields are full smarty templates.<br/>Along with other pre-existing smarty variables and plugins, the {$username} and {$group} variables are availabie.  <em>(The {$group} variable matches the first group to which the user belongs.)</em>.';
$lang['info_admin_password'] = 'Edit this field to reset the users password';
$lang['info_admin_repeatpassword'] = 'Edit this field to reset the users password';
$lang['error_username_exists'] = 'A user with that username already exists';
$lang['nocsvresults'] = 'No results returned from csv export';
$lang['prompt_unfldlen'] = 'Length of username field';
$lang['prompt_pwfldlen'] = 'Length of password field';
$lang['error_invalidpasswordlengths'] = 'Min/Max password lengths are invalid';
$lang['error_invalidusernamelengths'] = 'Min/Max username lengths are invalid';
$lang['error_invalidemailaddress'] = 'Invalid Email address';
$lang['error_noemailaddress'] = 'We could not find an email address for this account';
$lang['error_problemseettinginfo'] = 'Problem setting user info';
$lang['error_settingproperty'] = 'Problem setting property';
$lang['user_added'] = 'User Added %s = %s';
$lang['user_deleted'] = 'User Deleted uid=%s';
$lang['propertyfilter'] = 'Property';
$lang['valueregex'] = 'Value (regular expression)';
$lang['warning_effectsfieldlength'] = 'Warning: These fields affect the size of input fields for forms.  Decreasing this number on an existing site may not be advisable';
$lang['confirm_submitprefs'] = 'Are you sure you want to adjust the module preferences?';
$lang['error_emailalreadyused'] = 'Email address already used';
$lang['prompt_usecookiestoremember'] = 'Use cookies to remember login details';
$lang['prompt_cookiename'] = 'The name of the &quot;Remember Me&quot; cookie';
$lang['prompt_allow_duplicate_emails'] = 'Allow duplicate emails';
$lang['prompt_username_is_email'] = 'Email address is username';
$lang['info_cookie_keepalive'] = 'If enabled, a cookie will be set ith an expiry time of 24 hours to keep sessions alive.  This is different thant the rememberme functionality, and can be used to extend a users login to the system if session data is cleared too frequently.';
$lang['info_allow_duplicate_emails'] = '(Allow multiple users with the same email address)';
$lang['info_username_is_email'] = '(user\'s email address is their username -- don\'t set this with "allow duplicate email addresses"!)';
$lang['prompt_allow_duplicate_reminders'] = 'Allow duplicate "forgot password" reminders?';
$lang['info_allow_duplicate_reminders'] = '(Allow a users to request a password reset, even if they haven\'t acted on a previous one)';
$lang['prompt_feusers_specific_permissions'] = 'Use Front-end User specific permissions?';
$lang['info_feusers_specific_permissions'] = '(Normally, FEUSers permissions are the same as the equivalent Admin Area permissions like Add User, Add Group, etc. If you select this option, there will be separate permissions for FEUsers.)';
$lang['error_missingupload'] = 'Could not find the uploaded file (internal error)';
$lang['error_problem_upload'] = 'There was a problem with your uploaded file.  Please try again';
$lang['error_missingusername'] = 'You did not enter a username';
$lang['error_missingemail'] = 'You did not enter your email';
$lang['error_missingpassword'] = 'You did not enter a password';
$lang['frontenduser_logout'] = 'Frontend User Logout';
$lang['frontenduser_loggedin'] = 'Frontend User Login';
$lang['editprop_infomsg'] = '<font color="red"><b>USE CAUTION</b> when changing existing properties that are assigned to groups, you may potentially cause damage and break an existing site <i>(especially if you reduce field lengths, etc)</i></font>';
$lang['info_smtpvalidate'] = 'This function does not work on windows';
$lang['msg_dontcreateusername'] = 'Do not create a property for username, or password as these properties are builtin to the FrontEndUsers module';
$lang['prompt_exportcsv'] = 'Export Users to CSV';
$lang['exportcsv'] = 'Export';
$lang['importcsv'] = 'Import';
$lang['admin'] = 'Admin';
$lang['editprop'] = 'Edit Property: <em>%s</em>';
$lang['maxlength'] = 'Maximum Length';
$lang['created'] = 'Created';
$lang['sortby'] = 'Sort By';
$lang['sort'] = 'Sorting';
$lang['usersingroup'] = 'Users in the selected group(s)';
$lang['userlimit'] = 'Limit results to';
$lang['error_noemailfield'] = 'Could not find an email field for this user.  You may need to contact the system administrator';
$lang['prompt_forgotpw_page'] = 'PageID/Alias for Forgot Password form';
$lang['prompt_changesettings_page'] = 'PageID/Alias for Change Settings form';
$lang['prompt_login_page'] = 'PageID/Alias to jump to after login *';
$lang['prompt_logout_page'] = 'PageID/Alias to jump to after logout *';
$lang['sortorder'] = 'Sort order';
$lang['prompt_numresetrecord'] = 'A number of users are in the middle of resetting lost passwords.  Currently this count is at:';
$lang['remove1week'] = 'Remove all entries more than a week old';
$lang['remove1month'] = 'Remove all entries more than a month old';
$lang['removeall'] = 'Remove all entries';
$lang['areyousure'] = 'Are you sure?';
$lang['error_invalidcode'] = 'An invalid code has been entered, please try again';
$lang['error_tempcodenotfound'] = 'A temporary code for your user id could not be found in the database';
$lang['forgotpassword_verifytemplate'] = 'Template used to display verification form';
$lang['forgotpassword_emailtemplate'] = 'Template used for forgotten password email';
$lang['error_resetalreadysent'] = 'Either yourself or someone else has already triggered a password reset operation for this account.  Check your email, you may have further instructions on how to reset your password in your inbox';
$lang['error_dberror'] = 'Database error';
$lang['message_forgotpwemail'] = 'You are receiving this message because somebody told our site that you had lost your password.  If this is the case, read the instructions below.  If you don\'t have a clue what this is, then you are safe to delete this message, and we thank you for your time.';
$lang['prompt_code'] = 'Code';
$lang['message_code'] = 'The following code has been randomly generated in order to verify the user account.  when you click on the link below you will be presented with a field to enter this code.  Normally the field is pre-completed for you, but incase it isn\'t the code is:';
$lang['prompt_link'] = 'Clicking on the following link will take you to the website where you can enter the above code, and reset your password:';
$lang['lostpassword_emailsubject'] = 'Lost Password';
$lang['error_nomailermodule'] = 'Could not find the CMSMailer module';
$lang['info_forgotpwmessagesent'] = 'An email has been sent to %s with instructions as to how to reset your password.  Thank you';
$lang['lostpw_message'] = 'So you forgot or lost your password. Well, type your username in here, and if we can find you we will send you an email with instructions on how to reset it';
$lang['forgotpassword_template'] = 'Forgot Password Templates';
$lang['lostusername_template'] = 'Lost Username Template';
$lang['error_propnotfound'] = 'Property %s not found';
$lang['propsfound'] = 'Properties found';
$lang['addprop'] = 'Add Property';
$lang['error_requiredfield'] = 'A required field (%s) was empty';
$lang['info_emptypasswordfield'] = 'Enter a new password here to change your password';
$lang['error_notloggedin'] = 'You do not appear to be logged in';
$lang['user_settings'] = 'Settings';
$lang['user_registration'] = 'Registration';
$lang['error_accountexpired'] = 'This account has expired';
$lang['error_improperemailformat'] = 'Improper email address formatting';
$lang['error_invalidexpirydate'] = 'Invalid expiry date.  This may be system related.  Try setting an earlier year.';
$lang['error_problemsettingproperty'] = 'Error setting property %s for user $s';
$lang['error_invalidgroupid'] = 'Invalid group id %s';
$lang['sortorder'] = 'Sort order';
$lang['hiddenfieldmarker'] = 'Hidden field marker';
$lang['hiddenfieldcolor'] = 'Hidden field color';
$lang['hidden'] = 'Hidden';
$lang['error_duplicatename'] = 'A property with that name is already defined';
$lang['error_noproperties'] = 'No properties defined';
$lang['error_norelations'] = 'No properties were selected for this group.  A group must have at least one property selected (Required,Optional, or Hidden)';
$lang['nogroups'] = 'No Groups are defined';
$lang['groupsfound'] = 'Groups found';
$lang['error_onegrouprequired'] = 'Membership in at least one group is required';
$lang['prompt_requireonegroup'] = 'Require membership in atleast one group';
$lang['back'] = 'Back';
$lang['error_missing_required_param'] = '%s is a required field';
$lang['requiredfieldmarker'] = 'Mark required fields with';
$lang['requiredfieldcolor'] = 'Hilite required fields in';
$lang['next'] = 'Next';
$lang['error_groupexists'] = 'A Group with that name already exists';
$lang['required'] = 'Required';
$lang['optional'] = 'Optional';
$lang['off'] = 'Off';
$lang['size'] = 'Size';
$lang['sizecomment'] = '<br/>(Maximum size of any one dimension of the image in pixels)';
$lang['length'] = 'Length';
$lang['lengthcomment'] = '<br>(chars in the text input)';
$lang['seloptions'] = 'Dropdown options, separated by line breaks.  Values can be separated from text with a = character. i.e: Female=f';
$lang['radiooptions'] = 'Radiobutton labels, separated by line breaks. Values can be separated from text with a = character. i.e: Female=f';
$lang['yes'] = 'Yes';
$lang['prompt'] = 'Prompt';
$lang['prompt_type'] = 'Type';
$lang['type'] = 'Type';
$lang['required'] = 'Required';
$lang['fieldstatus'] = 'Field Status';
$lang['usedinlostun'] = 'Ask in Lost<br/>Username';
$lang['text'] = 'Text';
$lang['checkbox'] = 'Checkbox';
$lang['multiselect'] = 'Multi Select List';
$lang['radiobuttons'] = 'Radio Buttons';
$lang['image'] = 'Image';
$lang['email'] = 'Email';
$lang['textarea'] = 'Textarea';
$lang['dropdown'] = 'Dropdown';
$lang['msg_currentlyloggedinas'] = 'Welcome';
$lang['logout'] = 'Sign out';
$lang['prompt_newgroupname'] = 'Use this group name';
$lang['prompt_changesettings'] = 'Change My Settings';
$lang['error_loginfailed'] = 'Login failed - Invalid username or password?';
$lang['login'] = 'Sign in';
$lang['prompt_signin_button'] = 'Sign in button label';
$lang['prompt_username'] = 'Username';
$lang['prompt_email'] = 'Email Address';
$lang['prompt_password'] = 'Password';
$lang['prompt_rememberme'] = 'Remember me on this computer';
$lang['register'] = 'Register';
$lang['forgotpw'] = 'Forgot Your Password?';
$lang['lostusername'] = 'Forgot Your Login Details?';
$lang['defaults'] = 'Defaults';
$lang['template'] = 'Template';
$lang['error_usernotfound'] = 'User ID not found';
$lang['error_usernametaken'] = 'That username (%s) is already in use';
$lang['prompt_smtpvalidate'] = 'Use SMTP to validate email addresses?';
$lang['prompt_minpwlen'] = 'Minimum Password Length';
$lang['prompt_maxpwlen'] = 'Maximum Password Length';
$lang['prompt_minunlen'] = 'Minimum Username Length';
$lang['prompt_maxunlen'] = 'Maximum Username Length';
$lang['prompt_sessiontimeout'] = 'Session Timeout (seconds)';
$lang['prompt_cookiekeepalive'] = 'Use cookies to keep logins alive';
$lang['prompt_allowemailreg'] = 'Allow Email Registration';
$lang['prompt_dfltgroup'] = 'Default Group for new users';
$lang['changesettings_template'] = 'Change Settings Template';
$lang['error_passwordmismatch'] = 'Passwords Do not match';
$lang['error_invalidusername'] = 'Invalid Username';
$lang['error_invalidpassword'] = 'Invalid Password';
$lang['error_usernotfound'] = 'Could not find information for this user';
$lang['edituser'] = 'Edit User';
$lang['valid'] = 'Valid';
$lang['username'] = 'Username';
$lang['status'] = 'Status';
$lang['error_membergroups'] = 'This user is not a member of any groups';
$lang['error_properties'] = 'No Properties';
$lang['error_dup_properties'] = 'Attempt to import duplicate properties';
$lang['value'] = 'Value';
$lang['groups'] = 'Groups';
$lang['properties'] = 'Properties';
$lang['propname'] = 'Property Name';
$lang['propvalue'] = 'Property Value';
$lang['add'] = 'Add';
$lang['history'] = 'History';
$lang['edit'] = 'Edit';
$lang['expires'] = 'Expires';
$lang['specify_date'] = 'Specify Date';
$lang['12hrs'] = '12 Hours';
$lang['24hrs'] = '24 Hours';
$lang['48hrs'] = '48 Hours';
$lang['1week'] = '1 Week';
$lang['2weeks'] = '2 Weeks';
$lang['1month'] = '1 Month';
$lang['3months'] = '3 Months';
$lang['6months'] = '6 Months';
$lang['1year'] = '1 Year';
$lang['never'] = 'Never';
$lang['postinstallmessage'] = 'Module installed sucessfully.<br/>Be sure to set the "Modify FrontEndUser Properties permission.  Additionally, we recommend that you install the Captcha module.  If installed, validation of a captcha image will be required in addition to the username and password to login.  This is intended to prevent brute force attacks.  <strong>Note:</strong> The nocaptcha parameter can be used to disable this functionality even if the Captcha module is installed."';
$lang['email'] = 'Email Address';
$lang['password'] = 'Password';
$lang['repeatpassword'] = 'Again';
$lang['error_groupname_exists'] = 'Group by that name already exists';
$lang['editgroup'] = 'Edit Group';
$lang['submit'] = 'Submit';
$lang['cancel'] = 'Cancel';
$lang['delete'] = 'Delete';
$lang['confirm_editgroup'] = 'Are you sure this is the proper settings for this group?\nTurning a property off will not delete any entries in the properties table for this group/user.  They will merely be unavailable.';
$lang['areyousure_deletegroup'] = 'Are you sure you want to delete this group?';
$lang['confirm_delete_prop'] = 'Are you sure you want to completely delete this property?\nDoing so will also erase any user entries for this property.';
$lang['error_insufficientparams'] = 'Insufficient Parameters';
$lang['id'] = 'Id';
$lang['username'] = 'Username';
$lang['name'] = 'Name';
$lang['error_cantaddprop'] = 'Problem adding property';
$lang['error_cantaddgroupreln'] = 'Problem adding group relation';
$lang['error_cantaddgroup'] = 'Problem adding group';
$lang['error_cantassignuser'] = 'Problem adding a user to a group';
$lang['error_couldnotdeleteproperty'] = 'Problem deleting a property';
$lang['error_couldnotfindemail'] = 'Could not find an email address';
$lang['error_destinationnotwritable'] = 'No write permission to destination directory';
$lang['error_invalidparams'] = 'Invalid Parameters';
$lang['error_nogroups'] = 'Could not find any groups';
$lang['applyfilter'] = 'Apply';
$lang['filter'] = 'Filter';
$lang['userfilter'] = 'Username Regular Expression';
$lang['description'] = 'Description';
$lang['name'] = 'Name';
$lang['groupname'] = 'Group Name';
$lang['accessdenied'] = 'Access Denied';
$lang['error'] = 'Error';
$lang['addgroup'] = 'Add Group';
$lang['importgroup'] = 'Import Group';
$lang['adduser'] = 'Add User';
$lang['groupsfound'] = 'Groups Found';
$lang['usersfound'] = 'Users found that match the criteria';
$lang['group'] = 'Group';
$lang['selectgroup'] = 'Select Group';
$lang['registration_template'] = 'Registration Template';
$lang['logout_template'] = 'Logout Template';
$lang['login_template'] = 'Login Template';
$lang['preferences'] = 'Preferences';
$lang['groups'] = 'Groups';
$lang['users'] = "Users";
$lang['friendlyname'] = 'Frontend User Management';
$lang['moddescription'] = 'Allow users to log in to the frontend of your site';
$lang['defaultfrontpage'] = "Default front page";
$lang['lastaccessedpage'] = 'Last accessed page';
$lang['otherpage'] = 'Other page: ';
$lang['captcha_title'] = 'Enter the text from the image';
?>
