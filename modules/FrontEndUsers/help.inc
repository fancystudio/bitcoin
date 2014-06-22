<h3>What Does This Do?</h3>
<p>This module allows management and administration of front end users <i>(users who have no admin accesss)</i>.  It allows creation of user groups, and user accounts and allows users to login and logout.  it can be used in conjunction with the CustomContent module to display different content to different users once they have logged in</p>
<h3>Features:</h3>
<ul>
<li>User account expiration.  You can create temporary users</li>
<li>Group Properties.  You can ask for different information from members of different groups</li>
<li>Provides a content type to make protecting content simple, if not trivial.</li>
<li>Capable of handling thousands of users</li>
<li>Extensive flexibility for handling redirection after login, and sends events to extend the workflow process.</li>
<li>Forgotten password, and forgot username functionality... allows users to set a new password, and/or to recover their username if they completely forgot login details.</li>
<li>Extendable to different authentication types (LDAP, Facebook, etc).</li>
<li>Provides extensive import and export capabilities.</li>
<li>Has an extensive API for adding functionality into various other CMSMS addon modules.</li>
<li>The ability to encrypt sensitive user data.</li>
</ul>
<h3>How do I use it:</h3>
<p>After installation you can the access admin panel to the FrontEndUsers module under the &quot;Users &amp; Groups&quot; menu.</p>
<p>You need to define at least one property.  Properties are essentially field definitions, here you specify the type of information you want to gather, and limits. i.e:  Name, Age, City, State, Country, etc.</p>
<p><b>Note:</b> You do not need to define properties for username (or email address) and password, these will be provided for you.
<p><b>Note:</b> New installations of the FEU module specify that the users email address is their username (this option can be changed in the modules admin panel).  So if using this option you will not need to create an email address property.</p>
<p>Next you must create one or more user groups.  When you create a group, you are asked for a group name, a description and to associate one or more properties with that group, specify the properties sort order, and whether it is an optional, required, or hidden field.  At least one property must be associated with a group.</p>
<p><b>Note:</b> Properties can only be deleted once they are disassociated from all groups.</p>
<p><b>Note:</b> Before proceeding, you should ensure that the preferences are set correctly.  Take some time here, there are numerous options.</p>
<p>Thirdly you should create some users.  Adding users is a two step process.  When creating a user you are asked for the username/email and password, and an expiry date for that user.  You then must select the groups that that user is a member of, and click &quot;Next&quot;</p>
<p><em>Note: </em>This is a labour intensive and boring process, it is easier to let users register themselves <em>(See the SelfRegistration Module)</em>, and then you can edit their group information.  but for testing purposes, please create at least one user</p>
<p>Lastly, after the system has determined all of the information fields to be presented for that user, you are presented with a form asking for all of the required user information.  Complete this form to complete the user addition</p>
<p>You are now ready to add the front end functionality to your site.  This is as simple as adding the {FrontEndUsers} tag to your page or template.  You must ensure that this page is set to &quot;not cache&quot; when editing the content page(s) where the login form is displayed.  If you call the {FrontEndUsers} tag from within a page template, you must disable caching on all pages that use that template.</p>
<p>Adding protected content to your CMSMS site is as simple as creating new pages of type &quot;Protected Content&quot; and selecting which user groups (or all) that are allowed to view the page.</p>

<h3>Smarty Functions</h3>
<p>Some limited interaction with the FrontEndUsers module database is possible with smarty and the $feu_smarty object.</p>
<h4>Functions:</h4>
<ul>
<li><strong><code>{$feu_smarty-&gt;get_userid($username,$assign)}</code></strong>
<p>This function can be used to return the integer user id given a username.  The output is assigned to a smarty variable specified in the &quot;assign&quot; parameter.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;get_userid($username,'uinfo')}</code></p>
</li>
<li><strong><code>{$feu_smarty-&gt;get_userinfo($uid,$assign)}</code></strong>
<p>This function can be used to return the user information for a single user.  The output is an array is assigned to a smarty variable specified in the &quot;assign&quot; parameter.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;get_userinfo($something.userid,'uinfo')}<br/>{$uinfo|@print_r}</code></p>
</li>
<li><strong><code>{$feu_smarty-&gt;get_users_by_groupname($groupname,$assign)}</code></strong>
<p>This function can be used to extract an array of usernames and userids for all users that belong to the specified group.  The output is assigned to a smarty variable specified in the &quot;assign&quot; parameter.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;get_users_by_groupname('members','mymembers')}<br/>{$mymembers|@print_r}</code></p>
</li>
<li><strong><code>{$feu_smarty-&gt;get_user_properties($uid,$assign)}</code></strong>
<p>This function can be used to extract a list of properties for the specified user and assign them to a smarty variable with the specified name.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;get_user_properties(5,'userprops')}<br/>{$userprops|@print_r}</code></p>
</li>

<li><strong><code>{$feu_smarty-&gt;get_dropdown_text($propname,$propvalue[,$assign])}</code></strong>
<p>This smarty function returns the text specified for a particular option value for a specified dropdown property.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;get_dropdown_text('age_range',$onepropvalue)}</code></p>
</li>

<li><strong><code>{$feu_smarty-&gt;get_multiselect_text($propname,$propvalue,$assign)}</code></strong>
<p>This smarty function returns an array of option texts corresponding to a comma separated list of option values.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;get_multiselect_text('favorite_foods',$onepropvalue,'favorite_foods')}<br/>{$favorite_foods|@print_r}</code></p>
</li>

