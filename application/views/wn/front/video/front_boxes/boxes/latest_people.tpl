
				<h3>
					<a href="#">{$languages->latest_people_title}</a>
				</h3>
				<div>
				{foreach from=$latest_profiles item=profile}
				{include file="$tpl_dir/front_boxes/boxes/profile_box.tpl"}
				{foreachelse}
				None yet
				{/foreach}


				</div>

