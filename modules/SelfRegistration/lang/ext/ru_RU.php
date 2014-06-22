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
$lang['prompt_registration_settings'] = 'Registration Settings';
$lang['none'] = 'None';
$lang['month'] = 'Month';
$lang['year'] = 'Year';
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
$lang['edit_paidpkg'] = 'Edit Paid Package "%s"';
$lang['add_paidpkg'] = 'Add Paid Package';
$lang['name'] = 'Name';
$lang['prompt'] = 'Prompt';
$lang['group'] = 'Group';
$lang['cost'] = 'Cost';
$lang['regpkgs_tab'] = 'Registration Packages';
$lang['prompt_allow_paid_registration'] = 'Require members to pay for registration to your site';
$lang['info_allow_paid_registration'] = 'Please also select Selfregistration as a source module from CGEcommerceBase, and configure the "Paid Registration" Tab.  Additionally, you must enable package selection above.';
$lang['email-password'] = 'Email Address and Password';
$lang['username-password'] = 'Username and Password';
$lang['help_param_allowoverwrite'] = 'This parameter allows overwriting existing FEU users. In conjunction with the preferences in the SelfRegistration admin panel you can specify what data will be used to uniquely identify a user account\';';
$lang['into_additionalgroups_matchfields'] = 'Specify which fields should be used to uniquely identify a user.  This can be used to allow the user to register when an account already exists for that user with a different username.';
$lang['prompt_additionalgroups_matchfields'] = 'When overwriting an existing account the following fields must match';
$lang['prompt_reg_additionalgroups'] = 'Allow existing users to register for additional groups?';
$lang['prompt_additionalgroups_settings'] = 'Additional Groups Settings';
$lang['prompt_general_settings'] = 'General Settings';
$lang['prompt_security_settings'] = 'Security Settings';
$lang['error_uniquefield'] = 'The value specified for "%s" is already in use by another registered user';
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
$lang['error_nosecondemailaddress'] = 'You did not enter your email address twice';
$lang['push_live'] = 'Push this user into FEU';
$lang['areyousure_pushuser'] = 'Are you sure you want to push this user into FEU without completing the validation process?';
$lang['delete'] = 'Удалить';
$lang['login_afterverify'] = 'Автоматически осуществлять вход пользователя после прохождения проверки';
$lang['skip_final_msg'] = 'Не отображать сообщение после регистрации';
$lang['redirect_afterregister'] = 'PageID/Alias для переадресации после регистрации установлен';
$lang['redirect_afterverify'] = 'PageID/Alias to redirect to after verification step is complete';
$lang['use_inline_forms'] = 'Use Inline Forms <em>(form output replaces the module tag, not all of content)</em>';
$lang['error_codesdontmatch'] = 'Переданный ключ подтверждения неверен';
$lang['event_description_onNewUser'] = 'Событие показывает что новый пользователь завершил регистрацию';
$lang['event_description_onUserRegistered'] = 'Событие показывает что пользователь подтвердил свои данные и теперь зарегистрирован.';
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
</ul>
';
$lang['confirm_submitprefs'] = 'Изменить настройки Администратора?';
$lang['info_admin_password'] = 'Оставьте это поле пустым для сохранения пользовательского пароля';
$lang['info_admin_repeatpassword'] = 'Оставьте это поле пустым для сохранения пользовательского пароля';
$lang['error_emaildoesnotmatch'] = 'Адреса Email не совпадают';
$lang['force_email_twice'] = 'Потребовать от пользователей повторного ввода email';
$lang['again'] = 'снова';
$lang['deleteselusers'] = 'Удалить выбранных пользователей';
$lang['error_nopropdefns'] = 'Нет определений свойства, или ошибка доступа к базе данных';
$lang['error_nogroups'] = 'Нет групп, или проблема при отображении списка групп';
$lang['error_dberror'] = 'Ошибка базы данных';
$lang['title_post_sendanotheremail_template'] = 'Шаблон Post Lost Email';
$lang['title_sendanotheremail_template'] = 'Шаблон восстановления утерянного email-a';
$lang['clickhere'] = 'Щелкните здесь';
$lang['msg_sendanotheremail'] = 'Я уже заполнил регистрационную форму, но не получил сообщения. Могли бы выслать сообщение повторно?';
$lang['sendanotheremail_template'] = 'Шаблон формы утерянного  Email';
$lang['info_userverified'] = 'Добавлне новый пользователь';
$lang['edit'] = 'Редактировать';
$lang['unknown'] = 'Неизвестный';
$lang['select'] = 'Выбрать';
$lang['check_all'] = 'Отметить все';
$lang['uncheck_all'] = 'Снять отметку со всех';
$lang['send_adjustmentemail'] = 'Послать сообщение пользователю';
$lang['txt_adjustmentemail'] = '(информирует пользователя о том, что его учетная запись была изменена';
$lang['txt_changepassword'] = 'Заполните эти поля для для изменения пароля пользователя';
$lang['edituser'] = 'Редактировать пользователя';
$lang['areyousure_deleteuser'] = 'Вы уверены что хотите удалить не полностью зарегистрированного пользователя?';
$lang['hdr_userid'] = 'ID пользователя';
$lang['hdr_username'] = 'Имя пользователя';
$lang['hdr_grpname'] = 'Группа';
$lang['hdr_created'] = 'Создан';
$lang['hdr_email'] = 'Сообщение';
$lang['usersfound'] = 'Пользователей найдено (максимум 250)';
$lang['users'] = 'Пользователи';
$lang['list1day'] = 'Отобразить все записи, старее 1 дня';
$lang['subject'] = 'Тема для исходящих сообщений';
$lang['htmlbody'] = 'тело HTML сообщения';
$lang['textbody'] = 'Тело сообщения';
$lang['prompt_numresetrecord'] = 'Число пользователей не завершивших регистрацию. Сейчас это число:';
$lang['remove1week'] = 'Удалить все записи старше одной недели';
$lang['remove1month'] = 'Удалить все записи старше одного месяца';
$lang['remove1day'] = 'Удалить все записи старше одного дня';
$lang['removeall'] = 'Удалить все записи';
$lang['areyousure'] = 'Вы уверены?';
$lang['registration_info_edited'] = 'Данные вашей регистрации были изменены';
$lang['registration_confirmation'] = 'Подтверждение регистрации';
$lang['user_registration'] = 'Зарегистрироваться';
$lang['finalmessage_template'] = 'Шаблон финального сообщения';
$lang['title_verifyregistration'] = 'Подтвердить регистрацию';
$lang['code'] = 'Ключ подтверждения';
$lang['default'] = 'Установки по-умолчанию';
$lang['error_noproperties'] = 'Не найдено свойств для этого пользователя';
$lang['error_noproprelations'] = 'No property relations';
$lang['error_emailinvalid'] = 'Неверный email адрес ';
$lang['error_noemailaddress'] = 'Обнаружен неверный адрес электронной почты';
$lang['error_requiredfield'] = 'Поле %s должно быть заполнено';
$lang['registration1_template'] = 'Шаблон регистрации 1';
$lang['registration2_template'] = 'Шаблон регистрации 2';
$lang['emailconfirm_template'] = 'Шаблон подтверждения Email ';
$lang['emailuseredited_template'] = 'Шаблон изменения User Info';
$lang['preferences'] = 'Настройки';
$lang['error_usernotfound'] = 'Пользователь не найден';
$lang['error_invalidusername'] = 'Недопустимое имя пользователя (слишком длинное,  короткое, или содержит недопустимые символы).  Подсказка: Имя пользователя должно содержать только алфавитно-цифровые символы (без пробелов)';
$lang['error_invalidemail'] = 'Неверный Email';
$lang['error_usernametaken'] = 'Это имя пользователя сейчас используется';
$lang['error_passwordsdontmatch'] = 'Ошибка: неверный пароль';
$lang['error_invalidpassword'] = 'Недопустимый пароль (пароль должен быть между %s и %s символов  в длинну)';
$lang['error_emptyusername'] = 'Имя пользователя должно быть заполнено';
$lang['error_emptyemail'] = 'Недопускается использование пустого пароля';
$lang['repeatpassword'] = 'Пароль (ещё раз)';
$lang['password'] = 'Пароль';
$lang['username'] = 'Имя пользователя';
$lang['email'] = 'Email';
$lang['captcha_title'] = 'Введите текст с картинки';
$lang['error_insufficientparams'] = 'Неверное число (или неправильные) параметры предоставляемые модулю';
$lang['error_nofeusersmodule'] = 'Невозможно получить копию  модуля FrontEndUsers ';
$lang['error_nosuchgroup'] = 'Указанная группа не существует';
$lang['error_captchamismatch'] = 'Текст с картинки был введен некорректно';
$lang['send_emails_to'] = 'Сообщение о регистрации должно быть послано на';
$lang['require_email_confirmation'] = 'Требуется подтверждение регистрации через email';
$lang['notify_on_registration'] = 'Послать уведомление, если кто-либо зарегистрируется';
$lang['cancel'] = 'Отмена';
$lang['submit'] = 'Отправить';
$lang['friendlyname'] = 'Модуль Self Registration';
$lang['postinstall'] = 'Installation successfull, please remember to set the "Modify SelfRegistration Settings" permission.  If the Captcha module is installed, then captcha functionality is enabled by default.  We strongly reccommend that you install this module.  If the Captcha module is installed, and you want to disable it, use the nocaptcha param in your selfregistration tag.';
$lang['postuninstall'] = 'Self Registration модуль проинсталлирован, спасибо! ';
$lang['uninstalled'] = 'Модуль деинсталлирован';
$lang['installed'] = 'Установлена версия %s модуля';
$lang['prefsupdated'] = 'Обновлены настройки модуля';
$lang['accessdenied'] = 'В доступе отказано. Пожалуйства проверьте ваши права доступа.';
$lang['error'] = 'Ошибка!';
$lang['upgraded'] = 'Модуль обновлен до версии %s.';
$lang['title_mod_prefs'] = 'Настройки модуля';
$lang['title_mod_admin'] = 'Панель администрирования';
$lang['title_admin_panel'] = 'Модуль Self Registration';
$lang['moddescription'] = 'Модуль позволяет пользователям самостоятельно регистрироваться.';
$lang['welcome_text'] = '<p>Добро пожаловать в модуль self registration.</p>';
$lang['enable_whitelist'] = 'Enable Whitelist';
$lang['whitelist'] = 'List of whitelist username/emails. One per line. (use * for wildcards)';
$lang['whitelist_trigger_message'] = 'Message to show if a whitelist rule is triggered';
$lang['dont_use'] = 'No Whitelist';
$lang['no_matches'] = 'Don\'t allow matched username/emails to register';
$lang['only_matches'] = 'Only allow matched username/emails to register';
?>
