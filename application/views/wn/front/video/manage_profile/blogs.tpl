	{foreach from=$blogs item=blog}
	<div>
		<a onclick="edit_blog('{$blog->id}')">{$blog->title}</a>
	</div>
	{foreachelse} {$languages->blogs_no_results} {/foreach}