<div class="select" id="frm-{$i}-item">
	<div class="legend">
		<a title="Remove" href="#" class="del-button delete-confirm"
			id="del_{$i}"><span>Remove</span></a> <strong id="txt-title-{$i}">Password
			and Retype Password</strong>
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

					<div class="frm-fld">
						Preview:<input type="hidden" name="password_retype-{$i}">Password:<input
							type="password"> Retype Password:<input type="password">
					</div>
				</div>
			</div>
		</div>

	</div>