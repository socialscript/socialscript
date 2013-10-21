
<div   class="floatleft">

	<div id="groups_categories" style="width:150px">

	<div id="add_new_group" onclick="add_new_group()">{$languages->add_new_group}</div>
<br />
	<div id="groups">
{include file="$tpl_dir/manage_profile/groups.tpl"}
	</div>
</div>
</div>



<div id="add_group" class="floatleft hidden" style="margin-left:70px;width:800px">
{$languages->group_name}: <input type="text" name="group_name" id="group_name" class="ui-widget-header group_name input"><br />
{$languages->group_description}: <textarea id="group_description"  class="ui-widget-header group_description"></textarea><br />
{$languages->privacy}:
<input type="radio" name="group_privacy" id="group_privacy_1" class="ui-widget-header " value="1" checked="checked">{$languages->open_to_all}
<input type="radio" name="group_privacy" id="group_privacy_2" class="ui-widget-header " value="2">{$languages->show_in_search_but_closed_to_other_than_members}
<input type="radio" name="group_privacy" id="group_privacy_3" class="ui-widget-header " value="3">{$languages->open_only_to_members}
<br />
{$languages->location}: <input type="text" name="group_location" id="group_location" class="ui-widget-header group_location input"><br />

<input type="button" value="Submit" onclick="add_group_text()">
</div>

<div id="edit_group" class="floatleft" style="margin-left:70px;width:800px">
</div>
<div class="clear"></div>
{literal}
<script type="text/javascript">



function add_new_group()
{
	$("#edit_group").hide();
	$("#group_title").val('');
	$("#group_description").val('');
	$('#edit_group_description').wysiwyg('clear');
	$("#add_group").show();
	$('#group_description').wysiwyg({dialog:"jqueryui"});
}

function add_group_text()
{

	show_loading();
	if($.trim($("#group_name").val()) == '' || $.trim($("#group_description").val()) == '' || $.trim($("#group_location").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}
 if($("#group_privacy_1").is(':checked'))
{
	 privacy = 1;
}
 else if($("#group_privacy_2").is(':checked'))
 {
	 privacy = 2;
 }
 else if($("#group_privacy_3").is(':checked'))
 {
	 privacy = 3;
 }

	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=add_group",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'group_name':$("#group_name").val(),
				'group_description':$("#group_description").val(),
				'group_privacy':privacy,
				'group_location':$("#group_location").val(),
					},
					dataType:'json',
		success : function(response) {
			show_notification(response.status);
			$("#group_name").val('');
			$("#group_description").val('');
			$("#group_privacy_1").attr('checked','checked');
			$("#group_privacy_2").attr('checked','');
			$("#group_privacy_3").attr('checked','');
			$("#group_location").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=user_groups",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}'

				},
				success : function(response) {



							$("#groups").html('');
							 $("#groups").html(response);

		$("#add_group").hide();
		$("#edit_group").hide();
		hide_loading();

						}
					});


		}
	});

}




function edit_group(group_id)
{
	$("#add_group").hide();
	$("#group_name").val('');
	$("#group_description").val('');
	$("#edit_group").html('');
	$("#group_privacy_1").attr('checked','checked');
	$("#group_privacy_2").attr('checked','');
	$("#group_privacy_3").attr('checked','');
	$("#group_location").val('');
	//$("#edit_group").show();


	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=get_group",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'group_id': group_id
		},
		//dataType : 'json',
		success : function(response) {
			$("#edit_group").html(response);
						$("#edit_group").show();
						$('#edit_group_description').wysiwyg({dialog:"jqueryui"});
					hide_loading();

				}
			});

}

function edit_group_text()
{

	show_loading();
	if($.trim($("#edit_group_name").val()) == '' || $.trim($("#edit_group_description").val()) == '' || $.trim($("#edit_group_location").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}
	 if($("#edit_group_privacy_1").is(':checked'))
	 {
	 	 privacy = 1;
	 }
	  else if($("#edit_group_privacy_2").is(':checked'))
	  {
	 	 privacy = 2;
	  }
	  else if($("#edit_group_privacy_3").is(':checked'))
	  {
	 	 privacy = 3;
	  }


	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=edit_group",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
			'group_name':$("#edit_group_name").val(),
			'group_description':$("#edit_group_description").val(),
			'group_privacy':privacy,
			'group_location':$("#edit_group_location").val(),
				'group_id':$("#group_id").html()
		},
		dataType:'json',
		success : function(response) {
			show_notification(response.status);

			$("#edit_group_name").val();
			$("#edit_group_description").val();
			 $("#edit_group_privacy_1").attr('checked','checked');
			 $("#edit_group_privacy_2").attr('checked','');
			 $("#edit_group_privacy_3").attr('checked','');
			$("#edit_group_location").val();
			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=user_groups",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
				},
				success : function(response) {



							$("#groups").html('');
							 $("#groups").html(response);

		$("#add_group").hide();
		$("#edit_group").hide();

							hide_loading();

						}
					});


		}
	});

}
</script>
{/literal}
