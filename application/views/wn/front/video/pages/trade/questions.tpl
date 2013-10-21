 {foreach from=$trade_questions item=question}
				<div class="comment_text   ui-widget-header">
		{$question->question}

		<div class="comment_info ">
		{$languages->by}: <a onclick="view_profile('{$question->user_key}')">{$question->username}</a> {$question->timestamp|date_format:$settings->date_format}
		</div>
		</div>
		{foreachelse}
		{$languages->questions_no_results}
		{/foreach}