<?php
$lang['info_cookiename'] = 'Om satt, &quot;husk meg&quot; funksjonaliteten vill bli aktivert. Dette er tilsvarer cookie hold i live funksjonen, men varer opp til ett &aring;r.';
$lang['msg_username_readonly'] = 'Autentiserings forbrukeren tillater ikke endring av brukernavnet for denne kontoen';
$lang['msg_password_readonly'] = 'Autentiserings forbrukeren tillater ikke endring av passordet for denne kontoen';
$lang['prompt_normallogin'] = 'Direkte innlogging';
$lang['move_up'] = 'flytt opp';
$lang['move_down'] = 'flytt ned';
$lang['title_propmodule'] = 'Denne egenskapen er opprettet av en modul, og kan ikke redigeres';
$lang['not_available'] = 'Ikke tilgjengelig';
$lang['prompt_dflt_checked'] = 'Som standard, b&oslash;r dette feltet v&aelig;re avkrysset';
$lang['operation_completed'] = 'Handling fullf&oslash;rt';
$lang['members'] = 'Medlemmer';
$lang['view_filter'] = 'Vis filter';
$lang['data'] = 'Data ';
$lang['applied'] = 'Brukt';
$lang['firstpage'] = '<<';
$lang['prevpage'] = '<';
$lang['nextpage'] = '>';
$lang['lastpage'] = '>>';
$lang['page'] = 'Side';
$lang['prompt_allow_changeusername'] = 'Tillat &aring; endre brukernavn';
$lang['info_allow_changeusername'] = 'Om aktivert, s&aring; vil brukere tillates &aring; endre sitt brukernavn og andre innstillinger';
$lang['template_saved'] = 'Mal lagret';
$lang['template_resetdefaults'] = 'Mal tilbakestilt til standard';
$lang['lbl_settings'] = 'Innstillinger';
$lang['lbl_templates'] = 'Maler';
$lang['enable_captcha'] = 'Aktiver captcha p&aring; innloggingskjemaet';
$lang['info_enable_captcha'] = 'Hvis brukeren ikke er logget inn, og modulens preferanser er satt til &aring; vise innloggingskjema, styrer dette alternativet om en captcha vises p&aring; innloggingskjemaet.     Hvis captcha er tilgjengelig';
$lang['pagetype_unauthorized'] = 'Du er ikke autorisert til &aring; se dette innholdet';
$lang['info_contentpage_grouplist'] = 'Angi en liste over FEU-grupper som kan ha tilgang til denne siden. Ved &aring; ikke velge noen grupper s&aring; vil enhver bruker som er logget inn med FEU f&aring; tillatelse til &aring; se siden';
$lang['pagetype_settings'] = 'Innstillinger for Beskyttede sider';
$lang['pagetype_groups'] = 'Tillatte grupper';
$lang['info_pagetype_groups'] = 'Velg grupper som har (som standard) lov til &aring; vise beskyttede sider. En redakt&oslash;r med &quot;Behandle alt Innhold&quot;-tillatelse kan overstyre dette for hver side';
$lang['pagetype_action'] = 'Handling for utilstrekkelig tilgang';
$lang['info_pagetype_action'] = 'Angi atferd for personer som &aring;pner denne siden uten tilstrekkelig tillatelse. Du kan enten omdirigere til en bestemt side, eller vise innloggingskjemaet';
$lang['showloginform'] = 'Vis innloggingskjema';
$lang['redirect'] = 'Omdiriger til en side';
$lang['pagetype_redirectto'] = 'Omdiriger til';
$lang['info_pagetype_redirectto'] = 'Angi siden &aring; omdirigere til. Hvis du velger Ingen, og handlingen er satt til &quot;omdirigere til en side&quot; s&aring; vil brukeren bli presentert med en melding som indikerer at de ikke har tilgang til siden';
$lang['permissions'] = 'Tillatelser';
$lang['feu_protected_page'] = 'Beskyttet innhold';
$lang['prompt_viewprops'] = 'Velg ekstra egenskaper som skal vises';
$lang['view'] = 'Vis';
$lang['info_ignore_userid'] = 'Om valgt s&aring; vil importrutinen fors&oslash;ke &aring; legge til brukere uavhengig av brukerid kolonnen. Hvis en bruker eksisterer allerede med navnet som er angitt i importfilen, vil en feilmelding bli generert';
$lang['ignore_userid'] = 'Ignorer UserID kolonnen ved import';
$lang['export_passhash'] = 'Eksporter passord hash til filen';
$lang['info_export_passhash'] = 'Passordet hash er bare nyttig hvis passord salt p&aring; import-verten er identisk med eksport-verten';
$lang['error_adjustsalt'] = 'Passord salt kan ikke endres';
$lang['prompt_pwsalt'] = 'Passord salt';
$lang['info_pwsalt'] = 'FrontEndUsers salter alle passord med denne n&oslash;kkelen som er opprettet ved installasjon. N&aring;r brukerne har blitt lagt til databasen s&aring; kan salt ikke endres. Saltet kan v&aelig;re tomt for eldre installasjoner.';
$lang['advanced_settings'] = 'Avanserte innstillinger';
$lang['info_sessiontimeout'] = 'Angi antall sekunder f&oslash;r en inaktiv bruker automatisk blir logget ut av nettstedet';
$lang['prompt_expireusers_interval'] = 'Bruker utl&oslash;ps intervall';
$lang['info_expireusers_interval'] = 'Angi en verdi (i sekunder) som viser hvor ofte systemet skal tvinge brukere hvor sesjonen har utl&oslash;pt &aring; bli logget ut. Dette er en optimalisering for &aring; lagre databasesp&oslash;rringer. Dersom satt tomt eller satt til 0 - utl&oslash;p vil bli utf&oslash;rt p&aring; hver foresp&oslash;rsel.';
$lang['msg_settingschanged'] = 'Dine innstillinger ble vellykket lagret';
$lang['forcedlogouttask_desc'] = 'Tving brukere til &aring; logge ut p&aring; gitte intervaller';
$lang['prompt_forcelogout_times'] = 'Tider for tvunget utlogging';
$lang['info_forcelogout_times'] = 'Angi en kommaseparert liste med tider som HH:MM,HH:MM hvor brukerne vil bli tvangs utlogget. Merk, bruker dette psuedocron mekanismen s&aring; du m&aring; v&aelig;re sikker p&aring; at de tidene oppgitt her vil falle rimelig sammen med &quot;pseudocron granularitet&quot; og at nok foresp&oslash;rsler vil oppst&aring; til ditt nettsted for &aring; sikre at pseudocron utf&oslash;res.';
$lang['prompt_forcelogout_sessionage'] = 'Ekskludere brukere som har v&aelig;rt aktive i <em>(minutter)</em>';
$lang['info_forcelogout_sessionage'] = 'Hvis spesifisert, vil alle brukere som har v&aelig;rt aktive i dette antallet sekunder ikke bli tvangs utlogget';
$lang['areyousure_delete'] = 'Er du sikker p&aring; at du vil slette brukeren %s';
$lang['error_invalidfileextension'] = 'Den opplastede filen passer ikke til listen med tillatte filtyper';
$lang['postuninstall'] = 'Alle data assosiert med FrontEndUsers modulen har blitt slettet';
$lang['info_ecomm_paidregistration'] = 'Om sl&aring;tt p&aring;, s&aring; vil denne modulen lytte p&aring; handlinger fra Ecommerce suiten. De f&oslash;lgende innstillingene har kun effekt om denne innstillingen er p&aring;sl&aring;tt.';
$lang['prompt_ecomm_paidregistration'] = 'Lytt p&aring; Order handlinger';
$lang['info_paidreg_settings'] = 'De f&oslash;lgende innstillingene gjelder bare hvis du bruker Selvregistrering(Self Registration) og tillater Betalt p&aring;melding';
$lang['none'] = 'Ingen';
$lang['delete_user'] = 'Slett bruker';
$lang['expire_user'] = 'Tidsutl&oslash;p bruker';
$lang['prompt_action_ordercancelled'] = 'Handling &aring; utf&oslash;re n&aring;r en abonnementbestilling er kansellert';
$lang['prompt_action_orderdeleted'] = 'Handling &aring; utf&oslash;re n&aring;r en abonnementordre er slettet';
$lang['ecommerce_settings'] = 'Ecommerce innstillinger';
$lang['securefieldmarker'] = 'Sikkert felt mark&oslash;r';
$lang['securefieldcolor'] = 'Sikkert felt farge';
$lang['prompt_encrypt'] = 'Lagre disse data kryptert i databasen';
$lang['error_notsupported'] = 'Den valgte opsjonen er ikke st&oslash;ttet med din n&aring;v&aelig;rende konfigurasjon';
$lang['audit_user_created'] = 'Bruker automatisk opprettet';
$lang['info_auto_create_unknown'] = 'Om en bruker er identifisert av en ekstern identifikasjonsmodul, men ikke er kjent i FrontEndUsers modulen - skal da en FEU-konto opprettes automatisk?';
$lang['prompt_auto_create_unknown'] = 'Opprett automatisk ukjente brukere';
$lang['display_settings'] = 'Visningsinnstillinger';
$lang['info_std_auth_settings'] = 'Den f&oslash;lgende innstillingen er kun gyldig om &quot;Innebygd identifikasjon&quot; er benyttet.';
$lang['info_support_lostun'] = '&Aring; velge Nei vi sl&aring; av muligheten for en bruker til &aring; be om glemt innloggingsinformasjon, uavhengig av andre innstillinger';
$lang['info_support_lostpw'] = '&Aring; velge Nei vil sl&aring; av muligheten for en bruker til &aring; be om tilbakestilling av passord, uavhengig av andre innstillinger';
$lang['prompt_support_lostun'] = 'Tillat brukere &aring; be om sitt brukernavn';
$lang['prompt_support_lostpw'] = 'Tillat brukere &aring; be om passordendring';
$lang['auth_settings'] = 'Identifikasjonsinnstillinger';
$lang['authentication'] = 'Innebygd identifikasjon';
$lang['auth_builtin'] = 'FEU Standard identifikasjon';
$lang['auth_module'] = 'Identifikasjonsmodul/metode';
$lang['info_auth_module'] = 'FrontendUsers modulen st&oslash;tter st&oslash;tter bruk alternative metoder for identifikasjon, med varierende funksjoner. Noe funksjonalitet vil ikke fungere eller vil v&aelig;re deaktivert n&aring;r ikke den innebygde identifikasjonsmetode er i bruk';
$lang['error_user_nonunique_field_value'] = 'Verdien oppgitt for %s er allerede i bruk av en annen bruker';
$lang['unique'] = 'Unik';
$lang['error_nonunique_field_value'] = 'Verdien som er oppgitt for %s (%s) er ikke unik';
$lang['prompt_force_unique'] = 'Tving verdier for denne egenskapen til &aring; unik p&aring; tvers av alle kontoer';
$lang['help_returnlast'] = 'Om benyttet med innlogging- og utlogging-skjemaene vil denne parameter, om den er spesifisert, indikere at brukeren skal sendes tilbake til siden (etter url) som brukeren var p&aring; f&oslash;r handlingen hendte. Denne parameter vil overstyre omdirigering preferansene, og returnto parameteren.';
$lang['help_noinline'] = 'Benyttet med en av skjemaene, denne parameter spesifiserer at skjemaene ikke skal plasseres inline. Istedet skal de resulterende utdataene etter innsending av skjemaet erstatte standard innholdsblokken';
$lang['title_reset_session'] = 'Innloggings sessionstidsutl&oslash;psadvarsel';
$lang['msg_reset_session'] = 'Din innloggingsession er i ferd med &aring; utl&oslash;pe, vennligst klikk  OK  for &aring; bekrefte din tilstedev&aelig;relse p&aring; dette nettstedet.';
$lang['ok'] = 'OK';
$lang['resetsession_template'] = 'Tilbakestill sessionsmalen';
$lang['info_name'] = 'Dette er feltnavnet, som skal benyttes for adressering i smarty. Det m&aring; best&aring; av kun alfanummeriske bokstaver og understreker.';
$lang['visitors_tab'] = 'Bes&oslash;kere';
$lang['feu_groups_prompt'] = 'Velg en eller flere FEU-grupper som er tillatt &aring; se denne siden';
$lang['error_mustselect_group'] = 'En gruppe m&aring; velges';
$lang['selectone'] = 'Velg en';
$lang['start_year'] = 'Start&aring;r';
$lang['end_year'] = 'Slutt&aring;r';
$lang['date'] = 'Dato';
$lang['prompt_thumbnail_size'] = 'Miniatyrbildest&oslash;rrelse';
$lang['OnUpdateGroup'] = 'Ved endring av Brukergruppe(User Group)';
$lang['error_toomanyselected'] = 'For mange brukere ble valgt for masse-handlinger.... Vennligst reduser ned til 250 eller mindre';
$lang['confirm_delete_selected'] = 'Er du sikker p&aring; at du vil slette de valgte brukerne?';
$lang['delete_selected'] = 'Sletting valgt';
$lang['prompt_randomusername'] = 'Generer et tilfeldig brukenavn ved opprettelse av nye brukere';
$lang['months'] = 'm&aring;neder';
$lang['prompt_expireage'] = 'Standard bruker utl&oslash;pstid';
$lang['notification_settings'] = 'Varsling innstillinger';
$lang['property_settings'] = 'Egenskap innstillinger';
$lang['redirection_settings'] = 'Omdirigering innstillinger';
$lang['general_settings'] = 'Generelle innstillinger';
$lang['session_settings'] = 'Session og cookie innstillinger';
$lang['field_settings'] = 'Felt innstillinger';
$lang['error_lostun_nonrequired'] = 'Lostusername(Glemt Brukernavn) flagget kan kun benyttes p&aring;krevde felter';
$lang['prop_textarea_wysiwyg'] = 'Tillat bruk av wysiwyg p&aring; dette tekstomr&aring;det';
$lang['editing_user'] = 'Rediger bruker';
$lang['noinline'] = 'Ikke bruk skjema som inline';
$lang['info_lostun'] = 'Klikk her om du ikke kan huske dine innloggingsdetaljer';
$lang['info_forgotpw'] = 'Klikk her om du ikke kan huske ditt passord';
$lang['info_logout'] = 'Klikk her for &aring; logge ut';
$lang['info_changesettings'] = 'Klikk her for &aring; endre ditt passord eller annen informasjon';
$lang['viewuser_template'] = 'Vis bruker mal';
$lang['event'] = 'Hendelse';
$lang['feu_event_notification'] = 'FEU Hendelse varsel';
$lang['prompt_notification_address'] = 'Varsel e-postadresse';
$lang['prompt_notification_template'] = 'Varsling E-postmal';
$lang['prompt_notification_subject'] = 'Varsling E-postemne';
$lang['prompt_notifications'] = 'E-postvarsling';
$lang['OnLogin'] = 'Ved innlogging';
$lang['OnLogout'] = 'Ved utlogging';
$lang['OnExpireUser'] = 'Ved utl&oslash;p av session';
$lang['OnCreateUser'] = 'Ved Bruker opprettet';
$lang['OnDeleteUser'] = 'Ved Bruker slettet';
$lang['OnUpdateUser'] = 'Ved endring av brukerinnstillinger';
$lang['OnCreateGroup'] = 'Ved opprettelse av brukergruppe';
$lang['OnDeleteGroup'] = 'Ved sletting av brukergruppe';
$lang['lostunconfirm_premsg'] = 'Funksjonen for mistet innloggingsdetaljer er fullf&oslash;rt. Vi har funnet et unikt brukernavn som passer til de detaljene du har oppgitt.';
$lang['your_username_is'] = 'Ditt brukernavn er';
$lang['lostunconfirm_postmsg'] = 'Vi anbefaler at du tar vare p&aring; denne informasjonen p&aring; en sikker, men tilgjengelig plass.';
$lang['prompt_after_change_settings'] = 'PageID/Alias &aring; hoppe til etter endring av innstillinger';
$lang['prompt_after_verify_code'] = 'PageID/Alias &aring; hoppe til etter kode bekreftelse *';
$lang['lostun_details_template'] = 'Glemt Brukernavn detaljmal';
$lang['lostun_confirm_template'] = 'Glemt Brukernavn bekreftelsesmal';
$lang['error_nonuniquematch'] = 'Feil: Mere enn en brukerkonto passer med de spesifiserte egenskaper';
$lang['error_cantfinduser'] = 'Feil: Kunne ikke finne en bruker som passer';
$lang['error_groupnotfound'] = 'Feil: Kunne ikke finne en gruppe med det navnet';
$lang['readonly'] = 'Skrivebeskyttet';
$lang['prompt_usermanipulator'] = 'Bruker Manipulator Klasse';
$lang['admin_logout'] = 'Logget ut av administrator';
$lang['prompt_loggedinonly'] = 'Vis kun de som er innlogget';
$lang['prompt_logout'] = 'Logg ut denne brukeren';
$lang['user_properties'] = 'Bruker egenskaper';
$lang['userhistory'] = 'Bruker historie';
$lang['export'] = 'Eksporter';
$lang['clear'] = 'T&oslash;m';
$lang['prompt_exportuserhistory'] = 'Eksporter Brukerhistorie til ASCII fil som er minst';
$lang['prompt_clearuserhistory'] = 'T&oslash;m Brukerhistorie oppf&oslash;ringer som er minst';
$lang['title_lostusername'] = 'Glemt dine innloggingsdetaljer?';
$lang['title_rssexport'] = 'Eksporter gruppedefinisjon (og egenskaper) til XML';
$lang['title_userhistorymaintenance'] = 'Behandle Brukerhistorie';
$lang['yes'] = 'Ja';
$lang['no'] = 'Nei';
$lang['prompt_of'] = 'av';
$lang['date_allrecords'] = '** Ingen grense **';
$lang['date_onehourold'] = 'En time gamle';
$lang['date_sixhourold'] = 'Seks timer gamle';
$lang['date_twelvehourold'] = 'Tolv timer gamle';
$lang['date_onedayold'] = 'En dag gamle';
$lang['date_oneweekold'] = 'En uke gamle';
$lang['date_twoweeksold'] = 'To uker gamle';
$lang['date_onemonthold'] = 'En m&aring;ned gamle';
$lang['date_threemonthsold'] = 'Tre m&aring;neder gamle';
$lang['date_sixmonthsold'] = 'Seks m&aring;neder gamle';
$lang['date_oneyearold'] = 'Ett &aring;r gamle';
$lang['title_groupsort'] = 'Gruppering og Sortering';
$lang['prompt_recordsfound'] = 'Oppf&oslash;ringer som passer kriteriet';
$lang['sortorder_username_desc'] = 'Synkende brukernavn';
$lang['sortorder_username_asc'] = 'Stigende brukernavn';
$lang['sortorder_date_desc'] = 'Synkende Dato';
$lang['sortorder_date_asc'] = 'Stigende Dato';
$lang['sortorder_action_desc'] = 'Synkende Hendelsestype';
$lang['sortorder_action_asc'] = 'Stigende Hendelsestype';
$lang['sortorder_ipaddress_desc'] = 'Synkende IP-adresse';
$lang['sortorder_ipaddress_asc'] = 'Stigende IP-adresse';
$lang['info_nohistorydetected'] = 'Ikke noe historisk funnet';
$lang['reset'] = 'Tilbakestill';
$lang['prompt_group_ip'] = 'Grupper etter IP-adresse';
$lang['prompt_filter_eventtype'] = 'Hendelsestype Filter';
$lang['prompt_filter_date'] = 'Vis kun hendelser som er mindre enn:';
$lang['prompt_pagelimit'] = 'Sidegrense';
$lang['for'] = 'for ';
$lang['title_userhistory'] = 'Brukerhistorie rapport';
$lang['unknown'] = 'Ukjent';
$lang['prompt_ipaddress'] = 'IP-adresse';
$lang['prompt_eventtype'] = 'Hendelsestype';
$lang['prompt_date'] = 'Dato';
$lang['prompt_return'] = 'Tilbake';
$lang['import_complete_msg'] = 'Import oppgaven er ferdig';
$lang['prompt_linesprocessed'] = 'Linjer prosessert';
$lang['prompt_errors'] = 'Det oppstod feil';
$lang['prompt_recordsadded'] = 'Poster lagt til';
$lang['error_nogroupproprelns'] = 'Kunne ikke finne egenskaper for gruppe %s';
$lang['error_noresponsefromserver'] = 'Fikk ingen respons fra SMTP serveren';
$lang['error_importfilenotfound'] = 'Spesifiserte filer (%s) ble ikke funnet';
$lang['error_importfieldvalue'] = 'Ugyldig verdi for nedtrekk eller flervalgsfelt %s';
$lang['error_importfieldlength'] = 'Felt %s overskrider maksimum lengde';
$lang['error_importusers'] = 'Import Feil (linje %s): %s';
$lang['error_propertydefns'] = 'Kunne ikke f&aring; tak i egenskap definisjonene (intern feil)';
$lang['error_problemsettinginfo'] = 'Problem med &aring; sette brukerinfo';
$lang['error_importrequiredfield'] = 'Kunne ikke finne en kolonne som samsvarte med det p&aring;krevde feltet %es';
$lang['error_nogroupproperties'] = 'Kunne ikke finne egenskaper for den spesifiserte gruppen';
$lang['error_importfileformat'] = 'Filen oppgitt for import er ikke i korrekt format';
$lang['error_couldnotopenfile'] = 'Kunne ikke &aring;pne filen';
$lang['info_importusersfileformat'] = '<h4>File Format Information</h4>
<p>The input file must be in ASCII format using comma separated values.  Each line in this input file (with the exception of the header line, discussed below) represents one user record.  The order of the fields in each line must be identical.</p>
<h5>Header line</h5>
<ul>
<li>The first line of the file must begin with two pound (\#) characters, and names each of the fields in the file.  The names of these fields is significant.  There are some required field names (see below), and other field names must match the property names associated with the group users are going to be added into.</li>
<li>The import process will fail if the fields in the input file does not match all of the required properties associated with the group that users are being added into</li>
<li>The input file may contain fields representing some of the optional properties in the specified group.</li>
<li>The import process will ignore any fields in the input file that are either not known, or map to properties that are <em>off</em> in the specified user group.</li>
</ul><br/>
<h6><strong>Columnar Data</strong></h5>
<ul>
<li>The <strong>userid</strong> Field - The userid for the user. A value in this field will indicate you are doing an update.  There is a checkbox during the import process to specify that tue userid field can be ignored for the purposes of migrating users from one server to another.</li>
<li>The <strong>username</strong> Field - The desired username.
    <p>This field must exist in the headerline, and in each and every line of the input file. The record will fail if a user with that username already exists in the database.</p></li>
<li>The <strong>password</strong> Field - The password to set for the user.  Optionally, a <strong>passwordhash</strong> field may be included that specifies thee <em>salted</em> MD5 hash of the users password.  If the password field is empty when creating new users the password &amp;quot;changeme&amp;quot; is hardcoded.</li>
<li>The <strong>createdate</strong> Field - todo</li>
<li>The <strong>expires</strong> Field - todo</li>
<li>The <strong>groupname</strong> Field - The groups that you want to have the user be a member of. If all required fields are not filled in the insert/update of the record will fail. See Multiselect Fields below for syntax.</li>
<li>Dropdown/Radio Fields
    <p>The value of dropdown properties in an import file is represented as the string that is shown in the dropdown control in the FrontEndUsers module.</p>
</li>
<li>Multiselect Fields
    <p>Multiselect fields are contained within the ASCII file as a : separated list of strings, where each string represents the text shown in the multiselect list</p>
</li>
<li>Date Fields
    <p>Must be in the format of MM-DD-YYYY</p>
</li>
<li>Image Fields
    <p>Image are fields who&#039;s column name matches a property of type Image.  If this field is a required part of the destination group, then the name specified in these columns must exist in the uploads disrectory of the CMS installation.  If the image does not exist, and the field is required, then the record will fail.</p></li>
</ul>
<h5>Notes</h5>
<p>The import process is subject to the limitations imposed by the host provider, such as memory limitations, processing time, file size upload, and safe mode restrictions.  Any one of these limitations may cause the import to fail. Therefore it is advisable to ensure that import files are smaller in size, and simpler in nature.</p>
<p>Though every effort has been made to ensure that database corruption will not occur, it is advisable to perform a database backup before doing a user import.</p>
<p>The Export data is in the same format as needed for import.</p>
<h5>Example</h5>
<pre>
##username,first_name,last_name,email,city,state,country,zip
user1,test,user,user1@somedomain.com,somewhere,TX,US,12345
</pre>';
$lang['prompt_importdestgroup'] = 'Importer Brukere til denne gruppen';
$lang['prompt_importfilename'] = 'Inndata CSV fil';
$lang['prompt_importxmlfile'] = 'Inndata XML fil';
$lang['prompt_exportusers'] = 'Eksporter Brukere';
$lang['prompt_importusers'] = 'Importer Brukere';
$lang['prompt_clear'] = 'T&oslash;m';
$lang['prompt_image_destination_path'] = 'Bilde m&aring;lsti';
$lang['error_missing_upload'] = 'Et problem har oppst&aring;tt med en manglende (men n&oslash;dvendig) opplasting';
$lang['error_bad_xml'] = 'Kunne ikke behandle den tilbudte XML filen';
$lang['error_notemptygroup'] = 'Kan ikke slette en gruppe som fortsatt har brukere';
$lang['error_norepeatedlogins'] = 'Denne brukeren er allerede innlogget';
$lang['error_captchamismatch'] = 'Teksten fra bildet ble ikke skrevet riktig';
$lang['prompt_allow_repeated_logins'] = 'Tillater brukere &aring; logge inn mer en en gang';
$lang['prompt_allowed_image_extensions'] = 'Bilde filendelser som brukere f&aring;r lov &aring; laste opp';
$lang['event_help_OnRefreshUser'] = '<h3>OnRefreshUser</h3>
<p>An event generated when the user session is refreshed.</p>
<h4>Parameters:</h4>
<ul>
  <li><em>id</em> - The User id</li>
</ul>
';
$lang['event_help_OnDeleteUser'] = '<h3>OnDeleteUser<h3>
<p>En hendelse/event generert n&aring;r en bruker slettes</p>
<h4>Parametere</h4>
<ul>
<li><em>username</em> - Brukernavnet</li>
<li><em>id</em> - Bruker IDen</li>
<li><em>props</em> - En hash fylt med egenskapene til brukeren</li>
</ul> 
';
$lang['event_help_OnCreateUser'] = '<h3>OnCreateUser<h3>
<p>En hendelse/event generert n&aring;r en bruker opprettes</p>
<h4>Parametere</h4>
<ul>
<li><em>name</em> - Brukernavnet</li>
<li><em>id</em> - Bruker IDen</li>
</ul> 
';
$lang['event_help_OnUpdateUser'] = '<h3>OnUpdateUser<h3>
<p>En hendelse generert n&aring;r en bruker er oppdatert (enten av brukeren selv eller av admin)</p>
<h4>Parametere</h4>
<ul>
<li><em>name</em> - Brukernavnet</li>
<li><em>id</em> - BrukerID&#039;en</li>
</ul> 
';
$lang['event_help_OnCreateGroup'] = '<h3>OnCreateGroup<h3>
<p>En hendelse/event generert n&aring;r en gruppe er opprettet</p>
<h4>Parametere</h4>
<ul>
<li><em>name</em> - Gruppenavnet</li>
<li><em>description</em> - Gruppebeskrivelsen</li>
<li><em>id</em> - Gruppe IDen</li>
</ul> 
';
$lang['event_help_OnDeleteGroup'] = '<h3>OnDeleteGroup<h3>
<p>En hendelse/event generert n&aring;r en gruppe er slettet</p>
<h4>Parametere</h4>
<ul>
<li><em>name</em> - Gruppenavnet</li>
<li><em>id</em> - Gruppe IDen</li>
</ul> 
';
$lang['event_help_OnLogin'] = '<h3>OnLogin<h3>
<p>En hendelse/event generert n&aring;r en bruker logger seg inn</p>
<h4>Parametere</h4>
<ul>
<li><em>id</em> - id&#039;en for den innloggede bruker</li>
<li><em>username</em> - Navnet p&aring; brukeren som er logget inn</li>
<li><em>ip</em> - Webklientens IP adresse </li>
</ul>
';
$lang['event_help_OnLogout'] = '<p>En hendelse/event generert n&aring;r en bruker logger ut</p>
<h4>Parametere</h4>
<ul>
<li><em>id</em> - Bruker IDen</li>
</ul>
';
$lang['event_help_OnExpireUser'] = '<p>En hendelse/event generert n&aring;r en brukersession utl&oslash;per</p>
<h4>Parametereh4>
<ul>
<li><em>username</em> - Navnet p&aring; brukeren som utl&oslash;p</li>
<li><em>id</em> - Bruker IDen til brukeren som utl&oslash;p</li>
</ul>
';
$lang['event_info_OnLogin'] = 'En hendelse som genereres n&aring;r en bruker logger seg inn i systemet';
$lang['event_info_OnLogout'] = 'En hendelse som genereres n&aring;r en bruker logger seg ut av systemet';
$lang['event_info_OnExpireUser'] = 'En hendelse som genereres n&aring;r en bruker-session har utl&oslash;pt';
$lang['event_info_OnCreateUser'] = 'En hendelse generert n&aring;r en bruker er opprettet';
$lang['event_info_OnRefreshUser'] = 'En hendelse som genereres n&aring;r en bruker-session er oppfrisket';
$lang['event_info_OnUpdateUser'] = 'En hendelse generert n&aring;r en brukers info er oppdatert';
$lang['event_info_OnDeleteUser'] = 'En hendelse generert n&aring;r en brukerkonto er slettet';
$lang['event_info_OnCreateGroup'] = 'En hendelse generert n&aring;r en brukergruppe er opprettet';
$lang['event_info_OnUpdateGroup'] = 'En hendelse generert n&aring;r en brukergruppe er oppdatert';
$lang['event_info_OnDeleteGroup'] = 'En hendelse generert n&aring;r en brukergruppe er slettet';
$lang['backend_group'] = 'Backend gruppe';
$lang['info_star'] = '* F&oslash;lgende felt er fullstendige Smartymaler.<br/>Sammen med andre tidligere eksisterende smarty variabler og plugins, s&aring; er ($username) og ($ gruppe) variablene tilgjengelige. <em> (($group)-variablen kobler den f&oslash;rste gruppen til den som brukeren tilh&oslash;rer.)</ em>.';
$lang['info_admin_password'] = 'Rediger dette feltet for &aring; endre brukerens passord';
$lang['info_admin_repeatpassword'] = 'Rediger dette feltet for &aring; endre brukerens passord';
$lang['error_username_exists'] = 'En bruker med samme brukernavn finnes allerede';
$lang['nocsvresults'] = 'Ingen resultater fra csv eksporten';
$lang['prompt_unfldlen'] = 'Lengden p&aring; brukernavnfeltet';
$lang['prompt_pwfldlen'] = 'Lengden p&aring; passordfeltet';
$lang['error_invalidpasswordlengths'] = 'Min/Maks lengde p&aring; passordet er ugyldig';
$lang['error_invalidusernamelengths'] = 'Min/Maks lengde p&aring; brukernavn er ugyldig';
$lang['error_invalidemailaddress'] = 'Ugyldig e-postadresse';
$lang['error_noemailaddress'] = 'Vi kunne ikke finne en e-postadresse for denne kontoen';
$lang['error_problemseettinginfo'] = 'Kan ikke lagre brukerinformasjonen';
$lang['error_settingproperty'] = 'Kan ikke lagre egenskapen';
$lang['user_added'] = 'Bruker lagt til %s = %s';
$lang['user_deleted'] = 'Bruker slettet uid=%s';
$lang['propertyfilter'] = 'Egenskaper';
$lang['valueregex'] = 'Verdi (regular expression)';
$lang['warning_effectsfieldlength'] = 'Advarsel: Disse feltene p&aring;virker st&oslash;rrelsen p&aring; inndatafeltene i skjemaer. &Aring; minske disse verdiene p&aring; et eksisterende nettsted er ikke &aring; anbefale';
$lang['confirm_submitprefs'] = 'Er du sikker p&aring; at du vil endre denne modulens innstillinger?';
$lang['error_emailalreadyused'] = 'E-postadressen er allerede i bruk';
$lang['prompt_usecookiestoremember'] = 'Bruk informasjonskapsler(cookies) for &aring; huske innloggingsdetaljer';
$lang['prompt_cookiename'] = 'Navnet p&aring; informasjonskapselen(cookie)';
$lang['prompt_allow_duplicate_emails'] = 'Tillat identiske e-postadresser';
$lang['prompt_username_is_email'] = 'E-postadresse er brukernavn';
$lang['info_cookie_keepalive'] = 'Fors&oslash;k &aring; holde innloggingen ved live ved &aring; benytte en informasjonskapsel <em>informasjonskapselen vil bli tilbakesatt n&aring;r du er aktiv p&aring; nettstedet)</em>';
$lang['info_allow_duplicate_emails'] = '(tillat flere brukere med samme e-postadresse)';
$lang['info_username_is_email'] = '(brukers e-postadresse er deres brukernavn -- ikke sett dette sammen med &quot;Tillat identiske e-postadresser&quot;!)';
$lang['prompt_allow_duplicate_reminders'] = 'Tillat flere &quot;glemt passord&quot; p&aring;minnelser?';
$lang['info_allow_duplicate_reminders'] = '(tillat at en bruker ber om nullstilling av passordet, selv om de ikke har benyttet det forrige)';
$lang['prompt_feusers_specific_permissions'] = 'Benytt Front-end User spesifike tillatelser?';
$lang['info_feusers_specific_permissions'] = '(Normalt er, FEUser tillatelser de samme som tilsvarende Admin-omr&aring;de tillatelser - Legg til bruker, Legg til gruppe, osv. Om du haker av her, vil det v&aelig;re adskilte/egne tillatelser for FEUsers.)';
$lang['error_missingupload'] = 'Klarte ikke &aring; finne den opplastede fila (intern feil)';
$lang['error_problem_upload'] = 'Det er et problem med din opplastede fil. Vennligst fors&oslash;k p&aring; nytt';
$lang['error_missingusername'] = 'Du oppga ikke brukernavn';
$lang['error_missingemail'] = 'Du oppga ikke en e-postadresse';
$lang['error_missingpassword'] = 'Du oppga ikke passord';
$lang['frontenduser_logout'] = 'Frontend bruker utlogging';
$lang['frontenduser_loggedin'] = 'Frontend bruker innlogging';
$lang['editprop_infomsg'] = '<font color=&quot;red&quot;><b>V&AElig;R VARSOM</b> n&aring;r eksisterende egenskaper som er tilegnet grupper forandres, du kan komme i skade for &aring; &oslash;delegge noe og dermed nettstedet <i>(spesielt hvis du minsker feltlengder, etc)</i></font>';
$lang['info_smtpvalidate'] = 'Denne funksjonen virker ikke i Windows';
$lang['msg_dontcreateusername'] = 'Ikke opprett egenskaper for brukernavn eller passord da disse egenskapene er innebygget i selve FrontEndUser modulen.';
$lang['prompt_exportcsv'] = 'Eksporter brukere til CSV';
$lang['exportcsv'] = 'Eksporter';
$lang['importcsv'] = 'Importer';
$lang['admin'] = 'Admin ';
$lang['editprop'] = 'Rediger egenskap';
$lang['maxlength'] = 'Maks lengde';
$lang['created'] = 'Opprettet';
$lang['sortby'] = 'Sorter etter';
$lang['sort'] = 'Sorterer';
$lang['usersingroup'] = 'Brukere i valgt(e) gruppe(r)';
$lang['userlimit'] = 'Begrens resultatene til';
$lang['error_noemailfield'] = 'Kunne ikke finne et e-postfelt for denne brukeren. Du m&aring; kanskje kontakte systemadministratoren';
$lang['prompt_forgotpw_page'] = 'SideID/Alias for skjemaet Glemt passord';
$lang['prompt_changesettings_page'] = 'SideID/Alias for skjemaet Endre innstillinger';
$lang['prompt_login_page'] = 'SideID/Alias det skal hoppes til etter innlogging *';
$lang['prompt_logout_page'] = 'SideID/Alias det skal hoppes til etter utlogging *';
$lang['sortorder'] = 'Sorteringsrekkef&oslash;lge';
$lang['prompt_numresetrecord'] = 'Noen brukere holder p&aring; &aring; tilbakestille sine tapte passord. N&aring; er dette antallet: ';
$lang['remove1week'] = 'Fjern alle innlegg som er mer enn en uke gamle';
$lang['remove1month'] = 'Fjern alle innlegg som er mer enn en m&aring;ned gamle';
$lang['removeall'] = 'Fjern alle innlegg';
$lang['areyousure'] = 'Er du sikker?';
$lang['error_invalidcode'] = 'En ugyldig kode er lagt inn, vennligst pr&oslash;v igjen.';
$lang['error_tempcodenotfound'] = 'En midlertidig kode for din brukerID ble ikke funnet i databasen';
$lang['forgotpassword_verifytemplate'] = 'Mal som benyttes for &aring; vise verifikasjonsskjemaet';
$lang['forgotpassword_emailtemplate'] = 'Mal som benyttes p&aring; glemt passord epsoten';
$lang['error_resetalreadysent'] = 'Endring av passord for denne kontoen er allerede satt i gang av deg eller noen annen. Sjekk e-posten din, du kan ha mottatt videre instruksjoner om hvordan dette skal gjennomf&oslash;res. ';
$lang['error_dberror'] = 'Database feil';
$lang['message_forgotpwemail'] = 'Du f&aring;r denne meldingen fordi noen har fortalt v&aring;r nettside at du har mistet ditt passord.  Om dette er korrekt, les instruksjonene nedenfor.  Om du ikke skj&oslash;nner hva dette kan v&aelig;re, s&aring; kan du trygt slette denne meldingen, og vi takker for din oppmerksomhet.';
$lang['prompt_code'] = 'Kode';
$lang['message_code'] = 'Den f&oslash;lgende kode har blitt generert tilfeldig for &aring; gjenkjenne brukerkontoen.  n&aring;r du klikker linken nedenfor vil du f&aring; opp et felt for &aring; skrive inn denne koden.  Normal er feltet forh&aring;ndsutfylt for deg, men i tilfelle det ikke er - s&aring; er koden:';
$lang['prompt_link'] = 'Hvis du klikker p&aring; linken som f&oslash;lger vil du bli f&oslash;rt til en nettside hvor du kan legge inn vedlagte kode og legge inn nytt passord.';
$lang['lostpassword_emailsubject'] = 'Glemt passord';
$lang['error_nomailermodule'] = 'Kunne ikke finne CMSMailer modulen';
$lang['info_forgotpwmessagesent'] = 'En e-post er blitt sendt til %s med instruksjoner om hvordan passordet kan legges inn p&aring; ny. Takk.';
$lang['lostpw_message'] = 'S&aring; du har glemt eller mistet passordet ditt. Vel, legg inn brukernavnet ditt her, og om vi finner deg s&aring; vil vi sende deg en e-post om hvordan du kan tilbakestille det.';
$lang['forgotpassword_template'] = 'Mal for glemt passord';
$lang['lostusername_template'] = '&#039;Mistet brukernavn&#039; mal';
$lang['error_propnotfound'] = 'Egenskap %s ikke funnet';
$lang['propsfound'] = 'Egenskap funnet';
$lang['addprop'] = 'Legg til egenskap';
$lang['error_requiredfield'] = 'Et obligatorisk felt (%s) var tomt';
$lang['info_emptypasswordfield'] = 'Evt. nytt passord her for &aring; endre det eksisterende';
$lang['error_notloggedin'] = 'Det ser ikke ut til at du er innlogget';
$lang['user_settings'] = 'Innstillinger';
$lang['user_registration'] = 'Registrering';
$lang['error_accountexpired'] = 'Kontoen har utl&oslash;pt';
$lang['error_improperemailformat'] = 'Feil p&aring; e-postadressens formatering';
$lang['error_invalidexpirydate'] = 'Ugyldig utl&oslash;psdato. Dette kan v&aelig;re systemrelatert. Fors&oslash;k med &aring; sette et tidligere &aring;r.';
$lang['error_problemsettingproperty'] = 'Feil ved setting av egenskap %s for bruker $s';
$lang['error_invalidgroupid'] = 'Ugyldig gruppeID %s';
$lang['hiddenfieldmarker'] = 'Merke for skjult felt';
$lang['hiddenfieldcolor'] = 'Farge for skjult felt';
$lang['hidden'] = 'Skjult';
$lang['error_duplicatename'] = 'En egenskap med det navnet er allerede definert';
$lang['error_noproperties'] = 'Ingen egenskap definert';
$lang['error_norelations'] = 'Ingen egenskaper ble valgt for denne gruppen';
$lang['nogroups'] = 'Ingen grupper er definert';
$lang['groupsfound'] = 'Grupper funnet';
$lang['error_onegrouprequired'] = 'Det m&aring; tildeles medlemskap for minst en gruppe ';
$lang['prompt_requireonegroup'] = 'Krev medlemskap for minst en gruppe';
$lang['back'] = 'Tilbake';
$lang['error_missing_required_param'] = '%s feltet m&aring; fylles ut';
$lang['requiredfieldmarker'] = 'Merk obligatoriske felt med ';
$lang['requiredfieldcolor'] = 'Uthev obligatoriske felt med';
$lang['next'] = 'Neste';
$lang['error_groupexists'] = 'En gruppe med det navnet eksisterer allerede';
$lang['required'] = 'Obligatorisk';
$lang['optional'] = 'Valgfritt';
$lang['off'] = 'Av';
$lang['size'] = 'St&oslash;rrelse';
$lang['sizecomment'] = '<br/>(Maks st&oslash;rrelse i pixler for enhver dimensjon p&aring; bildet)';
$lang['length'] = 'Lengde';
$lang['lengthcomment'] = '<br>(bokstaver i tekstinnskrivingen)';
$lang['seloptions'] = 'Nedtrekksvalg, separert med linjeskift. Verdier kan separeres fra tekst med et = tegn. F.eks. Hunnkj&oslash;nn=f';
$lang['radiooptions'] = 'Radioknapp etiketter, separert med linjeskift. Verdier kan separeres fra tekst med et = tegn. F.eks: Hunnkj&oslash;nn=k';
$lang['prompt'] = 'Sp&oslash;r';
$lang['prompt_type'] = 'Type ';
$lang['type'] = 'Type ';
$lang['fieldstatus'] = 'Felt Status';
$lang['usedinlostun'] = 'Sp&oslash;r i Mistet<br/>brukernavn';
$lang['text'] = 'Tekst';
$lang['checkbox'] = 'Avkryssningsboks';
$lang['multiselect'] = 'Flervalgsliste';
$lang['radiobuttons'] = 'Radioknapper';
$lang['image'] = 'Bilde';
$lang['email'] = 'E-postadresse';
$lang['textarea'] = 'Tekstomr&aring;de';
$lang['dropdown'] = 'Nedtrekksmeny';
$lang['msg_currentlyloggedinas'] = 'Velkommen';
$lang['logout'] = 'Logg ut';
$lang['prompt_newgroupname'] = 'Benytt dette gruppenavnet';
$lang['prompt_changesettings'] = 'Forandre mine innstillinger';
$lang['error_loginfailed'] = 'Innlogging misslykket - ugyldig brukernavn eller passord?';
$lang['login'] = 'Logg inn';
$lang['prompt_signin_button'] = 'Logg inn knapp etikett';
$lang['prompt_username'] = 'Brukernavn';
$lang['prompt_email'] = 'E-postadresse';
$lang['prompt_password'] = 'Passord';
$lang['prompt_rememberme'] = 'Husk meg p&aring; denne datamaskinen';
$lang['register'] = 'Registrer';
$lang['forgotpw'] = 'Glemt passordet?';
$lang['lostusername'] = 'Har du glemt innloggingsdetaljene?';
$lang['defaults'] = 'Tilbakestill til standard';
$lang['template'] = 'Mal';
$lang['error_usernotfound'] = 'Kunne ikke finne informasjon om denne brukeren';
$lang['error_usernametaken'] = 'Det brukernavnet (%s) er allerede i bruk';
$lang['prompt_smtpvalidate'] = 'Bruk SMTP for &aring; kontrollere e-postadresser?';
$lang['prompt_minpwlen'] = 'Minimum lengde p&aring; passord';
$lang['prompt_maxpwlen'] = 'Maksimum lengde p&aring; passord';
$lang['prompt_minunlen'] = 'Minimum Lengde p&aring; brukernavn';
$lang['prompt_maxunlen'] = 'Maksimum lengde p&aring; brukernavn';
$lang['prompt_sessiontimeout'] = 'Session Timeout (sekunder)';
$lang['prompt_cookiekeepalive'] = 'Bruk cookies for &aring; holde innloggingen ved liv';
$lang['prompt_allowemailreg'] = 'Tillat e-post registrering';
$lang['prompt_dfltgroup'] = 'Standardgruppe for nye brukere';
$lang['changesettings_template'] = 'Mal for forandre brukerdata';
$lang['error_passwordmismatch'] = 'Passordene er ikke like';
$lang['error_invalidusername'] = 'Ugyldig brukernavn';
$lang['error_invalidpassword'] = 'Ugyldig passord';
$lang['edituser'] = 'Rediger bruker';
$lang['valid'] = 'Gyldig';
$lang['username'] = 'Brukernavn';
$lang['status'] = 'Status ';
$lang['error_membergroups'] = 'Denne brukeren er ikke medlem av noen gruppe';
$lang['error_properties'] = 'Ingen egenskaper';
$lang['error_dup_properties'] = 'Fors&oslash;k &aring; importere duplikate egenskaper';
$lang['value'] = 'Verdi';
$lang['groups'] = 'Grupper';
$lang['properties'] = 'Egenskaper';
$lang['propname'] = 'Egenskapens Navn ';
$lang['propvalue'] = 'Egenskapens verdi';
$lang['add'] = 'Legg til';
$lang['history'] = 'Historie';
$lang['edit'] = 'Rediger';
$lang['expires'] = 'Utl&oslash;per';
$lang['specify_date'] = 'Spesifiser dato';
$lang['12hrs'] = '12 timer';
$lang['24hrs'] = '24 timer';
$lang['48hrs'] = '48 timer';
$lang['1week'] = '1 uke';
$lang['2weeks'] = '2 Uker';
$lang['1month'] = '1 M&aring;ned';
$lang['3months'] = '3 M&aring;neder';
$lang['6months'] = '6 M&aring;neder';
$lang['1year'] = '1 &Aring;r';
$lang['never'] = 'Aldri';
$lang['postinstallmessage'] = 'Vellykket installasjon av modulen.<br/>Husk &aring; aktivisere  &quot;Modify FrontEndUser Properties permission.&quot;
I tillegg, anbefaler vi deg &aring; installere Captcha modulen.  Om denne er installert, en gyldighetstest av et captchabilde vil kreves i tillegg til brukernavn og passord for &aring; logge inn. Meningen med dette er &aring; hindre brute force angrep.  <strong>Merk:</strong> Parameteren nocaptcha kan benyttes for &aring; sl&aring; av denne funksjonen selv om Captcha modulen er installert.&quot;';
$lang['password'] = 'Nytt passord';
$lang['repeatpassword'] = 'Gjenta';
$lang['error_groupname_exists'] = 'En gruppe med det navnet eksisterer allerede';
$lang['editgroup'] = 'Rediger gruppe';
$lang['submit'] = 'Lagre';
$lang['cancel'] = 'Avbryt';
$lang['delete'] = 'Slett';
$lang['confirm_editgroup'] = 'Er du sikker p&aring; at dette er korrekte valg for denne gruppen?\n&Aring; sl&aring; en egenskap av/off vil ikke slette noen innlegg i egenskap-tabellen for denne gruppen/brukeren.  Egenskapen vil i stedet bli utilgjengelig.';
$lang['areyousure_deletegroup'] = 'Er du sikker p&aring; at du vil slette denne gruppen?';
$lang['confirm_delete_prop'] = 'Er du sikker p&aring; at du vil slette denne egenskapen helt?\n&Aring; gj&oslash;re dette vil ogs&aring; slette enhver brukers innlegg i denne egenskapen.';
$lang['error_insufficientparams'] = 'Ufullstendige parametre';
$lang['id'] = 'Id ';
$lang['name'] = 'Navn';
$lang['error_cantaddprop'] = 'Problem med &aring; legge til egenskap';
$lang['error_cantaddgroupreln'] = 'Problem med &aring; legge til gruppeegenskap';
$lang['error_cantaddgroup'] = 'Problem med &aring; legge til gruppe';
$lang['error_cantassignuser'] = 'Problem med &aring; legge en bruker til gruppen';
$lang['error_couldnotdeleteproperty'] = 'Problem med &aring; slette en egenskap';
$lang['error_couldnotfindemail'] = 'Kunne ikke finne en e-postadresse';
$lang['error_destinationnotwritable'] = 'Ingen skriverettighet i m&aring;lmappen';
$lang['error_invalidparams'] = 'Ugyldige parametere';
$lang['error_nogroups'] = 'Kunne ikke finne noen grupper';
$lang['applyfilter'] = 'Bruk';
$lang['filter'] = 'Filtrer';
$lang['userfilter'] = 'Brukernavn vanlig uttrykk';
$lang['description'] = 'Beskrivelse';
$lang['groupname'] = 'Gruppenavn';
$lang['accessdenied'] = 'Adgang nektet';
$lang['error'] = 'Feil';
$lang['addgroup'] = 'Legg til gruppe';
$lang['importgroup'] = 'Importer Gruppe';
$lang['adduser'] = 'Legg til bruker';
$lang['usersfound'] = 'Brukere som passer med kriteriene';
$lang['group'] = 'Gruppe';
$lang['selectgroup'] = 'Velg gruppe';
$lang['registration_template'] = 'Mal for registrering';
$lang['logout_template'] = 'Mal for utlogging';
$lang['login_template'] = 'Mal for innlogging';
$lang['preferences'] = 'Preferanser';
$lang['users'] = 'Brukere';
$lang['friendlyname'] = 'Frontend brukere';
$lang['moddescription'] = 'Administrer Frontend brukere';
$lang['defaultfrontpage'] = 'Standard forside';
$lang['lastaccessedpage'] = 'Siste viste side';
$lang['otherpage'] = 'Annen side: ';
$lang['captcha_title'] = 'Oppgi teksten fra bildet';
$lang['qca'] = 'P0-536849115-1307983495210';
$lang['utma'] = '156861353.1410669460.1360334748.1363908655.1363990160.57';
$lang['utmz'] = '156861353.1360334748.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353.2.10.1363990160';
$lang['utmc'] = '156861353';
?>