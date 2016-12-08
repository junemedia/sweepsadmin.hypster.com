<?php
include_once(CONFIG_DIR."config.php");
include_once(LIB_DIR."functions.php");

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

$user = '';
$data = '';
$message = '';

while(list($key,$val) = each($_POST)) 
{ 
	$$key = $val;
	if(strtolower($key) != 'submit')
	{
		$data[strtolower($key)] = $val;
	}
}
while(list($key,$val) = each($_GET)) 
{ 
	$$key = $val;
}

if($userid)
{
	$user = getUser($userid);
}

if(strtolower($submit)=='update')
{
	$result = false;
	if($user['email'] != trim($data['email']) && checkUser($data['email']))
	{
		$message = "<font style='color:red'>The email address already exist.</font>";

	}else
	{
		$geo = lookup($data['zip']);
		if(!@$geo || !@$geo['city'] || !@$geo['state'])
		{
			$message = "<font style='color:red'>Invalid Zip Code.</font>";			
		}else
		{
			$data['city'] = $geo['city'];
			$data['state'] = $geo['state'];
			$result = updateUser($userid,$data);
		}
	}
	
	if($result)
	{
		$user = getUser($userid);
		$message = "<font style='color:green'>User Updated.</font>";
	}
}

?>


<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit register user</title>
<link rel="stylesheet" href="../../assets/css/report.css">
<script src="../../assets/js/jquery.min.js"></script>
</head>
<body>
<div class="main">
	<div class="top_btn">
		<div class="back_btn"><a href="?m=update">Back</a></div>
	</div><br>
	<div class="search">
		<form action="?m=update" method="post" class="search_input" id="search_form">
			Email: <input type="text" name="search" id="search" size="30" />&nbsp;&nbsp;&nbsp;<input type="submit" value="Search" name="searchBtn"> 
		</form>
	</div>	
	<?php if($user){?>
	<div class="update_form">
		<form action="" method="post" class="signup profile" id="signup_form">
			<fieldset class="profile">
				<label class="req" for="firstname">First Name</label>
				<input type="text" id="firstname" name="firstname" value="<?php echo $user['firstname'];?>">
				<label class="req" for="lastname">Last Name</label>
				<input type="text" id="firstname" name="lastname" value="<?php echo $user['lastname'];?>">
				<label class="req" for="address">Street Address</label>
				<input type="text" id="address" name="address" value="<?php echo $user['address'];?>">
				<label class="req" for="zip">Zip Code</label>
				<input type="text" id="zip" name="zip" value="<?php echo $user['zip'].' ('.$user['city'].', '.$user['state'].')';?>" onkeyup="checkZip(this);" onclick="this.select();" maxlength="5" />
			</fieldset>
			<fieldset class="credentials">
				<label class="req" for="email">Email<?php echo $user['verified']?' (Verified)':'';?></label>
				<input type="text" id="email" name="email" value="<?php echo $user['email'];?>">
			</fieldset>
			<fieldset class="submit">
				<input type="submit" value="Update" name="submit"><span class="loader"></span>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?m=update">cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;<div class="alert" style="float: right;text-align: left;width: 300px;"><?php echo $message;?></div>
			</fieldset>
		</form>
	</div>
	<?php } else{echo "Please select one user first.";}?>
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
	function checkZip(obj)
	{
		obj.value=obj.value.replace(/[^0-9]+/,'');
	}
	
	function checkZipValue(obj,value)
	{
		if(obj.value=='')
		{
			obj.value=value;
		}		
	}
</script>
</body>
</html>