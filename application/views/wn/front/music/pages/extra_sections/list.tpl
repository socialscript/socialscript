 {foreach from=$extra_sections item=theextra_sections}
<div class="theextra_sections  ui-widget-header">
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/{$type}/{$theextra_sections->safe_seo_url}/{$theextra_sections->id}"
		{else}onclick="extra_sections_details('{$type}','{$theextra_sections->id}','{$theextra_sections->user_key}')"{/if}>{$theextra_sections->title}</a><br />
	{$theextra_sections->text|substr:0:20} <br /> {$languages->by}:
	{$theextra_sections->username}
	{$theextra_sections->timestamp|date_format:$settings->date_format}
</div>
{foreachelse} {$languages->no_results} {/foreach} {if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
