{* login form template *}
{* this is a sample template, feel free to customize it *}
{if isset($alt_loginform)}
  <div class="row" id="altlogin">{$alt_loginform}</div><br/>
{/if}

<fieldset id="loginform">
  <legend>{$FrontEndUsers->Lang('prompt_normallogin')}:</legend>
  {$startform}

  {*
   * a simple honeypot captcha....if this field has a value after submit an error will be thrown
   * deleting this field will simply disable the honeypot.
   * it is important that the field be hidden with CSS rather than using a hidden input field.
   *}
  <input type="text" name="{$actionid}feu__data" value="" style="display: none;"/>

  {if $error}<div class="alert alert-danger">{$error}</div>{/if}
  <div class="row">
    <p class="col-md-4 text-right"><label for="feu_username">{$prompt_username}:</label></p>
    <p class="col-md-8">
      <input type="text" id="feu_username" name="{$fldname_username}" value="{$username}" size="{$username_size}" maxlength="{$username_maxlength}" required/>
    </p>
  </div>
  <div class="row">
    <p class="col-md-4 text-right"><label for="feu_password">{$prompt_password}:</label></p>
    <p class="col-md-8">
      <input type="password" id="feu_password" name="{$fldname_password}" value="{$password}" size="{$password_size}" maxlength="{$password_maxlength}" required/>
    </p>
  </div>
  {if isset($captcha)}
  <div class="row">
    <p class="col-md-4 text-right"><label for="feu_captcha">{$captcha_title}:</label></p>
    <div class="col-md-8">{$captcha}
      <div classs="row">{$input_captcha}</div>
    </div>
  </div>
  {/if}

  {if isset($prompt_rememberme)}
  <div class="row">
    <p class="col-md-4"></p>
    <p class="col-md-8">
      <label><input type="checkbox" name="{$actionid}feu_rememberme" value="1" {if $rememberme==1}checked/>{/if}/> {$prompt_rememberme}</label>
    </p>
  </div>
  {/if}

  <div class="row">
    <p class="col-md-4"></p>
    <p class="col-md-8">
      <button class="btn btn-active" name="{$actionid}submit">{$FrontEndUsers->Lang('login')}</button>
    </p>
  </div>

  {if isset($url_lostun) || isset($url_forgot)}
  <div class="row">
    <p class="col-md-4"></p>
    <p class="col-sm-8">
      {if isset($url_forgot)}
        <a href="{$url_forgot}" title="{$FrontEndUsers->Lang('info_forgotpw')}">{$FrontEndUsers->Lang('forgotpw')}</a>
      {/if}
      {if isset($url_lostun)}
        <a href="{$url_lostun}" title="{$FrontEndUsers->Lang('info_lostun')}">{$FrontEndUsers->Lang('lostusername')}</a>
      {/if}
    </p>
  </div>
  {/if}
  {$endform}
</fieldset>
