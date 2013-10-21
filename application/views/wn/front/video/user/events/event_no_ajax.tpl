<div id="details_right">
<div>
	<h3>
					<a href="#">{$event->title}</a>
				</h3>
				<div>


{$event->text}
</div>
</div>
</div>
<div class="separator_vertical clear">&nbsp;</div>
<div id="details_left" style="margin-top:30px">
<div>
<h3 >
		<a href="#">{$languages->comments_title}</a>
		</h3>
		<div>
		<div id="comments_list_details">
		{include file="$tpl_dir/user/events/comments.tpl"}
		</div>
<br />
<textarea name="event_comment" id="event_comment" class="comments_textarea"></textarea>
<input type="button" name="submit" onclick="add_event_comment()" value="Submit" class="ui-widget-header input">

</div>
</div>
</div>

{literal}


<script type="text/javascript">
$(function() {
$("#details_right").accordion({
	header : "h3",
	 fillSpace: true
});

$("#details_left").accordion({
	header : "h3",
	 fillSpace: true
});
$('#event_comment').wysiwyg({dialog:"jqueryui"});
$(".wysiwyg").addClass('comments_textarea_big');
$("#event_comment-wysiwyg-iframe").addClass('comments_textarea_big');
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

					$('#event_comment').wysiwyg('clear');
					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}