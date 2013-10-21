<div id="details_right">
<div id="player_box">
	<div id="left_player"></div>
	<div id="right_player">
		<div id='playlist'></div>
	</div>
</div>
<div class="clear"></div>
</div>
{literal}
<script type="text/javascript">
var xml = {/literal}'{$video_playlist}'{literal};
		var width = {/literal}{$user_video_settings->video_player_width}{literal};
		var height = {/literal}{$user_video_settings->video_player_height}{literal};
init_player();
</script>
{/literal}
