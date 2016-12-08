<?php
include_once(CONFIG_DIR."config.php");
?>
<div class="criteria" style="float: left; padding: 10px 0; width: 650px;">
	<div class="daterange">
		Date Range:<?php echo $regfrom.' ~ '.$regto;?> 
	</div>
	<div class="filter_info">
		<?php echo $filterInfo.' ('.($total?$total.' total':'No users').')';?>
	</div>
</div>
<script>
function submitForm()
{
	$("#site_submit").click();
}
</script>
<div class="filter_section">
	<form id="site_form" name="site_form" action="?m=result" method="POST">
		From:
		<select name="fromsite" id="fromsite" class="select" onChange="submitForm();">
			<option class="option" value="0" <?php echo $fromsite?'':'selected="true"';?>>ALL</option>
			<?php $sites = getAllSites();
				if(!empty($sites))
				{
					foreach($sites as $site)
					{
			?>
			<option class="option" value="<?php echo $site['id'];?>" <?php echo $fromsite==$site['id']?'selected="true"':'';?>><?php echo $site['name'];?></option>
			<?php }
				}?>
		</select>
		<input type="submit" id="site_submit" name="submit" value="Submit" style="display:none;"/>
		<input type="hidden" name="reportType" value="<?php echo $reportType;?>"/>
		<input type="hidden" name="regfrom" value="<?php echo $regfrom;?>"/>
		<input type="hidden" name="regto" value="<?php echo $regto;?>"/>
		<input type="hidden" name="template" value="<?php echo $template;?>"/>
	</form>
</div>
<div class="report_details">
<?php if($reportType ==3){?>
	<table class="result_table" style="width:100%;">
		<thead>
			<tr>
				<th width="10%">Date</th>
				<th>Site</th>
				<th>Email Address</th>	
				<th>Verified</th>
				<th width="10%">First Name</th>
				<th width="10%">Last Name</th>
				<th>Address</th>
				<th width="5%">State</th>
				<th>Zipcode</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$i = 1;
			foreach($items as $item)
			{
		?>
			<tr>					
				<td><?php echo $item['date'];?></td>
				<td><?php echo $item['fromSite'];?></td>
				<td><?php echo $item['email'];?></td>
				<td><?php echo $item['verified']?'Y':'N';?></td>
				<td><?php echo $item['firstname'];?></td>
				<td><?php echo $item['lastname'];?></td>
				<td><?php echo $item['address'];?></td>
				<td><?php echo $item['state'];?></td>
				<td><?php echo $item['zip'];?></td>
			</tr>
		<?php 	$i++;}?>
		</tbody>
	</table>
	<?php }?>
</div>