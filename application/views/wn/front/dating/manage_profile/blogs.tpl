 {foreach from=$blogs item=blog}
<div class="edit_blog_left ui-widget-header">
	<a onclick="edit_blog('{$blog->id}')">{$blog->title}</a>
</div>
{foreachelse} {$languages->blogs_no_results} {/foreach}
