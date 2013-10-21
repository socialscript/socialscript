<label for="{$form_field->field_name}">Password</label>
<input type="password" name="password" id="password"
	class='{include file="$tpl_dir/form_fields/form_field_class.tpl"}'>
<br />
<label for="{$form_field->field_name}">Repeat Password</label>
<input type="password"
	class="validate[required,equals[password]] "
	name="password2" id="password2">
<br />