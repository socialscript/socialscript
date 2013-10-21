{if isset($banners[3])}
 {if $banners[3]->code != ''}
<div class="banner_bottom floatleft">{$banners[3]->code}</div>
{/if}
{/if}
<div class="navbar navbar-fixed-bottom" >
  <div class="navbar-inner">
  <div class="container">
  <ul class="nav" style="margin-left:200px;padding:0"> 
	{foreach from=$footer_pages item=footer_page} <li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}{$footer_page->url}/{$footer_page->id}"
		{else}onclick="show_text_page('{$footer_page->id}')"{/if}>{$footer_page->name}</a></li><li class="divider-vertical"></li>
	 {/foreach}
	</ul>
</div>
</div>
</div>
