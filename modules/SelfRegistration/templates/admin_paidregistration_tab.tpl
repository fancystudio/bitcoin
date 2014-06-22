{$formstart}
{if isset($packagelist)}
<div class="pageoverflow">
<table class="pagetable" cellspacing="0">
  <thead>
    <tr>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('prompt')}</th>
      <th>{$mod->Lang('group')}</th>
      <th>{$mod->Lang('cost')}</th>
      <th class="pageicon"></th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$packagelist item='onepkg'}
    <tr>
      <td><a href="{$onepkg.edit_url}">{$onepkg.name}</a></td>
      <td>{$onepkg.prompt}</td>
      <td>{if isset($grouplist[$onepkg.gid])}{$grouplist[$onepkg.gid]}{else}<span style="color: red;">ERROR</span>{/if}</td>
      <td>{$currency_symbol|default:''}{$onepkg.cost|number_format:2}</td>
      <td>{$onepkg.edit_link}</td>
      <td>{$onepkg.delete_link}</td>
    </tr>
  {/foreach}
  </tbody>
</table>
</div>
{/if}

<div class="pageoverflow">
  {$addlink}
</div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>
{$formend}