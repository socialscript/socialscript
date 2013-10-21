<div class="ui-widget-header left_panel">{$register_form_text}</div>
<div class="center_panel">
	<script type="text/javascript">
var validation = '{foreach from=$validators item=validator}<option value="{$validator}">{$validator}</option>{/foreach}';
var years_dropdown = '<select name="year">{foreach from=$years_dropdown item=validator}<option value="{$validator}">{$validator}</option>{/foreach}</select>';
var months_dropdown = '<select name="month">{foreach from=$months_dropdown item=validator}<option value="{$validator}">{$validator}</option>{/foreach}</select>';
var days_dropdown = '<select name="day">{foreach from=$days_dropdown item=validator}<option value="{$validator}">{$validator}</option>{/foreach}</select>';
var form_fields_nr = '{$form_fields_nr}';
var validators_ajax = '{foreach from=$form_validators_js_ajax item=validator}<option value="{$validator}">{$validator}</option>{/foreach}';
var page='register';

function add_text_field(){

	$("#fields").append('Label: <input type="text" name="label"><br />Required: <input type="checkbox" name="required" value="1"><br />Validation: <select name="validation">'+validation+'</select>');
}
</script>
	<script
		src="{$settings->site_url}/resources/js/formbuilder/formbuilder.js"></script>
	<link
		href="{$settings->site_url}/resources/js/formbuilder/jquery.formbuilder.css"
		media="screen" rel="stylesheet" />

	<script>
			$(function(){
				$('#form_builder').formbuilder({
						saveUrl : "index_admin.php?route=forms&action=save_register"
				});

			});


		</script>


	<div>

		<ul id="frmb-0" class="frmb frmb-0" style="width: 830px">


			<form name="register">
				{counter start=1 print=0 assign=i} {foreach from=$form_fields
				item=form_field} {include file="$tpl_dir/form_fields/form.tpl"}
				{counter} {/foreach}
				<div id="form_builder"></div>
				<div id="predefined"></div>

			</form>
		</ul>
	</div>
</div>
<div id="response" class="hidden">Data was saved</div>
