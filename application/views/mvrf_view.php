<?php
$mv = json_decode($mvrf_details);

$shared_array = array();
$this->db->select( 'shared_to, emp_id' );
$this->db->from( 'job_order_list' );
$this->db->where( 'jo_id', $this->input->get( 'a' ));
$query = $this->db->get();
if ($query->num_rows() > 0) {
    $row = $query->row();
    if (isset($row)) {
        $shared_array = explode( ',', $row->shared_to );
        $did = $row->emp_id;
    }
}

if( isset( $shared_array ) ){
    if ( in_array( $this->session->userdata('sess_id'), $shared_array ) || ( $this->session->userdata('sess_id') == $did ) ) {
        $str_display = 'style="display:block;"';
        $str_disa = '';
    }else{
        $str_display = 'style="display:none;"';
        $str_disa = 'disabled';
    }
}else{
    if( ( $this->session->userdata('sess_dept') <= 2 ) && ( $this->session->userdata('sess_id') == $did ) ) {
        $str_display = 'style="display:block;"';
        $str_disa = '';
    }else{
        $str_display = 'style="display:none;"';
        $str_disa = 'disabled';
    }
}

$hr_da = array('1','2','3','5');

if ( in_array( $this->session->userdata('sess_dept'), $hr_da ) ) {
	$hr_display = 'style="display:block;"';
	$hr_disa = '';
}else{
	$hr_display = 'style="display:none;"';
	$hr_disa = 'disabled';
}
?>

