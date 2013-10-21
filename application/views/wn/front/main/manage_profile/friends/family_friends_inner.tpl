{foreach from=$family_friends item=profile} {include
file="$tpl_dir/manage_profile/friends/friends_user_box.tpl"}
{foreachelse} {$languages->no_results} {/foreach} {if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
