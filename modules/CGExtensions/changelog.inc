<ul>
<li>Version 1.0.0. March 2007.  Initial Release.</li>
<li>Version 1.0.1. April 2007.  Fixes to CreateImageLink</li>
<li>Version 1.0.2. April 2007.  CreateImageLink will now work on the frontend.</li>
<li>Version 1.0.3. September 2007.  Adds apply buttons to new templates.</li>
<li>Version 1.1.   September 2007.  Adds default frontend error handling plugin.</li>
<li>Version 1.2.   November  2007,  Adds more convenience functions</li>
<li>Version 1.3.   November  2007.  Adds even more convenience functions</li>
<li>Version 1.4.   December  2007.  Adds CreateImageDropdown method, methods for state and country dropdowns and a bunch of other things.</li>
<li>Version 1.5.   January   2008.  Fixes to html_entities_decode in utf8</li>
<li>Version 1.6.   February  2008,  Adds the CGFileUploadHandler class</li>
<li>Version 1.6.1.   February  2008,  Minor fix to recursive_change_directory</li>
<li>Version 1.8. February 2008
  <ul>
    <li>Add a bunch more utility and convenience methods</li>
    <li>Move countries and states into a table so that they can be used with joins etc.</li>
    <li>Add the ability to prioritize certain countries by name</li>
    <li>Adds the GetSingleTemplateForm method to make it convenient to edit and restore to default a single template.</li>
    <li>Fixes issues with the cancel button when editing templates.</li>
    <li>Update the license.</li>
    <li>Updates to the file upload capabilities</li>
    <li>The module is automatically exported to smarty</li>
    <li>Add the get_action_id and set_action_id virtual methods that should be overridden by any module derived from CGExtensions.</li>
  </ul>
  </li>
<li>Version 1.8. May 2008
  <ul>
    <li>Minor change and addition to RedirectToTab</li>
  </ul>
</li>
<li>Version 1.10. September 2008
  <ul>
    <li>Added Watermarking functions.  Other modules can now use CGExtensions
        to add watermarks to images.</li>
    <li>Re-organized the functions, made the core module a bit smaller (there
        is still more to do), and utilize some lazy-loading stuff.</li>
    <li>Added a CreateInputColorDropdown function, or something like that.  This thing is funky, uses javascript to do neat color changes.  Thanks _SjG_</li>
    <li>More bug fixes, and convenience thingies.</li>
  </ul>
</li>
<li>Version 1.10.1. September 2008
  <ul>
    <li>Minor Bug Fixes.</li>
    <li>Upgrade template forms to allow them to work on an action other than defaultadmin</li>
  </ul>
</li>
<li>Version 1.10.2. September 2008
  <ul>
    <li>Minor Bug Fixes.</li>
  </ul>
</li>
<li>Version 1.10.3. October 2008
  <ul>
    <li>Support for syntax hilighter when editing templates.</li>
  </ul>
</li>
<li>Version 1.12 December 2008
  <ul>
    <li>Add numerous more methods.</li>
  </ul>
</li>
<li>Version 1.13 December 2008
  <ul>
    <li>Add the Sortable List Area functionlity</li>
    <li>Add another smarty tag for state options.</li>
  </ul>
</li>
<li>Version 1.14 December 2008
  <ul>
    <li>Added us_date_format modifier.</li>
  </ul>
</li>
<li>Version 1.14.1 December 2008
  <ul>
    <li>Changed us_date_format modifier to rfc_date modifier</li>
    <li>Fixed problem with nested forms.</li>
  </ul>
</li>
<li>Version 1.15 January 2009
  <ul>
    <li>Added the GetCurrentURL() method.</li>
  </ul>
</li>
<li>Version 1.15.1  February 2009
  <ul>
    <li>Fixed the piority countries sorting thing.</li>
  </ul>
</li>
<li>Version 1.15.2  March 2009
  <ul>
    <li>Fixes (hopefully) the &quot;request uri too large&quot; issue on apply.</li>
  </ul>
</li>
<li>Version 1.15.3  March 2009
  <ul>
    <li>Adds the ability select multiple files in the file dropdown.</li>
  </ul>
</li>
<li>Version 1.16  July 2009
  <ul>
    <li>Numerous bugfixes and new features.</li>
  </ul>
</li>
<li>Version 1.16.1  July 2009
  <ul>
    <li>Fix problem with apply button in template editing.</li>
  </ul>
</li>
<li>Version 1.16.1  July 2009
  <ul>
     <li>Add http_post method.</li>
  </ul>
</li>
<li>Version 1.17 - August 2009
  <ul>
     <li>Convert alot of stuff into PHP5 classes.</li>
     <li>Adds encrypted associative data thing.</li>
  </ul>
