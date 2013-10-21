<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#groups_comments" href="#collapseGroupVideo"> {$languages->comments_title}</a>
	</div>
    <div id="collapseGroupVideo" class="accordion-body collapse in">
      <div class="accordion-inner">
      
      
	<div id="comments_group_video_details" class="comments_group">{include
		file="$tpl_dir/pages/groups/comments.tpl"}</div>
	<br />
	<textarea name="group_video_comment" id="group_video_comment"
		class="comments_textarea"></textarea>
	<input type="button" name="submit" onclick="add_group_video_comment()"
		value="Submit" class="ui-widget-header input">

</div>
</div>
</div>
{literal}
<script type="text/javascript">
function add_group_video_comment()
{
	show_loading();
	if($.trim($("#group_video_comment").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_group_video_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': '{/literal}{$p_id}{literal}',
				'comment': $("#group_video_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=get_group_video_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': '{/literal}{$p_id}{literal}'
					},
				success : function(response) {
					$("#comments_group_video_details").html(response);


					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}
