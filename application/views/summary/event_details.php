<?php
//    print_r($ed_details);
$info = json_decode($jo_details);
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

    <table class="twidth">
        <tr>
            <td>What</td>
            <td>
                <?=isset($edcarray->wt) ? $edcarray->wt : '';?>
                <br>
                Additional Notes:
                <br>
                <?=isset($edcarray->wtad) ? $edcarray->wtad : '';?>
            </td>
        </tr>
        <tr class="hide-normal">
            <td>When</td>
            <td>
                <?=isset($edcarray->wn) ? $edcarray->wn : '';?>
                <br>
                Additional Notes:
                <br>
                <?=isset($edcarray->wnad) ? $edcarray->wnad : '';?>
            </td>
        </tr>
        <tr class="hide-normal">
            <td>Where</td>
            <td>
                <?=isset($edcarray->we) ? $edcarray->we : '';?>
                <br>
                Additional Notes:
                <br>
                <?=isset($edcarray->weadd) ? $edcarray->weadd : '';?>
            </td>
        </tr>
        <tr>
            <td>Expected Guests</td>
            <td>
                <?=isset($edcarray->expected) ? $edcarray->expected : '';?>
            </td>
        </tr>
    </table>

    <hr>

    <h4>Event specification</h4>
    <?=isset($edcarray->espec) ? $edcarray->espec : '';?>
<hr>
<h4>Venue(s)</h4>
<div class="column large-12 medium-12 small-12 scrollable_area">
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
            <th width="1">Image</th>
            <th> </th>
        </tr>
        </thead>
        <tbody id="cmae_tbody">
        <?php
        $query = $this->db->order_by('cmae_id', 'DESC')->get_where( 'cmtuva_ae_list', array('jo_id'=>$this->input->get('a')) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $arr_cmae = explode(",",$row->area);
                if( ( $this->session->userdata('sess_dept') <= 2 ) && ( $this->session->userdata('sess_id') == $did ) || ( $this->session->userdata('sess_dept') == 6 ) ) {
                    $query_img = $this->db->get_where( 'cmtuva_location_list', array('location_id'=>$row->loc_id) );
                    $row_img = $query_img->row();
                    $preview = '';
                    if( !empty($row_img->images) ){
                        $preview = '<a href="'.base_url($row_img->images).'" target="_blank">Preview</a>';
                    }
                    echo '
                    <tr id="cmae_'.$row->cmae_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $arr_cmae[0] ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>'.$row->date_start.'</td>
                        <td>'.$row->duration.' day(s)</td>
                        <td>Php '.$row->rate.'</td>
                        <td>Php '.$row->total_rate.'</td>
                        <td>'.$preview.'</td>
                    </tr>
                    ';
                }else{
                    echo '
                    <tr id="cmae_'.$row->cmae_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $row->area ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>'.$row->date_start.'</td>
                        <td>'.$row->duration.' day(s)</td>
                        <td>Php '.$row->rate.'</td>
                        <td>Php '.$row->total_rate.'</td>
                    </tr>
                ';
                }
            }
        }
        ?>
        </tbody>
    </table>
</div>

<hr>

<div class="column large-12 medium-12 small-12">
    <input type="search" class="radius tbl_bdr" name="search_deduct_items" id="search_deduct_items" placeholder="Search">
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
    $this->db->where('jo_id',$info->jo_number);
    $this->db->order_by("trans_id","DESC");
    $res = $this->db->get();

    foreach ( $res->result() as $row ){
        echo '
        <tr id="trans'.$row->trans_id.'">
            <td>'.$row->item_name.'</td>
            <td>'.$row->jo_id.'</td>
            <td>'.$row->received_by.'</td>
            <td>'.$row->sub_description.'</td>
            <td>'.$row->item_qty.'</td>
            <td>'.$row->deducted_by.'</td>
            <td>'.$row->transaction_date.'</td>
        </tr>
        ';
    }
    ?>
    </tbody>
</table>

<hr>

<h4>Animation Details</h4>

<div class="column large-4 medium-4 small-12">
    <input id="search_animation" type="text" placeholder="Search">
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