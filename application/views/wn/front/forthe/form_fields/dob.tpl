<label for="{$form_field->field_name}">{$form_field->name}</label>
<select name="year" class="ui-widget-header select select select_dob">{foreach
	from=$years_dropdown item=validator}
	<option value="{$validator}">{$validator}</option>{/foreach}
</select>
<select name="month" class="ui-widget-header select select_dob">{foreach
	from=$months_dropdown item=validator}
	<option value="{$validator}">{$validator}</option>{/foreach}
</select>
<select name="day" class="ui-widget-header select select_dob">{foreach
	from=$days_dropdown item=validator}
	<option value="{$validator}">{$validator}</option>{/foreach}
</select>
<br />