<?php
//    print_r($this->session->userdata('sess_dept'));

    if( $this->session->userdata('sess_dept') <= 2 ){
?>
<div class="row aaidashboard">
	<div class="medium-5 medium-centered large-5 columns large-centered" style="margin-top: 7%;">
		<ul class="tabs" data-tab role="tablist">
			<li class="tab-title active" role="presentation"><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1">Internal</a></li>
			<li class="tab-title" role="presentation" style="margin-left: 40px;"><a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2">External</a></li>
		</ul>
	</div>
</div>
<div class="row aaidashboard">
	<div class="large-12 columns">
		<div class="tabs-content">
			<section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
				<ul class="button-group even-3">
					<li><a href="<?=base_url('jo?id='.$this->session->userdata('sess_id'))?>" class="button text-left"><span><img src="<?=base_url('assets/img/logos/JO.png');?>" /></span>Job Order</a></li>
					<li><a href="<?=base_url('jo/production')?>" class="button text-left"><span><img src="<?=base_url('assets/img/logos/Prod.png');?>" /></span>Production</a></li>					
					<li>
						<a href="<?=base_url('jo/mvrf')?>" class="button text-left" style="line-height: 0px;">
							<div class="large-2 columns" style="padding: 0;">
								<img style="max-width: 49px;" src="<?=base_url('assets/img/logos/Vehicle.png');?>" />
							</div>
							<div class="large-10 columns">
								<p style="margin: 0;line-height: 18px;">Manpower / Vehicle Request Form</p>
							</div>
						</a>
					</li>
					<li><a href="<?=base_url('jo/setup')?>" class="button text-left"><span><img style="max-width: 47px;" src="<?=base_url('assets/img/logos/Set Up.png');?>" /></span>Set Up</a></li>
					<li><a href="<?=base_url('jo/activations')?>" class="button text-left"><span><img style="max-width: 40px;" src="<?=base_url('assets/img/logos/activations.png');?>" /></span>Activations</a></li>
					<li><a href="<?=base_url('jo/instore')?>" class="button text-left"><span><img src="<?=base_url('assets/img/logos/Instore.png');?>" /></span>In Store</a></li>
					<?php
//					if( $this->session->userdata('sess_dept') == 3 || $this->session->userdata('sess_dept') == 1 ){ // for accounting and admin only
					if( $this->session->userdata('sess_dept') <= 3 ){
					?>
						<li><a href="<?=base_url('jo/accounts')?>" class="button text-left"><span><img style="max-width: 32px;" src="<?=base_url('assets/img/logos/accounting.png');?>" /></span>Accounts</a></li>
					<?php
					}
					?>
					<li><a href="<?=base_url('')?>" class="button text-left"><span><img style="max-width: 40px;" src="<?=base_url('assets/img/logos/Completed.png');?>" /></span>Completed Job Orders</a></li>
				</ul>
			</section>
			<section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
				<div class="large-10 columns large-centered">
					<ul class="button-group even-2">
						<li><a href="<?=base_url('jo/motm')?>" class="button text-left"><span><img src="<?=base_url('assets/img/logos/Minutes.png');?>" /></span>Minutes of the meeting</a></li>
						<li><a href="<?=base_url('jo/bd')?>" class="button text-left"><span><img src="<?=base_url('assets/img/logos/Bid.png');?>" /></span>Bid Deck</a></li>					
						<li>
							<a href="<?=base_url('jo/ppld')?>" class="button text-left" style="line-height: 0px;">
								<div class="large-2 columns" style="padding: 0;">
									<img style="max-width: 49px;" src="<?=base_url('assets/img/logos/Logistics.png');?>" />
								</div>
								<div class="large-10 columns">
									<p style="margin: 0;line-height: 18px;">Pre Prod and Logistics Deck</p>
								</div>
							</a>
						</li>
						<li><a href="<?=base_url('jo/wrd')?>" class="button text-left"><span><img style="max-width: 36px;" src="<?=base_url('assets/img/logos/Weekly Report.png');?>" /></span>Weekly Report Deck</a></li>
						<li><a href="<?=base_url('jo/iped')?>" class="button text-left"><span><img style="max-width: 40px;" src="<?=base_url('assets/img/logos/Initial Eval.png');?>" /></span>Initial Post Evaluation Deck</a></li>
						<li><a href="<?=base_url('jo/fped')?>" class="button text-left"><span><img src="<?=base_url('assets/img/logos/Final Eval.png');?>" /></span>Final Post Evaluation Deck</a></li>					
					</ul>
				</div>
			</section>
		</div>
	</div>
</div>

<?php
    }elseif( $this->session->userdata('sess_dept') == '10' ){
?>
    <div class="row">
        <div class="column large-9 medium-9 small-9 dash_col">
            <?=$calendar?>
        </div>
		<div class="column large-3 medium-3 small-3 dash_col scrollable_area">
			<a href="<?=base_url('jo?id='.$this->session->userdata('sess_id'))?>" class="dash_button button round hide-for-large-down	">Job Order</a>
			<ul class="no-bullet" id="jo_table_list">
				<?php
				$c = '';
				$b = '';

				foreach( $jo_list as $row) {

					$query_company = $this->db->get_where('clients', array('client_id' => $row['client_company_name']));
					$row_company = $query_company->row();
					if (isset($row_company)) {
						$c = $row_company->company_name;
					}
					?>
					<li class="jolist mb_jolist jo-item-<?php echo $row['jo_id']; ?>" alt="<?php echo $row['jo_id']; ?>" >
						<div class="small-12 medium-12 large-12 columns">
							<h6 class="jolist_crea"><?php echo '<a href="'.base_url('jo/in?a=').$row['jo_id'].'" style="color:'.$row['jo_color'].';">'.$row['project_name'].'</a>'; ?></h6>
							<h6 class="jolist_crea"><?php echo '<a href="'.base_url('jo/in?a=').$row['jo_id'].'">JO NO.'.$row['jo_number'].'</a>'; ?></h6>
							<h6 class="jolist_crea"><?php echo $row['date_created']; ?></h6>
						</div>
<!--						<div class="small-6 medium-6 large-6 columns text-right" style="padding: 12px;display:none;">-->
<!--							<ul class="inline-list jorightlist right">-->
<!--								--><?php
//								if( $this->session->userdata('sess_dept') <=2 ){
//									?>
<!--									<li><a class="edit_load_jo" data-reveal-id="edit_joModal" alt="--><?php //echo $row['jo_id']; ?><!--"><img src="--><?php //echo base_url('assets/img/logos/Edit.png');?><!--" /></a></li>-->
<!--									--><?php
//								}
//								?>
<!--							</ul>-->
<!--							<div class="large-12 columns text-right" style="padding-right: 30px;">-->
<!--								<p style="margin-top: 10px;">--><?php //echo $row['project_type']; ?><!--</p>-->
<!--								<p>--><?php //echo $c; ?><!--</p>-->
<!--								<p>--><?php //echo isset($row['brand']) ? $row['brand']:'No Value'; ?><!--</p>-->
<!--								<p>DO: --><?php //echo isset($row['do_contract_no']) ? $row['do_contract_no']:'No Value'; ?><!--</p>-->
<!--								<p>Billed: --><?php //echo isset($row['billed_date']) ? $row['billed_date']:'No Value'; ?><!--</p>-->
<!--								<p>Paid: --><?php //echo isset($row['paid_date']) ? $row['paid_date']:'No Value'; ?><!--</p>-->
<!--							</div>-->
<!--						</div>-->
						<div class="clearfix"></div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
    </div>
<?php
    }
?>
