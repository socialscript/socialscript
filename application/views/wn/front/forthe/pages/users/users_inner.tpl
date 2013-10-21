{foreach from=$users item=profile} {include
file="$tpl_dir/home/boxes/profile_box.tpl"} {foreachelse}
{$languages->no_results} {/foreach} {if isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
