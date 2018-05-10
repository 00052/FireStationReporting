{extends 'main.tpl'}
{block name=content}

<div class="table-responsive">
<table class="table table-striped table-hover">
	<colgroup>
        <col />
        <col class="col-sm" />
        <col class="col-sm" />
        <col class="col-sm" />
    </colgroup>
    
    <thead>
    	<tr>
        	<th>{'Name'|@lang}</th>
            <th>{'Department'|@lang}</th>
            <th>{'Duty'|@lang}</th>
			<th>{'Operation'|@lang}</th>
        </tr>
    </thead>
    
    <tbody>
{foreach $officers as $officer}
    	<tr>
        	<td>
            	<i class="fa fa-user"></i>
            	<a href="#">{$officer->name}</a>
            </td>
            <td>{$officer->department}</td>
            <td>{$officer->duty}</td>
			<!-- <td><a href="{Router->build p1='OfficerController' p2='delete' p3=$officer}" data-noajax="true">{'Delete'|@lang}</a></td> -->
			<td><a href="javascript:window.location.replace('{Router->build p1='OfficerController' p2='delete' p3=$officer}')" onclick="return confirm('{"ConfirmDelete"|@lang}');" data-noajax="true">{'Delete'|@lang}</a></td>
        </tr>
{/foreach}
    </tbody>
</table>
</div>

<div class="buttons">
	<a href="{Router->build p1='OfficerController' p2='add'}" class="btn btn-default btn-sm" data-noajax=true role="button"><i class="fa fa-plus"></i>{'AddOfficer'|@lang}</a>
</div>

{/block}
