<div class="floatleft group_left">
	<div id="add_new_group_image" onclick="add_new_group_image()">{$languages->add_new_image}</div>
	<div id="add_picture"></div>
	<div id="gallery_pictures">{include
		file="$tpl_dir/pages/groups/group_gallery_pictures.tpl"}</div>
</div>
<div class="floatleft group_middle">
	<div id="group_details_pictures_left_inner">
		<div id="groups_pictures_comments"></div>
	</div>
</div>
<div class="floatleft group_right">
	<div id="group_details_pictures_right_inner">
		<h3>
			<a href="#">
				<div id="picture_title"></div>
			</a>
		</h3>
		<div>
			<div id="picture" class="floatleft"></div>
			<div class="floatleft" style="margin-left: 10px;">
				<div id="picture_tags"></div>
				<br />
				<div id="picture_description"></div>
			</div>
		</div>
	</div>
</div>

{literal}
<script type="text/javascript">

function add_new_group_image()
{

		$("#add_picture").load('index.php?route=users_interaction&action=add_pictures&id={/literal}{$group_id}{literal}').dialog(
				{title:'Add picture',width:'1200',height:'800',resizable:false,modal:true,show: { effect: 'fade'},modal:true,zIndex:'3000',hide: { effect: 'fade'}} )
}
function show_picture(p_id,g_id,u_k,p_n)
{

	show_loading();
	 $("#picture").html('');
	 $("#picture_tags").html('');
	 $("#picture_description").html('');
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=get_group_picture",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'p_id': p_id,
				'g_id':g_id
		},
		dataType : 'json',
		success : function(response) {
			 $("#picture_title").html(response.title);
			 $("#picture").html(response.image);
			 $("#picture_tags").html(response.tags);
			 $("#picture_description").html(response.description);
			 $("#group_details_pictures_right_inner").accordion({
					header : "h3",
					 animated: 'bounceslide',
					 fillSpace: true
				});
		}});


			 $.ajax({
					type : "GET",
					url : "index.php?route=users_interaction&action=view_group_pictures_comments",
					data : {
						'id' : p_id,
						'g_id' : g_id,
						'rh' : '{/literal}{$request_hash}{literal}'
					},
					success : function(response) {

						$("#groups_pictures_comments").html(response);
						 $("#groups_pictures_comments").accordion({
								header : "h3",
								 animated: 'bounceslide',
								 fillSpace: true
							});
$('#group_picture_comment').wysiwyg({dialog:"jqueryui"});
						hide_loading();
					}
				});
}

function change_gallery(dropdown)
{

	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=view_pictures_gallery",
		data : {
			'u_id' : '{/literal}{$picture_user_key}{literal}',
				'g_id' : $("#select_picture_galleries_profile").val(),
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		success : function(response) {
$("#gallery_pictures").html('');
			$("#gallery_pictures").html(response);


			hide_loading();
		}
	});
}


function subscribe_to_pictures(u_k)
{
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=subscribe_to_pictures",
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
