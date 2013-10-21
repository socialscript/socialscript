<div id="details_right">
	<div>
		<h3>
			<a href="#">{$blog->title}</a>
		</h3>
		<div>{$blog->text}</div>
	</div>
</div>
<div class="separator_vertical clear">&nbsp;</div>
<div id="details_left" style="margin-top: 30px">
	<div>
		<h3>
			<a href="#">{$languages->comments_title}</a>
		</h3>
		<div>
			<div id="comments_list_details">{include
				file="$tpl_dir/user/blogs/comments.tpl"}</div>
			<br />
			<textarea name="blog_comment" id="blog_comment"
				class="comments_textarea"></textarea>
			<input type="button" name="submit" onclick="add_blog_comment()"
				value="Submit" class="ui-widget-header input">

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
$('#blog_comment').wysiwyg({dialog:"jqueryui"});
$(".wysiwyg").addClass('comments_textarea_big');
$("#blog_comment-wysiwyg-iframe").addClass('comments_textarea_big');
});

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
				'id': '{/literal}{$blog->id}{literal}',
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
					'id': '{/literal}{$blog->id}{literal}'
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
