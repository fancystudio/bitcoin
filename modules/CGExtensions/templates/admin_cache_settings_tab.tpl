<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('cache_lifetime')}:</p>
  <p class="pageinput">
     <select name="{$actionid}cache_lifetime">
     {html_options options=$lifetime_opts selected=$cache_lifetime}
     </select>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('cache_filelock')}:</p>
  <p class="pageinput">
     <select name="{$actionid}cache_filelock">
     {cge_yesno_options selected=$cache_filelock}
     </select>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('cache_autoclean')}:</p>
  <p class="pageinput">
     <select name="{$actionid}cache_autoclean">
     {cge_yesno_options selected=$cache_autoclean}
     </select>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('cache_modulecalls')}:</p>
  <p class="pageinput">
     <select name="{$actionid}cache_modulecalls">
     {cge_yesno_options selected=$cache_modulecalls}
     </select> 
     <br/>{$mod->Lang('info_cache_modulecalls')}
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
     <input type="submit" name="{$actionid}cache_submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>