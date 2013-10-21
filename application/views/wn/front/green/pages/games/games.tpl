<div id="show_games">
	<h3>
		<a href="#">{$languages->flash_games}</a>
	</h3>
	<div class="middle_min_height">

		{foreach from=$games item=game}
		<div class="games_left ui-widget-header">
			<a {if $no_ajax==
				'yes'}href="{$settings->site_url}flash_game/{$game->safe_seo_url}/{$game->id}"
				{else}onclick="show_game_details('{$game->id}')"{/if}>{$game->title}</a>
			<br /> {$languages->tags}: {$game->tags}
		</div>

		{foreachelse} {$languages->no_results} {/foreach} <br />

	</div>

</div>
