<?php
$lang['friendlyname'] = 'Gestion multi-langues';
$lang['postinstall'] = 'Module install&eacute;, (Note : pensez &agrave; ajouter la permission &quot;manage xxx_mle&quot; pour pouvoir utiliser ce module !)';
$lang['postuninstall'] = 'Le module Mle CMS  &eacute;t&eacute; d&eacute;sinstall&eacute;';
$lang['really_uninstall'] = 'R&eacute;ellement ? &Ecirc;tes-vous s&ucirc;r(e) ?
Vous voulez d&eacute;sinstaller ce module ?';
$lang['uninstalled'] = 'Module d&eacute;sinstall&eacute;.';
$lang['installed'] = 'Module version %s install&eacute;.';
$lang['upgraded'] = 'Le module a &eacute;t&eacute; mis &agrave; jour &agrave; la version %s.';
$lang['moddescription'] = 'Ce module apporte une solution multilangues pour votre CmsMadeSimple';
$lang['info_success'] = 'Succ&egrave;s';
$lang['optionsupdated'] = 'Options mises &agrave; jour';
$lang['module_missing'] = 'SVP, installer le module %s';
$lang['error'] = 'Erreur !';
$lang['admindescription'] = ' Le module MleCMS est une solution pour r&eacute;aliser un site web multilangues pour CMS Made Simple, sans modification du code du noyau du CMS';
$lang['accessdenied'] = 'Acc&egrave;s refus&eacute;. Veuillez v&eacute;rifier vos permissions.';
$lang['mle_config'] = 'Configuration multilangues';
$lang['idtext'] = 'ID&nbsp;';
$lang['alias'] = 'Alias racine&nbsp;';
$lang['name'] = 'Nom&nbsp;';
$lang['extra'] = 'Extra&nbsp;';
$lang['par_template'] = 'Param&egrave;tre de Smarty dans les gabarits&nbsp;';
$lang['custom'] = 'Personnalis&eacute; ';
$lang['locale_custom'] = 'Param&egrave;tre &quot;Locale&quot; personnalis&eacute;e pour CMSMS';
$lang['locale'] = 'Locale pour CMSMS&nbsp;';
$lang['setlocale'] = 'Activer les informations pour Locale (pour utilisateurs avanc&eacute;s)&nbsp;';
$lang['documentation'] = 'Documentation ';
$lang['example'] = 'Exemple&nbsp;';
$lang['flag'] = 'Drapeau&nbsp;';
$lang['manage_snippets'] = 'Snippets ';
$lang['unknown'] = 'Erreur : inconnue';
$lang['delete'] = 'Supprimer&nbsp;';
$lang['areyousure'] = '\u00CAtes-vous s\u00FBr(e) ?';
$lang['edit'] = 'Editer';
$lang['add'] = 'Ajouter';
$lang['source'] = 'Source ';
$lang['submit'] = 'Envoyer';
$lang['cancel'] = 'Annuler';
$lang['apply'] = 'Appliquer';
$lang['tag'] = 'Balise';
$lang['manage_blocks'] = 'Blocs';
$lang['options'] = 'Options ';
$lang['mle_template'] = 'Gabarit multilangues';
$lang['addedit_mle_template'] = 'Ajouter/Editer le gabrarit multilangues';
$lang['mle_hierarchy_switch'] = 'Basculer les langues dans chaque hi&eacute;rarchie&nbsp;';
$lang['mle_search_restriction'] = 'Restriction de la recherche MLE (uniquement pour la recherche dans les pages)&nbsp;';
$lang['mle_search_restriction_note'] = 'l&#039;URL de votre page doit commencer par le pr&eacute;fixe root_alias (exemple : si mod_rewrite URL=fr/ma-page ou si internal URL=index.php/fr/ma-page)';
$lang['mle_auto_redirect'] = 'D&eacute;tection de la langue&nbsp;';
$lang['none'] = 'Aucun';
$lang['root_redirect'] = 'Rediriger vers le r&eacute;pertoire racine  ';
$lang['hierarchy_redirect'] = 'Rediriger &agrave; chaque niveau de la hi&eacute;rarchie';
$lang['mle_translator'] = 'Traducteur';
$lang['mle_translator_example'] = 'Indiquer dans votre gabarit : {translate text=&quot;mon_mot&quot;}, puis retourner dans l&#039;onglet traducteur  et &eacute;diter le texte.';
$lang['help_name'] = 'Snippet ou nom du bloc';
$lang['help_template'] = 'gabarit (default Flags)';
$lang['help_excludeprefix'] = 'exclude prefix (pour action sur param&egrave;tre &quot;lang&quot;)';
$lang['help_includeprefix'] = 'include prefix (pour action sur param&egrave;tre &quot;lang&quot;)';
$lang['changelog'] = '<ul>
<li>Version 1.11.2 - july 2012 - fix auto language redirection</li>
<li>Version 1.11.1 - july 2012 - translator reworked (XML files bye bye - remplacer  par table siteprefs : MleCMS_mapi_pref_translations en base de donn&eacute;es)<br /> ATTENTION  module d&eacute;pendant : ExtendedTools V 1.3.1 minimum</li>
<li>Version 1.11 - july 2012 - CMSMS 1.11 support</li>
<li>Version 1.10.5 - nov 2011 - setlocale, extra param</li>
<li><strong>Version 1.10.3 -nov 2011</strong><br />- Add diretion param $lang_directionbr />
- Add extra param to lang<</li>
<li><strong>Version 1.10.0 - oct 2011</strong><br />- Bug #6991 - fix ajaxURL amp problem<br />
Action.translator.php - removed, moved to class. Translation.php- Ad translations do pack</li>
<li><strong>Version 1.10.0 - oct 2011</strong><br />- Add CMS 1.10 support. Remove action.translator.php, move to class</li>
<li><strong>Version 1.9.2 - juil 2011</strong><br />- Remove ContentCache dependence. Use rather cge_cache at CGExtension module.<br />- fix strict standards issues</li>
<li><strong>Version 1.9 - juil 2011</strong> <br />- Add translate modifier {&quot;test&quot;|translate}<br /> - Add plugin mle_search_checker<br />- Fix search restriction for internal URL<br />- Fix module compare version.</li>
<li><strong>Version 1.8 - april 2011</strong> <br />- New plugin Mle_assign<br />- New block plugin {translator}{/translator}<br />- minor changes </li> 
<li><strong>Version 1.4 - 1.7 </strong>- april 2011 - some small updates</li>
<li>Version 1.3 - january 2011 - new millestone - Mle Translator</li>
<li>Version 1.2 - january 2011 - new millestone - auto redirection</li>
<li>Version 1.1 - january 2011 - small update</li>
<li>Version 1 - january 2011 - Initial Release.</li>
</ul>';
$lang['help'] = '<div style=&quot;float:right&quot;>
 	 <h3>CMS Made Simple screencasts</h3>
 	    <p><a href="http://www.cmsmadesimple.sk/screencasts/?utm_source=modules&amp;amp;utm_medium=refferal&amp;amp;utm_campaign=screencasts24_4_2012">donate view all screencasts</a></p>
 	</div>
 	 
 	     <h3>Like it? Donate :)</h3>
    <form action=&quot;https://www.paypal.com/cgi-bin/webscr&quot; method=&quot;post&quot;>
