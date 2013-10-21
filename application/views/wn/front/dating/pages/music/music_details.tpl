<div id="details_right">
{include
		file="$tpl_dir/pages/music/music_inner.tpl"}
<div id="player_box">
	<div id="left_player"><div id="player"></div>
	<div id="description_player"></div></div>
	<div id="right_player">
		<div id='playlist'></div>
	</div>
</div>
<div class="clear"></div>
</div>
{literal}
<script type="text/javascript">
var xml = {/literal}'{$music_playlist}'{literal};
init_player_audio();
</script>
{/literal}
