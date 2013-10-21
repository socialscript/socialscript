
<div id="add_extra_section" style="width: 450px">
	{$languages->title}: <input type="text" name="message_title"
		id="message_title" class="ui-widget-header  input input_text_big">
	<textarea id="message_text" style="width: 400px; height: 250px"
		class="ui-widget-header  input"></textarea>
	<input type="button" value="Submit" onclick="send_message_2('{$id}')"
		class="ui-widget-header input">
</div>
{literal}
<script type="text/javascript">
tiny_mce();
</script>
{/literal}
