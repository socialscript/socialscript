<h3>
			<a href="#">
				{$music->title}
			</a>
		</h3>
		<div>
		<div class="floatleft">
		<audio width="{$music_player_width}" height="{$music_player_height}" controls="controls">

		{foreach from=$music->files item=file}
  <source src="{$file.file}" type="{$file.type}" />
  {/foreach}
  Your browser does not support the audio tag.
</audio>
<br />
		{$music->description}
</div>
<div class="floatleft">
		{$music->tags}

		</div>
		</div>