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
?>
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