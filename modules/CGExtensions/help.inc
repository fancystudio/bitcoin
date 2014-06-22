<h3>What Does This Do?</h3>
<p>This module merely provides convenience api's, re-usable forms, and smarty tags for use in other modules.  It is meant solely from which to build other modules. If you are not a programmer you probably won't need to do anything with this module besides adjust some preferences.</p>
<h3 style="color: #f00;">Notes</h3>
<p>Many modules take advantages of the forms that are provided by the CGExtensions module to assist in managing templates.  When they do, the CGExtensions module information is displayed prominently.  However when you submit, or cancel from these forms you will be returned to the original module.</p>
<h3>How Do I Use It</h3>
<p>Well, you start your own module (I suggest starting with the Skeleton module), and then when you need to use an advanced form object from this library, simply make your module dependant upon FormObjects, and then instantiate an object of the appropriate type.  See the code inside the FormObjects directory for usage instructions.</p>
<h3>Smarty Addons</h3>
<p>This module adds a few smarty conveniences for use with other modules. They are listed and described here:</p>
<ul>
<li><u>cge_module_hint - <em>function</em> plugin</u>
<h5>Description:</h5>
<p>This function plugin can be used to provide hints for module behavior if various parameters cannot be specified on the URL.  I.e: In a situation when a site is configured to use pretty urls for SEO purposes it is often impossible to provide additional module parameters like a detailtemplate or sort order on a URL.  This plugin can be used in page templates, GCBs or in a page specific way to give hints as to how modules should behave.</p>
<p><strong>Note:</strong> Any parameters that are specified on the URL will override matching module hints.   i.e:  When using News and a detailtemplate parameter is specified on a News detail url, any detailtemplate hints will have no effect.</p>
<p><strong>Note:</strong> In order to ensure proper behavior, module hints must be created before the {content} tag is executed in the CMSMS page template.  Therefore they should (normally) be created very early in the page template process.  An ideal location for page specifc hints is in the &quot;Smarty data or logic that is specific to this page:&quot; textarea on the editcontent form.</p>
<h5>Example:</h5>
<p>When using the CGBlog module, and pretty urls.  You wish to display blog articles for a specific category on one page, and would like to use a non standard detail template to display the individual articles on a differernt page.  I.e: perhaps on your &quot;Sports&quot; page you are calling CGBlog like: <code>{CGBlog category=sports detailpage=sports_detail}</code>.  However, using pretty urls it is impossible to specify a detailtemplate on the links that will generate the detail views.  The solution is to use the {cge_module_hint} tag on the <u>sports_detail</u> page to provide some hints as to how CGBlog should behave on that page.</p>
<p>When editing the <u>sports_detail</u> page on the options tab, in the textarea entitled &quot;Smarty data or logic that is specific to this page:&quot; you could enter a tag such as: <code>{cge_module_hint module=CGBlog detailtemplate=sports}</code>.  Now when a user clicks on a link from the CGBlog display on your &quot;sports&quot; page he will be directed to the <u>sports_detail</u> page, and the CGBlog detail template entitled &quot;sports&quot; will be used to display the article.</p>
<h5>Usage:</h5>
<p><code>{cge_module_hint module=ModuleName paramname=value ...}</code></p>
<p><strong>Note:</strong> It is possible to specify multiple parameter hints to a single module in one call to this plugin.</p>
<p><strong>Note:</strong> It is possible to call this module multiple times to provide hints to different modules.</p>
</li><br/>

<li><u>{cgerror}</u> - <em>block</em> plugin
<p>Description: This block plugin uses the error template (configurable from the CGExtensions admin interface) to display an error message.</p>
<p>optional parameters: 'errorclass' = override the default class name in the template.</p>
<p>i.e: <code>{cgerror}This is error text{/cgerror}</code><br/>
or: <code>{cgerror}{$errortextvar}{/cgerror}</code></br>
</p>
</li><br/>

