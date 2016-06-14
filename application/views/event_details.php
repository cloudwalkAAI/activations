<?php
//    print_r($ed_details);
    $edcarray = array();
    $edcarray = json_decode( $ed_details );

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

<form id="event_details_form" action="" method="post" data-abide>
    <input type="hidden" name="jo_id" value="<?= $this->input->get('a') ?>">
    <table class="twidth">
        <tr>
            <td>What</td>
            <td>
                <div>
                    <label for="ed_what">
                        <input id="ed_what" name="ed_what" type="text" value="<?=isset($edcarray->wt) ? $edcarray->wt : '';?>" <?=$str_disa?> required>
                    </label>
                    <small class="error">This is a required field.</small>
                </div>
                <textarea name="ed_what_add" id="ed_what_add" cols="30" placeholder="Additional notes" rows="5" <?=$str_disa?>><?=isset($edcarray->wtad) ? $edcarray->wtad : '';?></textarea>
            </td>
        </tr>
        <tr class="hide-normal">
            <td>When</td>
            <td>
                <div>
                    <label for="when_date">
                        <textarea name="ed_when_date" id="ed_when_date" cols="30" rows="5" <?=$str_disa?> required><?=isset($edcarray->wn) ? $edcarray->wn : '';?></textarea>
                    </label>
                    <small class="error">This is a required field.</small>
                </div>
                <textarea name="ed_when_add" id="ed_when_add" cols="30" placeholder="Additional notes" rows="5" <?=$str_disa?>><?=isset($edcarray->wnad) ? $edcarray->wnad : '';?></textarea>
            </td>
        </tr>
        <tr class="hide-normal">
            <td>Where</td>
            <td>
                <div>
                    <label for="where_text">
                        <textarea name="ed_where_text" id="ed_where_text" cols="30" rows="5" <?=$str_disa?> required><?=isset($edcarray->we) ? $edcarray->we : '';?></textarea>
                    </label>
                    <small class="error">This is a required field.</small>
                </div>
                <textarea name="ed_where_add" id="ed_where_add" cols="30" placeholder="Additional notes" rows="5" <?=$str_disa?>><?=isset($edcarray->weadd) ? $edcarray->weadd : '';?></textarea>
            </td>
        </tr>
        <tr>
            <td>Expected Guests</td>
            <td>
                <div>
                    <label for="ed_expected_guest">
                        <input type="text" id="ed_expected_guest" name="ed_expected_guest" value="<?=isset($edcarray->expected) ? $edcarray->expected : '';?>" <?=$str_disa?>>
                    </label>
                    <small class="error">This is a required field.</small>
                </div>
            </td>
        </tr>
    </table>

    <hr>

    <h4>Event specification</h4>
    <textarea name="editor_event_spec" id="editor_event_spec" rows="10" cols="30" <?=$str_disa?> required><?=isset($edcarray->espec) ? $edcarray->espec : '';?></textarea>

    <div id="alert_box_ed_form_fail" data-alert class="alert-box alert radius hide-normal">
        Fail to save.
        <a href="#" class="close">&times;</a>
    </div>

    <div id="alert_box_ed_form_success" data-alert class="alert-box warning radius hide-normal">
        Saved Successfully.
        <a href="#" class="close">&times;</a>
    </div>

    <button id="btn_save_ed" class="right mar10" <?=$str_display?>><i class="fi-plus small"></i> Save</button>

</form>
<hr>

