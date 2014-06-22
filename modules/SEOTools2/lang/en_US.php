<?php
#-------------------------------------------------------------------------
# Module: SEOTools2 - Turbo-charge your on-page SEO
# Version: 1.2, Clip Magic <admin@clipmagic.com.au>
# Action: en_US Help text and change log
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

$lang['friendlyname'] = 'SEOTools2';
$lang['postinstall'] = 'SEOTools2 has been installed. Be sure to read the module help to learn how to use it.';
$lang['postuninstall'] = 'SEOTools2 has been uninstalled. Please be aware that you have just lost all meta information from your pages!';
$lang['really_uninstall'] = 'Do you really want to uninstall SEOTools2?';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['moddescription'] = 'A collection of tools to help with Search Engine Optimization.';

$lang['eventdesc-PrefsUpdated'] = 'Sent when the admin preferences are updated.';
$lang['eventhelp-PrefsUpdated'] = '<p>Sent when the admin preferences are updated.</p>
<h4>Parameters</h4>
<ol>
<li></li>
</ol>';



$lang['error'] = 'Error!';
$land['admin_title'] = 'SEOTools2 Admin Panel';
$lang['admindescription'] = 'Helps with SEO in general, automatically generating XML sitemaps and comprehensive meta descriptions';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['SEOAlerts'] = 'SEO Alerts';
$lang['Pagedescriptions'] = 'Page settings';
$lang['Sitemap'] = 'Sitemap';
$lang['SEOSettings'] = 'SEO Settings';
$lang['title_seoalerts'] = 'SEO Alerts';
$lang['title_pagedescriptions'] = 'Page settings';
$lang['title_sitemap'] = 'Sitemap';
$lang['title_seosettings'] = 'SEO Settings';

$lang['title_meta_type'] = 'Meta Tag Generator';
$lang['meta_create_standard'] = 'Generate standard Meta Tags';
$lang['meta_doctype'] = 'HTML Version';
$lang['meta_doctype_help'] = '(Select the version of HTML used in the page templates)';
$lang['meta_create_dublincore'] = 'Generate Dublin Core Meta Tags';
$lang['meta_create_opengraph'] = 'Generate OpenGraph Meta Tags (e.g. for Facebook Like Button)';

$lang['title_meta_defaults'] = 'META Tag Values';
$lang['meta_publisher'] = 'Site publisher';
$lang['meta_publisher_help'] = '(This is usually the organization you are building the website for)';
$lang['meta_contributor'] = 'Site contributor';
$lang['meta_contributor_help'] = '(Usually, this would be you or any other content author)';
$lang['meta_copyright'] = 'Site copyright';
$lang['meta_copyright_help'] = '(Something like "{custom_copyright} {sitename}. All Rights Reserved". You can use smarty tags and UDTs here.)';
$lang['meta_location_description'] = 'If your website is about an entity that can be located on a map, you should optionally fill in the following values:';
$lang['meta_location'] = 'Location of your entity';
$lang['meta_location_help'] = '(Usually, this would be the town name of your company)';
$lang['meta_region'] = 'Region of your entity';
$lang['meta_region_help'] = '(Enter something like "US-IL" for an entity located in Illinois, US)';
$lang['meta_latitude'] = 'Latitude of your entity';
$lang['meta_latitude_help'] = '(Enter the decimal latitude geo coodinate of your entitiy)';
$lang['meta_longitude'] = 'Longitude of your entity';
$lang['meta_longitude_help'] = '(Enter the decimal longitude geo coodinate of your entitiy)';
$lang['meta_opengraph_description'] = 'If you are creating OpenGraph META Tags, please fill in the following values:';
$lang['meta_opengraph_title'] = 'OpenGraph page title';
$lang['meta_opengraph_title_help'] = '(You can use all smarty tags here, e.g. to replace with the actual page title)';
$lang['meta_opengraph_type'] = 'OpenGraph default page type';
$lang['meta_opengraph_type_help'] = '(The default page type for OpenGraph, can be overridden for each page. Look <a href="http://developers.facebook.com/docs/opengraph#types" taget="_blank">here</a> for a list of allowed values)';
$lang['meta_opengraph_sitename'] = 'OpenGraph site name';
$lang['meta_opengraph_sitename_help'] = '(A short version of your site name, e.g. "Your Company", max. 25 chars)';
$lang['meta_opengraph_image'] = 'OpenGraph default image';
$lang['meta_opengraph_image_help'] = '(Select an image from your images directory to be used as the default for OpenGraph pages)';
$lang['meta_opengraph_admins'] = 'Facebook site administrators';
$lang['meta_opengraph_admins_help'] = '(A comma separated list of facebook account IDs who are able to administrate the streams of your pages)';
$lang['meta_opengraph_application'] = 'Facebook application';
$lang['meta_opengraph_application_help'] = '(The ID of a facebook application able to administrate the streams of your pages)';

