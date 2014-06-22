<?php
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
$lang['prompt_registration_settings'] = 'Registration Settings';
$lang['none'] = 'Ingen';
$lang['month'] = 'M&aring;nad';
$lang['year'] = '&Aring;r';
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
$lang['description'] = 'Beskrivning';
$lang['edit_paidpkg'] = 'Edit Paid Package &quot;%s&quot;';
$lang['add_paidpkg'] = 'Add Paid Package';
$lang['name'] = 'Namn';
$lang['prompt'] = 'Prompt';
$lang['group'] = 'Grupp';
$lang['cost'] = 'Cost';
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
$lang['prompt_general_settings'] = 'Allm&auml;nna inst&auml;llningar';
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
$lang['error_noregister'] = 'You cannot register to become a member of this user group';
$lang['prompt_noregister'] = 'Absolutely forbid users to register to these groups';
$lang['error_nosecondemailaddress'] = 'Du angav inte din e-postadress tv&aring; g&aring;nger';
$lang['push_live'] = 'Flytta anv&auml;ndare direkt till FEU';
$lang['areyousure_pushuser'] = '&Auml;r du s&auml;ker p&aring; att du vill flytta FEU anv&auml;ndaren utan en komplett validerings process? ';
$lang['delete'] = 'Radera';
$lang['login_afterverify'] = 'Automatiskt logga in FrontEndUsers efter veriferings steget &auml;r avklarat';
$lang['skip_final_msg'] = 'Visa inte det sista meddelande efter registreringen';
$lang['redirect_afterregister'] = 'Ange PageID/Alias som visas efter en komplett registrering';
$lang['redirect_afterverify'] = 'Ange PageID/Alias som visas efter veriferingprocessen &auml;r klar';
$lang['use_inline_forms'] = 'Anv&auml;nd Inline Forms <em>(ers&auml;tter modultaggen, dock inte allt inneh&aring;ll)</em>';
$lang['error_codesdontmatch'] = 'Valideringsnyckeln &auml;r ogiltig';
$lang['event_description_onNewUser'] = 'En h&auml;ndelse som visar att en ny anv&auml;ndare har fyllt i registreringsformul&auml;ret';
$lang['event_description_onUserRegistered'] = 'En h&auml;ndelse som visar att en anv&auml;ndare har kontrollerat hans uppgifter och &auml;r nu helt registrerade';
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
$lang['confirm_submitprefs'] = '&Auml;ndra admin preferenser?';
$lang['info_admin_password'] = 'L&auml;mna f&auml;ltet tomt f&ouml;r att bevara anv&auml;ndarens l&ouml;senord';
$lang['info_admin_repeatpassword'] = 'L&auml;mna f&auml;ltet tomt f&ouml;r att bevara anv&auml;ndarens l&ouml;senord';
$lang['error_emaildoesnotmatch'] = 'E-postadresserna &ouml;verens st&auml;mmer inte med varandra';
$lang['force_email_twice'] = 'Kr&auml;ver att anv&auml;ndarna ska ange deras e-postadress tv&aring; g&aring;nger';
$lang['again'] = 'igen';
$lang['deleteselusers'] = 'Radera valda anv&auml;ndare';
$lang['error_nopropdefns'] = 'Inga definitioner, eller s&aring; &auml;r det problem att h&auml;mta dom fr&aring;n databasen';
$lang['error_nogroups'] = 'Inga grupper, eller problem med att h&auml;mta grupplistan';
$lang['error_dberror'] = 'Databas fel';
$lang['title_post_sendanotheremail_template'] = 'Post F&ouml;rlorad Epostmall';
$lang['title_sendanotheremail_template'] = 'F&ouml;rlorad Epostmall';
$lang['clickhere'] = 'Klicka h&auml;r';
$lang['msg_sendanotheremail'] = 'Jag har redan fyllt i formul&auml;ret men inte f&aring;tt ett bekr&auml;ftelsemail, klicka f&ouml;r att f&aring; det skickat igen';
$lang['sendanotheremail_template'] = 'F&ouml;rlorad Epostmall';
$lang['info_userverified'] = 'En ny anv&auml;ndare har lagts till i FrontEndUsers';
$lang['edit'] = 'Redigera';
$lang['unknown'] = 'Ok&auml;nd';
$lang['select'] = 'V&auml;lj';
$lang['check_all'] = 'Markera alla';
$lang['uncheck_all'] = 'Avmarkera alla';
$lang['send_adjustmentemail'] = 'Skicka epost till anv&auml;ndaren';
$lang['txt_adjustmentemail'] = 'informerar anv&auml;ndaren att deras konto har &auml;ndrats';
$lang['txt_changepassword'] = 'Fyll i dessa f&auml;lt f&ouml;r att &auml;ndra anv&auml;ndarens l&ouml;senord';
$lang['edituser'] = 'Redigera anv&auml;ndare';
$lang['areyousure_deleteuser'] = 'Vill du verkligen ta bort denna delvis registrerad anv&auml;ndare?';
$lang['hdr_userid'] = 'ID';
$lang['hdr_username'] = 'Anv&auml;ndarnamn';
$lang['hdr_grpname'] = 'Grupp';
$lang['hdr_created'] = 'Skapad';
$lang['hdr_email'] = 'Epost';
$lang['usersfound'] = 'Anv&auml;ndare hittades (begr&auml;nsas till h&ouml;gst 250)';
$lang['users'] = 'Anv&auml;ndare';
$lang['list1day'] = 'Lista alla poster som &auml;r mer &auml;n 1 dag gammal';
$lang['subject'] = '&Auml;mne f&ouml;r utg&aring;ende e-post';
$lang['htmlbody'] = 'HTML meddelandetext';
$lang['textbody'] = 'Text meddelandetext';
$lang['prompt_numresetrecord'] = 'Ett antal anv&auml;ndare &auml;r mitt i registreringen. F&ouml;r n&auml;rvarande &auml;r det:';
$lang['remove1week'] = 'Ta bort alla poster som &auml;r mer &auml;n en vecka gammal';
$lang['remove1month'] = ' Ta bort alla poster som &auml;r &auml;ldre &auml;n en m&aring;nad ';
$lang['remove1day'] = 'Ta bort alla poster som &auml;r mer &auml;n en dag gammal';
$lang['removeall'] = 'Ta bort alla poster';
$lang['areyousure'] = '&Auml;r du s&auml;ker?';
$lang['registration_info_edited'] = 'Din registrerings info har &auml;ndrats';
$lang['registration_confirmation'] = 'Registrerings bekr&auml;ftelse';
$lang['user_registration'] = 'Registrera';
$lang['finalmessage_template'] = 'Sista Meddelandemall';
$lang['title_verifyregistration'] = 'Validera registreringen';
$lang['code'] = 'Valideringsnyckel';
$lang['default'] = '&Aring;terst&auml;ll till standardv&auml;rden';
$lang['error_noproperties'] = 'Inga objekt hittades f&ouml;r denna anv&auml;ndare';
$lang['error_noproprelations'] = 'Inga f&ouml;rbindelser';
$lang['error_emailinvalid'] = 'Ogiltig epostadress';
$lang['error_noemailaddress'] = 'Ingen giltigt e-postadress f&auml;lt hittades';
$lang['error_requiredfield'] = 'F&auml;ltet %s m&aring;ste fyllas i';
$lang['registration1_template'] = 'Registreringsmall 1';
$lang['registration2_template'] = 'Registreringsmall 2';
$lang['emailconfirm_template'] = 'Bekr&auml;ftelsemall';
$lang['emailuseredited_template'] = 'Anv&auml;ndarinfo &Auml;ndringsmall';
$lang['preferences'] = 'Inst&auml;llningar';
$lang['error_usernotfound'] = 'Anv&auml;ndare hittades inte';
$lang['error_invalidusername'] = 'Anv&auml;ndarnamnet &auml;r ogiltig (f&ouml;r l&aring;ngt, f&ouml;r kort eller inneh&aring;ller ogiltiga tecken). Tips -anv&auml;ndarnamn f&aring;r endast inneh&aring;lla alfanumeriska tecken (utan mellanslag)';
$lang['error_invalidemail'] = 'E-posten &auml;r ogiltig.';
$lang['error_usernametaken'] = 'Detta anv&auml;ndarnamn anv&auml;nds just nu';
$lang['error_passwordsdontmatch'] = 'FEL: L&ouml;senorden &ouml;verensst&auml;mmer inte';
$lang['error_invalidpassword'] = 'L&ouml;senordet &ouml;r ogiltig (l&ouml;senord m&aring;ste vara mellan %s och %s characters in length)';
$lang['error_emptyusername'] = 'Anv&auml;ndarnamn m&aring;ste fyllas i';
$lang['error_emptyemail'] = 'Epostadress m&aring;ste fyllas i';
$lang['repeatpassword'] = 'L&ouml;senord (igen)';
$lang['password'] = 'L&ouml;senord';
$lang['username'] = 'Anv&auml;ndarnamn';
$lang['email'] = 'Epost';
$lang['captcha_title'] = 'Skriv in texten fr&aring;n bilden';
$lang['error_insufficientparams'] = 'Otillr&auml;ckligt antal (eller felaktig) parametrar till modulen';
$lang['error_nofeusersmodule'] = 'Kunde inte f&aring; en instans av FrontEndUsers modulen';
$lang['error_nosuchgroup'] = 'Gruppens namn inte existerar';
$lang['error_captchamismatch'] = 'Texten fr&aring;n bilden var inte korrekt angiven';
$lang['send_emails_to'] = 'Registrerings e-postmeddelanden ska skickas till';
$lang['require_email_confirmation'] = 'Kr&auml;ver att anv&auml;ndaren bekr&auml;ftar sin registrering via e-post';
$lang['notify_on_registration'] = 'Skicka ett meddelande via e-post n&auml;r n&aring;gon registrerar sig';
$lang['cancel'] = 'Avbryt';
$lang['submit'] = 'Skicka';
$lang['friendlyname'] = 'Self Registration Modul';
$lang['postinstall'] = 'Installationen lyckades! Kom ih&aring;g att st&auml;lla in SelfRegistrations inst&auml;llningarna. Om Captcha modulen &auml;r installerad, s&aring; &auml;r den aktiverad som standard. Vi rekommenderar starkt att du installerar den h&auml;r modulen. Om Captcha modulen &auml;r installerat och du vill st&auml;nga av den, anv&auml;nda nocaptcha param i din selfregistration tagg.';
$lang['postuninstall'] = 'Self Registration modulen &auml;r avinstallerad.';
$lang['uninstalled'] = 'Modulen &auml;r avinstallerad.';
$lang['installed'] = 'Modul version %s installerad.';
$lang['prefsupdated'] = 'Modulens inst&auml;llningar uppdaterat.';
$lang['accessdenied'] = '&Aring;tkomst nekad. V&auml;nligen kontrollera dina r&auml;ttigheter.';
$lang['error'] = 'Fel!';
$lang['upgraded'] = 'Modulen &auml;r nu uppgraderad till version  %s.';
$lang['title_mod_prefs'] = 'Modul Inst&auml;llningar';
$lang['title_mod_admin'] = 'Modul Admin Panel';
$lang['title_admin_panel'] = 'Self Registration Modul';
$lang['moddescription'] = 'En modul som l&aring;ter bes&ouml;kare att registrera sig sj&auml;lva.';
$lang['welcome_text'] = '<p>V&auml;lkommen till self registration module.</p>';
$lang['enable_whitelist'] = 'Enable Whitelist';
$lang['whitelist'] = 'List of whitelist username/emails. One per line. (use * for wildcards)';
$lang['whitelist_trigger_message'] = 'Message to show if a whitelist rule is triggered';
$lang['dont_use'] = 'No Whitelist';
$lang['no_matches'] = 'Don&#039;t allow matched username/emails to register';
$lang['only_matches'] = 'Only allow matched username/emails to register';
?>
