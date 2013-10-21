{foreach from=$groups item=group}
		<a onclick="show_group('{$group->id}','{$group->user_key}')">{$group->group_name}</a>,{$group->group_location} <a onclick="join_group('{$group->id}','{$group->user_key}')">Join</a><br />
		{foreachelse}
		{$languages->groups_no_results}
		{/foreach}