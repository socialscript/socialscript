<form name="user" id="user">
	<input type="hidden" name="id" value="{$user_id}">
	<table
		class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
		<tbody>

			{foreach from=$user item=form_field}
			<tr>
				{if $form_field->field == 'year'}
				<td><label for="dob">Date of Birth</label></td>
				<td><select name="year" class="ui-widget-header select ">{foreach
						from=$years_dropdown item=validator}
						<option value="{$validator}" {if $form_field->value ==
							"{$validator}"}selected="selected"{/if}>{$validator}</option>{/foreach}
				</select> <select name="month" class="ui-widget-header  select">{foreach
						from=$months_dropdown item=validator}
						<option value="{$validator}" {if $form_field->value ==
							"{$validator}"}selected="selected"{/if}>{$validator}</option>{/foreach}
				</select> <select name="day" class="ui-widget-header  select">{foreach
						from=$days_dropdown item=validator}
						<option value="{$validator}" {if $form_field->value ==
							"{$validator}"}selected="selected"{/if}>{$validator}</option>{/foreach}
				</select></td> {elseif $form_field->field == 'month'} {elseif
				$form_field->field == 'day'} {else}
				<!--{include file="$tpl_dir/form_fields_edit/form.tpl"}-->
				<td><label for="{$form_field->field}">{$form_field->field|ucwords}</label></td>
				<td><input type="text" name="{$form_field->field}"
					id="{$form_field->field}" value="{$form_field->value}"></td> {/if}
			</tr>
			{foreachelse} No other data available {/foreach}
			<tr>
				<td colspan="2" align="center"><input type="button" name="submit"
					onclick="edit()" value="Edit"></td>
			</tr>
		</tbody>
	</table>
</form>