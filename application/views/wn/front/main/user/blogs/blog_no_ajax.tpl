<div id="details_right"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_right" href="#collapseEvents">{$blog->title}</a>
		</div>
    <div id="collapseEvents" class="accordion-body collapse in" style="min-height:480px;">
      <div class="accordion-inner">
		<div>{$blog->text}</div>
	</div>
</div>
</div>
</div>
<div class="separator_vertical clear">&nbsp;</div>
	<div id="details_left"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_left" href="#collapseEventsDetails">{$languages->comments_title}</a>
		</div>
		
		 <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:350px;">
      <div class="accordion-inner">
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
	</div>
</div>

{literal}


<script type="text/javascript">
$(function() {
$("#details_right").collapse();

$("#details_left").collapse();
tiny_mce();
$("#blog_comment").addClass('comments_textarea_big');
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

					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}
