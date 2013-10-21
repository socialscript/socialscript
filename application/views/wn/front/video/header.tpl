<header>
<div id="top">
{if $user_logged === FALSE}
{include file="$tpl_dir/header_not_logged.tpl"}
{else}
{include file="$tpl_dir/header_logged.tpl"}
{/if}
</div>
</header>
