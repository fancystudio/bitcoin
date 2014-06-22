{* lost username confirm template form *}
<h4>{$title}</h4>
{if isset($message)}<h5 class="error">{$message}</h5>{/if}
{if $controlcount > 0}
  {$startform}{$hidden}
    <div class="pagerow">
      <div class="page_prompt">{$prompt_password}</div>
      <div class="page_input">
        <input type="password" name="{$actionid}feu_input_password" size="{$passwdfldlength}" maxlength="{$max_paswordlength}"/>
      </div>
    </div>
    {foreach from=$controls item='entry'}
       <div class="pagerow">
          <div class="page_prompt">{$entry->hidden}{$entry->prompt}</div>
          <div class="page_input">{$entry->control}{$entry->addtext|default:''}</div>
       </div>
    {/foreach}
    {if isset($captcha) && isset($input_captcha)}
    <div class="pagerow">
      <p class="page_prompt">{$captcha_title}</div>
      <p class="page_input">{$input_captcha}<br/>{$captcha}</p>
    </div>
    {/if}
    <div class="pagerow">
      <div class="page_prompt"></div>
      <div class="page_input">
        <input type="submit" name="{$actionid}submit" value="{$FrontEndUsers->Lang('submit')}"/>
        <input type="submit" name="{$actionid}cancel" value="{$FrontEndUsers->Lang('cancel')}"/>
      </div>
    </div>
  {$endform}
{/if}
