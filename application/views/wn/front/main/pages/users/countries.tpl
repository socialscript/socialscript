	<div id="show_people_by_country"  class="accordion"   >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#show_people_by_country" href="#collapsePeopleByCountry">
	 {$languages->peoples_by_country}</a>

	</div>
    <div id="collapsePeopleByCountry" class="accordion-body collapse in" > 
      <div class="accordion-inner">
	<div class="middle_min_height">

		{foreach from=$countries item=country}
		<div class="people_by_country_left">
			<a {if $no_ajax==
				'yes'}href="{$settings->site_url}users_in/{$country->safe_seo_url}/{$country->iso_code_2}"
				{else}onclick="people_by_country('{$country->iso_code_2}')"{/if}>{$country->iso_country}({$country->users})</a>
		</div>
		{/foreach} <br />

	</div>
	</div>
	</div>
</div>