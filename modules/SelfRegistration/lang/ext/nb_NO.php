<?php
$lang['error_novalidgroups'] = 'Fant ingen gyldige grupper';
$lang['multiplegroups'] = 'Flere grupper';
$lang['singlegroup'] = 'En gruppe';
$lang['no'] = 'Nei';
$lang['error_multiplepkgs'] = 'Du valgte flere pakker, velg kun en.';
$lang['error_missingcode'] = 'Registrerings valideringskoden mangler';
$lang['error_missingemail'] = 'E-postadresse mangler';
$lang['eventhandlers_added'] = 'Hendelses behandler lagt til';
$lang['preferences_updated'] = 'Instillinger oppdatert';
$lang['setup_cart_events'] = 'Sett opp handlekurv hendelser';
$lang['setup'] = 'Oppsett';
$lang['info_setup_cart_events'] = 'Noen ganger, n&aring;r man oppgraderer fra en eldre versjon, blir ikke handlekurv hendelser lagt til. Trykk p&aring; denne knappen for &aring; sikre at de blir. Dette er viktig hvis man benytter betalte registrasjoner.';
$lang['info_force_email_twice'] = 'N&aring;r denne funksjoner er aktivert, m&aring; brukeren skrive inn brukernavnet (eller epost adressen) to ganger. Disse to vil s&aring; bli sjekket mot hverandre.';
$lang['prompt_redirect_paidpkg'] = 'Side ID/Alias &aring; omdirigere til for betalte pakker';
$lang['info_redirect_paidpkg'] = 'En smartymal som bestemmer pageid eller alias for en side som det skal omdirigeres til for betalte pakker. Typisk s&aring; vil en bruker som registrerer seg p&aring; nettstedet ville &aring; g&aring; direkte til kassesiden, eller til vis handlevogn siden.';
$lang['info_additionalgroups_matchfields'] = 'N&aring;r det tillates at eksisterende brukere kan registrere seg til en ekstra gruppe, kan du angi hvilke FEU egenskapene for den eksisterende brukeren som m&aring; samsvare n&aring;r brukeren registrerer seg igjen. Denne informasjonen vil bli brukt til &aring; identifisere FEU brukerkontoen';
$lang['info_cartitem_summary_tpl'] = 'En smartymal som bestemmer verdien av sammendraget som vises med denne linjeenheten i handlekurven, og i l&oslash;pet av betalingsprosessen. Om ingen verdi er spesifisert vil en standardverdi brukes. Gyldige smarty-variabler er ($pkg) <em> (matrise/erray) </ em>. ($sku), ($username), ($tmpuid) <em> (brukernes midlertidige bruker-ID) </ em>. <strong> Merk: </ strong> noen betalingsl&oslash;sninger kan bare st&oslash;tte et fast antall tegn for sammendraget.';
$lang['prompt_cartitem_summary_tpl'] = 'Handlekurv-enhet sammendragsmal';
$lang['paid_registration'] = 'Betalt Registrering';
$lang['info_skip_final_msg'] = 'Dette alternativet avgj&oslash;r om registreringens hele melding skal vises til brukeren etter registrering.';
$lang['notifications'] = 'Merknader';
$lang['info_login_afterverify'] = 'Dette alternativet vil automatisk logge brukeren inn p&aring; omr&aring;det etter at brukeren har blitt skj&oslash;vet til Frontend Brukere modulen. Dette alternativet har ingen virkning om betalt p&aring;melding er tillatt';
$lang['info_email_confirmation'] = 'Dette alternativet sender en e-post til den registrerte brukerkontoen med en lenke som tillater bekreftelse p&aring; at kontoinformasjonen er er oppgitt er gyldig.<br/><strong> Merk: </ strong> Dette valget skal ikke benyttes n&aring;r betalt registrering er tillatt';
$lang['prompt_registration_settings'] = 'Registreringsinnstillinger';
$lang['none'] = 'Ingen';
$lang['month'] = 'M&aring;ned';
$lang['year'] = '&Aring;r';
$lang['subscription_expires'] = 'Abonnement fornyer hver';
$lang['error_policycantadd'] = 'Politikken p&aring; dette nettstedet ikke tillater &aring; legge dette produktet i handlekurven. Vennligst kontakt administratoren av nettstedet';
$lang['prompt_allow_select_pkg'] = 'Tillat brukere &aring; velge en pakke (gruppe) &aring; registrere seg til';
$lang['info_allowselectpkg'] = 'Du kanskje &oslash;nsker &aring; tillate dine brukere &aring; velge en FEU gruppe &aring; registrere seg til. Disse gruppene er knyttet til pakker (for e-handel form&aring;l). Men dersom ikke benytter e-handel funksjonaliteten, kan prisdataene ignoreres';
$lang['error_nopkgs'] = 'Ingen pakker har blitt definert for &aring; tillate kunden &aring; registrere seg til';
$lang['selpkg_template'] = 'Velg en Pakkemal';
$lang['title_selpkg_template'] = 'Velg Abonnementpakkemal';
$lang['info_selpkg_template'] = 'Denne malen benyttes n&aring;r betalte abonnementer er aktivert for &aring; tillate brukeren &aring; velge en betalt abonnementpakke';
$lang['error_pkgcost'] = 'Pakkekostnad er ugyldig';
$lang['error_pkgexists'] = 'En pakke med en %s av %s eksisterer allerede';
$lang['description'] = 'Beskrivelse';
$lang['edit_paidpkg'] = 'Rediger Betalt-pakke &quot;%s&quot;';
$lang['add_paidpkg'] = 'Legg til Betalt-pakke';
$lang['name'] = 'Navn';
$lang['prompt'] = 'Sp&oslash;r';
$lang['group'] = 'Gruppe';
$lang['cost'] = 'Kostnad';
$lang['regpkgs_tab'] = 'Registreringspakker';
$lang['prompt_allow_paid_registration'] = 'Krev at medlemmer m&aring; betale for registrering p&aring; webomr&aring;det ditt';
$lang['info_allow_paid_registration'] = 'Vennligst velg ogs&aring; Selfregistration som en kildemodul fra CGEcommerceBase, og konfigurer &quot;Betalt Registrering&quot; (Paid Registration) fanen. I tillegg m&aring; du aktivere pakkevalg ovenfor.';
$lang['email-password'] = 'E-postadresse og passord';
$lang['username-password'] = 'Brukernavn og passord';
$lang['help_param_allowoverwrite'] = 'Denne parameteren tillater overskriving av eksisterende FEU-brukere. I forbindelse med preferanser i SelfRegistration administrasjonspanelet kan du angi hvilke data som skal brukes til &aring; identifisere en brukerkonto';
$lang['into_additionalgroups_matchfields'] = 'Spesifiser hvilke felter som eksplisitt skal identifisere en bruker. Dette kan benyttes for &aring; tillate en bruker &aring; registrere seg n&aring;r en konto allerede eksisterer for den brukeren med et annet brukernavn.';
$lang['prompt_additionalgroups_matchfields'] = 'Ved overskriving av en eksisterende konto s&aring; m&aring; f&oslash;lgende felter v&aelig;re like';
$lang['prompt_reg_additionalgroups'] = 'Tillat eksisterende brukere &aring; registrere for ekstra grupper?';
$lang['prompt_additionalgroups_settings'] = 'Ekstra gruppe innstillinger';
$lang['prompt_general_settings'] = 'Generelle innstillinger';
$lang['prompt_security_settings'] = 'Sikkerhetsinnstillinger';
$lang['error_uniquefield'] = 'Verdien benyttet for &quot;%s&quot; er allerede benyttet av en annen registrert bruker';
$lang['help_param_action'] = 'Denne parameteren dikterer oppf&oslash;rselen til modulen.
<ul>
  <li><strong>default</strong>
   <p>Dette er standard handlingen. Basert p&aring; den<em>(utg&aring;ende)</em> mode parameteren <em>(se nedenfor)</em> Dette vil vise enten brukerregistreringskjema, bekreftelseskjema eller et annet skjema.</li>
  </li>
  <li>reguser_link
   <p>Vis en lenke til brukerregistreringskjemaet.</p>
  </li>
