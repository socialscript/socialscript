<div class="select" id="frm-{$i}-item">
	<div class="legend">
		<a title="Remove" href="#" class="del-button delete-confirm"
			id="del_{$i}"><span>Remove</span></a> <strong id="txt-title-{$i}">Dropdown</strong>
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
						<label for="validation_type-{$i}"> </label>
					</div>
					<div class="opt_group">
						<div class="frm-fld">
							<label>Title</label> <input type="text" value=""
								name="dropdown-name-{$i}">
						</div>
						Preview: <select name="year">{foreach from=$years_dropdown
							item=validator}
							<option value="{$validator}">{$validator}</option>{/foreach}
						</select> <select name="month">{foreach from=$months_dropdown
							item=validator}
							<option value="{$validator}">{$validator}</option>{/foreach}
						</select> <select name="day">{foreach from=$days_dropdown
							item=validator}
							<option value="{$validator}">{$validator}</option>{/foreach}
						</select> <br /> <a title="Remove" class="remove" href="#">Remove</a>
					</div>
					<div class="add-area">
						<a class="add add_opt" href="#">Add</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>