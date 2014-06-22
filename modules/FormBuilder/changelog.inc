<h3>Version 0.7.4</h3>
<ul>
	<li>Fixed bugs #8510, #7408, #9296, #9129, #9360, #8893</li>
	<li>Adds a disposition to allow saving to ListItExtended</li>
	<li>Full support of HTML5 input fields and the required attribute</li>
	<li>Leaving the selection text blank in pulldown menus now defaults to first option</li>
	<li>Allow for prepopulation of all inputs including pulldowns via tag param</li>
	<li>Field table width is now 100%</li>
	<li>Dropped old Table DnD plugin. Using jQuery UI instead.</li>
	<li>Save & Continue button maintains tab correctly.</li>
	<li>Help re-written.</li>
	<li>Special thanks goes to Jonathan Schmid for bug fixes.</li>
</ul>
 
<h3>Version 0.7.3</h3>
<ul>
	<li>Compatibility release for 1.11.</li>
	<li>Adding cancel buttons to form and field instances.</li>
	<li>Removing ugly go back link.</li>
	<li>Ensuring usability in PHP strict mode.</li>
	<li>Some template fixes.</li>
	<li>NOTE: This is not feature or bug release, this is compatibility release as we ain't working with anything else than maintaining certain compatibility with this module. Stay tuned for FormBuilder2 within this year.</li>
</ul>

<h3>Version 0.7.2</h3>
<ul>
	<li>Many bug fixes.</li>
	<li>Last version of 0.x series.</li>
	<li>Fixing compability with 1.10.x series.</li>
	<li>Fixing problems with Form Browser.</li>
</ul>

<h3>Version 0.7.1 - (calguy1000) </h3>
<ul>
	<li>Fixes the search for fields to not show backup files etc.</li>
	<li>Fixes a CMS Version comparison.</li>
	<li>Adds a disposition to allow selecting users to email based on an FEU property. Also assigns smarty variables with info about matching usess.</li>
</ul>

<h3>Version 0.7</h3>
<ul>
	<li>Fixed a bug which caused the Date Submitted sorting in Form Browser to be inconsistent across pages at first.</li>
	<li>Fixed a bug which caused a Checkbox Field to be unable to be required. Checkbox Fields can now be made required.</li>
	<li>Fixed Bug #5610: File Upload Field advanced options now save correctly.</li>
	<li>Fixed Bug #5702: When using the "Frontend User binding" advanced option on the FormBrowser Disposition, checkboxes can now be saved in the "unchecked" state. Thanks Mike Hughesdon!</li>
	<li>Fixed Bug #5422: Multiple forms using the "Frontend User binding" advanced option on the FormBrowser Disposition now correctly load previously submitted data. Thanks Mike Hughesdon!</li>
	<li>Added: New Disposition - DispositionUniqueFile. Write form results to a unique file for each form submission.</li>
	<li>Added: TinyMCE integrated.</li>
	<li>Added: New Disposition - DispositionEmailBasedFrontendFields. Send form results via email with frontend-user-specified Subject, "From Name", "From Address", and Destination Address.</li>
	<li>Added: Random number generator to UniqueIntegerField.</li>
	<li>Fixed Bug #5555/#5453: Dominica (DM) is now properly selectable in the Country Picker Field.</li>
	<li>Fixed Bug #4307: Files uploaded on earlier pages of a multi-page form are now attached to Email Dispositions on later pages.</li>
	<li>Fixed Bug #3605: Dates are now translated in Email Dispositions.</li>
	<li>Fixed Bug #5358: DispositionFromEmailAddressField now creates a correct label for its input field.</li>
	<li>Fixed Bug #1822: Hidden Fields can now be edited in an Admin Form Browser.</li>
	<li>Added Feature Request #5277: Allow DispositionFormBrowser to be hidden.</li>
	<li>Several other cleanups and minor fixes.</li>
</ul>
	
<h3>Version 0.6.4 </h3>
<ul>
	<li>Bugs fixes for Field Sorting. Thanks to everyone who reported and Stikki for fixing it!</li>
	<li>Improvements FileUpload field: overwrite flag, file renaming, and hiding filename in output.</li>
	<li>Additional patches from Ryan Foster for DatePicker.</li>
