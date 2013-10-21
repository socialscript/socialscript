{foreach from=$pictures item=picture}
		<a onclick="show_picture('{$picture.id}','{$picture.group_id}','{$picture.user_key}','{$picture.file_name}')">{$picture.image}</a>

		{foreachelse}
		{$languages->no_results}
				{/foreach}