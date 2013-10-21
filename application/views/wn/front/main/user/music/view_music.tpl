<div id="the_musics_left">
	<div id="the_musics_profile">
		<a onclick="subscribe_to_music('{$music_user_key}')" class="label label-info" style="color:#FFFFFF">{$languages->subscribe}</a>
		{if $music_subscribers|count > 0} <br />{$languages->subscribers}: {foreach
		from=$music_subscribers item=subscriber} <span class="label label-info">{$subscriber.user}</span>, {/foreach}
		{/if} <br /> <select name="galleries" id="select_the_musics_profile"
			class="ui-widget-header select " onchange="change_music_category()">
			{foreach from=$user_music_galleries item=the_music}
			<option value="{$the_music->id}">{$the_music->gallery_name}</option> {/foreach}
		</select>
	</div>
	<div id="the_musics">{include file="$tpl_dir/user/music/music.tpl"}</div>
</div>
<div id="the_musics_right">
	<div id="the_musics_comments"></div>
	<div id="the_music"></div>
</div>


{literal}
<script type="text/javascript">
function show_music(id)
{
	 $("#the_musics_comments").html('');
	 $("#the_music").html('');

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=music_details",
		data : {
			'id' : id,
			'user' : '{/literal}{$music_user_key}{literal}',
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#the_music").html(response);
			$("#the_music").accordion({
				header : "h3",
				 fillSpace: true
			});
			hide_loading();
		}
	});

	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=music_files_comments",
		data : {
			'id' : id,
			'user' : '{/literal}{$music_user_key}{literal}',
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#the_musics_comments").html(response);
			$("#left_details").accordion({
				header : "h3",
				 fillSpace: true
			});
			tiny_mce();
		}
	});
}

function change_music_category()
{

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_content&action=view_music_by_category",
		data : {
			'u_id' : '{/literal}{$music_user_key}{literal}',
				'c_id' : $("#select_the_musics_profile").val(),
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		//dataType : 'json',
		success : function(response) {
$("#the_musics").html('');
			$("#the_musics").html(response);


			hide_loading();
		}
	});

	$("#the_music").html('');
	 $("#the_musics_comments").html('');

}


</script>
{/literal}
