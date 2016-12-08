<?php
include_once(CONFIG_DIR."config.php");
?>
<div class="criteria">
	<div class="daterange">
		Date Range:<?php echo $from.' ~ '.$to;?> 
	</div>
	<div class="filter_info">
		<?php echo $filterInfo;?>
	</div>
</div>
<div class="report_details">
<?php if($reportType ==2){?>
	<table class="result_table">
		<thead>
			<tr>
				<th width="10%">Date</th>
				<th>Prize Name</th>
				<th>Winner Email</th>	
				<th>Winner Name</th>				
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach($items as $item)
			{
		?>
			<tr>
				<td><?php echo $item['date'];?></td>
				<td><?php echo utf8_encode($item['prizeName']);?></td>
				<td><?php echo $item['email'];?></td>
				<td><?php echo $item['firstname'].' '.$item['lastname'];?></td>
			</tr>
		<?php 	}?>
		</tbody>		
	</table>
	<?php }?>
</div>