</ul>';
$lang['help_param_destpage'] = 'Gyldig kun for action=reguser_link. Denne parameteren tillater &aring; spesifisere (etter alias eller page id) en m&aring;lside for lenken.';
$lang['help_param_group'] = 'Gyldig for action=reguser_link eller action=register. Denne parameter tillater &aring; spesifisere en gruppe som brukeren vil bli registrert i';
$lang['help_param_onlyhref'] = 'Benyttet kun i action=reguser_link. Ved &aring; sette denne parameteren s&aring; indikerer det at utdata skal inneholde kun url delen av lenken';
$lang['help_param_linktext'] = 'Benyttet kun i action_reguser_link hvor den tillater &aring; spesifisere teksten for den genererte lenken. Denne parameter blir ingnorert om onlyhref parameteren er spesifisert.';
$lang['help_param_noinline'] = 'Gjelder mange handlinger. Denne parameteren overstyrer preferansen i admin-panelet for &aring; indikere at utdata fra de genererte linker eller skjemaer ikke skal vises inline. ie: noinline = 1   p&aring; standard handlingen vil indikere at utdata teksten vil erstatte (content) taggen.';
$lang['help_param_nofinalmessage'] = 'Gjelder bare for standard, signup handling. Denne parameteren tillater &aring; indikere at den endelige registrerings bekreftelsesmeldingen ikke skal vises';
$lang['error_noregister'] = 'Du f&aring;r ikke registrere deg for &aring; bli medlem av dennne gruppen';
$lang['prompt_noregister'] = 'Absolutt forby brukere &aring; registrere seg til disse gruppene';
$lang['error_nosecondemailaddress'] = 'Du skrev ikke inn din e-postadresse to ganger';
$lang['push_live'] = 'Overf&oslash;r denne brukeren til FEU';
$lang['areyousure_pushuser'] = 'Er du sikker p&aring; at du vil overf&oslash;re denne brukere til FEU uten &aring; fullf&oslash;re valideringsprosessen?';
$lang['delete'] = 'Slett';
$lang['login_afterverify'] = 'Logg brukeren automatisk inn i FrontEndUsers etter at verifikasjonstrinnet er fullf&oslash;rt';
$lang['skip_final_msg'] = 'Ikke vis bekreftelsesmeldingen etter registrering';
$lang['redirect_afterregister'] = 'PageID/Alias &aring; videresende til etter registreringen er ferdig';
$lang['redirect_afterverify'] = 'PageID/Alias &aring; videresende til etter verifiseringen er fullf&oslash;rt';
$lang['use_inline_forms'] = 'Benytt Inline skjemaer <em>(skjema utdata erstatter modultaggen og ikke alt innholdet)</em>';
$lang['error_codesdontmatch'] = 'Validerings n&oslash;kkelen som er oppgitt er ugyldig';
$lang['event_description_onNewUser'] = 'En hendelse som indikerer at en ny bruker har fylt ut registreringsskjemaet';
$lang['event_description_onUserRegistered'] = 'En Hendelse som indikerer at en bruker har bekreftet sin informasjon og er n&aring; fullt registrert';
$lang['event_help_onNewUser'] = '<p>En Hendelse som indikerer at en ny bruker har fullf&oslash;rt registreringsskjemaet</p>
<h4>Innstillinger</h4>
<ul>
<li><em>brukernavn</em> - Den nye brukerens valgte brukernavn</li>
<li><em>email</em> - Den nye brukerens e-postadresse</li>
</ul>
';
$lang['event_help_onUserRegistered'] = '<p>En Hendelse som indikerer at en bruker har blitt bekreftet og er n&aring; registrert p&aring; feusers</p>
<h4>Innstillinger</h4>
<ul>
<li><em>brukernavn</em> - Det registrerte brukernavn</li>
<li><em>id</em> - Den nye brukers uid</li>
</ul>
';
$lang['confirm_submitprefs'] = 'Forandre admin preferanser?';
$lang['info_admin_password'] = 'La dette feltet v&aelig;re tomt for &aring; beholde brukerpassordet';
$lang['info_admin_repeatpassword'] = 'La dette feltet v&aelig;re tomt for &aring; beholde brukerpassordet';
$lang['error_emaildoesnotmatch'] = 'E-postadressene er ikke like';
$lang['force_email_twice'] = 'Tvinger brukerne til &aring; taste inn e-postadressen sin to ganger';
$lang['again'] = 'igjen';
$lang['deleteselusers'] = 'Slett valgte brukere';
$lang['error_nopropdefns'] = 'Ingen felt definisjoner, eller problem med &aring; hente dem fra databasen';
$lang['error_nogroups'] = 'Ingen grupper funnet, eller problemer med &aring; lese gruppelisten';
$lang['error_dberror'] = 'Databasefeil';
$lang['title_post_sendanotheremail_template'] = 'Mal for Etter tapt e-post';
$lang['title_sendanotheremail_template'] = 'Mal for Tapt e-post';
$lang['clickhere'] = 'Klikk her';
$lang['msg_sendanotheremail'] = 'Jeg har allerede fullf&oslash;rt registreringsskjemaet, men mottok ikke noen e-post. Kan dere vennligst sende p&aring; nytt';
$lang['sendanotheremail_template'] = 'Mal for Mistet passord';
$lang['info_userverified'] = 'En ny bruker er lagt til i FrontEndUsers';
$lang['edit'] = 'Rediger';
$lang['unknown'] = 'Ukjent';
$lang['select'] = 'Velg';
$lang['check_all'] = 'Velg alle';
$lang['uncheck_all'] = 'Velg ingen';
$lang['send_adjustmentemail'] = 'Send e-post til brukeren';
$lang['txt_adjustmentemail'] = '(informerer brukeren om at kontoen har blitt justert';
$lang['txt_changepassword'] = 'Fyll ut disse feltene for &aring; forandre brukerpassordet';
$lang['edituser'] = 'Rediger bruker';
$lang['areyousure_deleteuser'] = 'Er du sikker p&aring; at du vil slette denne delvis registrerte brukeren?';
$lang['hdr_userid'] = 'BrukerID';
$lang['hdr_username'] = 'Brukernavn';
$lang['hdr_grpname'] = 'Gruppe';
$lang['hdr_created'] = 'Opprettet';
$lang['hdr_email'] = 'E-post';
$lang['usersfound'] = 'Brukere funnet <em>(Et maksimum p&aring; 250 vil vises, selv om fler kan finnes i databasen.)</em>';
$lang['users'] = 'Brukere';
$lang['list1day'] = 'List alle innlegg mer enn 1 dag gamle';
$lang['subject'] = 'Emne for utg&aring;ende e-post';
$lang['htmlbody'] = 'HTML meldings-kropp';
$lang['textbody'] = 'Text meldings-kropp';
$lang['prompt_numresetrecord'] = 'Antall brukerer midt i registreringen:';
$lang['remove1week'] = 'Fjern alle innlegg mer enn en uke gamle';
$lang['remove1month'] = 'Fjern alle innlegg mer enn en m&aring;ned gamle';
$lang['remove1day'] = 'Fjern alle innlegg mer enn en dag gamle';
$lang['removeall'] = 'Fjern alle innlegg';
$lang['areyousure'] = 'Er du sikker?';
$lang['registration_info_edited'] = 'Dine registreringsdata har blitt endret';
$lang['registration_confirmation'] = 'Bekreftelse p&aring; registrering';
$lang['user_registration'] = 'Registrer';
$lang['finalmessage_template'] = 'Mal for avsluttende melding';
$lang['title_verifyregistration'] = 'Bekreft registrering';
$lang['code'] = 'Koden&oslash;kkel (Validation Key)';
$lang['default'] = 'Tilbakestill til standard';
$lang['error_noproperties'] = 'Ingen egenskaper funnet for denne brukeren';
$lang['error_noproprelations'] = 'Ingen egenskap relasjoner';
$lang['error_emailinvalid'] = 'Ugyldig e-postadresse';
$lang['error_noemailaddress'] = 'Ingen gyldig emailadresse felt funnet';
$lang['error_requiredfield'] = 'Feltet %s m&aring; fylles ut';
$lang['registration1_template'] = 'Registreringsmal 1';
$lang['registration2_template'] = 'Registreringsmal 2';
$lang['emailconfirm_template'] = 'Mal for bekreftelses e-post';
$lang['emailuseredited_template'] = 'Mal for bruker-info forandret';
$lang['preferences'] = 'Preferanser';
$lang['error_usernotfound'] = 'Bruker ikke funnet';
$lang['error_invalidusername'] = 'Brukernavnet er ugyldig (for langt, for kort, eller inneholder ugyldige tegn).  Hint- Brukernavn m&aring; inneholde kun alfanumeriske tegn (ingen mellomrom)';
$lang['error_invalidemail'] = 'E-post er ugyldig.';
$lang['error_usernametaken'] = 'Det brukernavnet er allerede i bruk';
$lang['error_passwordsdontmatch'] = 'FEIL: passordene er ikke like';
$lang['error_invalidpassword'] = 'Passordet er ugyldig (passord m&aring; v&aelig;re mellom %s og %s karakterer i lengde)';
$lang['error_emptyusername'] = 'Brukernavnet kan ikke v&aelig;re blankt';
$lang['error_emptyemail'] = 'E-post kan ikke v&aelig;re tomt';
$lang['repeatpassword'] = 'Passord (igjen)';
$lang['password'] = 'Passord';
$lang['username'] = 'Brukernavn';
$lang['email'] = 'E-post';
$lang['captcha_title'] = 'Oppgi teksten fra bildet';
$lang['error_insufficientparams'] = 'Ugyldig nummer (eller feil) parametere gitt til modulen';
$lang['error_nofeusersmodule'] = 'Fant ikke FrontEndUsers modulen';
$lang['error_nosuchgroup'] = 'Oppgitt gruppenavn eksisterer ikke';
$lang['error_captchamismatch'] = 'Teksten fra bildet ble ikke skrevet riktig';
$lang['send_emails_to'] = 'Registrerings e-poster skal sendes til';
$lang['require_email_confirmation'] = 'Krev at brukeren m&aring; bekrefte registreringen via e-post';
$lang['notify_on_registration'] = 'Send en e-post melding n&aring;r noen registrerer seg';
$lang['cancel'] = 'Avbryt';
$lang['submit'] = 'Registrer';
$lang['friendlyname'] = 'Selv-registrerings modul';
$lang['postinstall'] = 'Installasjon vellykket, husk &aring; sette &quot;Modify SelfRegistration Settings&quot; rettigheten. 
Om Captcha modulen er installert, s&aring; vil captcha funksjonen bli sl&aring;tt p&aring; som standard. Vi anbefaler p&aring; det sterkeste at du installerer denne modulen. Om Captcha modulen er installert og du ikke vil benytte dette, bruker du parameteren nocaptcha i din selv-registrerings tagg.';
$lang['postuninstall'] = 'Selvregistrerings Modulen er avinstallert.';
$lang['uninstalled'] = 'Modulen avinstallert.';
$lang['installed'] = 'Modul versjon %s installert.';
$lang['prefsupdated'] = 'Modul innstillinger oppdatert.';
$lang['accessdenied'] = 'Adgang nektet. Vennligst sjekk dine rettigheter.';
$lang['error'] = 'Feil!';
$lang['upgraded'] = 'Modul oppgradert til versjon %s.';
$lang['title_mod_prefs'] = 'Modul innstillnger';
$lang['title_mod_admin'] = 'Modul administrasjonspanel';
$lang['title_admin_panel'] = 'Selvregistrerings Modul';
$lang['moddescription'] = 'En modul som tillater front-end brukere &aring; registrere seg selv.';
$lang['welcome_text'] = '<p>Velkommen til Selvregistrerings modulen.</p>';
$lang['enable_whitelist'] = 'Sl&aring; hvitlisting';
$lang['whitelist'] = 'Liste med hvitelistede brukernavn/e-poster. En per linje. (benytt * for wildcards)';
$lang['whitelist_trigger_message'] = 'Melding &aring; vise om en hviteliste regel er aktivert';
$lang['dont_use'] = 'Ingen hviteliste';
$lang['no_matches'] = 'Ikke tillat passende brukernav/e-poster &aring; registrere seg';
$lang['only_matches'] = 'Kun tillat passende brukernav/e-poster &aring; registrere seg';
$lang['utma'] = '156861353.1689806108.1377521044.1377521044.1377672637.2';
$lang['utmz'] = '156861353.1377521044.1.1.utmcsr=dev.cmsmadesimple.org|utmccn=(referral)|utmcmd=referral|utmcct=/project/files/1068';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>