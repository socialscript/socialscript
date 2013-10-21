<div id="blogs_left">
	<div id="blogs_profile">
		<a onclick="subscribe_to_blog('{$blogs_user_key}')"  class="label label-info" style="color:#FFFFFF">{$languages->subscribe_to_blog}</a>
		{if $blog_subscribers|count > 0} <br />{$languages->subscribers}: {foreach
		from=$blog_subscribers item=subscriber} <span class="label label-info">{$subscriber.user}</span>, {/foreach}
		{/if} <br /> <select name="galleries" id="select_blogs_profile"
			class="ui-widget-header select " onchange="change_blog_category()">
			{foreach from=$user_blog_categories item=blog}
			<option value="{$blog->id}">{$blog->category}</option> {/foreach}
		</select>
	</div>
	<div id="blogs">{include file="$tpl_dir/user/blogs/blogs.tpl"}</div>
</div>
<div id="blogs_right">
	<div id="blogs_comments"></div>
	<div id="blog"></div>
</div>


{literal}
<script type="text/javascript">
function show_blog(id,u_k)
{

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_content&action=view_blog",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}',
			'n_a':1
		},

		success : function(response) {
			$("#blog").html(response);
			$("#details_right").accordion({
				header : "h3",
				 fillSpace: true
			});
			hide_loading();
		}
	});

	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=view_blog_comments",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#blogs_comments").html(response);
			$("#details_left").accordion({
				header : "h3",
				 fillSpace: true
			});
		tiny_mce();
		}
	});
}

function change_blog_category()
{

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_content&action=view_blogs_by_category",
		data : {
			'u_id' : '{/literal}{$blogs_user_key}{literal}',
				'c_id' : $("#select_blogs_profile").val(),
			'rh' : '{/literal}{$request_hash}{literal}'
		},
		//dataType : 'json',
		success : function(response) {
$("#blogs").html('');
			$("#blogs").html(response);


			hide_loading();
		}
	});

	$("#blog").html('');
	 $("#blogs_comments").html('');

}


</script>
{/literal}
