
<td><label for="{$form_field->field}">{$form_field->field|ucwords}</label></td>
<td><select name="{$form_field->field_name}"
	class="{include file='$tpl_dir/form_fields/form_field_class.tpl'} ui-widget-header select ">
		{foreach from=$form_field->elements item=options}
		<option value="{$options.field_name}"
			data-icon="img/products/iphone.png" data-html-text="$options.name">{$options.name}</option>
		{/foreach}
</select></td>