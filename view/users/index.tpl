{extends 'main.tpl'}
{block name=content}

<table class="table table-striped table-hover">
	<colgroup>
        <col />
        <col />
        <col />
    </colgroup>
    
    <thead>
    	<tr>
        	<th>{'Username'|@lang}</th>
			<th>{'Nickname'|@lang}</th>
			<th>{'Usertype'|@lang}</th>
        </tr>
    </thead>
    
    <tbody>
{foreach $users as $user}
    	<tr>
        	<td>
            	<i class="fa fa-user"></i>
            	<a href="{Router->build p1='UsersController' p2='edit' p3=$user}">{$user->username}</a>
            </td>
			<td>{$user->nickname}</td>
			{if $user->type == User::USER_ADMIN}
			<td>{'Admin'|@lang}</td>
			{elseif $user->type == User::USER_STATION}
			<td>{'Station'|@lang}</td>
			{elseif $user->type == User::USER_SMALL_STATION}
			<td>{'SmallStation'|@lang}</td>
			{/if}
			
        </tr>
{/foreach}
    </tbody>
</table>

<div class="buttons">
	<a href="{Router->build p1='UsersController' p2='add'}" class="btn btn-default btn-sm" role="button">
    	<i class="fa fa-plus"></i> {'AddUser'|@lang}
    </a>
</div>

{/block}
