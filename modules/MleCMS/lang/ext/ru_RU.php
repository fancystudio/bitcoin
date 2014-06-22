<?php
$lang['friendlyname'] = 'Многоязычная CMS';
$lang['postinstall'] = 'Не забудьте установить право "manage mle_cms" для использования этого модуля!';
$lang['postuninstall'] = 'Модуль "Многоязычная CMS" был успешно удалён';
$lang['really_uninstall'] = 'Неужели? Вы уверены, что
хотите удалить этот превосходный модуль?';
$lang['uninstalled'] = 'Модуль удалён.';
$lang['installed'] = 'Модуль версии %s установлен.';
$lang['upgraded'] = 'Модуль обновлён до версии %s.';
$lang['moddescription'] = 'Этот модуль делает возможным создание с помощью CMS Made Simple многоязычных сайтов';
$lang['info_success'] = 'Выполнено успешно';
$lang['optionsupdated'] = 'Параметры обновлены';
$lang['module_missing'] = 'Пожалуйста, установите модуль %s';
$lang['error'] = 'Ошибка!';
$lang['admindescription'] = 'Этот модуль делает возможным создание с помощью CMS Made Simple многоязычных сайтов';
$lang['accessdenied'] = 'Доступ запрещен. Пожалуйста, проверте ваши права.';
$lang['mle_config'] = 'Языки сайта';
$lang['idtext'] = '#';
$lang['alias'] = 'Корневой алиас';
$lang['name'] = 'Имя';
$lang['extra'] = 'Дополнительно';
$lang['ltr'] = 'Left-to-right text or table';
$lang['rtl'] = 'Right-to-left text or table';
$lang['direction'] = 'Направление';
$lang['custom'] = 'Пользовательская';
$lang['locale_custom'] = 'Пользовательская локаль';
$lang['locale'] = 'Локаль';
$lang['setlocale'] = 'Set locale information (для опытных пользователей)';
$lang['documentation'] = 'Документация';
$lang['example'] = 'Пример';
$lang['flag'] = 'Флаг';
$lang['manage_snippets'] = 'Фрагменты';
$lang['unknown'] = 'Ошибка: неопределённая';
$lang['delete'] = 'Удалить';
$lang['areyousure'] = 'Вы уверены?';
$lang['edit'] = 'Редактировать';
$lang['add'] = 'Добавить';
$lang['source'] = 'Источник';
$lang['submit'] = 'Сохранить';
$lang['cancel'] = 'Отменить';
$lang['apply'] = 'Применить';
$lang['tag'] = 'Тег';
$lang['manage_blocks'] = 'Блоки';
$lang['options'] = 'Параметры';
$lang['mle_id'] = 'Идентификатор модуля (для одноязычного сайта используйте {$lang})';
$lang['mle_separator'] = 'Разделитель между языков (для {MleCMS action="langs" template="Separator"})';
$lang['translator_action_params'] = 'Default params for translator action';
$lang['mle_template'] = 'Шаблон меню выбора языка сайта';
$lang['addedit_mle_template'] = 'Добавить/Редактировать шаблон меню выбора языка';
$lang['mle_hierarchy_switch'] = 'Включить/выключить иерархию';
$lang['mle_search_restriction'] = 'Поиск ограничений модуля  (только для страницы)';
$lang['mle_search_restriction_note'] = 'URL вашей страницы должен начинаться с корневого алиаса (например: mod_rewrite (en/my-page) или internal index.php/en/my-page)';
$lang['mle_auto_redirect'] = 'Определение языка';
$lang['none'] = 'без определения';
$lang['root_redirect'] = 'Перенаправление в корневой каталог';
$lang['hierarchy_redirect'] = 'Перенаправление на каждый уровень иерархии';
$lang['mle_translator'] = 'Переводчик';
$lang['mle_translator_example'] = 'Поместите в шаблон тег {translate text="anything"}, возвратитесь в "Переводчик" для редактирования.';
$lang['help_name'] = 'имя фрагмента или блока';
$lang['help_template'] = 'шаблон (Флаги по умолчанию)';
$lang['help_excludeprefix'] = 'exclude prefix (for langs action) ';
$lang['help_includeprefix'] = 'include prefix (for langs action) ';
$lang['changelog'] = '<ul>
<li>Version 1.4 - 1.7 - april 2011 - небольшие обновления</li>
<li>Версия 1.3 - январь 2011 - новая функция - переводчик</li>
<li>Версия 1.2 - январь 2011 - новая функция - автоматическое перенаправление</li>
<li>Версия 1.1 - январь 2011 - небольшое обновление</li>
<li>Версия 1 - январь 2011 - первый выпуск.</li>
</ul>';
$lang['help'] = '<h3>Что делает этот модуль?</h3>
<p>Этот модуль делает возможным создание с помощью CMS Made Simple многоязычных сайтов</p>
<h3>Как использовать модуль?</h3>
<p>Смотрите <a href="http://cmsmadesimple.sk/modules/MleCMS/installation-guide.html">руководство по установке</a></p>
<h3>Плагины</h3>
<p><strong>Переводчик</strong> {translate text="some text"} или {translator}какой-то текст{/translator}или {"какой-то текст"|translate}</p>
<p>Параметры</p>
<ul>
<li>text (обязательно) - текст для перевода</li>
<li>assign (опция)  - назначение переменной smarty</li>
</ul>
<br />
<p><strong>Mle assign</strong> - (пример для новостей: {mle_assign object=$entry par="title" assign="entry"}) </p>
<p>Параметры</p>
<ul>
<li>from (обязательно) - object for mle assign</li>
<li>par (обязательно)  - par for find mutlilangue string (пример: title and mle version  are  title_sk, title_de, title_fr)</li>
<li>assign (опция)  - assign to object</li>
</ul>
<br />
<p><strong>Mle search checker</strong> - (for modules search search restriction, plugin create sql query) </p>
<p>Пример</p>
<code>
 {foreach from=$results item=entry}<br />
        {if $entry->module == "MyModule"}<br />
        {mle_search_checker select="filed" from="module_mymodule" id=$entry->modulerecord assign="language"}                <br />
        {if !$lang_parent}{MleCMS action="get_root_alias" assign="lang_parent"}{/if}<br />
        {*display every record from my category *}<br />
        {if $language == $lang_parent}  <br />
        {$entry->title}<br />
        <a href="{$entry->url}">{$entry->urltxt}</a>&nbsp;<span>({$entry->weight}%)</span><br />
        {/if}<br />
        {/foreach}<br />
</code><br />
<p>Параметры</p>
<ul>
<li>select (обязательно)  - SELECT select</li>
<li>from (обязательно) - FROM table</li>
<li>assign (опция)  - assign to object</li>
</ul>
    <h3>Нравится это? Поддержи :)</h3>
    <p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</p>
';
$lang['qca'] = 'P0-928654951-1306413567647';
$lang['utma'] = '156861353.1104515250.1324321267.1324321267.1324321284.2';
$lang['utmz'] = '156861353.1324321284.2.2.utmcsr=feedburner|utmccn=Feed: cmsmadesimple/blog (CMS Made Simple)|utmcmd=feed';
$lang['utmb'] = '156861353.4.10.1324321284';
$lang['utmc'] = '156861353';
?>