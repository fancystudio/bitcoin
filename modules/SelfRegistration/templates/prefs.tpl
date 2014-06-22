{if isset($message) && $message!=''}<p>{$message}</p>{/if}
{$startform}
<table width="100%">
  <tr>
    <td width="50%">
    <fieldset>
        <legend>{$mod->Lang('prompt_general_settings')}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_inline}:</p>
		<p class="pageinput">{$input_inline}</p>
	</div>

    </fieldset>

    <fieldset>
        <legend>{$mod->Lang('prompt_registration_settings')}</legend>
	<div class="pageoverflow">
	  <p class="pagetext"><label for="allowselectpkg">{$mod->Lang('prompt_allow_select_pkg')}</label>:</p>
	  <p class="pageinput">
            <select id="allowselectpkg" name="{$actionid}allowselectpkg">
            {html_options options=$selectpkgopts selected=$allowselectpkg}
            </select>
            <br/>{$mod->Lang('info_allowselectpkg')};
          </p>
	</div>


	<div class="pageoverflow">
  	  <p class="pagetext">{$prompt_email_confirmation}:</p>
	  <p class="pageinput">{$input_email_confirmation}
            <br/>
            {$mod->Lang('info_email_confirmation')}
          </p>
	</div>

	<div class="pageoverflow">
  	  <p class="pagetext">{$prompt_force_email_twice}:</p>
	  <p class="pageinput">{$input_force_email_twice}
            <br/>{$mod->Lang('info_force_email_twice')}
          </p>
	</div>

	<div class="pageoverflow">
  	  <p class="pagetext">{$prompt_login_afterverify}:</p>
	  <p class="pageinput">{$input_login_afterverify}
            <br/>
            {$mod->Lang('info_login_afterverify')}
          </p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$prompt_skip_final_msg}:</p>
		<p class="pageinput">{$input_skip_final_msg}
                  <br/>{$mod->Lang('info_skip_final_msg')}
                </p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_redirect_afterregister}:</p>
		<p class="pageinput">{$input_redirect_afterregister}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_redirect_afterverify}:</p>
		<p class="pageinput">{$input_redirect_afterverify}</p>
	</div>
    </fieldset>

    {if isset($input_allowpaidregistration)}
    <fieldset>
        <legend>{$mod->Lang('paid_registration')}:</legend>
        <div class="pageoverflow">
          <p class="pagetext">{$mod->Lang('prompt_allow_paid_registration')}:</p>
          <p class="pageinput">
            {$input_allowpaidregistration}
            <br/>
            {$mod->Lang('info_allow_paid_registration')}
          </p>
        </div>
         
        <div class="pageoverflow">
          <p class="pagetext">{$mod->Lang('prompt_cartitem_summary_tpl')}:</p>
          <p class="pageinput">
            <input type="text" name="{$actionid}cartitem_summary_tpl" size="80" value="{$cartitem_summary_tpl}"/>
            <br/>
            {$mod->Lang('info_cartitem_summary_tpl')}
          </p>
        </div>

	<div class="pageoverflow">
	  <p class="pagetext">{$mod->Lang('prompt_redirect_paidpkg')}:</p>
	  <p class="pageinput">
            <input type="text" name="{$actionid}redirect_paidpkg" size="80" maxlength="255" value="{$redirect_paidpkg}"/>
            <br/>
            {$mod->Lang('info_redirect_paidpkg')}
          </p>
	</div>

	<div class="pageoverflow">
	  <p class="pagetext">{$mod->Lang('setup_cart_events')}:</p>
	  <p class="pageinput">
            <input type="submit" name="{$actionid}setup_cart_events" value="{$mod->Lang('setup')}"/>
            <br/>
            {$mod->Lang('info_setup_cart_events')}
          </p>
	</div>
   
    </fieldset>
    {/if}

    <fieldset>
        <legend>{$mod->Lang('prompt_additionalgroups_settings')}:</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('prompt_reg_additionalgroups')}:</p>
		<p class="pageinput">{$input_reg_additionalgroups}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('prompt_additionalgroups_matchfields')}:</p>
		<p class="pageinput">
                <select name="{$actionid}input_additionalgroups_matchfields[]" multiple="multiple" size="5">
                {html_options options=$matchfield_options selected=$additionalgroups_matchfields}
                </select>
                <br/>
                {$mod->Lang('info_additionalgroups_matchfields')}</p>
	</div>
    </fieldset>

    <fieldset>
        <legend>{$mod->Lang('notifications')}:</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_notify}:</p>
		<p class="pageinput">{$input_notify}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_confirmmail_to}:</p>
		<p class="pageinput">{$input_confirmmail_to}</p>
	</div>
    </fieldset>

    <fieldset>
        <legend>{$mod->Lang('prompt_security_settings')}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_enable_whitelist}:</p>
		<p class="pageinput">{$input_enable_whitelist}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('prompt_noregister')}:</p>
		<p class="pageinput">{$input_noregister}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_whitelist}:</p>
		<p class="pageinput">{$input_whitelist}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_whitelist_trigger_message}:</p>
		<p class="pageinput">{$input_whitelist_trigger_message}</p>
	</div>
    </fieldset>
    <div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$hidden|default:''}{$submit}</p>
    </div>
   </td>
   {* options to reset users that didn't complete registration *}
   <td width="50%" valign="top">
   {if isset($prompt_numresetrecords)}
      <div class="pageoverflow">
	<p class="pagetext">{$prompt_numresetrecords|default:''}</p>
	<p class="pageinput">{$data_numresetrecords}</p>
      </div>
   {/if}
   {if isset($input_remove1week)}
      <div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$input_remove1week}</p>
      </div>
   {/if}
   {if isset($input_remove1month)}
      <div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$input_remove1month}</p>
      </div>
   {/if}
   {if isset($input_remove1day)}
      <div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$input_remove1day}</p>
      </div>
   {/if}
   {if isset($input_remove1all)}
      <div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$input_removeall}</p>
      </div>
   {/if}
   {if isset($input_list1day)}
      <div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$input_list1day}</p>
      </div>
   {/if}
   </td>
  </tr>
</table>
{$endform}
