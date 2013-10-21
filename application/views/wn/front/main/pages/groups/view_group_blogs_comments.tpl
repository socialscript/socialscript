<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#groups_comments" href="#collapseGroupComments">{$languages->comments_title}</a>
	</div>
    <div id="collapseGroupComments" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner"> 
  
	<div id="comments_group_details" class="comments_group">{include
		file="$tpl_dir/pages/groups/comments.tpl"}</div>

	<textarea name="group_blog_comment" id="group_blog_comment"
		class="comments_textarea"></textarea>
	<input type="button" name="submit" onclick="add_group_blog_comment()"
		value="Submit" class="btn">

</div>
</div>
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
