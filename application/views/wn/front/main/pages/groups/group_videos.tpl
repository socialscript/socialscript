<div class="floatleft group_left">
	<div id="add_new_group_video" onclick="add_new_group_video()" class="btn btn-warning">{$languages->add_video}</div>
	<div id="add_video"></div>
	<div id="gallery_videos">{include
		file="$tpl_dir/pages/groups/group_gallery_videos.tpl"}</div>
</div>
<div class="floatleft group_middle">
	<div id="group_details_videos_left_inner">
		<div id="group_videos_comments"></div>
	</div>
</div>
<div class="floatleft group_right">
	<div id="group_details_videos_right_inner">


		<div id="video"></div>

	</div>
</div>

{literal}
<script type="text/javascript">

function add_new_group_video()
{
		$("#add_video").load('index.php?route=users_interaction&action=add_videos&id={/literal}{$group_id}{literal}').dialog(
				{title:'Add video',width:'1000',height:'600',resizable:false,modal:true,show: { effect: 'fade'},zIndex:'3000',hide: { effect: 'fade'}} )
}
function show_video(p_id,g_id,g_n,u_k,p_n)
{

	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=get_group_video",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': p_id,
				'g_id':g_id
		},
		//dataType : 'json',
		success : function(response) {
			 $("#video").html(response);
			 $("#video").accordion({
					header : "h3",
					 animated: 'bounceslide',
					 fillSpace: true
				});
		}});
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=view_group_videos_comments",
		data : {
			'id' : p_id,
			'g_id' : g_id,
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		//dataType : 'json',
		success : function(response) {

			$("#group_videos_comments").html(response);
			 $("#group_videos_comments").accordion({
					header : "h3",
					 animated: 'bounceslide',
					 fillSpace: true
				});
//$("#group_details_left_inner").show();
tiny_mce();

			hide_loading();
		}
	});


}

function change_gallery(dropdown)
{

	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=view_videos_gallery",
		data : {
			'u_id' : '{/literal}{}{literal}',
				'g_id' : $("#select_video_galleries_profile").val(),
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		//dataType : 'json',
		success : function(response) {
$("#gallery_videos").html('');
			$("#gallery_videos").html(response);


			hide_loading();
		}
	});



}


function subscribe_to_videos(u_k)
{
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=subscribe_to_videos",
		data : {

			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			hide_loading();
		}
	});
}

function delete_group_video(id)
{
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=delete_group_video",
		data : {

			'id' : id,
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			hide_loading();
		}
	});
}

</script>
{/literal}
