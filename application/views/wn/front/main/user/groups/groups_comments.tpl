{$group->group_description}
<br />
{$languages->comments_title}: {foreach from=$groups_comments
item=comment} {$comment->comment}
<br />
{foreachelse} {$languages->comments_no_results} {/foreach}

<br />
<textarea name="group_comment" id="group_comment"></textarea>
<input type="button" class="btn" name="submit" onclick="add_group_comment()"
	value="Submit">