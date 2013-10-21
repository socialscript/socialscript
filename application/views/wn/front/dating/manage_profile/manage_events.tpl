
<div class="floatleft manage_events_left">

	<div id="events_categories" style="width: 150px">

		<div id="add_new_event" onclick="add_new_event()">{$languages->add_new_event}</div>
		<br />
		<div id="events">{include file="$tpl_dir/manage_profile/events.tpl"}</div>
	</div>
</div>



<div id="add_event" class="floatleft hidden manage_events_right">
	{$languages->title}: <input type="text" name="event_title"
		id="event_title" class="ui-widget-header event_title input"><br />
	{$languages->date}: <input type="text" name="event_date"
		id="event_date" class="ui-widget-header event_date input datepicker">&nbsp;&nbsp;&nbsp;&nbsp;
	{$languages->location}: <input type="text" name="event_location"
		id="event_location" class="ui-widget-header event_location  input"><br />
	<textarea id="event_text"
		class="ui-widget-header  event_textarea input"></textarea>

	<input type="button" value="Submit" class="ui-widget-header  input"
		onclick="add_event_text()">
</div>

<div id="edit_event" class="floatleft hidden manage_events_right">
	<div id="event_id" class="hidden"></div>
	{$languages->title}: <input type="text" name="edit_event_title"
		id="edit_event_title" class="ui-widget-header event_title input"><br />
	{$languages->date}: <input type="text" name="edit_event_date"
		id="edit_event_date"
		class="ui-widget-header event_date input datepicker">&nbsp;&nbsp;&nbsp;&nbsp;
	{$languages->location}: <input type="text" name="edit_event_location"
		id="edit_event_location"
		class="ui-widget-header  event_location input">
	<textarea id="edit_event_text"
		class="ui-widget-header event_textarea input"></textarea>
	<input type="button" value="Submit" onclick="edit_event_text()"
		class="ui-widget-header  input">
</div>
<div class="clear"></div>
{literal}
<script type="text/javascript">



function add_new_event()
{
	$("#edit_event").hide();
	$("#event_title").val('');
	$("#event_text").val('');

	$("#add_event").show();
	$('#event_text').wysiwyg({dialog:"jqueryui"});
	$('.datepicker').datepicker({appendText: "(yyyy-mm-dd)",dateFormat : "yy-mm-dd"}
		);
}

function add_event_text()
{

	show_loading();
	if($.trim($("#event_title").val()) == '' || $.trim($("#event_text").val()) == '' || $.trim($("#event_date").val()) == '' || $.trim($("#event_location").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}

	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=add_event",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'event_title':$("#event_title").val(),
				'event_text':$("#event_text").val(),
				'event_date':$("#event_date").val(),
				'event_location':$("#event_location").val()
		},
		success : function(response) {
			show_notification(response.status);
			$("#event_title").val('');
			$("#event_text").val('');
			$("#event_date").val('');
			$("#event_location").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=user_events",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'event_category': $("#select_event_categories").val()
				},
				success : function(response) {



							$("#events").html('');
							 $("#events").html(response);

		$("#add_event").hide();
		$("#edit_event").hide();
		$("#edit_event_title").val('');
		$("#edit_event_text").val('');
		$("#event_title").val();
		$("#event_text").val();
							hide_loading();

						}
					});


		}
	});

}


function change_event_category(dropdown)
{
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=user_events",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'event_category': $("#select_event_categories").val()
		},
		success : function(response) {



					$("#events").html('');
					 $("#events").html(response);

$("#add_event").hide();
$("#edit_event").hide();
$("#edit_event_title").val('');
$("#edit_event_text").val('');
$("#event_title").val();
$("#event_text").val();
					hide_loading();

				}
			});

		}

function edit_event(event_id)
{
	$("#add_event").hide();
	$("#edit_event_title").val('');
	$("#edit_event_text").val('');
	$("#edit_event_date").val('');
	$("#edit_event_location").val('');
	$("#edit_event").show();

	$('.datepicker').datepicker({appendText: "(yyyy-mm-dd)",dateFormat : "yy-mm-dd"}
		);
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=get_event",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'event_id': event_id
		},
		dataType : 'json',
		success : function(response) {


					//$("#events").html('');
					 $("#edit_event_title").val(response.title);
					 $("#edit_event_text").val(response.text);
					 $("#edit_event_date").val(response.event_date);
					 $("#edit_event_location").val(response.location);
					 $("#event_id").html('');
					 $("#event_id").html(response.id);
						$("#edit_event").show();
						$('#edit_event_text').wysiwyg({dialog:"jqueryui"});
					hide_loading();

				}
			});

}

function edit_event_text()
{

	show_loading();
	if($.trim($("#edit_event_title").val()) == '' || $.trim($("#edit_event_text").val()) == '' || $.trim($("#edit_event_date").val()) == '' || $.trim($("#edit_event_location").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}

	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=edit_event",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'event_title':$("#edit_event_title").val(),
				'event_text':$("#edit_event_text").val(),
				'event_date':$("#edit_event_date").val(),
				'event_location':$("#edit_event_location").val(),
				'event_id':$("#event_id").html()
		},
		success : function(response) {
			show_notification(response.status);

			$("#edit_event_title").val('');
			$("#edit_event_text").val('');
			$("#edit_event_date").val('');
			$("#edit_event_location").val('');
			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=user_events",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'event_category': $("#select_event_categories").val()
				},
				success : function(response) {



							$("#events").html('');
							 $("#events").html(response);

		$("#add_event").hide();
		$("#edit_event").hide();

		$("#event_title").val('');
		$("#event_text").val('');
		$("#event_date").val('');
		$("#event_location").val('');
							hide_loading();

						}
					});


		}
	});

}
</script>
{/literal}