$lang['title_title_description'] = 'Page title, description and keywords';
$lang['title_title'] = 'Page title';
$lang['title_title_help'] = '(The page title to be displayed in the browser\'s title bar. You can use the tags {title}, {$pagetitle}, {$seo_keywords} and all smarty tags and UDTs here)';
$lang['title_meta_title'] = 'Page Meta title';
$lang['title_meta_help'] = '(The page title to be used in the Meta title tags. You can use the tags {title}, {$pagetitle}, {$seo_keywords} and all smarty tags and UDTs here)';
$lang['description_block_title'] = 'Name of page description content block';
$lang['description_block_help'] = '(The name of your page description content block. Please see below for an explanation)';
$lang['detail_keywords_var_title'] = 'Module custom field keywords Smarty var';
$lang['detail_keywords_var_help'] = '(Name of the Smarty var you assigned your custom field keywords to on a module detail template. Please see below for an explanation)';


$lang['default_keywords_title'] = 'Keywords to always include';
$lang['default_keywords_help'] = '(A comma-separated list of keywords you would like to include on every page)';

$lang['title_sitemap_description'] = 'Google Sitemap and Crawler Settings';
$lang['create_sitemap_title'] = 'Create an XML Google Sitemap*';
$lang['push_sitemap_title'] = 'Automatically push the sitemap to Google after content changes';
$lang['create_robots_title'] = 'Create a robots.txt file*';
$lang['verification_title'] = 'Site verification code';
$lang['verification_help'] = '(The site verification code you obtain from Google Webmaster Tools, just the hash, not the complete meta tag)';

$lang['title_alerts_urgent'] = 'To be fixed immediately';
$lang['title_alerts_important'] = 'To be fixed as soon as possible';
$lang['title_alerts_notices'] = 'Things you should consider fixing';
$lang['nothing_to_be_fixed'] = 'There are no actions you need to take in this category';

$lang['save'] = 'Save settings';
$lang['none'] = '(none)';
$lang['confirm'] = 'Confirm';
$lang['cancel'] = 'Cancel';
$lang['settings_updated'] = 'The SEO settings were successfully updated.';
$lang['problem_alert'] = 'has detected severe problems with your SEO. %s';
$lang['problem_link_title'] = 'Click here to fix them';

$lang['help_description_content'] = '<b>How to use the "description content block":</b><br />To be able to enter a page description when editing a page, you must include the following code anywhere on every template:<br /><br /><pre>{capture assign=metadescription}{content block="metadescription" label="META Description" oneline="true"}{/capture}</pre><br />Then, put "metadescription" into the field "Name of page description content block<br /><br />Alternatively, enable the option &quot;Automatically generate descriptions where none is given&quot;. This is not as good but still better than nothing.';
$lang['help_detail_keywords_content'] = '<b>How to use the "module custom field smarty var":</b><br />You can overwrite the page keywords by assigning a custom field in a module detail template, eg News, CGBlog, Products, etc, that contains a comma-separated list of keywords specific to the article or product, eg {assign="detail_keywords" value=$entry->fields.custom.myfield.value} (or whatever the particular module requires to access the field value) to Smarty. The custom field name does not matter however the name of the Smarty var to which you assign the value must be consistent throughout all your modules.';


