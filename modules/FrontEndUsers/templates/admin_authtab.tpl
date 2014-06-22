{$formstart}
<div class="information">{$mod->Lang('info_std_auth_settings')}</div>
<fieldset>
  <legend>{$mod->Lang('auth_settings')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_requireonegroup')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=require_onegroup selected=$require_onegroup}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_dfltgroup')}:</p>
    <p class="pageinput">
      <select name="{$actionid}default_group">
        {html_options options=$grouplist selected=$default_group}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_support_lostun')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=support_lostun selected=$support_lostun}
      <br/>
      {$mod->Lang('info_support_lostun')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_allow_changeusername')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=allow_changeusername selected=$allow_changeusername}
      <br/>
      {$mod->Lang('info_allow_changeusername')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_support_lostpw')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=support_lostpw selected=$support_lostpw}
      <br/>
      {$mod->Lang('info_support_lostpw')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_pwfldlen')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}pwfldlen" value="{$pwfldlen}" size="2" maxlength="2"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_minpwlen')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}minpwlen" value="{$minpwlen}" size="2" maxlength="2"/>
      <br/>
      {$mod->Lang('warning_effectsfieldlength')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_maxpwlen')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}maxpwlen" value="{$maxpwlen}" size="2" maxlength="2"/>
      <br/>
      {$mod->Lang('warning_effectsfieldlength')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_unfldlen')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}unfldlen" value="{$unfldlen}" size="2" maxlength="2"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_minunlen')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}minunlen" value="{$minunlen}" size="2" maxlength="2"/>
      <br/>
      {$mod->Lang('warning_effectsfieldlength')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_maxunlen')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}maxunlen" value="{$maxunlen}" size="2" maxlength="2"/>
      <br/>
      {$mod->Lang('warning_effectsfieldlength')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_cookiename')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}cookiename" value="{$xcookiename|default:''}" size="50" maxlength="50"/>
      <br/>
      {$mod->Lang('info_cookiename')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_cookiekeepalive')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=cookie_keepalive selected=$cookie_keepalive}
      <br/>
      {$mod->Lang('info_cookie_keepalive')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_username_is_email')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=username_is_email selected=$username_is_email}
      <br/>
      {$mod->Lang('info_username_is_email')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_allow_duplicate_emails')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=allow_duplicate_emails selected=$allow_duplicate_emails}
      <br/>
      {$mod->Lang('info_allow_duplicate_emails')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_allow_duplicate_reminders')}:</p>
    <p class="pageinput">
      {cge_yesno_options prefix=$actionid name=allow_duplicate_reminders selected=$allow_duplicate_reminders}
      <br/>
      {$mod->Lang('info_allow_duplicate_reminders')}
    </p>
  </div>
</fieldset>

<fieldset>
<legend>{$mod->Lang('display_settings')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_signin_button')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}signin_button" value="{$signin_button}" size="15" maxlength="15"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('requiredfieldmarker')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}required_field_marker" value="{$required_field_marker}" size="2" maxlength="2"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('requiredfieldcolor')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}required_field_color" value="{$required_field_color}" size="10" maxlength="10"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('securefieldmarker')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}secure_field_marker" value="{$secure_field_marker}" size="2" maxlength="2"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('securefieldcolor')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}secure_field_color" value="{$secure_field_color}" size="10" maxlength="10"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('hiddenfieldmarker')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}hidden_field_marker" value="{$hidden_field_marker}" size="2" maxlength="2"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('hiddenfieldcolor')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}hidden_field_color" value="{$hidden_field_color}" size="10" maxlength="10"/>
    </p>
  </div>
</fieldset>

{if isset($ecomm_ordercancelled)}
<fieldset>
  <legend>{$mod->Lang('ecommerce_settings')}:</legend>
  <p class="pageoverflow">{$mod->Lang('info_paidreg_settings')}</p>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_ecomm_paidregistration')}:</p>
    <p class="pageinput">
      <select name="{$actionid}ecomm_paidregistration">
      {cge_yesno_options selected=$ecomm_paidregistration}
      </select>
      <br/>
      {$mod->Lang('info_ecomm_paidregistration')}
    </p>
  </div>

  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_action_ordercancelled')}:</p>
    <p class="pageinput">
      <select name="{$actionid}ecomm_ordercancelled">
      {html_options options=$ecommerce_actions selected=$ecomm_ordercancelled}
      </select>
    </p>
  </div>

  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_action_orderdeleted')}:</p>
    <p class="pageinput">
      <select name="{$actionid}ecomm_orderdeleted">
      {html_options options=$ecommerce_actions selected=$ecomm_orderdeleted}
      </select>
    </p>
  </div>
</fieldset>
{/if}

<fieldset>
<legend>{$mod->Lang('redirection_settings')}:</legend>
<div class="pageoverflow">
  <p class="pageoverflow">{$mod->Lang('info_star')}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_forgotpw_page')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pageidforgotpasswd" value="{$pageidforgotpasswd}" size="80" maxlength="255"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_changesettings_page')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pageid_changesettings" value="{$pageid_changesettings}" size="80" maxlength="255"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_login_page')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pageid_login" value="{$pageid_login}" size="80" maxlength="255"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_logout_page')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pageid_logout" value="{$pageid_logout}" size="80" maxlength="255"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_after_verify_code')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pageid_afterverify" value="{$pageid_afterverify}" size="80" maxlength="255"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_after_change_settings')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pageid_afterchangesettings" value="{$pageid_afterchangesettings}" size="80" maxlength="255"/>
  </p>
</div>
</fieldset>

<fieldset>
  <legend>{$mod->Lang('advanced_settings')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_pwsalt')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}pwsalt" value="{$pwsalt}" size="5" maxlength="5" {if $total_user_count gt 0}readonly="readonly"{/if}/>
      <br/>
      {$mod->Lang('info_pwsalt')}
    </p>
  </div>
</fieldset>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
   <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>

{$formend}