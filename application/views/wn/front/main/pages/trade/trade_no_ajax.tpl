
<div id="details_right"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_right" href="#collapseEventsDetails">{$trade->title}</a>
		</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
		<div>{$trade->text}</div>
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
		
		 <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
			<div id="comments_list_details">{include
				file="$tpl_dir/pages/trade/questions.tpl"}</div>

			<br />

			<textarea name="trade_question" id="trade_question"
				class="comments_textarea"></textarea>
			<input type="button" name="submit"
				onclick="add_trade_question({$trade->id})" value="Submit"
				class="btn">
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
$("#trade_question").addClass('comments_textarea_big');

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
