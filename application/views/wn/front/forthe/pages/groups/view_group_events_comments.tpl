<div id="group_details_events_right_inner">
	<h3>
		<a href="#"> {$languages->comments_title}</a>
	</h3>
	<div>
		<div id="comments_group_event_details" class="comments_group">
			{include file="$tpl_dir/pages/groups/comments.tpl"}</div>
		<br />
		<textarea name="group_event_comment" id="group_event_comment"
			class="comments_textarea"></textarea>
		<input type="button" name="submit" onclick="add_group_event_comment()"
			value="Submit" class="ui-widget-header input">

	</div>
</div>
{literal}
<script type="text/javascript">
function add_group_event_comment()
{
	show_loading();
	if($.trim($("#group_event_comment").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_group_event_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': '{/literal}{$group_event_id}{literal}',
				'comment': $("#group_event_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			$('#group_event_comment').wysiwyg('clear');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=get_group_event_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': '{/literal}{$group_event_id}{literal}'
					},
				success : function(response) {
					$("#comments_group_event_details").html(response);


					hide_loading();

				}
			});

		}
	});
}
</script>
{/literal}
