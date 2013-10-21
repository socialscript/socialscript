{foreach from=$group_pictures item=picture}
<div class="floatleft">
<a
	onclick="show_picture('{$picture.id}','{$picture.group_id}','{$picture.user_key}','{$picture.file_name}')">{$picture.image}</a>
{if $picture.delete == 'yes'}<br /><a onclick="delete_group_picture({$picture.id})">{$languages->delete}</a> &nbsp;&nbsp;{/if}
</div>
{foreachelse} {$languages->no_results} {/foreach}
