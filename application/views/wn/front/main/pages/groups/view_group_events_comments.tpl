<div class=" accordion" id="group_details_events_right_inner" >
<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#groups_comments" href="#collapseGroupEvents"> {$languages->comments_title}</a>
	</div>
    <div id="collapseGroupEvents" class="accordion-body collapse in">
      <div class="accordion-inner">
      
  
		<div id="comments_group_event_details" class="comments_group">
			{include file="$tpl_dir/pages/groups/comments.tpl"}</div>
		<br />
		<textarea name="group_event_comment" id="group_event_comment"
			class="comments_textarea"></textarea>
		<input type="button" name="submit" onclick="add_group_event_comment()"
			value="Submit" class="btn">

	</div>
</div>
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
