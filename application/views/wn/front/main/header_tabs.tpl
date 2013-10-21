<div id="tabs">
	<nav>
		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}home"
				rel="{$settings->site_url}home" {else}
				onclick="show_home()"   href="#"{/if}>{$languages->header_home}</a></li>
			<li class="ui-state-default ui-corner-top ui-state-active"><a href="#">{$languages->menu_login}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}register"
				rel="{$settings->site_url}register"
				{else}
				onclick="show_register()" href="#"{/if}>{$languages->menu_register}</a></li>

			<li class="ui-state-default ui-corner-top"><a {if $no_ajax==
				'yes'}href="{$settings->site_url}peopletalk/news"
				rel="{$settings->site_url}peopletalk/news"
				{else}onclick="show_extra_sections('news')"  href="#"{/if}>{$languages->header_news}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}groups"
				rel="{$settings->site_url}groups"
				{else}
				onclick="show_center('users_interaction','show_groups')"  href="#"{/if}>{$languages->header_groups}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}all_users"
				rel="{$settings->site_url}all_users"
				{else}
				onclick="show_center('users','show_all_users')"  href="#"{/if}>{$languages->header_all_users}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}search"
				rel="{$settings->site_url}search"
				{else}
				onclick="show_center('users','show_search')"  href="#"{/if}><span>{$languages->header_search}</span></a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax==
				'yes'}href="{$settings->site_url}users_by_country"
				rel="{$settings->site_url}users_by_country"
				{else}
				onclick="show_center('users','show_people_by_country')"  href="#"{/if}>{$languages->header_by_country}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}online_users"
				rel="{$settings->site_url}online_users"
				{else}
				onclick="show_center('users','show_online_people')"  href="#"{/if}>{$languages->header_online}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax==
				'yes'}href="{$settings->site_url}top_rated_users"
				rel="{$settings->site_url}top_rated_users"
				{else}
				onclick="show_center('users','show_top_rated_people')"  href="#"{/if}>{$languages->header_top_rated}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}flash_games"
				rel="{$settings->site_url}flash_games"
				{else}
				onclick="show_center('users_content','show_games')"  href="#"{/if}>{$languages->header_flash_games}</a></li>

			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}photos"
				rel="{$settings->site_url}photos"
				{else}
				onclick="show_center('users_content','show_photos')"  href="#"{/if}>{$languages->header_photos}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}videos"
				rel="{$settings->site_url}videos"
				{else}
				onclick="show_center('users_interaction','show_videos')"  href="#"{/if}>{$languages->header_videos}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}music"
				rel="{$settings->site_url}music"
				{else}
				onclick="show_center('users_interaction','show_music_files')"  href="#"{/if}>{$languages->header_music}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}events"
				rel="{$settings->site_url}events"
				{else}
				onclick="show_center('users_content','show_events')"  href="#"{/if}>{$languages->header_events}</a></li>
			<li class="ui-state-default ui-corner-top"><a {if $no_ajax== 'yes'}href="{$settings->site_url}blogs"
				rel="{$settings->site_url}blogs"
				{else}
				onclick="show_center('users_content','show_blogs')"  href="#"{/if}>{$languages->header_blogs}</a></li>

			<li class="ui-state-default ui-corner-top"><select name="categories" id="categories"
				onchange="interact(this)">
					<option value="Categories" selected="selected">Interact</option>
						<option value="trade">{$languages->header_trade}</option>
					<option value="gossip">{$languages->header_gossip}</option>
					<option value="whatshot">{$languages->header_whatshot}</option>
					<option value="fashion">{$languages->header_fashion}</option>
					<option value="movies">{$languages->header_movies}</option>
					<option value="sports">{$languages->header_sports}</option>
					<option value="foods">{$languages->header_foods}</option>
					<option value="travel">{$languages->header_travel}</option>
					<option value="music">{$languages->header_music}</option>
					<option value="cars">{$languages->header_cars}</option>
					<option value="business">{$languages->header_business}</option>
					<option value="technology">{$languages->header_technology}</option>
					<option value="statuses">{$languages->header_statuses}</option>
			</select></li> {if $settings->users_can_choose_theme == 'yes'}
			<li class="ui-state-default ui-corner-top">{include file="$tpl_dir/elements/theme_roller.tpl"}</li>{/if}
		</ul>
	</nav>

	<div id="tabs-1" class="login ui-state-default ui-corner-top">
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
		<div id="login_response"></div>

	</div>
</div>

<div id="view_profile"></div>