<div class="column large-3 medium-3 small-12">
    <form id="cmtuva_ae_form" action="" method="post" <?=($this->session->userdata('sess_dept') <= 2 ) && ( $this->session->userdata('sess_id') == $did ) || ( $this->session->userdata('sess_dept') == 6 ) ? 'style="display:block;"':'style="display:none;"';?>>
        <input type="hidden" name="jo_id" value="<?=$this->input->get('a');?>">
        <input type="hidden" id="loc_id" name="loc_id" value="">
        <select name="cmtuva_sel_venue" id="cmtuva_sel_venue">
            <option value="0">Select Venue ...</option>
            <?php
            $this->db->select( 'venue' );
            $this->db->from( 'cmtuva_location_list' );
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    echo '<option value="'.ucfirst($row->venue).'">'.ucfirst($row->venue).'</option>';
                }
            }
            ?>
        </select>
        <select name="cmtuva_sel_area" id="cmtuva_sel_area" disabled>
            <option value="0">Select Area ...</option>
        </select>
        <textarea name="cmae_street" id="cmae_street" cols="30" rows="3"></textarea>
        <input type="text" name="cmtuva_date" id="cmtuva_date" placeholder="Start date">
        <input type="text" class="txtboxToFilter text-right" name="cmtuva_duration" id="cmtuva_duration" placeholder="Duration">
        <input type="text" name="cmtuva_rate" id="cmtuva_rate" class="twidth text-right" placeholder="0" readonly>
        <input type="text" class="text-right" name="cmtuva_esp" id="cmtuva_esp" readonly>
        <button id="btn_ae_cmtuva_rate" class="button twidth text-center success">Add</button>
    </form>
</div>
<div class="column large-9 medium-9 small-12 scrollable_area">
    <input type="search" class="radius" name="inp_search_cmae" id="inp_search_cmae" placeholder="Search">
    <table class="twidth" id="cmae_table">
        <thead>
        <tr>
            <th width="2">Venue</th>
            <th width="3">Area</th>
            <th width="3">Address</th>
            <th width="1">Start date</th>
            <th width="1">Duration</th>
            <th width="1">Rate</th>
            <th width="1">Total</th>
            <th> </th>
        </tr>
        </thead>
        <tbody id="cmae_tbody">
        <?php
        $query = $this->db->order_by('cmae_id', 'DESC')->get_where( 'cmtuva_ae_list', array('jo_id'=>$this->input->get('a')) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                echo '
                    <tr id="cmae_'.$row->cmae_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $row->area ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>'.$row->date_start.'</td>
                        <td>'.$row->duration.'</td>
                        <td>Php '.$row->rate.' day(s)</td>
                        <td>Php '.$row->total_rate.'</td>
                    </tr>
                ';

                if( ( $this->session->userdata('sess_dept') <= 2 ) && ( $this->session->userdata('sess_id') == $did ) || ( $this->session->userdata('sess_dept') == 6 ) ) {
                    echo '
                        <tr id="cmae_'.$row->cmae_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $row->area ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>'.$row->date_start.'</td>
                        <td>'.$row->duration.'</td>
                        <td>Php '.$row->rate.' day(s)</td>
                        <td>Php '.$row->total_rate.'</td>
                        <td style="text-align:center;">
                            <div class="column large-6 medium-6 small-6">
                                <a class="edit-btn-cmtuva-ae" href="#" alt="'.$row->cmae_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                            </div>
                            <div class="column large-6 medium-6 small-6">
                                <a class="del-btn-cmtuva-ae" href="#" alt="'.$row->cmae_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                            </div>
                        </td>
                    </tr>
                    ';
                }
            }
        }
        ?>
        </tbody>
    </table>
</div>

<div id="cmae_Modal" class="reveal-modal tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle" class="text-center">Update the info.</h2>

    <div id="alert_cmae" data-alert class="alert-box alert radius hide-normal">
        Special characters are not allowed
        <a href="#" class="close">&times;</a>
    </div>

    <form id="cmae_form" action="" method="post">
        <input type="hidden" name="cm_id" id="cm_id">
        <select name="cmae_sel_venue" id="cmae_sel_venue">
            <option value="0">Select Venue ...</option>
            <?php
            $this->db->select( 'venue' );
            $this->db->from( 'cmtuva_location_list' );
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    echo '<option value="'.ucfirst($row->venue).'">'.ucfirst($row->venue).'</option>';
                }
            }
            ?>
        </select>
        <select name="cmae_sel_area" id="cmae_sel_area" disabled>
            <option value="0">Select Area ...</option>
        </select>
        <textarea name="cmuae_street" id="cmuae_street" cols="30" rows="3"></textarea>
        <input type="text" name="cmae_date" id="cmae_date" placeholder="Start date">
        <input type="text" class="txtboxToFilter text-right" name="cmae_duration" id="cmae_duration" placeholder="Duration">
        <input type="text" name="cmae_rate" id="cmae_rate" class="twidth text-right" placeholder="0" readonly>
        <input type="text" class="text-right" name="cmae_esp" id="cmae_esp" readonly>
        <a href="#" id="btn_edit_cmae" class="button medium right">Update</a>
    </form>

    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<hr>

