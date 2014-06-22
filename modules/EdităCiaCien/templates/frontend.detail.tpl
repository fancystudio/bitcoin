<div class="mcf_editciacien">
	<h2>{$Edit„CiaCien->title}</h2>
	
	{if $Edit„CiaCien->btc_k_dispozci_na_predaj ne ''}
	<p><strong>BTC k dispoz√≠ci√≠ na predaj:</strong> 
	{$Edit„CiaCien->btc_k_dispozci_na_predaj}
	</p>
	{/if}
	{if $Edit„CiaCien->EUR_k_dispozci_na_nkup ne ''}
	<p><strong>‚Ç¨ k dispoz√≠ci√≠ na n√°kup:</strong> 
	{$Edit„CiaCien->EUR_k_dispozci_na_nkup}
	</p>
	{/if}
	{if $Edit„CiaCien->mara_v_Percent_na_predaj ne ''}
	<p><strong>mar≈æa v % na predaj:</strong> 
	{$Edit„CiaCien->mara_v_Percent_na_predaj}
	</p>
	{/if}
	{if $Edit„CiaCien->mara_v_Percent_na_nkup ne ''}
	<p><strong>mar≈æa v % na n√°kup:</strong> 
	{$Edit„CiaCien->mara_v_Percent_na_nkup}
	</p>
	{/if}
</div>

{* Call child modules *}


{* Call ModuleXtender items *}

{if isset($Edit„CiaCien->xtended_felist)}
<div class="mcf_modulextender">
{if $Edit„CiaCien->xtended_felist->documents|@count gt 0}
<ul class="mx_documents">
	{foreach from=$Edit„CiaCien->xtended_felist->documents item=document}
	<li>
		<img src="{$document->getIcon()}" align="absmiddle" />
		<a href="{$document->getDocumentUrl()}" rel="external">
	{if $document->getTitle() ne ''}{$document->getTitle()}{else}{$document->getFilename()}{/if}
	</a> ({$document->getSize(true)})</li>
	{/foreach}
</ul>
{/if}

{if $Edit„CiaCien->xtended_felist->images|@count gt 0}
<ul class="mx_images">
	{foreach from=$Edit„CiaCien->xtended_felist->images item=image}
	<li><a href="{$image->url}" rel="external">
	<img src="{$image->resized_images.thumbnail}" />
	</a></li>
	{/foreach}
</ul>
{/if}

{if $Edit„CiaCien->xtended_felist->links|@count gt 0}
<ul class="mx_links">
	{foreach from=$Edit„CiaCien->xtended_felist->links item=link}
	<li><a href="{$link->url}"{if $link->is_new_window == 1} rel="external"{/if}>
	{if $link->title ne ''}{$link->title}{else}{$link->url}{/if}
	</a></li>
	{/foreach}
</ul>
{/if}

{if $Edit„CiaCien->xtended_felist->categories|@count gt 0}
<ul class="mx_categories">
	{foreach from=$Edit„CiaCien->xtended_felist->categories item=options key=category}
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
{if $Edit„CiaCien->xtended_felist->pages|@count gt 0}
<ul class="mx_pages">
	{foreach from=$Edit„CiaCien->xtended_felist->pages item=page}
	<li>{cms_selflink page=$page->alias}</li>
	{/foreach}
</ul>
{/if}
{**}

{* FEATURE DISABLED BY DEFAULT (REMOVE SMARTY COMMENTS TO MAKE IT WORK)}
{if $Edit„CiaCien->xtended_felist->modules|@count gt 0}
<ul class="mx_modules">
	{foreach from=$Edit„CiaCien->xtended_felist->modules item=module}
	<li><a href="{cms_module module=$module->getModuleName() item_id=$module->getId() action="geturl" urlaction="detail"}">{$module->getTitle()}</a></li>
	{/foreach}
</ul>
{/if}
{**}

{* FEATURE DISABLED BY DEFAULT (REMOVE SMARTY COMMENTS TO MAKE IT WORK)}
{if $Edit„CiaCien->xtended_felist->target_modules|@count gt 0}
<ul class="mx_target_modules">
	{foreach from=$Edit„CiaCien->xtended_felist->target_modules item=module}
	<li><a href="{cms_module module=$module->getModuleName() item_id=$module->getId() action="geturl" urlaction="detail"}">{$module->getTitle()}</a></li>
	{/foreach}
</ul>
{/if}
{**}

</div>
{/if}