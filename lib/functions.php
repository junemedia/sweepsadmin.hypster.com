<?php
function getPrizeEntries($params,&$total)
{
	if((isset($params['specFromDate']) && $params['specFromDate'] != '') && (isset($params['specToDate']) && $params['specToDate'] != ''))
	{
		//$where = "where c.date = '".$params['specDate']."' ";
		$order = ' ORDER BY u.email';
		$where = " where c.date BETWEEN '".$params['specFromDate']."' and '".$params['specToDate']."' ";
		if(isset($params['fromsite']) && (int)$params['fromsite']!=0 )
		{
			$where .= " AND e.site_id=".$params['fromsite'];
		}
		$query = "select c.date,e.time,p.title as prizeName,DATE_FORMAT(u.date_registered, '%Y-%m-%d') as date_registered,u.email,u.firstname,u.lastname,s.name as fromSite,case when c.winner_user_id=e.user_id then 'Winner' else '' end as isWinner
		from contest as c 
		left join prize as p on p.id=c.prize_id
		left join entry as e on c.date = e.date 
		left join user as u on e.user_id=u.id 
		left join site as s on e.site_id = s.id ".$where.$order;
		$result = mysql_query($query);
		$total = mysql_num_rows($result);
		$entries = '';
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			$entries[] = $row;
		}
		/*echo "<pre>";
		print_r($entries);
		echo "</pre>";exit;*/
		return $entries;
		//return false;
	}
	else
	{
		return false;
	}	
}

function getPrizeWinners($params,&$total)
{
	if((isset($params['from']) && $params['from'] != '') && (isset($params['to']) && $params['to'] != ''))
	{
		$query = "select c.date,p.title as prizeName,u.email,u.firstname,u.lastname,s.name as fromSite from contest as c 
		left join prize as p on p.id=c.prize_id 
		left join user as u on c.winner_user_id=u.id 
		left join site as s on c.winner_site_id = s.id 
		where c.date between '".$params['from']."' and '".$params['to']."'";

		$result = mysql_query($query);
		$total = mysql_num_rows($result);
		$winners = '';
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			$winners[] = $row;
		}
		/*echo "<pre>";
		print_r($winners);
		echo "</pre>";exit;*/
		return $winners;
		//return false;
	}
	else
	{
		return false;
	}
}

function getPrizeRegisters($params,&$total)
{
	if((isset($params['regfrom']) && $params['regfrom'] != '') && (isset($params['regto']) && $params['regto'] != ''))
	{
		$where = " where DATE_FORMAT(u.date_registered, '%Y-%m-%d') BETWEEN '".$params['regfrom']."' and '".$params['regto']."' ";
		if(isset($params['fromsite']) && (int)$params['fromsite']!=0 )
		{
			$where .= " AND u.site_id=".$params['fromsite'];
		}
		$query = "select DATE_FORMAT(u.date_registered, '%Y-%m-%d') as date,s.name as fromSite,u.email,u.verified,u.firstname,u.lastname,u.address,u.state,u.zip  
		from user as u left join site as s on s.id=u.site_id ".$where; 

		$result = mysql_query($query);
		$total = mysql_num_rows($result);
		$registers = '';
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			$registers[] = $row;
		}
		/*echo "<pre>";
		print_r($registers);
		echo "</pre>";exit;*/
		return $registers;
		//return false;
	}
	else
	{
		return false;
	}
}

