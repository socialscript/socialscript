{foreach from=$pictures item=picture}
<a
	onclick="show_picture('{$picture.id}','{$picture.gallery_id}','{$picture.gallery_name}','{$picture.user_key}','{$picture.pic_name}')">{$picture.image}</a>
{foreachelse} {$languages->no_results_pictures} {/foreach}
