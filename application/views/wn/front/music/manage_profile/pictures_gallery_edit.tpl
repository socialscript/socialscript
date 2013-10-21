{foreach from=$pictures item=picture}
<tr class="template-download in">

	<td class="preview"><img rel="gallery" title="{$picture.pic_name}"
		src="image.php?aoe=1&amp;w=100&amp;h=100&amp;src={$picture.user_key}/photos/{$picture.gallery}/{$picture.file_name}">
	</td>
	<td class="name">{$picture.pic_name}</td>
	<td class="size"><span>{$picture.file_size}</span></td>
	<td colspan="2"></td>
	<td class="name"><span><input type="text" name="title"
			value="{$picture.pic_name}"></span></td>
	<td class="name"><span><textarea name="description">{$picture.pic_description}</textarea></span></td>
	<td class="name"><span><input type="text" name="tags"
			value="{$picture.pic_tags}"></span></td>
	<td class="delete">
		<button
			data-url="index.php?route=users_content&amp;action=delete_picture&amp;g_id={$picture.gallery_id}&amp;id={$picture.id}&rh={$request_hash}"
			data-type="POST" class="btn btn-danger">
			<i class="icon-trash icon-white"></i> <span>Delete</span>
		</button> <input type="checkbox" value="1" name="delete">
	</td>
</tr>

{foreachelse} {$languages->no_results} {/foreach}
