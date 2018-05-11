{extends 'reports/menu.tpl'}
{block name=content1}

<br/>
<form class="form-inline" action="{Router->build p1='ReportsController' p2='stationStrength'}">
	<label for="date">Date</label>
	<div class="form-group">
		<div class="input-group date">
		<input name="date" id="date" type="text" class="form-control" role="date" value={$date}>
		<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
		</div>
		<!--</div>-->
	</div>
	<button type="submit" class="btn btn-primary">Search</button>
</form>
<br/>
<div class="table-responsive">
<table class="table table-bordered">
    <colgroup>
        <col class="col-md" />
        <col class="col" />
        <col class="col" />
        <col class="col" />
        <col class="col" />
        <col class="col" />
    </colgroup>
    
    <thead>
        <tr>
            <th>{'Nickname'|@lang}</th>
            <th>{'Officer'|@lang}</th>
            <th>{'Soldier'|@lang}</th>
            <th>{'Employee'|@lang}</th>
            <th>{'FireEngine'|@lang}</th>
            <th>{'Driver'|@lang}</th>
        </tr>
    </thead>
    
    <tbody>
{foreach $table as $item}
        <tr>
            <td>
                <i class="fa fa-user"></i>
                <a href="{$item['uid']}">{$item['nickname']}</a>
            </td>
{if $item['reported']}
            <td>{$item['nofficer']}</td>
            <td>{$item['nsoldier']}</td>
            <td>{$item['nemployee']}</td>
            <td>{$item['nfireengine']}</td>
            <td>{$item['ndriver']}</td>
{else}
			<td colspan=5 align="center">*No Reporting</td>
{/if}
        </tr>
{/foreach}
		<tr>

			<td><i class="fa fa-plus"></i>*Total</td>
			<td>{$total['nofficer']}</td>
            <td>{$total['nsoldier']}</td>
            <td>{$total['nemployee']}</td>
            <td>{$total['nfireengine']}</td>
            <td>{$total['ndriver']}</td>

		</tr>
    </tbody>
</table>
</div>
<script type="text/javascript">
$('input[role=date]').datepicker({
format: "yyyy-mm-dd",
language: "zh-CN",
weekStart: 1,
saysOfWeekHighlighted: "0,6",
autoclose: true,
todayHighlight: true
}); 
</script>
{/block}