<li><u>{cge_content_type type=string}</u> - <em>function</em> plugin
<p>Description: A plugin to change the content type of an action.  This is particularly useful in templates that are in response to ajax requests.</p>
<p>i.e: <code>{cge_content_type type='text/xml'}</code></p>
</li><br/>

<li><u>{cge_cached_url url=string [time=minutes]}</u> - <em>function</em> plugin
<p>Description: A plugin to retrieve the contents of a remote URL and cache the contents for a specified number of minutes.  Then return it.  This plugin is useful for retrieving the contents of remote URLS, or of local urls that represent expensive operations but can be cached.</p>
<p>i.e: <code>{cge_cached_url url='http://somesite.com/'}</code></p>
<p>Tip:  It is possible to use this function to cache expensive operations:</p>
  <ol>
    <li>Create a new page template with just <code>{content}</code> in it. Name the page template something like content_only</li>
    <li>Create a new content page using the new content_only page template.  Ensure that it will not be shown in the menu. In the content area of this page place smarty tags or other functions that are quite expensive in processing but do not need to be refreshed regularly.  Remember the page alias for this new page.</li>
    <li>On your normal page template(s) call <code>{cge_cached_url url="{cms_selflink href=$page_alias}"}</code></li>
  </ol>
</li><br/>

<li><u>{cge_isbot [assign=name]}</u> - <em>function</em> plugin
<p>Description: A plugin to detect wether the request is from a robot.<p>
<p>i.e: <code>{cge_isbot assign='isbot'}{if $isbot}&lt;h3&gt;You are a bot&lt;/h3&gt;{/if}</code></p>
</li><br/>

<li><u>{cge_is_smartphone [assign=name]}</u> - <em>function</em> plugin
<p>Description: A plugin to detect wether the request is from a smart phone such as an iphone or android.<p>
<p>i.e: <code>{cge_is_smartphone assign='isbot'}{if $isbot}&lt;h3&gt;I should do some funky mobile styling here.&lt;/h3&gt;{/if}</code></p>
</li><br/>

<li><u>{cge_getbrowser [assign=name]}</u> - <em>function</em> plugin
<p>Description: A plugin to return the name of the detected browser.  Returns a short string indicating the browser type.</p>
<p>i.e: <code>{cge_getbrowser assign='isbot'}{if $isbot}&lt;h3&gt;I should do some funky mobile styling here.&lt;/h3&gt;{/if}</code></p>
</li><br/>

<li><u>{cge_isie [assign=name]}</u> - <em>function</em> plugin
<p>Description: A plugin to detect if the current request is made by <em>(eeewww)</em> Internet Exploder.  It returns 0 or 1.</p>
<p>i.e: <code>{cge_isie assign='isbot'}{if $isbot}&lt;h3&gt;I should do some funky mobile styling here.&lt;/h3&gt;{/if}</code></p>
</li><br/>

<li><u>cge_state_options - <em>function</em> plugin</u>
<p>Description: Output a set of &lt;option&gt; tags for states.  The values are US/Canada State/Province abbreviations, the labels are the full length names in english.  This method reads the defined state list as defined in the database.</p>
<p>i.e: <code>&lt;select name="foo"&gt;{cge_state_options selected=&quot;ab&quot;}&lt;/select&gt;</code></p>
</li><br/>

<li><u>cge_country_options - <em>block</em> plugin</u>
<p>Description: Output a set of &lt;options&gt; tags for countries.  The values are approved country codes, the labels are the full length names (in english).  This method reads the country list as defined in the database, and takes into account the priority countries as defined in the CGExtensions admin console.</p>
<p>i.e: <code>&lt;select name=&quot;foo&quot;{cge_country_options selected=&quot;us&quot;}&lt;/select&gt;</code></p>
</li><br/>

<li><u>get_current_url - <em>function</em> plugin</u>
<p>Description: Return the current page url.</p>
<p>Optional Parameters: 'assign' = assign the output to the named smarty variable.</p>
<p>i.e: <code>{get_current_url assign=&quot;cur_url&quot;}{$cur_url}</code></p>
</li><br/>

