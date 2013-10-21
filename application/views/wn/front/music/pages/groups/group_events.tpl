<div id="add_group_event" class="hidden" style="width: 500px">
	Title: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"
		name="event_title" id="group_event_title"
		class="ui-widget-header  input input_text_big"><br /> Date:
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"
		name="event_date" id="group_event_date"
		class="ui-widget-header  input datepicker"><br /> Location: <input
		type="text" name="event_location" id="group_event_location"
		class="ui-widget-header  input input_text_big"><br />
	<textarea id="group_event_text" style="width: 450px; height: 200px"
		class="ui-widget-header  input"></textarea>

	<input type="button" value="Submit"
		onclick="add_group_event_text('{$group->id}')"
		class="ui-widget-header input">
</div>
<div class="floatleft group_left">
	<div id="add_new_group_event" onclick="add_new_group_event()">{$languages->add_new_event}</div>
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
		<div id="group_event_id" class="hidden"></div>
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
	$('#group_event_text').wysiwyg({dialog:"jqueryui"});
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
					 $("#edit_group_event_date").html(response.date);
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
$('#group_event_comment').wysiwyg({dialog:"jqueryui"});
								hide_loading();
							}
						});


				}
			});

}

function edit_group_event_text()
{

	show_loading();


	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=edit_group_event",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'group_event_title':$("#edit_group_event_title").val(),
				'group_event_text':$("#edit_group_event_text").val(),
				'group_event_id':$("#group_event_id").html()
		},
		success : function(response) {
			show_notification(response.status);

			$("#group_event_title").val('');
			$("#group_event_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=user_group_events",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'group_event_category': $("#select_group_event_categories").val()
				},
				success : function(response) {



							$("#group_events").html('');
							 $("#group_events").html(response);

		$("#add_group_event").hide();
		$("#edit_group_event").hide();
		$("#edit_group_event_title").val('');
		$("#edit_group_event_text").val('');
		$("#group_event_title").val();
		$("#group_event_text").val();
							hide_loading();

						}
					});


		}
	});

}
</script>
{/literal}
