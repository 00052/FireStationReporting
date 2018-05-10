{extends 'main.tpl'}
{block name=content}
	<p>{'Welcome'|@lang}</p>
	<br />
	<p>{if $isAdmin}管理员{else}非管理员{/if}</p>
{/block}
