
	 			<ul class="submenu ">

<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('gossip')">{$languages->header_gossip}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('whatshot')">{$languages->header_whatshot}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('fashion')">{$languages->header_fashion}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('movies')">{$languages->header_movies}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('sports')">{$languages->header_sports}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('foods')">{$languages->header_foods}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('travel')">{$languages->header_travel}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('music')">{$languages->header_music}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('cars')">{$languages->header_cars}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('business')">{$languages->header_business}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('finance')">{$languages->header_finance}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('technology')">{$languages->header_technology}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('video_games')">{$languages->header_video_games}</a></li>
	{if
			$settings->enable_multiple_languages == 'yes'} {include
			file="$tpl_dir/elements/languages.tpl"} {/if}
 <li class=" ui-widget-header ui-tabs-nav" style="margin:0;padding:0;">{if $settings->users_can_choose_theme == 'yes'} {include
			file="$tpl_dir/elements/theme_roller.tpl"} {/if} </li>
</ul>

	<div class="clear"></div>
<div id="tabs">
	<nav>
		<ul>
			<!-- <li><div class="wn" id="wn">&nbsp;</div></li>-->
				<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_home()">{$languages->header_home}</a></li>
			<li class="topmenu"><a href="#tabs-1">{$languages->menu_login}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a onclick="show_register()">{$languages->menu_register}</a></li>

			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_extra_sections('news')">{$languages->header_news}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_interaction','show_groups')">{$languages->header_groups}</a></li>
				<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_all_users')">{$languages->header_all_users}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_search')">{$languages->header_search}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_people_by_country')">{$languages->header_by_country}</a></li>
					<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_online_people')">{$languages->header_online}</a></li>
					<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_top_rated_people')">{$languages->header_top_rated}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_groups()">{$languages->header_games}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_content','show_photos')">{$languages->header_photos}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_interaction','show_videos')">{$languages->header_videos}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_interaction','show_music_files')">{$languages->header_music}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_content','show_events')">{$languages->header_events}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_content','show_blogs')">{$languages->header_blogs}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_trade')">{$languages->header_trade}</a></li>
<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_statuses')">{$languages->header_statuses}</a></li>

		</ul>
	</nav>

	<div id="tabs-1">
		<div class="floatleft">
			<form id="login_form" method="post"
				action="index.php?route=users&action=login">
				<label for="username_login">{$languages->login_username}</label> <input type="text"
					name="username_login" class='ui-widget-header input'
					id="username_login"> <label for="password_login">{$languages->login_password}</label> <input
					type="password" name="password_login"
					class='ui-widget-header input' id="password_login"> <label><input
					type="submit" name="login" id="login" value="Login"
					class="ui-widget-header input"></label>
			</form>
		</div>
		<div id="login_response"></div>
		<div id="login_response_2" class="hidden">{$languages->login_first}</div>

		<div class="clear"></div>
	</div>


</div>
<div id="view_profile"></div>