<li><strong><code>{$feu_smarty-&gt;get_user_expiry($uid[,$assign])}</code></strong>
<p>This smarty method returns the unix timestamp that the specified uid account expires.  The function will return false if the uid cannot be found or some other error occurred.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;get_user_expiry(25,'expiry')}<br/>{$expiry|cms_date_format}</code></p>
</li>

<li><strong><code>{$feu_smarty-&gt;user_expired($uid[,$assign])}</code></strong>
<p>This smarty method returns a boolean indicating wether the specified user account has expired.  The method will also return false if the uid cannot be found or some other error occurred.</p>
<p>Example:<br/><code>{$feu_smarty-&gt;user_expired(25,'expired')}<br/>{if $expired}UID 25 can no longer login to the system{/if}</code></p>
</li>
</ul>

<h3>Privacy Related Items:</h3>
<p>This module does track the IP address of users.  And does store that information in its history.  Additionally, the administrator has the ability to configure the module so that cookies are used.  However no personal information is stored in the cookies (if enabled).  Only a system assigned unique user identifer, and a session identifier.</p>
<h3>See Also:</h3>
<ul>
  <li>CustomContent - Provides smarty tags and utilities for more flexible control of protected pages.</li>
  <li>SelfRegistration - Provides the ability to allow users to register themselves, including paid registration options.</li>
  <li>CGUserDirectory - Provides the ability to browse and search through the profile information of known users.</li>
</ul>
<h3>Encrypted Data:</h3>
<p>The Encrypted field functionality is intended to store (in a secure way) personal and private data that even the site administrator should not have access to.  i.e: items such as Credit Card information.  The only person that should be able to view and edit this data is the user himself.   This data should not be exported to plain text either.  The data could however be read and used by other modules.</p>
<p><strong>Note:</strong>  There may be a need for an additional module to display the unencrypted form of encrytped user information, however the FEU module does not need it.</p>
<h3>FAQ</h3>
<ul>
  <li><strong>Q:</strong> Why can't I create a group
    <p><strong>A:</strong> Groups can't be created untill at least one property is created.</p>
  </li>
  <li><strong>Q:</strong> Why can't I delete a property
    <p><strong>A:</strong> A property cannot be deleted until it is not associated with any groups.</p>
  </li>
  <li><strong>Q:</strong> Setting property order doesn't seem to work
  <p><strong>A:</strong> The percieved property order will change each time the group is edited.  The properties that are marked as &quot;off&quot; will always be displayed at the bottom, but the sort order of other properties will be retained.</p>
  </li>
</ul>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguy\'s
module homepage at <a href="http://calguy1000.com">calguy1000.com</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<h3>Parameters</h3>
<ul>
<li><em>(optional)</em> action="default"
  <p>Actions:</p>
  <ul>
    <li><em>default</em> - The default action, which enables the normal form= behaviour.</li>
    <li><em>reset_session</em> - Provide a javascript controlled template to allow the manual, or automatic pinging of the user session.  This template can be used to remind the user that his login session is about to expire, and to trigger its reset.  Normally this method is not required as any page that displays the FrontEndUser controls would handle this, just requiring the user to view a page on a regular basis.  However, if there are pages with alot of content requiring extensive reading, this may be a useful solution.</li>
    <li><em>viewuser</em> - Display a report for a single user, requires use of the uid parameter.</li>
  </ul>
</li>

<li><em>(optional)</em> form="name"
<p>Forms:</p>
<ul>
 <li><em>login</em> - Display the login form</li>
 <li><em>logout</em> - Display the logout form</li>
 <li><em>changesettings</em> - Display the change settings form</li>
 <li><em>forgotpw</em> - Display the forgot password form</li>
 <li><em>lostusername</em> - Display the lost username form.</li>
<li><em>silent</em> = Display nothing, but export properties and other smarty variables for the currently logged in user.  If no user is logged in, then no variables are exported.</li>
</ul>
</li>

<li><em>(optional)</em> returnto="page"
  <p>Used with the login, logout, and changesettings forms, this parameter contains the page id or alias of a page to redirect to, when the form has been successfully completed</p>
  <ul>
    <li><em>(optional)</em> only_groups="group1, group2, group3"
     <p>Used with the login forms.  Basically only allows users to login if they belong to that particular group(s).</p>
    </li>
    <li><em>(optional)</em> lostun_group="group"
      <p>Used with the lostusername form, this feature specifies the frontend user group to assume tht users are members of.</p>
    </li>
    <li><em>(optional)</em> nocaptcha="1"
      <p>Used with the login forms. his will disnable captcha on the form. By default, if the Captcha module is installed, validation of a captcha image will be required for login.  This is a security measure intented to prevent brute force attacks.</p>
    </li>
    <li><em>(optional)</em> uid=null
      <p>Used with the viewuser action.  This parameter is required to specify which user to view the details of.</p>
    </li>
  </ul>
</li>
</ul>

<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>
<h3>Requirements</h3>
<p>In order to implement the forgotten password functionality, this module requires the CMSMailer module to be previously installed and properly configured.</p>
<p>For encrypted fields the mcrypt functionality is required.</p>
<h3>Copyright and License</h3>
<p>Copyright &copy; 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
<p>This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.</p>
<p>However, as a special exception to the GPL, this software is distributed
as an addon module to CMS Made Simple.  You may not use this software
in any Non GPL version of CMS Made simple, or in any version of CMS
Made simple that does not indicate clearly and obviously in its admin 
section that the site was built with CMS Made simple.</p>
<p>This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>
