{if isset($message) }<p>{$message}</p>{/if}
{$startform}

<fieldset>
  <legend>{$mod->Lang('general_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('auth_module')}:</p>
    <p class="pageinput">
      <select name="{$actionid}auth_module">
        {html_options options=$auth_modules selected=$auth_module}
      </select>
      <br/>{$mod->Lang('info_auth_module')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_auto_create_unknown')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name='auto_create_unknown' selected=$auto_create_unknown}
      <br/> 
      {$mod->Lang('info_auto_create_unknown')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_allow_repeated_logins}:</p>
    <p class="pageinput">{$input_allow_repeated_logins}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_expireage')}:</p>
    <p class="pageinput">{$input_expireage}&nbsp;({$mod->Lang('months')})</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_randomusername')}:</p>
    <p class="pageinput">{$input_randomusername}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_feusers_specific_permissions}:</p>
    <p class="pageinput">{$input_feusers_specific_permissions}<br/>{$info_feusers_specific_permissions}</p>
  </div>
</fieldset>

<fieldset>
  <legend>{$mod->Lang('session_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_sessiontimeout}:</p>
    <p class="pageinput">{$input_sessiontimeout}
      <br/>{$mod->Lang('info_sessiontimeout')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_expireusers_interval')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}expireusers_interval" value="{$expireusers_interval}" size="4" maxlength="4"/>
      <br/>{$mod->Lang('info_expireusers_interval')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_forcelogout_times')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}forcelogout_times" size="40" maxlength="255" value="{$forcelogout_times}"/>
      <br/>{$mod->Lang('info_forcelogout_times')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_forcelogout_sessionage')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}forcelogout_sessionage" size="5" maxlength="5" value="{$forcelogout_sessionage}"/>
      <br/>{$mod->Lang('info_forcelogout_sessionage')}
    </p>
  </div>
</fieldset>

<fieldset>
  <legend>{$mod->Lang('property_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_image_destination_path}:</p>
    <p class="pageinput">{$input_image_destination_path}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_allowed_image_extensions}:</p>
    <p class="pageinput">{$input_allowed_image_extensions}</p>
  </div>
</fieldset>

<fieldset>
  <legend>{$mod->Lang('notification_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_notifications}:</p>
    <p class="pageinput">{$input_notifications}</p>        
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_notification_address}:</p>
    <p class="pageinput">{$input_notification_address}</p>        
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_notification_subject}:</p>
    <p class="pageinput">{$input_notification_subject}</p>        
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_notification_template}:</p>
    <p class="pageinput">{$input_notification_template}</p>        
  </div>
</fieldset>

<fieldset>
  <legend>{$mod->Lang('pagetype_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('pagetype_groups')}:</p>
    <p class="pageinput">
      <select name="{$actionid}pagetype_groups[]" multiple="multiple" size="5">
        {html_options options=$all_groups selected=$pagetype_groups}
      </select>
      <br/>
      {$mod->Lang('info_pagetype_groups')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('pagetype_action')}:</p>
    <p class="pageinput">
      <select name="{$actionid}pagetype_action">
        {html_options options=$pagetype_action_opts selected=$pagetype_action}
      </select>
      <br/>
      {$mod->Lang('info_pagetype_action')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('pagetype_redirectto')}:</p>
    <p class="pageinput">
      {$pagetype_redirectto}
      <br/>
      {$mod->Lang('info_pagetype_redirectto')}
    </p>
  </div>
</fieldset>

{if isset($data_numresetrecords)}
  <div class="pageoverflow">
    <hr width="50%" align="left"/>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_numresetrecords}</p>
    <p class="pageinput">{$data_numresetrecords}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$input_remove1week}{$input_remove1month}{$input_removeall}</p>
  </div>
{/if}

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">{$hidden|default:''}{$submit}{$cancel}</p>
</div>
{$endform}