</li>
<li>Version 1.17.1 - August 2009
  <ul>
     <li>Fixed issue with constructor being incompatible with other modules that didn't have the __construct method</li>
  </ul>
</li>
<li>Version 1.17.2 - August 2009
  <ul>
     <li>Adds the cge_debug class.</li>
     <li>Implements autoload stuff, gets rid of the require_once lines all over the place, but requires PHP 5.2+</li>
  </ul>
</li>
<li>Version 1.17.3 - September 2009
  <ul>
     <li>Adds cge_array::hashsort and cge_array::hashrsort</li>
  </ul>
</li>
<li>Version 1.17.4 - September 2009
  <ul>
     <li>Adds RedirectToHTTPS which uses an optional $confg['ssl_url'] variable.</li>
  </ul>
</li>
<li>Version 1.17.5 - October 2009
  <ul>
     <li>Adds expiry parameters to the data store classes.</li>
  </ul>
</li>
<li>Version 1.17.6 - November 2009
  <ul>
     <li>Improved country handling.</li>
  </ul>
</li>
<li>Version 1.17.9 - February 2010
  <ul>
     <li>Fixes the RedirectToHTTPS function</li>
     <li>Improvements to the url handling stuff.</li>
     <li>Adds a common address class.</li>
  </ul>
</li>
<li>Version 1.18 - March 2010
  <ul>
     <li>Adds ability to create preview images on uploads in the upload handlers.</li>
     <li>Adds company field to the address class.</li>
     <li>Now look for interfaces in the autoloader.</li>
     <li>More optimization, move functions out of module class intolib directory classes, etc.</li>
     <li>Many fixes to classes.</li>
  </ul>
</li>
<li>Version 1.18.1 - March 2010
  <ul>
     <li>Minor fix to charting classes.</li>
  </ul>
</li>
<li>Version 1.18.2 - April 2010
  <ul>
     <li>Bug fixes.</li>
  </ul>
</li>
<li>Version 1.18.3 - April 2010
  <ul>
     <li>Bug fixes.</li>
  </ul>
</li>
<li>Version 1.18.4 - April 2010
  <ul>
     <li>Fixes to cge_url::redirect_https</li>
  </ul>
</li>
<li>Version 1.18.6 - April 2010
  <ul>
     <li>Adjustments and fixes to the http client class.</li>
     <li>Fixes to the cached_remote_file class.</li>
     <li>Minor tweaks.</li>
  </ul>
</li>
<li>Version 1.18.6 - April 2010
  <ul>
     <li>Adjustments and fixes to the http client class.</li>
     <li>Fixes to the cached_remote_file class.</li>
     <li>Minor tweaks.</li>
  </ul>
</li>
<li>Version 1.19
  <ul>
     <li>Many enhancements.</li>
  </ul>
<li>
<li>Version 1.19.1
  <ul>
    <li>Adds the check_upload method to the upload class...</li>
    <li>Begin the documentation process (what a pain that is gonna be).</li>
  </ul>
</li>
<li>Version 1.19.2
  <ul>
    <li>Fixes bugs in the AssocData class.</li>
  </ul>
</li>
<li>Version 1.19.3
  <ul>
    <li>Force states and countries lists to refresh.</li>
  </ul>
</li>
<li>Version 1.20
  <ul>
    <li>Fixes 1.9 compatibility stuff.</li>
    <li>Bug fixes</li>
    <li>Adds friendly class</li>
  <ul>
</li>
<li>Version 1.21.1
  <ul>
    <li>Fixes 1.9 compatibility stuff.</li>
    <li>Bug fixes</li>
    <li>Aadds jsmin plugin.</li>
    <li>More functions in cge_string</li>
    <li>A couple more smarty plugins.</li>
  <ul>
</li>
<li>Version 1.21.2
  <ul>
    <li>Adds a new recursive glob method to cge_dir.</li>
    <li>Fixes to the cge_array::explode_with_key() method.</li>
    <li>Updates Help.</li>
  <ul>
</li>
<li>Version 1.21.3
  <ul>
    <li>Fixes an error in template handling stuff.</li>
  <ul>
</li>
<li>Version 1.21.5
  <ul>
  <li>Adds the cms_cache_handler, cms_cache_driver, and cms_filecache_driver classes (maybe later they can be moved to the core)</li>
  <li>Now use file_get_contents() when requesting a URL when CURL is not installed using cms_http::get()</li>
  <li>Fixes problems with get_template_list()</li>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>Version 1.21.5
  <ul>
  <li>Add another test in the constructor for the cache stuff, cuz ModuleuManager does wierd stuff.</li>
  </ul>
