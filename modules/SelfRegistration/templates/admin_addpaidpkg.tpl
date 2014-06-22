{$formstart}
{if $pkgdata.name == ''}
<h3>{$mod->Lang('add_paidpkg')}</h3>
{else}
<h3>{$mod->Lang('edit_paidpkg',$pkgdata.name)}</h3>
{/if}

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('name')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pkg_name" size="20" maxlength="255" value="{$pkgdata.name}"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}pkg_prompt" size="20" maxlength="255" value="{$pkgdata.prompt}"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('group')}:</p>
  <p class="pageinput">
    <select name="{$actionid}pkg_gid">
    {html_options options=$grouplist selected=$pkgdata.gid}
    </select>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('description')}:</p>
  <p class="pageinput">{$input_description}</p>
</div>

{if isset($can_edit_cost)}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('cost')}:</p>
  <p class="pageinput">
    {$currency_symbol|default:''}
    <input type="text" name="{$actionid}pkg_cost" size="10" maxlength="10" value="{$pkgdata.cost}"/>
    {$currency_code|default:''}
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('subscription_expires')}:</p>
  <p class="pageinput">
    <select name="{$actionid}subscr_num">
    {html_options options=$nums selected=$pkgdata.subscr_num}
    </select>&nbsp;
    <select name="{$actionid}subscr_type">
    {html_options options=$subscr_types selected=$pkgdata.subscr_type}
    </select>
  </p>
</div>
{/if}

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>

{$formend}