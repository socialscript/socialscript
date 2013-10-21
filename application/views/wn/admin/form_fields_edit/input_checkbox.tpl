
<label for="{$form_field->field_name}">{$form_field->name}</label>
<ul class="imageless-css-3-form-elements">

	{foreach from=$form_field->elements item=options}
	<label> <input type="checkbox" name="{$options.field_name}"
		id="{$options.field_name}" {if $options.checked==
		'1'}checked="checked" {/if} value="1"><span>{$options.name}</span></label>label>
	{/foreach}
</ul>

<br />