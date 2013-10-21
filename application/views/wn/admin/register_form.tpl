<div style="width: 100%; height: 100%; overflow-y: scroll">
	<link type="text/css"
		href="{$settings->site_url}/resources/js/formbuilder/jquery.formbuilder.css"
		rel="stylesheet" />

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
var i = 0;
function add_new_field(){

	switch($("#add_new_field").val())
	{
	case '0':
		break;
	case 'text_field' :
	$("#fields").prepend('<div id="fields_'+i+'" class="form_box ui-widget-header"><b>Text Field</b><br /><a title="Remove" class="remove_item" onclick="remove_item('+i+')" id="del_'+i+'"> <span>Remove</span></a><input type="hidden" id="type_'+i+'" name="type_'+i+'" value="text">Label: <input type="text" name="label_'+i+'" id="label_'+i+'"><br />Required: <input type="checkbox" name="required_'+i+'"  id="required_'+i+'" value="1"><br />Validation: <select name="validation_'+i+'" id="validation_'+i+'"><option value="0">Select</option>'+validation+'</select></div><br />');
	break;
	case 'textarea' :
		$("#fields").prepend('<div id="fields_'+i+'" class="form_box ui-widget-header"><b>Textarea field</b><br /><a title="Remove" class="remove_item" onclick="remove_item('+i+')" id="del_'+i+'"> <span>Remove</span></a><input type="hidden" id="type_'+i+'" name="type_'+i+'" value="textarea">Label: <input type="text" name="label_'+i+'" id="label_'+i+'"><br />Required: <input type="checkbox" name="required_'+i+'"  id="required_'+i+'" value="1"><br />Validation: <select name="validation_'+i+'" id="validation_'+i+'"><option value="0">Select</option>'+validation+'</select></div><br />');
		break;
	case 'checkbox' :
		$("#fields").prepend('<div id="fields_'+i+'" class="form_box ui-widget-header"><b>Checkbox field</b><br /><a title="Remove" class="remove_item" onclick="remove_item('+i+')" id="del_'+i+'"> <span>Remove</span></a><input type="hidden" id="type_'+i+'" name="type_'+i+'" value="checkbox">Label: <input type="text" name="label_'+i+'" id="label_'+i+'"><br />Required: <input type="checkbox" name="required_'+i+'"  id="required_'+i+'" value="1"><br />Validation: <select name="validation_'+i+'" id="validation_'+i+'"><option value="0">Select</option>'+validation+'</select><br />Options:<br />Checked Default:<input type="checkbox" name="checked_default_'+i+'[]" id="checkbox_'+i+'" value="1">Label:<input type="text" name="label_default_'+i+'[]" id="label_'+i+'"><br /><a onclick="add_checkbox_options('+i+')">Add Options</a><div id="checkbox_options_'+i+'"></div></div><br />');
		break;
	case 'radio' :
		$("#fields").prepend('<div id="fields_'+i+'" class="form_box ui-widget-header"><b>Radio field</b><br /><a title="Remove" class="remove_item" onclick="remove_item('+i+')" id="del_'+i+'"> <span>Remove</span></a><input type="hidden" id="type_'+i+'" name="type_'+i+'" value="radio">Label: <input type="text" name="label_'+i+'" id="label_'+i+'"><br />Required: <input type="checkbox" name="required_'+i+'"  id="required_'+i+'" value="1"><br />Validation: <select name="validation_'+i+'" id="validation_'+i+'"><option value="0">Select</option>'+validation+'</select><br />Options:<br />Checked Default:<input type="radio" name="checked_default_radio_'+i+'" id="radio_'+i+'" value="0">Label:<input type="text" name="label_default_radio_'+i+'[]" id="label_'+i+'"><br /><a onclick="add_radio_options('+i+')">Add Options</a><div id="radio_options_'+i+'"></div></div><br />');
		break;
	case 'dropdown' :
		$("#fields").prepend('<div id="fields_'+i+'" class="form_box ui-widget-header"><b>Dropdown field<br /><input type="hidden" id="type_'+i+'" name="type_'+i+'" value="dropdown">Label: <input type="text" name="label_'+i+'" id="label_'+i+'"><br />Required: <input type="checkbox" name="required_'+i+'"  id="required_'+i+'" value="1"><br />Validation: <select name="validation_'+i+'" id="validation_'+i+'"><option value="0">Select</option>'+validation+'</select><br />Options:<br />Selected Option:<input type="radio" name="checked_default_dropdown_'+i+'" id="radio_'+i+'" value="0">Label:<input type="text" name="label_default_dropdown_'+i+'[]" id="label_'+i+'"><br /><a onclick="add_dropdown_options('+i+')">Add Options</a><div id="dropdown_options_'+i+'"></div></div><br />');
		break;
	}
	i++;
}
j = 0;
function add_checkbox_options(id)
{
	if(j == 0)
			{
		j = id + 1;
			}
	$("#checkbox_options_"+id).append('Checked Default: <input type="checkbox" name="checked_default_'+id+'[]" id="options_'+j+'[]" value="1"> Label:<input type="text" name="label_default_'+id+'[]" id="label_'+j+'"><br />');
	j++;
}

l = 1;
function add_radio_options(id)
{
	//if(l == 0)
		//	{
		//l = id + 1;
			//}
	$("#radio_options_"+id).append('Checked Default: <input type="radio" name="checked_default_radio_'+id+'" id="radio_'+l+'" value="'+l+'"> Label:<input type="text" name="label_default_radio_'+id+'[]" id="label_'+l+'"><br />');
	l++;
}

m = 1;
function add_dropdown_options(id)
{
	//if(m == 0)
		//	{
		//m = id + 1;
			//}
	$("#dropdown_options_"+id).append('Selected Default: <input type="radio" name="checked_default_dropdown_'+id+'" id="radio_'+m+'" value="'+m+'"> Option name:<input type="text" name="label_default_dropdown_'+id+'[]" id="label_'+m+'"><br />');
	m++;
}

function remove_item(id)
{
	$("#fields_"+id).remove();
}
</script>





		<div>
			<select onchange="add_new_field()" id="add_new_field">
				<option value="0">Select</option>
				<option value="text_field">text field</option>
				<option value="textarea">textarea</option>
				<option value="checkbox">checkbox</option>
				<option value="radio">radio</option>
				<option value="dropdown">dropdown</option>
			</select>
			<form name="register_form" id="register_form">
				<div id="fields"
					style="width: 900px; height: 100%; margin: 0; padding: 0;"></div>
				<div style="width: 900px; height: 100%; margin: 0; padding: 0;">
					{counter start=1 print=0 assign=i} {foreach from=$form_fields
					item=form_field} {include file="$tpl_dir/form_fields/form.tpl"}
					{counter} {/foreach}
					<div class="clear"></div>
					<div>
						<input type="button" name="submit" value="Save"
							onclick="save_register()">
					</div>
			
			</form>
		</div>
	</div>
	<div id="response" class="hidden">Data was saved</div>
	{literal}
	<script type="text/javascript">
function save_register()
{



			$.ajax({
				type : "POST",
				url : "index_admin.php?route=forms&action=save_register",
				data : $("#register_form").serialize(),
				dataType : 'json',
				success : function(response) {

					if (response.status == true) {
					$("#response").dialog({width:300,height:200,modal:true});
					}
				}
			});
		return false;

}
</script>
	{/literal}