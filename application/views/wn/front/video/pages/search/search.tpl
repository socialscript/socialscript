<div id="show_search">

				<h3>
					<a href="#">{$languages->search}</a>
				</h3>
				<div class="middle_min_height">
				<form method="get" action="index.php?route=users&action=search">
				<input type="hidden" name="route" value="users">
				<input type="hidden" name="action" value="search">
<input type="text" name="username" id="username" class="ui-widget-header input">{$languages->search_username}
<ul class="imageless-css-3-form-elements">
<label><input type="checkbox" name="featured" id="featured"><span>{$languages->search_featured}</span></label>
</ul>
<ul class="imageless-css-3-form-elements">
<label><input type="checkbox" name="online" id="online"><span>{$languages->search_online}</span></label>
</ul>
<ul class="imageless-css-3-form-elements">
<label><input type="checkbox" name="only_with_picture" id="only_with_picture"><span>{$languages->only_with_picture}</span></label>
</ul>
<br />
{$languages->search_gender}
<ul class="imageless-css-3-form-elements">
<label><input type="radio" name="male" id="male"><span>{$languages->search_male}</span></label>
</ul>
<ul class="imageless-css-3-form-elements">
<label><input type="radio" name="female" id="female"><span>{$languages->search_female}</span></label>
</ul><br />
<!-- Age Between <input type="text" name="age_min" id="age_min" class="ui-widget-header input"> and
<input type="text" name="age_max" id="age_max" class="ui-widget-header input"> years<br />
-->
{if $settings->show_countries_dropdown_on_register == 'yes'}
<label for="countries">{$languages->search_country}</label>
<select name="country" id="search_country" class="ui-widget-header select">
<option value="1">Select Country</option>
{foreach from=$countries item=country}
<option {if $country->iso_code_2 == $user_country}selected="selected"{/if} value="{$country->iso_code_2}">{$country->iso_country}</option>
{/foreach}
</select>
{/if}
<br />
{$languages->search_order_by}
<select name="order_by" id="order_by" class="ui-widget-header select">
<option value="username_asc">Username ASC</option>
<option value="username_desc">Username DESC</option>
<option value="registered_date_asc">Registered Date ASC</option>
<option value="registered_date_desc">Registered Date DESC</option>
<option value="rating_desc">Rating DESC</option>
</select>
<br />
<input  {if $no_ajax=='yes'}type="submit"{else}type="button" onclick="search()"{/if} name="submit" value="Search" class="ui-widget-header input" >
 </div>
</form>
 </div>

<div class="clear"></div>
<div id="search_results"></div>