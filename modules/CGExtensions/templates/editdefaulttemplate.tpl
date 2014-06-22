{if isset($simple) && !$simple && isset($dflt_tpl_counter) && $dflt_tpl_counter == 0}
<script type="text/javascript">
$(document).ready(function(){
  $('h4.cge_dflt_template_hdr').click(function(){
    $('.cge_dflt_template').hide();
    $(this).next('.cge_dflt_template').show();
    $('html,body').animate({ scrollTop: $(this).offset().top });
  });
  $('.cge_dflt_template').hide();
  $('.cge_dflt_template').first().show();
});
</script>
{/if}

{if isset($defaulttemplateform_title)}
  {if isset($simple) && $simple}
    <h4>{$defaulttemplateform_title}</h4>
  {else}
    <h4 id="{$prefname}" class="cge_dflt_template_hdr"><a href="javascript:void()"><span class="cge_toggle">+</span>&nbsp;{$defaulttemplateform_title}</a></h4>
  {/if}
{/if}

  <div class="pageoverflow cge_dflt_template" id="{$prefname}_tpl">
    {if isset($info_title) && $info_title}
      <p><em>{$info_title}</em></p>
    {/if}
    {$startform}
    <p class="pagetext">{$prompt_template}:</p>
    <p class="pageinput">{$input_template}
      <br/>{$submit}{$reset}
    </p>
    {$endform}
  </div>
