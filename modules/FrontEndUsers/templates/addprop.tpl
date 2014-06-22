<h3>{$title}</h3>
{if isset($message) }
  {if isset($error) }
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
{$startform}
<div>{$orig_type}</div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_name}:</p>
    <p class="pageinput">{$input_name}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_prompt}:</p>
    <p class="pageinput">{$input_prompt}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_type}:</p>
    <p class="pageinput">{$input_type}</p>
  </div>
  {if isset($fields)}
  {foreach from=$fields item='onefld'}
  <div class="pageoverflow">
    <p class="pagetext">{$onefld[0]}:</p>
    <p class="pageinput">{$onefld[1]}</p>
  </div>
  {/foreach}
  {/if}
{if isset($input_force_unique)}
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_force_unique')}:</p>
    <p class="pageinput">{$input_force_unique}</p>
  </div>
{/if}
{if $defn.type != 2}
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_encrypt')}:</p>
    <p class="pageinput">{$input_encrypt}<br/>{$mod->Lang('info_encrypt')}</p>
  </div>
{/if}
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$hidden|default:''}{$submit}{$cancel}</p>
  </div>
{$endform}
