<?php
$lang['eventhandlers_added'] = 'Rukovaoci događajima dodati';
$lang['preferences_updated'] = 'Preferencije izmenjene';
$lang['setup_cart_events'] = 'Setup Cart Events';
$lang['setup'] = 'Pode&scaron;avanje';
$lang['info_setup_cart_events'] = 'Occasionally, when upgrading from an older version, cart events handlers are not added.  Click this button to ensure that they are.  This is important if using paid registrations';
$lang['info_force_email_twice'] = 'If this option is enabled, the user will be required to enter their username (or email address) twice, and those two values will be checked to be identical';
$lang['prompt_redirect_paidpkg'] = 'Page ID/Alias to redirect to for paid packages';
$lang['info_redirect_paidpkg'] = 'A smarty template that determines the pageid or alias of a page to redirect to for paid packages. Typically a user that is registering for your site may want to go directly to your checkout page, or to the view cart page.';
$lang['info_additionalgroups_matchfields'] = 'When allowing existing users to register to an additional group, you can specify which FEU properties of the existing user must match when the user registers again.  This information will be used to uniquely identify the FEU user account';
$lang['info_cartitem_summary_tpl'] = 'A smarty template that determines the value of the summary that appears with this line item in the cart, and during the checkout process.  If no value is specified a default is used.  Valid smarty variables are {$pkg} <em>(array)</em>.  {$sku}, {$username}, {$tmpuid} <em>(the users temporary user id)</em>. <strong>Note:</strong> some payment gateways may only support a fixed number of characters for the summary.';
$lang['prompt_cartitem_summary_tpl'] = 'Cart Item Summary Template';
$lang['paid_registration'] = 'Plaćena registracija';
$lang['info_skip_final_msg'] = 'This option determins wether the registration complete message should be displayed to the user after registration.';
$lang['notifications'] = 'Notifikacije';
$lang['info_login_afterverify'] = 'This option will automatically log the visitor into the site after the user has been pushed to the Frontend Users module.  This option has no effect if allowing paid registration';
$lang['info_email_confirmation'] = 'This option sends an email to the registerd user account with a link that allows verifying that the account information entered is valid.<br/><strong>Note:</strong> This option should not be used when allowing paid registrations';
$lang['prompt_registration_settings'] = 'Pode&scaron;avanja registracije';
$lang['none'] = 'Ni&scaron;ta';
$lang['month'] = 'Mesec';
$lang['year'] = 'Godina';
$lang['subscription_expires'] = 'Pretplata se obnavlja svakih';
$lang['error_policycantadd'] = 'The policy of this website does not allow adding this item to your cart.  Please contact the site administrator';
$lang['prompt_allow_select_pkg'] = 'Allow users to select a package (group) to register to';
$lang['info_allowselectpkg'] = 'You may wish to allow your users to select an FEU group to register to.  These groups are tied to packages (for ecommerce purposes).  However if not using the E-commerce functionality, the price data can be ignored';
$lang['error_nopkgs'] = 'No packages have been defined to allow the customer to register to';
$lang['selpkg_template'] = 'Select Package Template';
$lang['title_selpkg_template'] = 'Select Subscription Package Template';
$lang['info_selpkg_template'] = 'This template is used when paid subscriptions are enabled to allow the user to select a paid subscription package';
$lang['error_pkgcost'] = 'Package Cost is Invalid';
$lang['error_pkgexists'] = 'A package with a %s of %s already exists';
$lang['description'] = 'Opis';
$lang['edit_paidpkg'] = 'Edit Paid Package &quot;%s&quot;';
$lang['add_paidpkg'] = 'Dodaj plaćeni paket';
$lang['name'] = 'Ime';
$lang['prompt'] = 'Prompt';
$lang['group'] = 'Grupa';
$lang['cost'] = 'Cena';
$lang['regpkgs_tab'] = 'Registration Packages';
$lang['prompt_allow_paid_registration'] = 'Zahtevajte od korisnika da plaćaju registrovanje na Va&scaron;em sajtu';
$lang['info_allow_paid_registration'] = 'Please also select Selfregistration as a source module from CGEcommerceBase, and configure the &quot;Paid Registration&quot; Tab.  Additionally, you must enable package selection above.';
$lang['email-password'] = 'E-mail adresa i lozinka';
$lang['username-password'] = 'Korisničko ime i lozinka';
$lang['help_param_allowoverwrite'] = 'This parameter allows overwriting existing FEU users. In conjunction with the preferences in the SelfRegistration admin panel you can specify what data will be used to uniquely identify a user account&#039;;';
$lang['into_additionalgroups_matchfields'] = 'Specify which fields should be used to uniquely identify a user.  This can be used to allow the user to register when an account already exists for that user with a different username.';
$lang['prompt_additionalgroups_matchfields'] = 'When overwriting an existing account the following fields must match';
$lang['prompt_reg_additionalgroups'] = 'Allow existing users to register for additional groups?';
$lang['prompt_additionalgroups_settings'] = 'Additional Groups Settings';
$lang['prompt_general_settings'] = 'Op&scaron;ta pode&scaron;avanja';
$lang['prompt_security_settings'] = 'Sigurnosna pode&scaron;avanja';
$lang['error_uniquefield'] = 'The value specified for &quot;%s&quot; is already in use by another registered user';
$lang['help_param_action'] = 'This parameter dictates the behaviour of the module.
<ul>
  <li><strong>default</strong>
   <p>This is the default action.  Based on the <em>(deprecated></em> mode parameter <em>(see below)</em> it will display either the user registration form, the verify form, or another form.</li>
  </li>
  <li>register_link
   <p>Display a link to the user registration form. <em>(deprecated)</em></p>
  </li>
</ul>';
$lang['help_param_destpage'] = 'Applicable only to the action=register_link.. this parameter allows specifying (by alias or page id) a destination page for the link.';
$lang['help_param_group'] = 'Applicable to (and required for) the action=register_link or action=register, this parameter allows specifying a group in which the user will be regisered';
$lang['help_param_onlyhref'] = 'Used only in the action=register_link, setting this parameter indicates that the output should only contain the url portion of the link';
$lang['help_param_linktext'] = 'Used only in the action_register_link it allows specifying the text for the generated link.  This parameter is ignored if the onlyhref parameter is specified.';
$lang['help_param_noinline'] = 'Applicable to many actions, this parameter overrides the preference in the admin panel to indicate that the output from the generated link or form should not be displayed inline.  i.e: noinline=1 on the default action will indicate that the output text will replace the {content} tag.';
$lang['error_noregister'] = 'Ne možete se registrovati da biste postali član ove korisničke grupe';
$lang['prompt_noregister'] = 'Asolutno zabrani korisnicima da se registruju u ovim grupama';
$lang['error_nosecondemailaddress'] = 'Niste uneli svoju e-mail adresu dva puta';
$lang['push_live'] = 'Prosledi ovog korisnika u FEU';
$lang['areyousure_pushuser'] = 'Are you sure you want to push this user into FEU without completing the validation process?';
$lang['delete'] = 'Obri&scaron;i';
$lang['login_afterverify'] = 'Automatically log the user in to FrontEndUsers after the verification step is complete';
$lang['skip_final_msg'] = 'Ne prikazuj zavr&scaron;nu poruku nakon registracije';
$lang['redirect_afterregister'] = 'ID/Alias stranice koja će biti prikazana korisniku nakon uspe&scaron;ne registracije';
$lang['redirect_afterverify'] = 'PageID/Alias to redirect to after verification step is complete';
$lang['use_inline_forms'] = 'Use Inline Forms <em>(form output replaces the module tag, not all of content)</em>';
$lang['error_codesdontmatch'] = 'Validacioni ključ koji ste uneli nije validan';
$lang['event_description_onNewUser'] = 'An event indicating that a new user has completed the registration form';
$lang['event_description_onUserRegistered'] = 'An event indicating that a user has verified his information and is now completely registered';
$lang['event_help_onNewUser'] = '<p>An event indicating that a new user has completed the registration form</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The new users selected username</li>
<li><em>email</em> - The new users email address</li>
</ul>
';
$lang['event_help_onUserRegistered'] = '<p>An event indicating that a user has been verified and is now registered with feusers</p>
<h4>Parameters</h4>
<ul>
<li><em>username</em> - The registered username</li>
<li><em>id</em> - The new users uid</li>
</ul>
';
$lang['confirm_submitprefs'] = 'Izmeniti administratorske preferencije?';
$lang['info_admin_password'] = 'Ostavite ovo polje prazno ukoliko ne želite da menjate lozinku';
$lang['info_admin_repeatpassword'] = 'Ostavite ovo polje prazno ukoliko ne želite da menjate lozinku';
$lang['error_emaildoesnotmatch'] = 'E-mail adrese se ne poklapaju';
$lang['force_email_twice'] = 'Zahtevaj od korisnika da svoju e-mail adresu unesu dva puta';
$lang['again'] = 'ponovo';
$lang['deleteselusers'] = 'Obri&scaron;i selektovane korisnike';
$lang['error_nopropdefns'] = 'No property definitions, or problem retreiving them from the database';
$lang['error_nogroups'] = 'No groups, or problem retreiving group list';
$lang['error_dberror'] = 'Gre&scaron;ka vezana za bazu podataka';
$lang['title_post_sendanotheremail_template'] = 'Post Lost Email Template';
$lang['title_sendanotheremail_template'] = '&Scaron;ablon za zahtev ponovnog slanja verifikacione e-mail poruke';
$lang['clickhere'] = 'Kliknite ovde';
$lang['msg_sendanotheremail'] = 'Već sam popunio/la registracioni formular, ali nisam primio/la verifikacionu e-mail poruku. Možete li je poslati ponovo?';
$lang['sendanotheremail_template'] = 'Lost Email Template';
$lang['info_userverified'] = 'Novi korisnik je dodat u FrontEndUsers modul';
$lang['edit'] = 'Izmeni';
$lang['unknown'] = 'Nepoznato';
$lang['select'] = 'Izaberi';
$lang['check_all'] = 'Čekiraj sve';
$lang['uncheck_all'] = 'Odčekiraj sve';
$lang['send_adjustmentemail'] = 'Po&scaron;alji e-mail korisniku';
$lang['txt_adjustmentemail'] = '(informs the user that their account has been adjusted';
$lang['txt_changepassword'] = 'Popunite ova polja kako biste izmenili korisničku lozinku';
$lang['edituser'] = 'Izmeni korisničke podatke';
$lang['areyousure_deleteuser'] = 'Da li ste sigurni da želite obrisati ovog delimično registrovanog korisnika?';
$lang['hdr_userid'] = 'Korisnička ID oznaka';
$lang['hdr_username'] = 'Korisničko ime';
$lang['hdr_grpname'] = 'Grupa';
$lang['hdr_created'] = 'Kreiran';
$lang['hdr_email'] = 'E-mail';
$lang['usersfound'] = 'Users found (limited to a maximum of 250)';
$lang['users'] = 'Korisnici';
$lang['list1day'] = 'List all entries more than 1 day old';
$lang['subject'] = 'Tema odlazne poruke';
$lang['htmlbody'] = 'HTML message body';
$lang['textbody'] = 'Text message body';
$lang['prompt_numresetrecord'] = 'Nekoliko korisnika je usred procesa registracije.  Trenutni njihov broj je:';
$lang['remove1week'] = 'Obri&scaron;i sve unose starije od nedelje dana';
$lang['remove1month'] = 'Obri&scaron;i sve unose starije od mesec dana';
$lang['remove1day'] = 'Obri&scaron;i sve unose starije od jednog dana';
$lang['removeall'] = 'Obri&scaron;i sve unose';
$lang['areyousure'] = 'Da li ste sigurni?';
$lang['registration_info_edited'] = 'Va&scaron;i registracioni podaci su izmenjeni';
$lang['registration_confirmation'] = 'Potvrda registracije';
$lang['user_registration'] = 'Registrujte se';
$lang['finalmessage_template'] = 'Final Message Template';
$lang['title_verifyregistration'] = 'Verifikacija registracije';
$lang['code'] = 'Validacioni ključ';
$lang['default'] = 'Vrati na podrazumevane vrednosti';
$lang['error_noproperties'] = 'No properties found for this user';
$lang['error_noproprelations'] = 'No property relations';
$lang['error_emailinvalid'] = 'E-mail adresa nije validna';
$lang['error_noemailaddress'] = 'No valid email address field found';
$lang['error_requiredfield'] = 'Field %s must be filled in';
$lang['registration1_template'] = 'Registration Template 1';
$lang['registration2_template'] = 'Registration Template 2';
$lang['emailconfirm_template'] = '&Scaron;ablon konfirmacione e-mail poruke';
$lang['emailuseredited_template'] = '&Scaron;ablon poruke o izmeni korisničkih podataka';
$lang['preferences'] = 'Preferencije';
$lang['error_usernotfound'] = 'Korisnik nije pronađen';
$lang['error_invalidusername'] = 'Username is invalid (too long, too short, or contains invalid characters).  Hint- Usernames must contain only alphanumeric characters (no spaces)';
$lang['error_invalidemail'] = 'E-mail adresa nije validna.';
$lang['error_usernametaken'] = 'To korisničko ime je već zauzeto';
$lang['error_passwordsdontmatch'] = 'GRE&Scaron;KA: Lozinke se ne poklapaju';
$lang['error_invalidpassword'] = 'Lozinka nije validna (lozinke moraju biti duge između %s i %s karaktera)';
$lang['error_emptyusername'] = 'Korisničko ime ne sme biti prazno';
$lang['error_emptyemail'] = 'E-mail ne sme biti prazan';
$lang['repeatpassword'] = 'Lozinka (ponovo)';
$lang['password'] = 'Lozinka';
$lang['username'] = 'Korisničko ime';
$lang['email'] = 'E-mail';
$lang['captcha_title'] = 'Molimo prekucajte tekst sa slike';
$lang['error_insufficientparams'] = 'Insufficient number (or incorrect) parameters supplied to module';
$lang['error_nofeusersmodule'] = 'Could not get instance of FrontEndUsers module';
$lang['error_nosuchgroup'] = 'Grupa pod ovim nazivom ne postoji';
$lang['error_captchamismatch'] = 'Tekst sa slike nije ispravno prekucan';
$lang['send_emails_to'] = 'Registration emails should be sent to';
$lang['require_email_confirmation'] = 'Zahtevaj od korisnika da potvrdi registraciju preko e-maila';
$lang['notify_on_registration'] = 'Po&scaron;alji e-mail obave&scaron;tenja kada se neko registruje';
$lang['cancel'] = 'Otkaži';
$lang['submit'] = 'Po&scaron;alji';
$lang['friendlyname'] = 'Modul za samo-registraciju';
$lang['postinstall'] = 'Installation successfull, please remember to set the &quot;Modify SelfRegistration Settings&quot; permission.  If the Captcha module is installed, then captcha functionality is enabled by default.  We strongly reccommend that you install this module.  If the Captcha module is installed, and you want to disable it, use the nocaptcha param in your selfregistration tag.';
$lang['postuninstall'] = 'Modul za samo-registraciju je deinstaliran.';
$lang['uninstalled'] = 'Modul deinstaliran.';
$lang['installed'] = 'Modul verzije %s je instaliran.';
$lang['prefsupdated'] = 'Preferencije sačuvane.';
$lang['accessdenied'] = 'Pristup odbijen. Molimo proverite svoje dozvole';
$lang['error'] = 'Gre&scaron;ka.';
$lang['upgraded'] = 'Modul je uspe&scaron;no nadograđen na verziju %s.';
$lang['title_mod_prefs'] = 'Pode&scaron;avanja modula';
$lang['title_mod_admin'] = 'Administratorski panel modula';
$lang['title_admin_panel'] = 'Modul za samo-registraciju';
$lang['moddescription'] = 'Modul koji dozvoljava posetiocima sajta da se sami registruju.';
$lang['welcome_text'] = '<p>Welcome to the self registration module.</p>';
$lang['enable_whitelist'] = 'Enable Whitelist';
$lang['whitelist'] = 'List of whitelist username/emails. One per line. (use * for wildcards)';
$lang['whitelist_trigger_message'] = 'Message to show if a whitelist rule is triggered';
$lang['dont_use'] = 'No Whitelist';
$lang['no_matches'] = 'Don&#039;t allow matched username/emails to register';
$lang['only_matches'] = 'Only allow matched username/emails to register';
?>
