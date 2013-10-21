<h3>
	<a href="#"> {$video->title} </a>
</h3>
<div>
	<div class="floatleft">
		<video width="{$video_player_width}" height="{$video_player_height}"
			controls="controls">
			{if $video->thumb != ''}
			<poster src="{$video->thumb}">{/if} {foreach from=$video->files
			item=file}
			<source src="{$file.file}" type="{$file.type}" />
			{/foreach} Your browser does not support the video tag. 
		
		</video>
		<br /> {$video->description}
	</div>
	<div class="floatleft">{$video->tags}</div>
</div>