<h4>Animation Details</h4>

<div class="column large-4 medium-4 small-12">
    <input id="search_animation" type="text" placeholder="Search">
</div>
<div class="column large-offset-4 large-4 medium-offset-4 medium-4 small-12">
    <button class="small right" data-reveal-id="detailsModal" <?=$str_display?>><i class="fi-plus small"></i> Add a detail</button>
</div>

<div id="detailsModal" class="reveal-modal medium" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle" class="text-center">Add a detail</h2>

    <div id="alert_box_details" data-alert class="alert-box alert radius hide-normal">
        Special characters are not allowed
        <a href="#" class="close">&times;</a>
    </div>

    <form id="detail_form" action="" method="post">
        <input type="hidden" name="eda_joid" value="<?= $this->input->get('a') ?>">
        <table class="twidth">
            <tr>
                <td colspan="3"><input id="eda_particulars" name="eda_particulars" type="text" placeholder="Particulars" <?=$str_disa?>></td>
            </tr>
            <tr>
                <td colspan="3"><input id="eda_activity" name="eda_activity" type="text" placeholder="Target Activity" <?=$str_disa?>></td>
            </tr>
            <tr>
                <td colspan="3"><input id="eda_sched" name="eda_sched" type="text" placeholder="Target Schedule" <?=$str_disa?>></td>
            </tr>
            <tr>
                <td class="text-center" colspan="3">Target Hits</td>
            </tr>
            <tr>
                <td><input id="eda_sell" name="eda_sell" type="text" placeholder="Selling" <?=$str_disa?>></td>
                <td><input id="eda_fly" name="eda_fly" type="text" placeholder="Flyering" <?=$str_disa?>></td>
                <td><input id="eda_survey" name="eda_survey" type="text" placeholder="Survey" <?=$str_disa?>></td>
            </tr>
            <tr>
                <td><input id="eda_experiment" name="eda_experiment" type="text" placeholder="Experiment" <?=$str_disa?>></td>
                <td><input id="eda_other" name="eda_other" type="text" placeholder="other" <?=$str_disa?>></td>
                <td> </td>
            </tr>
            <tr>
                <td><input id="datepicker_details" name="eda_datepicker" type="text" placeholder="Target Date" <?=$str_disa?>></td>
                <td><input id="eda_duration" name="eda_duration" type="text" placeholder="Duration" <?=$str_disa?>></td>
                <td> </td>
            </tr>
            <tr>
                <td rowspan="3" colspan="3">
                    <textarea name="editor_detail" id="editor_detail" rows="10" cols="30" <?=$str_disa?>></textarea>
                </td>
            </tr>
        </table>

        <button id="btn_add_detail" type="submit" class="button medium right" <?=$str_display?>><i class="fi-save medium"></i> Add</button>
    </form>

    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<table id="tbl_animation" class="twidth">
    <thead>
        <tr>
            <th>Particulars</th>
            <th>Target Activity</th>
            <th colspan="5" class="text-center">Target Hits</th>
            <th>Target Duration</th>
            <th>Areas</th>
        </tr>

        <tr>
            <th colspan="2"> </th>
            <th>Selling</th>
            <th>Flyering</th>
            <th>Survey</th>
            <th>Experiment</th>
            <th>Other</th>
            <th colspan="3"> </th>
        </tr>
    </thead>
    <tbody id="tbody_animation">

        <?php
            if( isset($eda_table) ){
                echo $eda_table;
            }else{
                echo '
                    <tr>
                        <td rowspan="10" style="text-align: center"> No details saved</td>
                    </tr>
                ';
            }
        ?>
    </tbody>
