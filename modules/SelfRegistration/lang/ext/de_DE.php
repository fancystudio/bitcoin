<?php
$lang['eventhandlers_added'] = 'Event Handlers Added';
$lang['preferences_updated'] = 'Preferences Updated';
$lang['setup_cart_events'] = 'Setup Cart Events';
$lang['setup'] = 'Setup';
$lang['info_setup_cart_events'] = 'Occasionally, when upgrading from an older version, cart events handlers are not added.  Click this button to ensure that they are.  This is important if using paid registrations';
$lang['info_force_email_twice'] = 'If this option is enabled, the user will be required to enter their username (or email address) twice, and those two values will be checked to be identical';
$lang['prompt_redirect_paidpkg'] = 'Page ID/Alias to redirect to for paid packages';
$lang['info_redirect_paidpkg'] = 'A smarty template that determines the pageid or alias of a page to redirect to for paid packages. Typically a user that is registering for your site may want to go directly to your checkout page, or to the view cart page.';
$lang['info_additionalgroups_matchfields'] = 'When allowing existing users to register to an additional group, you can specify which FEU properties of the existing user must match when the user registers again.  This information will be used to uniquely identify the FEU user account';
$lang['info_cartitem_summary_tpl'] = 'A smarty template that determines the value of the summary that appears with this line item in the cart, and during the checkout process.  If no value is specified a default is used.  Valid smarty variables are {$pkg} <em>(array)</em>.  {$sku}, {$username}, {$tmpuid} <em>(the users temporary user id)</em>. <strong>Note:</strong> some payment gateways may only support a fixed number of characters for the summary.';
$lang['prompt_cartitem_summary_tpl'] = 'Cart Item Summary Template';
$lang['paid_registration'] = 'Bezahlte Registrierung';
$lang['info_skip_final_msg'] = 'This option determins wether the registration complete message should be displayed to the user after registration.';
$lang['notifications'] = 'Benachrichtigungen';
$lang['info_login_afterverify'] = 'This option will automatically log the visitor into the site after the user has been pushed to the Frontend Users module.  This option has no effect if allowing paid registration';
$lang['info_email_confirmation'] = 'This option sends an email to the registerd user account with a link that allows verifying that the account information entered is valid.<br/><strong>Note:</strong> This option should not be used when allowing paid registrations';
$lang['prompt_registration_settings'] = 'Registrungseinstellungen';
$lang['none'] = 'Keine';
$lang['month'] = 'Monat';
$lang['year'] = 'Jahr';
$lang['subscription_expires'] = 'Subscription renews every';
$lang['error_policycantadd'] = 'The policy of this website does not allow adding this item to your cart.  Please contact the site administrator';
$lang['prompt_allow_select_pkg'] = 'Allow users to select a package (group) to register to';
$lang['info_allowselectpkg'] = 'You may wish to allow your users to select an FEU group to register to.  These groups are tied to packages (for ecommerce purposes).  However if not using the E-commerce functionality, the price data can be ignored';
$lang['error_nopkgs'] = 'No packages have been defined to allow the customer to register to';
$lang['selpkg_template'] = 'Select Package Template';
$lang['title_selpkg_template'] = 'Select Subscription Package Template';
$lang['info_selpkg_template'] = 'This template is used when paid subscriptions are enabled to allow the user to select a paid subscription package';
$lang['error_pkgcost'] = 'Package Cost is Invalid';
$lang['error_pkgexists'] = 'A package with a %s of %s already exists';
$lang['description'] = 'Beschreibung';
$lang['edit_paidpkg'] = 'Edit Paid Package &quot;%s&quot;';
$lang['add_paidpkg'] = 'Add Paid Package';
$lang['name'] = 'Name ';
$lang['prompt'] = 'Eingabeaufforderung';
$lang['group'] = 'Benutzergruppe';
$lang['cost'] = 'Kosten';
$lang['regpkgs_tab'] = 'Registration Packages';
$lang['prompt_allow_paid_registration'] = 'Require members to pay for registration to your site';
$lang['info_allow_paid_registration'] = 'Please also select Selfregistration as a source module from CGEcommerceBase, and configure the &quot;Paid Registration&quot; Tab.  Additionally, you must enable package selection above.';
$lang['email-password'] = 'Email-Adresse und Passwort';
$lang['username-password'] = 'Benutzername und Passwort';
$lang['help_param_allowoverwrite'] = 'This parameter allows overwriting existing FEU users. In conjunction with the preferences in the SelfRegistration admin panel you can specify what data will be used to uniquely identify a user account&#039;;';
$lang['into_additionalgroups_matchfields'] = 'Specify which fields should be used to uniquely identify a user.  This can be used to allow the user to register when an account already exists for that user with a different username.';
$lang['prompt_additionalgroups_matchfields'] = 'When overwriting an existing account the following fields must match';
$lang['prompt_reg_additionalgroups'] = 'Allow existing users to register for additional groups?';
$lang['prompt_additionalgroups_settings'] = 'Zus&auml;tzliche Gruppeneinstellungen';
$lang['prompt_general_settings'] = 'Allgemeine Einstellungen';
$lang['prompt_security_settings'] = 'Sicherheitseinstellungen';
$lang['error_uniquefield'] = 'The value specified for &quot;%s&quot; is already in use by another registered user';
$lang['help_param_action'] = 'This parameter dictates the behaviour of the module.
<ul>
  <li><strong>default</strong>
   <p>This is the default action.  Based on the <em>(deprecated></em> mode parameter <em>(see below)</em> it will display either the user registration form, the verify form, or another form.</li>
  </li>
  <li>reguser_link
   <p>Display a link to the user registration form.</p>
  </li>
</ul>';
$lang['help_param_destpage'] = 'Applicable only to the action=reguser_link.. this parameter allows specifying (by alias or page id) a destination page for the link.';
$lang['help_param_group'] = 'Applicable to the action=reguser_link or action=register, this parameter allows specifying a group in which the user will be regisered';
$lang['help_param_onlyhref'] = 'Used only in the action=reguser_link, setting this parameter indicates that the output should only contain the url portion of the link';
$lang['help_param_linktext'] = 'Used only in the action_reguser_link it allows specifying the text for the generated link.  This parameter is ignored if the onlyhref parameter is specified.';
$lang['help_param_noinline'] = 'Applicable to many actions, this parameter overrides the preference in the admin panel to indicate that the output from the generated link or form should not be displayed inline.  i.e: noinline=1 on the default action will indicate that the output text will replace the {content} tag.';
$lang['error_noregister'] = 'You cannot register to become a member of this user group';
$lang['prompt_noregister'] = 'Benutzern verbieten, sich f&uuml;r diese Gruppe zu registrieren';
$lang['error_nosecondemailaddress'] = 'Sie m&uuml;ssen Ihre Email-Adresse zur Sicherheit noch ein zweites Mal eingeben!';
$lang['push_live'] = 'Diesen Benutzer im FEU-Modul eintragen';
$lang['areyousure_pushuser'] = 'Soll dieser Benutzer wirklich ohne Abschlu&szlig; der &Uuml;berpr&uuml;fung in das FEU-Modul eintragen lassen?';
$lang['delete'] = 'L&ouml;schen';
$lang['login_afterverify'] = 'Den Benutzer automatisch im FrontEndUsers-Modul anmelden, wenn die &Uuml;berpr&uuml;fung erfolgreich abgeschlossen wurde';
$lang['skip_final_msg'] = 'Nach der Registrierung keine abschlie&szlig;ende Mitteilung anzeigen';
$lang['redirect_afterregister'] = 'Seiten-ID/Alias, auf die die Benutzer nach der vollst&auml;ndigen Registrierung weitergeleitet werden sollen';
$lang['redirect_afterverify'] = 'Seiten-ID/Alias, auf die die Benutzer nach der vollst&auml;ndigen &Uuml;berpr&uuml;fung weitergeleitet werden sollen';
$lang['use_inline_forms'] = 'Inline-Formulare verwenden <em>(das Formular ersetzt den Modul-Tag, nicht den gesamten content-Tag)</em>';
$lang['error_codesdontmatch'] = 'Der eingegebene &Uuml;berpr&uuml;fungsschl&uuml;ssel ist ung&uuml;ltig';
$lang['event_description_onNewUser'] = 'Ausf&uuml;hren, wenn ein Benutzer das Registrierungsformular vollst&auml;ndig ausgef&uuml;llt hat';
$lang['event_description_onUserRegistered'] = 'Ausf&uuml;hren, wenn ein Benutzer seine Daten &uuml;berpr&uuml;ft hat und vollst&auml;ndig registriert ist';
$lang['event_help_onNewUser'] = '<p>Ausf&uuml;hren, wenn ein Benutzer das Registrierungsformular vollst&auml;ndig ausgef&uuml;llt hat</p>
<h4>Parameter</h4>
<ul>
<li><em>username</em> - der Name des neuen Benutzers</li>
<li><em>email</em> - die Email-Adresse des neuen Benutzers</li>
</ul>
';
$lang['event_help_onUserRegistered'] = '<p>Ausf&uuml;hren, wenn ein Benutzer seine Daten &uuml;berpr&uuml;ft hat und jetzt vollst&auml;ndig registriert ist</p>
<h4>Parameter</h4>
<ul>
<li><em>username</em> - der registrierte Benutzername</li>
<li><em>id</em> - die ID des neuen Benutzers</li>
</ul>
';
$lang['confirm_submitprefs'] = 'Die Administrator-Einstellungen &auml;ndern?';
$lang['info_admin_password'] = 'Lassen Sie dieses Feld leer, wenn Sie das bisherige Benutzer-Passwort beibehalten m&ouml;chten.';
$lang['info_admin_repeatpassword'] = 'Lassen Sie dieses Feld leer, wenn Sie das bisherige Benutzer-Passwort beibehalten m&ouml;chten.';
$lang['error_emaildoesnotmatch'] = 'Die Email-Adressen stimmen nicht &uuml;berein.';
$lang['force_email_twice'] = 'Benutzer m&uuml;ssen Ihre Email-Adresse zur Best&auml;tigung ein zweites Mal eingeben.';
$lang['again'] = 'Noch einmal';
$lang['deleteselusers'] = 'Die ausgew&auml;hlten Benutzer l&ouml;schen';
$lang['error_nopropdefns'] = 'Keine Eigenschaftsdefinitionen vorhanden, oder Probleme bei deren Abruf aus der Datenbank';
$lang['error_nogroups'] = 'Keine Benutzergruppen vorhanden, oder ein Problem beim Auffinden der Benutzergruppenliste';
$lang['error_dberror'] = 'Datenbankfehler';
$lang['title_post_sendanotheremail_template'] = 'Nachfolgendes Template bei verlorengegangener Email';
$lang['title_sendanotheremail_template'] = 'Template bei verlorengegangener Email';
$lang['clickhere'] = 'Hier klicken';
$lang['msg_sendanotheremail'] = 'Ich habe das Registrierungsformular bereits vollst&auml;ndig ausgef&uuml;llt, habe aber noch keine Email bekommen. K&ouml;nnen Sie mir diese noch einmal senden?';
$lang['sendanotheremail_template'] = 'Template bei verlorengegangener Email';
$lang['info_userverified'] = 'Ein neuer Benutzer wurde im FrontendUsers-Modul hinzugef&uuml;gt';
$lang['edit'] = 'Bearbeiten';
$lang['unknown'] = 'Unbekannt';
$lang['select'] = 'Ausw&auml;hlen';
$lang['check_all'] = 'Alle auf &quot;Gepr&uuml;ft&quot; setzen';
$lang['uncheck_all'] = 'Alle auf &quot;Noch zu pr&uuml;fen&quot; setzen';
$lang['send_adjustmentemail'] = 'Eine Email an den Benutzer senden';
$lang['txt_adjustmentemail'] = '(informiert den Benutzer, dass sein Konto korrigiert wurde)';
$lang['txt_changepassword'] = 'Sie m&uuml;ssen diese Felder ausf&uuml;llen, um das Benutzer-Passwort zu &auml;ndern.';
$lang['edituser'] = 'Benutzer bearbeiten';
$lang['areyousure_deleteuser'] = 'M&ouml;chten Sie wirklich diesen teilweise registrierten Benutzer l&ouml;schen?';
$lang['hdr_userid'] = 'Benutzer-ID';
$lang['hdr_username'] = 'Benutzername';
$lang['hdr_grpname'] = 'Benutzergruppe';
$lang['hdr_created'] = 'Erstellt';
$lang['hdr_email'] = 'Email';
$lang['usersfound'] = 'Benutzer gefunden (beschr&auml;nkt auf maximal 250 Benutzer)';
$lang['users'] = 'Benutzer';
$lang['list1day'] = 'Alle Eintr&auml;ge auflisten, die &auml;lter als 1 Tag sind';
$lang['subject'] = 'Betreff f&uuml;r die ausgehende Email';
$lang['htmlbody'] = 'Inhalt der HTML-Nachricht';
$lang['textbody'] = 'Inhalt der Text-Nachricht';
$lang['prompt_numresetrecord'] = 'Anzahl von Benutzern, die ihr verloren gegangenes Passw&ouml;rter zur&uuml;cksetzen wollen. Aktuell sind dies:';
$lang['remove1week'] = 'Alle Eintr&auml;ge entfernen, die &auml;lter als eine Woche sind';
$lang['remove1month'] = 'Alle Eintr&auml;ge entfernen, die &auml;lter als ein Monat sind';
$lang['remove1day'] = 'Alle Eintr&auml;ge entfernen, die &auml;lter als einen Tag sind';
$lang['removeall'] = 'Alle Eintr&auml;ge entfernen';
$lang['areyousure'] = 'Wollen Sie das wirklich?';
$lang['registration_info_edited'] = 'Ihre Registrierungsinformation wurde modifiziert.';
$lang['registration_confirmation'] = 'Registrierungsbest&auml;tigung';
$lang['user_registration'] = 'Registrieren';
$lang['finalmessage_template'] = 'Template f&uuml;r Abschlussnachricht';
$lang['title_verifyregistration'] = 'Registrierung &uuml;berpr&uuml;fen';
$lang['code'] = '&Uuml;berpr&uuml;fungsschl&uuml;ssel';
$lang['default'] = 'Als Standard setzen';
$lang['error_noproperties'] = 'Keine Eigenschaften f&uuml;r diesen Benutzer gefunden';
$lang['error_noproprelations'] = 'Keine Verkn&uuml;pfung zu der Eigenschaft gefunden';
$lang['error_emailinvalid'] = 'Ung&uuml;ltige Email-Adresse';
$lang['error_noemailaddress'] = 'Kein g&uuml;ltiges Adressfeld gefunden';
$lang['error_requiredfield'] = 'Das Feld %s muss ausgef&uuml;llt werden';
$lang['registration1_template'] = 'Registrierungs-Template 1';
$lang['registration2_template'] = 'Registrierungs-Template 2';
$lang['emailconfirm_template'] = 'Template f&uuml;r die Email-Best&auml;tigung';
$lang['emailuseredited_template'] = 'Template f&uuml;r ge&auml;nderte Benutzer-Informationen';
$lang['preferences'] = 'Einstellungen';
$lang['error_usernotfound'] = 'Benutzer nicht gefunden';
$lang['error_invalidusername'] = 'Der Benutzername ist ung&uuml;ltig (zu lang, zu kurz oder enth&auml;lt ung&uuml;ltige Zeichen).
<b>Hinweis:</b> Benutzernamen d&uuml;rfen nur alphanumerische Zeichen enthalten (keine Leerzeichen)!';
$lang['error_invalidemail'] = 'Die Email-Adresse ist ung&uuml;ltig.';
$lang['error_usernametaken'] = 'Dieser Benutzername ist bereits vergeben!';
$lang['error_passwordsdontmatch'] = 'FEHLER: Die Passw&ouml;rter stimmen nicht &uuml;berein!';
$lang['error_invalidpassword'] = 'Das Passwort ist ung&uuml;ltig (Passw&ouml;rter m&uuml;ssen %s bis %s Zeichen lang sein)';
$lang['error_emptyusername'] = 'Der Benutzername darf nicht leer gelassen werden!';
$lang['error_emptyemail'] = 'Die Email-Adresse darf nicht leer sein!';
$lang['repeatpassword'] = 'Passwort (noch einmal)';
$lang['password'] = 'Passwort';
$lang['username'] = 'Benutzername';
$lang['email'] = 'Email-Adresse';
$lang['captcha_title'] = 'Bitte geben Sie den Text aus dem Bild ein';
$lang['error_insufficientparams'] = 'Das Modul wurde mit unvollst&auml;ndigen (oder falschen) Parametern aufgerufen!';
$lang['error_nofeusersmodule'] = 'Konnte keine Verbindung zum FrontEndUsers-Modul herstellen!';
$lang['error_nosuchgroup'] = 'Der angegebene Gruppenname existiert nicht!';
$lang['error_captchamismatch'] = 'Der aus dem Bild eingegebene Text war falsch';
$lang['send_emails_to'] = 'Die Registrierungs-Emails sollen versandt werden an';
$lang['require_email_confirmation'] = 'Erfordert, dass der Benutzer die Registrierung per Email best&auml;tigt';
$lang['notify_on_registration'] = 'Benachrichtigungsemail versenden, wenn sich jemand registriert';
$lang['cancel'] = 'Abbrechen';
$lang['submit'] = 'Absenden';
$lang['friendlyname'] = 'SelfRegistration-Modul';
$lang['postinstall'] = 'Die Installation war erfolgreich. Bitte denken Sie daran, die Berechtigung &#039;Modify SelfRegistration Settings&#039; zu setzen. Wenn das Captcha-Modul installiert ist, steht Ihnen die Captcha-Funktionalit&auml;t standardm&auml;&szlig;ig zur Verf&uuml;gung. Zur Vermeidung von Spam wird dringend empfohlen, dieses Moduls zu verwenden. Wenn das Captcha-Modul installiert ist, es aber nicht verwendet werden soll, m&uuml;ssen Sie SelfRegistration mit dem Parameter nocaptcha aufrufen.';
$lang['postuninstall'] = 'Das SelfRegistration-Modul wurde erfolgreich deinstalliert.';
$lang['uninstalled'] = 'Modul deinstalliert.';
$lang['installed'] = 'Modulversion %s installiert.';
$lang['prefsupdated'] = 'Moduleinstellungen aktualisiert.';
$lang['accessdenied'] = 'Zugriff verweigert. Bitte pr&uuml;fen Sie Ihre Berechtigungen.';
$lang['error'] = 'Fehler!';
$lang['upgraded'] = 'Modul auf Version %s aktualisiert.';
$lang['title_mod_prefs'] = 'Moduleinstellungen';
$lang['title_mod_admin'] = 'Moduladministration';
$lang['title_admin_panel'] = 'SelfRegistration-Modul';
$lang['moddescription'] = 'Ein Modul, mit dem sich Benutzer selbst registrieren k&ouml;nnen.';
$lang['welcome_text'] = '<p>Willkommen beim SelfRegistration-Modul.</p>';
$lang['enable_whitelist'] = 'Wei&szlig;e Liste aktivieren';
$lang['whitelist'] = 'List of whitelist username/emails. One per line. (use * for wildcards)';
$lang['whitelist_trigger_message'] = 'Message to show if a whitelist rule is triggered';
$lang['dont_use'] = 'Keine wei&szlig;e Liste';
$lang['no_matches'] = 'Keine Registrierungen erlauben, bei denen Benutzername und Email-Adresse &uuml;berein stimmen';
$lang['only_matches'] = 'Nur Registrierungen erlauben, bei denen Benutzername und Email-Adresse &uuml;berein stimmen';
?>
