<div id="messages"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#messages" href="#collapseMessages">{$languages->messages}</a>
		</div>
    <div id="collapseMessages" class="accordion-body collapse in">
      <div class="accordion-inner">
 
	<div class="middle_min_height" id="messages_list">{include
		file="$tpl_dir/manage_profile/messages_inner.tpl"}</div>
		</div>
		<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#messages" href="#collapseMessagesSaidHello">{$languages->said_hello}</a>
		</div>
    <div id="collapseMessagesSaidHello" class="accordion-body collapse in">
      <div class="accordion-inner">
	 
	<div class="middle_min_height" id="messages_list">{include
		file="$tpl_dir/manage_profile/said_hello_inner.tpl"}</div>
		</div>
		<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#messages" href="#collapseMessagesMarked">{$languages->marked_interested_in}</a>
		</div>
    <div id="collapseMessagesMarked" class="accordion-body collapse in">
      <div class="accordion-inner">
		 
	<div class="middle_min_height" id="messages_list">{include
		file="$tpl_dir/manage_profile/marked_interested_in_inner.tpl"}</div>
</div>
</div>
</div>
