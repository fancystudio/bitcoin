<?php
$lang['friendlyname'] = 'MLE CMS';
$lang['postinstall'] = 'Post Install Message, (e.g., Be sure to set &quot;manage mle_cms&quot; permissions to use this module!)';
$lang['postuninstall'] = 'MLE CMS wurde erfolgreich deinstalliert';
$lang['really_uninstall'] = 'Wollen Sie wirklich dieses wundervolle Modul deinstallieren?';
$lang['uninstalled'] = 'Modul deinstalliert.';
$lang['installed'] = 'Modulversion %s installiert.';
$lang['upgraded'] = 'Modul wurde auf Version %s aktualisiert.';
$lang['moddescription'] = 'Dieses Modul erm&ouml;glicht eine Multilanguage l&ouml;sung f&uuml;r CMS Made Simple';
$lang['info_success'] = 'Erfolgreich';
$lang['optionsupdated'] = 'Optionen aktualisiert';
$lang['module_missing'] = 'Bitte Modul %s installieren';
$lang['error'] = 'Fehler!';
$lang['admindescription'] = ' ';
$lang['accessdenied'] = 'Zugriff verweigert. Bitte pr&uuml;fen Sie Ihre Berechtigungen.';
$lang['mle_config'] = 'Multilanguage Konfiguration';
$lang['idtext'] = 'ID ';
$lang['alias'] = 'Stamm-Alias';
$lang['name'] = 'Name ';
$lang['extra'] = 'Extra ';
$lang['ltr'] = 'Links-nach-rechts Text oder Tabelle';
$lang['rtl'] = 'Rechts-nach-links Text oder Tabelle';
$lang['direction'] = 'Richtung';
$lang['par_template'] = 'Smarty Template-Parameter';
$lang['custom'] = 'Benutzerdefiniert';
$lang['locale_custom'] = 'Benutzerdefinierte Lokalisierung f&uuml;r CMSMS';
$lang['locale'] = 'Lokalisierung';
$lang['setlocale'] = 'Lokalisierungsinformation setzen (f&uuml;r fortgeschrittene Anwender)';
$lang['documentation'] = 'Dokumentation';
$lang['example'] = 'Beispiel';
$lang['flag'] = 'Flagge';
$lang['manage_snippets'] = 'Schnipsel';
$lang['unknown'] = 'Fehler: Unbekannt';
$lang['delete'] = 'L&ouml;schen';
$lang['areyousure'] = 'Sind Sie sicher?';
$lang['edit'] = 'Bearbeiten';
$lang['add'] = 'Hinzuf&uuml;gen';
$lang['source'] = 'Quelle';
$lang['submit'] = 'Absenden';
$lang['cancel'] = 'Abbrechen';
$lang['apply'] = 'Best&auml;tigen';
$lang['tag'] = 'Tag ';
$lang['manage_blocks'] = 'Bl&ouml;cke';
$lang['options'] = 'Optionen';
$lang['mle_id'] = 'MLE-Kennung';
$lang['mle_separator'] = 'Trenner';
$lang['translator_action_params'] = 'Voreingestellte Parameter f&uuml;r die translator-Aktion';
$lang['mle_template'] = 'Multilanguage-Template';
$lang['addedit_mle_template'] = 'Multilang-Template hinzuf&uuml;gen/bearbeiten';
$lang['mle_hierarchy_switch'] = 'Hierarchie-Schalter';
$lang['mle_search_restriction'] = 'MLE-Such-Beschr&auml;nkung (nur f&uuml;r die Seitensuche)';
$lang['mle_auto_redirect'] = 'Spracherkennung';
$lang['none'] = 'Keine';
$lang['root_redirect'] = 'Weiterleitung in das Stammverzeichnis';
$lang['hierarchy_redirect'] = 'Weiterleitung auf jede Ebene der Hierarchie';
$lang['for_template_separator'] = 'Wert f&uuml;r &quot;Separator&quot; Template';
$lang['mle_translator'] = '&Uuml;bersetzer';
$lang['mle_translator_example'] = 'F&uuml;gen Sie im Template {translate text=&quot;anything&quot;} ein, gehen dann zur&uuml;ck zur Registerkarte &quot;&Uuml;bersetzer&quot; und bearbeiten es.';
$lang['help_name'] = 'Schnipsel oder Blockname';
$lang['help_template'] = 'Template (voreingestellte Flaggen)';
$lang['help_excludeprefix'] = 'exclude-Pr&auml;fix (f&uuml;r die langs-Aktion) ';
$lang['help_includeprefix'] = 'include-Pr&auml;fix (f&uuml;r die langs-Aktion) ';
$lang['changelog'] = '<ul>
<li>Version 1.10.5 - november 2011 - setlocale, extra param</li>
<li>Version 1.4 - 1.7 - april 2011 - some small updates</li>
<li>Version 1.3 - january 2011 - new milestone - Mle Translator</li>
<li>Version 1.2 - january 2011 - new milestone - auto redirection</li>
<li>Version 1.1 - january 2011 - small update</li>
<li>Version 1 - january 2011 - Initial Release.</li>
</ul>';
$lang['help'] = '<h3>Was macht das Modul?</h3>
<p>Dieses Modul f&uuml;gt mehrsprachige L&ouml;sung f&uuml;r Ihr CMS Made Simple hinzu.</p>
<h3>Wie verwende ich es</h3>
<p>Sehen Sie in der <a href="../modules/MleCMS/installation-guide.html">Installationsanleitung</a> nach</p>
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
        &amp;lt;a href=&amp;quot;{$entry-&amp;gt;url}&amp;quot;&amp;gt;{$entry-&amp;gt;urltxt}&amp;lt;/a&amp;gt;&amp;amp;nbsp;&amp;lt;span&amp;gt;({$entry-&amp;gt;weight}%)&amp;lt;/span&amp;gt;<br />
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
</p>';
$lang['qca'] = 'P0-1458450664-1284573084918';
$lang['utma'] = '156861353.276278907.1342793520.1342793520.1342793520.1';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1342793520.1.1.utmcsr=forum.cmsmadesimple.org|utmccn=(referral)|utmcmd=referral|utmcct=/search.php';
$lang['utmb'] = '156861353.1.10.1342793520';
?>