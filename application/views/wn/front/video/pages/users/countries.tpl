<div id="show_people_by_country">
				<h3>
					<a href="#">{$languages->peoples_by_country}</a>

				</h3>
				<div class="middle_min_height">

{foreach from=$countries item=country}
<div class="people_by_country_left">
<a  {if $no_ajax=='yes'}href="{$settings->site_url}users_in/{$country->safe_seo_url}/{$country->iso_code_2}"
				{else}onclick="people_by_country('{$country->iso_code_2}')"{/if}>{$country->iso_country}({$country->users})</a>
</div>
{/foreach}

<br />

				</div>
</div>