$lang['help_sitemap_robots'] = '* To use the automatic generation of a sitemap and robots.txt file, both the root directory of your server and CMSMS installation must be writeable to the web server. If you already have a sitemap.xml and/or robots.txt file, both of them must be writeable to the web server.';

$lang['use_standard_or_dublincore_meta'] = 'Use at least one of the standard or Dublin Core Meta Tag generators';
$lang['use_standard_meta'] = 'You should always enable the standard Meta generator';
$lang['meta_description_missing'] = 'The page <i>%s</i> is lacking a Meta description';
$lang['meta_description_short'] = 'The Meta description of <i>%s</i> is rather short ( < 75 chars)';
$lang['duplicate_titles'] = 'The pages <i>%s</i> and <i>%s</i> have the same title';
$lang['duplicate_descriptions'] = 'The pages <i>%s</i> and <i>%s</i> have the same Meta description';
$lang['provide_an_author'] = 'You should provide the name of the page publisher';
$lang['set_up_description_block'] = 'Set up a content block for Meta descriptions';
$lang['activate_pretty_urls'] = 'Activate the pretty URLs feature of CMSMS';
$lang['pretty_urls_help'] = '<a href="http://wiki.cmsmadesimple.org/index.php/User_Handbook/Installation/Optional_Settings" target="_blank">Get help</a>';
$lang['create_a_sitemap'] = 'Have a Google XML Sitemap automatically created for you';
$lang['automatically_upload_sitemap'] = 'Have your XML Sitemap automatically uploaded to Google';
$lang['create_robots'] = 'Have a robots.txt file automatically created for you';
$lang['sitemap_not_writeable'] = 'Your sitemap.xml file is not writeable';
$lang['chmod_sitemap'] = 'Set your /sitemap.xml file to be writeable by the web server';
$lang['robots_not_writeable'] = 'Your robots.txt file is not writeable';
$lang['no_opengraph_admins'] = 'You have not set an OpenGraph admin application resp. admin list';
$lang['no_opengraph_type'] = 'You have not set the default OpenGraph page type';
$lang['no_opengraph_sitename'] = 'You have not set the OpenGraph site name';
$lang['no_opengraph_image'] = 'You have not set an OpenGraph default image';
$lang['chmod_robots'] = 'Set your /robots.txt file to be writeable by the web server';
$lang['edit_page'] = 'Edit %s';
$lang['edit_page_to_fix'] = 'Click here to edit the page and fix the problem';
$lang['visit_settings'] = 'Change settings';

$lang['page_id'] = 'ID';
$lang['page_name'] = 'Page name';
$lang['page_menutext'] = 'Page menu text';
$lang['priority'] = 'Sitemap Priority';
$lang['og_type'] = 'OpenGraph type';
$lang['keywords'] = '# Keywords';
$lang['description'] = 'Description';
$lang['index'] = 'Index';
$lang['follow'] = 'Follow';

$lang['click_to_add_description'] = 'Click here to add a page description';
$lang['toggle'] = 'toggle';
$lang['reset'] = 'reset';
$lang['reset_to_default'] = 'Reset this to the default value';
$lang['edit_value'] = '[Edit]';
$lang['admin_view'] = 'Quick unformatted view of your main content block';
$lang['edit_page'] = '[Edit Page]';
$lang['view_page'] = '[View in Browser]';
$lang['compile_udts'] = 'Use Smarty to compile UDTs in the content preview on the Keyword Edit screen';
$lang['compile_udts_help'] = '(Uncheck this option if it causes problems. Smarty tags in the preview will then appear as normal text.)';

