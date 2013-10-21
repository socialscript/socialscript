{foreach from=$pictures_comments item=comment} {$comment->comment}
{foreachelse} {$languages->no_results_comments} {/foreach}
