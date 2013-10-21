<div id="videos_left">
	<div id="videos_profile">
		<a onclick="subscribe_to_video('{$videos_user_key}')" class="label label-info" style="color:#FFFFFF">{$languages->subscribe}</a>
		{if $video_subscribers|count > 0} <br />{$languages->subscribers}: {foreach
		from=$video_subscribers item=subscriber}  <span class="label label-info">{$subscriber.user}</span>, {/foreach}
		{/if} <br /> <select name="galleries" id="select_videos_profile"
			class="ui-widget-header select " onchange="change_video_category()">
			{foreach from=$user_video_galleries item=video}
			<option value="{$video->id}">{$video->gallery_name}</option> {/foreach}
		</select>
	</div>
	<div id="videos">{include file="$tpl_dir/user/videos/videos.tpl"}</div>
</div>
<div id="videos_right">
	<div id="videos_comments"></div>
	<div id="video"></div>
</div>


{literal}
<script type="text/javascript">
function show_video(id)
{
	 $("#videos_comments").html('');
	 $("#video").html('');

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=video_details",
		data : {
			'id' : id,
			'user' : '{/literal}{$videos_user_key}{literal}',
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#video").html(response);
			$("#video").accordion({
				header : "h3",
				 fillSpace: true
			});
			hide_loading();
		}
	});

	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=video_comments",
		data : {
			'id' : id,
			'user' : '{/literal}{$videos_user_key}{literal}',
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#videos_comments").html(response);
			$("#left_details").accordion({
				header : "h3",
				 fillSpace: true
			});
			tiny_mce();
		}
	});
}

function change_video_category()
{

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_content&action=view_videos_by_category",
		data : {
			'u_id' : '{/literal}{$videos_user_key}{literal}',
				'c_id' : $("#select_videos_profile").val(),
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		//dataType : 'json',
		success : function(response) {
$("#videos").html('');
			$("#videos").html(response);


			hide_loading();
		}
	});

	$("#video").html('');
	 $("#videos_comments").html('');

}


</script>
{/literal}
