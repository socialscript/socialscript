{foreach from=$group_blogs item=group_blog}
	<div class="group_blogs_blog ui-widget-header ">
		<a onclick="view_group_blog('{$group_blog->id}')">{$group_blog->title}</a>
	</div>
	{foreachelse} {$languages->blogs_no_results}{/foreach}