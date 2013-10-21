
<label for="{$form_field->name}">{$form_field->name}</label>
<input type="hidden" name="dropdown_{$form_field->id}"
	value="{$form_field->id}">
<select name="{$form_field->field_name}" id="{$form_field->field_name}"
	class='{include file="$tpl_dir/form_fields/form_field_class.tpl"} ui-widget-header select '>
	{foreach from=$form_field->elements item=options}
	<option value="{$options.field_name}" {if $options.checked==
		'1'}selected="selected"{/if}>{$options.name}</option> {/foreach}
</select>
<br />