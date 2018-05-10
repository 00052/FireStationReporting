{extends 'reports/menu.tpl'}
{block name=content1}
<br />
<form class="form-inline">
	<div class="form-group">
		<label for="datefrom">From</label>
		<input id="datefrom" type="text" class="form-control" role="date">
		</div>
		<div class="form-group">
		<label for="dateto">To</label>
		<input id="dateto" type="text" class="form-control" role="date">
		<button type="submit" class="btn btn-primary">Search</button>
		</div>
	</div>
</form>
hello
{/block}
