<div id="fields_{$i}" class="form_box ui-widget-header">
	<b>Radio Field</b><br />
	<a title="Remove" onclick="remove_item('{$i}')" class="remove_item"
		id="del_{$i}"> <span>Remove</span></a> <input type="hidden"
		id="type_{$i}" name="type_{$i}" value="radio">Label: <input
		type="text" name="label_{$i}" id="label_{$i}"
		value="{$form_field->name}"><br />Required: <input type="checkbox"
		name="required_{$i}" id="required_{$i}" value="1" {if $form_field->required
	== '1'}checked="checked"{/if}><br />Validation: <select
		name="validation_{$i}" id="validation_{$i}"><option value="0">Select</option>
		{foreach from=$validators item=validator}
		<option value="{$validator}" {if $form_field->validation ==
			$validator}selected="selected"{/if}>{$validator}</option> {/foreach}
	</select><br />Options:<br /> {foreach from=$form_field->elements
	item=element} Checked default: <input type="radio"
		name="checked_default_radio_{$i}" id="radio_{$i}" value="0"
		{if $element.checked== "1"}checked="checked"{/if}>Label:<input
		type="text" name="label_default_radio_{$i}[]" id="label_{$i}"
		value="{$element.name}"><br /> {/foreach} <a
		onclick="add_radio_options({$i})">Add Options</a>
	<div id="radio_options_{$i}"></div>
</div>

<!-- <div class="radio" id="frm-{$i}-item">
	<div class="legend">
		<a title="Remove" href="#" class="del-button delete-confirm"
			id="del_{$i}"> <span>Remove</span></a> <strong id="txt-title-{$i}">Radio
			Group</strong>
	</div>
	<div class="frm-holder" id="frm-{$i}-fld">
		<div class="frm-elements">
			<div class="frm-fld">
				<label for="required-{$i}">Required</label> <input type="checkbox"
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
					<div class="rd_group">
						<div class="frm-fld">
							<label>Title</label> <input type="text" value=""
								name="radio-name-{$i}">
						</div>
						<div class="false-label">Select Options</div>
						<div class="fields">
							<div>
								<input type="radio" name="radio-{$i}[]"> <input type="text"
									name="radio-{$i}[]" value=""> <a title="Remove" class="remove"
									href="#">Remove</a>
							</div>
							<div class="add-area">
								<a class="add add_rd" href="#">Add</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
-->