<?php
$lang['import_deleteduser'] = 'Benutzer %s gel&ouml;scht';
$lang['error_export_nousers'] = 'Keine Benutzer zum Exportieren gefunden';
$lang['prompt_export_users'] = 'Benutzer exportieren';
$lang['title_export_users'] = 'Benutzer in ASCII-Datei exportieren';
$lang['error_importgroupname'] = 'Ung&uuml;ltiger oder leerer Gruppenname angegeben';
$lang['prompt_delimiter'] = 'Trenner';
$lang['prompt_delete_users'] = 'Extra-Benutzer l&ouml;schen';
$lang['title_import_users'] = 'Benutzer aus CSV-Datei importieren';
$lang['frontend_access'] = 'Betrachter';
$lang['sortby_username_asc'] = 'Benutzername (aufsteigend)';
$lang['sortby_username_desc'] = 'Benutzername (absteigend)';
$lang['sortby_create_asc'] = 'Erstellungsdatum (aufsteigend)';
$lang['sortby_create_desc'] = 'Erstellungsdatum (absteigend)';
$lang['sortby_expires_asc'] = 'Ablaufdatum (aufsteigend)';
$lang['sortby_expires_desc'] = 'Ablaufdatum (absteigend)';
$lang['encrypted'] = 'Verschl&uuml;sselt';
$lang['move_up'] = 'nach oben bewegen';
$lang['move_down'] = 'nach unten bewegen';
$lang['title_propmodule'] = 'Diese Eigenschaft wird durch das Modul erstellt und kann nicht bearbeitet werden';
$lang['not_available'] = 'Nicht verf&uuml;gbar';
$lang['prompt_dflt_checked'] = 'Standardm&auml;&szlig;ig sollte dieses Feld markiert sein';
$lang['operation_completed'] = 'Vorgang abgeschlossen';
$lang['members'] = 'Mitglieder';
$lang['view_filter'] = 'Ansichtsfilter';
$lang['data'] = 'Daten';
$lang['applied'] = '&Uuml;bernomen';
$lang['firstpage'] = '&laquo;';
$lang['prevpage'] = '&lsaquo;';
$lang['nextpage'] = '&rsaquo;';
$lang['lastpage'] = '&raquo;';
$lang['page'] = 'Seite';
$lang['prompt_allow_changeusername'] = '&Auml;nderung des Benutzernamens erlauben';
$lang['info_allow_changeusername'] = 'Wenn aktiviert, werden Benutzer die M&ouml;glichkeit haben, den Benutzernamen zusammen mit anderen Einstellungen zu &auml;ndern';
$lang['template_saved'] = 'Vorlage gespeichert';
$lang['template_resetdefaults'] = 'Vorlage zur&uuml;cksetzen';
$lang['lbl_settings'] = 'Einstellungen';
$lang['lbl_templates'] = 'Vorlagen';
$lang['enable_captcha'] = 'Captcha beim Login-Formular aktivieren';
$lang['info_enable_captcha'] = 'Wenn der Benutzer nicht angemeldet ist, und die Moduleinstellung besagt, das Login-Formular anzuzeigen, steuert diese Option ob ein Abfrage des Captcha-Sicherheitscode auf dem Login-Bildschirm angezeigt wird, wenn ein Captcha-Modul installiert ist.';
$lang['pagetype_unauthorized'] = 'Sie sind nicht autorisiert, diesen Inhalt zu sehen';
$lang['info_contentpage_grouplist'] = 'Geben Sie eine Liste der FEU-Gruppen an, die Zugang zu dieser Seite haben darf. Keine Auswahl erlaubt jedem angemeldeten FEU-Benutzer, die Seite zu sehen.';
$lang['pagetype_settings'] = 'Einstellungen f&uuml;r die gesch&uuml;tzte Seite';
$lang['pagetype_groups'] = 'Erlaubte Gruppen';
$lang['info_pagetype_groups'] = 'Select the groups that are (by default) allowed to view protected pages.  An editor with the &quot;Manage All Content&quot; permission can override this for each page';
$lang['pagetype_action'] = 'Aktion f&uuml;r unberechtigte Zugriffe';
$lang['info_pagetype_action'] = 'Specify the behavior for people accessing this page without sufficient permission.  You can either redirect to a specified page, or display the login form';
$lang['showloginform'] = 'Das Anmeldeformular anzeigen';
$lang['redirect'] = 'Auf eine Seite weiterleiten';
$lang['pagetype_redirectto'] = 'Weiterleiten auf';
$lang['info_pagetype_redirectto'] = 'Specify the page to redirect to.  If you select none, and the action is set to &quot;redirect&quot; the user will be presented with a message indicating that they do not hace access to the page';
$lang['permissions'] = 'Berechtigungen';
$lang['feu_protected_page'] = 'Gesch&uuml;tzter Inhalt';
$lang['prompt_viewprops'] = 'W&auml;hlen Sie Zus&auml;tzliche Eigenschaften f&uuml;r Ansicht';
$lang['view'] = 'Ansicht';
$lang['info_ignore_userid'] = 'If checked the import routine will attempt to add users independant of the userid column.  If a user with the name specified in the import file already exists, an error will be generated';
$lang['ignore_userid'] = 'Ignoriere UserID-Spalte beim Importieren';
$lang['export_passhash'] = 'Exportiere die Kennwort-hash in die Datei';
$lang['info_export_passhash'] = 'The password hash is only useful if the password salt on the import host is identical to that of the export host';
$lang['error_adjustsalt'] = 'Password-Salt kann nicht eingestellt werden';
$lang['prompt_pwsalt'] = 'Password-Salt';
$lang['info_pwsalt'] = 'FrontEndUsers salts all passwords with this key which is created upon install.  Once users have been added to the database the salt cannot be changed. The salt may be empty for older installs.';
$lang['advanced_settings'] = 'Weitere Einstellungen';
$lang['info_sessiontimeout'] = 'Geben Sier hier die Anzahl von Sekunden an, nach deren Ablauf inaktive Benutzer automatisch von der Webseite abgemeldet werden';
$lang['prompt_expireusers_interval'] = 'Benutzerablauf-Intervall';
$lang['info_expireusers_interval'] = 'Specify a value (in seconds) that indicates how often the system should force users whos session has expired to be logged out.  T&quot;his is an optimization to save database queries.  If left empty or set to 0 expiry will be performed on every request.';
$lang['msg_settingschanged'] = 'Ihre Einstellungen wurden aktualisiert';
$lang['forcedlogouttask_desc'] = 'Benutzer in regelm&auml;&szlig;igen Zeitabst&auml;nden abmelden';
$lang['prompt_forcelogout_times'] = 'Zeiten, zu denen der Benutzer automatisch abgemeldet wird';
$lang['info_forcelogout_times'] = 'Geben Sie hier eine durch Kommata getrennte Liste von Zeiten wie zum Beispiel HH:MM,HH:MM an, in denen die Benutzer automatisch abgemeldet werden. Hinweis: Note, this uses the psuedocron mechanism so you must be sure that the times entered here will coincide reasonably with your &quot;pseudocron granularity&quot; and that sufficient requests will occur to your website to ensure that pseudocron is executed.';
$lang['prompt_forcelogout_sessionage'] = 'Benutzer ausschlie&szlig;en, die aktiv waren in <em>(Minuten)</em>';
$lang['info_forcelogout_sessionage'] = 'Wird dieser Wert angegeben, wird jeder Benutzer, der in diesem Zeitraum aktiv war, nicht automatisch abgemeldet';
$lang['areyousure_delete'] = 'Wollen Sie wirklich den Benutzer %s l&ouml;schen';
$lang['error_invalidfileextension'] = 'Die hochgeladene Datei entspricht nicht der erlaubten Dateitypen';
$lang['postuninstall'] = 'Alle dem FrontEndUsers-Modul zugeordneten Daten wurden gel&ouml;scht';
$lang['info_ecomm_paidregistration'] = 'Wird dies aktiviert, wird das Modul auf Ereignisse achten, die durch die Ecommerce Suite ausgel&ouml;st werden. Die folgenden Einstellungen haben nur dann eine Auswirkung, wenn diese Einstellung aktiviert wird.';
$lang['prompt_ecomm_paidregistration'] = 'Auf Bestellungen achten';
$lang['info_paidreg_settings'] = 'Die folgenden Einstellungen werden nur dann angewendet, wenn sich Benutzer selbst registrieren k&ouml;nnen und bezahlte Registrierungen erlaubt sind.';
$lang['none'] = 'Kein(er)';
$lang['delete_user'] = 'Benutzer l&ouml;schen';
$lang['expire_user'] = 'Abgelaufene Benutzer';
$lang['prompt_action_ordercancelled'] = 'Aktion, die ausgef&uuml;hrt wird, wenn die Bestellung eines Abonnements abgebrochen wird';
$lang['prompt_action_orderdeleted'] = 'Aktion, die ausgef&uuml;hrt wird, wenn die Bestellung eines Abonnements gel&ouml;scht wird';
$lang['ecommerce_settings'] = 'eCommerce-Einstellungen';
$lang['securefieldmarker'] = 'Kennzeichnung f&uuml;r sichere Felder';
$lang['securefieldcolor'] = 'Farbe f&uuml;r sichere Felder';
$lang['prompt_encrypt'] = 'Diese Daten in der Datenbank verschl&uuml;sselt speichern';
$lang['error_notsupported'] = 'Die gew&auml;hlte Option wird von Ihrer aktuellen Konfiguration nicht unterst&uuml;tzt';
$lang['audit_user_created'] = 'Benutzer wurde automatisch erstellt';
$lang['info_auto_create_unknown'] = 'Soll f&uuml;r einen Benutzer, der &uuml;ber ein externes Authentifizierungs-Modul angemeldet wurde, aber dem FrontEndUsers-Modul nicht bekannt ist, automatisch ein FEU-Konto erstellt werden?';
$lang['prompt_auto_create_unknown'] = 'Automatisch unbekannten Benutzer erstellen';
$lang['display_settings'] = 'Anzeige-Einstellungen';
$lang['info_std_auth_settings'] = 'Die folgenden Einstellungen werden nur verwendet, wenn Sie die &quot;Interne Authentifizierung&quot; verwenden.';
$lang['info_support_lostun'] = 'Die Einstellung &quot;Nein&quot; deaktiviert die M&ouml;glichkeit f&uuml;r die Benutzer, ein Anfrage nach Zusendung der Anmeldedaten zu stellen (unabh&auml;ngig von anderen Einstellungen)';
$lang['info_support_lostpw'] = 'Die Einstellung &quot;Nein&quot; deaktiviert die M&ouml;glichkeit f&uuml;r die Benutzer, ein Zur&uuml;cksetzen des Passworts anzufordern (unabh&auml;ngig von anderen Einstellungen)';
$lang['prompt_support_lostun'] = 'Benutzern eine Anfrage nach Ihren Benutzernamen erlauben';
$lang['prompt_support_lostpw'] = 'Benutzern eine Anfrage zur &Auml;nderungen des Passworts erlauben';
$lang['auth_settings'] = 'Authentifizierungseinstellungen';
$lang['authentication'] = 'Interne Authentifizierung';
$lang['auth_builtin'] = 'FEU-Standard-Authentifizierung';
$lang['auth_module'] = 'Authentifizierungs-Modul/Methode';
$lang['info_auth_module'] = 'Das FrontendUsers-Modul unterst&uuml;tzt die Anmeldung &uuml;ber alternative Authentifizierungs-Methoden, mit unterschiedlichen M&ouml;glichkeiten. Jedoch stehen dann einige Funktionen nicht zur Verf&uuml;gung oder werden deaktiviert, wenn nicht die eingebaute Authentifizierungs-Methode verwendet wird';
$lang['error_user_nonunique_field_value'] = 'Der f&uuml;r %s festgelegte Wert wird bereits von einem anderen Benutzer verwendet';
$lang['unique'] = 'Eindeutig';
$lang['error_nonunique_field_value'] = 'Der f&uuml;r %s festgelegte Wert (%s) ist nicht eindeutig';
$lang['prompt_force_unique'] = 'Werte f&uuml;r diese Eigenschaft sollen in allen Benutzerkonten eindeutig sein';
$lang['help_returnlast'] = 'Wird mit An- und Abmelde-Formularen verwendet. Mit diesem Parameter kann festgelegt werden, dass der Webseitenbesucher nach der Anmeldung auf die Seite (URL) weitergeleitet werden, die sie vor dieser Aktion angesehen haben. Dieser Parameter &uuml;berschreibt s&auml;mliche Weiterleitungseinstellungen und -Parameter.';
$lang['help_noinline'] = 'Wird mit einem der Formulare verwendet. Dieser Parameter legt fest, ob die Formulare inline angezeigt werden sollen, anstatt dass die Ergebnisausgabe nach &Uuml;bermittlung des Formulars den Standard-Inhaltsblock ersetzt.';
$lang['title_reset_session'] = 'Warnung vor dem Ablauf der Anmelde-Session';
$lang['msg_reset_session'] = 'Die Zeit f&uuml;r Ihre aktuelle Anmeldung auf dieser Webseite ist abgelaufen. Bitte klicken Sie auf &bdquo;OK&ldquo;, um zu best&auml;tigen, dass Sie noch auf dieser Webseite aktiv sind.';
$lang['ok'] = 'OK';
$lang['resetsession_template'] = 'Session-Template zur&uuml;cksetzen';
$lang['info_name'] = 'Dies ist der Feldname, der in Smarty f&uuml;r die Adressierung verwendet wird. Er darf nur alphanumerische Zeichen und Unterstriche (_) enthalten.';
$lang['visitors_tab'] = 'Besucher';
$lang['feu_groups_prompt'] = 'W&auml;hlen sie eine oder mehrere FEU-Benutzergruppen, denen es erlaubt ist, diese Seite anzusehen';
$lang['error_mustselect_group'] = 'Es muss eine Gruppe ausgew&auml;hlt werden';
$lang['selectone'] = 'Ihre Auswahl';
$lang['start_year'] = 'Startjahr';
$lang['end_year'] = 'Endjahr';
$lang['date'] = 'Datum';
$lang['prompt_thumbnail_size'] = 'Gr&ouml;&szlig;e des Vorschaubild';
$lang['OnUpdateGroup'] = 'Ausf&uuml;hren, wenn die Benutzergruppe ge&auml;ndert wurde';
$lang['error_toomanyselected'] = 'F&uuml;r diese Aktion wurden zu viele Benutzer ausgew&auml;hlt. Bitte beschr&auml;nken Sie sich auf 250 (oder weniger).';
$lang['confirm_delete_selected'] = 'Wollen Sie wirklich die ausgew&auml;hlten Benutzer l&ouml;schen?';
$lang['delete_selected'] = 'Ausgew&auml;hlte Benutzer l&ouml;schen';
$lang['prompt_randomusername'] = 'Einen zuf&auml;lligen Benutzernamen erzeugen, wenn ein neuer Benutzer hinzugef&uuml;gt wird';
$lang['months'] = 'Monate';
$lang['prompt_expireage'] = 'Voreingestellte Zeit bis zum Verfall des Benutzerkontos';
$lang['notification_settings'] = 'Benachrichtigungs-Einstellungen';
$lang['property_settings'] = 'Eigenschafts-Einstellungen';
$lang['redirection_settings'] = 'Weiterleitungs-Einstellungen';
$lang['general_settings'] = 'Allgemeine Einstellungen';
$lang['session_settings'] = 'Einstellungen f&uuml;r Sessions und Cookies';
$lang['field_settings'] = 'Feld-Einstellungen';
$lang['error_lostun_nonrequired'] = 'Die Kennzeichnung f&uuml;r vergessene Benutzernamen kann nur bei Pflichtfeldern verwendet werden.';
$lang['prop_textarea_wysiwyg'] = 'In diesem Textbereich die Verwendung eines WYSIWYG-Editors erlauben';
$lang['editing_user'] = 'Benutzer-Bearbeitung';
$lang['noinline'] = 'Keine Inline-Formulare verwenden';
$lang['info_lostun'] = 'Klicken Sie hier, wenn Sie sich nicht mehr an die Details Ihrer Anmeldung erinnern k&ouml;nnen';
$lang['info_forgotpw'] = 'Klicken Sie hier, wenn Sie sich nicht mehr an Ihr Passwort erinnern k&ouml;nnen';
$lang['info_logout'] = 'Zum Abmelden hier klicken';
$lang['info_changesettings'] = 'Klicken Sie hier, um Ihr Passwort oder andere Informationen zu &auml;ndern.';
$lang['viewuser_template'] = 'Template f&uuml;r die Benutzer-Anzeige';
$lang['event'] = 'Ereignis';
$lang['feu_event_notification'] = 'FEU-Ereignis-Benachrichtigungen';
$lang['prompt_notification_address'] = 'E-Mail-Adresse f&uuml;r Benachrichtigungen';
$lang['prompt_notification_template'] = 'Template f&uuml;r E-Mail-Benachrichtigungen';
$lang['prompt_notification_subject'] = 'Betreff der E.Mail-Benachrichtigung';
$lang['prompt_notifications'] = 'E-Mail-Benachrichtigungen';
$lang['OnLogin'] = 'Ausf&uuml;hren, wenn sich ein Benutzer anmeldet';
$lang['OnLogout'] = 'Ausf&uuml;hren, wenn sich ein Benutzer abmeldet';
$lang['OnExpireUser'] = 'Ausf&uuml;hren, wenn eine Benutzer-Session abl&auml;uft';
$lang['OnCreateUser'] = 'Ausf&uuml;hren, wenn ein Benutzerkonto neu erstellt wurde';
$lang['OnDeleteUser'] = 'Ausf&uuml;hren, wenn ein Benutzerkonto gel&ouml;scht wurde';
$lang['OnUpdateUser'] = 'Ausf&uuml;hren, wenn Benutzerdaten aktualisiert wurden';
$lang['OnCreateGroup'] = 'Ausf&uuml;hren, wenn eine Benutzergruppe neu erstellt wurde';
$lang['OnDeleteGroup'] = 'Ausf&uuml;hren, wenn eine Benutzergruppe gel&ouml;scht wurde';
$lang['lostunconfirm_premsg'] = 'Die Daten zum Auffinden verlorener Passw&ouml;rter wurden vollst&auml;ndig eingegeben. Wir haben einen Benutzernamen gefunden, der den von Ihnen eingegebenen Details entspricht.';
$lang['your_username_is'] = 'Ihr Benutzername ist';
$lang['lostunconfirm_postmsg'] = 'Wir empfehlen Ihnen, diese Information an sicherer Stelle aufzubewahren.';
$lang['prompt_after_change_settings'] = 'Seiten-ID/-Alias der Seite, auf die nach dem &Auml;ndern der Einstellungen gesprungen werden soll';
$lang['prompt_after_verify_code'] = 'Seiten-ID/-Alias der Seite, auf die nach der Code-Pr&uuml;fung gesprungen werden soll *';
$lang['lostun_details_template'] = 'Details-Template bei vergessenem Benutzernamen';
$lang['lostun_confirm_template'] = 'Best&auml;tigungs-Template bei vergessenem Benutzernamen';
$lang['error_nonuniquematch'] = 'FEHLER: Mehr als ein Benutzer-Konto entspricht den gesuchten Eigenschaften';
$lang['error_cantfinduser'] = 'FEHLER: Konnte den gesuchten Benutzer nicht finden';
$lang['error_groupnotfound'] = 'FEHLER: Konnte keine Gruppe mit diesem Namen finden';
$lang['readonly'] = 'Nur lesen';
$lang['prompt_usermanipulator'] = 'Klasse zur Bearbeitung von Benutzern';
$lang['admin_logout'] = 'Durch den Administrator abgemeldet';
$lang['prompt_loggedinonly'] = 'Nur die angemeldeten Benutzer anzeigen';
$lang['prompt_logout'] = 'Diesen Benutzer abmelden';
$lang['user_properties'] = 'Benutzer-Eigenschaften';
$lang['userhistory'] = 'Benutzer-Geschichte';
$lang['export'] = 'Exportieren';
$lang['clear'] = 'L&ouml;schen';
$lang['prompt_exportuserhistory'] = 'Benutzergeschichte in eine ASCII-Datei exportieren';
$lang['prompt_clearuserhistory'] = 'Datens&auml;tze der Benutzergeschichte l&ouml;schen, die mindestens';
$lang['title_lostusername'] = 'Haben Sie Ihre Zugangsdaten vergessen?';
$lang['title_rssexport'] = 'Gruppen-Definition (und Eigenschaften) als XML-Datei exportieren';
$lang['title_userhistorymaintenance'] = 'Verwaltung der Benutzergeschichten';
$lang['yes'] = 'Ja';
$lang['no'] = 'Nein';
$lang['prompt_of'] = 'von';
$lang['date_allrecords'] = '** Keine Beschr&auml;nkung **';
$lang['date_onehourold'] = 'Eine Stunde alt';
$lang['date_sixhourold'] = 'Sechs Stunden alt';
$lang['date_twelvehourold'] = 'Zw&ouml;lf Stunden alt';
$lang['date_onedayold'] = 'Einen Tag alt';
$lang['date_oneweekold'] = 'Eine Woche alt';
$lang['date_twoweeksold'] = 'Zwei Wochen alt';
$lang['date_onemonthold'] = 'Einen Monat alt';
$lang['date_threemonthsold'] = 'Drei Monate alt';
$lang['date_sixmonthsold'] = 'Sechs Monate alt';
$lang['date_oneyearold'] = 'Ein Jahr alt';
$lang['title_groupsort'] = 'Gruppierung und Sortierung';
$lang['prompt_recordsfound'] = 'Mit den vorgegebenen Kriterien &uuml;bereinstimmende Datens&auml;tze';
$lang['sortorder_username_desc'] = 'Nach Benutzernamen absteigend';
$lang['sortorder_username_asc'] = 'Nach Benutzernamen aufsteigend';
$lang['sortorder_date_desc'] = 'Nach Datum absteigend';
$lang['sortorder_date_asc'] = 'Nach Datum aufsteigend';
$lang['sortorder_action_desc'] = 'Nach Ereignistyp absteigend';
$lang['sortorder_action_asc'] = 'Nach Ereignistyp aufsteigend';
$lang['sortorder_ipaddress_desc'] = 'Nach IP-Adresse absteigend';
$lang['sortorder_ipaddress_asc'] = 'Nach IP-Adresse aufsteigend';
$lang['info_nohistorydetected'] = 'Keine Geschichte vorhanden';
$lang['reset'] = 'Zur&uuml;cksetzen';
$lang['prompt_group_ip'] = 'Gruppen nach IP-Adresse';
$lang['prompt_filter_eventtype'] = 'Ereignistypen-Filter';
$lang['prompt_filter_date'] = 'Zeigt nur Ereignisse an, die geringer sind als:';
$lang['prompt_pagelimit'] = 'Seitenlimit';
$lang['for'] = 'f&uuml;r';
$lang['title_userhistory'] = 'Bericht zur Benutzergeschichte';
$lang['unknown'] = 'Unbekannt';
$lang['prompt_ipaddress'] = 'IP-Adresse';
$lang['prompt_eventtype'] = 'Ereignis-Typ';
$lang['prompt_date'] = 'Datum';
$lang['prompt_return'] = 'Zur&uuml;ck';
$lang['import_complete_msg'] = 'Datenimport komplett';
$lang['prompt_linesprocessed'] = 'Zeilen verarbeitet';
$lang['prompt_errors'] = 'Fehler aufgetreten';
$lang['prompt_recordsadded'] = 'Datens&auml;tze hinzugef&uuml;gt';
$lang['error_nogroupproprelns'] = 'Keine Eigenschaften f&uuml;r die Gruppe %s gefunden';
$lang['error_noresponsefromserver'] = 'Keine Antwort vom SMTP-Server erhalten';
$lang['error_importfilenotfound'] = 'Die Datei (%s) konnte nicht gefunden werden';
$lang['error_importfieldvalue'] = 'Ung&uuml;ltiger Wert f&uuml;r das Listenfeld oder das Feld zur Mehrfachauswahl %s';
$lang['error_importfieldlength'] = 'Das Feld %s &uuml;berschreitet die maximal m&ouml;gliche L&auml;nge';
$lang['error_importusers'] = 'Import-Fehler (Zeile %s): %s';
$lang['error_propertydefns'] = 'Konnte die Eigenschaftsdefinition nicht abrufen (interner Fehler)';
$lang['error_problemsettinginfo'] = 'Problem beim Setzen der Benutzerinformation';
$lang['error_importrequiredfield'] = 'Konnte keine Spalte finden, die mit dem erforderlichen Feld %s &uuml;bereinstimmt';
$lang['error_nogroupproperties'] = 'Konnte f&uuml;r die festgelegte Gruppe keine Eigenschaften finden';
$lang['error_importfileformat'] = 'Die zu importierenden Datei hat das falsche Format';
$lang['error_couldnotopenfile'] = 'Konnte die Datei nicht &ouml;ffnen';
$lang['prompt_importdestgroup'] = 'Benutzer in diese Gruppe importieren';
$lang['prompt_importfilename'] = 'CSV-Datei ausw&auml;hlen';
$lang['prompt_importxmlfile'] = 'XML-Datei ausw&auml;hlen';
$lang['prompt_exportusers'] = 'Benutzer exportieren';
$lang['prompt_importusers'] = 'Benutzer importieren';
$lang['prompt_clear'] = 'L&ouml;schen';
$lang['prompt_image_destination_path'] = 'Zielpfad f&uuml;r das Bild';
$lang['error_missing_upload'] = 'Es ist ein Problem mit einer fehlenden, aber erforderlichen (hochzuladenden) Datei aufgetreten';
$lang['error_bad_xml'] = 'Konnte die angegebene XML-Datei nicht verarbeiten';
$lang['error_notemptygroup'] = 'Die Gruppe konnte nicht gel&ouml;scht werden, da sie noch Benutzer enth&auml;lt.';
$lang['error_norepeatedlogins'] = 'Dieser Benutzer ist bereits angemeldet';
$lang['error_captchamismatch'] = 'Der Text aus dem Bild wurde nicht richtig eingegeben';
$lang['prompt_allow_repeated_logins'] = 'Den Benutzern erlauben, sich mehr als einmal anzumelden';
$lang['prompt_allowed_image_extensions'] = 'Namenserweiterungen f&uuml;r Bilder, die der Benutzer hochladen darf';
$lang['event_help_OnRefreshUser'] = '<h3>OnRefreshUser</h3>
<p>An event generated when the user session is refreshed.</p>
<h4>Parameters:</h4>
<ul>
  <li><em>id</em> - The User id</li>
