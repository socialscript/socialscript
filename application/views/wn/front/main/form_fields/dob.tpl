<label for="{$form_field->field_name}">{$form_field->name}</label>
<select name="year" class=" select_dob_year">{foreach
	from=$years_dropdown item=validator}
	<option value="{$validator}">{$validator}</option>{/foreach}
</select>
<select name="month" class="select_dob">{foreach
	from=$months_dropdown item=validator}
	<option value="{$validator}">{$validator}</option>{/foreach}
</select>
<select name="day" class=" select_dob">{foreach
	from=$days_dropdown item=validator}
	<option value="{$validator}">{$validator}</option>{/foreach}
</select>
<br />