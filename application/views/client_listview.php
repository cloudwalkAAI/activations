<li class="jolist load_client cl-item-<?php echo $row['client_id']; ?>" alt="<?php echo $row['client_id']; ?>" >
	<div class="small-7 medium-8 large-8 columns" style="padding: 50px;">
		<h3><?php echo $row['company_name']; ?></h3>
		<h5><?php echo '<a href="#" alt="'.$row['client_id'].'">'.$row['contact_person'].'</a>'; ?></h5>
		<h6><?php echo $row['date_created']; ?></h6>
	</div>
	<div class="small-5 medium-4 large-4 columns text-right" style="padding: 12px;">
		<ul class="inline-list jorightlist right">
			<!--<li><a onclick="getJoId(this)"><img src="<?php //echo base_url('assets/img/logos/Edit.png');?>" /></a></li>-->
			<!--<li><a href="#"><img src="<?php //echo base_url('assets/img/logos/Delete.png');?>"/></a></li>-->
		</ul>
		<div class="large-12 columns text-right" style="padding-right: 30px;">
			<p style="margin-top: 41px;"><?php echo 'Client NO.'.str_pad( $row['client_id'], 6, "0", STR_PAD_LEFT ); ?></p>
			<p><?php echo $row['contact_number']; ?></p>
			<p><?php echo $row['email']; ?></p>
		</div>
	</div>
	<div class="clearfix"></div>
</li>