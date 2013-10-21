<div id="groups_left">
<a onclick="subscribe_to_groups('{$group_user_key}')">{$languages->subscribe_to_groups}</a>
{if $group_subscribers|count > 0}
{$languages->subscribers}:
{foreach from=$group_subscribers item=subscriber}
{$subscriber.user},
{/foreach}
{/if}
<br />
		<div id="groups">
			{include file="$tpl_dir/user/groups/groups.tpl"}
		</div>
		<div id="groups_comments"></div>
		</div>
		<div id="groups_right">
		</div>
{literal}
<script type="text/javascript">
function show_group(id,u_k)
{

$("#view_user_section").dialog('close');
group_details(id,u_k);
/*

	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=view_group",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#groups_right").html(response);
			hide_loading();
		}
	});

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=view_group_comments",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#groups_comments").html(response);
		}
	});
	*/
}


</script>
{/literal}