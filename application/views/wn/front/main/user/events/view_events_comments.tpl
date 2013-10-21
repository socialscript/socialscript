 {include file="$tpl_dir/user/events/events_comments.tpl"} {literal}
<script type="text/javascript">
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
				'id': '{/literal}{$event_id}{literal}',
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
					'id': '{/literal}{$event_id}{literal}'
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
