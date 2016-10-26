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
    }elseif( $this->session->userdata('sess_dept') == '7' ){
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
							<div class="clearfix"></div>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
<?php
	}elseif($this->session->userdata('sess_dept') == '6'){
?>
		<div style="padding: 10px;">
			<div class="column large-2 medium-2 small-12 x-content-scroller" style=" border: 1px solid; padding: 5px; border-radius:5px;">
				<div class="cmtuva_form">
					<h3 class="twidth text-center">Location</h3>
					<form id="cmtuva_form" action="" method="post" autocomplete="on">
						<label for="inp_category"><input type="text" class="radius" name="inp_category" id="inp_category" placeholder="Category"></label>
						<label for="inp_subcategory"><input type="text" class="radius" name="inp_subcategory" id="inp_subcategory" placeholder="Subcategory"></label>
						<label for="inp_venue"><input type="text" class="radius" name="inp_venue" id="inp_venue" placeholder="Venue"></label>
						<label for="inp_area"><textarea type="text" class="radius" name="inp_area" id="inp_area" placeholder="Area"></textarea></label>
						<label for="inp_street"><textarea type="text" class="radius" name="inp_street" id="inp_street" placeholder="Address"></textarea></label>
						<label for="inp_rates"><input type="number" class="radius txtboxToFilter" name="inp_rates" id="inp_rates" placeholder="Rates"></label>
						<label for="inp_eft"><input type="text" class="radius" name="inp_eft" id="inp_eft" placeholder="Estimated foot traffic"></label>
						<label for="inp_tarhits"><input type="text" class="radius" name="inp_tarhits" id="inp_tarhits" placeholder="Target hits"></label>
						<label for="inp_achits"><input type="text" class="radius" name="inp_achits" id="inp_achits" placeholder="Actual hits"></label>
						<label for="inp_lsm"><input type="text" class="radius" name="inp_lsm" id="inp_lsm" placeholder="LSM"></label>
						<label for="inp_cmremarks"><textarea type="text" class="radius" name="inp_cmremarks" id="inp_cmremarks" placeholder="Remarks"></textarea></label>
						<input type="file" name="inp_upload_cmtuva" id="inp_upload_cmtuva" accept="image/*">
						<a id="cmtuva_btn" href="#" class="button tiny twidth">Add</a>
					</form>
				</div>
			</div>
			<div class="column large-8 medium-8 small-12 x-content-scroller" style="overflow-x: scroll;">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <input type="search" class="radius" name="inp_search_cmtuva" id="inp_search_cmtuva" placeholder="Search">
                    </div>
                    <div class="column large-3 medium-3 small-12">
                        <select name="sel_cmtuva_category" id="sel_cmtuva_category">
                            <option value="0">Select Category</option>
                            <?php
                            $this->db->select('category'); // Select field
                            $this->db->from('cmtuva_location_list'); // from Table1
                            $this->db->group_by('category');
                            $query = $this->db->get();
                            foreach($query->result() as $row){
                                if( !empty($row->category) ){
                                    echo '<option value="'.$row->category.'">'.ucfirst($row->category).'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="column large-3 medium-3 small-12">
                        <select name="sel_cmtuva_sub_category" id="sel_cmtuva_sub_category" style="display:none;">
                            <option value="0">Select Category</option>
                        </select>
                    </div>
                </div>
				<table class="twidth" id="cmtuva_table">
					<thead>
						<tr>
							<th width="2">Venue</th>
							<th width="3">Area</th>
							<th width="3">Address</th>
							<th width="1">Rate</th>
							<th width="1">Estimated foot traffic</th>
							<th width="1">Target hits</th>
							<th width="1">Actual hits</th>
							<th width="1">LSM</th>
							<th width="1">Remarks</th>
							<th width="1">Images</th>
							<th width="1"> </th>
						</tr>
					</thead>
					<tbody id="cmtuva_tbody">
						<?php
							$query = $this->db->order_by('location_id', 'DESC')->get( 'cmtuva_location_list' );
							if($query->num_rows() > 0) {
								foreach ($query->result() as $row) {
									$preview = '';
									if( !empty($row->u_images) ){
										$preview = '<a href="'.$row->u_images.'" target="_blank">Preview</a>';
									}
									echo '
										<tr id="cmt_'.$row->location_id.'">
											<td>'.ucfirst( $row->venue ).'</td>
											<td>'.ucfirst( $row->area ).'</td>
											<td>'.ucfirst( $row->street ).'</td>
											<td>Php '.ucfirst( $row->rate ).'</td>
											<td>'.ucfirst( $row->eft ).'</td>
											<td>'.ucfirst( $row->target_hits ).'</td>
											<td>'.ucfirst( $row->actual_hits ).'</td>
											<td>'.ucfirst( $row->lsm ).'</td>
											<td>'.$row->remarks.'</td>
											<td>'.$preview.'</td>
											<td style="text-align:center;">
												<div class="column large-6 medium-6 small-6">
													<a class="edit-btn-cmtuva" href="#" alt="'.$row->location_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Edit.png").'" /></a>
												</div>
												<div class="column large-6 medium-6 small-6">
													<a class="del-btn-cmtuva" href="#" alt="'.$row->location_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Delete.png").'" /></a>
												</div>
											</td>
										</tr>
									';
								}
							}
						?>
					</tbody>
				</table>
			</div>

			<div class="column large-2 medium-2 small-12 text-right x-content-scroller">
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
							<div class="clearfix"></div>
						</li>
						<?php
					}
					?>
				</ul>
			</div>

			<div id="cmt_Modal" class="reveal-modal tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
				<h2 id="modalTitle" class="text-center">Update the information.</h2>

				<div id="alert_cmt" data-alert class="alert-box alert radius hide-normal">
					Special characters are not allowed
					<a href="#" class="close">&times;</a>
				</div>

				<form id="cmt_form" action="" method="post">
					<input type="hidden" class="radius" id="cmt_joid" name="cmt_joid" value="">
					<input type="text" class="radius" name="cmt_venue" id="cmt_venue" placeholder="Venue">
					<textarea name="cmt_area" id="cmt_area" cols="30" rows="3" placeholder="Area"></textarea>
					<textarea name="cmt_st" id="cmt_st" cols="30" rows="3" placeholder="Address"></textarea>
					<input type="number" class="radius txtboxToFilter" name="cmt_rate" id="cmt_rate" placeholder="Rate">
					<input type="number" class="radius" name="cmt_eft" id="cmt_eft" placeholder="Estimated foot traffic">
					<input type="text" class="radius" name="cmt_tarhits" id="cmt_tarhits" placeholder="Target hits">
					<input type="text" class="radius" name="cmt_achits" id="cmt_achits" placeholder="Actual hits">
					<input type="text" class="radius" name="cmt_lsm" id="cmt_lsm" placeholder="LSM">
					<input type="text" class="radius" name="cmt_rem" id="cmt_rem" placeholder="Remarks">
					<input type="file" name="cmt_upload_cmtuva" id="cmt_upload_cmtuva" accept="image/*">
					<img id="current_image" src="" alt="">
					<a href="#" id="btn_edit_cmt" class="button medium right" style="margin-top:5px;">Update</a>
				</form>

				<a class="close-reveal-modal" aria-label="Close">&#215;</a>
			</div>
		</div>
