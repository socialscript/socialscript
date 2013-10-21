<label for="{$form_field->field_name}">{$form_field->name}</label>
<input type="text" name="{$form_field->field_name}"
	class='{include file="$tpl_dir/form_fields/form_field_class.tpl"} ui-widget-header  input'
	id="{$form_field->field_name}" value="{$form_field->value}">
<br />