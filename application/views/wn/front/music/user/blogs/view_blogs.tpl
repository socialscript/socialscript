<div id="blogs_left">
	<div id="blogs_profile">
		<a onclick="subscribe_to_blog('{$blogs_user_key}')">{$languages->subscribe_to_blog}</a>
		{if $blog_subscribers|count > 0} Subscribers: {foreach
		from=$blog_subscribers item=subscriber} {$subscriber.user}, {/foreach}
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
			'rh' : '{/literal}{$request_hash}{literal}'
		},

		success : function(response) {
			$("#blog").html(response);
			$("#blog").accordion({
				header : "h3",
				 animated: 'bounceslide',
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
			$("#blogs_comments").accordion({
				header : "h3",
				 animated: 'bounceslide',
				 fillSpace: true
			});
			$('#blog_comment').wysiwyg({dialog:"jqueryui"});
		}
	});
}

function change_blog_category()
{

	show_loading();
	$.ajax({
		type : "POST",
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

	$("#blogs_right").html('');
	 $("#blogs_comments").html('');

}


</script>
{/literal}