<?php
	}elseif($this->session->userdata('sess_dept') == '8'){
?>
		<div class="column large-2 medium-2 small-12 scrollable_area">
			<ul class="tabs vertical inv_tabs tbl_bdr" data-tab>
				<li class="tab-title active"><a class="tbl_bdr" href="#panel11">Current Item(s)</a></li>
				<li class="tab-title"><a class="tbl_bdr" href="#panel21">Add Item(s)</a></li>
				<li class="tab-title"><a class="tbl_bdr" href="#panel31">Deduct Item(s)</a></li>
				<li class="tab-title"><a class="tbl_bdr" href="#panel41">Returned Items(s)</a></li>
				<li class="tab-title"><a class="tbl_bdr" href="#panel51">Summary</a></li>
			</ul>
		</div>
		<div class="column large-8 medium-8 small-12 scrollable_area">
			<div class="tabs-content">
				<div class="content active" id="panel11">
					<input type="search" class="radius tbl_bdr" name="search_current_items" id="search_current_items" placeholder="Search">
					<table style="width:inherit;" class="tbl_bdr">
						<thead>
						<tr style="background-color:#ccccff;">
							<th style="text-align:center;">Code</th>
							<th style="text-align:center;">Name</th>
							<th style="text-align:center;">Description</th>
							<th style="text-align:center;">Quantity</th>
							<th style="text-align:center;">Expiration</th>
							<th style="text-align:center;">Date Stored</th>
						</tr>
						</thead>
						<tbody id="tbody_current">
						<?php
						$this->db->order_by("stock_id","desc");
						$query = $this->db->get('stocks');
						foreach ( $query->result() as $row ){
							echo '
								<tr id="ori'.$row->stock_id.'">
									<td>'.$row->item_code.'</td>
									<td>'.$row->item_name.'</td>
									<td>'.$row->description.'</td>
									<td>'.$row->qty.'</td>
									<td>'.$row->expiration.'</td>
									<td>'.$row->date_stored.'</td>
								</tr>
							';
						}
						?>
						</tbody>
					</table>
				</div>
				<div class="content" id="panel21">

					<div class="column large-10 medium-10 small-12">
						<input type="search" class="radius tbl_bdr" name="search_added_items" id="search_added_items" placeholder="Search">
					</div>
					<div class="column large-2 medium-2 small-12 right-align">
						<a href="#" class="button tiny" data-reveal-id="inv_add_item">Add new item</a>
					</div>
					<div id="inv_add_item" class="reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<h2 id="modalTitle" class="text-center">Add Item</h2>

						<div id="alert_add_inv" data-alert class="alert-box warning round" style="display: none;">
							This is an alert - alert that is rounded.
							<a href="#" class="close">&times;</a>
						</div>

						<form id="inv_form" action="" method="post" autocomplete="on">

							<div class="column large-6 medium-6 small-12">
								<input type="text" class="radius" name="inv_code" id="inv_code" placeholder="Code">
								<input type="text" class="radius" name="inv_name" id="inv_name" placeholder="Name">
								<input type="text" class="radius" name="inv_delivered_by" id="inv_delivered_by" placeholder="Delivered By">
								<input type="text" class="radius" name="inv_received_by" id="inv_received_by" placeholder="Received By">
							</div>
							<div class="column large-6 medium-6 small-12">
								<input type="text" class="radius" name="inv_description" id="inv_description" placeholder="Description">
								<input type="number" class="radius txtboxToFilter" name="inv_qty" id="inv_qty" placeholder="Quantity">
								<input type="text" class="radius" name="inv_expiration" id="inv_expiration" placeholder="Expiration date">
								<a href="#" id="btn_add_inv" class="button radius tiny right">Add</a>
							</div>
						</form>

						<a class="close-reveal-modal" aria-label="Close">&#215;</a>
					</div>
					<div id="inv_edit_item" class="reveal-modal large" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<h2 id="modalTitle" class="text-center">Update Item</h2>

						<div id="alert_edit_inv" data-alert class="alert-box warning round" style="display: none;">
							This is an alert - alert that is rounded.
							<a href="#" class="close">&times;</a>
						</div>

						<form id="inv_edit_form" action="" method="post" autocomplete="on">
                            <input type="hidden" id="edit_inv_trans_id" name="edit_inv_trans_id">
                            <input type="hidden" id="edit_inv_stck_id" name="edit_inv_stck_id">
							<div class="column large-6 medium-6 small-12">
								<input type="text" class="radius" name="edit_inv_code" id="edit_inv_code" placeholder="Code">
								<input type="text" class="radius" name="edit_inv_name" id="edit_inv_name" placeholder="Name">
								<input type="text" class="radius" name="edit_inv_delivered_by" id="edit_inv_delivered_by" placeholder="Delivered By">
								<input type="text" class="radius" name="edit_inv_received_by" id="edit_inv_received_by" placeholder="Received By">
							</div>
							<div class="column large-6 medium-6 small-12">
								<input type="text" class="radius" name="edit_inv_description" id="edit_inv_description" placeholder="Description">
								<input type="number" class="radius txtboxToFilter" name="edit_inv_qty" id="edit_inv_qty" placeholder="Quantity">
								<input type="text" class="radius" name="edit_inv_expiration" id="edit_inv_expiration" placeholder="Expiration date">
                                    <a href="#" id="btn_edit_inv" class="button radius tiny right">Update</a>
							</div>
						</form>

						<a class="close-reveal-modal" aria-label="Close">&#215;</a>
					</div>

					<table id="deduct_table" class="tbl_bdr twidth">
						<thead>
						<tr style="background-color:#ccccff;">
							<th style="text-align:center;">Code</th>
							<th style="text-align:center;">Name</th>
							<th style="text-align:center;">Description</th>
							<th style="text-align:center;">Quantity</th>
							<th style="text-align:center;">Expiration</th>
							<th style="text-align:center;display: none;">Delivered By</th>
							<th style="text-align:center;display: none;">Received By</th>
							<th style="text-align:center;display: none;">Updated By</th>
							<th style="text-align:center;">Informations</th>
							<th style="text-align:center;">Date Stored</th>
						</tr>
						</thead>
						<tbody id="tbody_add">
						<?php
						$this->db->select('*'); // Select field
						$this->db->from('stocks_sub'); // from Table1
						$this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER'); // Join table1 with table2 based on the foreign key
						$this->db->order_by("stock_id","desc");
						$this->db->where('process','add');
						$res = $this->db->get();

						foreach ( $res->result() as $row ){

							echo '
							<tr id="add'.$row->trans_id.'">
								<td><a class="inv_edit" href="#" alt="'.$row->trans_id.'">'.$row->item_code.'</a></td>
								<td>'.$row->item_name.'</td>
								<td>'.
									$row->description.'
								</td>
								<td>'.$row->item_qty.'</td>
								<td>'.$row->expiration.'</td>
								<td>Delivered by : '.$row->personel.
									'<br> Received by : '.$row->received_by.
									'<br> Transacted by : '.$row->transacted_by.
								'</td>
								<td>'.$row->date_stored.'</td>
							</tr>
							';
						}
						?>
						</tbody>
					</table>
				</div>
				<div class="content" id="panel31">
					<div class="column large-10 medium-10 small-12">
						<input type="search" class="radius tbl_bdr" name="search_deduct_items" id="search_deduct_items" placeholder="Search">
					</div>
					<div class="column large-2 medium-2 small-12 right-align">
						<a href="#" class="button tiny" data-reveal-id="inv_deduct_item">Deduct item</a>
					</div>

					<div id="inv_deduct_item" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<h2 id="modalTitle" class="text-center">Deduct Item</h2>

						<div id="alert_deduct_inv" data-alert class="alert-box warning round" style="display: none;">
							This is an alert - alert that is rounded.
							<a href="#" class="close">&times;</a>
						</div>

						<form id="inv_form_deduct" action="" method="post" autocomplete="on">
							<select name="deduct_select" id="deduct_select">
								<option value="0">Select Item</option>
								<?php
								$query = $this->db->get('stocks');
								foreach ( $query->result() as $row ){
									echo '
										<option value="'.$row->stock_id.'">'.$row->item_code.' : '.$row->item_name.'</option>
									';
								}
								?>
							</select>
							<select name="deduct_jo" id="deduct_jo">
								<option value="0">Select Job Order</option>
								<?php
								$this->db->where( 'jo_color', 'blue' );
								$query_jho = $this->db->get('job_order_list');
								foreach ( $query_jho->result() as $row_jho ){
									echo '
										<option value="'.$row_jho->jo_number.'">'.$row_jho->jo_number.' : '.$row_jho->project_name.'</option>
									';
								}
								?>
							</select>
							<input type="text" name="deduct_rece" id="deduct_rece" placeholder="Receiver's name">
							<input type="text" name="deduct_desc" id="deduct_desc" placeholder="Description">
							<input type="text" name="deduct_qty_total" id="deduct_qty_total" readonly>
							<input type="text" name="deduct_qty" id="deduct_qty" placeholder="Quantity">
							<input type="text" name="deduct_total" id="deduct_total" placeholder="Total" readonly>
							<a href="#" id="btn_deduct_inv" class="button radius tiny right" disabled>Deduct</a>
						</form>

						<a class="close-reveal-modal" aria-label="Close">&#215;</a>
					</div>
					<table class="tbl_bdr twidth">
						<thead>
						<tr style="background-color:#ccccff;">
							<th style="text-align:center;">Item Name</th>
							<th style="text-align:center;">JO ID.</th>
							<th style="text-align:center;">Received By</th>
							<th style="text-align:center;">Description</th>
							<th style="text-align:center;">Quantity</th>
							<th style="text-align:center;">Deducted By</th>
							<th style="text-align:center;">Date Deducted</th>
						</tr>
						</thead>
						<tbody id="tbody_deduct">
						<?php
						$this->db->select('*'); // Select field
						$this->db->from('stocks_sub'); // from Table1
						$this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER'); // Join table1 with table2 based on the foreign key
						$this->db->where('process','deduct');
						$this->db->order_by("trans_id","DESC");
						$res = $this->db->get();

						foreach ( $res->result() as $row ){

							$str_appr_rel = '';
							if( !$row->approved_by && ($this->session->userdata('sess_dept') == '6') ){
								$str_appr_rel .= '
									<label for="chk_approval">Approve : 
										<input type="checkbox" class="approvalchk" name="chk_approval" id="chk_approval" alt="'.$row->trans_id.'">
									</label>
								';
							}else{
								$str_appr_rel .= '
									Approved By : '.$row->approved_by.'
								';
								$str_appr_rel .= '<br>';
							}

							if( !$row->released_by && ($this->session->userdata('sess_dept') == '8') ){
								$str_appr_rel .= '
									<label for="chk_approval">Release : 
										<input type="checkbox" class="releasechk" name="chk_released" id="chk_released" alt="'.$row->trans_id.'">
									</label>
								';
							}else{
								$str_appr_rel .= '
									Released By : '.$row->released_by.'
								';
							}
							echo '
							<tr id="trans'.$row->trans_id.'">
								<td>'.$row->item_name.'</td>
								<td>'.$row->jo_id.'</td>
								<td>'.$row->received_by.'</td>
								<td>'.$row->sub_description.'</td>
								<td>'.$row->item_qty.'</td>
								<td>'.$row->deducted_by.'<br>'.$str_appr_rel.'</td>
								<td>'.$row->transaction_date.'</td>
							</tr>
							';
						}
						?>
						</tbody>
					</table>
				</div>
				<div class="content" id="panel41">
					<div class="column large-10 medium-10 small-12">
						<input type="search" class="radius tbl_bdr" name="search_returned_items" id="search_returned_items" placeholder="Search">
					</div>
					<div class="column large-2 medium-2 small-12 right-align">
						<a href="#" class="button tiny" data-reveal-id="inv_returned_item">Return item</a>
					</div>

					<div id="inv_returned_item" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
						<h2 id="modalTitle" class="text-center">Return Item</h2>

						<div id="alert_returned_inv" data-alert class="alert-box warning round" style="display: none;">
							This is an alert - alert that is rounded.
							<a href="#" class="close">&times;</a>
						</div>

						<form id="inv_form_returned" action="" method="post" autocomplete="on">
							<select name="returned_select" id="returned_select">
								<option value="0">Select Item</option>
								<?php
								$query = $this->db->get('stocks');
								foreach ( $query->result() as $row ){
									echo '
										<option value="'.$row->stock_id.'">'.$row->item_code.' : '.$row->item_name.'</option>
									';
								}
								?>
							</select>
							<input type="hidden" name="return_current_stocks_hide" id="return_current_stocks_hide">
							<input type="text" name="return_current_stocks" id="return_current_stocks" placeholder="Returned By" readonly>
							<input type="text" name="return_qty" id="return_qty" placeholder="Quantity">
							<input type="text" name="return_by" id="return_by" placeholder="Returned By">
							<input type="text" name="return_recieved" id="return_recieved" placeholder="Received By">
							<input type="text" name="return_desc" id="return_desc" placeholder="Description">
							<a href="#" id="btn_return_inv" class="button radius tiny right" disabled>Returned</a>
						</form>

						<a class="close-reveal-modal" aria-label="Close">&#215;</a>
					</div>
					<table class="tbl_bdr twidth">
						<thead>
						<tr style="background-color:#ccccff;">
							<th style="text-align:center;">Item Name</th>
							<th style="text-align:center;">Returned By</th>
							<th style="text-align:center;">Received By</th>
							<th style="text-align:center;">Description</th>
							<th style="text-align:center;">Quantity</th>
							<th style="text-align:center;">Date Returned</th>
						</tr>
						</thead>
						<tbody id="tbody_inv_return">
						<?php
						$this->db->select('*'); // Select field
						$this->db->from('stocks_sub'); // from Table1
						$this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER'); // Join table1 with table2 based on the foreign key
						$this->db->order_by("trans_id","desc");
						$this->db->where('process','return');
						$res_inv = $this->db->get();
						foreach ( $res_inv->result() as $row_inv ){
							echo '
								<tr id="ret'.$row_inv->trans_id.'">
									<td>'.$row_inv->item_code.' - '.$row_inv->item_name.'</td>
									<td>'.$row_inv->personel.'</td>
									<td>'.$row_inv->received_by.'</td>
									<td>'.$row_inv->description.'</td>
									<td>'.$row_inv->item_qty.'</td>
									<td>'.$row_inv->transaction_date.'</td>
								</tr>
							';
						}
						?>
						</tbody>
					</table>
				</div>
				<div class="content" id="panel51">
					<input type="search" class="radius tbl_bdr" name="search_summary_items" id="search_summary_items" placeholder="Search">
					<table class="twidth">
						<thead>
						<tr style="background-color:#ccccff;">
							<th style="text-align:center;">Item Name</th>
							<th style="text-align:center;">Process</th>
							<th style="text-align:center;">Date Received/<br/>Delivered/<br/>Returned</th>
							<th style="text-align:center;">Quantity</th>
							<th style="text-align:center;">Receiver/<br/>Delivered by/<br/>Returned by</th>
							<th style="text-align:center;">Updated By</th>
						</tr>
						</thead>
						<tbody id="tbodyAppend" class="tbodyAppend">
						<?php
						$this->db->select('*'); // Select field
						$this->db->from('stocks_sub'); // from Table1
						$this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER');
						$this->db->order_by("trans_id","desc");
						$query = $this->db->get();
						foreach ( $query->result() as $row ){
							echo '
								<tr>
									<td>'.$row->item_code.'<br>'.$row->item_name.'</td>
									<td>'.ucfirst($row->process).'</td>
									<td>'.$row->transaction_date.'</td>
									<td>'.$row->item_qty.'</td>
									<td>
										Receiver : '.$row->received_by.'<br>
										Delivered / Returned By : '.$row->personel.'
									</td>
									<td>'.$row->transacted_by.'</td>
								</tr>
							';
						}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="column large-2 medium-2 small-12 scrollable_area">
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
						<div class="clearfix"></div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
<?php
	}elseif($this->session->userdata('sess_dept') == '5'){
?>
		<div class="column large-3 medium-3 small-12 scrollable_area">
			Manpower

			<div id="alert_manhr" data-alert class="alert-box alert radius hide-normal">
				Special characters are not allowed
				<a href="#" class="close">&times;</a>
			</div>
			<form id="manpower_hr_add" action="" method="post">
				<div class="row">
					<input type="text" style="" class="brdrRad" name="man_agency" id="man_agency" placeholder="Agency">
				</div>
				<div class="row" id="additional_manpower" style="border: 2px solid #000000; padding: 13px 6px 0px 6px; margin-bottom: 6px;">
					<input type="text" class="brdrRad" name="man_name[]" id="man_name" placeholder="Name">
					<input type="text" class="brdrRad" name="man_contact[]" id="man_contact" placeholder="Contact">
					<input type="text" class="brdrRad" name="man_type[]" id="man_type" placeholder="Manpower Type">
				</div>
				<div class="row">
					<a id="btn_add_manpower" href="#" class="button small brdrRad twidth">Add another field</a>
				</div>
				<div class="row">
					<a id="btn_save_manpower" href="#" class="button small brdrRad ora_col float-right">Save</a>
				</div>
			</form>
		</div>
		<div class="column large-7 medium-7 small-12 scrollable_area">
			<input type="search" class="radius" name="inp_search_manpower" id="inp_search_manpower" placeholder="Search">
			<table class="twidth">
				<thead>
				<tr>
					<td>Manpower</td>
					<td>Contact</td>
					<td>Manpower Type</td>
					<td>Agency</td>
				</tr>
				</thead>
				<tbody id="tbody_manpower">

				<?php
				$this->db->order_by("manpower_id", "desc");
				$query = $this->db->get('hr_manpower');
				foreach ($query->result() as $row)
				{
					echo '
						<tr>
							<td>'.$row->name.'</td>
							<td>'.$row->contact.'</td>
							<td>'.$row->type.'</td>
							<td>'.$row->agency.'</td>
						</tr>
					';
				}
				?>
				</tbody>
			</table>
		</div>
		<div class="column large-2 medium-2 small-12 scrollable_area">
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
						<div class="clearfix"></div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
<?php
	}
?>
