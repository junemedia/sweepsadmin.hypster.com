<?php
include_once(CONFIG_DIR."config.php");
include_once(LIB_DIR."functions.php");

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/
$items = '';

while(list($key,$val) = each($_POST)) 
{ 
	$$key = strtolower($val);
}

if($searchBtn=='search')
{
	$items = searchEmails($search);
}
?>


<html lang="en">
<head>
<meta charset="utf-8">
<title>Search register user to update</title>
<link rel="stylesheet" href="../../assets/css/report.css">
<script src="../../assets/js/jquery.min.js"></script>
</head>
<body>
<div class="main">
	<div class="top_btn">
		<div class="back_btn"><a href="/">Back</a></div>
	</div><br>
	<div class="search">
		<form action="?m=update" method="post" class="search_input" id="search_form">
			Email: <input type="text" name="search" id="search" size="30" />&nbsp;&nbsp;&nbsp;<input type="submit" name="searchBtn" value="Search">
		</form>
	</div>
	<div class="result_content">		
		<div class="result_title">
			<ul style="list-style:none;margin:0;text-align:left;">
			<?php if(!empty($items)){
					foreach($items as $item){?>
				<li><a href="?m=edit&userid=<?php echo $item['id']; ?>"><?php echo $item['email'];?></a><?php echo $item['verified']?' (Verified)':'';?></li>
			<?php }}?>
			</ul>
		</div>
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