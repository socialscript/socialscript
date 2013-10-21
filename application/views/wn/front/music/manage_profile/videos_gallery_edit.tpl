{foreach from=$videos item=video}
<tr class="template-download in">

	<td class="preview"></td>
	<td class="name">{$video.video_name}</td>
	<td class="size"><span>{$video.file_size}</span></td>
	<td colspan="2"></td>
	<td class="name"><span><input type="text" name="title"
			value="{$video.video_name}"></span></td>
	<td class="name"><span><textarea name="description">{$video.video_description}</textarea></span></td>
	<td class="name"><span><input type="text" name="tags"
			value="{$video.video_tags}"></span></td>
	<td class="delete">
		<button
			data-url="index.php?route=users_content&amp;action=delete_video&amp;g_id={$video.gallery_id}&amp;id={$video.id}&rh={$request_hash}"
			data-type="POST" class="btn btn-danger">
			<i class="icon-trash icon-white"></i> <span>{$languages->delete}</span>
		</button> <input type="checkbox" value="1" name="delete">
	</td>
</tr>

{foreachelse} {$languages->no_results} {/foreach}
