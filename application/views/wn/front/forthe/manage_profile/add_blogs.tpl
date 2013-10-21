
<div class="floatleft manage_blogs_left">

	<div id="blogs_categories">
		{$languages->select_from_existing_categories}:<br /> <select
			name="select_blog_categories" id="select_blog_categories"
			class="ui-widget-header select "
			onchange="change_blog_category(this)"> {foreach
			from=$user_blog_categories item=user_blog_category}
			<option value="{$user_blog_category->id}">{$user_blog_category->category}</option>
			{/foreach}
		</select>
	</div>
	<div id="create_new_blog_category">
		{$languages->create_new_category}:<br /> <input type="text"
			name="blog_category" id="new_blog_category"
			class="ui-widget-header  input"> <br />
		<input type="button" name="submit" value="Add"
			class='ui-widget-header ' onclick="add_blog_category()">
	</div>
	<div class="clear"></div>
	<br />
	<div id="add_new_blog" onclick="add_new_blog()">{$languages->add_new_blog}</div>
	<br />
	<div id="blogs">{include file="$tpl_dir/manage_profile/blogs.tpl"}</div>

</div>



<div id="add_blog" class="floatleft hidden manage_blogs_right">
	{$languages->title}: <input type="text" name="blog_title"
		id="blog_title" class="ui-widget-header blog_title">
	<textarea id="blog_text" style="width: 800px; height: 600px;"
		class="ui-widget-header blog_textarea"></textarea>
	<input type="button" value="Submit" class="ui-widget-header  input"
		onclick="add_blog_text()">
</div>

<div id="edit_blog" class="floatleft hidden manage_blogs_right">
	<div id="blog_id" class="hidden"></div>
	{$languages->title}: <input type="text" name="edit_blog_title"
		id="edit_blog_title" class="ui-widget-header blog_title  input">
	<textarea id="edit_blog_text" class="ui-widget-header  blog_textarea"></textarea>
	<input type="button" value="Submit" onclick="edit_blog_text()"
		class="ui-widget-header  input">
</div>
<div class="clear"></div>
{literal}
<script type="text/javascript">

function add_blog_category()
{
	show_loading();
	if($.trim($("#new_blog_category").val()) == '')
	{
	show_notification(field_is_required);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=add_blog_category",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'blog_category': $("#new_blog_category").val()
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=blog_categories_dropdown",
				data : {

					'rh' : '{$request_hash}',
					'blog_category': $("#new_blog_category").val()
					},
				dataType : 'json',
				success : function(response) {
					$("#select_blog_categories").html();
					$("#select_blog_categories").html(response.select);
					$("#new_blog_category").val();
					$("#create_new_blog_category").hide();

					$.ajax({
						type : "POST",
						url : "index.php?route=users_content&action=blog_categories_dropdown",
						data : {

							'rh' : '{$request_hash}',
							'blog_category': $("#new_blog_category").val()
							},
						dataType : 'json',
						success : function(response) {

							$("#create_new_blog_category").hide();
							$("#blogs").html('');
							hide_loading();

						}
					});

					hide_loading();

				}
			});

		}
	});
}

function add_new_blog()
{
	$("#edit_blog").hide();
	$("#edit_blog_title").val('');
	$("#edit_blog_text").val('');
	$("#blog_title").val();
	$("#blog_text").val();
	$("#add_blog").show();
	$('#blog_text').wysiwyg({dialog:"jqueryui"});
}

function add_blog_text()
{

	show_loading();
	if($.trim($("#blog_title").val()) == '' || $.trim($("#blog_text").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}

	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=add_blog",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'blog_title':$("#blog_title").val(),
				'blog_text':$("#blog_text").val(),
				'category_id':$("#select_blog_categories").val()
		},
		success : function(response) {
			show_notification(response.status);
			$("#blog_title").val('');
			$("#blog_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=user_blogs",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'blog_category': $("#select_blog_categories").val()
				},
				success : function(response) {



							$("#blogs").html('');
							 $("#blogs").html(response);

		$("#add_blog").hide();
		$("#edit_blog").hide();
		$("#edit_blog_title").val('');
		$("#edit_blog_text").val('');
		$("#blog_title").val();
		$("#blog_text").val();
							hide_loading();

						}
					});


		}
	});

}


function change_blog_category(dropdown)
{
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=user_blogs",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'blog_category': $("#select_blog_categories").val()
		},
		success : function(response) {



					$("#blogs").html('');
					 $("#blogs").html(response);

$("#add_blog").hide();
$("#edit_blog").hide();
$("#edit_blog_title").val('');
$("#edit_blog_text").val('');
$("#blog_title").val();
$("#blog_text").val();
					hide_loading();

				}
			});

		}

function edit_blog(blog_id)
{
	$("#edit_blog_title").val('');
	$("#edit_blog_text").val('');
	$("#blog_title").val('');
	$("#blog_text").val('');
	$("#add_blog").hide();
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=get_blog",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'blog_id': blog_id
		},
		dataType : 'json',
		success : function(response) {


					//$("#blogs").html('');
					 $("#edit_blog_title").val(response.title);
					 $("#edit_blog_text").val(response.text);
					 $("#blog_id").html('');
					 $("#blog_id").html(response.id);
					//	$("#manage_blogs").dialog( )
						$("#edit_blog").show();
						$('#edit_blog_text').wysiwyg({dialog:"jqueryui"});
					hide_loading();

				}
			});

}

function edit_blog_text()
{

	show_loading();


	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=edit_blog",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'blog_title':$("#edit_blog_title").val(),
				'blog_text':$("#edit_blog_text").val(),
				'blog_id':$("#blog_id").html()
		},
		success : function(response) {
			show_notification(response.status);

			$("#blog_title").val('');
			$("#blog_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=user_blogs",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'blog_category': $("#select_blog_categories").val()
				},
				success : function(response) {



							$("#blogs").html('');
							 $("#blogs").html(response);

		$("#add_blog").hide();
		$("#edit_blog").hide();
		$("#edit_blog_title").val('');
		$("#edit_blog_text").val('');
		$("#blog_title").val();
		$("#blog_text").val();
							hide_loading();

						}
					});


		}
	});

}
</script>
{/literal}
