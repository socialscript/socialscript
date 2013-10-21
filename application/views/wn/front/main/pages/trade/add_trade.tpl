
<div id="add_trade" style="width: 450px">
	{$languages->title}: <input type="text" name="trade_title"
		id="trade_title" class="ui-widget-header  input input_text_big">
	<textarea id="trade_text" style="width: 400px; height: 250px"
		class="ui-widget-header"></textarea>
	<input type="button" value="Submit" onclick="add_trade_text()"
		class="ui-widget-header input">
</div>

{literal}
<script type="text/javascript">
$(function ()
		{
tiny_mce();
});
</script>
{/literal}
