<h3>
	<a href="#"> {$languages->comments_title}</a>
</h3>
<div>
	<div id="comments_group_picture_details" class="comments_group">
		{include file="$tpl_dir/pages/groups/comments.tpl"}</div>
	<br />
	<textarea name="group_picture_comment" id="group_picture_comment"
		class="comments_textarea"></textarea>
	<input type="button" name="submit"
		onclick="add_group_picture_comment()" value="Submit"
		class="ui-widget-header input">

</div>
</div>
{literal}
<script type="text/javascript">
function add_group_picture_comment()
{
	show_loading();
	if($.trim($("#group_picture_comment").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_group_picture_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': '{/literal}{$p_id}{literal}',
				'comment': $("#group_picture_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			$('#group_picture_comment').wysiwyg('clear');

			$.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=get_group_picture_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': '{/literal}{$p_id}{literal}'
					},
				success : function(response) {
					$("#comments_group_picture_details").html(response);


					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}
