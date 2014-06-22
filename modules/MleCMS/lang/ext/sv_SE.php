<?php
$lang['friendlyname'] = 'MLE CMS';
$lang['postinstall'] = 'Post Install Message, (e.g., Be sure to set &quot;manage mle_cms&quot; permissions to use this module!)';
$lang['postuninstall'] = 'MLE CMS installerat';
$lang['really_uninstall'] = '&Auml;r du s&auml;ker p&aring; att du vill radera denna modul?';
$lang['uninstalled'] = 'Modulen avinstallerad';
$lang['installed'] = 'Modul version %s installerad.';
$lang['upgraded'] = 'Modulen upgraderad till version %s.';
$lang['moddescription'] = 'Denna modul l&auml;gger till multispr&aring;k till ditt CMS Made Simple';
$lang['info_success'] = 'Lyckat';
$lang['optionsupdated'] = 'Alternativen uppdaterade';
$lang['module_missing'] = 'V&auml;nligen installera modulen %s';
$lang['error'] = 'Fel!';
$lang['admindescription'] = '';
$lang['accessdenied'] = '&Aring;tkomst nekad. V&auml;nligen kontrollera dina r&auml;ttigheter';
$lang['mle_config'] = 'Multilang inst&auml;llningar';
$lang['idtext'] = 'Id';
$lang['alias'] = 'Root-alias';
$lang['name'] = 'Namn';
$lang['custom'] = 'Anpassad';
$lang['locale_custom'] = 'Lokalt anpassad';
$lang['locale'] = 'Lokalt';
$lang['flag'] = 'Flagga';
$lang['manage_snippets'] = 'Koder';
$lang['unknown'] = 'Fel: Ok&auml;nd';
$lang['delete'] = 'Radera';
$lang['areyousure'] = '&Auml;r du s&auml;ker ?';
$lang['edit'] = 'Redigera';
$lang['add'] = 'L&auml;gg till';
$lang['source'] = 'K&auml;lla';
$lang['submit'] = 'Spara';
$lang['cancel'] = 'Avbryt';
$lang['apply'] = 'Verkst&auml;ll';
$lang['tag'] = 'Tagg';
$lang['manage_blocks'] = 'Block';
$lang['options'] = 'Alternativ';
$lang['mle_id'] = 'Mle identifier (for monolingual site use {$lang})';
$lang['mle_separator'] = 'Separator between langs (for {MleCMS action=&quot;langs&quot; template=&quot;Separator&quot;})';
$lang['mle_template'] = 'Multilang mall';
$lang['addedit_mle_template'] = 'L&auml;gg till/redigera multilang mall';
$lang['mle_hierarchy_switch'] = 'Hierarchy switch';
$lang['mle_search_restriction'] = 'S&ouml;k MLE begr&auml;nsning (endast f&ouml;r sids&ouml;kning)';
$lang['mle_auto_redirect'] = 'Spr&aring;kidentifiering';
$lang['none'] = 'Ingen';
$lang['root_redirect'] = 'Dirigera om i rotkatalogen';
$lang['hierarchy_redirect'] = 'Redirect on each level of hierarchy';
$lang['mle_translator'] = '&Ouml;vers&auml;ttare';
$lang['mle_translator_example'] = 'Put to your template: {translate text=&quot;anything&quot;}, return to the translator tab and edit it.';
$lang['help_name'] = 'kod eller blocknamn';
$lang['help_template'] = 'mall (standard flagga)';
$lang['changelog'] = '<ul>
<li>Version 1.4 - 1.7 - april 2011 - som small updates</li>
<li>Version 1.3 - january 2011 - new millestone - Mle Translator</li>
<li>Version 1.2 - january 2011 - new millestone - auto redirection</li>
<li>Version 1.1 - january 2011 - small update</li>
<li>Version 1 - january 2011 - Initial Release.</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This module add multilanguage solution to your CMS Made Simple.</p>
<h3>How Do I Use It</h3>
<p>Check installation guide <a href="http://cmsmadesimple.sk/modules/MleCMS/installation-guide.html">Installation Guide</a></p>
<h3>Plugins</h3>
<p><strong>Translate</strong> {translate text=&quot;some text&quot;} or {translator}some text{/translator} or {&quot;some text&quot;|translate}</p>
<p>Params</p>
<ul>
<li>text (required) - text for translate</li>
<li>assign (optional)  - smarty assign</li>
</ul>
<br />
<p><strong>Mle assign</strong> - (news example: {mle_assign object=$entry par=&quot;title&quot; assign=&quot;entry&quot;}) </p>
<p>Params</p>
<ul>
<li>from (required) - object for mle assign</li>
<li>par (required)  - par for find mutlilangue string (example: title and mle version  are  title_sk, title_de, title_fr)</li>
<li>assign (optional)  - assign to object</li>
</ul>
<br />
<p><strong>Mle search checker</strong> - (for modules search search restriction, plugin create sql query) </p>
<p>Example</p>
<code>
 {foreach from=$results item=entry}<br />
        {if $entry->module == &quot;MyModule&quot;}<br />
        {mle_search_checker select=&quot;filed&quot; from=&quot;module_mymodule&quot; id=$entry->modulerecord assign=&quot;language&quot;}                <br />
        {if !$lang_parent}{MleCMS action=&quot;get_root_alias&quot; assign=&quot;lang_parent&quot;}{/if}<br />
        {*display every record from my category *}<br />
        {if $language == $lang_parent}  <br />
        {$entry->title}<br />
        <a href="{$entry->url}&quot;>{$entry->urltxt}</a>&nbsp;<span>({$entry->weight}%)</span><br />
        {/if}<br />
        {/foreach}<br />
</code><br />
<p>Params</p>
<ul>
<li>select (required)  - SELECT select</li>
<li>from (required) - FROM table</li>
<li>assign (optional)  - assign to object</li>
</ul>
    <h3>Like it? Donate :)</h3>
    <p><form action=&quot;https://www.paypal.com/cgi-bin/webscr&quot; method=&quot;post&quot;>
<input type=&quot;hidden&quot; name=&quot;cmd&quot; value=&quot;_s-xclick&quot;>
<input type=&quot;hidden&quot; name=&quot;encrypted&quot; value=&quot;-----BEGIN PKCS7-----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-----END PKCS7-----
&quot;>
<input type=&quot;image&quot; src=&quot;https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif&quot; border=&quot;0&quot; name=&quot;submit&quot; alt=&quot;PayPal - The safer, easier way to pay online!&quot;>
<img alt=&quot;&quot; border=&quot;0&quot; src=&quot;https://www.paypal.com/en_US/i/scr/pixel.gif&quot; width=&quot;1&quot; height=&quot;1&quot;>
</form>
</p>
';
$lang['utma'] = '156861353.683385644.1310669373.1310669373.1310674882.2';
$lang['utmz'] = '156861353.1310669373.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
$lang['qca'] = 'P0-1529175659-1310081076901';
$lang['utmc'] = '156861353';
$lang['utmb'] = '156861353.1.10.1310674882';
?>