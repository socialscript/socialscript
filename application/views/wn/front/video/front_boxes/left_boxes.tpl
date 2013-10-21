<div class="floatleft left_boxes">

<div id="left_sections"></div>
<div id="left_my_account">
{if $settings->show_my_account_box_when_not_logged_in == 'yes' || $user_logged === TRUE}

		{include file="$tpl_dir/front_boxes/boxes/my_account.tpl"}

{/if}
</div>

{include file="$tpl_dir/front_boxes/boxes/left_bottom_box.tpl"}