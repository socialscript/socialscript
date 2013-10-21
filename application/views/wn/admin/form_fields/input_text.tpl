<div id="fields_{$i}" class="form_box ui-widget-header">
	<b>Text Field</b><br /> <a title="Remove" class="remove_item"
		onclick="remove_item('{$i}')" id="del_{$i}"> <span>Remove</span></a> <input
		type="hidden" id="type_{$i}" name="type_{$i}" value="text">Label: <input
		type="text" name="label_{$i}" id="label_{$i}"
		value="{$form_field->name}"> <br />Required: <input type="checkbox"
		name="required_{$i}" id="required_{$i}" value="1" {if $form_field->required
	== '1'}checked="checked"{/if}> <br />Validation: <select
		name="validation_{$i}" id="validation_{$i}"><option value="0">Select</option>
		{foreach from=$validators item=validator}
		<option value="{$validator}" {if $form_field->validation ==
			$validator}selected="selected"{/if}>{$validator}</option> {/foreach}
	</select>
</div>

