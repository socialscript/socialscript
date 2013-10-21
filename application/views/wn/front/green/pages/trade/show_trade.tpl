<div id="show_trade">
	<div>
		<h3>
			<a href="#">{$languages->trade}</a>
		</h3>
		<div class="middle_min_height">

			<div id="add_new_trade">
				<input type="button" class="ui-widget-header  input"
					onclick="add_new_trade()" value="Add trade">
				<div id="add_trade"></div>
			</div>
			<div class="clear"></div>

			<div id="trade">{include file="$tpl_dir/pages/trade/trade.tpl"}</div>
			<div id="trade_details"></div>
		</div>


		<div id="edit_trade" class="floatleft"
			style="margin-left: 50px; width: 300px">
			<div id="trade_id" class="hidden"></div>
			<div id="edit_trade_title"></div>
			<div id="edit_trade_text"></div>
		</div>
		<div class="clear"></div>
	</div>

</div>
</div>
{literal}
<script type="text/javascript">


function add_new_trade()
{

	show_loading();
	$("#add_trade").html('');
    $("#add_trade").dialog({
        modal: true,
        open: function ()
        {
            $(this).load('index.php?route=users&action=add_trade_form');
            hide_loading();
        },
        height: 400,
        width: 520,
        title: 'Add trade',
        resizable:false,show: { effect: 'fade'},zIndex:'3000',hide: { effect: 'fade'}
    });



}

function add_trade_text()
{

	show_loading();
	if($.trim($("#trade_title").val()) == '' || $.trim($("#trade_text").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}

	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=add_trade",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'trade_title':$("#trade_title").val(),
				'trade_text':$("#trade_text").val()

		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			$("#trade_title").val('');
			$("#trade_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users&action=get_latest_trade",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',

				},
				success : function(response) {

					$("#add_trade").dialog('close');

							$("#latest_trade").html('');
							 $("#latest_trade").html(response);

		$("#add_trade").dialog('close');

							hide_loading();

						}
					});


		}
	});

}




function edit_trade_text()
{

	show_loading();


	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=edit_trade",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'trade_title':$("#edit_trade_title").val(),
				'trade_text':$("#edit_trade_text").val(),
				'trade_id':$("#trade_id").html()
		},
		success : function(response) {
			show_notification(response.status);

			$("#trade_title").val('');
			$("#trade_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users&action=user_trades",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'trade_category': $("#select_trade_categories").val()
				},
				success : function(response) {



							$("#trades").html('');
							 $("#trades").html(response);

		$("#add_trade").hide();
		$("#edit_trade").hide();
		$("#edit_trade_title").val('');
		$("#edit_trade_text").val('');
		$("#trade_title").val();
		$("#trade_text").val();
							hide_loading();

						}
					});


		}
	});

}

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
