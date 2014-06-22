<ul>
<li>Version 0.0.1. Oct 2005. Initial NRPT (Not Ready for Prime Time) release.</li>
<li>Version 0.1.0. Oct 2005. Initial release.</li>
<li>Version 0.1.1. Oct 2005. Set the HTML mail flag.</li>
<li>Version 0.1.2. Oct 2005. Moved Random stuff into feusers, and added the ability to delete old entries from the registration temporary tables</li>
<li><p>Version 0.1.3. - Dec 2005</p>
<p>Fixed the toggles in the admin preferences.  Also, changed the permissions model to not require the unique permission added previously for the selfreg module.</p>
<p>This release was removed due to possible errors</p>
</li>
<li><p>Version 0.1.4. - Jan 2006</p>
<p>Fixed minor errors with CheckPermission, replaced all assign_by_refs\'s with assigns for hopeful php5 compatibility.</p>
<li><p>Version 0.1.5. - Jan 2006</p>
<p>Added the ability to set the subject of the confirmation email, and added the ability to specify a text body.  Subject, and text body are required.</p>
</li>
<li><p>Version 1.0.0. - Feb 2006</p>
<p>Fixed a problem with the verify mode.</p>
<p>Added the ability to edit and delete users. with selection on the checkboxes, and "checkall"</p>
<p>Now require FEUsers 0.1.8 and CMSMailer 1.73.9</p>
<p>Added another tab for the "your settings have been adjusted" email templates</p>
<p>Added CSV Exporting</p>
<p>Added a "Delete all users older than a day" button</p>
<p>Now works with the maximum length field of FEUsers</p>
<p>Added support for dropdowns and text areas</p>
<p>Disallow punctuation characters in username</p>
</li>
<li><p>Version 1.0.1. - Feb 2006</p>
<p>Added the ability for users to request another registration email (uses the same code), incase they lost their first one.</p>
</li>
<li><p>Version 1.0.2. - Feb 2006</p>
<p>The "Require email confirmation" checkbox now works.  Users are added straight to the frontend users database</p>
<p>Fixed a bug with the confirmation emails having links to the admin section (new bug only).</p>
</li>
<li><p>Version 1.0.3. - Feb 2006</p>
<p>Added the (optional) ability to require the user enter the email address twice</p>
<p>Fixed a bug with the useredited message not being thrown through smarty</p>
<p>Fixed the default registration template a bit to aide in validation for non required fields (fixed a warning)</p>
<p>Fix problems with inline and non-inline forms and links</p>
<p>Handle another case where the admin may not have created the proper type of email property</p>
<p>Changed to require CMS 0.12-beta2 at a minimum (for safety purposes)</p>
</li>
<li><p>Version 1.0.4. - Mar 2006</p>
<p>More control over username and password field sizes (controlled by feusers)</p>
<p>Confirmation on editing preferences</p>
<p>Require 0.12 proper of cms as a minimum</p>
</li>
<li><p>Version 1.1.0. - Dec 2006</p>
    <p>Added events and 1.0 compatibility</p>
    <p>Captcha support (thanks Dittman)</p>
</li>
<li><p>Version 1.1.1. - Apr 2007</p>
    <p>Now require FEUsers 1.2.0 (minimum)</p>
    <p>Support for multiselect lists in feusers</p>
    <p>Output some more fields to smarty to allow for increased accessibility</p>
    <p>Split code out into multiple files to reduce overall memory footprint</p>
    <p>Ignore all image fields</p>
    <p>Change Captcha support to be on by default if the Captcha module is found</p>