function exportCSV($data,$type,$filepath)
{
	if(!empty($data))
	{
		if (!$handle = fopen($filepath, 'w')) {
			 echo "Cannot open file ($filepath)";
		}
		if($type == 1)
		{
			$header = "Prize Name,Email Address,Registered Date,Date,Time,Site,Current Winner\n";  
			fwrite($handle,$header);
		
			foreach($data as $row)
			{
				$csvValue = '"'.strip_tags($row['prizeName'])."\",\"".$row['email']."\",".$row['date_registered'].",".$row['date'].",".$row['time'].",".$row['fromSite'].",".$row['isWinner']."\n";
				fwrite($handle,$csvValue);
			}
		}
		
		if($type == 2)
		{
			$header = "Date,Prize Name,Winner Email,WinnerName\n";  
			fwrite($handle,$header);
		
			foreach($data as $row)
			{
				$csvValue = $row['date'].",\"".strip_tags($row['prizeName'])."\",\"".$row['email']."\",\"".$row['firstname'].' '.$row['lastname']."\"\n";
				fwrite($handle,$csvValue);
			}
		}
		
		if($type == 3)
		{
			$header = "Date,Site,Email Address,Verified,First Name,Last Name,Address,State,Zipcode\n";  
			fwrite($handle,$header);
		
			foreach($data as $row)
			{
				$verified = $row['verified']?'Y':'N';
				$csvValue = $row['date'].",".$row['fromSite'].",\"".$row['email']."\",\"".$verified."\",\"".$row['firstname']."\",\"".$row['lastname']."\",\"".$row['address']."\",".$row['state'].",".$row['zip']."\n";
				fwrite($handle,$csvValue);
			}
		}
		
		
		fclose($handle);		
	}else
	{
		return false;
	}
}

function searchEmails($search)
{
	if(!empty($search))
	{
		$query = "select u.id,u.email,u.verified 
		from user as u
		where u.email like '%".$search."%'";

		$result = mysql_query($query);
		$total = mysql_num_rows($result);
		$searchResult = '';
		while($row = mysql_fetch_array($result,MYSQL_ASSOC))
		{
			$searchResult[] = $row;
		}
		/*echo "<pre>";
		print_r($searchResult);
		echo "</pre>";exit;*/
		return $searchResult;
		//return false;
	}
	else
	{
		return false;
	}
}

function updateUser($userid,$data)
{
	if(!empty($userid) && !empty($data))
	{
		$query = "UPDATE user SET firstname='".$data['firstname'].
				"',lastname='".$data['lastname'].
				"',address='".$data['address'].
				"',zip='".$data['zip'].
				"',city='".$data['city'].
				"',state='".$data['state'].
				"',email='".$data['email'].
				"' WHERE id=".$userid;

		$result = mysql_query($query);
		/*echo "<pre>";
		print_r($registers);
		echo "</pre>";exit;*/
		return $result;
		//return false;
	}
	else
	{
		return false;
	}
}

function getUser($id)
{
	if(!empty($id))
	{
		$query = "select u.id,u.email,u.verified,u.firstname,u.lastname,u.address,u.state,u.city,u.zip  
		from user as u
		where u.id=".$id;

		$result = mysql_query($query);
		$total = mysql_num_rows($result);
		$user = mysql_fetch_array($result,MYSQL_ASSOC);
		/*echo "<pre>";
		print_r($registers);
		echo "</pre>";exit;*/
		return $user;
		//return false;
	}
	else
	{
		return false;
	}
}

function checkUser($email)
{
	if(!empty($email))
	{
		$query = "select u.id,u.email,u.firstname,u.lastname,u.address,u.state,u.zip  
		from user as u
		where u.email='".trim($email)."'";

		$result = mysql_query($query);
		$total = mysql_num_rows($result);
		$user = mysql_fetch_array($result,MYSQL_ASSOC);
		/*echo "<pre>";
		print_r($registers);
		echo "</pre>";exit;*/
		return $user;
		//return false;
	}
	else
	{
		return false;
	}
}

function lookup($q)
{
	$url = 'http://resolute.com/geo.json?q=';
    $ch  = null;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($ch, CURLOPT_URL, $url . $q);
	return json_decode(curl_exec($ch), true);
}

function getAllSites()
{
	$query = "select s.id,s.name 
		from site as s";

	$result = mysql_query($query);
	$siteResult = '';
	while($row = mysql_fetch_array($result,MYSQL_ASSOC))
	{
		$siteResult[] = $row;
	}
	return $siteResult;
}
?>