</ul>
	
<h3>Version 0.6.3 </h3>
<ul>
	<li>Security patch for Upload field type.</li>
	<li>Numerous bugs fixes. Thanks to everyone who reported.</li>
	<li>Numerous fixes and improvements for use with FormBrowser v0.3.x.</li>
	<li>Improvements to the ComputedField type to allow much more computation.</li>
	<li>Vilkis' fixes for localizing CountryPicker</li>
	<li>Ryan Foster's patch for re-ordering date inputs on DatePicker</li>
</ul>

<h3>Version 0.6.2 </h3>
<ul>
	<li>A lot of small and big bugs fixes. Thanks to everyone who reported.</li>
	<li>Introducing dynamic field management.</li>
	<li>New "YearPullDown" field type added</li>
	<li>Compatible with CMSMS 1.7.1 and further.</li>
	<li>Added jQuery. Prototype removed completely.</li>
	<li>Added some styling.</li>
</ul>

<h3>Version 0.6.1 </h3>
<ul>
	<li>Numerous Bug fixes. If your bug isn't fixed, post it in the tracker!</li>
	<li>New Validation UDT code provided by Jeff Bosch</li>
	<li>Ability to reject blank/only spaces for required fields</li>
	<li>New "CompanyDirectory"" Field type provided by Jeremy Bass</li>
	<li>Improvements to default value code provided by Jeremy Bass</li>
	<li>New "Module Interface" field type provided by Jeremy Bass</li>
	<li>New "User Defined Tag Call" field type</li>
	<li>Fix to support syntax highlighters for templates and Javascript on admin side</li>	
</ul>

<h3>Version 0.6 </h3>
<ul>
	<li>30 Dec 09. Bug fixes. Finally releasing this thing!</li>
</ul>

<h3>Version 0.6b2.</h3>
<ul>
  <li>Numerous bug fixes. Thanks for all who reported on bugs!</li>
  <li>Added Form Disposition to do an HTTP GET or POST to any arbitrary URL for form handling</li>
  <li>Added capability (and example of) advanced multipage contact form where a previous response gets displayed on a subsequent page as per uptoeleven's FR</li>
  <li>Fix for template $fld_X remapping on XML import</li>
  <li>Extended to provide DOM/CSS id attributes to fields</li>
  <li>Cleaned up bad use of references for PHP 5.x</li>
</ul>

<h3>Version 0.6b1.</h3>
<ul>
	<li>Updated database code to be CMSMS 1.7-compatible</li>
	<li>Added Button field type.</li>
	<li>Implemented FormBrowser v0.3 Disposition.</li>
	<li>Numerous code fixes.</li>
</ul>

<h3>Version 0.5.12. </h3>
<ul>
	<li>3 Sept 09. Numerous user-submitted fixes. Thanks to Calguy and Simon Schaufi.</li>
</ul>

<h3>Version 0.5.11. 19 Jan 09. (calguy1000)</h3>
<ul>
	<li>Adds the capability to call a UDT before the form is displayed.</li>
	<li>Move changelog to an external file.</li>
</ul>

<h3> Single line releases, Stikki slacking...</h3>
<ul>
	<li>Version 0.5.10. 12 Jan 09. Bug fixes to restore functionality of FormBrowser.</li>
	<li>Version 0.5.9. Jan 09 (calguy1000) - Minor change to the DispositionFile class.</li>
	<li>Version 0.5.8. Jan 09 (calguy1000) - Minor change to the DispositionMultiselectFileDirector class.</li>
	<li>Version 0.5.7. Jan 09 (calguy1000) - Minor change to the DispositionMultiselectFileDirector class.</li>
	<li>Version 0.5.6. 23 Dec 08. Bug fixes.</li>
	<li>Version 0.5.5. 1 Oct 08. Bug fixes. Added new DispositionFromEmailAddressField to replace deficiencies with Email Address 'From' Field type.</li>
	<li>Version 0.5.4. 29 Aug 08. Scrapping plans for 0.6. Bug fixes. Ted's new \"Email \"From Address\" Again Field\". Added database indices.</li>
	<li>Version 0.5.3. 26 May 08. Bugfixes to previous set of bugfixes. Now ready for major upgrades for 0.6.</li>
	<li>Version 0.5.2. 25 May 08. Bugfixes. Release in preparation for substantial reworking for 0.6</li>
	<li>Version 0.5.1. 30 April 08. Bugfixes, rewrote some of the File Upload code to prevent white screen of annoyance.</li>
	<li>Version 0.5. 19 April 08. Bugfixes, support for FormBrowser fixes and features, disposition type for upcoming FormBrowser version.</li>
	<li>Version 0.4.4. 26 Sept 07. Bugfixes for radio button groups, fix for validation of DispositionDeliverToEmailAddressField.</li>
	<li>Version 0.4.3. 18 Sept 07. Bugfixes for pulldowns using numbers, option to inline form, fixes for table-layouts provided by Ap Muthu, fix for requirability of Dispositions.</li>
	<li>Version 0.4.2. 14 Sept 07. Bugfixes for XML export, RadioButton Group submission, and HTML labels.</li>
	<li>Version 0.4.1. Bugfixes for File Disposition Types.</li>