</li>
<li><p>Version 1.1.2. - Nov 2007</p>
    <p>Fix the problem with the UserDisplayLostRegEmailForm thing</p>
    <p>Adds the id to the onUserRegistered Event</p>
    <p>Fixes the problem with checkbox properties not working</p>
    <p>Now Requires CMS 1.2 minimum</p>
    <p>You can now use {SelfRegistration group=\'blah\'}</p>
    <p>Now Requires CMS 1.3 minimum.</p>
</li>
<li><p>Version 1.1.3. - Nov 2007</p>
    <p>Fixes issue with SMTP Email address validation</p>
    <p>Now Require FEU 1.3.1</p>
    <p>Adds the noinline parameter</p>
</li>
<li><p>Version 1.1.4. - Jan 2008</p>
    <p>Splits a few more actions up into seperate files</p>
    <p>Adds preferences and behaviour for pages to redirect to after a user is registered, and/or verified</p>
</li>
<li><p>Version 1.1.5. - Feb 2008</p>
    <p>use =& syntax to all calls to GetModuleInstance()</p>
    <p>Remove cancel buttons from forms (they didn\'t work anyways)</p>
</li>
<li><p>Version 1.1.6. - Mar 2008</p>
    <p>License change</p>
    <p>Remove cancel buttons from forms</p>
    <p>Minor bug fixes and cleanups</p>
</li>
<li><p>Version 1.2 - Mar 2008</p>
    <p>Add functionality to allow automatic logging in once verification is complete</p>
    <p>Minor, but important bug fixes.</p>
<li>
<li><p>Version 1.2.1 - Jul 2008</p>
    <p>Added support for email addresses as the username (thanks _SjG_).</p>
<li>
<li><p>Version 1.2.3 - Feb 2009</p>
    <p>Bug Fixes.</p>
<li>
<li><p>Version 1.2.4 - April 2009</p>
    <p>Minor Bug Fixes.</p>
<li>
<li><p>Version 1.2.6 - Nov 2009</p>
    <p>Minor Bug Fixes.</p>
<li>
<li><p>Version 1.3 - March 2010</p>
    <p>Adds pretty url support.</p>
    <p>Adds absolutely do not register functionality.</p>
    <p>Adds register_link action.</p>
    <p>Minor bug fixes.</p>
<li>
<li><p>Version 1.3.1 - March 2010</p>
    <p>Fixes an issue with registered user expiry.</p>
    <p>Minor bug fixes.</p>
<li>
<li><p>Version 1.3.2 - April 2010</p>
    <p>Minor bug fixes.</p>
    <p>Make onNewUser event fire after FEU login (if email activation is off)</p>
<li>
<li><p>Version 1.3.3 - April 2010</p>
    <p>Minor bug fixes.</p>
<li>
<li><p>Version 1.4 - May 2010</p>
<p>Adds the ability to optionally overwrite existing FEU Users, providing the capability to register to another group.  Use this option with caution</p>
<li>
<li><p>Version 1.4.2 - May 2010</p>
<p>Adds orig_url stuff to redirect to after registration is complete.</p>
</li>
<li><p>Version 1.5 - July 2010</p>
<p>Adds support for encrypted FEU properties.</p>
</li>
<li>Version 1.6 - July 2010
  <ul>
    <li>Adds support for allowing the user to select his group.</li>
    <li>Adds support for different registration packages (including price and expiry date). (One package per FEU group)</li>
    <li>Adds support for paid registration.  This module can now act as a supplier to CGEcommerceBase.</li>
    <li>Reorganizes the preferences tab so that it makes more sense.</li>
  </ul>
</li>
<li>Version 1.6.1 - August 2010
  <ul>
    <li>Fixes an error in creating paid pkgs.</li>
  </ul>
</li>
<li>Version 1.6.2 - August 2010
  <ul>
    <li>Can now have multiple paid packages for a single FEU group</li>
    <li>Adds a seperate redirect preference for redirecting with paid packages.</li>
    <li>Fixes an error with messages when adding/editing paid packages.</li>
  </ul>
</li>
<li>Version 1.6.5
  <ul>
    <li>Fixes a bug in verifyuser.</li>
  </ul>
</li>
<li>Version 1.6.7
  <ul>
   <li>Fixes for CMSMS 1.9.</li>
  </ul>
</li>
<li>Version 1.6.8
  <ul>
   <li>Fixes for paid registration stuff.</li>
  </ul>
</li>
<li>Version 1.6.9
  <ul>
   <li>Minor fixes to paid registration stuff.</li>
  </ul>
</li>
<li>Version 1.6.10
  <ul>
    <li>A minor enhancement or two, and numerous bug fixes.</li>
  </ul>
</li>
<li>Version 1.6.11
  <ul>
    <li>Minor bug fix to verify users routine when using salted passwords.</li>
  </ul>
</li>
<lI>Version 1.6.12
  <ul>
    <li>Fixes issues related to subscription orders.</li>
    <li>Adds a preference to ensure that events got created.</li>
  </ul>
</li>
<li>Version 1.6.13
  <ul>
    <li>Fixes minor problem with paid registration.</li>
  </ul>
</li>
<lI>Version 1.6.14
  <ul>
    <li>Fixes for CMSMS 1.10</li>
    <li>Fixes reference issues.</li>
  </ul>
</li>
<li>Version 1.6.15
  <ul>
    <li>Numerous bug fixes.</li>
  </ul>
</li>
<li>Version 1.7.x
  <ul>
    <li>Many new features, cleanup to editing users....</li>
  </ul>
</li>
<li>Version 1.8.x
  <ul>
    <li>Adds ability to register to multiple groups at once.</li>
    <li>Minor template cleanup.</li>
    <li>code optimizations and cleanup.</li>
    <li>Update depdendencies.</li>
    <li>Bug fixes wrt paid registration.</li>
  </ul>
</li>
</ul>';
