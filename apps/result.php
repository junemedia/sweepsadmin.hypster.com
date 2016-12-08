<?php
include_once(CONFIG_DIR."config.php");
include_once(LIB_DIR."functions.php");

/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/

$time = '';//date("YmdHms");
$filename='nofile';
$title = '';
$csvValues = '';
$filterInfo = '';
$params = '';

while(list($key,$val) = each($_POST)) 
{ 
	$$key = strtolower($val);
	$params[$key] = strtolower($val);
}

if($submit=='submit')
{	
	if($reportType ==1)
	{
		$title="Prize Entries By Date";
		$filterInfo = "All Entries of the prize at this date: ";
	}else if($reportType==2)
	{	
		$title="Export Of Total Winners";
		$filterInfo = "All Winners within this date range: ";
	}
	else if($reportType==3)
	{	
		$title="List Of Registered Users";
		$filterInfo = "All Registered Users within this date range: ";
	}
	
	$method = 'getPrize'.ucfirst($template); 
	$total = 0;
	$items = $method($params,$total);
	$templates = TEMPLATES_DIR.'prize'.ucfirst($template).".php";
	$filepath = DOWNLOAD_DIR.$title.$time.".csv";
	$filename = $title.$time.".csv";
	
	$result = exportCSV($items,$reportType,$filepath);
}
else
{
	echo "No results to show.";
	exit;
}
?>


<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title;?></title>
<link rel="stylesheet" href="../assets/css/report.css">
<script src="../assets/js/jquery.min.js"></script>
</head>
<body>
<div class="main">
	<div class="top_btn">
		<div class="back_btn"><a href="/">Back</a></div>
		<div class="function_btn"><a href="<?php echo 'download/'.$filename;?>" id="download" download="<?php echo $filename;?>">Export</a> | <a href="#" onclick="window.print();">Print</a></div>
	</div>
	<div class="result_content">
		<div class="result_title">
		<?php echo $title;?>
		</div>
		<?php include_once($templates);?>
	</div>
</div>
<script>  
   /* function clickDownload(aLink)  
    {  
         var head = "Subcamp ID ,Description,Total Sent,Total Opens,Total Clicks\n";  
		 var values = "<?php echo $csvValues;?>";		
		 var str = head+values;
		 var blob = new Blob([str], { type: 'text/csv' }); //new way 
         str =  encodeURIComponent(str);  
         aLink.href = "data:text/csv;charset=utf-8,"+str;  
		   
		var csvUrl = URL.createObjectURL(blob);  
		document.getElementById("download").href = csvUrl;  
    }  */
</script>
</body>
</html>