$lang['help_opengraph'] = 'Look <a href="http://developers.facebook.com/docs/opengraph#types" taget="_blank">here</a> for a list of allowed values';
$lang['enter_new_ogtype'] = 'Enter the new value for this page\'s OpenGraph type';
$lang['help_new_ogtype'] = 'Leave blank to revert to the default setting';

$lang['enter_new_keywords'] = 'Enter the new keywords for this page';
$lang['help_new_keywords'] = 'COMMA separated list of keywords. Leave blank to revert to auto generated keywords';
$lang['metadescription_content'] = 'Meta Description Tag Content';
$lang['no_metadescription'] = '<em><strong>NO META DESCRIPTION SET FOR THIS PAGE!</strong></em>';

$lang['grouptitle_opengraph'] = 'We have detected %s OpenGraph related problem(s)';
$lang['grouptitle_system'] = 'We have detected %s problem(s) with your system configuration';
$lang['grouptitle_pages'] = 'We have detected %s problem(s) on your content pages';
$lang['grouptitle_settings'] = 'We have detected %s problem(s) with your SEO Settings';
$lang['grouptitle_descriptions'] = 'We have detected %s problem(s) with your page descriptions';
$lang['grouptitle_titles'] = 'We have detected %s problem(s) with your page titles';

$lang['view_all'] = 'View all';

$lang['title_metasettings'] = 'Page title &amp; Meta information';
$lang['title_sitemapsettings'] = 'Sitemap &amp; Crawler settings';
$lang['title_keywordsettings'] = 'Keyword generator settings';

$lang['description_auto_generate'] = 'Automatically generate a page description where none is provided';
$lang['description_auto_title'] = 'Text for auto-generated descriptions';
$lang['description_auto_help'] = '(You <b>must</b> include the tag {keywords} here)';

$lang['set_up_auto_description'] = 'Set up the description auto-generator and ensure the text contains the tag {keywords}';
$lang['auto_generated'] = 'Automatically generated';
$lang['and'] = 'and';

$lang['title_keyword_weight'] = 'Keyword weight settings';
$lang['keyword_minlength_title'] = 'Minimum keyword length';
$lang['keyword_minlength_help'] = '(The minimum length of a word to be considered as a keyword)';
$lang['keyword_title_weight_title'] = 'Weight of words in the page title';
$lang['keyword_title_weight_help'] = '(The weight of words in the page title. The higher a word\'s weight, the more likely it is to become a keyword)';
$lang['keyword_description_weight_title'] = 'Weight of words in the page description';
$lang['keyword_description_weight_help'] = '(The weight of words in the page description. The higher a word\'s weight, the more likely it is to become a keyword)';
$lang['keyword_headline_weight_title'] = 'Weight of words in content headlines';
$lang['keyword_headline_weight_help'] = '(The weight of words between &lt;h1&gt; to &lt;h6&gt; tags. The higher a word\'s weight, the more likely it is to become a keyword)';
$lang['keyword_content_weight_title'] = 'Weight of words in plain content';
$lang['keyword_content_weight_help'] = '(The weight of words inside the plain content. The higher a word\'s weight, the more likely it is to become a keyword)';

$lang['keyword_minimum_weight_title'] = 'Minimum total weight of a keyword';
$lang['keyword_minimum_weight_help'] = '(The minimum total weight of a word to become a keyword. Should be greater than the highest weight from above. The smaller the number, the more keywords you get)';

$lang['help_keyword_generator'] = 'The settings you change on this page will not affect any keywords you enter manually. Feel free to play with all values until you get the best results for your page.';

$lang['title_keyword_exclude'] = 'Keyword exclusion list';
$lang['keyword_exclude_title'] = 'Words to never consider as keywords';
$lang['keyword_exclude_help'] = '(Provide a space separated list of words that should never appear in keyword lists)';

$lang['increase_priority'] = 'by 10%';
$lang['decrease_priority'] = 'by 10%';

