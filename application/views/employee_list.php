<li class="jolist jo-item-<?php echo $row['id']; ?>" alt="<?php echo $row['id']; ?>">
	<div class="small-1 medium-2 large-2 columns text-center" style="padding-top: 35px;">
		<div class="img-cropper">
			<img class="img-responsive" src="<?= base_url( 'assets/img/profile/default.jpg' ) ?>" onError="this.onerror=null;this.src='<?= base_url( 'assets/img/profile/default.jpg' ) ?>';" alt="">		
		</div>
	</div>
	<div class="small-7 medium-6 large-6 columns" style="padding: 50px;padding-left: 0px;">
		<h3><?php echo ucfirst($row['first_name']).' '.ucfirst($row['sur_name']); ?></h3>
		<h5><?php echo '<a href="#">Employee NO.'.$row['emp_id'].'</a>'; ?></h5>
		<h6><?php echo ucfirst($dept_str); ?></h6>
		<h6><?php echo ucfirst($post_str); ?></h6>
	</div>
	<div class="small-5 medium-4 large-4 columns text-right" style="padding: 12px;">
		<ul class="inline-list jorightlist right">
			<li><a href="<?= base_url('emp/edit/'.$row['id']) ?>"><img src="<?php echo base_url('assets/img/logos/Edit.png');?>" /></a></li>
			<!--<li><a href="#"><img src="<?php //echo base_url('assets/img/logos/Delete.png');?>"/></a></li>-->
		</ul>
		<div class="large-12 columns text-right" style="padding-right: 30px;">
			<p style="margin-top: 10px;"><?php echo (strtolower($row['status']) == 'hired') ? 'Active (Regular)':$row['status']; ?></p>
			<p><?php echo $age; ?> Years Old</p>
			<p><?php echo isset($row['contact_nos']) ? $row['contact_nos']:'No Value'; ?></p>
			<p><?php echo isset($row['email']) ? $row['email']:'No Value'; ?></p>			
		</div>
	</div>
	<div class="clearfix"></div>
</li>