<div id="show_games"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_games" href="#collapseGames">
	 {$languages->flash_games}</a>
	</div>
    <div id="collapseGames" class="accordion-body collapse in">
      <div class="accordion-inner">
	<div class="middle_min_height">

		{foreach from=$games item=game}
		<div class="games_left label label-info">
			<a {if $no_ajax==
				'yes'}href="{$settings->site_url}flash_game/{$game->safe_seo_url}/{$game->id}"
				{else}onclick="show_game_details('{$game->id}')"{/if}>{$game->title}</a>
			<br /> {$languages->tags}: {$game->tags}
		</div>

		{foreachelse} {$languages->no_results} {/foreach} <br />

	</div>

</div>
</div>
</div>
