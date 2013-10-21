

		<div id="details_left"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#details_left" href="#collapseEventsDetails">{$languages->comments_title}</a>
		</div>
		
		 <div id="collapseEventsDetails" class="accordion-body collapse in" style="min-height:400px;">
      <div class="accordion-inner">
		<div id="comments_list_details">{include
			file="$tpl_dir/pages/extra_sections/comments.tpl"}</div>

		<form id="extra_sections_form">
			<br />
			<textarea name="extra_sections_comment" id="extra_sections_comment"
				class="comments_textarea validate[required]"></textarea>
			<input type="button" name="submit"
				onclick="add_extra_sections_comment('{$type}','{$id}')"
				value="Submit" class="btn">

		</form>
	</div>
</div>
</div>
</div>


<div class="box_separator">&nbsp;</div>