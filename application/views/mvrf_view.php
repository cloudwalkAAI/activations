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

<div id="alert_box_mvfr" data-alert class="alert-box alert radius hide-normal">
    Special characters are not allowed
    <a href="#" class="close">&times;</a>
</div>
<form id="mvrf_form" action="" method="post">
    <input type="hidden" name="mvrfid" value="<?=$this->input->get('a')?>">
    <textarea name="ta_mvrf" id="ta_mvrf" cols="30" rows="10" <?=$str_disa?>><?=isset($mv->content) ? $mv->content : '';?></textarea>
    <button id="btn_mvrf_submit" type="button" <?=$str_display?>>Save</button>
</form>