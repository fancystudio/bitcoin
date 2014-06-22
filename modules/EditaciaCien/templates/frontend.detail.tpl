<div class="mcf_editaciacien">
	<h2>{$EditaciaCien->title}</h2>
	
	{if $EditaciaCien->EUR_k_dispozci_na_nkup ne ''}
	<p><strong>€ k dispozícií na nákup:</strong> 
	{$EditaciaCien->EUR_k_dispozci_na_nkup}
	</p>
	{/if}
	{if $EditaciaCien->btc_k_dispozci_na_predaj ne ''}
	<p><strong>BTC k dispozícií na predaj:</strong> 
	{$EditaciaCien->btc_k_dispozci_na_predaj}
	</p>
	{/if}
	{if $EditaciaCien->mara_v_Percent_na_nkup ne ''}
	<p><strong>marža v % na nákup:</strong> 
	{$EditaciaCien->mara_v_Percent_na_nkup}
	</p>
	{/if}
	{if $EditaciaCien->mara_v_Percent_na_predaj ne ''}
	<p><strong>marža v % na predaj:</strong> 
	{$EditaciaCien->mara_v_Percent_na_predaj}
	</p>
	{/if}
</div>

{* Call child modules *}


{* Call ModuleXtender items *}

{if isset($EditaciaCien->xtended_felist)}
<div class="mcf_modulextender">
{if $EditaciaCien->xtended_felist->documents|@count gt 0}
<ul class="mx_documents">
	{foreach from=$EditaciaCien->xtended_felist->documents item=document}
	<li>
		<img src="{$document->getIcon()}" align="absmiddle" />
		<a href="{$document->getDocumentUrl()}" rel="external">
	{if $document->getTitle() ne ''}{$document->getTitle()}{else}{$document->getFilename()}{/if}
	</a> ({$document->getSize(true)})</li>
	{/foreach}
</ul>
{/if}

{if $EditaciaCien->xtended_felist->images|@count gt 0}
<ul class="mx_images">
	{foreach from=$EditaciaCien->xtended_felist->images item=image}
	<li><a href="{$image->url}" rel="external">
	<img src="{$image->resized_images.thumbnail}" />
	</a></li>
	{/foreach}
</ul>
{/if}

{if $EditaciaCien->xtended_felist->links|@count gt 0}
<ul class="mx_links">
	{foreach from=$EditaciaCien->xtended_felist->links item=link}
	<li><a href="{$link->url}"{if $link->is_new_window == 1} rel="external"{/if}>
	{if $link->title ne ''}{$link->title}{else}{$link->url}{/if}
	</a></li>
	{/foreach}
</ul>
{/if}

{if $EditaciaCien->xtended_felist->categories|@count gt 0}
<ul class="mx_categories">
	{foreach from=$EditaciaCien->xtended_felist->categories item=options key=category}
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
{if $EditaciaCien->xtended_felist->pages|@count gt 0}
<ul class="mx_pages">
	{foreach from=$EditaciaCien->xtended_felist->pages item=page}
	<li>{cms_selflink page=$page->alias}</li>
	{/foreach}
</ul>
{/if}
{**}

{* FEATURE DISABLED BY DEFAULT (REMOVE SMARTY COMMENTS TO MAKE IT WORK)}
{if $EditaciaCien->xtended_felist->modules|@count gt 0}
<ul class="mx_modules">
	{foreach from=$EditaciaCien->xtended_felist->modules item=module}
	<li><a href="{cms_module module=$module->getModuleName() item_id=$module->getId() action="geturl" urlaction="detail"}">{$module->getTitle()}</a></li>
	{/foreach}
</ul>
{/if}
{**}

{* FEATURE DISABLED BY DEFAULT (REMOVE SMARTY COMMENTS TO MAKE IT WORK)}
{if $EditaciaCien->xtended_felist->target_modules|@count gt 0}
<ul class="mx_target_modules">
	{foreach from=$EditaciaCien->xtended_felist->target_modules item=module}
	<li><a href="{cms_module module=$module->getModuleName() item_id=$module->getId() action="geturl" urlaction="detail"}">{$module->getTitle()}</a></li>
	{/foreach}
</ul>
{/if}
{**}

</div>
{/if}