 {foreach from=$extra_sections item=extra_section}
<div class="edit_blog_left label label-info">
	<a onclick="edit_extra_section('{$extra_section->id}')">{$extra_section->title}</a>
	<br />{$extra_section->timestamp|date_format:$settings->date_format}
</div>
{foreachelse} {$languages->no_results} {/foreach}