<div class="column">
	<ul class="accordion" data-accordion>
		<li class="accordion-navigation">
			<a href="#panelHr1">Requirement</a>
			<div id="panelHr1" class="content active">

				<form id="man_req_form" action="" method="post">
					<input type="hidden" name="hid_req_man_id" value="<?=$this->input->get('a');?>">
					<button class="button medium" id="submit_man_req" style="float:right;">Update</button>

					<div id="alert_req_man" data-alert class="alert-box warning round" style="display: none;">
						This is an alert - alert that is rounded.
						<a href="#" class="close">&times;</a>
					</div>
					<table class="twidth">
						<thead>
						<tr>
							<th>Manpower Type</th>
							<th>No. of Manpower Needed</th>
							<th <?=$hr_display;?>>Manpower Rate</th>
						</tr>
						</thead>
						<tbody id="tbl_man_req">
				<?php
				$overalltotaltobepulled = 0;

				$query = $this->db->get_where( 'hr_requirements', array( 'jo_id' => $this->input->get('a') ) );
				if($query->num_rows() > 0){
					$ret = $query->row();
					$overalltotaltobepulled = $ret->ba + $ret->pg + $ret->sampler + $ret->seller + $ret->pa + $ret->setup + $ret->stylist + $ret->dancer + $ret->others_needed;
					echo '
							<tr>
								<td>BA</td>
								<td><input type="number" name="inp_req_ba_needed" id="inp_req_ba_needed" value="'.$ret->ba.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_req_ba_rate" id="inp_req_ba_rate" value="'.$ret->ba_rate.'"></td>
							</tr>
							<tr>
								<td>PG</td>
								<td><input type="number" name="inp_req_pg_needed" id="inp_req_pg_needed" value="'.$ret->pg.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_req_pg_rate" id="inp_req_pg_rate" value="'.$ret->pg_rate.'"></td>
							</tr>
							<tr>
								<td>Sampler</td>
								<td><input type="number" name="inp_req_needed_sampler" id="inp_req_needed_sampler" value="'.$ret->sampler.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_req_rate_sampler" id="inp_req_rate_sampler" value="'.$ret->sampler_rate.'"></td>
							</tr>
							<tr>
								<td>Seller</td>
								<td><input type="number" name="inp_req_needed_seller" id="inp_req_needed_seller" value="'.$ret->seller.'"></td>
								<td><input type="number" name="inp_req_rate_seller" id="inp_req_rate_seller" value="'.$ret->seller_rate.'"></td>
							</tr>
							<tr>
								<td>PA</td>
								<td><input type="number" name="inp_req_needed_pa" id="inp_req_needed_pa" value="'.$ret->pa.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_req_rate_pa" id="inp_req_rate_pa" value="'.$ret->pa_rate.'"></td>
							</tr>
							<tr>
								<td>Set-up</td>
								<td><input type="number" name="inp_req_needed_set" id="inp_req_needed_set" value="'.$ret->setup.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_req_rate_set" id="inp_req_rate_set" value="'.$ret->setup_rate.'"></td>
							</tr>
							<tr>
								<td>Stylist</td>
								<td><input type="number" name="inp_req_needed_stylist" id="inp_req_needed_stylist" value="'.$ret->stylist.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_req_rate_stylist" id="inp_req_rate_stylist" value="'.$ret->stylist_rate.'"></td>
							</tr>
							<tr>
								<td>Dancer</td>
								<td><input type="number" name="inp_req_needed_dancer" id="inp_req_needed_dancer" value="'.$ret->dancer.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_req_rate_dancer" id="inp_req_rate_dancer" value="'.$ret->dancer_rate.'"></td>
							</tr>
							<tr>
								<td>Others</td>
								<td> </td>
								<td '.$hr_display.'> </td>
							</tr>
							<tr>
								<td><input type="text" name="inp_other_man_req" id="inp_other_man_req" value="'.$ret->others.'"></td>
								<td><input type="number" name="inp_other_man_req_needed" id="inp_other_man_req_needed" value="'.$ret->others_needed.'"></td>
								<td '.$hr_display.'><input type="number" name="inp_other_man_req_rate" id="inp_other_man_req_rate" value="'.$ret->others_rate.'"></td>
							</tr>
					';
				}else{
				?>
							<tr>
								<td>BA</td>
								<td><input type="number" name="inp_req_ba_needed" id="inp_req_ba_needed"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_ba_rate" id="inp_req_ba_rate"></td>
							</tr>
							<tr>
								<td>PG</td>
								<td><input type="number" name="inp_req_pg_needed" id="inp_req_pg_needed"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_pg_rate" id="inp_req_pg_rate"></td>
							</tr>
							<tr>
								<td>Sampler</td>
								<td><input type="number" name="inp_req_needed_sampler" id="inp_req_needed_sampler"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_rate_sampler" id="inp_req_rate_sampler"></td>
							</tr>
							<tr>
								<td>Seller</td>
								<td><input type="number" name="inp_req_needed_seller" id="inp_req_needed_seller"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_rate_seller" id="inp_req_rate_seller"></td>
							</tr>
							<tr>
								<td>PA</td>
								<td><input type="number" name="inp_req_needed_pa" id="inp_req_needed_pa"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_rate_pa" id="inp_req_rate_pa"></td>
							</tr>
							<tr>
								<td>Set-up</td>
								<td><input type="number" name="inp_req_needed_set" id="inp_req_needed_set"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_rate_set" id="inp_req_rate_set"></td>
							</tr>
							<tr>
								<td>Stylist</td>
								<td><input type="number" name="inp_req_needed_stylist" id="inp_req_needed_stylist"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_rate_stylist" id="inp_req_rate_stylist"></td>
							</tr>
							<tr>
								<td>Dancer</td>
								<td><input type="number" name="inp_req_needed_dancer" id="inp_req_needed_dancer"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_req_rate_dancer" id="inp_req_rate_dancer"></td>
							</tr>
							<tr>
								<td>Others</td>
								<td> </td>
								<td <?=$hr_display;?>> </td>
							</tr>
							<tr>
								<td><input type="text" name="inp_other_man_req" id="inp_other_man_req"></td>
								<td><input type="number" name="inp_other_man_req_needed" id="inp_other_man_req_needed"></td>
								<td <?=$hr_display;?>><input type="number" name="inp_other_man_req_rate" id="inp_other_man_req_rate"></td>
							</tr>
				<?php
				}
				?>
						</tbody>
					</table>
				</form>
			</div>
		</li>
		<li class="accordion-navigation">
			<a href="#panelHr2">Pooling</a>
			<div id="panelHr2" class="content">
				<div id="alert_man_pool" data-alert class="alert-box warning round" style="display: none;">
					This is an alert - alert that is rounded.
					<a href="#" class="close">&times;</a>
				</div>
				<form id="pool_form" action="" method="post">
					<input type="hidden" name="pooling_joid" value="<?=$this->input->get('a');?>">
					<input type="hidden" id="pool_overalltotal" name="pool_overalltotal" value="<?=$overalltotaltobepulled?>">
					<?php
					$percentage = 0;
					$query_pool = $this->db->get_where( 'hr_pooling', array( 'jo_id' => $this->input->get('a') ) );
					if($query_pool->num_rows() > 0) {
						$ret_pool = $query_pool->row();
						$percentage = ($ret_pool->pool_pulled/$overalltotaltobepulled) * 100;
						?>
						<input type="text" name="pool_start" id="pool_start" placeholder="Start of Pooling" value="<?=$ret_pool->pool_start?>">
						<input type="text" name="pool_deadline" id="pool_deadline" placeholder="Deadline" value="<?=$ret_pool->pool_deadline?>">
						<input type="text" name="pool_pulled" id="pool_pulled" placeholder="Pooled Manpower" value="<?=$ret_pool->pool_pulled?>">
						<input type="text" name="pool_percentage" id="pool_percentage" value="<?=$percentage <= 0 ? '0%' : $percentage?>" readonly>
						<?php
					}else{
						?>
						<input type="text" name="pool_start" id="pool_start" placeholder="Start of Pooling">
						<input type="text" name="pool_deadline" id="pool_deadline" placeholder="Deadline">
						<input type="text" name="pool_pulled" id="pool_pulled" placeholder="Pooled Manpower">
						<input type="text" name="pool_percentage" id="pool_percentage" value="0%" readonly>
						<?php
					}
					?>
					<button class="button tiny" id="btn_pool">Update</button>
				</form>
				<div id="div_status" class="row" <?=$percentage <= 0 ? 'style="background:red; color:white; text-align:center; border-radius:10px;"' : 'style="background:#f57e20; color:white; text-align:center; border-radius:10px;"'?>>Status <?=$percentage < 100 ? 'Pending' : 'Done'?></div>
			</div>
		</li>
		<li class="accordion-navigation">
			<a href="#panelHr3">Line-up</a>
			<div id="panelHr3" class="content">
				Panel 3. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
			</div>
		</li>
		<li class="accordion-navigation">
			<a href="#panelHr4">Briefing, Training and Simulation</a>
			<div id="panelHr4" class="content">
				<div id="addMpvrForm" class="reveal-modal small radius" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
					<h2 id="modalTitle" class="text-center">Add Record</h2>
					<div class="row">
						<div data-alert class="alert-box warning radius hide" id="errBox" style="display:none;">
							Please fill up all fields.
						</div>
						<div class="large-6 columns">
							<label>Quantity:
								<input type="number" id="quantxt" placeholder="Quantity" />
							</label>
						</div>
						<div class="large-6 columns">
							<label>Designation:
								<input type="text" id="desigtxt" placeholder="Designation" />
							</label>
						</div>
						<div class="large-6 columns">
							<label>Rate:
								<input type="text" id="ratetxt" placeholder="Rate" />
							</label>
						</div>
						<div class="large-6 columns">
							<label>Venue:
								<input type="text" id="ventxt" placeholder="Venue" />
							</label>
						</div>
						<div class="large-12 columns">
							<label>Description:
								<textarea style="min-height: 106px;resize: none;" id="destxt"></textarea>
							</label>
						</div>
						<div class="large-12 columns">
							<button class="expand button warning radius" onclick="addRecord(this)">+ Add</button>
						</div>
					</div>
					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
				<hr>
				<div class="row mpvrForm">
					<form onsubmit="return false;" method="post" id="mpvrFormInput">
						<div class="large-12 columns">
							<div class="large-6 columns">
								<label>Project Overview:
									<input type="text" name="poverview" id="poverview" placeholder="Project Overview" />
								</label>
							</div>
							<div class="large-6 columns">
								<label>Kick Off Event:
									<input type="text" name="kEvent" id="kEvent" placeholder="Kick Off Event" />
								</label>
							</div>
							<div class="large-12 columns">
								<button class="button default right" data-reveal-id="addMpvrForm" onclick="clearData()">+ Add</button>
								<table id="mpvrTbl">
									<thead>
									<tr>
										<th style="width: 5%;">QTY</th>
										<th style="width: 25%;">Designation</th>
										<th style="width: 30%;">Description</th>
										<th style="width: 20%;">Rate</th>
										<th style="width: 20%;">Venue</th>
									</tr>
									</thead>
									<tbody class="mpvrTbl">
									<tr>
										<td align="center" class="text-center" colspan="5">No Data</td>
									</tr>
									</tbody>
								</table>
							</div>
							<div class="large-6 columns">
								<label>No. of Teams:
									<input type="number" name="nTeams" id="nTeams" placeholder="No. of Teams" />
								</label>
							</div>
							<div class="large-6 columns">
								<label>Event Date:
									<input type="text" name="eDate" id="eDate" placeholder="Event Date" />
								</label>
							</div>
							<div class="large-6 columns">
								<label>Call Time:
									<input type="text" name="cTime" id="cTime" placeholder="Call Time" />
								</label>
							</div>
							<div class="large-6 columns">
								<label>No. of Days:
									<input type="number" name="nDays" id="nDays" placeholder="No. of Days" />
								</label>
							</div>
							<div class="large-6 columns">
								<label>Manpower Briefing / Simulation:
									<textarea name="nBreif" id="nBreif"></textarea>
								</label>
							</div>
							<div class="large-6 columns">
								<label>Attire:
									<input type="text" name="mAttire" id="mAttire" placeholder="Attire" />
								</label>
								<label>Other(s):
									<textarea name="mOthers" id="mOthers" style="min-height: 96px;"></textarea>
								</label>
							</div>
							<div class="large-3 columns right">
								<button class="button warning radius expand" onclick="saveMpvrRecord(this)">Save</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</li>
	</ul>
</div>
