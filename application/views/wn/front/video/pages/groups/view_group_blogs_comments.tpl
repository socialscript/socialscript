<h3>
			<a href="#"> {$languages->comments_title}</a>
		</h3>
		<div id="comments_group_details">
{include file="$tpl_dir/pages/groups/comments.tpl"}
</div>
<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">

<textarea name="group_blog_comment" id="group_blog_comment" class="comments_textarea"></textarea>
<input type="button" name="submit" onclick="add_group_blog_comment()" value="Submit">

</div>
{literal}
<script type="text/javascript">
function add_group_blog_comment()
{
	show_loading();
	if($.trim($("#group_blog_comment").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_group_blog_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': '{/literal}{$blog_id}{literal}',
				'comment': $("#group_blog_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=get_group_blog_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': '{/literal}{$blog_id}{literal}'
					},
				success : function(response) {
					$("#comments_group_details").html(response);


					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}