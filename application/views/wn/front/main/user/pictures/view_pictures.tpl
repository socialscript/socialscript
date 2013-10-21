<div id="galleries_left">
	<a onclick="subscribe_to_pictures('{$picture_user_key}')" class="label label-info" style="color:#FFFFFF">{$languages->subscribe}</a>
	{if $pictures_subscribers|count > 0} <br />{$languages->subscribers}:
	{foreach from=$pictures_subscribers item=subscriber}
	<span class="label label-info" style="color:#FFFFFF">{$subscriber.user}</span>, {/foreach} {/if} <br />
	<div id="galleries_profile">
		<select name="galleries" id="select_picture_galleries_profile"
			class="ui-widget-header select " onchange="change_gallery(this)">
			{foreach from=$pictures_galleries item=user_gallery}
			<option value="{$user_gallery->id}">{$user_gallery->gallery_name}</option>
			{/foreach}
		</select>
	</div>
	<div id="gallery_pictures">{include
		file="$tpl_dir/user/pictures/gallery_pictures.tpl"}</div>
</div>

<div id="galleries_right">
	<div id="pictures_comments"></div>
	<div id="big_picture_gallery"></div>
</div>




{literal}
<script type="text/javascript">


function change_gallery(dropdown)
{

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_content&action=view_pictures_gallery",
		data : {
			'u_id' : '{/literal}{$picture_user_key}{literal}',
				'g_id' : $("#select_picture_galleries_profile").val(),
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		//dataType : 'json',
		success : function(response) {
$("#gallery_pictures").html('');
			$("#gallery_pictures").html(response);


			hide_loading();
		}
	});




	$("#big_picture_gallery").html('');
	 $("#pictures_comments").html('');

}


</script>
{/literal}
