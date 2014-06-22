<h3>{$title}</h3>
{if $message != ''}
  {if $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{/if}
{$startform}
  {$input_name}
  {$input_prompt}
  {$input_type}
  <div class="pageoverflow">
    <p class="pagetext">{$prompt1}</p>
    <p class="pageinput">{$input1}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt2}</p>
    <p class="pageinput">{$input2}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$hidden}{$submit}{$cancel}</p>
  </div>
{$endform}
