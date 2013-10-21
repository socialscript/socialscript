{if isset($banners[3])}
 {if $banners[3]->code != ''}
<div class="banner_bottom floatleft">{$banners[3]->code}</div>
{/if}
{/if}
<div class="ui-widget-header"
	style="width: 100%; margin: 0; height: 20px;">
	{foreach from=$footer_pages item=footer_page} <a {if $no_ajax==
		'yes'}href="{$settings->site_url}{$footer_page->url}/{$footer_page->id}"
		{else}onclick="show_text_page('{$footer_page->id}')"{/if}>{$footer_page->name}</a>
	| {/foreach}
</div>
