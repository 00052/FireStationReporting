<form class="form-inline" action="{$action}">
	<label for="date">{'Date'|@lang}</label> 
	<div class="form-group">
		<div class="input-group date">
		<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
		<input name="date" id="date" type="text" class="form-control" role="date" value={$date}>
		<div class="input-group-btn">
			<button type="submit" class="btn btn-primary">{'Search'|@lang}</button>
		</div>
		</div>
		<!--</div>-->
	</div>
</form>

<script type="text/javascript">
$(document).ready(function(){
        $('input[role=date]').datepicker({
            format: "yyyy-mm-dd",
            language: "zh-CN",
            weekStart: 1,
            saysOfWeekHighlighted: "0,6",
            autoclose: true,
            todayHighlight: true
        });
    }   
);
</script>
