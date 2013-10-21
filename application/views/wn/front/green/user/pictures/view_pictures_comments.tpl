<div class="hidden" id="p_id">{$p_id}</div>
<div id="comments">{include
	file="$tpl_dir/user/pictures/pictures_comments.tpl"}</div>
<br />
<textarea name="picture_comment" id="picture_comment"></textarea>
<input type="button" name="submit" onclick="add_picture_comment()"
	value="Submit">
{literal}
<script type="text/javascript">
function add_picture_comment()
{
	show_loading();
	if($.trim($("#picture_comment").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_picture_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'p_id': $("#p_id").text(),
				'comment': $("#picture_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=get_picture_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'p_id': $("#p_id").text()
					},
				success : function(response) {
					$("#comments").html(response);


					hide_loading();

				}
			});
			$("#pictures").html('You have no pictures in this gallery');
			hide_loading();
		}
	});
}
</script>
{/literal}
