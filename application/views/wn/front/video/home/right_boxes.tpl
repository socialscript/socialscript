<div class="floatleft right_boxes">
{if $settings->enable_chat == 'yes'}
<div id="right_chat">
{include file="$tpl_dir/chat/chat.tpl"}
</div>
{/if}
{if $settings->show_my_account_box_when_not_logged_in == 'yes' || $user_logged === TRUE}

		{include file="$tpl_dir/home/boxes/my_account.tpl"}

{/if}
<div class="separator_vertical">&nbsp;</div>
{include file="$tpl_dir/home/boxes/right_bottom_box.tpl"}
</div>