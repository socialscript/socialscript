
<label for="{$form_field->name}">{$form_field->name}</label>
<ul class="imageless-css-3-form-elements">
<input type="hidden" name="checkbox_{$form_field->id}" value="{$form_field->id}">
	{foreach from=$form_field->elements item=options}
	<label> <input type="checkbox" name="{$options.field_name}"
		id="{$options.field_name}" {if $options.checked==
		'1'}checked="checked" {/if} value="1"><span>{$options.name}</span></label>
	{/foreach}
</ul>

<br />