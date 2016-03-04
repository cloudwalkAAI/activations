<?php
	$info = json_decode($jo_details);
?>
<div class="row fullwidth jo-in" style="height:100%;">
	<div class="large-3 columns jo-sidebar text-center">
		<div class="img-cropper">
			<img class="img-responsive" src="<?= base_url( 'assets/img/profile/'.$info->emp_info[0]->img_loc ) ?>" onError="this.onerror=null;this.src='<?= base_url( 'assets/img/profile/default.jpg' ) ?>';" alt="">		
		</div>
		<?php
            echo '<h3>'.$info->emp_info[0]->sur_name.', '.$info->emp_info[0]->first_name.' '.$info->emp_info[0]->middle_name.'</h3>';
        ?>
		<!--<h6>Position</h6>-->
		<div class="large-12 columns details">
			<h4>JOB ORDER DETAILS</h4>
			<hr/>
			<div class="large-10 columns large-centered text-left">
				<h5>Date Created</h5>
				<h6><?= $info->date_created ?></h6>
				<h5>Job Order No</h5>
				<h6><?= $info->jo_number ?></h6>
				<h5>Project Name</h5>
				<h6><?= $info->project_name ?></h6>
				<h5>Project Type</h5>
				<h6><?= $info->project_type ?></h6>
				<h5>Client</h5>
				<h6><?= $info->client_company_name ?></h6>
				<h5>Brand</h5>
				<h6><?= $info->brand ?></h6>				
				<h5>DO/Contract Date</h5>
				<h6> 
				<?php
					if( $info->do_contract_no == '' ){
						echo 'pending';
					}else{
						echo $info->do_contract_no;
					}
				?>
				</h6>
				<h5>Billed Date</h5>
				<h6>
					<?php
						if( $info->billed_date == '' ){
							echo 'pending';
						}else{
							echo $info->billed_date;
						}
					?>
				</h6>
				<h5>Paid Date</h5>
				<h6>
					<?php
                if( $info->paid_date == '' ){
                    echo 'pending';
                }else{
                    echo $info->paid_date;
                }
            ?>
				</h6>
			</div>
		</div>
	</div>
	<div class="large-9 columns jo-maincontent">
		<div class="row">
			<div class="large-12 columns">
				<a href="#" style="margin-top: 9px;" id="pdf_selector" data-reveal-id="modal_pdf_selector" class="button tiny right">Print</a>
			</div>
		</div>
		<div id="modal_pdf_selector" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
			<input type="hidden" id="jid" name="jid" value="<?=$this->input->get('a');?>">
			<a href="<?=base_url('jo/mpdf?jid='.$this->input->get('a'))?>" id="pdf-btn" target="_blank" href="">Save and Print PDF</a>
		</div>
		<ul class="accordion" data-accordion>
			<li class="accordion-navigation acd">
				<a href="#panel1a">Minutes of the Meeting<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="panel1a" class="content">
					<?= $mom ?>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#panel2a">Event Details<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="panel2a" class="content">
					<?= $event_details ?>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#accordion_emp_task">Tasks assignment<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="accordion_emp_task" class="content">
					<?= $emp_task ?>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#panel3a">Project Attachments<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="panel3a" class="content">
					<?= $project_attachments ?>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#panel4a">Set Up Details<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="panel4a" class="content">
					<?= $setup_details ?>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#panel5a">Man Power and Vehicle Request Form<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="panel5a" class="content">
					<?= $mvrf_view ?>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#accordion_references">References<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="accordion_references" class="content">
					<?= $reference ?>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#accordion_other">Others<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="accordion_other" class="content">
					<?php
						$other = json_decode($other_details);
					?>

					<div id="alert_box_oth" data-alert class="alert-box alert radius hide-normal">
						Special characters are not allowed
						<a href="#" class="close">&times;</a>
					</div>
					<form id="other_form" action="" method="post">
						<input type="hidden" name="otherid" value="<?=$this->input->get('a')?>">
						<textarea name="ta_Other" id="ta_Other" cols="30" rows="10" <?=$this->session->userdata('sess_dept') > '2' ? 'disabled' : '';?>><?=isset($other->texts) ? $other->texts : '';?></textarea>
						<button id="btn_other_submit" type="button" <?=$this->session->userdata('sess_dept') > '2' ? 'style="display:none;"' : '';?>>Save</button>
					</form>
				</div>
			</li>
			<li class="accordion-navigation acd">
				<a href="#accordion_comment">Comments<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
				<div id="accordion_comment" class="content">
					<?= $comments ?>
				</div>
			</li>
		</ul>
	</div>
</div>