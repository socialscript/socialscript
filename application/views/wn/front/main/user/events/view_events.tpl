<div id="events_left">
	<a onclick="subscribe_to_events('{$event_user_key}')"  class="label label-info" style="color:#FFFFFF">{$languages->subscribe_to_events}</a>
	{if $events_subscribers|count > 0}<br /> {$languages->subscribers}: {foreach
	from=$events_subscribers item=subscriber}<span class="label label-info">{$subscriber.user}</span>,
	{/foreach} {/if} <br />
	<div id="events">{include file="$tpl_dir/user/events/events.tpl"}</div>
</div>
<div id="events_right">
	<div id="events_comments"></div>
	<div id="event"></div>
	<div class="clear"></div>
</div>


{literal}
<script type="text/javascript">
function show_event(id,u_k)
{

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_content&action=view_event&n_a=1",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#event").html(response);
			$("#details_right").accordion({
				header : "h3",
				 fillSpace: true
			});
			hide_loading();
		}
	});

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=view_event_comments",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#events_comments").html(response);
			$("#details_left").accordion({
				header : "h3",
				 fillSpace: true
			});
					tiny_mce();

			//$('#event_comment').wysiwyg({dialog:"jqueryui"});
		}
	});
}



</script>
{/literal}
