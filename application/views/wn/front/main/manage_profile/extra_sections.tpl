
<div class="floatleft manage_extra_sections_left">


	<div id="extra_sections">{include file="$tpl_dir/manage_profile/extra_sections_inner.tpl"}</div>

</div>




<div id="edit_extra_section" class="floatleft hidden manage_extra_sections_right">
	<div id="extra_section_id" class="hidden"></div>
	{$languages->title}: <input type="text" name="edit_extra_section_title"
		id="edit_extra_section_title" class="ui-widget-header extra_section_title  input">
	<textarea id="edit_extra_section_text" class="ui-widget-header  extra_section_textarea"></textarea>
	<input type="button" value="Submit" onclick="edit_extra_section_text()"
		class="btn">
</div>
<div class="clear"></div>
{literal}
<script type="text/javascript">



function edit_extra_section(extra_section_id)
{
	$("#edit_extra_section_title").val('');
	$("#edit_extra_section_text").val('');
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=get_extra_section",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'extra_section_id': extra_section_id,
				'type' : '{/literal}{$type}{literal}'
		},
		dataType : 'json',
		success : function(response) {


					//$("#extra_sections").html('');
					 $("#edit_extra_section_title").val(response.title);
					 $("#edit_extra_section_text").val(response.text);
					 $("#extra_section_id").html('');
					 $("#extra_section_id").html(response.id);
					//	$("#manage_extra_sections").dialog( )
						$("#edit_extra_section").show();
						tiny_mce();
					hide_loading();

				}
			});

}

function edit_extra_section_text()
{

	show_loading();


	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=edit_extra_section",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'extra_section_title':$("#edit_extra_section_title").val(),
				'extra_section_text':$("#edit_extra_section_text").val(),
				'extra_section_id':$("#extra_section_id").html(),
				'type' : '{/literal}{$type}{literal}'
		},
		success : function(response) {
			show_notification(response.status);

			$("#extra_section_title").val('');
			$("#extra_section_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=user_extra_sections",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'type': '{/literal}{$type}{literal}'
				},
				success : function(response) {



							$("#extra_sections").html('');
							 $("#extra_sections").html(response);

		$("#add_extra_section").hide();
		$("#edit_extra_section").hide();
		$("#edit_extra_section_title").val('');
		$("#edit_extra_section_text").val('');
		$("#extra_section_title").val();
		$("#extra_section_text").val();
							hide_loading();

						}
					});


		}
	});

}
</script>
{/literal}
