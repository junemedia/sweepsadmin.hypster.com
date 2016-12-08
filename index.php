<?php
include_once("config/config.php");
include_once("config/router.php");
include_once("lib/functions.php");

if(isset($_GET['m']) && trim($_GET['m'])!= '' && array_key_exists(trim($_GET['m']), $routers)){
    $module = $routers[trim($_GET['m'])];
	include(APPS . $module . '.php');
}
else{
    $module = 'index';

?>

<html lang="en">
<head>
<meta charset="utf-8">
<title>Sweeps Prize Reports</title>
<link rel="stylesheet" href="assets/css/jquery-ui.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/report.css">
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script>
$(function() {
	$( "#from" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: new Date(),
		changeMonth: false,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#to" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+2D",
		changeMonth: false,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});

	$( "#from" ).datepicker("setDate","-5");
	$( "#to" ).datepicker("setDate","0");
	
	$( "#specFromDate" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: new Date(),
		changeMonth: false,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#specToDate" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#specToDate" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+2D",
		changeMonth: false,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#specFromDate" ).datepicker( "option", "maxDate", selectedDate );
		}
	});

	$( "#specFromDate" ).datepicker("setDate","-5");
	$( "#specToDate" ).datepicker("setDate","0");
	
	$("#reportType").val(1);
	$("#template").val("entries");
	
	$( "#regfrom" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: new Date(),
		changeMonth: false,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#regto" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#regto" ).datepicker({
		dateFormat: "yy-mm-dd",
		defaultDate: "+2D",
		changeMonth: false,
		numberOfMonths: 1,
		onClose: function( selectedDate ) {
			$( "#regfrom" ).datepicker( "option", "maxDate", selectedDate );
		}
	});

	$( "#regfrom" ).datepicker("setDate","-5");
	$( "#regto" ).datepicker("setDate","0");
	
	$('#reportType').change(function(){
		var p=$(this).children('option:selected').val();
		if(p==4){
			window.location.href="?m=update";
		}
	});
});
</script>

<script>
function selectChange(obj)
{
	if(obj.value==1)
	{
		$("#entries_report").show();
		$("#winners_report").hide();
		$("#register_report").hide();
		$("#edit_register").hide();
		$("#template").val("entries");
		$(".submit").show();
	}else if(obj.value==2)
	{
		$("#entries_report").hide(); 
		$("#winners_report").show();		
		$("#edit_register").hide();
		$("#register_report").hide();
		$("#template").val("winners");
		$(".submit").show();
	}
	else if(obj.value==3)
	{
		$("#entries_report").hide(); 
		$("#winners_report").hide();
		$("#edit_register").hide();
		$("#register_report").show();
		$("#template").val("registers");
		$(".submit").show();
	}
	else if(obj.value==4)
	{
		$("#entries_report").hide(); 
		$("#winners_report").hide();
		$("#register_report").hide();
		//$("#edit_register").show();
		$(".submit").hide();
	}
	else
	{
		alert("Please select the report type!");
	}
}
function checkForm()
{
	if($('#reportType').val()==1)
	{
		var dateVal = $( "#specToDate" ).val();
		if(dateVal=='')
		{
			alert("Please choose a specific date!");
			return false;
		}
	}
}
</script>
</head>
<body>
<div class="main">
	<form id="report_form" name="report_form" action="?m=result" method="POST" onsubmit="return checkForm();">
		<div class="report_type">
			Report Type:
			<select name="reportType" id="reportType" class="select" onChange="selectChange(this);return false;">
				<option class="option" value="1" selected>Prize Entries By Date</option>
				<option class="option" value="2">Export Of Total Winners</option>
				<option class="option" value="3">Export Of Registered Users</option>
				<option class="option" value="4">Edit Registered Users</option>
			</select>
		</div>
		<div class="report_content">
			<div id="edit_register" style="display:none;"><a id="edit_link" href="?m=update">Click here to edit users.</a></div>
			<div id="winners_report">			
				<div class="date_range">
					<label for="from" class="label">Start Date:</label>
					<input type="text" id="from" name="from" class="text" />&nbsp;&nbsp;&nbsp;
					<label for="to" class="label">End Date:</label>
					<input type="text" id="to" name="to" class="text" />
				</div>
				<div class="filters">	
				</div>
			</div>
			<div id="entries_report">	
				<div class="date_range">
					<label for="specFromDate" class="label">Start Date:</label>
					<input type="text" id="specFromDate" name="specFromDate" class="text" />&nbsp;&nbsp;&nbsp;
					<label for="specToDate" class="label">End Date:</label>
					<input type="text" id="specToDate" name="specToDate" class="text" />
				</div>
				<div class="filters">						
				</div>
			</div>	
			<div id="register_report" style="display:none;">	
				<div class="date_range">
					<label for="regfrom" class="label">Start Date:</label>
					<input type="text" id="regfrom" name="regfrom" class="text" />&nbsp;&nbsp;&nbsp;
					<label for="regto" class="label">End Date:</label>
					<input type="text" id="regto" name="regto" class="text" />
				</div>
				<div class="filters">	
				</div>
			</div>				
		</div>	
		
		<div class="submit">
			<input type="hidden" id="template" name="template" value="" />
			<input type="submit" name="submit" value="Submit" class="button"/>
		</div>
	</form>
	
</div>
</body>
</html>
<?php }?>