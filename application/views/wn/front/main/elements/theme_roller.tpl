<ul class="dropdown-menu">
	{foreach from=$themes item=theme}
	<li><a onclick="change_theme_2('{$theme}')">{$theme}</a></li>
	{foreachelse} {$languages->no_themes_available} {/foreach}
</ul>

 