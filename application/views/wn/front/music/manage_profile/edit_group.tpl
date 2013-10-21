<div id="group_id" class="hidden">{$group->id}</div>
{$languages->group_name}:
<input type="text" name="group_name" id="edit_group_name"
	value="{$group->group_name}" class="ui-widget-header group_name input">
<br />
{$languages->group_description}:
<textarea id="edit_group_description"
	class="ui-widget-header group_description">{$group->group_description}</textarea>
<br />
{$languages->privacy}:
<input type="radio" name="group_privacy" id="edit_group_privacy_1"
	class="ui-widget-header  input " value="1" {if $group->
privacy == 1}checked="checked"{/if}>{$languages->open_to_all}
<input type="radio" name="group_privacy" id="edit_group_privacy_2"
	class="ui-widget-header  input " value="2" {if $group->
privacy ==
2}checked="checked"{/if}>{$languages->show_in_search_but_closed_to_other_than_members}
<input type="radio" name="group_privacy" id="edit_group_privacy_3"
	class="ui-widget-header  input " value="3" {if $group->
privacy == 3}checked="checked"{/if}>{$languages->open_only_to_members}
<br />
{$languages->location}:
<input type="text" name="group_location" id="edit_group_location"
	value="{$group->group_location}"
	class="ui-widget-header  group_location input">
<br />

<input type="button" value="Submit" onclick="edit_group_text()"
	class="ui-widget-header  input">