<input type=&quot;hidden&quot; name=&quot;cmd&quot; value=&quot;_s-xclick&quot; />
<input type=&quot;hidden&quot; name=&quot;encrypted&quot; value=&quot;-----BEGIN PKCS7-----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-----END PKCS7-----
 	    &quot; />
 	    <input type=&quot;image&quot; src=&quot;https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif&quot;  name=&quot;submit&quot; alt=&quot;PayPal - The safer, easier way to pay online!&quot; />
 	    <img alt=&quot;&quot; src=&quot;https://www.paypal.com/en_US/i/scr/pixel.gif&quot; width=&quot;1&quot; height=&quot;1&quot; />
 	    </form>
 	    
 	 
 	<hr style=&quot;clear:both; display:block&quot; />

<h3>Que fait ce module ?</h3>
<p>Ce module ajoute une solution multilingue pour CMS Made Simple.</p>
<h3>Comment l&#039;utiliser ?</h3>
<p>V&eacute;rifier le <a href="http://cmsmadesimple.sk/modules/MleCMS/installation-guide.html"title="MleCMS - installation guide 1.1">guide d&#039;installation</a> ou <a target="_blank" href="http://blog.arvixe.com/creating-a-multilingual-cmsms-site-using-mlecms-module/" title="Creating a Multilingual CMSMS Site Using MleCMS Module par Goran Ilic" >Creating a Multilingual CMSMS Site Using MleCMS Module</a></p>
<p>ou <a target="_blank" href="http://wiki.cmsmadesimple.fr/wiki/MleCMS_(Module)" title="Wiki cmsmadesimple.fr">MleCMS (Module) sur le Wiki cmsmadesimple.fr</a></p>

<h3>Plugins</h3>
<p><strong>Translate</strong> {translate text=&quot;un_texte&quot;} or {translator}sun_texte{/translator}</p>
<p>Param&egrave;tres</p>
<ul>
<li>text (requis) - texte &agrave; traduire</li>
<li>assign (option)  - smarty assign</li>
</ul>
<br />
<p><strong>Mle assign</strong> - (news example: {mle_assign object=$entry par=&quot;title&quot; assign=&quot;entry&quot;}) </p>
<p>Param&egrave;tres</p>
<ul>
<li>object or array (requis) - object/array for mle assign</li>
<li>par (requis)  - pour trouver une cha&icirc;ne de multilingue (par exemple : les titres sont title_sk, title_de, title_fr, o&ugrave; le titre est une cha&icirc;ne par d&eacute;faut pour la langue par d&eacute;faut. Super solution MLE dans les gabarits)</li>
<li>assign (option)  - assign to object</li>
</ul>
<br />
<p><strong>Mle search checker</strong> - (for modules search search restriction, plugin create sql query) </p>
<p>Exemple</p>
<code>
{foreach from=$results item=entry}<br />
{if $entry->module == &quot;MyModule&quot;}<br />
{mle_search_checker select=&quot;filed&quot; from=&quot;module_mymodule&quot; id=$entry->modulerecord assign=&quot;language&quot;}<br />
{if !$lang_parent}{MleCMS action=&quot;get_root_alias&quot; assign=&quot;lang_parent&quot;}{/if}<br />
{*display every record from my category *}<br />
{if $language == $lang_parent}<br />
{$entry->title}<br />
<a href="{$entry->url}&quot;>{$entry->urltxt}</a>&nbsp;<span>({$entry->weight}%)</span><br />
{/if}<br />
{/foreach}<br />
</code><br />
<p>Param&egrave;tres</p>
<ul>
<li>select (requis)  - SELECT select</li>
<li>from (requis) - FROM table</li>
<li>assign (option)  - assign to object</li>
</ul>';
?>