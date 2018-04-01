{extends 'main.tpl'}
{block name=content}
	<p>{'Welcome'|@lang}</p>
	<br />
	<p>{if $isAdmin}Logged in{/if}</p>
{/block}
