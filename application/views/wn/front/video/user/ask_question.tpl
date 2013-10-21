 			<div id="add_question" style="width:450px">
	<textarea id="ask_question_textarea" style="width: 400px; height: 250px" class="ui-widget-header  input"></textarea>
	<input type="button" value="Submit" onclick="ask_question_2('{$id}')" class="ui-widget-header input">
</div>

{literal}
<script type="text/javascript">
$('#ask_question_textarea').wysiwyg({dialog:"jqueryui"});
</script>
{/literal}