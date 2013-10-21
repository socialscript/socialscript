{foreach from=$musics item=music}
<div class="ui-widget-header group_musics_music">
		<a onclick="show_music('{$music->id}','{$music->group_id}')">{$music->title}</a>
</div>
		{foreachelse}
	{$languages->music_no_results}
		{/foreach}