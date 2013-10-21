<div>
				<h3>
					<a href="#">{$languages->latest_people_title}</a>
				</h3>
				<div  class="middle_min_height">
				{foreach from=$latest_profiles item=profile}
				{include file="$tpl_dir/home/boxes/profile_box.tpl"}
				{foreachelse}
				None yet
				{/foreach}


				</div>

</div>