{if $settings->enable_multiple_languages == 'yes'}
{foreach from=$all_languages item=language} <a
	href="index.php?route=index&lang={$language->language}">{$language->language}</a>
	{/foreach}

{/if}