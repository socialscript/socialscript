

<div id="rp_list" class="rp_list">
	<ul>
		{foreach from=$profiles_right item=profile}
		<li>
			<div>
				{if $profile.type == 'video'} <a {if $no_ajax==
					'yes'}href="{$settings->site_url}video/{$profile.safe_seo_url}/{$profile.id}"
					{else}onclick="video_details('{$profile.id}','{$profile.user_key}')"{/if}>{$profile.thumb}</a>
				<span class="rp_title"> <a {if $no_ajax==
					'yes'}href="{$settings->site_url}video/{$profile.safe_seo_url}/{$profile.id}"
					{else}onclick="video_details('{$profile.id}','{$profile.user_key}')"{/if}>
						<b>Video::{$profile.title}</b>
				</a></span> <span class="rp_links"> <a {if $no_ajax==
					'yes'}href="{$settings->site_url}video/{$profile.safe_seo_url}/{$profile.id}"
					{else}onclick="video_details('{$profile.id}','{$profile.user_key}')"{/if}>View</a>
					<a {if $settings->only_logged_in_users_can_view_profile_info ==
						'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
						{else}{if
						$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile.username}"
						{else}onclick="view_profile('{$profile.user_key}')"{/if}{/if}>
						{$profile.username}</a>
				</span>
{elseif $profile.type == 'picture'}
<a {if $no_ajax==
		'yes'}href="{$settings->site_url}photo/{$profile.safe_seo_url}/{$profile.id}"
		{else}onclick="show_picture_details('{$profile.id}','{$profile.gallery_id}','{$profile.gallery_name}','{$profile.user_key}','{$profile.pic_name}')"{/if}>{$profile.image}</a>
				<span class="rp_title"> <a {if $no_ajax==
		'yes'}href="{$settings->site_url}photo/{$profile.safe_seo_url}/{$profile.id}"
		{else}onclick="show_picture_details('{$profile.id}','{$profile.gallery_id}','{$profile.gallery_name}','{$profile.user_key}','{$profile.pic_name}')"{/if}>
						<b>Picture::{$profile.title}</b>
				</a></span> <span class="rp_links"><a {if $no_ajax==
		'yes'}href="{$settings->site_url}photo/{$profile.safe_seo_url}/{$profile.id}"
		{else}onclick="show_picture_details('{$profile.id}','{$profile.gallery_id}','{$profile.gallery_name}','{$profile.user_key}','{$profile.pic_name}')"{/if}>View</a>
					<a {if $settings->only_logged_in_users_can_view_profile_info ==
						'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
						{else}{if
						$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile.username}"
						{else}onclick="view_profile('{$profile.user_key}')"{/if}{/if}>
						{$profile.username}</a>
				</span>
{elseif $profile.type == 'user'}
	<a {if $settings->only_logged_in_users_can_view_profile_info ==
						'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
						{else}{if
						$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile.username}"
						{else}onclick="view_profile('{$profile.user_key}')"{/if}{/if}>{$profile.profile_pic}</a>
				<span class="rp_title">	<a {if $settings->only_logged_in_users_can_view_profile_info ==
						'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
						{else}{if
						$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile.username}"
						{else}onclick="view_profile('{$profile.user_key}')"{/if}{/if}>

						<b>User::{$profile.username}</b></a></span> <span class="rp_links"> 	<a {if $settings->only_logged_in_users_can_view_profile_info ==
						'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
						{else}{if
						$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile.username}"
						{else}onclick="view_profile('{$profile.user_key}')"{/if}{/if}>View</a>
					<a {if $settings->only_logged_in_users_can_view_profile_info ==
						'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
						{else}{if
						$no_ajax=='yes'}href="{$settings->site_url}profile/{$profile.username}"
						{else}onclick="view_profile('{$profile.user_key}')"{/if}{/if}>
						{$profile.username}</a>
				</span>

				{/if}
			</div>
		</li> {/foreach}
	</ul>


</div>
{literal}
<script>
			$(function() {
				/**
				* the list of posts
				*/
				var $list 		= $('#rp_list ul');
				/**
				* number of related posts
				*/
				var elems_cnt 		= $list.children().length;

				/**
				* show the first set of posts.
				* 200 is the initial left margin for the list elements
				*/
				load(60);

				function load(initial){
					$list.find('li').hide().andSelf().find('div').css('margin-left',-initial+'px');
					var loaded	= 0;
					//show 5 random posts from all the ones in the list.
					//Make sure not to repeat
					while(loaded < 5){
						var r 		= Math.floor(Math.random()*elems_cnt);
						var $elem	= $list.find('li:nth-child('+ (r+1) +')');
						if($elem.is(':visible'))
							continue;
						else
							$elem.show();
						++loaded;
					}
					//animate them
					var d = 200;
					$list.find('li:visible div').each(function(){
						$(this).stop().animate({
							'marginLeft':'-50px'
						},d += 100);
					});
				}

				/**
				* hovering over the list elements makes them slide out
				*/
				$list.find('li:visible').live('mouseenter',function () {
					$(this).find('div').stop().animate({
						'marginLeft':'-220px'
					},200);
				}).live('mouseleave',function () {
					$(this).find('div').stop().animate({
						'marginLeft':'-50px'
					},200);
				});

				/**
				* when clicking the shuffle button,
				* show 5 random posts
				*/

            });
		</script>
{/literal}