$lang['title_regenerate_sitemap'] = "Regenerate sitemap and robots.txt";
$lang['button_regenerate_sitemap'] = "Regenerate sitemap and robots.txt now";
$lang['text_regenerate_sitemap'] = "It can be necessary to regenerate the sitemap and robots.txt file after extensive changes to the page structure";
$lang['sitemap_regenerated'] = "Both the sitemap and the robots.txt files have been successfully regenerated.";
$lang['sitemap_only_regenerated'] = "Only the sitemap file was regenerated.";
$lang['title_custom_robots_description'] = 'Custom robots.txt content';
$lang['robots_before'] = 'Custom rules to insert before User-Agent:*';
$lang['robots_after'] = 'Custom rules to insert after CMSMS standard rules';

$lang['robots_sure_delete'] = 'Are you sure you want to replace the robots.txt in the root directory?';
$lang ['robots_old_file'] = 'Below is a copy of the existing robots.txt file';

$lang['install_database_error'] = "An error has occured during installation: The database table could not be created.";
$lang['no_url_fopen'] = "Not possible as allow_url_fopen has not been set to &quot;on&quot; in your php configuration.";
$lang['title_additional_meta_tags'] = "Additional Meta tags";
$lang['additional_meta_tags_title'] = "Additional Meta tags to be inserted";
$lang['additional_meta_tags_help'] = "Specify additional Meta tags here to be inserted into the page header. You can use all smarty variables and UDTs here.";


$lang['sitemap_title'] = 'Update SEOTools2';
$lang['sitemap_message'] = 'This page was previously marked inactive.  Please update the SEOTools2 settings.';
$lang['sitemap_add_index'] = 'Add this page to the sitemap.xml';
$lang['sitemap_add_follow'] = 'Allow robots to follow links';


$lang['help_showbase'] = "Set this parameter to <code>false</code> to suppress the output of the base href tag.";

$lang['changelog'] = <<<EOT
<ul>
<li>Version 1.0 - 25 January 2012. Initial release. This is a fork of the SEOTools module with CMSMS 1.10+ compatibility. Changes include:
	<ul>
		<li>Set preferences on install</li>
		<li>Remove preferences on uninstall</li>
		<li>Replace all reference to HierarchyManager objects with ContentOperations objects</li>
		<li>Generate all keywords, keyword suggestions, descriptions and default descriptions</li>
		<li>Generate sitemap.xml and robots.txt files</li>
		<li>Retain checkbox preference settings after submit</li>
		<li>On frontend page load, ensure that a corresponding record exists in the seotools2 database table</li>
	</ul>
</li>
<li>Version 1.0.1 - 25 January 2012. Minor bug fix</li>
<li>Version 1.0.2 - 1 February 2012. Bug fix</li>
<li>Version 1.0.3 - 1 February 2012. Bug fix</li>
<li>Version 1.0.4 - 1 February 2012. Correction</li>
<li>Version 1.0.5 - 6 February 2012. Add event handlers to push sitemap to Google webmasters</li>
<li>Version 1.0.6 - 5 March 2012. Improved handling of ssl urls and bug fix when there are no short meta descriptions</li>
<li>Version 1.0.7 - 9 April 2012. Bug fix</li>
<li>Version 1.0.8 - 9 April 2012. Bug fix</li>
<li>Version 1.0.9 - 11 April 2012.
    <ul>
        <li>More improvements to ssl handling especially in the sitemap.xml (thanks andriesinfoserv)</li>
        <li>Ability to show any Active page, not just pages with Active and Show In Menu in the sitemap.xml (thanks Matt)</li>
    </ul>
<li>Version 1.0.10 - 24 May 2012 - mostly improvements in the sitemap area, ie:
    <ul>
        <li>Allows sitemap indexing of internal and external URL links</li>
        <li>Filters out Error Page from sitemap.xml</li>
    </ul>
