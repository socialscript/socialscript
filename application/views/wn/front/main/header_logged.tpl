<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
    <div class="nav-collapse collapse">
		<ul class="nav ">

		
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}home"
				rel="{$settings->site_url}home" {else}
				onclick="show_home()"{/if}>{$languages->header_home}</a></li><li class="divider-vertical"></li>

			<li  class='dropdown'><a href="#" class="dropdown-toggle" data-toggle="dropdown">My account<b class="caret"></b></a>
				<ul class="dropdown-menu">
					
					<li><a
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users&action=profile&rh={$request_hash}"
				{else}
					onclick="show_profile()"{/if}>{$languages->header_profile}</a></li><li class="divider"></li>
			<li><a
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=friends&rh={$request_hash}"
				{else}
					onclick="show_center('users_interaction','friends')"{/if}
					>{$languages->header_friends}</a></li><li class="divider"></li> 
			<li ><a
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=best_friends&rh={$request_hash}"
				{else}
					onclick="show_center('users_interaction','best_friends')"{/if}
				>{$languages->header_best_friends}</a></li><li class="divider"></li> 
				 
			<li ><a
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=family_friends&rh={$request_hash}"
				{else}
					onclick="show_center('users_interaction','family_friends')"{/if}>{$languages->header_family}</a></li><li class="divider"></li>
 
 
			<li ><a
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=show_matches&rh={$request_hash}"
				{else}
					onclick="show_center('users_interaction','show_matches')"{/if}>
					{$languages->header_matches}</a></li><li class="divider"></li>
 
			<li ><a
				onclick="manage_pictures()">{$languages->manage_pictures}</a></li><li class="divider"></li>
			<li ><a
				onclick="manage_videos()">{$languages->manage_videos}</a></li><li class="divider"></li>
			<li ><a
				onclick="manage_music()">{$languages->manage_music}</a></li><li class="divider"></li>
			<li ><a
				onclick="manage_blogs()">{$languages->manage_blogs}</a></li><li class="divider"></li>
			<li ><a
				onclick="manage_events()">{$languages->manage_events}</a></li><li class="divider"></li>
			<li ><a
				onclick="manage_groups()">{$languages->manage_groups}</a></li><li class="divider"></li>
			<li ><a onclick="start_webcam()">{$languages->webcam}</a></li>
			
</ul>
<li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}groups"
				rel="{$settings->site_url}groups"
				{else}
				onclick="show_center('users_interaction','show_groups')"{/if}>{$languages->header_groups}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}all_users"
				rel="{$settings->site_url}all_users"
				{else}
				onclick="show_center('users','show_all_users')"{/if}>{$languages->header_all_users}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}search"
				rel="{$settings->site_url}search"
				{else}
				onclick="show_center('users','show_search')"{/if}><span>{$languages->header_search}</span></a></li><li class="divider-vertical"></li>
				
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}online_users"
				rel="{$settings->site_url}online_users"
				{else}
				onclick="show_center('users','show_online_people')"{/if}>{$languages->header_online}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax==
				'yes'}href="{$settings->site_url}top_rated_users"
				rel="{$settings->site_url}top_rated_users"
				{else}
				onclick="show_center('users','show_top_rated_people')"{/if}>{$languages->header_top_rated}</a></li><li class="divider-vertical"></li>
			 
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}photos"
				rel="{$settings->site_url}photos"
				{else}
				onclick="show_center('users_content','show_photos')"{/if}>{$languages->header_photos}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}videos"
				rel="{$settings->site_url}videos"
				{else}
				onclick="show_center('users_interaction','show_videos')"{/if}>{$languages->header_videos}</a></li><li class="divider-vertical"></li>
		 				

		 
				
				<li  class='dropdown'><a href="#" class="dropdown-toggle" data-toggle="dropdown">Content<b class="caret"></b></a>
				<ul class="dropdown-menu">
				<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}flash_games"
				rel="{$settings->site_url}flash_games"
				{else}
				onclick="show_center('users_content','show_games')"  {/if}>{$languages->header_flash_games}</a></li><li class="divider"></li>
					<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}events"
				rel="{$settings->site_url}events"
				{else}
				onclick="show_center('users_content','show_events')"  {/if}>{$languages->header_events}</a></li><li class="divider"></li>
				<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}blogs"
				rel="{$settings->site_url}blogs"
				{else}
				onclick="show_center('users_content','show_blogs')"  {/if}>{$languages->header_blogs}</a></li><li class="divider"></li>
				<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}music"
				rel="{$settings->site_url}music"
				{else}
				onclick="show_center('users_interaction','show_music_files')"  {/if}>{$languages->header_music}</a></li>
		
			
				</ul>
				
		<li  class='dropdown'><a href="#" class="dropdown-toggle" data-toggle="dropdown">Interact<b class="caret"></b></a>

							<ul class="dropdown-menu">
							<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/news"
				{else}
				onclick="show_extra_sections('news')"  {/if}>{$languages->header_news}</a></li><li class="divider"></li>
						<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}trade"
				{else}
				onclick="show_center('users','show_trade')"{/if}>{$languages->header_trade}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/gossip"
				{else}
				onclick="show_extra_sections('gossip')"{/if}>{$languages->header_gossip}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/whatshot"
				{else}
				onclick="show_extra_sections('whatshot')"{/if}>{$languages->header_whatshot}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/fashion"
				{else}
				onclick="show_extra_sections('fashion')"{/if}>{$languages->header_fashion}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/movies"
				{else}
				onclick="show_extra_sections('movies')"{/if}>{$languages->header_movies}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/sports"
				{else}
				onclick="show_extra_sections('sports')"{/if}>{$languages->header_sports}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/foods"
				{else}
				onclick="show_extra_sections('foods')"{/if}>{$languages->header_foods}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/travel"
				{else}
				onclick="show_extra_sections('travel')"{/if}>{$languages->header_travel}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/music"
				{else}
				onclick="show_extra_sections('music')"{/if}>{$languages->header_music}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/cars"
				{else}
				onclick="show_extra_sections('cars')"{/if}>{$languages->header_cars}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/business"
				{else}
				onclick="show_extra_sections('business')"{/if}>{$languages->header_business}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/technology"
				{else}
				onclick="show_extra_sections('technology')"{/if}>{$languages->header_technology}</a></li><li class="divider"></li>
					<li><a {if $no_ajax== 'yes'}href="{$settings->site_url}peopletalk/gossip"
				{else}
				onclick="show_center('users','show_statuses')"{/if}>{$languages->header_statuses}</a></li><li class="divider"></li>
			<li ><a {if $no_ajax==
				'yes'}href="{$settings->site_url}users_by_country"
				rel="{$settings->site_url}users_by_country"
				{else}
				onclick="show_center('users','show_people_by_country')"{/if}>{$languages->header_by_country}</a></li>
			</ul></li>   
				<li style="margin-left:150px;"><a
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=messages&rh={$request_hash}"
				{else}
					onclick="show_center('users_interaction','messages')"{/if}
					>{$languages->header_messages}({$unread_messages})</a></li> <li class="divider-vertical"></li>
		
					<li ><a href="#" onclick="logout()" >{$languages->menu_logout}</a></li>
		
			
		</ul>
		</div> 
		</div>
		</div>
		</div>


 
	<div id="view_profile"></div>