<?php
    $str_display = '';
    $str_disa = '';
    $md = array();
    $md = json_decode($mom_details);

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


    $empid = 0;
    $empid = $this->session->userdata('sess_id');

    if( isset( $shared_array ) ){
//        foreach($shared_array as $empid){
//            $str_sess_id = ;
//            if ( $empid == $this->session->userdata('sess_id') ) {
            if ( in_array($empid, $shared_array, true) ) {
                print_r($shared_array);
                print_r($this->session->userdata('sess_id'));
                $str_display = 'style="display:block;"';
                $str_disa = '';
                return false;
            }else{
                $str_display = 'style="display:none;"';
                $str_disa = 'disabled';
            }
//        }
    }else{
        if ( ( $this->session->userdata('sess_dept') <= 2 ) && ( $this->session->userdata('sess_id') == $did ) ) {
            $str_display = 'style="display:block;"';
            $str_disa = '';
        }else{
            $str_display = 'style="display:none;"';
            $str_disa = 'disabled';
        }
    }
?>

<div class="row motm">
	<div class="large-11 columns large-centered">
		<h4>Overview</h4>
		<div id="alert_box_mom_form_fail" data-alert class="alert-box alert radius hide-normal">
			Fail to save.
			<a href="#" class="close">&times;</a>
		</div>

		<div id="alert_box_mom_form_success" data-alert class="alert-box success radius hide-normal">
			Saved successfully.
			<a href="#" class="close">&times;</a>
		</div>
		<form id="mom_form" action="" data-abide>
			<input type="hidden" id="inp_joid" name="inp_joid" value="<?= $this->input->get( 'a' ) ?>">
			<div class="large-5 columns large-offset-1">
				<div class="large-12 columns">
					<label>Agenda
						<input class="cc mom_required" type="text" id="inp_mom_agenda" name="inp_mom_agenda" value="<?=isset($md->agenda) ? $md->agenda : '';?>" <?=$str_disa?> required>
					</label>
					<small class="error">Agenda is required.</small>
				</div>
				<div class="large-12 columns">
					<label>Date and time
						<input class="cc mom_required" type="text" id="inp_mom_date" name="inp_mom_date" value="<?=isset($md->date) ? $md->date : '';?>" <?=$str_disa?> required>
					</label>
					<small class="error">Date is required.</small>
				</div>
				<div class="large-12 columns">
					<label>Location
						<input class="cc mom_required" type="text" id="inp_mom_location" name="inp_mom_location" value="<?=isset($md->location) ? $md->location : '';?>" <?=$str_disa?> required>
					</label>
					<small class="error">Location is required.</small>
				</div>
			</div>
			<div class="large-6 columns">
				<div class="large-12 columns">
					<label>Attendees
						<textarea style="min-height: 183px;" class="cc mom_required" id="inp_mom_attendees" name="inp_mom_attendees" <?=$str_disa?> required><?=isset($md->attend) ? $md->attend : '';?></textarea>						
					</label>
					<small class="error">Name is required and must be a string.</small>
				</div>
			</div>
			<hr/>
			<h4>Notes</h4>
			<div class="row motm-notes">
				<ul class="tabs" data-tab role="tablist">
					<li class="tab-title active" role="presentation"><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1">Event details</a></li>
					<li class="tab-title" role="presentation"><a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2">Campaign overview</a></li>
					<li class="tab-title" role="presentation"><a href="#panel2-3" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-3">Activation flow</a></li>
					<li class="tab-title" role="presentation"><a href="#panel2-4" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-4">Other details</a></li>
				</ul>
				<div class="tabs-content">
					<section role="tabpanel" aria-hidden="false" class="content active tabarea" id="panel2-1">
						<table class="twidth">
							<tr>
								<td>What</td>
								<td>
									<label for="what_text">
										<input class="cc mom_required" id="what_text" name="what_text" type="text" value="<?=isset($md->what) ? $md->what : '';?>" <?=$str_disa?>>
									</label>
									<textarea class="cc" name="what_add" id="what_add" cols="30" placeholder="Additional notes" rows="5" <?=$str_disa?>><?=isset($md->what_notes) ? $md->what_notes : '';?></textarea>
								</td>
							</tr>
							<tr>
								<td>When</td>
								<td>
									<textarea class="cc" name="when_date" id="when_date" cols="30" rows="5" <?=$str_disa?>><?=isset($md->when) ? $md->when : '';?></textarea>
									<textarea class="cc" name="when_add" id="when_add" cols="30" placeholder="Additional notes" rows="5" <?=$str_disa?>><?=isset($md->when_notes) ? $md->when_notes : '';?></textarea>
								</td>
							</tr>
							<tr>
								<td>Where</td>
								<td>
									<textarea class="cc" name="where_text" id="where_text" cols="30" rows="5" <?=$str_disa?>><?=isset($md->where) ? $md->where : '';?></textarea>
									<textarea class="cc" name="where_add" id="where_add" cols="30" placeholder="Additional notes" rows="5" <?=$str_disa?>><?=isset($md->where_notes) ? $md->where_notes : '';?></textarea>
								</td>
							</tr>
							<tr>
								<td>Expected Guests</td>
								<td>
									<input class="cc mom_required" id="inp_mom_exp_guest" type="text" name="inp_mom_exp_guest" value="<?=isset($md->guest) ? $md->guest : '';?>" <?=$str_disa?>>
								</td>
							</tr>
						</table>
					</section>
					<section role="tabpanel" aria-hidden="true" class="content tabarea" id="panel2-2">
						<textarea class="cc" name="editor_campaign_overview" id="editor_campaign_overview" rows="10" cols="30" <?=$str_disa?>><?=isset($md->campaign) ? $md->campaign : '';?></textarea>
					</section>
					<section role="tabpanel" aria-hidden="true" class="content tabarea" id="panel2-3">
						<textarea class="cc" name="editor_activation_flow" id="editor_activation_flow" rows="10" cols="30" <?=$str_disa?>><?=isset($md->act_flow) ? $md->act_flow : '';?></textarea>
					</section>
					<section role="tabpanel" aria-hidden="true" class="content tabarea" id="panel2-4">
						<textarea class="cc" name="editor_other_details" id="editor_other_details" rows="10" cols="30" <?=$str_disa?>><?=isset($md->details) ? $md->details : '';?></textarea>
					</section>
				</div>
			</div>
			<h4>Next steps and deliverables</h4>
			<div class="large-12 columns">
				<textarea class="cc" name="editor_next" id="editor_next" rows="10" cols="30" <?=$str_disa?>><?=isset($md->steps) ? $md->steps : '';?></textarea>
			</div>
			<div class="large-12 columns">
				<button id="btn_mom_submit" class="right mar10" type="button" <?=$str_display?>><i class="fi-plus small"></i> Save</button>
			</div>
		</form>
	</div>
</div>
