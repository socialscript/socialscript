
<div>
	{if $form_field->field_type == 'text'} {include
	file="$tpl_dir/form_fields/input_text.tpl"} <br />{elseif
	$form_field->field_type == 'textarea'} {include
	file="$tpl_dir/form_fields/textarea.tpl"} <br />{elseif
	$form_field->field_type == 'checkbox'} {include
	file="$tpl_dir/form_fields/input_checkbox.tpl"} <br /> {elseif
	$form_field->field_type == 'radio'} {include
	file="$tpl_dir/form_fields/input_radio.tpl"} <br />{elseif
	$form_field->field_type == 'dropdown'} {include
	file="$tpl_dir/form_fields/dropdown.tpl"} <br />{elseif
	$form_field->field_type == 'dob'} {include
	file="$tpl_dir/form_fields/dob.tpl"} <br /> {elseif
	$form_field->field_type == 'password'} {include
	file="$tpl_dir/form_fields/password.tpl"} <br />{elseif
	$form_field->field_type == 'repeat_password'} {include
	file="$tpl_dir/form_fields/repeat_password.tpl"} <br /> {/if}
</div>