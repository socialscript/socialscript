
<label for="{$form_field->name}">{$form_field->name}</label>
<ul class="imageless-css-3-form-elements">
	<input type="hidden" name="radio_{$form_field->id}"
		value="{$form_field->id}"> {foreach from=$form_field->elements
	item=options}

	<label><input type="radio" name="{$form_field->field_name}"
		{if $options.checked== '1'}checked="checked"
		{/if} value="{$options.name}"><span>{$options.field_name}</span></label>
	{/foreach}
</ul>
<br />