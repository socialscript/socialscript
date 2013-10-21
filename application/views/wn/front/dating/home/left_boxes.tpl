<div class="floatleft left_boxes">

	<div id="left_sections"></div>
	<div id="left_my_account">{if $user_logged === TRUE} {include
		file="$tpl_dir/home/boxes/my_account.tpl"}
		{else}
		{include
		file="$tpl_dir/home/boxes/login.tpl"}
		 {/if}</div>

	{include file="$tpl_dir/home/boxes/left_bottom_box.tpl"}
</div>