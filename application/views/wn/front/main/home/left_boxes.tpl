<div class="floatleft left_boxes">

	<div id="left_sections"></div>
	<div id="left_my_account">{if
		$settings->show_my_account_box_when_not_logged_in == 'yes' ||
		$user_logged === TRUE} {include
		file="$tpl_dir/home/boxes/my_account.tpl"} {/if}</div>
<div class="vertical_separator">&nbsp;</div>
	{include file="$tpl_dir/home/boxes/left_bottom_box.tpl"}
</div>