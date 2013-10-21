<div>
<h3><a href="#">{{$languages->featured_profiles_title}}</a></h3>
	<div  class="middle_min_height">
				{foreach from=$featured_profiles item=profile}
				{include file="$tpl_dir/home/boxes/profile_box.tpl"}
				{foreachelse}
				None yet
				{/foreach}
</div>
</div>