<?php
$edcarray = array();
$edcarray = json_decode($result_ed);
$info = json_decode($jo_details);
?>
<div style="background-color: rgba(255,0,0,0);font-size:12px;font-family:'monospace';">
    <img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
    <hr>
    <h2 style="text-decoration:underline;">Event Details</h2>
    <hr>
    <table style="width: 100%;">
        <tr>
            <td>Job order number : <span style="color:#2a92db;"><?= $info->jo_number ?></span></td>
        </tr>
        <tr>
            <td><?= $info->date_created ?></td>
        </tr>
        <tr>
            <td>Contract No.</td>
        </tr>
        <tr>
            <td><?= $info->contract_no ?></td>
        </tr>
        <tr>
            <td>Client : <span style="color:#2a92db;"><?= $info->client_company_name ?></span></td>
        </tr>
        <tr>
            <td>Product : <span style="color:#2a92db;"><?= $info->brand ?></span></td>
        </tr>
        <tr>
            <td>Project : <span style="color:#2a92db;"><?= $info->project_name ?></span></td>
        </tr>
        <tr>
            <td>Account Handler : <span style="color:#2a92db;"><?= $info->emp_info[0]->sur_name.', '.$info->emp_info[0]->first_name.' '.$info->emp_info[0]->middle_name ?></span></td>
        </tr>
    </table>

    <hr>
    <table style="width: 100%;">
        <tr>
            <td colspan="2">What :  <span style="color:#2a92db;"><?=isset($edcarray->wt) ? ucfirst($edcarray->wt) : '';?></span></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($edcarray->wtad) ? ucfirst($edcarray->wtad) : '';?></span></td>
        </tr>
        <tr style="display: none;">
            <td colspan="2">When :  <span style="color:#2a92db;"><?=isset($edcarray->wn) ? ucfirst($edcarray->wn) : '';?></span></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($edcarray->wnad) ? ucfirst($edcarray->wnad) : '';?></span></td>
        </tr>
        <tr style="display: none;">
            <td colspan="2">Where :  <span style="color:#2a92db;"><?=isset($edcarray->we) ? ucfirst($edcarray->we) : '';?></span></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($edcarray->weadd) ? ucfirst($edcarray->weadd) : '';?></span></td>
        </tr>
        <tr>
            <td colspan="4">Expected Guests :  <span style="color:#2a92db;"><?=isset($edcarray->expected) ? $edcarray->expected : '';?></span></td>
        </tr>
        <tr>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td colspan="4"><h3>Event specification</h3></td>
        </tr>
        <tr>
            <td colspan="4"><?=isset($edcarray->espec) ? $edcarray->espec : '';?></td>
        </tr>
    </table>
    <hr>
    <h2>Venue(s)</h2>
    <table style="width:100%;" border="1">
        <thead>
        <tr>
            <th width="2">Venue</th>
            <th width="3">Area</th>
            <th width="3">Address</th>
            <th width="1">Start date</th>
            <th width="1">Duration</th>
            <th width="1">Rate</th>
            <th width="1">Total</th>
        </tr>
        </thead>
        <tbody id="cmae_tbody">
        <?php
        $query = $this->db->order_by('cmae_id', 'DESC')->get_where( 'cmtuva_ae_list', array('jo_id'=>$info->jo_id) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $arr_cmae = explode(",",$row->area);
                if( ( $this->session->userdata('sess_dept') <= 2 ) && ( $this->session->userdata('sess_id') == $did ) || ( $this->session->userdata('sess_dept') == 6 ) ) {
                    echo '
                        <tr id="cmae_'.$row->cmae_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $arr_cmae[0] ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>'.$row->date_start.'</td>
                        <td>'.$row->duration.' day(s)</td>
                        <td>Php '.$row->rate.'</td>
                        <td>Php '.$row->total_rate.'</td>
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

    <hr>

    <h2>Animation Details</h2>
    <table style="width:100%;" border="1">
        <thead>
        <tr>
            <th>Particulars</th>
            <th>Target Activity</th>
            <th colspan="5" style="text-align: center;">Target Schedule</th>
            <th>Target Schedule</th>
            <th>Target Duration</th>
        </tr>

        <tr>
            <th colspan="2"> </th>
            <th>Selling</th>
            <th>Flyering</th>
            <th>Survey</th>
            <th>Experiment</th>
            <th>Other</th>
            <th colspan="2"> </th>
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
    <br>
    <hr>

    <h2>Requirements</h2>
    <table style="width: 100%;" border="1">
        <thead>
        <tr>
            <th width="50">Department - Handler</th>
            <th width="100">Deliverables</th>
            <th width="50">Deadline</th>
            <th width="100">Next Steps</th>
        </tr>
        </thead>
        <tbody>
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
</div>
