
			<div id="add_trade" style="width:450px">
	{$languages->title}: <input type="text" name="trade_title" id="trade_title" class="ui-widget-header  input">
	<textarea id="trade_text" style="width: 400px; height: 250px" class="ui-widget-header  input"></textarea>
	<input type="button" value="Submit" onclick="add_trade_text()">
</div>

{literal}
<script type="text/javascript">
$(function ()
		{
$('#trade_text').wysiwyg({dialog:"jqueryui"});
});
</script>
{/literal}