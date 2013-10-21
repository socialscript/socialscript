<div id="fields_{$i}" class="form_box ui-widget-header">
	<b>Textarea Field</b><br />
	<a title="Remove" onclick="remove_item('{$i}')" class="remove_item"
		id="del_{$i}"> <span>Remove</span></a> <input type="hidden"
		id="type_{$i}" name="type_{$i}" value="textarea">Label: <input
		type="text" name="label_{$i}" id="label_{$i}"
		value="{$form_field->name}"><br />Required: <input type="checkbox"
		name="required_{$i}" id="required_{$i}" value="1" {if $form_field->required
	== '1'}checked="checked"{/if}><br />Validation: <select
		name="validation_{$i}" id="validation_{$i}"><option value="0">Select</option>
		{foreach from=$validators item=validator}
		<option value="{$validator}" {if $form_field->validation ==
			$validator}selected="selected"{/if}>{$validator}</option> {/foreach}
	</select>
</div>
<!-- <div class="textarea" id="frm-{$i}-item" style="display: list-item;">
	<div class="legend">
		<a title="Remove" href="#" class="del-button delete-confirm"
			id="del_{$i}"><span>Remove</span></a> <strong id="txt-title-{$i}">Paragraph
			field</strong>
	</div>
	<div class="frm-holder" id="frm-{$i}-fld">
		<div class="frm-elements">
			<div class="frm-fld">
				<label for="required-2">Required</label> <input type="checkbox"
					id="required-{$i}" name="required-{$i}" value="1" {if $form_field->required
				== '1'}checked="checked"{/if} class="required">
				<div class="frm-fld">
					<label for="validation_type-{$i}">Validation Type</label>
					<div class="frm-fld" id="validation_type-{$i}">
						<label for="validation_type-{$i}"> <select
							name="validation_type-{$i}" onchange="addAdditional(this,{$i})">
								<option value="">Select</option>option> {foreach
								from=$validators item=validator}
								<option value="{$validator}" {if $form_field->validation ==
									$validator}selected="selected"{/if}>{$validator}</option>
								{/foreach}
						</select>
						</label>
					</div>
					<label>Label</label> <input type="text" name="textarea-{$i}"
						value="{$form_field->name}">
				</div>
			</div>
		</div>
	</div>
</div>
-->