<li>Version 1.0.11 - 14 August 2012. CMSMS 1.11 compatibility (thanks leeroybrun and postiffm)</li>
<li>Version 1.1 - 8 September 2012. Better future-proofing for CMSMS 1.11 compatibility and a few more features
	<ul>
		<li>Option to include follow/nofollow as well as index/noindex to meta robots tag</li>
		<li>Jquery ajax support for Priority, Index and Follow toggling.</li>
		<li>Process smarty tags in the meta description and meta copyright fields</li>
		<li>Include meta viewport tag by default to the additional meta tags</li>
		<li>Keyword edit screen now shows a preview of the page content for quick reference, as well as links to edit or view the frontend version of the page.</li>
		<li>Restructured defaultadmin tab files to be a little more manageable.</li>
		<li>Outputs only HTML5 registered meta tags when HTML5 is specified. (Thanks uniqu3)</li>
		<li>Uses canonical URL when available. (Thanks infoandries)</li>
	</ul>
</li>
<li>Version 1.2 - 6 April 2013. Even more features including COMMA-SEPARATED KEYWORDS!
	<ul>
		<li>Outputs robots.txt file to the root directory regardless where CMSMS is installed.</li>
		<li>Ability to include custom rules before and after the standard CMSMS robots.txt rules.</li>
		<li>Assigning a module custom field to Smarty with the same var name as the SEOTools2 block name for the meta description in module detail pages eg News, Products, CGBlog etc, automatically replaces the page meta description without needing to edit the page template. (Thanks Chris).</li>
		<li>You can nominate a Smarty var that contains keywords from module custom field on a detail page eg News, Products, CGBlog etc, that will automatically replace the page keywords without needing to edit the page template.</li>
		<li>Automatically inserts &lt;base&gt; tag regardless whether specified as a parameter in the SEOTools2 tag. (Thanks uniqu3).</li>
		<li>When both {SEOTools2} and {metadata} tags exist in the page template, ensures only one &lt;base&gt; tag is output.</li>
		<li>Uses COMMA-SEPARATED keyword lists! Upgrade will convert existing space-separated lists. (Thanks to all who requested this feature).</li>
		<li>All SEOTools2 db functions occur in the admin section to help speed up frontend page load.</li>
		<li>Newly created pages automatically added to site map.</li>
		<li>Inactive pages changed to Active automatically reinstated in site map.</li>
		<li>Bug fix for og:image tag (Thanks Chris and swarfega)</li>
		<li>Bug fix in db query (Thanks Michael)</li>
	</ul>
</li>
<li>Version 1.2.1 - 19 April 2013. Bug fixes</li>
</ul>
EOT;

$lang['help'] = '<style>div.seo2 p, div.seo2 li, div.seo2 div {margin-bottom: 1.2em;}li{list-style-type:square}</style>
<div class="seo2">
<h3>What Does This Do?</h3>
<p>SEOTools2 helps you to get your SEO (Search Engine Optimization) right. The module adds several SEO capabilities to your CMSMS installation and alerts you if you missed out on something SEO related. Currently, the following features are supported:</p>
<ul>
<li> generates Meta tags in standard html, Dublin Core and OpenGraph formats</li>
<li> automatically extracts keywords from your pages and adds them to the meta tags and page title</li>
<li> lets you determine with a single click whether certain pages should be indexed by search engines or not</li>
<li> generates a sitemap.xml file with your pages while giving you full control over the priorities of your pages</li>
<li> generates a robots.txt file explicitly disallowing access to pages you don\'t want to be indexed</li>
<li> alerts you when there are several pages featuring the same page titles and descriptions</li>
<li> alerts you when very short page meta descriptions are detected</li>
<li> automatically submits your sitemap file to Google when you change your content</li>
</ul>
<h3>How Do I Use It</h3>
<p>First, open all templates where you want do use SEOTools2. Remove the complete &lt;title&gt; tag and replace it with the module tag. You may also wish to remove the {metadata} tag. Should you elect to leave it there, ensure that no meta tags are duplicated. Remove any duplicates from Site Admin - Global Settings - Global Metadata. </p>
<pre>
{SEOTools2}
</pre><br />

