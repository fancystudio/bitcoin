<?php
$lang['eventhandlers_added'] = 'Gestionnaires d&#039;&eacute;v&egrave;nements ajout&eacute;s';
$lang['preferences_updated'] = 'Pr&eacute;f&eacute;rences mises &agrave; jour';
$lang['setup_cart_events'] = 'Installer les &eacute;v&egrave;nements panier';
$lang['setup'] = 'Installer';
$lang['info_setup_cart_events'] = 'Parfois, lors de la mise &agrave; jour, les gestionnaires d&#039;&eacute;v&egrave;nements de panier ne sont pas ajout&eacute;s. Cliquez sur ce bouton pour vous assurer qu&#039;ils soient install&eacute;s. Ceci est important si vous utilisez les enregistrements soumis &agrave; paiement.';
$lang['info_force_email_twice'] = 'Si cette option est activ&eacute;e, le visiteur devra entrer deux fois son identifiant (ou adresse e-mail), et les deux valeurs saisies devront &ecirc;tre identiques';
$lang['prompt_redirect_paidpkg'] = 'ID/Alias de page vers laquelle rediriger pour les packages pay&eacute;s';
$lang['info_redirect_paidpkg'] = 'Un gabarit smarty qui d&eacute;termine l&#039;ID ou l&#039;alias d&#039;une page vers lequel rediriger apr&egrave;s l&#039;inscription payante. Typiquement, un utilisateur qui s&#039;enregistre sur votre site pourrait vouloir aller directement &agrave; la v&eacute;rification du paiement, ou voir la page du panier d&#039;achat.';
$lang['info_additionalgroups_matchfields'] = 'Si vous autorisez les utilisateurs existants &agrave; s&#039;inscrire &agrave; un groupe suppl&eacute;mentaire, vous pouvez d&eacute;finir quelles propri&eacute;t&eacute;s FEU de l&#039;utilisateur donn&eacute; doivent correspondre quand l&#039;utilisateur s&#039;inscrit &agrave; nouveau. Cette information sera utilis&eacute;e pour identifier de mani&egrave;re unique le compte de l&#039;utilisateur FEU.';
$lang['info_cartitem_summary_tpl'] = 'Un gabarit smarty qui d&eacute;termine la valeur du sommaire qui apparait avec la ligne de l&#039;article dans le panier d&#039;achat, et durant le processus de paiement. Si aucune valeur n&#039;est sp&eacute;cifi&eacute;e, une valeur par d&eacute;faut est utilis&eacute;e. Les variables smarty valides sont {$pkg} <em>(array)</em>.  {$sku}, {$username}, {$tmpuid} <em>(l&#039;id utilisateur provisoire)</em>. <strong>Note :</strong> certaines passerelles de paiement n&#039;autorisent qu&#039;un nombre fix&eacute; de caract&egrave;res pour le sommaire.';
$lang['prompt_cartitem_summary_tpl'] = 'Gabarit du sommaire panier';
$lang['paid_registration'] = 'Inscription pay&eacute;e';
$lang['info_skip_final_msg'] = 'Cette option d&eacute;termine si le message de l&#039;enregistrement complet doit &ecirc;tre affich&eacute; &agrave; l&#039;utilisateur apr&egrave;s son inscription.';
$lang['notifications'] = 'Notifications ';
$lang['info_login_afterverify'] = 'Cette option va automatiquement ouvrir une session pour le visiteur dans le site apr&egrave;s que l&#039;utilisateur a &eacute;t&eacute; pouss&eacute; par le module Frontend Users. Cette option n&#039;a aucun effet si l&#039;enregistrement avec paiement est autoris&eacute;';
$lang['info_email_confirmation'] = 'Cette option envoie un email &agrave; l&#039;utilisateur avec un lien permettant de valider les informations du compte. <br/> <strong> Note : <strong> Cette option ne doit pas &ecirc;tre utilis&eacute; si l&#039;enregistrement avec paiement est autoris&eacute;';
$lang['prompt_registration_settings'] = 'Enregistrement des param&egrave;tres';
$lang['none'] = 'Aucune';
$lang['month'] = 'Mois ';
$lang['year'] = 'Ann&eacute;e';
$lang['subscription_expires'] = 'Renouvellement abonnement tous les';
$lang['error_policycantadd'] = 'La politique de ce site ne permet pas d&#039;ajouter cet item &agrave; votre panier. merci de contacter l&#039;administrateur du site';
$lang['prompt_allow_select_pkg'] = 'Autoriser les utilisateurs &agrave; choisir un package(groupe) pour l&#039;enregistrement&nbsp;';
$lang['info_allowselectpkg'] = 'Vous pouvez permettre &agrave; vos utilisateurs de s&eacute;lectionner un groupe FEU pour s&#039;inscrire. Ces groupes sont li&eacute;s &agrave; des forfaits (&agrave; des fins de commerce &eacute;lectronique). Cependant si vous n&#039;utilisez pas la fonctionnalit&eacute; e-commerce, les donn&eacute;es de prix peut &ecirc;tre ignor&eacute;es';
$lang['error_nopkgs'] = 'Aucun package n&#039;a &eacute;t&eacute; d&eacute;finis pour permettre au client de s&#039;inscrire';
$lang['selpkg_template'] = 'Gabarit de choix de package';
$lang['title_selpkg_template'] = 'Gabarit de choix du package d&#039;enregistrement';
$lang['info_selpkg_template'] = 'Ce gabarit est utilis&eacute; lorsque l&#039;abonnement pay&eacute; est activ&eacute; pour permettre &agrave; l&#039;utilisateur de choisir une formule d&#039;abonnement';
$lang['error_pkgcost'] = 'Le co&ucirc;t du package est invalide';
$lang['error_pkgexists'] = 'Un package avec %s de %s existe d&eacute;ja';
$lang['description'] = 'Description ';
$lang['edit_paidpkg'] = 'Editer le package &quot;%s&quot;';
$lang['add_paidpkg'] = 'Ajouter le package payant';
$lang['name'] = 'Nom&nbsp;';
$lang['prompt'] = 'Prompt&nbsp;';
$lang['group'] = 'Groupe&nbsp;';
$lang['cost'] = 'Co&ucirc;t&nbsp;';
$lang['regpkgs_tab'] = 'Packages d&#039;inscription';
$lang['prompt_allow_paid_registration'] = 'Demander aux membres de payer pour l&#039;enregistrement &agrave; votre site';
$lang['info_allow_paid_registration'] = 'S&eacute;lectionner &eacute;galement Selfregistration comme source du module CGEcommerceBase, et configurer l&#039;onglet &quot;Inscription pay&eacute;e&quot;. En outre, vous devez activer s&eacute;lection des packages ci-dessus.';
$lang['email-password'] = 'Adresse de courriel et mot de passe';
$lang['username-password'] = 'Nom d&#039;utilisateur et mot de passe';
$lang['help_param_allowoverwrite'] = 'Ce param&egrave;tre permet d&#039;&eacute;craser les utilisateurs FEU existants. En conjonction avec les pr&eacute;f&eacute;rences dans le panneau d&#039;administration de SelfRegistration vous pouvez sp&eacute;cifier quelles donn&eacute;es seront utilis&eacute;es pour sp&eacute;cifier un compte utilisateur unique';
$lang['into_additionalgroups_matchfields'] = 'Sp&eacute;cifier les champs qui doivent &ecirc;tre utilis&eacute;s pour identifier un utilisateur unique. Ceci peut &ecirc;tre utilis&eacute; pour permettre &agrave; l&#039;utilisateur de s&#039;enregistrer quand un compte existe d&eacute;j&agrave; pour cet utilisateur avec un nom d&#039;utilisateur diff&eacute;rent.';
$lang['prompt_additionalgroups_matchfields'] = 'Lors de l&#039;&eacute;crasement d&#039;un compte existant dans les champs suivants doit correspondre&nbsp;';
$lang['prompt_reg_additionalgroups'] = 'Autoriser les utilisateurs existants &agrave; s&#039;inscrire &agrave; d&#039;autres groupes&nbsp;';
$lang['prompt_additionalgroups_settings'] = 'Param&egrave;tres suppl&eacute;mentaires Groupes&nbsp;';
$lang['prompt_general_settings'] = 'Param&egrave;tres g&eacute;n&eacute;raux';
$lang['prompt_security_settings'] = 'Param&egrave;tres de s&eacute;curit&eacute;';
$lang['error_uniquefield'] = 'La valeur indiqu&eacute;e pour &quot;% s&quot; est d&eacute;j&agrave; utilis&eacute; par un autre utilisateur enregistr&eacute;';
$lang['help_param_action'] = 'Ce param&egrave;tre dicte le comportement du module.
<ul>
  <li><strong>default</strong>
   <p>C&#039;est l&#039;action par d&eacute;faut.  Bas&eacute; sur le <em>(deprecated)</em> mode parameter <em>(voir ci-desous)</em>, cela va afficher soit le formulaire d&#039;enregistrement d&#039;utilisateur, soit le formulaire de v&eacute;rification, ou un autre formulaire.</p></li>

  <li>reguser_link
   <p>Affiche un lien vers le formulaire d&#039;enregistrement d&#039;utilisateur.</p>
  </li>
