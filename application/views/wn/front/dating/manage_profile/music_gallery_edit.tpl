{foreach from=$musics item=music}
<tr class="template-download in">

	<td class="preview"></td>
	<td class="name">{$music.file_name}</td>
	<td class="size"><span>{$music.file_size}</span></td>
	<td colspan="2"></td>
	<td class="name"><span><input type="text" name="title"
			value="{$music.title}"></span></td>
	<td class="name"><span><textarea name="description">{$music.description}</textarea></span></td>
	<td class="name"><span><input type="text" name="tags"
			value="{$music.tags}"></span></td>
	<td class="delete">
		<button
			data-url="index.php?route=users_content&amp;action=delete_music&amp;g_id={$music.gallery_id}&amp;id={$music.id}&amp;rh={$request_hash}"
			data-type="POST" class="btn btn-danger">
			<i class="icon-trash icon-white"></i> <span>{$languages->delete}</span>
		</button> <input type="checkbox" value="1" name="delete">
	</td>
</tr>

{foreachelse} {$languages->no_results} {/foreach}
