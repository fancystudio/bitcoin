<ul class="tagcloud">
    {foreach from=$tags item=tag}
        {capture assign=value}%{$tag.tag}%{/capture}
        <li class="weight-{$tag.class}"><a href="{{literal}}{{{/literal}}{{$module->getModuleName()}} action="url_for" limit=20 tag=$value}">{$tag.tag}</a></li>
    {/foreach}
</ul>