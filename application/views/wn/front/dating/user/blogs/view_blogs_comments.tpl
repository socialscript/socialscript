<div class="hidden" id="p_id">{$p_id}</div>
<div id="comments">{include
	file="$tpl_dir/user/blogs/blogs_comments.tpl"}</div>

{literal}
<script type="text/javascript">
function add_blog_comment()
{
	show_loading();
	if($.trim($("#blog_comment").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_blog_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': '{/literal}{$blog_id}{literal}',
				'comment': $("#blog_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=get_blog_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': '{/literal}{$blog_id}{literal}'
					},
				success : function(response) {
					$("#comments_list_details").html(response);

					$('#blog_comment').wysiwyg('clear');
					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}
