
<div id="details_right">
	<div>
		<h3>
			<a href="#">{$trade->title}</a>
		</h3>

		<div>{$trade->text}</div>
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
				file="$tpl_dir/pages/trade/questions.tpl"}</div>

			<br />

			<textarea name="trade_question" id="trade_question"
				class="comments_textarea"></textarea>
			<input type="button" name="submit"
				onclick="add_trade_question({$trade->id})" value="Submit"
				class="ui-widget-header input">
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
$('#trade_question').wysiwyg({dialog:"jqueryui"});
$(".wysiwyg").addClass('comments_textarea_big');
$("#trade_question-wysiwyg-iframe").addClass('comments_textarea_big');
});

function add_trade_question(trade_id)
{
	show_loading();
	if($.trim($("#trade_question").val()) == '')
	{
	show_notification(comment_empty);
	hide_loading();
	return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=add_trade_question",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'id': trade_id,
				'question': $("#trade_question").val(),
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);

			$('#trade_question').wysiwyg('clear');
			$.ajax({
				type : "POST",
				url : "index.php?route=users&action=get_trade_questions",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
					'id': trade_id
					},
				success : function(response) {
					$("#comments_list_details").html('');
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
