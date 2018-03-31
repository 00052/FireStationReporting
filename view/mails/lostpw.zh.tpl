{extends 'mails/lostpw.tpl'}
{block name=content}
<p>你好 {$user} ({$user->username}),</p>

<p>如果你想修改密码，请点击如下链接。如果这不是你本人的操作，保持冷静，你的密码还没有被修改。</p>

<a href="{$link}">重置密码</a>

<p class="info">这是自动发送的邮件，请不要回复</p>
{/block}
