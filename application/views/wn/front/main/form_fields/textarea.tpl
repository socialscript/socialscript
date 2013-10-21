<label for="{$form_field->field_name}">{$form_field->name}</label>
<textarea name="{$form_field->field_name}"
	id="{$form_field->field_name}"
	class='{include file="$tpl_dir/form_fields/form_field_class.tpl"} '>{$form_field->value}</textarea>
<br />