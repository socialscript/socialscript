<div id="details_right"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_right" href="#collapseEvents">{$languages->events}</a>
		</div>
    <div id="collapseEvents" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
		<div>{$event->text}</div>
	</div>
</div>
</div>
</div>
<div class="separator_vertical clear">&nbsp;</div>
	<div id="details_left"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_left" href="#collapseEventsDetails">{$languages->comments_title}</a>
		</div>
		
		 <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
			<div id="comments_list_details">{include
				file="$tpl_dir/user/events/comments.tpl"}</div>
			<br />
			<textarea name="event_comment" id="event_comment"
				class="comments_textarea"></textarea>
			<input type="button" name="submit" onclick="add_event_comment()"
				value="Submit" class="btn">

		</div>
	</div>
</div>
</div>

{literal}


<script type="text/javascript">
$(function() {
$("#details_right").collapse();

$("#details_left").collapse();
tiny_mce();
$("#event_comment").addClass('comments_textarea_big');
});
function add_event_comment()
{
	show_loading();
	if($.trim($("#event_comment").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_event_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': '{/literal}{$event->id}{literal}',
				'comment': $("#event_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=get_event_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': '{/literal}{$event->id}{literal}'
					},
				success : function(response) {
					$("#comments_list_details").html(response);

					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}
