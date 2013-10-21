<div class="floatleft right_boxes">
	{if $settings->enable_chat == 'yes'}
	<div id="right_chat">{include file="$tpl_dir/chat/chat.tpl"}</div>
	{/if}

	<div class="separator_vertical">&nbsp;</div>
	{include file="$tpl_dir/home/boxes/right_bottom_box.tpl"}
</div>
{if isset($banners[1])}
{if $banners[1]->code != ''}
 {/if}
 {/if}
