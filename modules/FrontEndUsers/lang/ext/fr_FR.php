<?php
$lang['info_cookiename'] = 'Si coch&eacute;, la fonctionnalit&eacute; &quot;se souvenir de moi&quot; est activ&eacute;e. Ceci est similaire &agrave; la fonctionnalit&eacute; keep-alive du cookie, mais peut durer jusqu&#039;&agrave; 60 jours.';
$lang['msg_username_readonly'] = 'L&#039;authentification de l&rsquo;utilisateur ne permet pas de changer le nom d&#039;utilisateur de ce compte';
$lang['msg_password_readonly'] = 'L&#039;authentification de l&rsquo;utilisateur ne permet pas de changer le mot de passe de ce compte';
$lang['prompt_normallogin'] = 'Login direct';
$lang['move_up'] = 'D&eacute;placer vers le haut';
$lang['move_down'] = 'D&eacute;placer vers le bas';
$lang['title_propmodule'] = 'This property is created by a module, and cannot be edited';
$lang['not_available'] = 'Non disponible';
$lang['prompt_dflt_checked'] = 'Par d&eacute;faut, ce champ doit &ecirc;tre coch&eacute;';
$lang['operation_completed'] = 'Operation compl&eacute;t&eacute;e';
$lang['members'] = 'Membres';
$lang['view_filter'] = 'Voir les filtres';
$lang['data'] = 'Donn&eacute;es';
$lang['applied'] = 'Appliqu&eacute;';
$lang['firstpage'] = '<<';
$lang['prevpage'] = '<';
$lang['nextpage'] = '>';
$lang['lastpage'] = '>>';
$lang['page'] = 'Page';
$lang['prompt_allow_changeusername'] = 'Autoriser le changement d&#039;identifiant par les membres';
$lang['info_allow_changeusername'] = 'Si cela est autoris&eacute;, les utilisateurs pourront modifier leur identifiant en m&ecirc;me temps quel leurs autres param&egrave;tres';
$lang['template_saved'] = 'Gabarit enregistr&eacute;';
$lang['template_resetdefaults'] = 'Gabarit r&eacute;initialis&eacute;';
$lang['lbl_settings'] = 'R&eacute;glages';
$lang['lbl_templates'] = 'Gabarits';
$lang['enable_captcha'] = 'Activer le captcha sur le formulaire de connexion';
$lang['info_enable_captcha'] = 'If the user is not logged in, and the module preference states to display the login form, this option controls wether a captcha will be displayed on the login screen.  If captcha is available';
$lang['pagetype_unauthorized'] = 'Vous n&#039;&ecirc;tes pas autoris&eacute;(e) &agrave; acc&eacute;der &agrave; ce contenu';
$lang['info_contentpage_grouplist'] = 'Sp&eacute;cifiez la liste des groupes du FEU qui auront acc&egrave;s &agrave; cette page. Si vous ne sp&eacute;cifiez aucun groupe, tout utilisateur connnect&eacute; pourra voir cette page';
$lang['pagetype_settings'] = 'R&eacute;glages des pages prot&eacute;g&eacute;es';
$lang['pagetype_groups'] = 'Groupes autoris&eacute;s';
$lang['info_pagetype_groups'] = 'S&eacute;lectionnez les groupes qui pourront (par d&eacute;faut) voir les pages prot&eacute;g&eacute;es. Un &eacute;diteur avec la permission &quot;Manage All Content&quot; pourra surpasser cette permission pour chaque page.';
$lang['pagetype_action'] = 'Action pour un acc&egrave;s non-autoris&eacute;';
$lang['info_pagetype_action'] = 'Sp&eacute;cifiez le comportement du module pour les personnes qui acc&egrave;dent &agrave; cette page et qui ne requ&egrave;rent pas les droits suffisants pour y acc&egrave;der. Vous pouvez soit rediriger vers une page sp&eacute;cifique, soit affiche le formulaire de connexion.';
$lang['showloginform'] = 'Afficher le formulaire de connexion';
$lang['redirect'] = 'Rediriger vers une page';
$lang['pagetype_redirectto'] = 'Rediriger vers';
$lang['info_pagetype_redirectto'] = 'Choisissez la page vers laquelle rediriger.  Si vous n&#039;en choisissez pas, alors que l&#039;action est &quot;rediriger&quot;, le visiteur se verra pr&eacute;senter un message lui indiquant qu&#039;il n&#039;a pas acc&egrave;s &agrave; la page.';
$lang['permissions'] = 'Permissions';
$lang['feu_protected_page'] = 'Contenu prot&eacute;g&eacute;';
$lang['prompt_viewprops'] = 'Choisissez une propri&eacute;t&eacute; compl&eacute;mentaire &agrave; afficher';
$lang['view'] = 'Vue';
$lang['info_ignore_userid'] = 'If checked the import routine will attempt to add users independant of the userid column.  If a user with the name specified in the import file already exists, an error will be generated';
$lang['ignore_userid'] = 'Ignore la colonne UserID lors de l&#039;importation';
$lang['export_passhash'] = 'Export the password hash to the file';
$lang['info_export_passhash'] = 'The password hash is only useful if the password salt on the import host is identical to that of the export host';
$lang['error_adjustsalt'] = 'The password salt cannot be adjusted';
$lang['prompt_pwsalt'] = 'Password Salt';
$lang['info_pwsalt'] = 'FrontEndUsers salts all passwords with this key which is created upon install.  Once users have been added to the database the salt cannot be changed. The salt may be empty for older installs.';
$lang['advanced_settings'] = 'R&eacute;glages avanc&eacute;s';
$lang['info_sessiontimeout'] = 'Sp&eacute;cifier le nombre de secondes avant qu&#039;un utilisateur inactif soir d&eacute;connect&eacute; automatiquement du site';
$lang['prompt_expireusers_interval'] = 'User Expiry Interval';
$lang['info_expireusers_interval'] = 'Specify a value (in seconds) that indicates how often the system should force users whos session has expired to be logged out.  T&quot;his is an optimization to save database queries.  If left empty or set to 0 expiry will be performed on every request.';
$lang['msg_settingschanged'] = 'Vos r&eacute;glages ont &eacute;t&eacute; mis &agrave; jour avec succ&egrave;s';
$lang['forcedlogouttask_desc'] = 'Oblige les utilisateurs &agrave; se d&eacute;connecter &agrave; des intervalles de temps r&eacute;guliers';
$lang['prompt_forcelogout_times'] = 'Temps pour la deconnexion forc&eacute;e';
$lang['info_forcelogout_times'] = 'Specify a comma separated list of times like HH:MM,HH:MM where users will be forcibly logged out. Note, this uses the psuedocron mechanism so you must be sure that the times entered here will coincide reasonably with your &quot;pseudocron granularity&quot; and that sufficient requests will occur to your website to ensure that pseudocron is executed.';
$lang['prompt_forcelogout_sessionage'] = 'Exclure les membres qui n&#039;ont pas &eacute;t&eacute; actifs en <em>(minutes)</em>';
$lang['info_forcelogout_sessionage'] = 'If specified, any users that have been active in this number of seconds will not be forcibly logged out';
$lang['areyousure_delete'] = 'Etes vous s&ucirc;r(e) de vouloir supprimer l&#039;utilisateur : %s';
$lang['error_invalidfileextension'] = 'Le type de fichier upload&eacute; ne semble pas faire partie des fichiers autoris&eacute;s';
$lang['postuninstall'] = 'Toutes les donn&eacute;es associ&eacute;es au module FrontEndUsers ont &eacute;t&eacute; effac&eacute;es';
$lang['info_ecomm_paidregistration'] = 'Si activ&eacute;, ce module va &eacute;couter les &eacute;v&eacute;nements de la suite Ecommerce.
Dans ce cas, les param&egrave;tres suivants sont effectifs.';
$lang['prompt_ecomm_paidregistration'] = 'Ecouter les &eacute;v&eacute;nements des commandes';
$lang['info_paidreg_settings'] = 'Les param&egrave;tres suivants ne s&#039;appliquent que si vous utilisez le module Self Registration permettant des enregistrement payant';
$lang['none'] = 'Aucun';
$lang['delete_user'] = 'Supprimer l&#039;utilisateur';
$lang['expire_user'] = 'Expirez utilisateur';
$lang['prompt_action_ordercancelled'] = 'Action &agrave; effectuer quand un ordre de souscription est annul&eacute;e';
$lang['prompt_action_orderdeleted'] = 'Action &agrave; effectuer quand un ordre de souscription est supprim&eacute;';
$lang['ecommerce_settings'] = 'Param&egrave;tres Ecommerce';
$lang['securefieldmarker'] = 'Marker s&eacute;curis&eacute;&nbsp;';
$lang['securefieldcolor'] = 'Champ color&eacute; s&eacute;curis&eacute;&nbsp;';
$lang['prompt_encrypt'] = 'Stocker ces donn&eacute;es de mani&egrave;re crypt&eacute;e dans la base de donn&eacute;es';
$lang['error_notsupported'] = 'L&#039;option choisie n&#039;est pas support&eacute;e avec la configuration actuelle';
$lang['audit_user_created'] = 'Utilisateur cr&eacute;&eacute; automatiquement';
$lang['info_auto_create_unknown'] = 'Si un utilisateur est authentifi&eacute; par un module externe d&#039;authentification, mais est inconnu dans le module FrontEndUsers, un compte FEU doit-il &ecirc;tre cr&eacute;&eacute; automatiquement ?';
$lang['prompt_auto_create_unknown'] = 'Cr&eacute;&eacute;r automatiquement les utilisateurs inconnus&nbsp;';
$lang['display_settings'] = 'Afficher les r&eacute;glages';
$lang['info_std_auth_settings'] = 'Les r&eacute;glages suivants ne sont applicables qu&#039;avec &quot;l&#039;Authentification int&eacute;gr&eacute;e&quot;.';
$lang['info_support_lostun'] = 'Choisir Non d&eacute;sactive la possibilit&eacute; pour un utilisateur d&#039;utiliser la fonction de r&eacute;cup&eacute;ration des identifiants, ind&eacute;pendamment des autres r&eacute;glages';
$lang['info_support_lostpw'] = 'Choisir Non d&eacute;sactive la possibilit&eacute; pour un utilisateur de r&eacute;initialiser son mot de passe, ind&eacute;pendamment des autres r&eacute;glages';
$lang['prompt_support_lostun'] = 'Autoriser les utilisateurs &agrave; demander leur identifiant&nbsp;';
$lang['prompt_support_lostpw'] = 'Autoriser les utilisateurs &agrave; demander un changement de mot de passe&nbsp;';
$lang['auth_settings'] = 'Param&eacute;tres d&#039;authentification';
$lang['authentication'] = 'Authentification int&eacute;gr&eacute;e';
$lang['auth_builtin'] = 'Authentification Standard de FEU';
$lang['auth_module'] = 'Module/M&eacute;thode d&#039;authentification&nbsp;';
$lang['info_auth_module'] = 'Le module FrontEndUsers supporte l&#039;utilisation de m&eacute;thode alternatives d&#039;authentification, avec des capacit&eacute;s variables. Certaines fonctionnalit&eacute;s ne vont pas fonctionner ou seront d&eacute;sactiv&eacute;es si la m&eacute;thode d&#039;authentification int&eacute;gr&eacute;e n&#039;est pas utilis&eacute;e.';
$lang['error_user_nonunique_field_value'] = 'La valeur sp&eacute;cifi&eacute;e pour % s est d&eacute;j&agrave; utilis&eacute;e par un autre utilisateur';
$lang['unique'] = 'Unique ';
$lang['error_nonunique_field_value'] = 'La valeur sp&eacute;cifi&eacute;e pour % s (% s) n&#039;est pas unique';
$lang['prompt_force_unique'] = 'Forcer la valeur de cette propri&eacute;t&eacute; pour &ecirc;tre unique dans tous les comptes utilisateurs';
$lang['help_returnlast'] = 'Utilis&eacute; avec les formulaires login et logout, si ce param&egrave;tre est sp&eacute;cifi&eacute;, il indiquera que l&#039;utilisateur doit &ecirc;tre renvoy&eacute; vers la page (par URL) que l&#039;utilisateur avait affich&eacute; avant l&#039;action. Ce param&egrave;tre remplace les pr&eacute;f&eacute;rences de redirection, et le param&egrave;tre &quot;returnto&quot;';
$lang['help_noinline'] = 'Utilis&eacute; avec l&#039;un des formulaires, ce param&egrave;tre sp&eacute;cifie que les formulaires ne devraient pas &ecirc;tre mis en ligne, au contraire le r&eacute;sultat de soumission du formulaire remplacera le bloc de contenu par d&eacute;faut';
$lang['title_reset_session'] = 'Avertissement de fin de session';
$lang['msg_reset_session'] = 'Votre session va bient&ocirc;t expirer, veuillez cliquer sur &quot;OK&quot; pour rester connect&eacute;(e).';
$lang['ok'] = 'OK';
$lang['resetsession_template'] = 'Gabarit de remise &agrave; z&eacute;ro de session ';
$lang['info_name'] = 'Ceci est le nom du champ (utilis&eacute; avec Smarty). Il doit comporter uniquement des caract&egrave;res alphanum&eacute;riques ou des underscore (_).';
$lang['visitors_tab'] = 'Visiteurs';
$lang['feu_groups_prompt'] = 'S&eacute;lectionnez un ou plusieurs groupes FEU qui sont autoris&eacute;s &agrave; acc&eacute;der &agrave; cette page';
$lang['error_mustselect_group'] = 'Un groupe doit &ecirc;tre s&eacute;lectionn&eacute;';
$lang['selectone'] = 'S&eacute;lectionner un groupe';
$lang['start_year'] = 'Ann&eacute;e de d&eacute;but';
$lang['end_year'] = 'Ann&eacute;e de fin';
$lang['date'] = 'Date&nbsp;';
$lang['prompt_thumbnail_size'] = 'Taille de vignette&nbsp;';
$lang['OnUpdateGroup'] = 'Lorsqu&#039;un groupe d&#039;utilisateurs est modifi&eacute;';
$lang['error_toomanyselected'] = 'Trop d&#039;utilisateurs sont s&eacute;lectionn&eacute;s pour les op&eacute;rations .... Merci de r&eacute;duire &agrave; 250 ou moins';
$lang['confirm_delete_selected'] = '&Ecirc;tes vous s&ucirc;r(e) de vouloir supprimer les utilisateurs s&eacute;lectionn&eacute;s ?';
$lang['delete_selected'] = 'Supprimer la s&eacute;lection';
$lang['prompt_randomusername'] = 'G&eacute;n&eacute;rer un nom d&#039;utilisateur au hasard lors de l&#039;ajout de nouveaux utilisateurs&nbsp;';
$lang['months'] = 'mois';
$lang['prompt_expireage'] = 'P&eacute;riode d&#039;expiration par d&eacute;faut pour l&#039;utilisateur  ';
$lang['notification_settings'] = 'Param&egrave;tres de notification&nbsp;';
$lang['property_settings'] = 'Param&egrave;tres de propri&eacute;t&eacute;&nbsp;';
$lang['redirection_settings'] = 'Param&egrave;tres de redirection&nbsp;';
$lang['general_settings'] = 'Param&egrave;tres g&eacute;n&eacute;raux&nbsp;';
$lang['session_settings'] = 'Param&egrave;tres de Session et Cookie&nbsp;';
$lang['field_settings'] = 'Param&egrave;tres des champs&nbsp;';
$lang['error_lostun_nonrequired'] = 'Le drapeau &quot;demande lors de la r&eacute;cup&eacute;ration de l&#039;identifiant&quot; ne peut &ecirc;tre utilis&eacute; que sur les champs obligatoires';
$lang['prop_textarea_wysiwyg'] = 'Permettre l&#039;utilisation de l&#039;&eacute;diteur visuel (WYSIWYG) sur cette zone de texte';
$lang['editing_user'] = 'Edition d&#039;utilisateur&nbsp;';
$lang['noinline'] = 'Ne pas mettre en ligne les formulaires';
$lang['info_lostun'] = 'Cliquez ici si vous ne vous souvenez pas de votre identifiant';
$lang['info_forgotpw'] = 'Cliquez ici si vous ne vous souvenez pas de votre mot de passe';
$lang['info_logout'] = 'Cliquez ici pour vous d&eacute;connecter';
$lang['info_changesettings'] = 'Cliquez ici pour modifier votre mot de passe et d&#039;autres informations';
$lang['viewuser_template'] = 'Vue gabarit utilisateur&nbsp;';
$lang['event'] = '&Eacute;v&eacute;nement';
$lang['feu_event_notification'] = 'Notification d&#039;&eacute;v&eacute;nement module FrontEndUser';
$lang['prompt_notification_address'] = 'Adresse email pour la notification&nbsp;';
$lang['prompt_notification_template'] = 'Gabarit d&#039;email pour la notification&nbsp;';
$lang['prompt_notification_subject'] = 'Sujet de l&#039;email pour la notification&nbsp;';
$lang['prompt_notifications'] = 'Notifications par email&nbsp;';
$lang['OnLogin'] = '&Agrave; la connexion';
$lang['OnLogout'] = '&Agrave; la d&eacute;connexion';
$lang['OnExpireUser'] = '&Agrave; l&#039;expiration de la session';
$lang['OnCreateUser'] = 'Lorsqu&#039;un nouvel utilisateur est cr&eacute;&eacute;';
$lang['OnDeleteUser'] = 'Lorsqu&#039;un utilisateur est supprim&eacute;';
$lang['OnUpdateUser'] = 'Lors de changement de param&egrave;tres utilisateur';
$lang['OnCreateGroup'] = 'Lorsqu&#039;un groupe d&#039;utilisateurs est cr&eacute;&eacute;';
$lang['OnDeleteGroup'] = 'Lorsqu&#039;un groupe d&#039;utilisateurs est supprim&eacute;';
$lang['lostunconfirm_premsg'] = 'La fonction de r&eacute;cup&eacute;ration des d&eacute;tails de login oubli&eacute; est termin&eacute;e. Nous avons trouv&eacute; un identifiant unique qui correspond aux d&eacute;tails que vous avez entr&eacute;s.';
$lang['your_username_is'] = 'Votre identifiant est';
$lang['lostunconfirm_postmsg'] = 'Nous vous recommandons d&#039;enregistrer cette information dans un endroit s&ucirc;r, mais facile &agrave; retrouver pour vous.';
$lang['prompt_after_change_settings'] = 'PageID/Alias o&ugrave; se rendre apr&egrave;s la modification&nbsp;';
$lang['prompt_after_verify_code'] = 'L&#039;ID ou l&#039;alias de la page o&ugrave; se rendre apr&egrave;s la v&eacute;rification du code *&nbsp;';
$lang['lostun_details_template'] = 'Gabarit pour la r&eacute;cup&eacute;ration des d&eacute;tails d&#039;identifiant';
$lang['lostun_confirm_template'] = 'Gabarit pour la confirmation de la r&eacute;cup&eacute;ration des d&eacute;tails d&#039;identifiant';
$lang['error_nonuniquematch'] = 'Erreur&nbsp;: Plus d&#039;un utilisateur correspond aux propri&eacute;t&eacute;s d&eacute;finies';
$lang['error_cantfinduser'] = 'Erreur&nbsp;: Impossible de trouver un utilisateur correspondant';
$lang['error_groupnotfound'] = 'Erreur&nbsp;: Impossible de trouver un groupe de ce nom';
$lang['readonly'] = 'Lecture seule';
$lang['prompt_usermanipulator'] = 'Classe de manipulation des identifiants&nbsp;';
$lang['admin_logout'] = 'D&eacute;connect&eacute; par un administrateur';
$lang['prompt_loggedinonly'] = 'Affiche uniquement les utilisateurs connect&eacute;s';
$lang['prompt_logout'] = 'D&eacute;connecter cet utilisateur';
$lang['user_properties'] = 'Propri&eacute;t&eacute;s de l&#039;utilisateur';
$lang['userhistory'] = 'Historique des utilisateurs';
$lang['export'] = 'Exporter';
$lang['clear'] = 'Vider';
$lang['prompt_exportuserhistory'] = 'Exporter en ASCII l&#039;historique utilisateur qui a moins de&nbsp;';
$lang['prompt_clearuserhistory'] = 'Vider l&#039;historique utilisateur qui a plus de&nbsp;';
$lang['title_lostusername'] = 'Avez-vous oubli&eacute; votre identifiant ?';
$lang['title_rssexport'] = 'Exporter la d&eacute;finition du groupe (et ses propri&eacute;t&eacute;s) au format XML';
$lang['title_userhistorymaintenance'] = 'Maintenance de l&#039;historique utilisateur';
$lang['yes'] = 'Oui';
$lang['no'] = 'Non';
$lang['prompt_of'] = 'de';
$lang['date_allrecords'] = '** Non limit&eacute; **';
$lang['date_onehourold'] = '1 heure';
$lang['date_sixhourold'] = '6 heures';
$lang['date_twelvehourold'] = '12 heures';
$lang['date_onedayold'] = '1 jour';
$lang['date_oneweekold'] = '1 semaine';
$lang['date_twoweeksold'] = '2 semaines';
$lang['date_onemonthold'] = '1 mois';
$lang['date_threemonthsold'] = '3 mois';
$lang['date_sixmonthsold'] = '6 mois';
$lang['date_oneyearold'] = '1 an';
$lang['title_groupsort'] = 'Grouper et trier&nbsp;';
$lang['prompt_recordsfound'] = 'Enregistrements qui correspondent aux crit&egrave;res';
$lang['sortorder_username_desc'] = 'Ordre descendant des noms d&#039;utilisateurs';
$lang['sortorder_username_asc'] = 'Ordre ascendant des noms d&#039;utilisateurs';
$lang['sortorder_date_desc'] = 'Ordre descendant de la date';
$lang['sortorder_date_asc'] = 'Ordre ascendant de la date';
$lang['sortorder_action_desc'] = 'Ordre descendant du type d&#039;&eacute;v&eacute;nement';
$lang['sortorder_action_asc'] = 'Ordre ascendant du type d&#039;&eacute;v&eacute;nement';
$lang['sortorder_ipaddress_desc'] = 'Ordre descendant de l&#039;adresse IP';
$lang['sortorder_ipaddress_asc'] = 'Ordre ascendant de l&#039;adresse IP';
$lang['info_nohistorydetected'] = 'Aucun historique d&eacute;tect&eacute;';
$lang['reset'] = 'R&eacute;initialiser';
$lang['prompt_group_ip'] = 'Grouper par adresse IP&nbsp;';
$lang['prompt_filter_eventtype'] = 'Filtre de type d&#039;&eacute;v&eacute;nement&nbsp;';
$lang['prompt_filter_date'] = 'Affiche uniquement les &eacute;v&eacute;nements qui on moins de&nbsp;';
$lang['prompt_pagelimit'] = 'Limite de page&nbsp;';
$lang['for'] = 'pour';
$lang['title_userhistory'] = 'Rapport d&#039;historique d&#039;utilisateur';
$lang['unknown'] = 'Inconnu';
$lang['prompt_ipaddress'] = 'Adresse IP';
$lang['prompt_eventtype'] = 'Type d&#039;&eacute;v&eacute;nement';
$lang['prompt_date'] = 'Date ';
$lang['prompt_return'] = 'Retour';
$lang['import_complete_msg'] = 'Op&eacute;ration d&#039;importation termin&eacute;e';
$lang['prompt_linesprocessed'] = 'Lignes effectu&eacute;es';
$lang['prompt_errors'] = 'Erreurs rencontr&eacute;es';
$lang['prompt_recordsadded'] = 'Enregristrements ajout&eacute;s';
$lang['error_nogroupproprelns'] = 'Impossible de trouver des propri&eacute;t&eacute;s pour le groupe %s';
$lang['error_noresponsefromserver'] = 'Aucune r&eacute;ponse du serveur SMTP';
$lang['error_importfilenotfound'] = 'Impossible de trouver le fichier sp&eacute;cifi&eacute; (%s)';
$lang['error_importfieldvalue'] = 'Valeur invalide pour le champ menu d&eacute;roulant ou multis&eacute;lection %s';
$lang['error_importfieldlength'] = 'Le champ %s d&eacute;passe la longueur maximale';
$lang['error_importusers'] = 'Erreur d&#039;importation (ligne %s): %s';
$lang['error_propertydefns'] = 'Impossible d&#039;obtenir les d&eacute;finitions de propri&eacute;t&eacute; (erreur interne)';
$lang['error_problemsettinginfo'] = 'Probl&egrave;me lors de la d&eacute;finition des infos utilisateur';
$lang['error_importrequiredfield'] = 'Impossible de trouver une colonne qui correspond au champ requis %s';
$lang['error_nogroupproperties'] = 'Impossible de trouver les propri&eacute;t&eacute;s pour le groupe sp&eacute;cifi&eacute;';
$lang['error_importfileformat'] = 'Le fichier sp&eacute;cifi&eacute; pour l&#039;importation n&#039;est pas au bon format';
$lang['error_couldnotopenfile'] = 'Impossible d&#039;ouvrir le fichier';
$lang['info_importusersfileformat'] = '<h4>Information sur le format du fichier</h4>
<p>Le fichier doit &ecirc;tre en format ASCII avec les valeurs s&eacute;par&eacute;es par des virgules. Chaque ligne de ce fichier (&agrave; l&#039;exception de la ligne d&#039;en-t&ecirc;te, voir plus bas) repr&eacute;sent un enregistrement utilisateur. Chaque ligner doit contenir le m&ecirc;me nombre de champ, et l&#039;ordre des champs dans chaque ligne doit &ecirc;tre identique.</p>
<h5>Ligne d&#039;en-t&ecirc;te</h5>
<ul>
<li>La premi&egrave;re ligne du fichier doit commencer par 2 di&egrave;ses (\#), et nomme chacun des champs dans le fichier. Les noms de ces champs sont importants. Il y a quelques noms de champs requis (voir ci-dessous), et pour les autres champs, ils doivent correspondre aux propri&eacute;t&eacute;s associ&eacute;es au groupe d&#039;utilisateurs dans lequel ce fichier va &ecirc;tre import&eacute;.</li>
<li>Le processus d&#039;importation &eacute;chouera si le fichier d&#039;import ne correspond pas &agrave; toutes les propri&eacute;t&eacute;s associ&eacute;es au groupe d&#039;utilisateurs dans lequel ce fichier va &ecirc;tre import&eacute;.</li>
<li>Le fichier peut contenir des champs repr&eacute;sentant les propri&eacute;t&eacute;s optionnelles du groupe sp&eacute;cifi&eacute;.</li>
<li>Le processus d&#039;importation ignorera tout champ du fichier qui est soit inconnu, ou qui ne correspond pas aux propri&eacute;t&eacute;s qui sont <em>d&eacute;sactiv&eacute;es</em> dans le groupe sp&eacute;cifi&eacute;.</li>
</ul>
<h5>Donn&eacute;es tabulaires</h5>
<ul>
<li>Le champ <strong>userid</strong> (en anglais) - Le num&eacute;ro d&#039;identifiant unique pour un utilisateur. A value in this field will indicate you are doing an update.</li>
<li>Le champ <strong>username</strong> (en anglais) - Le nom d&#039;utilisateur d&eacute;sir&eacute;.
    <p>Ce champ doit exister dans la ligne d&#039;en-t&ecirc;te, et doit &ecirc;tre rempli dans chacune des lignes du fichier d&#039;importation. L&#039;enregistrement &eacute;chouera si un utilisateur du m&ecirc;me nom existe d&eacute;j&agrave; dans la base de donn&eacute;es.</p></li>
<li>Le champ <strong>password</strong> (en anglais) - le mot de passe pour l&#039;utilisateur</li>
<li>Le champ <strong>createdate</strong> (en anglais) - la date de cr&eacute;ation pour l&#039;utilisateur</li>
<li>Le champ <strong>expires</strong> (en anglais) - la date d&#039;expiration pour l&#039;utilisateur</li>
<li>The <strong>groupname</strong> Field - The groups that you want to have the user be a member of. If all required fields are not filled in the insert/update of the record will fail. See Multiselect Fields below for syntax.</li>
<li>Champ d&eacute;roulants/Bouton radio
    <p>La valeur des propri&eacute;t&eacute;s de champ d&eacute;roulant dans le fichier d&#039;importation est repr&eacute;sent&eacute;e par le texte qui est affich&eacute; dans le champ d&eacute;roulant dans le module FrontEndUsers.</p>
</li>
<li>Champs &agrave; multis&eacute;lection
    <p>Les champs &agrave; multis&eacute;lection sont contenus dans le fichier ASCII en tant que&nbsp;: une liste s&eacute;par&eacute;e de textes, ou chaque texte repr&eacute;sente le texte affich&eacute; dans la liste &agrave; multis&eacute;lection</p>
</li>
<li>Champs Dates 
    <p>Doivent &ecirc;tre dans le format MM-DD-YYYY</p>
</li>
<li>Champs images
    <p>Les images sont des champs dont le nom de colonne correspond &agrave; une propri&eacute;t&eacute; de type Image. Si ce champ est requis dans le groupe de destination, alors le nom sp&eacute;cici&eacute; dans ces colonnes doit exister dans le dossier &quot;uploads&quot; de l&#039;installation de CMS Made Simple. Si l&#039;image n&#039;existe pas, and que le champ est requis, l&#039;enregistrement &eacute;chouera.</p>
</ul>
<h5>Notes</h5>
<p>Le processus d&#039;importation est sujet aux limitations impos&eacute;es par l&#039;h&eacute;bergeur, telles que limitation de m&eacute;moire, de temps d&#039;ex&eacute;cution, de taille maximale de fichier t&eacute;l&eacute;charg&eacute;, et les restrictions &quot;safemode&quot;. Chacune de ces limitations peut causer l&#039;&eacute;chec de l&#039;importation. D&egrave;s lors, il est recommand&eacute; de s&#039;assurer que les fichiers d&#039;importation soient petits en taille, et de nature simple.</p>
<p>Malgr&eacute; que tout aie &eacute;t&eacute; entrepris afin de s&#039;assurer qu&#039;aucune corruption de la base de donn&eacute;es ne survienne, il est recommand&eacute; de faire une sauvegarde de la base de donn&eacute;e avant d&#039;effectuer un import d&#039;utilisateurs.</p>
<p>L&#039;exportation des donn&eacute;es est dans le m&ecirc;me format pour les besoins d&#039;importation.</p>
<h5>Exemple</h5>
<pre>
##username,first_name,last_name,email,city,state,country,zip
user1,test,user,user1@undomaine.fr,quelquepart,TX,US,12345
</pre>
';
$lang['prompt_importdestgroup'] = 'Importer les utilisateurs dans ce groupe&nbsp;';
$lang['prompt_importfilename'] = 'Entrer un fichier CSV&nbsp;';
$lang['prompt_importxmlfile'] = 'Entrer un fichier XML';
$lang['prompt_exportusers'] = 'Exporter des utilisateurs';
$lang['prompt_importusers'] = 'Importer des utilisateurs';
$lang['prompt_clear'] = 'Vider';
$lang['prompt_image_destination_path'] = 'Chemin de destination de l&#039;image&nbsp;';
$lang['error_missing_upload'] = 'Un probl&egrave;me est apparu avec un t&eacute;l&eacute;chargement manquant (mais requis)';
$lang['error_bad_xml'] = 'Impossible d&#039;analyser le fichier XML fourni';
$lang['error_notemptygroup'] = 'Impossible de supprimer un groupe qui contient encore des utilisateurs';
$lang['error_norepeatedlogins'] = 'Cet utilisateur est d&eacute;j&agrave; connect&eacute;';
$lang['error_captchamismatch'] = 'Le texte de cette image n&#039;a pas &eacute;t&eacute; entr&eacute; correctement';
$lang['prompt_allow_repeated_logins'] = 'Autoriser les utilisateurs &agrave; &ecirc;tre connect&eacute;s plus d&#039;une fois&nbsp;';
$lang['prompt_allowed_image_extensions'] = 'Extensions des fichiers d&#039;images que les utilisateurs sont autoris&eacute;s &agrave; t&eacute;l&eacute;charger&nbsp;';
$lang['event_help_OnRefreshUser'] = '<h3>OnRefreshUser</h3>
<p>An event generated when the user session is refreshed.</p>
<h4>Parameters:</h4>
<ul>
  <li><em>id</em> - The User id</li>
</ul>
';
$lang['event_help_OnDeleteUser'] = '<h3>OnDeleteUser<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur est supprim&eacute;</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>username</em> - le nom de l&#039;utilisateur</li>
<li><em>id</em> - l&#039;id de l&#039;utilisateur</li>
<li><em>props</em> - Un hachage remplis avec les propri&eacute;t&eacute;s de l&#039;utilisateur</li>
</ul> 
';
$lang['event_help_OnCreateUser'] = '<h3>OnCreateUser<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur est cr&eacute;&eacute;</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>name</em> - le nom de l&#039;utilisateur</li>
<li><em>id</em> - l&#039;id de l&#039;utilisateur</li>
</ul> 
';
$lang['event_help_OnUpdateUser'] = '<h3>OnUpdateUser<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur est mis &agrave; jour (par lui-m&ecirc;me ou par un admin)</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>name</em> - le nom de l&#039;utilisateur</li>
<li><em>id</em> - l&#039;id de l&#039;utilisateur</li>
</ul> 
';
$lang['event_help_OnCreateGroup'] = '<h3>OnCreateGroup<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un groupe est cr&eacute;&eacute;</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>name</em> - le nom du groupe</li>
<li><em>description</em> - la description du groupe</li>
<li><em>id</em> - l&#039;id du groupe</li>
</ul> 
';
$lang['event_help_OnDeleteGroup'] = '<h3>OnDeleteGroup<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un groupe est supprim&eacute;</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>name</em> - le nom du groupe</li>
<li><em>id</em> - l&#039;id du groupe</li>
</ul> 
';
$lang['event_help_OnLogin'] = '<h3>OnLogin<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur se connecte</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>username</em> - le nom de l&#039;utilisateur connect&eacute;</li>
<li><em>ip</em> - l&#039;adresse ip du client</li>
</ul>
';
$lang['event_help_OnLogout'] = '<h3>OnLogout<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur se d&eacute;connecte</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>username</em> - le nom de l&#039;utilisateur d&eacute;connect&eacute;</li>
<li><em>id</em> - l&#039;id de l&#039;utilisateur</li>
</ul>
';
$lang['event_help_OnExpireUser'] = '<h3>OnExpireUser<h3>
<p>Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand une session expire</p>
<h4>Param&egrave;tres</h4>
<ul>
<li><em>username</em> - le nom de l&#039;utilisateur dont la session a expir&eacute;</li>
<li><em>id</em> - l&#039;id de l&#039;utilisateur dont la session a expir&eacute;</li>
</ul>
';
$lang['event_info_OnLogin'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur se connecte';
$lang['event_info_OnLogout'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur se d&eacute;connecte';
$lang['event_info_OnExpireUser'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand une session expire';
$lang['event_info_OnCreateUser'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur est cr&eacute;&eacute;';
$lang['event_info_OnRefreshUser'] = 'An event generated when the user session is refreshed';
$lang['event_info_OnUpdateUser'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur est mis &agrave; jour (par lui-m&ecirc;me ou par un admin)';
$lang['event_info_OnDeleteUser'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un utilisateur est supprim&eacute;';
$lang['event_info_OnCreateGroup'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un groupe est cr&eacute;&eacute;';
$lang['event_info_OnUpdateGroup'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un groupe est mis &agrave; jour';
$lang['event_info_OnDeleteGroup'] = 'Un &eacute;v&eacute;nement est g&eacute;n&eacute;r&eacute; quand un groupe est supprim&eacute;';
$lang['backend_group'] = 'Groupe';
$lang['info_star'] = '*Les champs suivants sont gabarits Smarty.<br/>Avec les variables existantes  smarty et les plugins,  les macros suivantes peuvent &ecirc;tre utilis&eacute;es dans ces champs : {$username},{$group}. Lors de l&#039;utilisation de la macro {$group}, le syst&egrave;me remplace le nom du premier groupe auquel l&#039;utilisateur appartient, et va le rediriger sur cette page.';
$lang['info_admin_password'] = '&Eacute;diter ce champ pour r&eacute;initialiser le mot de passe utilisateur';
$lang['info_admin_repeatpassword'] = '&Eacute;diter ce champ pour r&eacute;initialiser le mot de passe utilisateur';
$lang['error_username_exists'] = 'Un utilisateur avec ce nom existe d&eacute;j&agrave;.';
$lang['nocsvresults'] = 'Aucun r&eacute;sultat retourn&eacute; de l&#039;export csv';
$lang['prompt_unfldlen'] = 'Longueur du champ nom d&#039;utilisateur&nbsp;';
$lang['prompt_pwfldlen'] = 'Longueur du champ mot de passe&nbsp;';
$lang['error_invalidpasswordlengths'] = 'Longueur minimale/maximale invalide pour le mot de passe&nbsp;';
$lang['error_invalidusernamelengths'] = 'Longueur minimale/maximale invalide pour le nom d&#039;utilisateur&nbsp;';
$lang['error_invalidemailaddress'] = 'Adresse email invalide';
$lang['error_noemailaddress'] = 'Il n&#039;y a pas d&#039;adresse email enregistr&eacute;e pour ce compte.';
$lang['error_problemseettinginfo'] = 'Probl&egrave;me lors de l&#039;&eacute;dition des infos utilisateur';
$lang['error_settingproperty'] = 'Probl&egrave;me lors de l&#039;&eacute;dition de la propri&eacute;t&eacute;';
$lang['user_added'] = 'Utilisateur ajout&eacute; %s = %s';
$lang['user_deleted'] = 'Utilisateur supprim&eacute; uid=%s';
$lang['propertyfilter'] = 'Propri&eacute;t&eacute;';
$lang['valueregex'] = 'Valeur (expression r&eacute;guli&egrave;re)';
$lang['warning_effectsfieldlength'] = 'Attention : ces champs affectent la taille de champs d&#039;entr&eacute;e dans les formulaires.  Diminuer cette valeur sur un site existant n&#039;est pas recommand&eacute;';
$lang['confirm_submitprefs'] = 'Modifier les pr&eacute;f&eacute;rences administrateur&nbsp;?';
$lang['error_emailalreadyused'] = 'Cette adresse email est d&eacute;j&agrave; utilis&eacute;e';
$lang['prompt_usecookiestoremember'] = 'Utiliser les cookies pour m&eacute;moriser les d&eacute;tails d&#039;identification&nbsp;';
$lang['prompt_cookiename'] = 'Le nom du cookie&nbsp;';
$lang['prompt_allow_duplicate_emails'] = 'Autoriser les doublons d&#039;email&nbsp;';
$lang['prompt_username_is_email'] = 'L&#039;adresse email est le nom d&#039;utilisateur&nbsp;';
$lang['info_cookie_keepalive'] = 'Tente de garder les connexions actives par l&#039;utilisation de cookies <em>le cookie est r&eacute;initialis&eacute; par l&#039;activit&eacute; sur le site</em>';
$lang['info_allow_duplicate_emails'] = '(Autoriser plusieurs utilisateurs partageant la m&ecirc;me adresse email)';
$lang['info_username_is_email'] = '(L&#039;adresse email est le nom de l&#039;utilisateur -- Ne pas cocher si vous choisissez &quot;Autoriser les doublons d&#039;email&quot; !)';
$lang['prompt_allow_duplicate_reminders'] = 'Autoriser des demandes multiples de mot de passe oubli&eacute;&nbsp;';
$lang['info_allow_duplicate_reminders'] = '(Autoriser les utilisateurs &agrave; re-demander une r&eacute;initialisation du mot de passe, malgr&eacute; qu&#039;ils n&#039;aient pas utilis&eacute; une pr&eacute;c&eacute;dente demande)';
$lang['prompt_feusers_specific_permissions'] = 'Utiliser les permissions sp&eacute;cifique de FEUsers ?&nbsp;';
$lang['info_feusers_specific_permissions'] = '(Normalement, les permissions de FEUsers sont identiques aux permissions du panneau d&#039;administration tel que Ajouter un utilisateur, Ajouter une groupe, etc. Si vous s&eacute;lectionnez cette option, il y aura des permissions diff&eacute;rentes pour FEUsers.)';
$lang['error_missingupload'] = 'Impossible de trouver le fichier charg&eacute; (erreur interne)';
$lang['error_problem_upload'] = 'Il y a eu un probl&egrave;me avec le fichier charg&eacute;. Veuillez r&eacute;essayer.';
$lang['error_missingusername'] = 'Vous n&#039;avez pas entr&eacute; de nom d&#039;utilisateur';
$lang['error_missingemail'] = 'Vous ne devez pas entrer votre adresse email';
$lang['error_missingpassword'] = 'Vous n&#039;avez pas entr&eacute; de mot de passe';
$lang['frontenduser_logout'] = 'D&eacute;connexion utilisateur';
$lang['frontenduser_loggedin'] = 'Connexion utilisateur';
$lang['editprop_infomsg'] = '<font color=&quot;red&quot;><b>ATTENTION :</b> en changeant une propri&eacute;t&eacute; qui a &eacute;t&eacute; assign&eacute;e &agrave; des groupes, vous pouvez potentiellement d&eacute;truire ou ab&icirc;mer un site existant <i>(en particulier si vous r&eacute;duisez les longueurs de champs, etc)</i></font>';
$lang['info_smtpvalidate'] = 'Cette fonction ne marche pas sous Windows';
$lang['msg_dontcreateusername'] = 'Ne cr&eacute;ez pas de propri&eacute;t&eacute; pour utilisateur (nom d&#039;utilisateur et mot de passe), car ceci est inclus dans le module FrontEndUsers';
$lang['prompt_exportcsv'] = 'Exporter la liste des utilisateurs au format CSV&nbsp;';
$lang['exportcsv'] = 'Exporter';
$lang['importcsv'] = 'Importer';
$lang['admin'] = 'Admin ';
$lang['editprop'] = '&Eacute;diter la propri&eacute;t&eacute;';
$lang['maxlength'] = 'Longueur maximale';
$lang['created'] = 'Cr&eacute;&eacute;';
$lang['sortby'] = 'Trier par&nbsp;';
$lang['sort'] = 'Tri&nbsp;';
$lang['usersingroup'] = 'Utilisateurs dans le groupe';
$lang['userlimit'] = 'Limiter les r&eacute;sultats &agrave;';
$lang['error_noemailfield'] = 'Aucun email trouv&eacute; pour cet utilisateur. Vous devez &eacute;ventuellement contacter l&#039;administrateur.';
$lang['prompt_forgotpw_page'] = 'PageID/Alias du formulaire mot de passe oubli&eacute;&nbsp;';
$lang['prompt_changesettings_page'] = 'PageID/Alias du formulaire de changement de param&egrave;tres&nbsp;';
$lang['prompt_login_page'] = 'PageID/Alias o&ugrave; rediriger l&#039;utilisateur apr&egrave;s qu&#039;il se soit connect&eacute;&nbsp;';
$lang['prompt_logout_page'] = 'PageID/Alias o&ugrave; rediriger l&#039;utilisateur apr&egrave;s qu&#039;il se soit d&eacute;connect&eacute;&nbsp;';
$lang['sortorder'] = 'Orde de tri';
$lang['prompt_numresetrecord'] = 'Un nombre d&#039;utilisateurs est en cours de r&eacute;initialisation de mots de passe. Ce nombre est actuellement de :';
$lang['remove1week'] = 'Supprimer toutes les entr&eacute;es vieilles de plus d&#039;une semaine';
$lang['remove1month'] = 'Supprimer toutes les entr&eacute;es vieilles de plus d&#039;un mois';
$lang['removeall'] = 'Supprimer toutes les entr&eacute;es';
$lang['areyousure'] = '&Ecirc;tes-vous s&ucirc;r(e)&nbsp;?';
$lang['error_invalidcode'] = 'Un code invalide a &eacute;t&eacute; entr&eacute;, veuillez r&eacute;essayer';
$lang['error_tempcodenotfound'] = 'Le code temporaire pour votre id utilisatuer n&#039;a pas pu &ecirc;tre trouv&eacute; dans la base de donn&eacute;es';
$lang['forgotpassword_verifytemplate'] = 'Gabarit utilis&eacute; pour afficher le formulaire de v&eacute;rification';
$lang['forgotpassword_emailtemplate'] = 'Gabarit utilis&eacute; pour l&#039;email envoy&eacute; lors de l&#039;oubli du mot de passe';
$lang['error_resetalreadysent'] = 'Une demande de r&eacute;initialisation de mot de passe a &eacute;t&eacute; soumise pour ce compte, soit par vous-m&ecirc;me, soit par quelqu&#039;un d&#039;autre. V&eacute;rifiez votre email, vous y trouverez les instructions pour la r&eacute;initialisation de votre mot de passe.';
$lang['error_dberror'] = 'Erreur de base de donn&eacute;es';
$lang['message_forgotpwemail'] = 'Vous recevez ce message car quelqu&#039;un (peut &ecirc;tre vous) a fait une demande de r&eacute;cup&eacute;ration de mot de passe. Si c&#039;est le cas, lisez les instructions ci-dessous. Si vous ne savez pas de quoi il s&#039;agit ou si ce n&#039;est pas vous, vous pouvez simplement effacer ce message (cela n&#039;aura aucune cons&eacute;quence sur votre compte). Nous vous remercions.';
$lang['prompt_code'] = 'Code ';
$lang['message_code'] = 'Le code suivant a &eacute;t&eacute; g&eacute;n&eacute;r&eacute; au hasard pour la v&eacute;rification du compte utilisateur. Lorsque vous cliquerez sur le lien ci-dessous, vous trouverez un champ dans lequel entrer ce code. Normalement, ce champ est rempli pour vous, mais dans le cas contraire, le code est :';
$lang['prompt_link'] = 'Le lien suivant vous am&egrave;ne au site o&ugrave; vous pourrez entrer le code ci-dessus, et r&eacute;initialiser votre mot de passe :';
$lang['lostpassword_emailsubject'] = 'Mot de passe oubli&eacute;';
$lang['error_nomailermodule'] = 'Le module CMSMailer n&#039;a pas &eacute;t&eacute; trouv&eacute;';
$lang['info_forgotpwmessagesent'] = 'Un email a &eacute;t&eacute; envoy&eacute; &agrave; %s avec les instructions pour la r&eacute;initialisation du mot de passe. Merci';
$lang['lostpw_message'] = 'Si vous avez oubli&eacute; votre mot de passe, veuillez entrer votre identifiant ici, et si nous le trouvons, vous recevrez un email avec les instructions pour la r&eacute;initialisation du mot de passe.';
$lang['forgotpassword_template'] = 'Gabarit pour l&#039;oubli du mot de passe';
$lang['lostusername_template'] = 'Gabarit pour la r&eacute;cup&eacute;ration de l&#039;identifiant';
$lang['error_propnotfound'] = 'La propri&eacute;t&eacute; %s n&#039;a pas &eacute;t&eacute; trouv&eacute;e';
$lang['propsfound'] = 'propri&eacute;t&eacute;s trouv&eacute;es';
$lang['addprop'] = 'Ajouter une propri&eacute;t&eacute;';
$lang['error_requiredfield'] = 'Un champ requis (%s) est vide';
$lang['info_emptypasswordfield'] = 'Veuillez entrer ici un nouveau mot de passe';
$lang['error_notloggedin'] = 'Vous ne semblez pas &ecirc;tre connect&eacute;';
$lang['user_settings'] = 'Param&egrave;tres';
$lang['user_registration'] = 'Enregistrement';
$lang['error_accountexpired'] = 'Ce compte est p&eacute;rim&eacute;';
$lang['error_improperemailformat'] = 'Format d&#039;adresse email invalide';
$lang['error_invalidexpirydate'] = 'Date d&#039;expiration invalide. Essayez avec ann&eacute;e ant&eacute;rieure';
$lang['error_problemsettingproperty'] = 'Il y a eu une erreur lors de la d&eacute;finition %s pour l&#039;utilisateur $s';
$lang['error_invalidgroupid'] = 'id de groupe %s invalide';
$lang['hiddenfieldmarker'] = 'Marqueur de champ cach&eacute;&nbsp;';
$lang['hiddenfieldcolor'] = 'Couleur de champ cach&eacute;&nbsp;';
$lang['hidden'] = 'Cach&eacute;';
$lang['error_duplicatename'] = 'Une propri&eacute;t&eacute; du m&ecirc;me nom est d&eacute;j&agrave; d&eacute;finie';
$lang['error_noproperties'] = 'Aucune propri&eacute;t&eacute; d&eacute;finie';
$lang['error_norelations'] = 'Aucun propri&eacute;t&eacute; n&#039;a &eacute;t&eacute; s&eacute;lectionn&eacute;e pour ce groupe';
$lang['nogroups'] = 'Aucun groupe d&eacute;fini';
$lang['groupsfound'] = 'Groupes trouv&eacute;s';
$lang['error_onegrouprequired'] = 'L&#039;appartenance &agrave; au moins un groupe est requise';
$lang['prompt_requireonegroup'] = 'Requiert l&#039;appartenance &agrave; au moins un groupe&nbsp;';
$lang['back'] = 'Retour';
$lang['error_missing_required_param'] = '%s est un champ requis';
$lang['requiredfieldmarker'] = 'Marqueur de champs requis&nbsp;';
$lang['requiredfieldcolor'] = 'Mise en &eacute;vidence des champs requis en&nbsp;';
$lang['next'] = 'Suivant';
$lang['error_groupexists'] = 'Un groupe du m&ecirc;me nom existe d&eacute;j&agrave;';
$lang['required'] = 'Champ requis';
$lang['optional'] = 'Optionel';
$lang['off'] = 'D&eacute;sactiv&eacute;';
$lang['size'] = 'Taille';
$lang['sizecomment'] = '<br/>(Taille maximale d&#039;une des dimensions de l&#039;image en pixels)';
$lang['length'] = 'Longueur';
$lang['lengthcomment'] = '<br>(caract&egrave;res dans le champ texte)';
$lang['seloptions'] = 'Options menu d&eacute;roulant, s&eacute;par&eacute;es par des retours &agrave; la ligne';
$lang['radiooptions'] = 'Label des boutons Radio s&eacute;par&eacute;s par des sauts de ligne. Les valeurs peuvent &ecirc;tre s&eacute;par&eacute;s du texte par un caract&egrave;re exemple : Femme = f';
$lang['prompt'] = 'Invite de saisie';
$lang['prompt_type'] = 'Type ';
$lang['type'] = 'Type ';
$lang['fieldstatus'] = 'Statut du champ';
$lang['usedinlostun'] = 'Demande lors de la r&eacute;cup&eacute;ration de<br/>l&#039;identifiant';
$lang['text'] = 'Texte';
$lang['checkbox'] = 'Case &agrave; cocher';
$lang['multiselect'] = 'Liste multi-s&eacute;lection';
$lang['radiobuttons'] = 'Boutons Radio';
$lang['image'] = 'Image ';
$lang['email'] = 'Adresse email';
$lang['textarea'] = 'Champ de texte';
$lang['dropdown'] = 'Menu d&eacute;roulant';
$lang['msg_currentlyloggedinas'] = 'Bienvenue';
$lang['logout'] = 'D&eacute;connexion';
$lang['prompt_newgroupname'] = 'Utiliser le nom de ce groupe';
$lang['prompt_changesettings'] = 'Changement de mes param&egrave;tres';
$lang['error_loginfailed'] = 'La connexion a &eacute;chou&eacute; : identifiant ou mot de passe invalide ?';
$lang['login'] = 'S&#039;identifier';
$lang['prompt_signin_button'] = 'Texte du bouton de connexion&nbsp;';
$lang['prompt_username'] = 'Identifiant';
$lang['prompt_email'] = 'Adresse email';
$lang['prompt_password'] = 'Mot de passe';
$lang['prompt_rememberme'] = 'Me m&eacute;moriser sur cet ordinateur';
$lang['register'] = 'S&#039;enregistrer';
$lang['forgotpw'] = 'Mot de passe oubli&eacute; ?';
$lang['lostusername'] = 'D&eacute;tails d&#039;identification oubli&eacute;s ?';
$lang['defaults'] = 'Par d&eacute;faut';
$lang['template'] = 'Gabarit';
$lang['error_usernotfound'] = 'ID utilisateur non trouv&eacute;';
$lang['error_usernametaken'] = 'Cet identifiant (%s) existe d&eacute;j&agrave;';
$lang['prompt_smtpvalidate'] = 'Utiliser SMTP pour la validation des adresses email&nbsp;?';
$lang['prompt_minpwlen'] = 'Longueur minimale du mot de passe&nbsp;';
$lang['prompt_maxpwlen'] = 'Longueur maximale du mot de passe&nbsp;';
$lang['prompt_minunlen'] = 'Longueur minimale de l&#039;identifiant&nbsp;';
$lang['prompt_maxunlen'] = 'Longueur maximale de l&#039;identifiant&nbsp;';
$lang['prompt_sessiontimeout'] = 'Expiration de session (secondes)&nbsp;';
$lang['prompt_cookiekeepalive'] = 'Utiliser les cookies pour garder les connexions actives&nbsp;';
$lang['prompt_allowemailreg'] = 'Autorise l&#039;enregistrement par email';
$lang['prompt_dfltgroup'] = 'Groupe par d&eacute;faut pour les nouveaux utilisateurs&nbsp;';
$lang['changesettings_template'] = 'Gabarit pour le changement des param&egrave;tres';
$lang['error_passwordmismatch'] = 'Les mots de passe ne concordent pas';
$lang['error_invalidusername'] = 'Identifiant non valide';
$lang['error_invalidpassword'] = 'Mot de passe non valide';
$lang['edituser'] = '&Eacute;diter l&#039;utilisateur';
$lang['valid'] = 'Valide';
$lang['username'] = 'Identifiant';
$lang['status'] = 'Statut';
$lang['error_membergroups'] = 'Cet utilisateur n&#039;est membre d&#039;aucun groupe';
$lang['error_properties'] = 'Aucune propri&eacute;t&eacute;';
$lang['error_dup_properties'] = 'Tente d&#039;importer des propri&eacute;t&eacute;s &agrave; double';
$lang['value'] = 'Valeur';
$lang['groups'] = 'Groupes';
$lang['properties'] = 'Propri&eacute;t&eacute;s';
$lang['propname'] = 'Nom de propri&eacute;t&eacute;';
$lang['propvalue'] = 'Valeur de la propri&eacute;t&eacute;';
$lang['add'] = 'Ajouter';
$lang['history'] = 'Historique';
$lang['edit'] = '&Eacute;diter';
$lang['expires'] = 'Expire';
$lang['specify_date'] = 'Sp&eacute;cifiez une date';
$lang['12hrs'] = '12 heures';
$lang['24hrs'] = '24 heures';
$lang['48hrs'] = '48 heures';
$lang['1week'] = '1 semaine';
$lang['2weeks'] = '2 semaines';
$lang['1month'] = '1 mois';
$lang['3months'] = '3 mois';
$lang['6months'] = '6 mois';
$lang['1year'] = '1 an';
$lang['never'] = 'Jamais';
$lang['postinstallmessage'] = 'Le module a &eacute;t&eacute; install&eacute; avec succ&egrave;s.<br/>Assurez-vous de d&eacute;finir la permission &quot;Modify FrontEndUser Properties&quot;. De plus, nous vous recommandons d&#039;installer le module Captcha. Lorsque celui-ci est install&eacute;, la validation de l&#039;image captcha sera requise pour se connecter, en plus de l&#039;identifiant et du mot de passe. Ceci est conseill&eacute; pour &eacute;viter les attaques.

<strong>Note:</strong> Le param&egrave;tre &#039;nocaptcha&#039; peut &ecirc;tre utilis&eacute; pour d&eacute;sactiver cette fonction m&ecirc;me lorsque le module Captcha est install&eacute;.

Le module SelfRegistration doit &ecirc;tre install&eacute; pour que le visiteurs puissent s&#039;inscrire sur votre site. Sinon, vous devrez les enregistrer vous m&ecirc;me.';
$lang['password'] = 'Mot de passe';
$lang['repeatpassword'] = 'Re-tapez le mot de passe';
$lang['error_groupname_exists'] = 'Un groupe du m&ecirc;me nom existe d&eacute;j&agrave;';
$lang['editgroup'] = '&Eacute;diter le groupe';
$lang['submit'] = 'Valider';
$lang['cancel'] = 'Annuler';
$lang['delete'] = 'Supprimer';
$lang['confirm_editgroup'] = '&Ecirc;tes-vous s&ucirc;r(e) que cette propri&eacute;t&eacute; est correcte pour ce groupe&nbsp;?\nD&eacute;sactiver une propri&eacute;t&eacute; n&#039;effacera pas les entr&eacute;es dans la table des propri&eacute;t&eacute;s pour ce groupe/utilisateur. Tout au plus, les propri&eacute;t&eacute;s ne seront pas disponibles.';
$lang['areyousure_deletegroup'] = '&Ecirc;tes-vous s&ucirc;r(e) de vouloir supprimer ce groupe&nbsp;?';
$lang['confirm_delete_prop'] = '&Ecirc;tes-vous s&ucirc;r(e) de vouloir compl&egrave;tement supprimer cette propri&eacute;t&eacute;?\nCela supprimera toutes les entr&eacute;es pour cette propri&eacute;t&eacute;';
$lang['error_insufficientparams'] = 'Param&egrave;tres insuffisants';
$lang['id'] = 'Id ';
$lang['name'] = 'Nom';
$lang['error_cantaddprop'] = 'Probl&egrave;me lors de l&#039;ajout d&#039;une propri&eacute;t&eacute;';
$lang['error_cantaddgroupreln'] = 'Probl&egrave;me lors de l&#039;ajout d&#039;une relation de groupe';
$lang['error_cantaddgroup'] = 'Probl&egrave;me lors de l&#039;ajout d&#039;un groupe';
$lang['error_cantassignuser'] = 'Probl&egrave;me lors de l&#039;ajout d&#039;un utilisateur &agrave; un groupe';
$lang['error_couldnotdeleteproperty'] = 'Probl&egrave;me lors de la suppression d&#039;une propri&eacute;t&eacute;';
$lang['error_couldnotfindemail'] = 'Impossible de trouver une adresse email';
$lang['error_destinationnotwritable'] = 'Pas d&#039;acc&egrave;s en &eacute;criture dans le dossier de destination';
$lang['error_invalidparams'] = 'Param&egrave;tres non valides';
$lang['error_nogroups'] = 'Aucun groupe trouv&eacute;';
$lang['applyfilter'] = 'Appliquer';
$lang['filter'] = 'Filtre&nbsp;';
$lang['userfilter'] = 'Identifiant (expression r&eacute;guli&egrave;re)&nbsp;';
$lang['description'] = 'Description ';
$lang['groupname'] = 'Nom du groupe';
$lang['accessdenied'] = 'Acc&egrave;s refus&eacute;';
$lang['error'] = 'Erreur';
$lang['addgroup'] = 'Ajouter un groupe';
$lang['importgroup'] = 'Importer le groupe';
$lang['adduser'] = 'Ajouter un utilisateur';
$lang['usersfound'] = 'Utilisateurs trouv&eacute;s';
$lang['group'] = 'Groupe';
$lang['selectgroup'] = 'S&eacute;lectionner le groupe';
$lang['registration_template'] = 'Gabarit d&#039;enregistrement';
$lang['logout_template'] = 'Gabarit de d&eacute;connexion';
$lang['login_template'] = 'Gabarit de connexion';
$lang['preferences'] = 'Pr&eacute;f&eacute;rences';
$lang['users'] = 'Utilisateurs';
$lang['friendlyname'] = 'Gestion des utilisateurs du site';
$lang['moddescription'] = 'G&egrave;re les utilisateurs du site';
$lang['defaultfrontpage'] = 'Page par d&eacute;faut';
$lang['lastaccessedpage'] = 'Derni&egrave;re page acc&eacute;d&eacute;e';
$lang['otherpage'] = 'Autre page&nbsp;:';
$lang['captcha_title'] = 'Veuillez entrer le texte de l&#039;image';
$lang['utma'] = '156861353.1734876172.1377157497.1377157497.1377157497.1';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1377157497.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
?>