<li><u>cge_setlist - <em>function</em> plugin</u>
<p>Description: Allows adding items to flat smarty arrays. This plugin returns no output</p>
<p>ParameterS:
  <ul>
    <li>&quot;name&quot; - The name of the smarty array.</li>
    <li>&quot;key&quot; - The array key.<.li>
    <li>&quot;value&quot; - The array value.</li>
  </ul>
</p>
<br/>
<p>i.e: <code>{cge_setlist name='somearray' key='akey' value='avalue'}</code></p>
</li><br/>

<li><u>cge_unsetlist - <em>function</em> plugin</u>
<p>Description: Allows removing items from flat smarty arrays. This plugin returns no output</p>
<p>ParameterS:
  <ul>
    <li>&quot;name&quot; - The name of the smarty array.</li>
    <li>&quot;key&quot; - The array key.<.li>
  </ul>
</p>
<br/>
<p>i.e: <code>{cge_unsetlist name='somearray' key='akey'}</code></p>
</li><br/>

<li><u>cge_yesno_options - <em>function</em> plugin</u>
<p>Description: Output options for a dropdown list that allows selecting two options, &quot;Yes&quot; or &quot;No&quot;.  This plugin will output the &lt;option&gt tags using localized strings for the labels, and integers for the values.</p>
<p>Optional Parameters:
  <ul>
    <li>&quot;prefix&quot; - A prefix to place before the name attribute on the tag.  i.e: prefix=$actionid</li>
    <li>&quot;name&quot; - A name for the select list, if this parameter is specified the system will generate a complete &lt;select&gt; tag.  Otherwise, only &lt;option&gt; tags will be generated.</li>
    <li>&quot;id&quot; - An id attribue for the select list.  Only useful if the name is also specified.</li>
    <li>&quot;class&quot; - A class attribue for the select list.  Only useful if the name is also specified.</li>
    <li>&quot;selected&quot; - The value of the currently selected element (either 0 or 1)</li>
    <li>&quot;assign&quot; - Assign the output html code to a newly generated smarty variable.</li>
  </ul>
</p>
<br/>
<p>i.e: <code>{cge_yesno_options prefix=\$actionid name=&quot;send_mail&quot; selected=$send_mail}</code></p>
</li><br/>

<li><u>cge_have_module - <em>function</em> plugin</u>
  <p>Description: Output a boolean (0 or 1) value if a module is installed and ready to use.</p>
  <p>Optional Parameters:
     <ul>
       <li>&quot;m&quot;|&quot;mod&quot;|&quot;module&quot; - Specify the module name</lI>
       <li>&quot;assign&quot; - Assign the output html code to a newly generated smarty variable.</li>
     </ul>
  </p>
<br/>
<p>i.e: <code>{cge_have_module module=&quot;FrontEndUsers&quot assign=&quot;have_feu&quot;}</code></p>
</li><br/>

<li><u>cgimage - <em>function</em> plugin</u>
  <p>Description: Output an image tag, This plugin is typically used in admin templates, as it automatically searches in the admin theme, and in registered icon directories.</p>
  <p>Required Parameters:
    <ul>
      <li>&quot;image&quot; - The filename of the image.  You may specify a filename, or a path relative to the admin theme&quot;s images directory.</li>
    </ul>
  </p>
  <br/>
  <p>Optional Parameters:
    <ul>
      <li>&quot;alt&quot; - Specify alt text for the image.  If not specified, the value of the image parameter will be used.</li>
      <li>&quot;class&quot; - Specify a class for the image tag.</li>
      <li>&quot;width&quot; - Specify an integer width for the image tag.</li>
      <li>&quot;height&quot; - Specify an integer height for the image tag.</li>
      <li>&quot;assign&quot; - Assign the output html code to a newly generated smarty variable.</li>
    </ul>
  </p>
  <br/>
  <p>See also:  CGExtensions->AddImageDir()</p>
  <p>i.e: <code>{cgimage image=&quot;icons/system/newobject.gif&quot;}</code></p>
