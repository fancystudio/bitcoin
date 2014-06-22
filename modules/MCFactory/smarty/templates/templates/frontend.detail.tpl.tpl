<div class="mcf_{{$module->getModuleName()|lower}}">
	<h2>{${{$module->getModuleName()}}->title}</h2>
	
{{foreach from=$extra_fields item=field}}
{{if $field.form_type ne 'none'}}
	{if ${{$module->getModuleName()}}->{{$field.name}} ne ''}
	<p><strong>{{$field.label}}:</strong> 
{{if $field.type == 'image'}}
		<img src="{${{$module->getModuleName()}}->get{{$field.camelcase}}Url($id)}" />
{{elseif $field.type == 'document'}}
		<a href="{${{$module->getModuleName()}}->get{{$field.camelcase}}Url($id)}" rel="external">Download</a>
{{elseif $field.type == 'page'}}
	{cms_selflink page=${{$module->getModuleName()}}->{{$field.name}}}
{{elseif $field.type == 'select'}}
	{${{$module->getModuleName()}}->get{{$field.camelcase}}Value()}
{{else}}
	{${{$module->getModuleName()}}->{{$field.name}}}
{{/if}}
	</p>
	{/if}
{{/if}}
{{/foreach}}
</div>

{* Call child modules *}

{{if $child_modules|@count > 0}}
<div class="mcf_childs">
{{foreach from=$child_modules item=child_module}}

<div class="mcf_child_{{$child_module->getModuleName()}}">
{{literal}}{{{/literal}}{{$child_module->getModuleName()}} parent_item=${{$module->getModuleName()}}->getId()}
</div>
{{/foreach}}
</div>
{{/if}}

{* Call ModuleXtender items *}

{if isset(${{$module->getModuleName()}}->xtended_felist)}
<div class="mcf_modulextender">
{if ${{$module->getModuleName()}}->xtended_felist->documents|@count gt 0}
<ul class="mx_documents">
	{foreach from=${{$module->getModuleName()}}->xtended_felist->documents item=document}
	<li>
		<img src="{$document->getIcon()}" align="absmiddle" />
		<a href="{$document->getDocumentUrl()}" rel="external">
	{if $document->getTitle() ne ''}{$document->getTitle()}{else}{$document->getFilename()}{/if}
	</a> ({$document->getSize(true)})</li>
	{/foreach}
</ul>
{/if}

{if ${{$module->getModuleName()}}->xtended_felist->images|@count gt 0}
<ul class="mx_images">
	{foreach from=${{$module->getModuleName()}}->xtended_felist->images item=image}
	<li><a href="{$image->url}" rel="external">
	<img src="{$image->resized_images.thumbnail}" />
	</a></li>
	{/foreach}
</ul>
{/if}

{if ${{$module->getModuleName()}}->xtended_felist->links|@count gt 0}
<ul class="mx_links">
	{foreach from=${{$module->getModuleName()}}->xtended_felist->links item=link}
	<li><a href="{$link->url}"{if $link->is_new_window == 1} rel="external"{/if}>
	{if $link->title ne ''}{$link->title}{else}{$link->url}{/if}
	</a></li>
	{/foreach}
</ul>
{/if}

{if ${{$module->getModuleName()}}->xtended_felist->categories|@count gt 0}
<ul class="mx_categories">
	{foreach from=${{$module->getModuleName()}}->xtended_felist->categories item=options key=category}
	<li><strong>{$category}</strong>
		<ul>
			{foreach from=$options item=option}
			<li>{$option->getTitle()}</li>
			{/foreach}
		</ul>
	</li>
	{/foreach}
</ul>
{/if}

{* FEATURE DISABLED BY DEFAULT (REMOVE SMARTY COMMENTS TO MAKE IT WORK)}
{if ${{$module->getModuleName()}}->xtended_felist->pages|@count gt 0}
<ul class="mx_pages">
	{foreach from=${{$module->getModuleName()}}->xtended_felist->pages item=page}
	<li>{cms_selflink page=$page->alias}</li>
	{/foreach}
</ul>
{/if}
{**}

{* FEATURE DISABLED BY DEFAULT (REMOVE SMARTY COMMENTS TO MAKE IT WORK)}
{if ${{$module->getModuleName()}}->xtended_felist->modules|@count gt 0}
<ul class="mx_modules">
	{foreach from=${{$module->getModuleName()}}->xtended_felist->modules item=module}
	<li><a href="{cms_module module=$module->getModuleName() item_id=$module->getId() action="geturl" urlaction="detail"}">{$module->getTitle()}</a></li>
	{/foreach}
</ul>
{/if}
{**}

{* FEATURE DISABLED BY DEFAULT (REMOVE SMARTY COMMENTS TO MAKE IT WORK)}
{if ${{$module->getModuleName()}}->xtended_felist->target_modules|@count gt 0}
<ul class="mx_target_modules">
	{foreach from=${{$module->getModuleName()}}->xtended_felist->target_modules item=module}
	<li><a href="{cms_module module=$module->getModuleName() item_id=$module->getId() action="geturl" urlaction="detail"}">{$module->getTitle()}</a></li>
	{/foreach}
</ul>
{/if}
{**}

</div>
{/if}