<div class="row fullwidth bar_color1 text-center">
	<div class="large-12 columns" style="padding: 20px 0px;">
		<h5>Job Order</h5>		
	</div>
</div>
<div class="row jopart">
	<div class="large-12 columns">
		<?php
			if( $this->session->userdata('status') == 1 && $this->session->userdata('sess_role') == 'admin' || $this->session->userdata('sess_role') == 'employee' ){
		?>
				<?php if( $this->session->userdata('sess_dept') <= 2 ){ ?>
					<a data-reveal-id="joModal" class="right plussign">&#43;</a>
				<?php } ?>


				<div id="joModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="border-radius: 13px;">
					<h2 id="modalTitle" class="text-center">Create New Job Order</h2>

					<div id="alert_box" data-alert class="alert-box alert radius hide-normal">
						Special characters are not allowed
						<a href="#" class="close">&times;</a>
					</div>

					<form id="form_jo" action="" method="post">
						<div class="large-11 columns large-centered">
							<label for="inp_projtype"> Project type
								<input type="text" id="inp_projtype" name="inp_projtype" placeholder="Project Type" autocomplete="on">
							</label>
						</div>	
						<div class="large-11 columns large-centered">
							<label for="inp_client">Client
								<select name="inp_client" id="inp_client">
									<option value="0">Select</option>
									<?php
										foreach($client_list as $row){
											echo '
												<option value="'.$row['client_id'].'">'.$row['company_name'].'</option>
											';
										}
									?>
								</select>
							</label>
						</div>	
						<div class="large-11 columns large-centered">
							<label for="inp_brand" id="hd" class="hide">Brand
								<select name="inp_brand" id="inp_brand">
									<option value="0">Select</option>
								</select>
							</label>
						</div>
						<div class="large-11 columns large-centered">
							<label for="inp_projname">Project Name
								<input type="text" id="inp_projname" name="inp_projname" placeholder="Project Name" />
							</label>
						</div>
						<div class="large-11 columns large-centered">
							<button id="btn_save_jo" type="submit" class="button medium expand">Create Job Order</button>
						</div>
					</form>

					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
				<div id="joEditModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="border-radius: 13px;">
					<h2 id="modalTitle" class="text-center">Edit Job Order</h2>

					<div id="alert_box" data-alert class="alert-box alert radius hide-normal">
						Special characters are not allowed
						<a href="#" class="close">&times;</a>
					</div>

					<form id="form_jo_edit" action="" method="post">
						<input type="hidden" name="joid" id="joid" />
						<div class="large-11 columns large-centered">
							<label for="inp_projtype_edit"> Project type
								<input type="text" id="inp_projtype_edit" name="inp_projtype" placeholder="Project Type" autocomplete="on">
							</label>
						</div>	
						<div class="large-11 columns large-centered">
							<label for="inp_client">Client
								<select name="inp_client" id="inp_client_edit">
									<option value="0">Select</option>
									<?php
										foreach($client_list as $row){
											echo '
												<option value="'.$row['client_id'].'">'.$row['company_name'].'</option>
											';
										}
									?>
								</select>
							</label>
						</div>	
						<div class="large-11 columns large-centered">
							<label for="inp_brand_edit" id="hd">Brand
								<select name="inp_brand" id="inp_brand_edit">
									<option value="0">Select</option>
								</select>
							</label>
						</div>
						<div class="large-11 columns large-centered">
							<label for="inp_projname">Project Name
								<input type="text" id="inp_projname_edit" name="inp_projname" placeholder="Project Name" />
							</label>
						</div>
						<div class="large-11 columns large-centered">
							<button id="btn_save_jo_edit" type="submit" class="button medium expand">Update Job Order</button>
						</div>
					</form>

					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
		<?php
			}
		?>		
	</div>
	<div class="large-12 columns">
		<div class="row collapse prefix-round" style="border-bottom: 2px solid #96adb5;">
			<div class="small-1 columns text-right">
				<img src="<?=base_url('assets/img/logos/Search.png');?>" class="img-responsive show-for-medium-up" style="max-width: 58px;margin-right: 6px;" />
			</div>
			<div class="small-11 columns">
				<input type="text" class="sjo" id="search_jolist" placeholder="Search For A Job Order...">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="large-12 columns" style="padding-top: 22px;">
		<ul class="no-bullet" id="jo_table_list">
		<?php
                $c = '';
                $b = '';

