<div id="events_left">
<a onclick="subscribe_to_events('{$event_user_key}')">{$languages->subscribe_to_events}</a>
{if $events_subscribers|count > 0}
{$languages->subscribers}:
{foreach from=$events_subscribers item=subscriber}
{$subscriber.user},
{/foreach}
{/if}
<br />
		<div id="events">
			{include file="$tpl_dir/user/events/events.tpl"}
		</div>
		</div>
		<div id="events_right">
		<div id="events_comments"></div>
		<div id="event"></div>
		</div>


{literal}
<script type="text/javascript">
function show_event(id,u_k)
{

	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=view_event",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#event").html(response);
			$("#event").accordion({
				header : "h3",
				 animated: 'bounceslide',
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
			$("#events_comments").accordion({
				header : "h3",
				 animated: 'bounceslide',
				 fillSpace: true
			});
			$('#event_comment').wysiwyg({dialog:"jqueryui"});
		}
	});
}



</script>
{/literal}