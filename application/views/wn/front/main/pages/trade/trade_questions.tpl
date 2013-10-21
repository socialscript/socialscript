
		<div id="details_left"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_left" href="#collapseEventsDetails">{$languages->comments_title}</a>
		</div>
		
		 <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
			<div id="comments_list_details">{include
				file="$tpl_dir/pages/trade/questions.tpl"}</div>

			<br />

			<textarea name="trade_question" id="trade_question"
				class="comments_textarea"></textarea>
			<input type="button" name="submit"
				onclick="add_trade_question({$trade_id})" value="Submit"
				class="btn">
		</div>
	</div>
</div>
</div>
</div>