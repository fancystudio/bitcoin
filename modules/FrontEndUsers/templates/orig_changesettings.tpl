<!-- change settings template -->
<div id="feu_changesettingsform">
<h4>{$mod->Lang('user_settings')}</h4>

{if isset($message) && $message != ''}
  {if isset($error) && $error != ''}
    <p class="alert alert-error">{$message}</p>
  {else}
    <p class="alert alert-info">{$message}</p>
  {/if}
{/if}

{$startform}
  {if $controlcount > 0}
  {foreach $controls as $key=>$field}
    <div class="row">
      <label for="$field->input_id" class="col-sm-3 text-right" style="color: {$field->color|default:'inherit'}">{$field->marker|default:''} {$field->prompt}:</label>
      <div class="col-md-9">
        {$field->hidden|default:''}
        {if isset($field->hidden)}{$field->hidden}{/if}

	{* build the field itself *}
	{if $field->type == '0'} {* text *}
	  <input type="text" id="{$field->input_id}" class="form-control" name="{$field->input_name}" size="{$field->length}" maxlength="{$field->maxlength}" value="{$field->value}" {if $field->readonly}readonly{/if}/>
	{elseif $field->type == 'password'} {* text *}
	  <input type="password" id="{$field->input_id}" class="form-control" name="{$field->input_name}" size="{$field->length}" maxlength="{$field->maxlength}" value="{$field->value}" {if $field->readonly}readonly{/if}/>
	{elseif $field->type == 2} {* email *}
	  <input type="email" id="{$field->input_id}" class="form-control" name="{$field->input_name}" size="{$field->length}" maxlength="{$field->maxlength}" value="{$field->value}" {if $field->readonly}readonly{/if}/>
	{elseif $field->type == 3} {* textarea *}
          {cge_textarea id=$field->input_id wysiwyg=$field->wysiwyg name=$field->input_name content=$field->value class="form-control"}
	{elseif $field->type == 1} {* checkbox *}
	  <input type="checkbox" id="{$field->input_id}" class="checkbox" name="{$field->input_name}" value="1" {if $field->value}checked{/if}/>
	{elseif $field->type == 4} {* dropdown *}
	   <select id="{$field->input_id}" class="form-control" name="{$field->input_name}" {if $field->readonly}readonly{/if}>
	      {html_options options=$field->options selected=$field->value}
	   </select>
	{elseif $field->type == 5} {* multiselect *}
	   <select id="{$field->input_id}" class="form-control" name="{$field->input_name}[]" {if $field->readonly}readonly{/if} multiple>
	      {html_options options=$field->options}
	   </select>
	{elseif $field->type == 7} {* radio group *}
	   {foreach $field->options as $key => $val}
	      <label><input type="radio" class="form-control" name="{$field->input_name}" value="{$key}"> {$val}</label>
	   {/foreach}
	{elseif $field->type == 6} {* image *}
	   {if isset($field->image_url) && $field->image_url}<img src="{$field->image_url}" alt="{$field->image_url}" width="100" height="100"/>{/if}
	   {if isset($field->prompt2) && $field->prompt2}<label><input type="checkbox" class="checkbox" name="{$field->input_name2}" value="clear"/> {$field->prompt2}</label>{/if}
	   <input type="hidden" name="{$field->input_name}" value="{$field->value}"/>
 	   <input type="file" id="{$field->input_id}" class="form-control" name="{$field->input_name}" {if $field->readonly}readonly{/if}/>
	{/if}
        {$field->addtext|default:''}
      </div>
    </div>
  {/foreach}
  {/if}

  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
      <button type="submit" class="btn btn_active" name="{$actionid}submit">{$mod->Lang('submit')}</button>
    </div>
  </div>
{$hidden|default:''}{$endform}
</div>
<!-- change settings template -->
