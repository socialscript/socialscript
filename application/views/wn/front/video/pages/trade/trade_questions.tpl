<div id="details_left">
<div>
<h3 >
		<a href="#">{$languages->comments_title}</a>
		</h3>
<div>
		<div id="comments_list_details">
		{include file="$tpl_dir/pages/trade/questions.tpl"}

		</div>

<br />

<textarea name="trade_question" id="trade_question" class="comments_textarea"></textarea>
<input type="button" name="submit" onclick="add_trade_question({$trade_id})" value="Submit" class="ui-widget-header input">
</div>
</div>
</div>