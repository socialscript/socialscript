<div id="comments">{include
	file="$tpl_dir/user/groups/groups_comments.tpl"}</div>

{literal}
<script type="text/javascript">
function add_group_comment()
{
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_group_comment",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': '{/literal}{$group_id}{literal}',
				'comment': $("#group_comment").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=get_group_comments",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': '{/literal}{$group_id}{literal}'
					},
				success : function(response) {
					$("#groups_comments").html(response);


					hide_loading();

				}
			});

			hide_loading();
		}
	});
}
</script>
{/literal}
