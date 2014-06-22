<?php
$lang['install_timezone'] = 'Some servers running php 5.3 have not set the timezone correctly.  Please select the appropriate timezone from the list before.  If this is not necessary on your server you may select "None"';
$lang['timezone'] = 'タイムゾーン';
$lang['none'] = 'なし';
$lang['test_error_estrict'] = 'Testing error_reporting to ensure E_STRICT is disabled';
$lang['test_estrict_failed'] = 'E_STRICT は有効です。';
$lang['info_estrict_failed'] = 'Some libraries that CMSMS uses do not work well with E_STRICT.  Please disable this before continuing';
$lang['test_error_edeprecated'] = 'Testing error_reporting to ensure E_DEPRECATED is disabled';
$lang['test_edeprecated_failed'] = 'E_DEPRECATED は有効です。';
$lang['info_edeprecated_failed'] = 'If E_DEPRECATED is enabled in your error reporting users will see alot of warning messages that could effect the display and functionalty';
$lang['invalidemail'] = '入力されたメールアドレスが無効です。';
$lang['empty_query'] = 'Empty query?? %s';
$lang['no_db_driver'] = 'データベースドライバに互換性がありません。';
$lang['test_check_output_buffering'] = 'Checking output buffering';
$lang['test_check_output_buffering_failed'] = 'Output buffering is disabled. You will probably not be able to use any of functionality that requires this';
$lang['phpinfo'] = 'PHP情報を表示する。';
$lang['mod_security'] = 'Apache セキュリティモジュール';
$lang['test_check_tempnam'] = 'Checking for tempnam Function';
$lang['test_check_db_drivers'] = 'データベースドライバ';
$lang['test_check_db_drivers_failed'] = 'データベースドライバが見つかりません。';
$lang['test_check_register_globals'] = 'Checking PHP register globals';
$lang['test_check_register_globals_failed'] = 'PHP register globals is active. For security reasons, this should be disabled.';
$lang['test_check_disable_functions'] = 'Checking PHP disable functions';
$lang['test_check_disable_functions_failed'] = '警告: サーバで無効な機能の一覧があります。';
$lang['install_admin_db_port'] = 'データベースポート';
$lang['install_admin_db_port_info'] = '分からないようであれば、空白にすることでデフォルト値を設定します。';
$lang['install_admin_db_socket'] = 'データベースソケット';
$lang['install_admin_db_socket_info'] = 'サポートしていません。';
$lang['install_admin_frontendlang'] = 'Default language for the frontend. This adjusts the locale used for various default date handling functions, etc.';
$lang['install_default_encoding'] = 'In almost all cases, default_encoding should be utf-8.';
$lang['installer_done'] = '[完了]';
$lang['installer_failed'] = '[失敗]';
$lang['create_permission'] = '権限を作成する ...';
$lang['add_column_sql'] = 'テーブルにカラムを追加中・・・ %s';
$lang['update_table_sql'] = 'テーブルを更新中・・・ %s ';
$lang['installing_module'] = 'モジュールをインストール中・・・ %s';
$lang['updating_schema_version'] = 'スキーマバージョンを更新中・・・ %s';
$lang['upgrade_config'] = 'config.php更新します。';
$lang['upgrade_config_info'] = '設定の更新';
$lang['upgrade_failed_again'] = 'One or more upgrades have failed. Please correct the problem and click the button below to recheck.';
$lang['upgrade_cache_dirs'] = 'キャッシュディレクトリをクリーンにします。';
$lang['cannot_clean_cache_dirs'] = 'キャッシュディレクトリをクリーンにできませんでした。';
$lang['upgrade_schema'] = 'スキーマをアップグレードしました。';
$lang['need_upgrade_schema'] = 'CMS is in need of an upgrade.<br />You are now running schema version %s and you need to be upgraded to version %s';
$lang['schema_ok'] = 'The CMS database is up to date.  Using schema version %s';
$lang['noneed_upgrade_schema'] = 'The CMS database is up to date. Using schema version %s';
$lang['upgrade_modules'] = 'モジュールのアップグレード';
$lang['noneed_upgrade_modules'] = 'The core modules are up to date';
$lang['upgrade_sql_module_from_to'] = 'Upgrading SQL of "%s" module from %s to %s ...';
$lang['upgrade_event_module_from_to'] = 'Upgrading Events of "%s" module from %s to %s ...';
$lang['sitedown_not_removed'] = 'Could not remove the tmp/cache/SITEDOWN file. Please remove manually or you will continue to show a "Site Down for Maintainence" message on your site';
$lang['upgrade_ok'] = 'Please review config.php, modify any new settings as necessary and then reset it\'s permissions back to a locked state. You should also check that all of your modules are up to date, by going to the Extensions -> Modules page and looking for any listed as "Needs Upgrade"';
$lang['upgrade_complete'] = 'Upgrade process complete';
$lang['upgrade_end'] = 'CMS is up to date. Please click %s to go to your CMS site or you can %s.';
$lang['here'] = 'ここ';
$lang['go_to_admin'] = '管理者ページへ進む';
$lang['errorfilenot'] = 'ファイルが見つかりません！';
$lang['errorfilenotwritable'] = 'ファイルが書き込めません！';
$lang['nofiles'] = 'このリソースは存在しません！';
$lang['is_directory'] = 'このリソースはディレクトリです！';
$lang['is_readable_false'] = 'このリソースは読み込めません！';
$lang['checksum_match'] = 'チェックサムが一致しました！';
$lang['checksum_not_match'] = 'チェックサムが一致しませんでした！';
$lang['not_checksum'] = 'チェックサムを検索できませんでした！';
$lang['format_datetime'] = '%c';
$lang['upload_err_ini_size'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini!';
$lang['upload_err_form_size'] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
$lang['upload_err_partial'] = 'The uploaded file was only partially uploaded.';
$lang['upload_err_no_file'] = '更新されたファイルがありません。';
$lang['upload_err_no_tmp_dir'] = 'テンポラリフォルダが間違っています。';
$lang['upload_err_cant_write'] = 'ファイルをディスクに書き込めませんでした。';
$lang['upload_err_extension'] = 'File upload stopped by extension.';
$lang['upload_err_empty'] = '0バイトのファイルです。';
$lang['upload_err_unknown'] = '不明なアップロード時の問題です。';
$lang['function_file_uploads_off'] = 'file_uploads is off in your php configuration!';
$lang['upload_file_no_readable'] = 'Uploaded file is not readable!';
$lang['upload_file_multiple'] = 'Multiple file uploads are not allowed!';
$lang['test_check_magic_quotes_gpc'] = 'Magic quotes for Get/Post/Cookie operations';
$lang['test_check_magic_quotes_gpc_failed'] = 'When magic_quotes are on, all single-quote, double quote and backslash are escaped with a backslash automatically. This can cause many problems in CMS.';
$lang['test_check_magic_quotes_runtime'] = 'Magic quotes in runtime';
$lang['test_check_magic_quotes_runtime_failed'] = 'When magic_quotes are on, most functions that return data from any sort of external source including databases and text files will have quotes escaped with a backslash. This will cause problems with CMS made simple.';
$lang['install_admin_checksum'] = 'インストールをチェックしてください。';
$lang['upgrade_admin_checksum'] = 'システム更新をチェックしてください。';
$lang['checksum'] = 'Checksum test';
$lang['checksum_file'] = 'Checksum file';
$lang['install_test_checksum'] = 'You can validate the integrity of your CMS files by comparing against original CMS checksum. It can assist in finding problems with uploads.';
$lang['checksum_passed'] = 'All checksums match!';
$lang['checksum_failed'] = 'Checksum match with errors. Look at the help for more information';
$lang['test_check_open_basedir'] = 'Check for PHP Open Basedir';
$lang['test_check_open_basedir_failed'] = 'Open basedir restrictions are in effect. You may have difficulty with some addon functionality with this restriction.';
$lang['unlimited'] = '上限値なし';
$lang['test_open_basedir_session_save_path'] = 'Open basedir restrictions appear to be in effect. If you have SESSION problems and ini_set works, you can try to enable sessions with cookies adding: ini_set(\'session.use_only_cookies\', 1);  to top of config.php';
$lang['install_warn_db_createtables'] = 'Normally this field should be checked at all times.  Use caution when disabling this feature';
$lang['install_admin_tablesnotcreated'] = 'Process complete. The installation process has completed, at your request database tables were not created. However, the config file has been reset and all pre-installation tests have passed. Thank you, and here is your';
$lang['info_create_dir_and_file'] = 'The HTTP Process owner cannot create a file inside a directory that it owns. This probably means that safe mode is enabled in some way. Many functions inside CMS made simple will not operate properly without this ability. Continuing is not possible.';
$lang['test_create_dir_and_file'] = 'Checking if the httpd process can create a file inside of a directory it created.';
$lang['cms_site'] = 'CMS Site';
$lang['or_greater'] = 'Or greater';
$lang['sitename'] = 'サイト名';
$lang['warning_safe_mode'] = '<strong><em>WARNING:</em></strong> PHP Safe mode is enabled.  This will cause dificulty with files uploaded via the web browser interface, including images, theme and module XML packages.  You are advised to contact your site administrator to see about disabling safe mode.';
$lang['test'] = 'テスト';
$lang['results'] = '結果';
$lang['untested'] = 'Not Tested';
$lang['owner'] = 'オーナー';
$lang['permissions'] = '権限';
$lang['off'] = 'オフ';
$lang['on'] = 'オン';
$lang['permission_information'] = '権限情報';
$lang['server_os'] = 'Server Operating System';
$lang['server_api'] = 'サーバAPI';
$lang['server_software'] = 'サーバソフトウェア';
$lang['server_information'] = 'サーバ情報';
$lang['session_save_path'] = 'セッション保存パス';
$lang['max_execution_time'] = 'Maximum Execution Time';
$lang['gd_version'] = 'GDバージョン';
$lang['upload_max_filesize'] = 'Maximum Upload Size';
$lang['post_max_size'] = 'Maximum Post Size';
$lang['memory_limit'] = 'PHPメモリ上限';
$lang['server_db_type'] = 'データベースサーバ';
$lang['server_db_version'] = 'データベースサーババージョン';
$lang['phpversion'] = 'PHPバージョン';
$lang['safe_mode'] = 'PHPセーフモード';
$lang['php_information'] = 'PHP情報';
$lang['cms_install_information'] = 'CMSインストール情報';
$lang['cms_version'] = 'CMSバージョン';
$lang['systeminfo_copy_paste'] = 'Please copy and paste this selected text into your forum posting';
$lang['help_systeminformation'] = 'The information displayed below is collected from a variety of locations, and summarized so that you may be able to conveniently find some of the information required when trying to diagnose a problem or request help with your CMS Made Simple installation.';
$lang['systeminfo'] = 'システム情報';
$lang['systeminfodescription'] = 'Display various pieces of information about your system that may be useful in diagnosing problems';
$lang['error'] = 'エラー';
$lang['new_version_available'] = '<em>Notice:</em> A new version of CMS Made Simple is available.  Please notify your administrator.';
$lang['info_urlcheckversion'] = 'If this url is the word "none" no checks will be made.<br/>An empty string will result in a default URL being used.';
$lang['urlcheckversion'] = 'Check for new CMS versions using this URL';
$lang['read'] = 'Read';
$lang['write'] = 'Write';
$lang['execute'] = '実行';
$lang['group'] = 'グループ';
$lang['other'] = 'そのほか';
$lang['global_umask'] = 'File Creation Mask (umask)';
$lang['errorcantcreatefile'] = 'Could not create a file (permissions problem?)';
$lang['add'] = '追加';
$lang['about'] = 'About';
$lang['action'] = 'Action';
$lang['actionstatus'] = 'Action/Status';
$lang['active'] = '有効';
$lang['cantremove'] = '削除できない';
$lang['changepermissions'] = '権限の変更';
$lang['changepermissionsconfirm'] = 'USE CAUTION\\n\\nThis action will attempt to ensure that all of the files making up the module are writable by the web server.\\nAre you sure you want to continue?';
$lang['success'] = '成功';
$lang['advanced'] = 'Advanced';
$lang['back'] = 'メニューへ戻る';
$lang['cancel'] = 'キャンセル';
$lang['cantchmodfiles'] = 'Couldn\'t change permissions on some files';
$lang['cantremovefiles'] = 'Problem Removing Files (permissions?)';
$lang['create'] = '新規作成';
$lang['database'] = 'データベース';
$lang['databaseprefix'] = 'Database Prefix';
$lang['databasetype'] = 'データベースタイプ';
$lang['date'] = '日付';
$lang['default'] = 'デフォルト';
$lang['delete'] = '削除';
$lang['deleteconfirm'] = 'Are you sure you want to delete - %s - ?';
$lang['description'] = 'Description';
$lang['directoryexists'] = 'This directory already exists.';
$lang['down'] = '下';
$lang['edit'] = '編集';
$lang['email'] = 'メールアドレス';
$lang['errordeletingfile'] = 'Could not delete file. Permissions Problem?';
$lang['errordirectorynotwritable'] = 'No permission to write in directory.  This could be caused by file permissions and ownership.  Safe mode may also be in effect.';
$lang['cachenotwritable'] = 'Cache folder is not writable. Clearing cache will not work. Please make the tmp/cache folder have full read/write/execute permissions (chmod 777).  You may also have to disable safe mode.';
$lang['modulesnotwritable'] = 'The modules folder is not writable, if you would like to install modules by uploading an XML file you need to make the modules folder have full read/write/execute permissions (chmod 777).  Safe mode may also be in effect.';
$lang['false'] = 'False';
$lang['settrue'] = 'Set True';
$lang['filename'] = 'ファイル名';
$lang['filesize'] = 'ファイルサイズ';
$lang['help'] = 'ヘルプ';
$lang['language'] = '言語';
$lang['lastname'] = 'Last Name';
$lang['name'] = '名前';
$lang['password'] = 'パスワード';
$lang['passwordagain'] = 'パスワード(再)';
$lang['remove'] = '削除';
$lang['saveconfig'] = '設定の保存';
$lang['true'] = 'True';
$lang['setfalse'] = 'Set False';
$lang['type'] = 'タイプ';
$lang['typenotvalid'] = 'Type is not valid';
$lang['unknown'] = '不明';
$lang['user'] = 'ユーザ';
$lang['userdefinedtags'] = 'User Defined Tags';
$lang['usermanagement'] = 'User Management';
$lang['username'] = 'ユーザ名';
$lang['usernameincorrect'] = 'Username or password incorrect';
$lang['version'] = 'バージョン';
$lang['install_title'] = 'CMS Made Simple Install (step %s)';
$lang['install_system'] = 'インストールシステム';
$lang['install_thanks'] = 'Thanks for installing CMS Made Simple';
$lang['upgrade_title'] = 'CMS Made Simple Upgrade (step %s)';
$lang['upgrade_system'] = 'アップグレードシステム';
$lang['upgrade_thanks'] = 'Thanks for upgrading CMS Made Simple to';
$lang['install_please_read'] = 'Please read the <a rel="external" href="http://wiki.cmsmadesimple.org/index.php/User_Handbook/Installation/Troubleshooting">Installation Troubleshooting</a> page in the CMS Made Simple Documentation Wiki.';
$lang['install_checking'] = 'Checking permissions and PHP settings';
$lang['install_test'] = 'テスト';
$lang['install_result'] = '結果';
$lang['install_required_settings'] = 'Required settings';
$lang['install_recommended_settings'] = 'Recommended settings';
$lang['install_you_have'] = 'You have';
$lang['install_legend'] = 'Legend';
$lang['install_symbol'] = 'シンボル';
$lang['install_definition'] = '定義';
$lang['install_value_passed'] = 'A required test passed';
$lang['install_value_failed'] = 'A required test failed';
$lang['install_error_fragment'] = 'Info Installation Troubleshooting';
$lang['install_value_required'] = 'A setting is below a required minimum value';
$lang['install_value_recommended'] = 'A setting is above the required value, but below the recommended value<br />or... A capability that <em>may</em> be required for some optional functionality is unavailable';
$lang['install_value_exceed'] = 'A setting meets or exceeds the recommended threshhold<br />or... A capability that <em>may</em> be required for some optional functionality is available';
$lang['install_test_failed'] = 'One or more tests have failed or are in warning. You can still install the system but some functions may not work correctly.<br />Please try to correct the situation and click "Try Again", or click the "Continue" button if are recommended only.';
$lang['install_test_passed'] = 'All tests passed (at least at a minimum level). Please click the "Continue" button.';
$lang['install_failed_again'] = 'One or more tests have failed. Please correct the problem and click the button below to recheck.';
$lang['install_try_again'] = '再度実行する';
$lang['install_continue'] = '続ける';
$lang['failure'] = 'Failure';
$lang['caution'] = '警告';
$lang['install_admin_umask'] = 'Test File Creation Mask';
$lang['install_test_umask'] = 'Please click Test button for check the umask entered ...';
$lang['test_umask_text'] = 'umask (abbreviated from user file creation mode mask) is a function in POSIX environments which affects the default file system mode for newly created files and directories of the current process. It controls which of the file permissions will not be set for any newly created file.';
$lang['test_check_umask'] = 'Result test on file created in';
$lang['test_umask_not_given'] = 'Umask not given';
$lang['test_check_umask_failed'] = 'Test umask failed';
$lang['test_username_not_given'] = 'You must supply a Username.';
$lang['test_username_illegal'] = 'Username contains illegal characters!';
$lang['test_not_both_passwd'] = 'Please complete both password fields.';
$lang['test_passwd_not_match'] = 'Password fields do not match!';
$lang['test_email_accountinfo'] = 'E-mail accountinfo selected, but no E-mail address given!';
$lang['test_database_prefix'] = 'Database prefix contains invalid characters';
$lang['test_no_dbms'] = 'No dbms selected!';
$lang['test_could_not_connect_db'] = 'Could not connect to the database. Verify that username and password are correct, and that the user has access to the given database.';
$lang['test_could_not_drop_table'] = 'Could not drop a table. Verify that the user has privileges to drop tables in the given database.';
$lang['test_could_not_create_table'] = 'Could not create a table. Verify that the user has privileges to create tables in the given database.';
$lang['test_check_php'] = 'Checking for PHP version %s+';
$lang['test_min_recommend'] = '(minimum %s, recommend %s or greater)';
$lang['test_min_recommend_plus'] = '(min %s, recommend %s+)';
$lang['test_requires_php_version'] = 'CMS Made Simple requires a php version of 4.3 or greater (you have %s), but PHP %s or greater is recommended to ensure maximum compatibility with third party addons';
$lang['test_check_md5_func'] = 'Checking for md5 Function';
$lang['test_check_safe_mode'] = 'Checking for safe mode';
$lang['test_check_safe_mode_failed'] = 'PHP safe mode could create some problems with uploading files and other functions. It all depends on how strict your server safe mode settings are.';
$lang['test_check_tokenizer'] = 'Checking for tokenizer functions';
$lang['test_check_tokenizer_failed'] = 'Not having the tokenizer could cause pages to render as purely white. We required you have this installed.';
$lang['test_check_gd'] = 'Checking for GD library';
$lang['test_check_gd_failed'] = 'The GD library is mandatory for some modules and functionality.';
$lang['test_check_write'] = 'Checking write permission on';
$lang['test_may_not_exist'] = 'This file may not exist yet. If it does not, you should create an empty file with this name. Please also ensure that this file writable by the web server process.';
$lang['could_not_retrieve_a_value'] = 'Could not retrieve a value.... passing anyways.';
$lang['displaying_the_value_originally'] = '<br />Displaying the value originally set in the config file (this may not be accurate).';
$lang['test_check_xml_func'] = 'Checking for basic XML (expat) support';
$lang['test_check_xml_failed'] = 'XML support is not compiled into your php install. You can still use the system, but will not be able to use any of the remote module installation functions.';
$lang['test_allow_url_fopen_failed'] = 'When allow url fopen is disabled you will not be able to accessing URL object like file using the ftp or http protocol.';
$lang['test_remote_url'] = 'Test for remote URL';
$lang['test_remote_url_failed'] = 'You will probably not be able to open a file on a remote web server.';
$lang['connection_error'] = 'Outgoing http connections do not appear to work! There is a firewall or some ACL for external connections?. This will result in module manager, and potentially other functionality failing.';
$lang['remote_connection_timeout'] = 'コネクションタイムアウトしました！';
$lang['search_string_find'] = '接続しました！';
$lang['connection_failed'] = '接続に失敗！';
$lang['remote_response_ok'] = 'リモートレスポンス: ok!';
$lang['remote_response_404'] = 'リモートレスポンス: not found!';
$lang['remote_response_error'] = 'リモートレスポンス: エラー！';
$lang['test_check_file_upload'] = 'Checking file uploads';
$lang['test_check_file_failed'] = 'When file uploads are disabled you will not be able to use any of the file uploading facilities included in CMS Made Simple. If possible, this restriction should be lifted by your system admin to properly use all file management features of the system. Proceed with caution.';
$lang['test_check_memory'] = 'PHPのメモリ上限をチェックしてください。';
$lang['test_check_memory_failed'] = 'You may not have enough memory to run CMSMS correctly, or with all of your desired addons. If possible, you should try to get your system admin to raise this value. Proceed with caution.';
$lang['test_check_time_limit'] = 'Checking PHP time limit in second';
$lang['test_check_time_limit_failed'] = 'Number of seconds a script is allowed to run. If this is reached, the script returns a fatal error.';
$lang['test_check_post_max'] = 'Checking max post size';
$lang['test_check_post_max_failed'] = 'You will probably not be able to submit (larger) data. Please be aware of this restriction.';
$lang['test_check_upload_max'] = 'Checking max upload file size';
$lang['test_check_upload_max_failed'] = 'You will probably not be able to upload (larger) files using the included file management functions. Please be aware of this restriction.';
$lang['test_check_writable'] = 'Checking if %s is writable';
$lang['test_check_upload_failed'] = 'The uploads folder is not writable. You can still install the system, but you will not be able to upload files via the Admin Panel.';
$lang['test_check_images_failed'] = 'The images folder is not writable. You can still install the system, but you will not be able to upload and use images via the Admin Panel.';
$lang['test_check_modules_failed'] = 'The modules folder is not writable. You can still install the system, but you will not be able to upload modules via the Admin Panel.';
$lang['test_check_file_get_contents'] = 'Checking for file_get_contents';
$lang['test_check_file_get_contents_failed'] = 'You will probably not be able to use any of functionality that uses this function';
$lang['test_check_session_save_path'] = 'Checking if session.save_path is writable';
$lang['test_empty_session_save_path'] = 'Your session.save_path is empty. PHP will use the temporary directory of your OS. If you have SESSION problems and ini_set works you can try to enable session cookies adding: ini_set(\'session.use_only_cookies\', 1);  on top of include.php';
$lang['test_check_session_save_path_failed'] = 'Your session.save_path is "%s". Not having this as writable may make logins to the Admin Panel not work. You may want to look into making this path writable if you have trouble logging into the Admin Panel. This test may fail if safe_mode is enabled (see below).';
$lang['test_check_ini_set'] = 'Checking if ini_set works';
$lang['test_check_ini_set_failed'] = 'Although the ability to override php ini settings is not mandatory, some addon (optional) functionality uses ini_set to extend timeouts, and allow uploading of larger files, etc. You may have difficulty with some addon functionality without this capability. This test may fail if safe_mode is enabled (see below).';
$lang['install_admin_header'] = 'Admin Account Information';
$lang['install_admin_info'] = 'Select the username, password and email address for your admin account. Please make sure you record this password somewhere.';
$lang['install_admin_email'] = 'メールアドレス';
$lang['install_admin_email_info'] = 'E-Mail Account Information';
$lang['install_admin_email_note'] = '<strong>Note:</strong> This task uses the php\'s mail function. If you don\'t receive this email, it may be an indication that your server is not properly configured and that you should contact your host administrator.';
$lang['install_admin_sitename'] = 'This is the name of your site. It will be used in various places of the default templates and can be used anywhere with the {sitename} tag.';
$lang['install_admin_db'] = 'データベース情報';
$lang['install_admin_db_info'] = '<p>Make sure you have created your database and granted full privileges to a user to use that database.</p>
<p>For MySQL, use the following:</p>
<p>Log in to mysql from a console and run the following commands:</p>
<ol>
<li>create database cms; (use whatever name you want here but make sure to remember it, you\'ll need to enter it on this page)</li>
<li>grant all privileges on cms.* to cms_user@localhost identified by \'cms_pass\';</li>
</ol>';
$lang['install_admin_follow'] = 'Please complete the following fields';
$lang['install_admin_db_type'] = 'データベースタイプ';
$lang['install_admin_no_db'] = 'No valid database drivers appear to be compiled into your PHP install. Please confirm that you have mysql, mysqli, and/or postgres7 support installed, and try again.';
$lang['install_admin_db_host'] = 'データベースアドレス';
$lang['install_admin_db_name'] = 'データベース名';
$lang['install_admin_db_create'] = 'テーブルを作成します。 (警告: データは削除されます)';
$lang['install_admin_db_prefix'] = 'テーブル・プレフィックス';
$lang['install_admin_db_sample'] = 'サンプルコンテンツとテンプレートをインストールします。';
$lang['retry'] = 'リトライ';
$lang['install_admin_db_create_seq'] = 'テーブルシーケンスを作成しています。 %s';
$lang['install_admin_importing'] = 'サンプルデータをインポートしています。';
$lang['invalid_query'] = 'Invalid query: %s';
$lang['install_creating_table'] = '<p>Creating %s table... [%s]</p>';
$lang['install_creating_index'] = '<p>Creating index in %s table... [%s]</p>';
$lang['done'] = '完了しました。';
$lang['failed'] = '失敗しました。';
$lang['install_admin_error_schema'] = 'SQLスキーマの検索でエラーが発生しました。';
$lang['install_admin_set_account'] = 'admin account 情報を設定しました。';
$lang['install_admin_set_sitename'] = 'サイト名を設定しました。';
$lang['install_admin_setup'] = 'Now let\'s continue to setup your configuration file, we already have most of the stuff we need. Chances are you can leave all these values alone, so when you are ready, click Continue.';
$lang['install_admin_docroot'] = 'CMS Document root (as seen from the webserver)';
$lang['install_admin_docroot_path'] = 'Document root のパス';
$lang['install_admin_querystring'] = 'Query string (leave this alone unless you have trouble, then edit config.php by hand)';
$lang['invalid_querys'] = '<b>WARNING<b/>: Invalid queries on your DB!';
$lang['install_admin_sitedown'] = 'エラー: Could not remove the tmp/cache/SITEDOWN file. Please remove manually.';
$lang['install_admin_update_hierarchy'] = 'Updating hierarchy positions...';
$lang['install_admin_set_core_event'] = 'Setting up core events...';
$lang['install_admin_install_modules'] = 'モジュールのインストール...';
$lang['install_admin_index_search'] = 'インデックス検索・・・';
$lang['install_admin_clear_cache'] = 'Clearing site cache (if any)...';
$lang['install_admin_emailing'] = 'アカウント情報をadminにメールしました。';
$lang['install_admin_congratulations'] = 'Congratulations, you are all setup - here is your ';
$lang['could_not_connect_db'] = 'Could not connect to the database. Verify that username and password are correct, and that the user has access to the given database.';
$lang['cannot_write_config'] = 'エラー: 書き込みできませんでした。 %s.';
$lang['email_accountinfo_subject'] = 'CMS Made Simple のAdmin アカウント情報';
$lang['email_accountinfo_message'] = 'CMS Made Simpleをご利用いただき、ありがとうございます！

以下はアカウント情報になります:
ユーザ名: %s
パスワード: %s

ここからサイトの管理ページへログインしてください: %s';
$lang['utma'] = '156861353.1025915730.1283783986.1283783986.1283783986.1';
$lang['utmb'] = '156861353.1.10.1283783986';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1283783986.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
$lang['qca'] = 'P0-494958194-1283783986906';
?>