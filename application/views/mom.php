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
            $shared_array = json_decode( $row->shared_to, true );
            $did = $row->emp_id;
        }
    }

    if( isset( $shared_array ) ){
        if ( in_array( $this->session->userdata('sess_id'), $shared_array ) || ( ( $this->session->userdata('sess_dept') == 1 ) && ( $this->session->userdata('sess_id') == $did ) ) ) {
            $str_display = 'style="display:block;"';
            $str_disa = '';
        }else{
            $str_display = 'style="display:none;"';
            $str_disa = 'disabled';
        }
    }else{
        if ( ( $this->session->userdata('sess_dept') == 1 ) && ( $this->session->userdata('sess_id') == $did ) ) {
            $str_display = 'style="display:block;"';
            $str_disa = '';
        }else{
            $str_display = 'style="display:none;"';
            $str_disa = 'disabled';
        }
    }
?>
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
    <div class="row">
        <table class="twidth">
            <tr>
                <td>Attendees</td>
                <td>
                    <label for="inp_mom_attendees">
                        <input class="cc mom_required" type="text" id="inp_mom_attendees" name="inp_mom_attendees" value="<?=isset($md->attend) ? $md->attend : '';?>" <?=$str_disa?> required>
                    </label>
                    <small class="error">Name is required and must be a string.</small>
                </td>
                <td>Date and time</td>
                <td>
                    <label for="inp_mom_date">
                        <input class="cc mom_required" type="text" id="inp_mom_date" name="inp_mom_date" value="<?=isset($md->date) ? $md->date : '';?>" <?=$str_disa?> required>
                    </label>
                    <small class="error">Date is required.</small>
                </td>
            </tr>
            <tr>
                <td>Location</td>
                <td>
                    <label for="inp_mom_location">
                        <input class="cc mom_required" type="text" id="inp_mom_location" name="inp_mom_location" value="<?=isset($md->location) ? $md->location : '';?>" <?=$str_disa?> required>
                    </label>
                    <small class="error">Location is required.</small>
                </td>
                <td>Agenda</td>
                <td>
                    <label for="inp_mom_agenda">
                        <input class="cc mom_required" type="text" id="inp_mom_agenda" name="inp_mom_agenda" value="<?=isset($md->agenda) ? $md->agenda : '';?>" <?=$str_disa?> required>
                    </label>
                    <small class="error">Agenda is required.</small>
                </td>
            </tr>
        </table>
    </div>

    <h4>Notes</h4>
    <div class="row">
        <ul class="tabs" data-tab role="tablist">
            <li class="tab-title active" role="presentation"><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1">Event details</a></li>
            <li class="tab-title" role="presentation"><a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2">Campaign overview</a></li>
            <li class="tab-title" role="presentation"><a href="#panel2-3" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-3">Activation flow</a></li>
            <li class="tab-title" role="presentation"><a href="#panel2-4" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-4">Other details</a></li>
        </ul>
        <div class="tabs-content">
            <section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
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
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
                <textarea class="cc" name="editor_campaign_overview" id="editor_campaign_overview" rows="10" cols="30" <?=$str_disa?>><?=isset($md->campaign) ? $md->campaign : '';?></textarea>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-3">
                <textarea class="cc" name="editor_activation_flow" id="editor_activation_flow" rows="10" cols="30" <?=$str_disa?>><?=isset($md->act_flow) ? $md->act_flow : '';?></textarea>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-4">
                <textarea class="cc" name="editor_other_details" id="editor_other_details" rows="10" cols="30" <?=$str_disa?>><?=isset($md->details) ? $md->details : '';?></textarea>
            </section>
        </div>
    </div>

    <div class="row">
        <h4>Next steps and deliverables</h4>
        <textarea class="cc" name="editor_next" id="editor_next" rows="10" cols="30" <?=$str_disa?>><?=isset($md->steps) ? $md->steps : '';?></textarea>
    </div>

    <div class="row">
        <button id="btn_mom_submit" class="right mar10" type="button" <?=$str_display?>><i class="fi-plus small"></i> Save</button>
    </div>
</form>