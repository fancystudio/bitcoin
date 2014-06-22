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
$lang['paid_registration'] = 'Paid Registration';
$lang['info_skip_final_msg'] = 'This option determins wether the registration complete message should be displayed to the user after registration.';
$lang['notifications'] = 'Notifications';
$lang['info_login_afterverify'] = 'This option will automatically log the visitor into the site after the user has been pushed to the Frontend Users module.  This option has no effect if allowing paid registration';
$lang['info_email_confirmation'] = 'This option sends an email to the registerd user account with a link that allows verifying that the account information entered is valid.<br/><strong>Note:</strong> This option should not be used when allowing paid registrations';
$lang['prompt_registration_settings'] = 'Registracijos nustatymai';
$lang['none'] = 'None';
$lang['month'] = 'Mėnuo';
$lang['year'] = 'Metai';
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
$lang['description'] = 'Description';
$lang['edit_paidpkg'] = 'Edit Paid Package &quot;%s&quot;';
$lang['add_paidpkg'] = 'Add Paid Package';
$lang['name'] = 'Vardas';
$lang['prompt'] = 'Prompt';
$lang['group'] = 'Grupė';
$lang['cost'] = 'Kaina';
$lang['regpkgs_tab'] = 'Registration Packages';
$lang['prompt_allow_paid_registration'] = 'Require members to pay for registration to your site';
$lang['info_allow_paid_registration'] = 'Please also select Selfregistration as a source module from CGEcommerceBase, and configure the &quot;Paid Registration&quot; Tab.  Additionally, you must enable package selection above.';
$lang['email-password'] = 'Email Address and Password';
$lang['username-password'] = 'Username and Password';
$lang['help_param_allowoverwrite'] = 'This parameter allows overwriting existing FEU users. In conjunction with the preferences in the SelfRegistration admin panel you can specify what data will be used to uniquely identify a user account&#039;;';
$lang['into_additionalgroups_matchfields'] = 'Specify which fields should be used to uniquely identify a user.  This can be used to allow the user to register when an account already exists for that user with a different username.';
$lang['prompt_additionalgroups_matchfields'] = 'When overwriting an existing account the following fields must match';
$lang['prompt_reg_additionalgroups'] = 'Allow existing users to register for additional groups?';
$lang['prompt_additionalgroups_settings'] = 'Additional Groups Settings';
$lang['prompt_general_settings'] = 'General Settings';
$lang['prompt_security_settings'] = 'Security Settings';
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
$lang['error_noregister'] = 'Jūs negalite registruotis &scaron;ioje grupėje';
$lang['prompt_noregister'] = 'Uždrausti lankytojams registruotis &scaron;iose grupėse';
$lang['error_nosecondemailaddress'] = 'Jūs neįvedėte du kartus e. pa&scaron;to adreso';
$lang['push_live'] = 'Padaryti FEU naudotoju';
$lang['areyousure_pushuser'] = 'Ar tikrai norite padaryti &scaron;į naudotoją FEU naudotoju, nelaukdami registracijos patikrinimo procedūros?';
$lang['delete'] = 'I&scaron;trinti';
$lang['login_afterverify'] = 'Automatically log the user in to FrontEndUsers after the verification step is complete';
$lang['skip_final_msg'] = 'Nerodyti žinutės po registracijos';
$lang['redirect_afterregister'] = 'PageID/Alias to redirect to after registration is complete';
$lang['redirect_afterverify'] = 'PageID/Alias to redirect to after verification step is complete';
$lang['use_inline_forms'] = 'Use Inline Forms <em>(form output replaces the module tag, not all of content)</em>';
$lang['error_codesdontmatch'] = 'Pateiktas kodas yra neteisingas';
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
$lang['confirm_submitprefs'] = 'Pakeisti admin nustatymus?';
$lang['info_admin_password'] = 'Palikite &scaron;į lauką tu&scaron;čia, jei nenorite keisti naudotojo slaptažodžio';
$lang['info_admin_repeatpassword'] = 'Palikite &scaron;į lauką tu&scaron;čia, jei nenorite keisti naudotojo slaptažodžio';
$lang['error_emaildoesnotmatch'] = 'E. pa&scaron;to adresai nesutampa';
$lang['force_email_twice'] = 'Naudotojas turi įvesti e. pa&scaron;to adresą du kartus';
$lang['again'] = 'dar kartą';
$lang['deleteselusers'] = 'I&scaron;trinti pasirinktus naudotojus';
$lang['error_nopropdefns'] = 'No property definitions, or problem retreiving them from the database';
$lang['error_nogroups'] = 'No groups, or problem retreiving group list';
$lang['error_dberror'] = 'Duomenų bazės klaida';
$lang['title_post_sendanotheremail_template'] = 'Dingusio e. lai&scaron;ko pakartojimo &scaron;ablonas';
$lang['title_sendanotheremail_template'] = 'Dingusio e. lai&scaron;ko &scaron;ablonas';
$lang['clickhere'] = 'Spausti čia';
$lang['msg_sendanotheremail'] = 'A&scaron; jau užpildžiau registracijos formą, bet negavau e. lai&scaron;ko. Pra&scaron;ome, i&scaron;siųskite e. lai&scaron;ką dar kartą';
$lang['sendanotheremail_template'] = 'Nei&scaron;siųsto e. lai&scaron;ko &scaron;ablonas';
$lang['info_userverified'] = 'Naujas naudotojas buvo pridėtas į FEU';
$lang['edit'] = 'Redaguoti';
$lang['unknown'] = 'Nežinomas';
$lang['select'] = 'Pasirinkti';
$lang['check_all'] = 'Pažymėti visus';
$lang['uncheck_all'] = 'Atžymėti visus';
$lang['send_adjustmentemail'] = 'Siųsti e. lai&scaron;ką naudotojui';
$lang['txt_adjustmentemail'] = '(informuoja naudotoją, kad jo paskyra buvo pakoreguota';
$lang['txt_changepassword'] = 'Jei norite pakeisti slaptažodį, užpildykite &scaron;iuos laukus';
$lang['edituser'] = 'Redaguoti naudotoją';
$lang['areyousure_deleteuser'] = 'Ar tikrai norite i&scaron;trinti &scaron;į dalinai užsiregistravusį naudotoją?';
$lang['hdr_userid'] = 'Naudotojo ID';
$lang['hdr_username'] = 'Naudotojo vardas';
$lang['hdr_grpname'] = 'Grupė';
$lang['hdr_created'] = 'Sukurta';
$lang['hdr_email'] = 'E. lai&scaron;kas';
$lang['usersfound'] = 'Rasti naudotojai (riba - 250 įra&scaron;ų)';
$lang['users'] = 'Nautotojai';
$lang['list1day'] = 'Rodyti įra&scaron;us senesnius negu 1 (viena) diena';
$lang['subject'] = 'Siunčiamo e. lai&scaron;ko tema';
$lang['htmlbody'] = 'HTML žinutės turinys';
$lang['textbody'] = 'Tekstinės žinutės turinys';
$lang['prompt_numresetrecord'] = 'A number of users are in the middle of registering.  Currently this count is at:';
$lang['remove1week'] = 'Remove all entries more than a week old';
$lang['remove1month'] = 'Remove all entries more than a month old';
$lang['remove1day'] = 'Remove all entries more than a day old';
$lang['removeall'] = 'Pa&scaron;alinti visus įra&scaron;us';
$lang['areyousure'] = 'Ar jūs įsitikinęs??';
$lang['registration_info_edited'] = 'Jūsų registracijos duomenys buvo modifikuoti';
$lang['registration_confirmation'] = 'Registracijos patvirtinimas';
$lang['user_registration'] = 'Registruotis';
$lang['finalmessage_template'] = 'Galutinės žinutės &scaron;ablonas';
$lang['title_verifyregistration'] = 'Patikrinti registraciją';
$lang['code'] = 'Patvirtinimo raktas';
$lang['default'] = 'Numatytieji nustatymai';
$lang['error_noproperties'] = 'Nerasta &scaron;io naudotojo savybių';
$lang['error_noproprelations'] = 'No property relations';
$lang['error_emailinvalid'] = 'Neteisingas e. pa&scaron;to adresas';
$lang['error_noemailaddress'] = 'Nerastas galiojantis e. pa&scaron;to adreso laukas';
$lang['error_requiredfield'] = 'Laukas %s privalo būti užpildytas';
$lang['registration1_template'] = 'Registracijos &scaron;ablonas';
$lang['registration2_template'] = 'Registracijos patvirtinimo &scaron;ablonas';
$lang['emailconfirm_template'] = 'Patvirtinimo e. lai&scaron;ko &scaron;ablonas';
$lang['emailuseredited_template'] = 'Pakeistų naudotojo duomenų &scaron;ablonas';
$lang['preferences'] = 'Nustatymai';
$lang['error_usernotfound'] = 'Naudotojas nerastas';
$lang['error_invalidusername'] = 'Neteisingas naudotojo vardas (per ilgas, per trumpas, arba turi neteisingų simbolių).  Pasitikrinkite- Naudotojo varde gali būti tik lotyni&scaron;kos raidės ir skaičiai (be tarpų)';
$lang['error_invalidemail'] = 'E. pa&scaron;tas yra neteisingas';
$lang['error_usernametaken'] = '&Scaron;is naudotojo vardas jau yra naudojamas';
$lang['error_passwordsdontmatch'] = 'KLAIDA: slaptažodžiai nesutampa';
$lang['error_invalidpassword'] = 'Neteisingas slaptažodis (slaptažodžio ilgis turi būti  %s iki %s simbolių)';
$lang['error_emptyusername'] = 'Naudotojo vardas negali būti tu&scaron;čias';
$lang['error_emptyemail'] = 'E. pa&scaron;to adresas negali būti tu&scaron;čias';
$lang['repeatpassword'] = 'Slaptažodis (dar kartą)';
$lang['password'] = 'Slaptažodis';
$lang['username'] = 'Naudotojo vardas';
$lang['email'] = 'E. pa&scaron;tas';
$lang['captcha_title'] = 'Įveskite tekstą pavaizduotą paveiksle';
$lang['error_insufficientparams'] = 'Insufficient number (or incorrect) parameters supplied to module';
$lang['error_nofeusersmodule'] = ' Nerastas FrontEndUsers modulis';
$lang['error_nosuchgroup'] = 'Tokios grupės nėra';
$lang['error_captchamismatch'] = 'Buvo įvestas neteisingas tekstas i&scaron; paveikslo';
$lang['send_emails_to'] = 'Registracijos e. lai&scaron;kai turi būti siunčiami adresu';
$lang['require_email_confirmation'] = 'Reikalingas registracijos patvirtinimas naudojant e. pa&scaron;tą';
$lang['notify_on_registration'] = 'Siųsti prane&scaron;imą e. pa&scaron;tu, kai kas nors užsiregistruoja';
$lang['cancel'] = 'At&scaron;aukti';
$lang['submit'] = 'Pateikti';
$lang['friendlyname'] = 'Registracijos modulis';
$lang['postinstall'] = 'Installation successfull, please remember to set the &quot;Modify SelfRegistration Settings&quot; permission.  If the Captcha module is installed, then captcha functionality is enabled by default.  We strongly reccommend that you install this module.  If the Captcha module is installed, and you want to disable it, use the nocaptcha param in your selfregistration tag.';
$lang['postuninstall'] = 'Registracijos modulis i&scaron;instaliuotas. ';
$lang['uninstalled'] = 'Modulis i&scaron;instaliuotas.';
$lang['installed'] = 'Modulio %s versija įdiegta.';
$lang['prefsupdated'] = 'Modulio nustatymai atnaujinti.';
$lang['accessdenied'] = 'Prieiga uždrausta. Patikrinkite savo leidimus.';
$lang['error'] = 'Klaida!';
$lang['upgraded'] = 'Modulis atnaujintas iki %s versijos.';
$lang['title_mod_prefs'] = 'Modullio nustatymai';
$lang['title_mod_admin'] = 'Modulio admin panelė';
$lang['title_admin_panel'] = 'Registracijos modulis';
$lang['moddescription'] = 'A module that allows front end users to register themselves.';
$lang['welcome_text'] = '<p>Sveiki atvykę į registracijos modulį.</p>';
$lang['enable_whitelist'] = 'Enable Whitelist';
$lang['whitelist'] = 'List of whitelist username/emails. One per line. (use * for wildcards)';
$lang['whitelist_trigger_message'] = 'Message to show if a whitelist rule is triggered';
$lang['dont_use'] = 'No Whitelist';
$lang['no_matches'] = 'Don&#039;t allow matched username/emails to register';
$lang['only_matches'] = 'Only allow matched username/emails to register';
?>
