<div class="ui-widget-header3" style="width:100%;margin:0;height:20px;">
{foreach from=$footer_pages item=footer_page}
<a class='new-footer-l' {if $no_ajax=='yes'}href="{$settings->site_url}{$footer_page->url}/{$footer_page->id}"
				{else}onclick="show_text_page('{$footer_page->id}')"{/if}>{$footer_page->name}</a> |
{/foreach}</div>
<div id="demo1" data-title="sharrre" data-url="http://sharrre.com" ></div>
