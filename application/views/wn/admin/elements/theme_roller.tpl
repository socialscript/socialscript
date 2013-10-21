<select id='theme_selector' class="ui-widget-header select"
	style="font-size: 9px; width: 90px;"> {foreach from=$themes item=theme}
	<option value="{$theme}" {if $wn_theme== $theme}selected="selected"{/if}>{$theme}</option>
	{foreachelse} No themes {/foreach}
</select>