</li>
<li><u>rfc_date - <em>modifier</em> plugin</u>
<p>Description: Format a supplied time in an RFC consistent manner.  This modifier is particularly useful when generating RSS feeds.</p>
<p>i.e: <code>{$smarty.now|rfc_date}</code></p>
</li>
<li><u>time_fmt - <em>modifier</em> plugin</u>
<p>Description: Take an absolute time (in seconds) and format it into hours, minutes/seconds</p>
<p><code>{$value|time_fmt[:show_hours[:show_minutes[:show_seconds[:delimiter]]]]}</code></p>
<p>show_hours, and show_minutes default to true.  show_seconds defaults to false.  The default delimiter is :</p>
<p>i.e: <code>{8100|time_fmt}</code></p>
</li>

<li><u>jsmin - <em>block</em> plugin</u>
  <p>Description: Pass content through the javascript minifier.</p>
  <p>Note: You must specify the approprate {literal},{/literal},{ldelim|, and {rdelim} inside the block to allow smarty to process or ignore the code.</p>
  <p>i.e:  <code>{jsmin}&lt;script type="text/javascript"&gt;// alot of javascript code here&lt;/script&gt;{/jsmin}</code></p>
</li><br/>

<li><u>cge_textarea - <em>block</em> plugin</u>
  <p>Description: Create a text area tag, with optional support for wysiwyg editor.  This tag is typically used in admin templates to create text areas.</p>
  <p>Required Parameters:
    <ul>
      <li>&quot;prefix&quot; - A string to prefix the textarea element name.  i.e: {$actionid}</li>
      <li>&quot;name&quot; - The element name.</li>
    </ul>
  </p>
  <br/>
  <p>Optional Parameters:
    <ul>
      <li>&quot;wysiwyg&quot; - An integer value to indicate wether a wysiwyg should be applied (the actual wysiwyg that is used depends on CMSMS site preferrences and user preferences.</li>
      <li>&quot;content&quot; - The content for the text area.</li>
      <li>&quot;class&quot; - An optional class to supply to the text area tag.</li>
      <li>&quot;id&quot; - An optional id attribute for the text area tag.</li>
      <li>&quot;rows&quot; - An optional rows attribute for the text area tag.</li>
      <li>&quot;cols&quot; - An optional cols attribute for the text area tag.</li>
      <li>&quot;assign&quot; - Assign the output html code to a newly generated smarty variable.</li>
    </ul>
  </p>
  <br/>
  <p>i.e: <code>{cge_textarea prefix=$actionid name=&quot;description&quot; content=$description wysiwyg=1}</code></p>
</li><br/>

<li><u>cge_str_to_assoc - <em>function</em> plugin</u>
  <p>Description: Convert url parameter type string to an associative array.</p>
  <p>Required Parameters:
    <ul>
      <li>&quot;input&quot; - The input string</li>
    </ul>
  </p>
  <br/>
  <p>Optional Parameters:
    <ul>
      <li>&quot;delim1&quot; - Delimiter for separating the string into a list of variables.  Defaults to &quot;,&quot;</li>
      <li>&quot;delim2&quot; - Delimiter for separating variable into a variable name and value.  Defaults to &quot;=&quot;</li>
      <li>&quot;assign&quot; - Assign the output html code to a newly generated smarty variable.</li>
    </ul>
  </p>
  <br/>
  <p>i.e: <code>{cge_str_to_assoc input=&quot;var1=val1,var2=val2,var3=val3&quot; assign=&quot;tmp&quot;}</code></p>
</li><br/>

<li><u>cge_wysiwyg - <em>function</em> plugin</u>
  <p>Description: An alias for the {cge_textarea} plugin.</p>
</li><br/>

<li><u>cge_cache - <em>block</em> plugin</u>
  <p>Description: Cache html outout between start and end blocks for performance. By default content between the start and end tags is cached to files in the tmp/cache directory for a period of five minutes.  Later versions of this plugin will allow extending the cache lifetime.</p>
  <p><strong>Note:</strong> This is not technically a block plugin, but does behave like one.</p>
  <p><strong>Note:</strong> This is an advanced plugin that can dramatically improve the average performance of your (primarily static) website, though it should be used with caution as using it incorrectly can cause strange behaviour on your site.  This functionality works best when wrapped around smarty tags that query the database and generate static html content.  This plugin should not be used around dynamic functionality or forms.</p>
  <p><strong>Note:</strong> This plugin utilizes file locking to prevent race conditions.  This may present problems on different platforms.  Use this plugin with caution.</p>
  <pp>i.e: <code>{cge_cache}{Products}{/cge_cache}</code></p>
</li>

<li><u>cge_file_list - <em>function</em> plugin</u>
   <p>Description: A smarty plugin to retrieve a list of files that match a criteria, and optionally to build a list of html options from the results.</p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;dir&quot; - The name of the directory <em>(relative to the uploads path)</em> to search.</li>
     <li>&quot;pattern&quot; - A list of file patterns separated by || to search for.  i.e: *.pdf||*.doc</li>
     <li>&quot;excludes&quot; - A list of file patterns separated by || to exclude from the returned list.  i.e: Z*</li>
     <li>&quot;maxdepth&quit; - A positive integer representing the maximum depth of directories to search.  Default is to put no limit on directory depth.</li>
     <li>&quot;absolute&quot; - A boolean option indicating that the absolute path to the files should be used in the returned values.</li>
     <li>&quot;options&quot; - A boolean option indicating that the output should be a string of html options.</li>
     <li>&quot;selected&quot; - If options is specified, this parameter can be used to specify the currently selected option.</li>
     <li>&quot;novalue&quot; - if the &quot;options&quot; attribute is specified, this parameter can be used to specify the string used to indicate in the generated dropdown or multi select list to indicate that no value has been selected.  By default, there is no option indicating novalue.</li>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
   <p>Example One - Create a dropdown of PDF files in the uploads/docs directory:
     <pre><code>&lt;select name="{$actionid}pdf_file">{cge_file_list dir=docs options=1 novalue="None" pattern='*.pdf' selected=$somevar}&lt;select&gt;</code></pre>
   </p>
   <p>Example Two - Create an array of PDF Files in the uploads/docs directory:
     <pre><code>{cge_file_list dir=docs pattern='*.pdf' assign='pdf_files'}</code></pre>
   </p>
</li>

<li><u>cge_image_list - <em>function</em> plugin</u>
   <p>Description: A smarty plugin to retrieve a list of images that match a criteria from a directory, and optionally to build a list of html options from the results.  This plugin is simply a wrapper around the {cge_file_list} plugin described above.</p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;dir&quot; - The name of the directory <em>(relative to the uploads path)</em> to search.</li>
     <li>&quot;extensions&quot; - A list of file patterns separated by || to override the default pattern of *.jpg||*.jpeg||*.png||*.gif||*.bmp||*.ico</li>
     <li>&quot;excludes&quot; - A list of file patterns separated by || to exclude from the returned list.  i.e: Z*||a*</li>
     <li>&quot;maxdepth&quit; - A positive integer representing the maximum depth of directories to search.  Default is to put no limit on directory depth.</li>
     <li>&quot;absolute&quot; - A boolean option indicating that the absolute path to the files should be used in the returned values.</li>
     <li>&quot;options&quot; - A boolean option indicating that the output should be a string of html options.</li>
     <li>&quot;selected&quot; - If options is specified, this parameter can be used to specify the currently selected option.</li>
     <li>&quot;novalue&quot; - if the &quot;options&quot; attribute is specified, this parameter can be used to specify the string used to indicate in the generated dropdown or multi select list to indicate that no value has been selected.  By default, there is no option indicating novalue.</li>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
</li>

</ul>

<h3>Tab Functions:</h3>
<p>This module provides some smarty plugins to assist in building tabbed output in admin side templates.  This aids in further separating the display issues from logic issues.</p>
<h4>Example:</h4>
  <pre><code>
  {cge_start_tabs}
  {cge_tabheader name='tab1' label='Tab One'}
  {cge_tabheader name='tab2' label='Tab Two'}
  {cge_tabcontent_start name='tab1'}
  &lt;p&gt;Content for tab one&lt;/p&gt;
  {cge_tabcontent_end}{* not necessary, but provided for completeness *}
  {cge_tabcontent_start name='tab2'}
  &lt;p&gt;Content for tab two&lt;/p&gt;
  {cge_end_tabs}
  </code></pre>
<ul>
<li><u>cge_start_tabs - <em>function</em> plugin</u>
   <p>Description: An admin only smarty plugin useful in admin tabs to indicate the start of tabbed output.  See the brief demo above.</p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
</li>
<li><u>cge_tabheader - <em>function</em> plugin</u>
   <p>Description: An admin only smarty plugin used to denote the start of a tab header.  See the brief demo above.</p>
   <p>Required Parameters:
    <ul>
     <li>&quot;name&quot; - The name for the tab.  This shold be all alphanumeric characters, or underscore.</li>
    </ul>
   </p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;label&quot; - The human readable label for this tab.</li>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
</li>

<li><u>cge_tabcontent_start - <em>function</em> plugin</u>
   <p>Description: An admin only smarty plugin used to denote the start of a tab content.  See the demo above.</p>
   <p><strong>Note:</strong> The order of the tabcontents must match exactly the order of the tab headers specified.  Additionally, it is not necessary to denote the ending of the tab headers, as this is detected automatically by the first call to {cge_tabcontent_start}.</p>
   <p>Required Parameters:
    <ul>
     <li>&quot;name&quot; - The name for the tab.  This shold be all alphanumeric characters, or underscore.</li>
    </ul>
   </p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
</li>

<li><u>cge_tabcontent_end - <em>function</em> plugin</u>
   <p>Description: An admin only smarty plugin used to denote the end of a tabs content.  See the demo above.</p>
   <p><strong>Note:</strong>  It is not necessary to call this plugin for each tab, as it is done implicitly by the call to {cge_tabcontent_start} or {cge_end_tabs}.</p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
</li>

<li><u>cge_end_tabs - <em>function</em> plugin</u>
   <p>Description: An admin only smarty plugin used to denote the end of tabbed output..  See the demo above.</p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
</li>

<li><u>cge_message - <em>function</em> plugin</u>
   <p>Description: A simple convenience plugin to store messages in the session and retrieve them. Messages are automatically removed from the session once retrieved.</p>
   <p>See also: class cge_message</p>
   <p>Required Parameters:
     <ul>
       <li>&quot;key&quot; - (string) The message key.</li>
     </ul>
   </p>
   <p>Optional Parameters:
    <ul>
     <li>&quot;value&quot; - Optionally create a new message variable.</li>
     <li>&quot;assign&quot; - Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   </p>
   <p>Usage:
     <ul>
       <li>{cge_message key='sample'} - get, erase, and output the value of &quot;sample&quot; if it exists.</li>
       <li>{cge_message key='sample' assign='foo'} - get, erase, and assign the value of &quot;sample&quot; if it exists to the smarty variable foo.</li>
       <li>{cge_message key='sample' value='bar'} - set the value of the key &quot;sample&quot; to &quot;bar&quot;</li>
     </ul>
   </p>
</li>

</ul>

<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit the cms development forge at <a href="http://dev.cmsmadesimple.org">dev.cmsmadesimple.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author(s), calguy et all can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author(s) directly.</li>
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

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