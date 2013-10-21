<div id="add_group_blog" class="hidden" style="width: 500px">
	{$languages->title}: <input type="text" name="group_blog_title"
		id="group_blog_title" class="ui-widget-header  input input_text_big">
	<textarea id="group_blog_text" style="width: 400px; height: 250px"
		class="ui-widget-header  input"></textarea>
	<input type="button" value="Submit" class="ui-widget-header input"
		onclick="add_group_blog_text('{$group->id}')">
</div>

<div class="floatleft group_left">
	<div id="add_new_group_blog" onclick="add_new_group_blog()">{$languages->add_new_blog}</div>
	<div id="group_blogs">{include file="$tpl_dir/pages/groups/blogs.tpl"}</div>
</div>
<div class="floatleft group_middle">
	<div id="group_details_left_inner">
		<div id="groups_comments"></div>
	</div>
</div>
<div class="floatleft group_right">
	<div id="group_details_right_inner">
		<div id="group_blog_id" class="hidden"></div>
		<h3>
			<a href="#">
				<div id="edit_group_blog_title"></div>
			</a>
		</h3>
		<div>
			<div id="edit_group_blog_text"></div>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">


function add_new_group_blog()
{
	$("#group_blog_title").val('');
	$("#group_blog_text").val('');

	$("#add_group_blog").dialog( {open: function(event, ui) { $('#group_blog_text').wysiwyg({dialog:"jqueryui"}); },modal:true,title:'{/literal}{$languages->add_new_blog}{literal}',width:'500',height:'380',resizable:false,show: { effect: 'fade'},zIndex:'4000',hide: { effect: 'fade'}} )
	//$("#add_group_blog").show();

}

function add_group_blog_text(group_id)
{

	show_loading();

	if($.trim($("#group_blog_title").val()) == '' || $.trim($("#group_blog_text").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_group_blog",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'group_blog_title':$("#group_blog_title").val(),
				'group_blog_text':$("#group_blog_text").val(),
				'group_id':group_id
		},
		 dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			$("#group_blog_title").val('');
			$("#group_blog_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=group_blogs",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'group_id': group_id
				},
				success : function(response) {

					$("#add_group_blog").dialog('close');

							$("#group_blogs").html('');
							 $("#group_blogs").html(response);

		$("#add_group_blog").hide();
		$("#edit_group_blog").hide();
		$("#edit_group_blog_title").val('');
		$("#edit_group_blog_text").val('');
		$("#group_blog_title").val();
		$("#group_blog_text").val();
							hide_loading();

						}
					});


		}
	});

}




function view_group_blog(group_blog_id)
{
	$("#edit_group_blog_title").val('');
	$("#edit_group_blog_text").val('');
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=get_group_blog",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'blog_id': group_blog_id
		},
		dataType : 'json',
		success : function(response) {


					 $("#edit_group_blog_title").html(response.title);
					 $("#edit_group_blog_text").html(response.text);
					 $("#group_details_right_inner").accordion({
							header : "h3",
							 animated: 'bounceslide',
							 fillSpace: true
						});
					 $.ajax({
							type : "POST",
							url : "index.php?route=users_interaction&action=view_group_blog_comments",
							data : {
								'id' : group_blog_id,
								'rh' : '{/literal}{$request_hash}{literal}'
							},

							success : function(response) {
								$("#groups_comments").html(response);
								 $("#groups_comments").accordion({
										header : "h3",
										 animated: 'bounceslide',
										 fillSpace: true
									});
//$("#group_details_left_inner").show();
$('#group_blog_comment').wysiwyg({dialog:"jqueryui"});
								hide_loading();
							}
						});


				}
			});

}

function edit_group_blog_text()
{

	show_loading();


	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=edit_group_blog",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'group_blog_title':$("#edit_group_blog_title").val(),
				'group_blog_text':$("#edit_group_blog_text").val(),
				'group_blog_id':$("#group_blog_id").html()
		},
		success : function(response) {
			show_notification(response.status);

			$("#group_blog_title").val('');
			$("#group_blog_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=user_group_blogs",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'group_blog_category': $("#select_group_blog_categories").val()
				},
				success : function(response) {



							$("#group_blogs").html('');
							 $("#group_blogs").html(response);

		$("#add_group_blog").hide();
		$("#edit_group_blog").hide();
		$("#edit_group_blog_title").val('');
		$("#edit_group_blog_text").val('');
		$("#group_blog_title").val();
		$("#group_blog_text").val();
							hide_loading();

						}
					});


		}
	});

}
</script>
{/literal}
