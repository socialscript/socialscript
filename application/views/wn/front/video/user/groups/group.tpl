{$languages->group_members}:
{foreach from=$members item=user}
{$user->username}
{foreachelse}
{$languages->no_group_members}
{/foreach}