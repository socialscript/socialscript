<div class="floatleft group_left">
	<div id="add_new_group_music" onclick="add_new_group_music()">{$languages->add_music}</div>
	<div id="add_music"></div>
	<div id="gallery_musics">
		{include file="$tpl_dir/pages/groups/group_gallery_musics.tpl"}
</div>
</div>
<div class="floatleft group_middle">
	<div id="group_details_musics_left_inner">
		<div id="group_musics_comments"></div>
	</div>
</div>
<div class="floatleft group_right">
	<div id="group_details_musics_right_inner">
			<div id="music"></div>
		</div>
	</div>




{literal}
<script type="text/javascript">

function add_new_group_music()
{
		$("#add_music").load('index.php?route=users_interaction&action=add_musics&id={/literal}{$group_id}{literal}').dialog(
				{title:'Add music',width:'1000',height:'600',resizable:false,modal:true,show: { effect: 'fade'},zIndex:'3000',hide: { effect: 'fade'}} )
}
function show_music(p_id,g_id,g_n,u_k,p_n)
{

	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=get_group_music",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': p_id,
				'g_id':g_id
		},
		//dataType : 'json',
		success : function(response) {
			 $("#music").html(response);
			 $("#music").accordion({
					header : "h3",
					 animated: 'bounceslide',
					 fillSpace: true
				});
		}});
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=view_group_music_comments",
		data : {
			'id' : p_id,
			'g_id' : g_id,
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		//dataType : 'json',
		success : function(response) {

			$("#group_musics_comments").html(response);
			 $("#group_musics_comments").accordion({
					header : "h3",
					 animated: 'bounceslide',
					 fillSpace: true
				});
//$("#group_details_left_inner").show();
$('#group_music_comment').wysiwyg({dialog:"jqueryui"});

			hide_loading();
		}
	});


}

function subscribe_to_musics(u_k)
{
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=subscribe_to_musics",
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
</script>
{/literal}