</ul>';
$lang['help_param_destpage'] = 'Applicable uniquement &agrave; l&#039;action=reguser_link.. ce param&egrave;tre permet de sp&eacute;cifier (par un alias ou un identifiant de page) une page de destination pour le lien.';
$lang['help_param_group'] = 'Applicable si action=reguser_link ou action=register, ce param&egrave;tre permet de sp&eacute;cifier un groupe dans lequel l&#039;utilisateur sera enregistr&eacute;';
$lang['help_param_onlyhref'] = 'Utilis&eacute; seulement si action=reguser_link, valoriser ce param&egrave;tre indique que l&#039;affichage doit contenir uniquement la partie URL du lien';
$lang['help_param_linktext'] = 'Utilis&eacute; seulement dans action_reguser_link, cela permet de sp&eacute;cifier le texte pour le lien g&eacute;n&eacute;r&eacute;.  Ce param&egrave;tre est ignor&eacute; si le param&egrave;tre onlyhref est sp&eacute;cifi&eacute;.';
$lang['help_param_noinline'] = 'Applicable &agrave; beaucoup d&#039;actions, ce param&egrave;tre (prioritaire aux pr&eacute;f&eacute;rences du panneau d&#039;administration) indique que la sortie du lien g&eacute;n&eacute;r&eacute; ou du formulaire ne doit pas &ecirc;tre affich&eacute; en inline.  ex : noinline=1 : sur l&#039;action par d&eacute;faut, cela indique que le texte de sortie va remplacer la balise {content}.';
$lang['error_noregister'] = 'Vous ne pouvez pas cr&eacute;er un compte pour devenir membre de ce groupe d&#039;utilisateurs';
$lang['prompt_noregister'] = 'Absolument interdit aux utilisateurs de s&#039;inscrire &agrave; ces groupes&nbsp;';
$lang['error_nosecondemailaddress'] = 'Vous devez entrer deux fois votre adresse e-mail';
$lang['push_live'] = 'Passer cet utilisateur dans FEU';
$lang['areyousure_pushuser'] = '&Ecirc;tes-vous s&ucirc;r de vouloir passer cet utilisateur dans FEU sans achever le processus de validation ?';
$lang['delete'] = 'Supprimer';
$lang['login_afterverify'] = 'Authentifie automatiquement l&#039;utilisateur dans FrontEndUsers apr&egrave;s la v&eacute;rification des &eacute;tapes d&#039;enregistrement&nbsp;';
$lang['skip_final_msg'] = 'Ne pas afficher le message final apr&egrave;s l&#039;enregistrement&nbsp;';
$lang['redirect_afterregister'] = 'PageID/Alias o&ugrave; rediriger l&#039;utilisateur apr&egrave;s l&#039;enregistrement&nbsp;';
$lang['redirect_afterverify'] = 'PageID/Alias o&ugrave; rediriger l&#039;utilisateur apr&egrave;s l&#039;&eacute;tape de v&eacute;rification&nbsp;';
$lang['use_inline_forms'] = 'Utiliser des formulaires inline (le formulaire g&eacute;n&eacute;r&eacute; remplace la balise du module, pas tout le contenu)&nbsp;';
$lang['error_codesdontmatch'] = 'La cl&eacute; de validation fournie n&#039;est pas valide';
$lang['event_description_onNewUser'] = 'Un &eacute;v&eacute;nement indique qu&#039;un nouvel utilisateur a compl&eacute;t&eacute; le formulaire d&#039;enregistrement';
$lang['event_description_onUserRegistered'] = 'Un &eacute;v&eacute;nement indique qu&#039;un utilisateur a v&eacute;rifi&eacute; son information et est maintenant compl&egrave;tement enregistr&eacute;';
$lang['event_help_onNewUser'] = '<p>Un &eacute;v&eacute;nement indique qu&#039;un nouvel utilisateur a compl&eacute;t&eacute; le formulaire d&#039;enregistrement</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>username</em> - Identifiant (ou e-mail) du nouvel utilisateur</li>
<li><em>email</em> - L&#039;adresse email du nouvel utilisateur</li>
</ul>
';
$lang['event_help_onUserRegistered'] = '<p>Un &eacute;v&eacute;nement indique qu&#039;un utilisateur a v&eacute;rifi&eacute; et est maintenant enregistr&eacute; avec le module FrontEndUsers (Gestion des utilisateurs du site)</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>username</em> - Identifiant (ou e-mail) du nouvel utilisateur</li>
<li><em>id</em> - L&#039;ID du nouvel utilisateur</li>
</ul>
';
$lang['confirm_submitprefs'] = 'Changer les pr&eacute;f&eacute;rence de l&#039;administrateur ?';
$lang['info_admin_password'] = 'Laissez ce champ vide pour pr&eacute;servez le mot de passe utilisateur';
$lang['info_admin_repeatpassword'] = 'Laissez ce champ vide pour pr&eacute;servez le mot de passe utilisateur';
$lang['error_emaildoesnotmatch'] = 'L&#039;adresse de courriel ne correspond pas';
$lang['force_email_twice'] = 'Demande aux utilisateurs d&#039;entrer leur adresse email deux fois&nbsp;';
$lang['again'] = '&agrave; nouveau';
$lang['deleteselusers'] = 'Efface les utilisateurs s&eacute;lectionn&eacute;s';
$lang['error_nopropdefns'] = 'Pas de propri&eacute;t&eacute;s d&eacute;finies, ou probl&egrave;me pour les obtenir de la base de donn&eacute;es';
$lang['error_nogroups'] = 'Il n&#039;y a pas de groupe cr&eacute;&eacute;, ou il y a un probl&egrave;me pour obtenir la liste des groupes';
$lang['error_dberror'] = 'Erreur de la base de donn&eacute;es';
$lang['title_post_sendanotheremail_template'] = 'Gabarit envoi perdu de courriel';
$lang['title_sendanotheremail_template'] = 'Gabarit de courriel perdu';
$lang['clickhere'] = 'Cliquez ici';
$lang['msg_sendanotheremail'] = 'J&#039;ai d&eacute;j&agrave; compl&eacute;t&eacute; le formulaire d&#039;enregistrement mais je n&#039;ai pas re&ccedil;u d&#039;email, pouvez-vous le renvoyer s.v.p. ';
$lang['sendanotheremail_template'] = 'Gabarit d&#039;email perdu';
$lang['info_userverified'] = 'Un nouvel utilisateur a &eacute;t&eacute; ajout&eacute; au module FrontEndUsers';
$lang['edit'] = '&Eacute;diter';
$lang['unknown'] = 'Inconnu';
$lang['select'] = 'S&eacute;lectionner';
$lang['check_all'] = 'Tout s&eacute;lectionner';
$lang['uncheck_all'] = 'Tout d&eacute;s&eacute;lectionner';
$lang['send_adjustmentemail'] = 'Envoyer un courriel &agrave; l&#039;utilisateur';
$lang['txt_adjustmentemail'] = '(Informer les utilisateurs que leur compte a &eacute;t&eacute; modifi&eacute;)';
$lang['txt_changepassword'] = 'Remplissez ces champs pour modifier le mot de passe utilisateur';
$lang['edituser'] = '&Eacute;diter l&#039;utilisateur';
$lang['areyousure_deleteuser'] = '&Ecirc;tes-vous s&ucirc;r de vouloir effacer cet utilisateur partiellement enregistr&eacute; ? ';
$lang['hdr_userid'] = 'ID utilisateur';
$lang['hdr_username'] = 'Nom d&#039;utilisateur';
$lang['hdr_grpname'] = 'Groupe';
$lang['hdr_created'] = 'Cr&eacute;&eacute;';
$lang['hdr_email'] = 'Courriel';
$lang['usersfound'] = 'Utilisateurs trouv&eacute;s (limit&eacute; &agrave; un maximum de 250)';
$lang['users'] = 'Utilisateurs';
$lang['list1day'] = 'Lister toutes les entr&eacute;es plus vieille d&#039;un jour ';
$lang['subject'] = 'Sujet pour l&#039;email envoy&eacute;&nbsp;';
$lang['htmlbody'] = 'Corps du message HTML&nbsp;';
$lang['textbody'] = 'Texte du corps du message&nbsp;';
$lang['prompt_numresetrecord'] = 'Un certain nombre d&#039;utilisateurs sont au milieu du processus d&#039;enregistrement. Leur nombre actuel est de :';
$lang['remove1week'] = 'Supprimer toutes les entr&eacute;es de plus d&#039;une semaine';
$lang['remove1month'] = 'Supprimer toutes les entr&eacute;es de plus d&#039;un mois';
$lang['remove1day'] = 'Supprimer toutes les entr&eacute;es de plus d&#039;un jour';
$lang['removeall'] = 'Supprimer toutes les entr&eacute;es';
$lang['areyousure'] = '&Ecirc;tes-vous s&ucirc;r ?';
$lang['registration_info_edited'] = 'Votre information d&#039;enregistrement a &eacute;t&eacute; modifi&eacute;e';
$lang['registration_confirmation'] = 'Confirmation d&#039;enregistrement';
$lang['user_registration'] = 'S&#039;enregistrer';
$lang['finalmessage_template'] = 'Gabarit de message final';
$lang['title_verifyregistration'] = 'V&eacute;rifier l&#039;enregistrement';
$lang['code'] = 'Cl&eacute; de validation';
$lang['default'] = 'Valeurs par d&eacute;faut';
$lang['error_noproperties'] = 'Aucune propri&eacute;t&eacute; n&#039;a &eacute;t&eacute; trouv&eacute;e pour cet utilisateur';
$lang['error_noproprelations'] = 'Pas de relation de propri&eacute;t&eacute;';
$lang['error_emailinvalid'] = 'Adresse email invalide';
$lang['error_noemailaddress'] = 'Aucun champ d&#039;adresse email valide n&#039;a &eacute;t&eacute; trouv&eacute; pour cet utilisateur';
$lang['error_requiredfield'] = 'Le champ %s doit &ecirc;tre rempli';
$lang['registration1_template'] = 'Gabarit d&#039;enregistrement 1';
$lang['registration2_template'] = 'Gabarit formulaire de validation';
$lang['emailconfirm_template'] = 'Gabarit d&#039;E-mail de confirmation';
$lang['emailuseredited_template'] = 'Gabarit d&#039;informations utilisateur chang&eacute;es';
$lang['preferences'] = 'Pr&eacute;f&eacute;rences';
$lang['error_usernotfound'] = 'Utilisateur introuvable';
$lang['error_invalidusername'] = 'Le nom d&#039;utilisateur est invalide (trop long, trop court ou contient des caract&egrave;res non valides). Indice - les noms d&#039;utilisateurs ne doivent contenir que des caract&egrave;res alphanum&eacute;riques (sans espaces)';
$lang['error_invalidemail'] = 'Adresse email non valide.';
$lang['error_usernametaken'] = 'Ce nom d&#039;utilisateur est d&eacute;j&agrave; utilis&eacute; par quelqu&#039;un d&#039;autre';
$lang['error_passwordsdontmatch'] = 'Erreur : les mots de passe ne correspondent pas ';
$lang['error_invalidpassword'] = 'Le mot de passe n&#039;est pas valide (les mots de passe doivent &ecirc;tre entre %s et %s caract&egrave;res de long) ';
$lang['error_emptyusername'] = 'Le nom d&#039;utilisateur ne peut pas &ecirc;tre vide';
$lang['error_emptyemail'] = 'le champs Email ne peut pas &ecirc;tre vide';
$lang['repeatpassword'] = 'Mot de passe (&agrave; nouveau)';
$lang['password'] = 'Mot de passe';
$lang['username'] = 'Nom d&#039;utilisateur';
$lang['email'] = 'Email&nbsp;';
$lang['captcha_title'] = 'Entrer le texte figurant dans l&#039;image';
$lang['error_insufficientparams'] = 'Nombre insuffisant (ou incorrect) de param&egrave;tres envoy&eacute;s au module';
$lang['error_nofeusersmodule'] = 'N&#039;a pas pu recevoir d&#039;instance du module FrontEndUsers';
$lang['error_nosuchgroup'] = 'Le nom du groupe sp&eacute;cifi&eacute; n&#039;existe pas';
$lang['error_captchamismatch'] = 'Le texte contenu dans l&#039;image n&#039;est pas correct';
$lang['send_emails_to'] = 'L&#039;email d&#039;enregistrement devrait &ecirc;tre envoy&eacute; &agrave;&nbsp;';
$lang['require_email_confirmation'] = 'N&eacute;cessite que l&#039;utilisateur confirme son enregistrement par email&nbsp;';
$lang['notify_on_registration'] = 'Envoie un email de notification lorsque quelqu&#039;un s&#039;enregistre&nbsp;';
$lang['cancel'] = 'Annuler';
$lang['submit'] = 'Envoyer';
$lang['friendlyname'] = 'Auto-enregistrement utilisateurs';
$lang['postinstall'] = 'L&#039;installation est r&eacute;ussie, pensez bien &agrave; d&eacute;finir les permissions &quot;des r&eacute;glages du Module d&#039;auto-enregistrement&quot;. Si le Captcha est install&eacute;, la fonction Captcha fonctionne par d&eacute;faut. Nous vous recommandons fortement d&#039;installer ce module (pour &eacute;viter les inscriptions par des robots). Si le module Captcha est install&eacute;, et que vous voulez le d&eacute;sactiver, utilisez le param&egrave;tre &quot;nocaptcha&quot; dans votre balise d&#039;auto-enregistrement.';
$lang['postuninstall'] = 'Le module d&#039;auto-enregistrement est d&eacute;sinstall&eacute;. A bient&ocirc;t.';
$lang['uninstalled'] = 'Module d&eacute;sinstall&eacute;.';
$lang['installed'] = 'La version %s du module est install&eacute;e.';
$lang['prefsupdated'] = 'Les pr&eacute;f&eacute;rences du module ont &eacute;t&eacute; mise &agrave; jour.';
$lang['accessdenied'] = 'Acc&egrave;s interdit. V&eacute;rifiez vos permissions.';
$lang['error'] = 'Erreur !';
$lang['upgraded'] = 'Le module a &eacute;t&eacute; mis &agrave; jour &agrave; la version %s';
$lang['title_mod_prefs'] = 'Pr&eacute;f&eacute;rences du module';
$lang['title_mod_admin'] = 'Panneau d&#039;administration du module';
$lang['title_admin_panel'] = 'Module d&#039;auto-enregistrement';
$lang['moddescription'] = 'Un module qui permet aux utilisateurs de s&#039;enregistrer par eux-m&ecirc;mes.';
$lang['welcome_text'] = '<p>Bienvenue dans le module d&#039;auto-enregistrement.</p>';
$lang['enable_whitelist'] = 'D&eacute;marrer la Liste Blanche';
$lang['whitelist'] = 'Liste blanche des nom d&#039;utilisateur/emails. Un par ligne. (Utiliser des jokers *)&nbsp;';
$lang['whitelist_trigger_message'] = 'Message &agrave; afficher si une r&eacute;gle de la Liste Blanche est d&eacute;clench&eacute;e&nbsp;';
$lang['dont_use'] = 'Pas de Liste Blanche';
$lang['no_matches'] = 'Ne laissez pas appari&eacute;s nom d&#039;utilisateur/email pour s&#039;inscrire';
$lang['only_matches'] = 'N&#039;autorisez que nom d&#039;utilisateur/email pour s&#039;inscrire';
?>