</table>

<hr>

<h4>Requirements</h4>

<div class="column large-4 medium-4 small-12">
    <input id="search_requirements" type="text" placeholder="Search">
</div>
<div class="column large-offset-4 large-4 medium-offset-4 medium-4 small-12">
    <button class="small right" data-reveal-id="requModal" <?=$str_display?>><i class="fi-plus small"></i> Add Requirements</button>
</div>

<div id="requModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle" class="text-center">Add requirement</h2>

    <div id="alert_box_requ" data-alert class="alert-box alert radius hide-normal">
        Special characters are not allowed
        <a href="#" class="close">&times;</a>
    </div>

    <form id="requ_form" action="" method="post">
        <input type="hidden" name="rq_joid" value="<?= $this->input->get('a') ?>">
        <div class="row">
            <select name="rq_dept" id="sel_dept_ad">
                <option value="0">Department</option>
                <?php
                    foreach( $departments as $dept ){
                        echo '<option value="' . $dept['department_name'] . '">'. ucfirst($dept['department_name']) .'</option>';
                    }
                ?>
            </select>
        </div>

        <div class="row">
            <textarea name="editor_req" id="editor_req" cols="30" rows="10" placeholder="Deliverables"></textarea>
        </div>
        <div class="row">
            <br>
            <input type="text" name="rq_deadline" id="datepicker_deadline" placeholder="Deadline">
        </div>
        <div class="row">
            <textarea name="editor_ns" id="editor_ns" cols="30" rows="10" placeholder="Next Steps"></textarea>
        </div>

        <button id="btn_add_requ" type="submit" class="button medium right"><i class="fi-save medium"></i> Add</button>
    </form>
    <br>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="requModal_u" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle" class="text-center">Add requirement</h2>

    <div id="alert_box_requ_u" data-alert class="alert-box alert radius hide-normal">
        Special characters are not allowed
        <a href="#" class="close">&times;</a>
    </div>

    <form id="requ_form_u" action="" method="post">
        <input type="hidden" name="rq_joid_u" id="rq_joid_u">
        <div class="row">
            <select name="rq_dept_u" id="sel_dept_ad_u">
                <option value="0">Department</option>
                <?php
                    foreach( $departments as $dept ){
                        echo '<option value="' . $dept['department_name'] . '">'. ucfirst($dept['department_name']) .'</option>';
                    }
                ?>
            </select>
        </div>

        <div class="row">
            <textarea name="editor_req_u" id="editor_req_u" cols="30" rows="10" placeholder="Deliverables"></textarea>
        </div>
        <div class="row">
            <br>
            <input type="text" name="rq_deadline_u" id="datepicker_deadline_u" placeholder="Deadline">
        </div>
        <div class="row">
            <textarea name="editor_ns_u" id="editor_ns_u" cols="30" rows="10" placeholder="Next Steps"></textarea>
        </div>

        <button id="btn_add_requ_u" type="submit" class="button medium right"><i class="fi-save medium"></i> Update</button>
    </form>
    <br>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<table id="tbl_req" class="twidth">
    <thead>
        <tr>
            <th>Department - Handler</th>
            <th>Deliverables</th>
            <th>Deadline</th>
            <th>Next Steps</th>
        </tr>
    </thead>
    <tbody id="tbody_req">
        <?php
        if( isset($req_table) ){
            echo $req_table;
        }else{
            echo '
                        <tr>
                            <td rowspan="4" style="text-align: center"> No details saved</td>
                        </tr>
                    ';
        }
        ?>
    </tbody>
</table>