</li>
<li>Version 1.21.6
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>Version 1.21.7
  <ul>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>Version 1.23
  <ul>
  <li>Adds the Browser code</li>
  <li>Minor bug fixes.</li>
  </ul>
</li>
<li>Version 1.24
  <ul>
  <li>Extends the browser code for better robot detection.</li>
  <li>Adds {cge_isbot} and {cge_is_smartphone} smarty plugins.</li>
  </ul>
</li>
<li>Version 1.24.1
  <ul>
  <li>Adds the report base class.</li>
  </ul>
</li>
<li>Version 1.24.2
  <ul>
  <li>Handle the stupid input type='image' cross browser problem.</li>
  </ul>
</li>
<li>Version 1.25
  <ul>
  <li>Adds some more classes for delaing with pop3 servers.</li>
  </ul>
</li>
<li>Version 1.25.1
  <ul>
  <li>Bug fixes.</li>
  </ul>
</li>
<li>Version 1.25.2
  <ul>
  <li>Bug fixes.</li>
  <li>Adds a new function to the cge_url class.</li>
  </ul>
</li>
<li>Version 1.25.3
  <ul>
  <li>Adds auditing of template edits etc.</li>
  </ul>
</li>
<li>Version 1.25.4
  <ul>
  <li>Fixes to the http class that I found in working with 1.10</li>
  <li>Now call class_exists('CGExtensions',false) ... to handle the 1.9 problems but also make way for 1.10</li>
  </ul>
</li>
<li>Version 1.26
  <ul>
   <li>Adds the new CGDomDocument class that has support for innerhtml...</li>
  </ul>
</li>
<li>Version 1.27
  <ul>
   <li>Adds the new {cge_wysiwyg} smarty plugin.</li>
   <li>Use cms_http_request for http requests, if available.</li>
  </ul>
</li>
<li>Version 1.28
  <ul>
   <li>Some more useful smarty plugins.</li>
  </ul>
</li>
<li>Version 1.28.1
  <ul>
   <li>Minor bug fixes.</li>
  </ul>
</li>
<li>Version 1.28.2
  <ul>
   <li>Minor bug fixes.</li>
  </ul>
</li>
<li>Version 1.29.x
 <ul>
   <li>Improvements to default template handling.</li>
   <li>Minor enhancements to error handling.</li>
   <li>CGCreateFormStart by default uses multipart/form-data to allow uploads.</li>
   <li>Minor compatibility for CMSMS 1.11</li>
   <li>Moved help out of the lang file.</li>
 </ul>
</li>
<li>Version 1.30
 <ul>
  <li>Adds the {cge_module_hint} tag.</li>
 </ul>
</li>
<li>Version 1.30.1
 <ul>
  <li>Minor improvements to the add/edit template stuff.</li>
 </ul>
</li>
<li>Version 1.30.2
 <ul>
  <li>Added the cge_userops::get_grouplist() method.</li>
  <li>Added the notification_message class.</li>
 </ul>
</li>
<li>Version 1.31
 <ul>
  <li>Improved cge_cached_remote_file class.</li>
  <li>Fixes to the smartcache class.</li>
  <li>Many minor improvements... new functions in the cge_utils class.</li>
 </ul>
</li>
<li>Version 1.32
 <ul>
  <li>Numerous improvements to smarty functions.</li>
  <li>Now requries PHP 5.3 or greater.</li>n
 </ul>
</li>
<li>Version 1.35
  <ul>
    <li>Adds the {cge_content_type} smarty plugin... and a minor fix to the upload stuff.</li>
  </ul>
</li>
<li>Version 1.36
  <ul>
    <li>Adds the {cge_cached_url} plugin.</li>
    <li>Minor bug fixes.</li>
  </ul>
</li>
<li>Version 1.37
  <ul>
    <li>Adds new preferences for memory limit detection used by some modules.</li>
    <li>Improvements to the notification message class.</li>
    <li>New generic object sorting method.</li>
    <li>Adds more bots to the bot checker</li>
    <li>Bug fixes.</li>
  <ul>
</li>
<ii>Version 1.38.x
  <ul>
    <li>Improvements to file upload handlers.</li>
    <li>Adds the messaging classes.</li>
    <li>Bug fixes.</li>
    <li>Code cleanup</li>
    <li>Adds the cge_utils::get_param() method</li>
    <li>Adds the CGGetPreference method to the module api.</li>
    <li>Adds the get_uid_emails convenience method.</li>
    <li>Improvements to {cge_textarea}</li>
    <li>Improvements to {cg_image}</li>
  </ul>
</li>
</ul>
