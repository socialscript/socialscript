<select id='theme_selector' class="ui-widget-header select "
	onchange="change_theme()" style="font-size: 9px; width: 80px;">
	{foreach from=$themes item=theme}
	<option value="{$theme}" {if $wn_theme== $theme}selected="selected"{/if}>{$theme}</option>
	{foreachelse} {$languages->no_themes_available} {/foreach}
</select>
{literal}
<script type="text/javascript">
$("select").css("background",
						$(".ui-widget-header").css("background-color"));
						</script>
{/literal}