<p>If you left the {metadata} tag in the template, you can alternatively place the {SEOTools2} tag in the Global Meta textarea.</p>
<p>Next, at the bottom of your template (after the closing &lt;/body&gt; tag), insert the following code:</p>
<pre>
{content block="metadescription" label="Page Description" oneline="true" assign="metadescription"}
</pre><br />

<p>This is where you\'ll enter a short page description (one or two sentences) that will appear in the search engine\'s results and if, for example, someone shares a link to your page on facebook.</p>

<p>Now, visit the admin tabs for <em>Page Title & Meta Information</em>, the <em>Sitemap & Crawler Settings</em> and the <em>Keyword Generator Settings</em> and fill in all required information for your site. Under "Name of page description content block" you need to enter the name of the content block you just added to your templates ("metadescription" in our example).</p>
<p>The tab "SEO Alerts" will alert you if it detects anything that is required but not activated or filled in. You should also consider signing up your
site with Google Webmaster tools. There, select "Meta tag validation" and paste the verification code (quite a long string of characters and numbers) into the box "Verification Code" in "SEO Settings" to automatically verify that you are really
the owner of your page (no need to paste the Google Meta-code into your template).</p>
<p>As soon as everything is set up, look at the "SEO Alerts" tab and fix all problems detected here. Take care to insert a unique page description on every page.</p>
<p>Go to the <em>Page settings</em> tab where you\'ll find a list of all pages you have in your system. Here, you can:</p>
<ul>
<li>Set your own keywords (instead of the automatically generated ones) or OpenGraph type for certain pages</li>
<li>Adjust the sitemap priority (which is auto-calculated by default) of a page to indicate that it should
be considered more important for search engine matches on your page.</li>
<li>Prevent active pages from being listed in the Site Map</li>
<li>Specify whether robots should index or follow the page and links</li>
</ul>
<p>SEOTools2 will also automatically insert a link to the image to be used as the main image of your page if you select an "Image" for the page from within your page\'s "Options" tab (this is important for people submitting a link to your page e.g. on facebook). Also, if you are using OpenGraph, the image selected here
will override the default OpenGraph image you specified from within "SEO Settings". Please be aware that you need to upload those images to your /uploads/images directory.</p>
<h3>Can I use smarty variables?</h3>
<p>You can use all smarty variables and UDTs within the settings fields <i>Page title</i>, <i>Meta page title</i>, <i>Automatically generated descriptions</i>, <i>Meta copyright</i>, <i>Additional meta tags</i> and your custom page description block. Enter <code>{debug}</code> to see a list of all available variables.</p>
<h3>Which smarty variables are exported by SEOTools2?</h3>
<code>{$seo_keywords}</code>: A comma-separated list of all keywords set for the page (including the default keywords)<br />
<code>{$title_keywords}</code>: A space-separated list of all keywords set for the page (including the default keywords)<br />
<code>{$default_keywords}</code>: A space-separated list of all default keywords<br />
<code>{$page_keywords}</code>: A space-separated list of all keywords set for the page (without the default keywords)<br />
<p></p>
<h3>Acknowledgements</h3>
<p>Thank you to all the CMSMS developers who have contributed to this module with suggestions and bug-reports. Every little bit helps to make it better for all.</p>
<p>In particular, a HUGE thank you to uniqu3 for the above as well as beta testing and his words of encouragement when I felt like giving up.</p>
<h3>Support</h3>
<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>
<h3>Copyright and License</h3>
<p>Copyright &copy; 2013, Clip Magic <a href="mailto:admin@clipmagic.com.au">&lt;admin@clipmagic.com.au&gt;</a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>
</div>';
?>