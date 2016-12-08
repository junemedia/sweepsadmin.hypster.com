<?php
include_once(CONFIG_DIR."config.php");
?>
<div class="criteria" style="float: left; padding: 10px 0; width: 650px;">
	<div class="daterange">
		Date Range:<?php echo $specFromDate.' ~ '.$specToDate;?> 
	</div>
	<div class="filter_info">
		<?php echo $filterInfo.' ('.$total.' total)';?>
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
		<!--<input type="hidden" name="specDate" value="<?php echo $specDate;?>"/>-->
		<input type="hidden" name="specFromDate" value="<?php echo $specFromDate;?>"/>
		<input type="hidden" name="specToDate" value="<?php echo $specToDate;?>"/>
		<input type="hidden" name="template" value="<?php echo $template;?>"/>
	</form>
</div>
<div class="report_details">
<?php if($reportType ==1){?>
	<table class="result_table" style="width:100%;">
		<thead>
			<tr>
				<th width="25%">Prize Name</th>
				<th width="9%">Email Address</th>
				<th width="14%">Registered Date</th>
				<th width="9%">Date</th>
				<th width="7%">Time</th>
				<th width="10%">Site</th>
				<th width="15%">Current Winner</th>
			</tr>
		</thead>
		<tbody>
		<?php 
			$i = 1;
			foreach($items as $item)
			{
		?>
			<tr>
				<?php /*if($i==1){?>					
					<td><?php echo utf8_encode($item['prizeName']);?></td>
				<?php }else
				{?>
					<td></td>
				<?php }*/?>
				<td><?php echo utf8_encode($item['prizeName']);?></td>
				<td><?php echo $item['email'];?></td>
				<td><?php echo $item['date_registered'];?></td>
				<td><?php echo $item['date'];?></td>
				<td><?php echo $item['time'];?></td>
				<td><?php echo $item['fromSite'];?></td>
				<td><?php echo $item['isWinner'];?></td>
			</tr>
		<?php 	$i++;}?>
		</tbody>
	</table>
	<?php }?>
</div>