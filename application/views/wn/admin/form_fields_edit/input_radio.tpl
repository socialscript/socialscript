
<label for="{$form_field->field_name}">{$form_field->name}</label>
<ul class="imageless-css-3-form-elements">
	{foreach from=$form_field->elements item=options}

	<label><input type="radio" name="{$form_field->field_name}"
		id="{$options.field_name}" {if $options.checked==
		'1'}checked="checked" {/if} value="{$options.field_name}"><span>{$options.name}</span></label>
	{/foreach}
</ul>
<br />