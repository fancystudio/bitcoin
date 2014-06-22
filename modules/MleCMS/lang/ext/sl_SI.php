<?php
$lang['friendlyname'] = 'Mle CMS';
$lang['postinstall'] = 'Sporočilo po nastavitvi (npr. nastavite &quot;manage_mle_cms&quot; pravice za uporabo tega modula!)';
$lang['postuninstall'] = 'Mle CMS modul je bil uspe&scaron;no name&scaron;čen';
$lang['really_uninstall'] = 'Ste prepričani, da želite odstraniti ta modul?';
$lang['uninstalled'] = 'Modul je bil odstranjen.';
$lang['installed'] = 'Modul različice %s je bil name&scaron;čen.';
$lang['upgraded'] = 'Modul nadgrajen na različico %s.';
$lang['moddescription'] = 'Modul doda re&scaron;itve za večjezične spletne strani na CMS Made Simple';
$lang['info_success'] = 'Uspe&scaron;no';
$lang['optionsupdated'] = 'Možnosti shranjene';
$lang['module_missing'] = 'Prosimo, namestite modul %s';
$lang['error'] = 'Napaka!';
$lang['admindescription'] = '';
$lang['accessdenied'] = 'Dostop zavrnjen. Prosimo, preverite va&scaron;e pravice.';
$lang['mle_config'] = 'Nastavitve večjezičnosti';
$lang['idtext'] = 'ID';
$lang['alias'] = 'Vrhnji alias';
$lang['name'] = 'Naziv';
$lang['extra'] = 'Dodatno';
$lang['ltr'] = 'Besedilo z leve proti desni';
$lang['rtl'] = 'Besedilo z desne proti levi';
$lang['direction'] = 'Smer pisave';
$lang['custom'] = 'Prilagojeno';
$lang['locale_custom'] = 'Prilagojen locale za CMSMS';
$lang['locale'] = 'Locale za CMSMS';
$lang['setlocale'] = 'Nastavitev informacij o locale (za napredne uporabnike)';
$lang['documentation'] = 'Dokumentacija';
$lang['example'] = 'Primer';
$lang['flag'] = 'Zastavica';
$lang['manage_snippets'] = 'Odlomki kode';
$lang['unknown'] = 'Napaka: neznano';
$lang['delete'] = 'Izbri&scaron;i';
$lang['areyousure'] = 'Ste prepričani?';
$lang['edit'] = 'Uredi';
$lang['add'] = 'Dodaj';
$lang['source'] = 'Izvor';
$lang['submit'] = 'Po&scaron;lji';
$lang['cancel'] = 'Prekliči';
$lang['apply'] = 'Uporabi';
$lang['tag'] = 'Oznaka';
$lang['manage_blocks'] = 'Bloki';
$lang['options'] = 'Možnosti';
$lang['mle_id'] = 'MLE identifikator (za enojezične strani uporabite {$lang})';
$lang['mle_separator'] = 'Razdelilec med jeziki (za {MleCMS action=&quot;langs&quot; template=&quot;Separator&quot;})';
$lang['translator_action_params'] = 'Privzeti parametri za akcijo prevajalca';
$lang['mle_template'] = 'Večjezična predloga';
$lang['addedit_mle_template'] = 'Dodaj/Uredi večjezično predlogo';
$lang['mle_hierarchy_switch'] = 'Preklop v hierarhiji';
$lang['mle_search_restriction'] = 'Jezikovna omejitev pri iskanju (samo za iskanje po strani)';
$lang['mle_search_restriction_note'] = 'Va&scaron;a stran se mora začeti z with root_alias predpono (npr.: mod_rewrite (en/my-page) ali index.php/en/my-page)';
$lang['mle_auto_redirect'] = 'Zaznava jezika';
$lang['none'] = 'Nobena';
$lang['root_redirect'] = 'Preusmeritev na vrhnji strani';
$lang['hierarchy_redirect'] = 'Preusmeritev v vseh nivojih';
$lang['mle_translator'] = 'Prevajalec';
$lang['mle_translator_example'] = 'V va&scaron;o predlogo vstavite {translate text=&quot;besedilo&quot;}, se vrnite v prevajalca in prevedite besede.';
$lang['help_name'] = 'Odlomek kode ali naziv bloka';
$lang['help_template'] = 'predloga (privzete zastavice)';
$lang['help_excludeprefix'] = 'izključi predpono (za akcijo zastavic) ';
$lang['help_includeprefix'] = 'vključi predpono (za akcijo zastavic) ';
$lang['changelog'] = '<ul>
<li>Version 1.10.5 - november 2011 - setlocale, extra param</li>
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
<p>or</p>
<p><a target="_blank" href="http://blog.arvixe.com/creating-a-multilingual-cmsms-site-using-mlecms-module/">Creating a Multilingual CMSMS Site Using MleCMS Module</a></p>
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
<li>object or array (required) - object/array for mle assign</li>
<li>par (required)  - par for find mutlilangue string (example: title and mle version  are  title_sk, title_de, title_fr, where title is default string for default language. Great MLE solution in templates!!)</li>
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
$lang['utma'] = '156861353.750868367.1327478160.1327478160.1328102628.2';
$lang['utmz'] = '156861353.1327478160.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>