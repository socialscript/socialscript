<div id="details_right" class="label label-info" style="width:99%;">
{include
		file="$tpl_dir/pages/video/video_inner.tpl"}
<div id="player_box">
	<div id="left_player"><div id="player"></div>
	<div id="description_player"></div></div>
	<!--
	<div id="right_player">
		<div id='playlist' class="btn btn-success"></div>
	</div>
	-->
</div>
<div class="clear"></div>
</div>
{literal}
<script type="text/javascript">
var xml = {/literal}'{$video_playlist}'{literal};
init_player();
</script>
{/literal}
