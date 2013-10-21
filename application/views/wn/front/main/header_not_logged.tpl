
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
    <div class="nav-collapse collapse">
		<ul class="nav ">
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}home"
				rel="{$settings->site_url}home" {else}
				onclick="show_home()"  {/if}><span>{$languages->header_home}</span></a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}register"
				rel="{$settings->site_url}register"
				{else}
				onclick="show_register()" {/if}><span>{$languages->menu_register}</span></a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}groups"
				rel="{$settings->site_url}groups"
				{else}
				onclick="show_center('users_interaction','show_groups')"  {/if}>{$languages->header_groups}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}all_users"
				rel="{$settings->site_url}all_users"
				{else}
				onclick="show_center('users','show_all_users')"  {/if}>{$languages->header_all_users}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}search"
				rel="{$settings->site_url}search"
				{else}
				onclick="show_center('users','show_search')"  {/if}><span>{$languages->header_search}</span></a></li><li class="divider-vertical"></li>
				
				{if $resolution.0 > 1300}
				<!-- 
			<li ><a {if $no_ajax==
				'yes'}href="{$settings->site_url}users_by_country"
				rel="{$settings->site_url}users_by_country"
				{else}
				onclick="show_center('users','show_people_by_country')"  {/if}>{$languages->header_by_country}</a></li><li class="divider-vertical"></li>
				-->
				{/if}
				
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}online_users"
				rel="{$settings->site_url}online_users"
				{else}
				onclick="show_center('users','show_online_people')"  {/if}>{$languages->header_online}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax==
				'yes'}href="{$settings->site_url}top_rated_users"
				rel="{$settings->site_url}top_rated_users"
				{else}
				onclick="show_center('users','show_top_rated_people')"  {/if}>{$languages->header_top_rated}</a></li><li class="divider-vertical"></li>
			 
			
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}photos"
				rel="{$settings->site_url}photos"
				{else}
				onclick="show_center('users_content','show_photos')"  {/if}>{$languages->header_photos}</a></li><li class="divider-vertical"></li>
			<li ><a {if $no_ajax== 'yes'}href="{$settings->site_url}videos"
				rel="{$settings->site_url}videos"
				{else}
				onclick="show_center('users_interaction','show_videos')"  {/if}>{$languages->header_videos}</a></li><li class="divider-vertical"></li>
			
				
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
			</ul></li><li class="divider"></li> 
			<!--{if $settings->users_can_choose_theme == 'yes'}
			<li  class='dropdown '><a href="#" class="dropdown-toggle" data-toggle="dropdown">Theme<b class="caret"></b></a>{include file="$tpl_dir/elements/theme_roller.tpl"}</li><li class="divider"></li>{/if}-->
		
		</ul> 
			<form id="login_form" method="post" class="navbar-search pull-right"
				action="index.php?route=users&action=login">
				  <input
					type="text" name="username_login"  
					id="username_login" value="{$languages->login_username}" style="width:100px;"> 
				<input type="password" name="password_login"
					  id="password_login" value="{$languages->login_password}" style="width:100px;"><input
					type="submit" name="login" id="login" value="Login"
					class="btn btn-success" style="margin-top:-10px;margin-left:5px;">
			</form>

</div>
</div>
</div>
</div>
<!-- 
	<div id="tabs-1" class="submenu">
		<div class="floatleft ">
			<form id="login_form" method="post"
				action="index.php?route=users&action=login">
				<label for="username_login">{$languages->login_username}</label> <input
					type="text" name="username_login" class='ui-widget-header input'
					id="username_login"> <label for="password_login">{$languages->login_password}</label>
				<input type="password" name="password_login"
					class='ui-widget-header input' id="password_login"> <label><input
					type="submit" name="login" id="login" value="Login"
					class="ui-widget-header input"></label>
			</form>
		</div>
		 
		

	</div>
-->
<div id="login_response" class="btn-danger"></div>

<div id="view_profile"></div>

