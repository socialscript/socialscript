<div id="add_group_event" class="hidden" style="width: 500px">
	{$languages->title}: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
		type="text" name="event_title" id="group_event_title"
		class="  input_text_big"><br />
	{$languages->date}: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
		type="text" name="event_date" id="group_event_date"
		class="datepicker"><br />
	{$languages->location}: <input type="text" name="event_location"
		id="group_event_location"
		class="  input_text_big"><br />
	<textarea id="group_event_text" style="width: 450px; height: 200px"
		class=" "></textarea>

	<input type="button" value="Submit"
		onclick="add_group_event_text('{$group->id}')"
		class=" ">
</div>

<div id="edit_group_event" class="hidden" style="width: 500px">
<input type="hidden" name="group_event_id" id="group_event_id" value="">
	{$languages->title}: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
		type="text" name="edit_event_title" id="edit_group_event_title_2"
		class="  input_text_big"><br />
	{$languages->date}: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
		type="text" name="event_date" id="edit_group_event_date_2"
		class="  datepicker"><br />
	{$languages->location}: <input type="text" name="event_location"
		id="edit_group_event_location_2"
		class=" input_text_big"><br />
	<textarea id="edit_group_event_text_2"
		style="width: 450px; height: 200px" class=" "></textarea>

	<input type="button" value="Submit"
		onclick="edit_group_event_text('{$group->id}')"
		class="btn">
</div>
<div class="floatleft group_left">
	<div id="add_new_group_event" onclick="add_new_group_event()"  class="btn btn-warning">{$languages->add_new_event}</div>
	<br />
	<div id="group_events">{include
		file="$tpl_dir/pages/groups/events.tpl"}</div>
</div>
<div class="floatleft group_middle">
	<div id="group_details_events_left_inner">
		<div id="groups_events_comments"></div>
	</div>
</div>

<div class="floatleft group_right">
	<div id="group_details_events_right_inner">
		<h3>
			<a href="#">
				<div id="edit_group_event_title"></div>
			</a>
		</h3>
		<div>
			<div id="edit_group_event_text"></div>
			<br />
			<div id="edit_group_event_location"></div>
			<br />
			<div id="edit_group_event_date"></div>
		</div>
	</div>
</div>


<div class="clear"></div>
{literal}
<script type="text/javascript">


function add_new_group_event()
{
	$("#group_event_title").val('');
	$("#group_event_text").val('');

	$("#add_group_event").dialog( {title:'Add new event',width:'500',height:'400',modal:true,resizable:false,show: { effect: 'fade'},zIndex:'1000',hide: { effect: 'fade'}} )
	//$("#add_group_event").show();
	tiny_mce();
}

function add_group_event_text(group_id)
{

	show_loading();
	if($.trim($("#group_event_title").val()) == '' || $.trim($("#group_event_text").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_group_event",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
			'group_event_title':$("#group_event_title").val(),
			'group_event_text':$("#group_event_text").val(),
			'group_event_date':$("#group_event_date").val(),
			'group_event_location':$("#group_event_location").val(),
				'group_id':group_id
		},
		 dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			$("#add_group_event").dialog('close');

			$("#group_event_title").val('');
			$("#group_event_text").val('');
			$("#group_event_date").val('');
			$("#group_event_location").val('');
			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=group_events",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'group_id': group_id
				},
				success : function(response) {

					$("#add_group_event").dialog('close');

							$("#group_events").html('');
							 $("#group_events").html(response);

		$("#add_group_event").hide();
		$("#edit_group_event").hide();
		$("#edit_group_event_title").val('');
		$("#edit_group_event_text").val('');

							hide_loading();

						}
					});


		}
	});

}



function edit_group_event(id)
{
	$("#edit_group_event_title_2").val('');
	$("#edit_group_event_date_2").val('');
	$("#edit_group_event_location_2").val('');

show_loading();
$.ajax({
	type : "POST",
	url : 'index.php?route=users_interaction&action=get_group_event',
	data : {

			'event_id':id,
			'rh':'{/literal}{$request_hash}{literal}',
	},
	 dataType : 'json',
	success : function(response) {
		$("#group_event_id").val(response.id);
		$("#edit_group_event_title_2").val(response.title);
		$("#edit_group_event_date_2").val(response.event_date);
		$("#edit_group_event_location_2").val(response.location);
		$("#edit_group_event_text_2").val(response.text);

		$("#edit_group_event").dialog(   {
			open : function() {

			tiny_mce();
				},
			modal:true,title:'{/literal}{$languages->edit}{literal}',width:'500',height:'380',resizable:false,show: { effect: 'fade'},zIndex:'4000',hide: { effect: 'fade'}} )

hide_loading();
}});
}

function edit_group_event_text(group_id)
{

	show_loading();
	//alert($("#edit_group_event_title_2").val());
	//if($.trim($("#edit_group_event_title_2").val()) == '' || $.trim($("#edit_group_event_location_2").val()) == '')
	//{
	//show_notification(all_fields_required);
	//hide_loading();
	//return false;
	//}

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=edit_group_event",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
			'group_event_id':$("#group_event_id").val(),
			'group_event_title':$("#edit_group_event_title_2").val(),
			'group_event_text':$("#edit_group_event_text_2").val(),
			'group_event_date':$("#edit_group_event_date_2").val(),
			'group_event_location':$("#edit_group_event_location_2").val(),
				'group_id':group_id
		},
		 dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			$("#edit_group_event").dialog('close');

			$("#edit_group_event_title_2").val('');
			$("#edit_group_event_text_2").val('');
			$("#edit_group_event_date_2").val('');
			$("#edit_group_event_location_2").val('');
			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=group_events",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'group_id': group_id
				},
				success : function(response) {

					$("#edit_group_event").dialog('close');

							$("#group_events").html('');
							 $("#group_events").html(response);

		$("#add_group_event").hide();
		$("#edit_group_event").hide();

							hide_loading();

						}
					});


		}
	});

}




function view_group_event(group_event_id)
{
	$("#edit_group_event_title").val('');
	$("#edit_group_event_text").val('');
	$("#edit_group_event_location").val('');
	$("#edit_group_event_date").val('');
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=get_group_event",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'event_id': group_event_id
		},
		dataType : 'json',
		success : function(response) {


					 $("#edit_group_event_title").html(response.title);
					 $("#edit_group_event_text").html(response.text);
					 $("#edit_group_event_location").html(response.location);
					 $("#edit_group_event_date").html(response.event_date);
					 $("#group_details_events_right_inner").accordion({
							header : "h3",
							 animated: 'bounceslide',
							 fillSpace: true
						});
					 $.ajax({
							type : "POST",
							url : "index.php?route=users_interaction&action=view_group_event_comments",
							data : {
								'id' : group_event_id,
								'rh' : '{/literal}{$request_hash}{literal}'
							},

							success : function(response) {
								$("#groups_events_comments").html(response);
								 $("#groups_events_comments").accordion({
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
			});

}

</script>
{/literal}
