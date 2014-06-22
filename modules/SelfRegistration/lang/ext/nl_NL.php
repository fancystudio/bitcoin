<?php
$lang['error_novalidgroups'] = 'Geen groepen gevonden';
$lang['multiplegroups'] = 'Meerdere Groepen';
$lang['singlegroup'] = 'Enkele Groep';
$lang['no'] = 'Nee';
$lang['error_multiplepkgs'] = 'Meerdere items geselecteerd, maar dat is niet toegestaan';
$lang['error_missingcode'] = 'De registratie validatiecode is niet aanwezig';
$lang['error_missingemail'] = 'E-mail adres is niet aanwezig';
$lang['eventhandlers_added'] = 'Gebeurtenis beschrijvingen toegevoegd';
$lang['preferences_updated'] = 'Instellingen bijgewerkt';
$lang['setup_cart_events'] = 'Stel Cart gebeurtenissen in';
$lang['setup'] = 'Installatie';
$lang['info_setup_cart_events'] = 'Af en toe, bijvoorbeeld bij het upgraden van oudere installaties, kan het gebeuren dat de gebeurtenisbeschrijvingen niet zijn toegevoegd. Klik op deze knop om er voor te zorgen dat deze wel worden toegevoegd. Dit is belangrijk bij het gebruik van betaalde registraties.';
$lang['info_force_email_twice'] = 'Als deze optie is ingeschakeld dan is de gebruiker verplicht om zijn gebruikersnaam (of e-mailadres) twee keer in te voeren. Deze twee waarden moeten dan met elkaar overeen komen';
$lang['prompt_redirect_paidpkg'] = 'Page ID/alias voor verwijzing naar betaalpakketen';
$lang['info_redirect_paidpkg'] = 'Een smarty sjabloon dat verwijst naar de pagina-id of alias van de pagina waar naartoe moet worden doorverwezen voor betaalde pakketten. Een gebruiker die registreert voor uw website wil misschien direct naar de betaalpagina gaan of de winkelwagen zien.';
$lang['info_additionalgroups_matchfields'] = 'Indien toegestaan kunnen bestaande gebruikers toegevoegd worden aan een extra groep. U kunt hier opgegeven welke FEU-eigenschappen van de bestaande gebruiker moeten overeenkomen wanneer de gebruiker opnieuw registreert. Deze informatie moet uniek zijn om de FEU-gebruiker te kunnen identificeren.';
$lang['info_cartitem_summary_tpl'] = 'Een smarty sjabloon die verwijst naar de waarde van de samenvatting die zal worden weer gegeven in de winkelwagen en gedurende het betalingsproces. Als deze waarde niet wordt opgegeven, dan zal de standaardwaarde worden gebruikt. Geldige waarden zijn: {$pkg} <em>(array)</em>.  {$sku}, {$username}, {$tmpuid} <em>(de tijdelijke gebruikersid)</em>. <strong>Opmerking:</strong> sommige betalingsgateways ondersteunen enkel het gebruik van een vast aantal getallen of tekens in de samenvatting.';
$lang['prompt_cartitem_summary_tpl'] = 'Cart Item Samenvattingssjabloon';
$lang['paid_registration'] = 'Betaalde registratie';
$lang['info_skip_final_msg'] = 'Deze optie bepaald wanneer de melding dat de registratie voltooid moet worden weergegeven aan de gebruiker na de registratie';
$lang['notifications'] = 'Berichten';
$lang['info_login_afterverify'] = 'Deze optie zorgt er voor dat de gebruiker direct wordt aangemeld op de site nadat de gebruiker is gepushed naar de Fronend Users module. Deze optie heeft geen effect als u geen gebruik maakt van betaalde registraties';
$lang['info_email_confirmation'] = 'Deze optie zorgt dat een mail wordt verzonden met een link waarmee de gebruiker moet bevestigen dat de accountinformatie correct is.<br/><strong>Opmerking:</strong> Deze optie kan niet gebruikt worden als u geen gebruik maakt van betaalde registraties.';
$lang['prompt_registration_settings'] = 'Registratie instellingen';
$lang['none'] = 'Geen';
$lang['month'] = 'Maand';
$lang['year'] = 'Jaar';
$lang['subscription_expires'] = 'Aanmelding verloopt iedere';
$lang['error_policycantadd'] = 'Het beleid van deze website staat niet toe om dit item toe te voegen aan uw winkelwagentje. Neem contact op met de beheerder';
$lang['prompt_allow_select_pkg'] = 'Sta gebruikers toe een pakket (groep) te selecteren voor registratie';
$lang['info_allowselectpkg'] = 'Misschien wilt u dat gebruikers een bepaalde FEU-groep kunnen kiezen om zich toe te registreren. Deze groepen zullen worden geplaatst in pakketten (voor verkoopdoeleinden). Als u geen gebruik maakt van de verkoopmogelijkheden, dan kunt u de prijsgegevens negeren.';
$lang['error_nopkgs'] = 'Er zijn geen pakketen ingesteld waar een klant zich voor kan registreren';
$lang['selpkg_template'] = 'Selecteer pakket template';
$lang['title_selpkg_template'] = 'Selecteer inschrijvingspakket template';
$lang['info_selpkg_template'] = 'Deze template wordt gebruikt wanneer betaalde inschrijvingen zijn ingeschakeld om zo de gebruiker te kunnen laten kiezen uit verschillende inschrijvingspakketen.';
$lang['error_pkgcost'] = 'Pakketprijs is ongeldig';
$lang['error_pkgexists'] = 'Een pakket met een %s van %s bestaat al reeds';
$lang['description'] = 'Omschrijving';
$lang['edit_paidpkg'] = 'Wijzig betaalpakker &quot;%s&quot;';
$lang['add_paidpkg'] = 'Voeg betaalpakket toe';
$lang['name'] = 'Naam';
$lang['prompt'] = 'Prompt ';
$lang['group'] = 'Groep';
$lang['cost'] = 'Kosten';
$lang['regpkgs_tab'] = 'Registratiepakketen';
$lang['prompt_allow_paid_registration'] = 'Vereis dat leden moeten betalen voor registratie op uw site';
$lang['info_allow_paid_registration'] = 'Selecteer de SelfRegistration module als bronmodule voor CGEcommerceBase en configureer de &#039;betaalde registratie&#039;-tab. Eventueel kunt u een pakket in de sectie hierboven activeren.';
$lang['email-password'] = 'E-mail Adres en Wachtwoord';
$lang['username-password'] = 'Gebruikersnaam en Wachtwoord';
$lang['help_param_allowoverwrite'] = 'This parameter allows overwriting existing FEU users. In conjunction with the preferences in the SelfRegistration admin panel you can specify what data will be used to specify what data will be used to uniquely identify a user account&#039;;';
$lang['into_additionalgroups_matchfields'] = 'Benoem welke velden moeten worden gebruikt om een gebruiker te identificeren als unieke gebruiker. Dit kan gebruikt worden als een gebruiker wil registreren terwijl deze al een account heeft onder een andere gebruikersnaam.';
$lang['prompt_additionalgroups_matchfields'] = 'Wanneer een bestaande account wordt overschreven dan moeten de volgende velden overeenkomen';
$lang['prompt_reg_additionalgroups'] = 'Bestaande gebruikers toestaan om zich te registreren voor extra groepen?';
$lang['prompt_additionalgroups_settings'] = 'Extra Groep Instellingen';
$lang['prompt_general_settings'] = 'Algemene Instellingen';
$lang['prompt_security_settings'] = 'Beveiliging Instellingen';
$lang['error_uniquefield'] = 'De ingevoerde waarde &quot;%s&quot; is al in gebruik door een andere geregistreerde gebruiker';
$lang['help_param_action'] = 'This parameter dictates the behaviour of the module.
<ul>
  <li><strong>default</strong>
   <p>This is the default action.  Based on the <em>(deprecated></em> mode parameter <em>(see below)</em> it will display either the user registration form, the verify form, or another form.</li>
  </li>
  <li>register_link
   <p>Display a link to the user registration form. <em>(deprecated)</em></p>
  </li>
</ul> ';
$lang['help_param_destpage'] = 'Alleen toepasbaar in de  action=reguser_link. Met deze parameter kunt u de doel pagina voor de link instellen (alias of page_id).';
$lang['help_param_group'] = 'Toepasbaar in de action=reguser_link of action=register. Met deze parameter kunt u een groep specificeren waar de gebruiker in geregistreerd zal worden.';
$lang['help_param_onlyhref'] = 'Geldt alleen bij de action=reguser_link. Met deze parameter kunt u instellen dat alleen het url gedeelte van de link weergegeven wordt.';
$lang['help_param_linktext'] = 'Geldt alleen bij de action=reguser_link.  Hiermee kan de linktekst worden opgegeven.  Deze parameter wordt genegeerd als de onlyhref parameter gebruikt is.';
$lang['help_param_noinline'] = 'Toepasbaar voor veel actions. Deze parameter overschrijft de voorkeur in het admin panel en zorgt ervoor dat de output van een gegenereerde link of formulier niet inline wordt getoond. Bijvoorbeeld noinline=1 in combinatie met de default action zal tot gevolg hebben dat de module-output de {content} tag zal vervangen.';
$lang['help_param_nofinalmessage'] = 'Geldt alleen bij de action=default Deze parameter zorgt ervoor dat de laatste bevestigings boodschap niet weergegeven wordt.';
$lang['error_noregister'] = 'U kunt zich niet registreren als lid van deze groep';
$lang['prompt_noregister'] = 'Sta niet toe dat bezoekers zich registreren voor deze groepen';
$lang['error_nosecondemailaddress'] = 'U heeft uw e-mail adres niet twee keer ingevoerd';
$lang['push_live'] = 'Deze gebruiker direct naar FEU';
$lang['areyousure_pushuser'] = 'Weet je zeker dat je deze gebruiker naar FEU wilt duwen zonder het validatie proces te hebben afgerond?';
$lang['delete'] = 'Verwijderen';
$lang['login_afterverify'] = 'Log de gebruiker na de bevestiging stap automatisch aan';
$lang['skip_final_msg'] = 'Laatste bericht niet tonen na registratie';
$lang['redirect_afterregister'] = 'Te openen PageID/Alias na registratie';
$lang['redirect_afterverify'] = 'Te openen PageID/Alias na bevestiging';
$lang['use_inline_forms'] = 'Gebruik &quot;Inline&quot; formulieren <em>(module aanroep wordt vervangen, niet de inhoud)</em>';
$lang['error_codesdontmatch'] = 'De ingevoerde validatiesleutel is ongeldig';
$lang['event_description_onNewUser'] = 'Een tag die wordt aangeroepen als een nieuwe gebruiker het registratieformulier heeft ingevuld';
$lang['event_description_onUserRegistered'] = 'Een tag die wordt aangeroepen als een gebruiker zijn gegevens heeft gevalideerd en nu volledig is geregistreerd.';
$lang['event_help_onNewUser'] = '<p>Een gebeurtenis die wordt aangeroepen als een nieuwe gebruiker het registratieformulier heeft ingevuld</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - De geselecteerde gebruikersnaam</li>
<li><em>email</em> - Het geselecteerde emailadres</li>
</ul>
';
$lang['event_help_onUserRegistered'] = '<p>Een gebeurtenis die wordt aangeroepen als een gebruiker zijn gegevens heeft gevalideerd en nu volledig is geregistreerd.</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - De geregistreerde gebruikersnaam</li>
<li><em>id</em> - De nieuwe gebruikers uid</li>
</ul>
';
$lang['confirm_submitprefs'] = 'Wijzig beheersvoorkeuren?';
$lang['info_admin_password'] = 'Laat dit veld leeg om het gebruikerswachtwoord te behouden';
$lang['info_admin_repeatpassword'] = 'Laat dit veld leeg om het gebruikerswachtwoord te behouden';
$lang['error_emaildoesnotmatch'] = 'E-mailadressen komen niet overeen';
$lang['force_email_twice'] = 'Verplicht gebruikers om hun emailadres twee maal in te voeren';
$lang['again'] = 'opnieuw';
$lang['deleteselusers'] = 'Verwijder geselecteerde gebruikers';
$lang['error_nopropdefns'] = 'Geen eigenschapsdefinitie of een probleem om deze uit de database te halen';
$lang['error_nogroups'] = 'Geen groepen of een probleem met het ophalen van de groepenlijst';
$lang['error_dberror'] = 'Database Fout';
$lang['title_post_sendanotheremail_template'] = 'Post verloren e-mailsjabloon';
$lang['title_sendanotheremail_template'] = 'Verloren e-mailsjabloon';
$lang['clickhere'] = 'Klik hier';
$lang['msg_sendanotheremail'] = 'Ik heb het registratieformulier al ingevuld, maar heb nog geen e-mail ontvangen. Kunt u het opnieuw versturen?';
$lang['sendanotheremail_template'] = 'Verloren e-mailsjabloon';
$lang['info_userverified'] = 'Een nieuwe gebruiker is toegevoegd aan FrontEndUsers';
$lang['edit'] = 'Bewerk';
$lang['unknown'] = 'Onbekend';
$lang['select'] = 'Selecteer';
$lang['check_all'] = 'Selecteer alles';
$lang['uncheck_all'] = 'Deselecteer alles';
$lang['send_adjustmentemail'] = 'Stuur een e-mail naar de gebruiker';
$lang['txt_adjustmentemail'] = '(informeert de gebruiker dat zijn account is aangepast';
$lang['txt_changepassword'] = 'Vul deze velden in om het gebruikerswachtwoord te veranderen';
$lang['edituser'] = 'Bewerk gebruiker';
$lang['areyousure_deleteuser'] = 'Weet u zeker dat deze, deels geregistreerde gebruiker, verwijderd moet worden?';
$lang['hdr_userid'] = 'Gebruikers-ID';
$lang['hdr_username'] = 'Gebruikersnaam';
$lang['hdr_grpname'] = 'Groep';
$lang['hdr_created'] = 'Aangemaakt';
$lang['hdr_email'] = 'E-mail';
$lang['usersfound'] = 'gebruiker(s) gevonden (beperkt tot maximaal 250)';
$lang['users'] = 'Gebruikers';
$lang['list1day'] = 'Toon alle invoer van meer dan &eacute;&eacute;n dag oud';
$lang['subject'] = 'Onderwerp van uitgaande e-mail';
$lang['htmlbody'] = 'HTML tekst van de e-mail';
$lang['textbody'] = 'Platte tekst van de e-mail';
$lang['prompt_numresetrecord'] = 'Een aantal gebruikers is zich aan het registreren. Dit zijn er nu:';
$lang['remove1week'] = 'Verwijder alle invoer van meer dan een week oud';
$lang['remove1month'] = 'Verwijder alle invoer van meer dan een maand oud';
$lang['remove1day'] = 'Verwijder alle invoer van meer dan een dag oud';
$lang['removeall'] = 'Verwijder alle invoer';
$lang['areyousure'] = 'Weet u het zeker?';
$lang['registration_info_edited'] = 'Uw registratie informatie is aangepast';
$lang['registration_confirmation'] = 'Registratiebevestiging';
$lang['user_registration'] = 'Registreer';
$lang['finalmessage_template'] = 'Afrondingsboodschapsjabloon';
$lang['title_verifyregistration'] = 'Verifieer registratie';
$lang['code'] = 'Validatiesleutel';
$lang['default'] = 'Activeer standaardwaarden';
$lang['error_noproperties'] = 'Geen eigenschappen voor deze gebruiker gevonden';
$lang['error_noproprelations'] = 'Geen eigenschapsrelaties';
$lang['error_emailinvalid'] = 'Ongeldig e-mailadres';
$lang['error_noemailaddress'] = 'Geen geldig e-mailadresveld gevonden';
$lang['error_requiredfield'] = 'Veld %s moet ingevuld zijn';
$lang['registration1_template'] = 'Registratiesjabloon 1';
$lang['registration2_template'] = 'Registratiesjabloon 2';
$lang['emailconfirm_template'] = 'Bevestigingse-mail-sjabloon';
$lang['emailuseredited_template'] = 'Gebruikersinfo-sjabloon';
$lang['preferences'] = 'Voorkeuren';
$lang['error_usernotfound'] = 'Gebruiker niet gevonden';
$lang['error_invalidusername'] = 'Gebruikersnaam is ongeldig (te lang, te kort of ongeldige karakters). Tip: gebruikersnamen mogen alleen alfanumerieke karakters en geen spaties bevatten';
$lang['error_invalidemail'] = 'E-mail is niet geldig';
$lang['error_usernametaken'] = 'De gebruikersnaam is al in gebruik';
$lang['error_passwordsdontmatch'] = 'Fout: Wachtwoorden komen niet overeen';
$lang['error_invalidpassword'] = 'Wachtwoord is fout (wachtwoorden moeten tussen de %s en %s karakters lang zijn)';
$lang['error_emptyusername'] = 'Gebruikersnaam kan niet leeg zijn';
$lang['error_emptyemail'] = 'E-mail moet ingevuld worden';
$lang['repeatpassword'] = 'Wachtwoord (opnieuw)';
$lang['password'] = 'Wachtwoord';
$lang['username'] = 'Gebruikersnaam';
$lang['email'] = 'E-mail';
$lang['captcha_title'] = 'Voer de tekst uit het plaatje in';
$lang['error_insufficientparams'] = 'Onvoldoende (of incorrecte) parameters opgegeven aan de module';
$lang['error_nofeusersmodule'] = 'Kon geen verbinding met de FrontEndUsers-module krijgen';
$lang['error_nosuchgroup'] = 'Opgegevens groepsnaam bestaat niet';
$lang['error_captchamismatch'] = 'De tekst uit het plaatje is niet goed ingevoerd';
$lang['send_emails_to'] = 'Registratie e-mail moet verstuurd worden aan';
$lang['require_email_confirmation'] = 'Verplicht de gebruiker om de registratie te bevestigen via e-mail';
$lang['notify_on_registration'] = 'Stuur een e-mailbevestiging als iemand zich registreert';
$lang['cancel'] = 'Annuleer';
$lang['submit'] = 'Verstuur';
$lang['friendlyname'] = 'Self Registration-module';
$lang['postinstall'] = 'De installatie is afgerond. Vergeet niet om de rechten van &quot;Modify SelfRegistration Settings&quot; in te stellen. Als de Captcha module ge&iuml;nstalleerd is, dan staat deze functionaliteit standaard aan. We raden u sterk aan om deze module te installeren. Als de Captcha module ge&iuml;nstalleerd is en u wilt deze uitschakelen, gebruik dan de nocaptcha parameter in de selfregistration tag';
$lang['postuninstall'] = 'De Self Registration-module is ge&iuml;nstalleerd';
$lang['uninstalled'] = 'Module gedeinstalleerd';
$lang['installed'] = 'Moduleversie %s ge&iuml;nstalleerd.';
$lang['prefsupdated'] = 'Modulevoorkeuren ge&uuml;pdate.';
$lang['accessdenied'] = 'Toegang geweigerd. Controleer uw rechten.';
$lang['error'] = 'Fout!';
$lang['upgraded'] = 'Module opgewaardeerd naar versie %s.';
$lang['title_mod_prefs'] = 'Modulevoorkeuren';
$lang['title_mod_admin'] = 'Modulebeheerpaneel';
$lang['title_admin_panel'] = 'Self Registration-module';
$lang['moddescription'] = 'Een module die het FrontEnd gebruikers mogelijk maakt zichzelf te registreren.';
$lang['welcome_text'] = '<p>Welkom bij de Self Registration-module.</p>';
$lang['enable_whitelist'] = 'Activeer Whitelist';
$lang['whitelist'] = 'Lijst met whitelist gebruikersnaam/email. E&eacute;n per regel. (gebruik * voor wildcards)';
$lang['whitelist_trigger_message'] = 'Bericht om weer te geven of een whitelist regel is uitgevoerd';
$lang['dont_use'] = 'Geen Whitelist';
$lang['no_matches'] = 'Sta niet toe dat overeenkomende gebruikersnaam/e-mail zich registreren';
$lang['only_matches'] = 'Laat alleen overeenkomende gebruikersnaam/e-mail zich registreren';
$lang['utma'] = '156861353.1652442735.1375624076.1375624076.1375624076.1';
$lang['utmz'] = '156861353.1375624076.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>