//                foreach( $toc->result_array() as $row){
                foreach( $jo_list as $row){

                    $query_company = $this->db->get_where( 'clients', array( 'client_id' => $row['client_company_name'] ) );
                    $row_company = $query_company->row();
                    if (isset($row_company))
                    {
                        $c = $row_company->company_name;
                    }

                    $query_brand = $this->db->get_where( 'brand', array( 'brand_id' => $row['brand'] ) );
                    $row_brand = $query_brand->row();
                    if (isset($row_brand))
                    {
                        $b = $row_brand->brand_name;
                    }
			?>
			<li class="jolist jo-item-<?php echo $row['jo_id']; ?>" alt="<?php echo $row['jo_id']; ?>">
				<div class="small-7 medium-8 large-8 columns" style="padding: 50px;">					
					<h3><?php echo $row['project_name']; ?></h3>
					<h5><?php echo '<a href="'.base_url('jo/in?a=').$row['jo_id'].'">JO NO.'.$row['jo_number'].'</a>'; ?></h5>
					<h6><?php echo $row['date_created']; ?></h6>					
				</div>
				<div class="small-5 medium-4 large-4 columns text-right" style="padding: 12px;">
					<ul class="inline-list jorightlist right">
						<li><a onclick="getJoId(this)"><img src="<?php echo base_url('assets/img/logos/Edit.png');?>" /></a></li>
						<!--<li><a href="#"><img src="<?php //echo base_url('assets/img/logos/Delete.png');?>"/></a></li>-->
					</ul>
					<div class="large-12 columns text-right" style="padding-right: 30px;">
						<p style="margin-top: 10px;"><?php echo $row['project_type']; ?></p>
						<p><?php echo $c; ?></p>
						<p><?php echo $b; ?></p>
						<p>DO: <?php echo isset($row['do_contract_no']) ? $row['do_contract_no']:'No Value'; ?></p>
						<p>Billed: <?php echo isset($row['billed_date']) ? $row['billed_date']:'No Value'; ?></p>
						<p>Paid: <?php echo isset($row['paid_date']) ? $row['paid_date']:'No Value'; ?></p>
					</div>					
				</div>
				<div class="clearfix"></div>
			</li>
			<?php
                    /* echo '
                        <tr>
                        <td>'.$row['date_created'].'</td>
                        <td><a href="'.base_url('jo/in?a=').$row['jo_id'].'">'.$row['jo_number'].'</a></tdtr>
                        <td>'.$row['do_contract_no'].'</td>
                        <td>'.$row['project_name'].'</td>
                        <td>'.$row['project_type'].'</td>
                        <td>'.$c.'</td>
                        <td>'.$b.'</td>
                        <td>'.$row['billed_date'].'</td>
                        <td>'.$row['paid_date'].'</td>
                        </tr>
                    '; */
                }
            ?>
			<!--<li class="jolist">
				<div class="small-7 medium-8 large-8 columns" style="padding: 50px;">					
					<h3>Dove School Event</h3>
					<h5>JO NO.54768534</h5>
					<h6>February 26, 2016</h6>					
				</div>
				<div class="small-5 medium-4 large-4 columns text-right" style="padding: 12px;">
					<ul class="inline-list jorightlist right">
						<li><a href="#"><img src="<?php //echo base_url('assets/img/logos/Edit.png');?>" /></a></li>
						<li><a href="#"><img src="<?php //echo base_url('assets/img/logos/Delete.png');?>"/></a></li>
					</ul>
					<div class="large-12 columns text-right" style="padding-right: 30px;">
						<p style="margin-top: 10px;">School Event</p>
						<p>Uniliver</p>
						<p>Dove</p>
						<p>DO: February 24, 2016</p>
						<p>Billed: P203,000</p>
						<p>Paid: P133,000</p>
					</div>					
				</div>
				<div class="clearfix"></div>
			</li>-->
		</ul>
	</div>
</div>