</ul>

<h3>Version 0.4</h3>
<ul>
	<li>Upped minimum CMS version to 1.1</li>
	<li>Numerous Bug fixes; too many to enumerate here</li>
	<li>Massive rejiggering of code to work with CMS MS 1.1 parameter sanitizing regime</li>
	<li>Added field types: \"TextField (Multiple)\" and \"Computed Field\"</li>
	<li>Added dispositions: \"Save Results to File Based on Pulldown\" and \"Save Results to File(s) Based on Multiple Selections\"(Calguy)</li>
	<li>Added neat-o AJAX-y template-copying for Form Templates, gave versions of old table-based templates to soothe the raging masses.</li>
	<li>Added ability to pass default values to form elements from module tag using value_FIELDNAME=\"value\" syntax (Calguy)</li>
	<li>Added option to display field ids in admin (Calguy)</li>
</ul>

<h3>Version 0.3 </h3>
<ul>
  <li>Added Captcha module support.</li>
  <li>Reworked labeling of form elements to be XHTML compliant</li>
  <li>Added Paul Noone's new, improved contact form templates</li>
  <li>Implementation of Email Subject Field</li>
  <li>Added admin-specifiable values to hidden field type, which may contain parsable smarty tags</li>
  <li>Text Area Field now allows specification of rows and cols in the admin, instead of CSS</li>
  <li>Added Drag'n'Drop reordering of form fields.</li>
  <li>Added non-blank field name and unique field name global configuration options and validation</li>
  <li>Implemented templated display of form results upon submission in addition to page redirecting</li>
</ul>

<h3>Version 0.2.4 - 09 May 2007</h3>
<ul>
	<li>Added \"Email Form to User-Supplied Address\" disposition.</li>
	<li>Added \"TimePicker\" field type. Split \"Link\" field into a \"User-supplied Link\" field and a \"Static Link\" field.</li>
	<li>Added HTML email option and auto-templates for all email dispositions.</li>
	<li>Added primitive anti-spam features.</li>
	<li>Added XML-based import and export of forms.</li>
</ul>
   
<h3>Version 0.2.3</h3>
<ul>
   <li>Add the ability to call a selectable user defined tag upon disposition of the form.</li>
</ul>

<h3>Version 0.2.2</h3>
<p>Many thanks to Utter Design for sponsoring some changes and bugfixes, which include:
<ul>
  <li>Added file upload capabilities to the email disposition</li>
  <li>Add PageSetStart and PageSetEnd field types
  <p>These field types allow you to create fieldsets in your form, and organise
  your fields logically for the user.  You can even nest fieldsets, and
  associate a style with them appropriately.  The default template was changed
  to prevent it from wrapping a div around these types of fields.
  </p>
  </li>
  <li>Fixed a problem with DATETIME fields on install
  <p>This solves a problem when on install the response table would sometimes not get created when using adodb lite</li>
  </li>
</ul>
</p>

<h3>Version 0.2 </h3>
<ul>
	<li>14 November 2006. Calguy &amp; tsw's bug fixes for field re-ordering and custom templates. Additional bug fixes for field labels.</li>
</ul>

<h3>Version 0.1</h3>
<ul>
	<li> 8 July 2006. Initial Release</li>
</ul>