</ul>';
$lang['event_help_OnDeleteUser'] = '<h3>OnDeleteUser<h3>
<p>Ausf&uuml;hren, wenn ein Benutzerkonto gel&ouml;scht wurde</p>
<h4>Parameter</h4>
<ul>
<li><em>username</em> - der Benutzername</li>
<li><em>id</em> - die Benutzer-ID</li>
<li><em>props</em> - Ein Hash, der mit den Eigenschaften des Benutzers gef&uuml;llt wurde</li>
</ul>';
$lang['event_help_OnCreateUser'] = '<h3>OnCreateUser<h3>
<p>Ausf&uuml;hren, wenn ein Benutzerkonto neu erstellt wurde</p>
<h4>Parameter</h4>
<ul>
<li><em>username</em> - der Benutzername</li>
<li><em>id</em> - die Benutzer-ID</li>
</ul>';
$lang['event_help_OnUpdateUser'] = '<h3>OnUpdateUser<h3>
<p>Ausf&uuml;hren, wenn Benutzerdaten aktualisiert wurden (entweder durch ihn selbst oder durch den Administrator)</p>
<h4>Parameter</h4>
<ul>
<li><em>name</em> - der Benutzername</li>
<li><em>id</em> - die Benutzer-ID</li>
</ul>';
$lang['event_help_OnCreateGroup'] = '<h3>OnCreateGroup<h3>
<p>Ausf&uuml;hren, wenn eine Benutzergruppe neu erstellt wurde</p>
<h4>Parameter</h4>
<ul>
<li><em>name</em> - der Benutzergruppename</li>
<li><em>description</em> - die Beschreibung der Benutzergruppe</li>
<li><em>id</em> - die Benutzergruppen-ID</li>
</ul>';
$lang['event_help_OnDeleteGroup'] = '<h3>OnDeleteGroup<h3>
<p>Ausf&uuml;hren, wenn eine Benutzergruppe gel&ouml;scht wurde</p>
<h4>Parameter</h4>
<ul>
<li><em>name</em> - der Benutzergruppenname</li>
<li><em>id</em> - die Benutzergruppen-ID</li>
</ul>';
$lang['event_help_OnLogin'] = '<h3>OnLogin<h3>
<p>Ausf&uuml;hren, wenn sich ein Benutzer anmeldet</p>
<h4>Parameter</h4>
<ul>
<li><em>id</em> - die ID des angemeldeten Benutzers</li>
<li><em>username</em> - der Name des angemeldeten Benutzers</li>
<li><em>ip</em> - die IP-Adresse des Clients</li>
</ul>';
$lang['event_help_OnLogout'] = '<h3>OnLogout<h3>
<p>Ausf&uuml;hren, wenn sich ein Benutzer abmeldet</p>
<h4>Parameter</h4>
<ul>
<li><em>username</em> - der Name des abgemeldeten Benutzers</li>
<li><em>id</em> - die Benutzer-ID</li>
</ul>';
$lang['event_help_OnExpireUser'] = '<h3>OnSessionExpiry</h3>
<p>Ausf&uuml;hren, wenn eine Benutzer-Session abl&auml;uft</p>
<h4>Parameter</h4>
<ul>
<li><em>username</em> - der Name des Benutzers der abgelaufenen Sitzung</li>
<li><em>id</em> - die Benutzer-ID der abgelaufenen Sitzung</li>
</ul>';
$lang['event_info_OnLogin'] = 'Ausf&uuml;hren, wenn sich ein Benutzer im System anmeldet';
$lang['event_info_OnLogout'] = 'Ausf&uuml;hren, wenn sich ein Benutzer im System abmeldet';
$lang['event_info_OnExpireUser'] = 'Ausf&uuml;hren, wenn eine Benutzer-Sitzung abl&auml;uft';
$lang['event_info_OnCreateUser'] = 'Ausf&uuml;hren, wenn ein neuer Benutzer erstellt wurde';
$lang['event_info_OnRefreshUser'] = 'Ausf&uuml;hren, wenn die Benutzer-Sitzung erneuert wird';
$lang['event_info_OnUpdateUser'] = 'Ausf&uuml;hren, wenn die Informationen zu einem Benutzer aktualisiert wurden';
$lang['event_info_OnDeleteUser'] = 'Ausf&uuml;hren, wenn ein Benutzerkonto gel&ouml;scht wurde';
$lang['event_info_OnCreateGroup'] = 'Ausf&uuml;hren, wenn eine Benutzergruppe erstellt wurde';
$lang['event_info_OnUpdateGroup'] = 'Ausf&uuml;hren, wenn eine Benutzergruppe aktualisiert wurde';
$lang['event_info_OnDeleteGroup'] = 'Ausf&uuml;hren, wenn eine Benutzergruppe gel&ouml;scht wurde';
$lang['backend_group'] = 'Administrations-Gruppe';
$lang['info_star'] = '* Die folgenden Felder sind komplette Smarty-Templates.<br />Neben den anderen, bereits existierenden Smarty-Variablen stehen Ihnen jetzt die Variablen {$username} und {$group} zur Verf&uuml;gung. <em>(Die Variable {$group} enth&auml;lt die erste Benutzergruppe, der der Benutzer angeh&ouml;rt.)</em>.';
$lang['info_admin_password'] = 'Bearbeiten Sie dieses Feld, um das Passwort des Benutzers zur&uuml;ckzusetzen.';
$lang['info_admin_repeatpassword'] = 'Bearbeiten Sie dieses Feld, um das Passwort des Benutzers zur&uuml;ckzusetzen.';
$lang['error_username_exists'] = 'Ein Benutzer mit diesem Benutzernamen existiert bereits.';
$lang['nocsvresults'] = 'Vom CSV-Export wurden keine Daten zur&uuml;ckgegeben.';
$lang['prompt_unfldlen'] = 'L&auml;nge des Benutzernamen-Feldes';
$lang['prompt_pwfldlen'] = 'L&auml;nge des Passwort-Feldes';
$lang['error_invalidpasswordlengths'] = 'Beim Unter-/&Uuml;berschreiten dieser L&auml;nge ist das Passwort ung&uuml;ltig.';
$lang['error_invalidusernamelengths'] = 'Beim Unter-/&Uuml;berschreiten dieser L&auml;nge ist der Benutzername ung&uuml;ltig.';
$lang['error_invalidemailaddress'] = 'Ung&uuml;ltige E-Mail-Adresse';
$lang['error_noemailaddress'] = 'F&uuml;r dieses Benutzerkonto wurde keine E-Mail-Adresse gefunden.';
$lang['error_problemseettinginfo'] = 'Problem beim Setzen der Benutzerinformationen';
$lang['error_settingproperty'] = 'Problem beim Setzen der Eigenschaften';
$lang['user_added'] = 'Benutzer %s = %s wurde hinzugef&uuml;gt';
$lang['user_deleted'] = 'Benutzer mit der uid=%s wurde gel&ouml;scht';
$lang['propertyfilter'] = 'Eigenschaft';
$lang['valueregex'] = 'Wert (regul&auml;rer Ausdruck)';
$lang['warning_effectsfieldlength'] = 'Warnung: Diese Felder beeinflussen die Gr&ouml;&szlig;e der Eingabefelder in Formularen. Die Verringerung dieser Zahl ist daher auf einer bereits existierenden Seite nicht ratsam.';
$lang['confirm_submitprefs'] = 'Wollen Sie wirklich die Moduleinstellungen &auml;ndern?';
$lang['error_emailalreadyused'] = 'Diese E-Mail-Adresse ist bereits in Verwendung.';
$lang['prompt_usecookiestoremember'] = 'Cookies f&uuml;r die Speicherung der Anmelde-Details verwenden';
$lang['prompt_cookiename'] = 'Der Name des Cookies';
$lang['prompt_allow_duplicate_emails'] = 'E-Mail-Adressduplikate erlauben';
$lang['prompt_username_is_email'] = 'Die E-Mail-Adresse soll der Benutzername sein';
$lang['info_cookie_keepalive'] = 'Es wird versucht, die erfolgreiche Anmeldung &uuml;ber einen Cookie auf dem Rechner zu speichern <em>(der Cookie wird bei entsprechenden Aktivit&auml;ten auf der Webseite zur&uuml;ck gesetzt)</em>';
$lang['info_allow_duplicate_emails'] = '(erlaubt mehreren Benutzern die Nutzung der gleichen E-Mail-Adresse)';
$lang['info_username_is_email'] = '(die E-Mail-Adresse des Benutzers ist sein Benutzername -- verwenden Sie diese Einstellung NIEMALS zusammen mit &quot;E-Mail-Adressduplikate erlauben&quot;!)';
$lang['prompt_allow_duplicate_reminders'] = 'Erneute Anfrage &quot;Passwort vergessen&quot; erlauben?';
$lang['info_allow_duplicate_reminders'] = '(erlaubt einem Benutzer die erneute Anfrage auf das Zur&uuml;cksetzen des Passwortes, auch wenn er auf eine vorangegangene Zur&uuml;cksetzung nicht reagiert hat)';
$lang['prompt_feusers_specific_permissions'] = 'FrontendUser-spezifische Berechtigungen verwenden?';
$lang['info_feusers_specific_permissions'] = '(Normalerweise entsprechen die FEUsers Berechtigungen denen aus der Administration wie etwa Benutzer hinzuf&uuml;gen, Gruppe hinzuf&uuml;gen usw. Wenn Sie jedoch diese Option ausw&auml;hlen, werden f&uuml;r die FrontendUsers-Benutzerkonten separate Berechtigungen gesetzt.)';
$lang['error_missingupload'] = 'Konnte die hochgeladene Datei nicht finden (interner Fehler)';
$lang['error_problem_upload'] = 'Mit der hochgeladenen Datei ist ein Problem aufgetreten. Bitte versuchen Sie es noch einmal.';
$lang['error_missingusername'] = 'Sie haben keinen Benutzernamen eingegeben.';
$lang['error_missingemail'] = 'Sie haben Ihre E-Mail-Adresse nicht eingegeben!';
$lang['error_missingpassword'] = 'Sie haben kein Passwort eingegeben.';
$lang['frontenduser_logout'] = 'FrontendUser - Abmeldung';
$lang['frontenduser_loggedin'] = 'FrontendUser - Anmeldung';
$lang['editprop_infomsg'] = '<span style=&quot;color: red&quot;><b>ACHTUNG</b> Wenn Sie bereits existierende Eigenschaften &auml;ndern, die schon Gruppen zugeordnet sind, kann Ihre Seite m&ouml;glicherweise zerst&ouml;rt werden<i>(besonders, wenn Sie die L&auml;nge der Felder reduzieren, etc).</i></span>';
$lang['info_smtpvalidate'] = 'Dies funktioniert NICHT unter Windows.';
$lang['msg_dontcreateusername'] = 'Erstellen Sie NIEMALS eine Eigenschaft f&uuml;r einen Benutzernamen oder Passwort. Dies ist im FrontEndUsers-Modul bereits eingebaut.';
$lang['prompt_exportcsv'] = 'Benutzer in eine CSV-Datei exportieren';
$lang['exportcsv'] = 'Exportieren';
$lang['importcsv'] = 'Importieren';
$lang['admin'] = 'Administrator';
$lang['editprop'] = 'Eigenschaft <em>%s</em> bearbeiten';
$lang['maxlength'] = 'Maximale L&auml;nge';
$lang['created'] = 'Erstellt';
$lang['sortby'] = 'Sortieren nach';
$lang['sort'] = 'Sortierung';
$lang['usersingroup'] = 'Benutzer in der/den ausgew&auml;hlten Gruppe(n)';
$lang['userlimit'] = 'Ergebnisse beschr&auml;nken auf';
$lang['error_noemailfield'] = 'F&uuml;r diesen Benutzer konnte das E-Mail-Feld nicht gefunden werden. Bitte kontaktieren Sie den Systemadministrator.';
$lang['prompt_forgotpw_page'] = 'Seiten-ID/-Alias f&uuml;r das Formular &quot;Passwort vergessen&quot;';
$lang['prompt_changesettings_page'] = 'Seiten-ID/-Alias f&uuml;r das Formular &quot;Einstellungen &auml;ndern&quot;';
$lang['prompt_login_page'] = 'Seiten-ID/-Alias der Seite, auf die nach der Anmeldung gesprungen werden soll *';
$lang['prompt_logout_page'] = 'Seiten-ID/-Alias der Seite, auf die nach der Abmeldung gesprungen werden soll *';
$lang['sortorder'] = 'Sortierreihenfolge';
$lang['prompt_numresetrecord'] = 'Anzahl der Benutzern, die ihr verlorenes Passwort zur&uuml;ckzusetzen m&ouml;chten. Aktuell steht der Z&auml;hler auf:';
$lang['remove1week'] = 'Alle Eintr&auml;ge entfernen, die &auml;lter als eine Woche sind';
$lang['remove1month'] = 'Alle Eintr&auml;ge entfernen, die &auml;lter als ein Monat sind';
$lang['removeall'] = 'Alle Eintr&auml;ge entfernen';
$lang['areyousure'] = 'Wollen Sie das wirklich?';
$lang['error_invalidcode'] = 'Sie haben einen ung&uuml;ltigen Code eingegeben; bitte versuchen Sie es noch einmal.';
$lang['error_tempcodenotfound'] = 'F&uuml;r Ihre Benutzer-ID wurde kein tempor&auml;rer Code in der Datenbank gefunden.';
$lang['forgotpassword_verifytemplate'] = 'Template f&uuml;r die Anzeige des &Uuml;berpr&uuml;fungs-Formulars';
$lang['forgotpassword_emailtemplate'] = 'Template f&uuml;r die E-Mail bei vergessenem Passwort';
$lang['error_resetalreadysent'] = 'Entweder Sie selbst oder jemand anderes hat bereits das Zur&uuml;cksetzen des Passworts f&uuml;r diese Konto ausgel&ouml;st. Pr&uuml;fen Sie Ihren E-Mail-Eingang. Sie finden dort weitere Anweisungen zum Zur&uuml;cksetzen Ihres Passwortes.';
$lang['error_dberror'] = 'Datenbankfehler';
$lang['message_forgotpwemail'] = 'Sie erhalten diese Nachricht, da jemand auf unserer Seite angegeben hat, dass Sie Ihr Passwort verloren haben. Falls dies zutrifft, lesen Sie bitte die weiteren Anweisungen.  Wenn Sie keine Ahnung haben, um was es geht, dann l&ouml;schen Sie sicherheitshalber diese Nachricht. Wir bedanken uns, dass Sie sich die Zeit genommen haben.';
$lang['prompt_code'] = 'Code';
$lang['message_code'] = 'Der folgende Code wurde zuf&auml;llig generiert, um das Benutzer-Konto zu &uuml;berpr&uuml;fen. Wenn Sie auf den folgenden Link klicken, gelangen Sie auf eine Seite, wo Sie diesen Code eingeben m&uuml;ssen. Normalerweise enth&auml;lt das Feld bereits Ihren Code. Falls aber nicht, lautet der Code:';
$lang['prompt_link'] = 'Ein Klick auf den folgenden Link bringt Sie auf die Webseite, wo Sie den untenstehenden Code eingeben und damit Ihr Passwort zur&uuml;cksetzen k&ouml;nnen:';
$lang['lostpassword_emailsubject'] = 'Passwort verloren';
$lang['error_nomailermodule'] = 'Das CMSMailer-Modul wurde nicht gefunden.';
$lang['info_forgotpwmessagesent'] = 'Eine E-Mail mit Informationen zum Zur&uuml;cksetzen des Passworts wurde an %s versandt. Vielen Dank!';
$lang['lostpw_message'] = 'Sie haben Ihr Passwort vergessen oder verloren. Geben Sie hier Ihren Benutzernamen ein. Wenn wir Sie im System finden, erhalten Sie eine E-Mail mit weiteren Anweisungen zum Zur&uuml;cksetzen des Passworts.';
$lang['forgotpassword_template'] = 'Template f&uuml;r vergessene Passw&ouml;rter';
$lang['lostusername_template'] = 'Template f&uuml;r vergessene Benutzernamen';
$lang['error_propnotfound'] = 'Eigenschaft %s nicht gefunden';
$lang['propsfound'] = 'Eigenschaften gefunden';
$lang['addprop'] = 'Eigenschaft hinzuf&uuml;gen';
$lang['error_requiredfield'] = 'Ein erforderliches Feld (%s) war leer.';
$lang['info_emptypasswordfield'] = 'Um Ihr Passwort zu &auml;ndern, geben Sie bitte hier ein neues Passwort ein.';
$lang['error_notloggedin'] = 'Es scheint so, als ob Sie nicht angemeldet sind.';
$lang['user_settings'] = 'Einstellungen';
$lang['user_registration'] = 'Registrierung';
$lang['error_accountexpired'] = 'Dieses Konto ist abgelaufen';
$lang['error_improperemailformat'] = 'Ungenaue Formatierung der E-Mail-Adresse';
$lang['error_invalidexpirydate'] = 'Ung&uuml;ltiges Ablaufdatum';
$lang['error_problemsettingproperty'] = 'Fehler beim Setzen der Eigenschaft %s f&uuml;r den Benutzer $s';
$lang['error_invalidgroupid'] = 'Ung&uuml;ltige Gruppen-ID %s';
$lang['hiddenfieldmarker'] = 'Kennzeichnung f&uuml;r verborgene Felder';
$lang['hiddenfieldcolor'] = 'Farbe f&uuml;r verborgene Felder';
$lang['hidden'] = 'Verborgen';
$lang['error_duplicatename'] = 'Eine Eigenschaft mit diesem Namen existiert bereits.';
$lang['error_noproperties'] = 'Es wurden noch keine Eigenschaften definiert.';
$lang['error_norelations'] = 'F&uuml;r diese Benutzergruppe wurden keine Eigenschaften ausgew&auml;hlt.';
$lang['nogroups'] = 'Es wurden noch keine Gruppen definiert.';
$lang['groupsfound'] = 'Benutzergruppen gefunden';
$lang['error_onegrouprequired'] = 'Die Mitgliedschaft in mindestens einer Gruppe ist erforderlich.';
$lang['prompt_requireonegroup'] = 'Erfordert die Mitgliedschaft in mindestens einer Gruppe';
$lang['back'] = 'Zur&uuml;ck';
$lang['error_missing_required_param'] = '%s ist ein Pflichtfeld.';
$lang['requiredfieldmarker'] = 'Pflichtfelder kennzeichnen mit';
$lang['requiredfieldcolor'] = 'Pflichtfelder einf&auml;rben mit';
$lang['next'] = 'Weiter';
$lang['error_groupexists'] = 'Eine Gruppe mit diesem Namen existiert bereits.';
$lang['required'] = 'Pflichtfeld';
$lang['optional'] = 'optional';
$lang['off'] = 'Aus';
$lang['size'] = 'Gr&ouml;&szlig;e';
$lang['sizecomment'] = '<br/>(Maximale Gr&ouml;&szlig;e irgend einer Bilddimension in Pixel)';
$lang['length'] = 'L&auml;nge';
$lang['lengthcomment'] = '<br>(Zeichen in der Texteingabe)';
$lang['seloptions'] = 'Listenfeld-Optionen, getrennt durch Zeilenumbr&uuml;che. Die Werte k&ouml;nnen mit a = Zeichen vom Text getrennt werden, z.Bsp.: Weiblich=w';
$lang['radiooptions'] = 'Beschriftung des Optionsfeldes, getrennt durch Zeilenumbr&uuml;che. Die Werte k&ouml;nnen mit a = Zeichen vom Text getrennt werden, z.Bsp.: Weiblich=w';
$lang['prompt'] = 'Eingabeaufforderung';
$lang['prompt_type'] = 'Typ';
$lang['type'] = 'Typ';
$lang['fieldstatus'] = 'Feldstatus';
$lang['usedinlostun'] = 'Frage bei vergessenem<br/>Benutzernamen';
$lang['text'] = 'Text';
$lang['checkbox'] = 'Kontrollk&auml;stchen';
$lang['multiselect'] = 'Mehrfachlistenauswahl';
$lang['radiobuttons'] = 'Optionsfelder';
$lang['image'] = 'Bild';
$lang['email'] = 'E-Mail-Adresse';
$lang['textarea'] = 'Textfeld';
$lang['dropdown'] = 'Listenfeld';
$lang['msg_currentlyloggedinas'] = 'Willkommen';
$lang['logout'] = 'Abmelden';
$lang['prompt_newgroupname'] = 'Diesen Gruppennamen verwenden';
$lang['prompt_changesettings'] = 'Meine Einstellungen &auml;ndern';
$lang['error_loginfailed'] = 'Ihre Anmeldung ist fehlgeschlagen - ung&uuml;ltiger Benutzername oder ung&uuml;ltiges Passwort?';
$lang['login'] = 'Anmelden';
$lang['prompt_signin_button'] = 'Beschriftung des Anmelde-Buttons';
$lang['prompt_username'] = 'Benutzername';
$lang['prompt_email'] = 'E-Mail-Adresse';
$lang['prompt_password'] = 'Passwort';
$lang['prompt_rememberme'] = 'Anmeldung auf diesem Computer merken';
$lang['register'] = 'Registrieren';
$lang['forgotpw'] = 'Haben Sie Ihr Passwort vergessen?';
$lang['lostusername'] = 'Haben Sie Ihre Benutzerdaten vergessen?';
$lang['defaults'] = 'Standard';
$lang['template'] = 'Template';
$lang['error_usernotfound'] = 'Konnte keine Informationen f&uuml;r diesen Benutzer finden';
$lang['error_usernametaken'] = 'Dieser Benutzername (%s) wird bereits verwendet.';
$lang['prompt_smtpvalidate'] = 'Soll SMTP verwendet werden, um E-Mail-Adressen auf G&uuml;ltigkeit zu pr&uuml;fen?';
$lang['prompt_minpwlen'] = 'Minimale L&auml;nge des Passworts';
$lang['prompt_maxpwlen'] = 'Maximale L&auml;nge des Passworts';
$lang['prompt_minunlen'] = 'Minimale L&auml;nge des Benutzernamens';
$lang['prompt_maxunlen'] = 'Maximale L&auml;nge des Benutzernamens';
$lang['prompt_sessiontimeout'] = 'Auszeit f&uuml;r Sessions (in Sekunden)';
$lang['prompt_cookiekeepalive'] = 'Cookies f&uuml;r die Anmeldung verwenden';
$lang['prompt_allowemailreg'] = 'E-Mail-Registrierung erlauben';
$lang['prompt_dfltgroup'] = 'Standard-Benutzergruppe f&uuml;r neue Benutzer';
$lang['changesettings_template'] = 'Template f&uuml;r Einstellungen &auml;ndern';
$lang['error_passwordmismatch'] = 'Die Passw&ouml;rter stimmen nicht &uuml;berein.';
$lang['error_invalidusername'] = 'Ung&uuml;ltiger Benutzername';
$lang['error_invalidpassword'] = 'Ung&uuml;ltiges Passwort';
$lang['edituser'] = 'Benutzer bearbeiten';
$lang['valid'] = 'G&uuml;ltig';
$lang['username'] = 'Benutzername';
$lang['status'] = 'Status';
$lang['error_membergroups'] = 'Dieser Benutzer ist noch kein Mitglied einer Benutzergruppe.';
$lang['error_properties'] = 'Keine Eigenschaften';
$lang['error_dup_properties'] = 'Sie haben versucht, Eigenschaften doppelt zu importieren';
$lang['value'] = 'Wert';
$lang['groups'] = 'Benutzergruppen';
$lang['properties'] = 'Eigenschaften';
$lang['propname'] = 'Name der Eigenschaft';
$lang['propvalue'] = 'Wert der Eigenschaft';
$lang['add'] = 'Hinzuf&uuml;gen';
$lang['history'] = 'Geschichte';
$lang['edit'] = 'Bearbeiten';
$lang['expires'] = 'Ablauf';
$lang['specify_date'] = 'Datum festlegen';
$lang['12hrs'] = '12 Stunden';
$lang['24hrs'] = '24 Stunden';
$lang['48hrs'] = '48 Stunden';
$lang['1week'] = '1 Woche';
$lang['2weeks'] = '2 Wochen';
$lang['1month'] = '1 Monat';
$lang['3months'] = '3 Monate';
$lang['6months'] = '6 Monate';
$lang['1year'] = '1 Jahr';
$lang['never'] = 'Niemals';
$lang['postinstallmessage'] = 'Das Modul wurde installiert.<br/>Stellen Sie sicher, dass die Berechtigung &quot;Modify FrontEndUser Properties&quot; gesetzt wurde. Zus&auml;tzlich wird die Installation des Captcha-Moduls empfohlen. Nach dessen Installation wird bei der Anmeldung erg&auml;nzend zu Benutzernamen und Passwort der Inhalt eines Captcha-Bildes abgefragt. Dies soll helfen, Brute-force-Attacken zu verhindern. <strong>Hinweis:</strong> Diese Funktionalit&auml;t kann mit dem Parameter nocaptcha deaktiviert werden, auch wenn das Captcha-Modul installiert ist.';
$lang['password'] = 'Passwort';
$lang['repeatpassword'] = 'Wiederholung Passwort';
$lang['error_groupname_exists'] = 'Eine Benutzergruppe mit diesem Namen existiert bereits.';
$lang['editgroup'] = 'Benutzergruppe bearbeiten';
$lang['submit'] = 'Absenden';
$lang['cancel'] = 'Abbrechen';
$lang['delete'] = 'L&ouml;schen';
$lang['confirm_editgroup'] = 'Sind das wirklich die richtigen Einstellungen f&uuml;r diese Benutzergruppe?\nDas Deaktivieren einer Eigenschaft l&ouml;scht keine Eintr&auml;ge in der Eigenschaftentabelle f&uuml;r diese Benutzergruppe/diesen Benutzer. Sie sind lediglich nicht mehr verf&uuml;gbar.';
$lang['areyousure_deletegroup'] = 'Wollen Sie diese Benutzergruppe wirklich l&ouml;schen?';
$lang['confirm_delete_prop'] = 'Wollen Sie diese Eigenschaft wirklich komplett l&ouml;schen?\nFalls ja, wird auch jeder Benutzereintrag f&uuml;r diese Eigenschaft gel&ouml;scht.';
$lang['error_insufficientparams'] = 'Unzureichende Parameter';
$lang['id'] = 'ID';
$lang['name'] = 'Name';
$lang['error_cantaddprop'] = 'Problem beim Hinzuf&uuml;gen einer Eigenschaft';
$lang['error_cantaddgroupreln'] = 'Problem beim Hinzuf&uuml;gen einer Gruppenbeziehung';
$lang['error_cantaddgroup'] = 'Problem beim Hinzuf&uuml;gen einer Benutzergruppe';
$lang['error_cantassignuser'] = 'Problem beim Hinzuf&uuml;gen eines Benutzers zu einer Benutzergruppe';
$lang['error_couldnotdeleteproperty'] = 'Problem beim L&ouml;schen einer Eigenschaft';
$lang['error_couldnotfindemail'] = 'Konnte keine E-Mail-Adresse finden';
$lang['error_destinationnotwritable'] = 'Sie haben keine Schreibberechtigung f&uuml;r das Zielverzeichnis.';
$lang['error_invalidparams'] = 'Ung&uuml;ltige Parameter';
$lang['error_nogroups'] = 'Konnte keine Benutzergruppen finden';
$lang['applyfilter'] = 'Anwenden';
$lang['filter'] = 'Filter';
$lang['userfilter'] = 'Benutzername (regul&auml;rer Ausdruck)';
$lang['description'] = 'Beschreibung';
$lang['groupname'] = 'Name der Benutzergruppe';
$lang['accessdenied'] = 'Zugriff verweigert';
$lang['error'] = 'Fehler';
$lang['addgroup'] = 'Eine Benutzergruppe hinzuf&uuml;gen';
$lang['importgroup'] = 'Gruppe importieren';
$lang['adduser'] = 'Einen Benutzer hinzuf&uuml;gen';
$lang['usersfound'] = 'Benutzer gefunden, die den Kriterien entsprechen';
$lang['group'] = 'Benutzergruppe';
$lang['selectgroup'] = 'Benutzergruppe ausw&auml;hlen';
$lang['registration_template'] = 'Registrierungs-Template';
$lang['logout_template'] = 'Abmeldungs-Template';
$lang['login_template'] = 'Anmeldungs-Template';
$lang['preferences'] = 'Einstellungen';
$lang['users'] = 'Benutzer';
$lang['friendlyname'] = 'FrontendUser-Verwaltung';
$lang['moddescription'] = 'Erlaubt den Benutzern, sich auf Ihrer Webseite anzumelden';
$lang['defaultfrontpage'] = 'Standard-Startseite';
$lang['lastaccessedpage'] = 'Letzte Seite, auf die zugegriffen wurde';
$lang['otherpage'] = 'Andere Seite:';
$lang['captcha_title'] = 'Geben Sie den Text aus dem Bild ein';
$lang['utma'] = '156861353.1820432479.1392278822.1392278822.1392726308.2';
$lang['utmz'] = '156861353.1392278822.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
?>