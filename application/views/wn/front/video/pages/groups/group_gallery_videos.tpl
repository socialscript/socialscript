{foreach from=$videos item=video}
<div class="ui-widget-header group_videos_video">
{$video->thumb}
<br />
		<a onclick="show_video('{$video->id}','{$video->group_id}')">{$video->title}</a>
</div>
		{foreachelse}
		{$languages->videos_no_results}
		{/foreach}